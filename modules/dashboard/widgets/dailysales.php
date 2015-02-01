<?php
/**********************************************************************
// Creator: Alastair Robertson
// date_:   2013-01-30
// Title:   Daily Sales widget for dashboard
// Free software under GNU GPL
***********************************************************************/

global $path_to_root;
include_once($path_to_root . "/includes/ui.inc");
include_once($path_to_root . "/modules/dashboard/includes/dashboard_ui.inc");

class dailysales
{
    var $page_security = 'SA_CUSTPAYMREP';

    var $top;
    var $graph_type;
    var $data_filter;

    function dailysales($params='')
    {
        if (isset($params))
        {
            $data=json_decode(html_entity_decode($params, ENT_QUOTES));
            if ($data != null) {
                if ($data->top != '')
                    $this->top = $data->top;
                $this->graph_type = $data->graph_type;
//                if ($data->data_filter != '')
//                    $this->data_filter = $data->data_filter;
            }
        }
    }

    function render($id, $title)
    {
		set_ext_domain('modules/dashboard');
        $sql = 'SELECT * FROM (SELECT week `Week End`, weekofyear(week) week,'
            .'concat(cast(case when weekofyear(trans_date) = 1 and month(trans_date)=12 then year(trans_date) + 1 else year(trans_date) end as char),cast(weekofyear(trans_date) as char)) `Week No`, '
            .'sum(case when weekday(trans_date)=0 then gross_output else 0 end) Monday, '
            .'sum(case when weekday(trans_date)=1 then gross_output else 0 end) Tuesday, '
            .'sum(case when weekday(trans_date)=2 then gross_output else 0 end) Wednesday, '
            .'sum(case when weekday(trans_date)=3 then gross_output else 0 end) Thursday, '
            .'sum(case when weekday(trans_date)=4 then gross_output else 0 end) Friday, '
            .'sum(case when weekday(trans_date)=5 then gross_output else 0 end) Saturday, '
            .'sum(case when weekday(trans_date)=6 then gross_output else 0 end) Sunday '
            .'FROM (SELECT dt.tran_date trans_date, date_add(tran_date, INTERVAL 6-weekday(tran_date) DAY) week,'
				.'sum(if(dt.type='.ST_CUSTCREDIT.', -1, 1)*(ov_amount+ov_freight+ov_discount+ov_gst)*rate) gross_output '
	            .'FROM '.TB_PREF.'debtor_trans dt  '
    	        .'WHERE `type` IN('.ST_SALESINVOICE.','.ST_CUSTCREDIT.') ';
	    	    if (isset($this->top))
    	    	    $sql .='AND tran_date>date_add(now(), INTERVAL -7*'.($this->top-1).' DAY) ';
//        if ($this->data_filter != '')
//            $sql .= ' WHERE '.$this->data_filter;

        $sql .= ' GROUP BY dt.tran_date  '
            .') days '
            .'GROUP BY concat(cast(case when weekofyear(trans_date) = 1 and month(trans_date)=12 then year(trans_date) + 1 else year(trans_date) end as char),cast(weekofyear(trans_date) as char)) '
            .'ORDER BY max(trans_date) desc ';
        if (isset($this->top))
            $sql .= ' limit '.$this->top;
        $sql .= ") weeks ORDER BY `Week End`";
//_vd(strtr($sql, array(','=>",\n", '&TB_PREF&'=>'1_')));
        $result = db_query($sql) or die(_('Error getting daily sales data'));

		$zero = number_format2(0, user_price_dec());
		// complete week data
		for ($n=$this->top-1; $n >= 0; $n--)
		{
			$end_date = add_days(Today(), -7*$n);
			$woy = weekofyear($end_date);
            $temp[0] = array('v' => 0.0, 'f' =>  _('Week').' '.$woy);//sql2date($r['Week End']));
            $temp[1] = array('v' => 0.0, 'f' => $zero);
            $temp[2] = array('v' => 0.0, 'f' => $zero);
            $temp[3] = array('v' => 0.0, 'f' => $zero);
            $temp[4] = array('v' => 0.0, 'f' => $zero);
            $temp[5] = array('v' => 0.0, 'f' => $zero);
            $temp[6] = array('v' => 0.0, 'f' => $zero);
            $temp[7] = array('v' => 0.0, 'f' => $zero);
            $weeks[$woy] = array('c' => $temp);
		}

        //flag is not needed
        $flag = true;
        $table = array();
        $table['cols'] = array(
            array('label' => _('Week End'), 'type' => 'string'),
            array('label' => _('Monday'), 'type' => 'number'),
            array('label' => _('Tuesday'), 'type' => 'number'),
            array('label' => _('Wednesday'), 'type' => 'number'),
            array('label' => _('Thursday'), 'type' => 'number'),
            array('label' => _('Friday'), 'type' => 'number'),
            array('label' => _('Saturday'), 'type' => 'number'),
            array('label' => _('Sunday'), 'type' => 'number')
        );

        $rows = array();
        while($r = db_fetch_assoc($result)) {
            $temp = array();
            $temp[] = array('v' => (string) $r['Week End'], 'f' =>  _('Week').' '.$r['week']);//sql2date($r['Week End']));
            $temp[] = array('v' => (float) $r['Monday'], 'f' => number_format2($r['Monday'], user_price_dec()));
            $temp[] = array('v' => (float) $r['Tuesday'], 'f' => number_format2($r['Tuesday'], user_price_dec()));
            $temp[] = array('v' => (float) $r['Wednesday'], 'f' => number_format2($r['Wednesday'], user_price_dec()));
            $temp[] = array('v' => (float) $r['Thursday'], 'f' => number_format2($r['Thursday'], user_price_dec()));
            $temp[] = array('v' => (float) $r['Friday'], 'f' => number_format2($r['Friday'], user_price_dec()));
            $temp[] = array('v' => (float) $r['Saturday'], 'f' => number_format2($r['Saturday'], user_price_dec()));
            $temp[] = array('v' => (float) $r['Sunday'], 'f' => number_format2($r['Sunday'], user_price_dec()));
            $weeks[$r['week']] = array('c' => $temp);
        }

        $table['rows'] = array_values($weeks);
		render_graphic_widget($this->graph_type, $id, $title, $table);
		set_ext_domain();
    }

    function edit_param()
    {
        global $top, $sequences, $asc_desc;

        $graph_types = array(
            'LineChart' => _("Line Chart"),
            'ColumnChart' => _("Column Chart"),
            'Table' => _("Table")
        );
        $_POST['top'] = $this->top;
        $_POST['graph_type'] = $this->graph_type;
//        $_POST['data_filter'] = $this->data_filter;
        text_row_ex(_("Number of weeks:"), 'top', 2);
//        text_row_ex(_("Filter:"), 'data_filter', 50);
        select_row(_("Graph Type:"), "graph_type", null, $graph_types, null);
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
		global 	$Ajax;

        $param = array('top' => $_POST['top'],
//                        'data_filter' => $_POST['data_filter'],
                        'graph_type' => $_POST['graph_type']);
        return $Ajax->php2js($param);
    }

}
