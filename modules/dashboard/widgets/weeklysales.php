<?php
/**********************************************************************
// Creator: Alastair Robertson
// date_:   2013-01-30
// Title:   Weekly Sales widget for dashboard
// Free software under GNU GPL
***********************************************************************/

global $path_to_root;
include_once($path_to_root . "/includes/ui.inc");
include_once($path_to_root . "/modules/dashboard/includes/dashboard_ui.inc");

class weeklysales
{
    var $page_security = 'SA_CUSTPAYMREP';

    var $top;
    var $orderby;
    var $orderby_seq;
    var $data_filter;

    function weeklysales($params='')
    {
        if (isset($params))
        {
            $data=json_decode(html_entity_decode($params, ENT_QUOTES));
            if ($data != null) {
                if ($data->top != '')
                    $this->top = $data->top;
                if ($data->orderby != '')
                {
                  $this->orderby = $data->orderby;
                  if ($data->orderby_seq != '')
                      $this->orderby_seq = $data->orderby_seq;
                  else
                      $this->orderby_seq = 'ASC';
                }
                $this->graph_type = $data->graph_type;
//                if ($data->data_filter != '')
//                    $this->data_filter = $data->data_filter;
            }
        }
        $this->graph_type = "Pie";
    }

    function render($id, $title)
    {
		global $Ajax;

		set_ext_domain('modules/dashboard');
        $sql = '';

        if (isset($this->orderby))
            $sql .= 'SELECT  * FROM (';

        $sql .= 'SELECT * FROM (SELECT week `Week End`, weekofyear(week) week,'
            .'concat(cast(case when weekofyear(trans_date) = 1 and month(trans_date)=12 then year(trans_date) + 1 else year(trans_date) end as char),cast(weekofyear(trans_date) as char)) `Week No`, '
			.'sum(gross_output) gross_output '
            .'FROM (SELECT dt.tran_date trans_date, date_add(tran_date, INTERVAL 6-weekday(tran_date) DAY) week,'
				.'sum(if(dt.type='.ST_CUSTCREDIT.', -1, 1)*(ov_amount+ov_freight+ov_discount+ov_gst)*rate) gross_output '
	            .'FROM '.TB_PREF.'debtor_trans dt  '
    	        .'WHERE `type` IN('.ST_SALESINVOICE.','.ST_CUSTCREDIT.') ';
	    	    if (isset($this->top))
    	    	    $sql .='AND tran_date>date_add(now(), INTERVAL -7*'.($this->top-1).' DAY) ';
//        if ($this->data_filter != '')
//            $sql .= ' WHERE '.$this->data_filter;

        $sql .= ' GROUP BY year(tran_date), week  '
            .') weeks '
            .'GROUP BY concat(cast(case when weekofyear(trans_date) = 1 and month(trans_date)=12 then year(trans_date) + 1 else year(trans_date) end as char),cast(weekofyear(trans_date) as char)) ';
        if (isset($this->orderby))
            $sql .= ') items order by `'.$this->orderby.'` '.$this->orderby_seq;
        if (isset($this->top))
            $sql .= ' limit '.$this->top;
        $sql .= ") weeks ORDER BY `Week End`";
//_vd(strtr($sql, array(','=>",\n", '&TB_PREF&'=>'1_')));
        $result = db_query($sql) or die(_('Error getting weekly sales data'));

		$zero = number_format2(0, user_price_dec());
		// complete week data
		for ($n=$this->top-1; $n >= 0; $n--)
		{
			$end_date = add_days(Today(), -7*$n);
			$woy = weekofyear($end_date);
            $temp[0] = array('v' => $woy, 'f' => week_end($end_date));
            $temp[1] = array('v' => 0.0, 'f' => $zero);
            $weeks[$woy] = array('c' => $temp);
		}

        //flag is not needed
        $flag = true;
        $table = array();
        $table['cols'] = array(
            array('label' => _('Week End'), 'type' => 'string'),
            array('label' => _('Gross Sales'), 'type' => 'number')
        );

        $rows = array();
        while($r = db_fetch_assoc($result)) {
            $temp = array();
            // the following line will used to slice the Pie chart
            $temp[] = array('v' => (string) $r['Week End'], 'f' => sql2date($r['Week End']));
            $temp[] = array('v' => (float) $r['gross_output'], 'f' => number_format2($r['gross_output'], user_price_dec()));
            $weeks[$r['week']] = array('c' => $temp);
        }

        $table['rows'] = array_values($weeks);
		//render_graphic_widget($this->graph_type, $id, $title, $table);
		set_ext_domain();

        echo '<canvas id="myChart-'.$id.'" width="400" height="300"></canvas>
        <script>

            //var ctx = document.getElementById("myChart-'.$id.'").getContext("2d");
            var ctx = $("#myChart-'.$id.'").get(0).getContext("2d");
            // For a pie chart
            ';

        echo ' var data = { ';
        echo 'labels: [';
        foreach($weeks as $w) {
          echo '"';
          echo $w['c'][0]['v'];
          echo '"';
          echo ', ';
        }
        echo '], ';
        echo 'datasets: [{';
        echo 'label: "my first",';
        echo '
          fillColor: "rgba(151,187,205,0.2)",
          strokeColor: "rgba(151,187,205,1)",
          pointColor: "rgba(151,187,205,1)",
          pointStrokeColor: "#fff",
          pointHighlightFill: "#fff",
          pointHighlightStroke: "rgba(151,187,205,1)",
             ';
        echo 'data: [';
        foreach($weeks as $w) {
          echo $w['c'][1]['f'];
          echo ', ';
        }

        echo ']}]};';


echo '
            var Line = new Chart(ctx).Line(data,{ animation:false});
              </script>';
    }

    function edit_param()
    {
        global $top, $sequences, $asc_desc;

        $sequences = array(
            'Week End' => _("Week End Date"),
            'Gross Sales' => _("Gross Sales")
        );
        $asc_desc = array(
            'asc' => _("Ascending"),
            'desc' => _("Descending")
        );
        $graph_types = array(
            'LineChart' => _("Line Chart"),
            'ColumnChart' => _("Column Chart"),
            'Table' => _("Table")
        );
        $_POST['top'] = $this->top;
        $_POST['orderby'] = $this->orderby;
        $_POST['orderby_seq'] = $this->orderby_seq;
        $_POST['graph_type'] = $this->graph_type;
//        $_POST['data_filter'] = $this->data_filter;
        text_row_ex(_("Number of weeks:"), 'top', 2);
        select_row(_("Sequence"), "orderby", null, $sequences, null);
        select_row(_("Order"), "orderby_seq", null, $asc_desc, null);
//        text_row_ex(_("Filter:"), 'data_filter', 50);
        select_row(_("Graph Type"), "graph_type", null, $graph_types, null);
    }

    function validate_param()
    {
        $input_error = 0;
        //if (!is_numeric($_POST['top']))
        //  {
        //      $input_error = 1;
        //      display_error( _("The number of weeks must be numeric."));
        //      set_focus('top');
        //  }

        //  if ($_POST['top'] == '')
        //      $_POST['top'] = 10;

          return $input_error;
      }

    function save_param()
    {
		global $Ajax;

        $param = array('top' => $_POST['top'],
                        'orderby' => $_POST['orderby'],
                        'orderby_seq' => $_POST['orderby_seq'],
                        'graph_type' => $_POST['graph_type'],
//                        'data_filter' => $_POST['data_filter']
		);
        return $Ajax->php2js($param);
    }

}
