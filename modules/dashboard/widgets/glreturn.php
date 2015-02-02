<?php
/**********************************************************************
// Creator: Alastair Robertson
// date_:   2013-01-30
// Title:   GL classes balances widget for dashboard
// Free software under GNU GPL
***********************************************************************/

global $path_to_root;
include_once($path_to_root . "/includes/ui.inc");
include_once($path_to_root . "/modules/dashboard/includes/dashboard_ui.inc");

class glreturn
{
    var $page_security = 'SA_GLANALYTIC';

    var $graph_type;
    var $data_filter;

    function glreturn($params='')
    {
//       $this->graph_type = 'Plot';
       $this->graph_type = 'Table';
        if (isset($params))
        {
            $data=json_decode(html_entity_decode($params, ENT_QUOTES));
            if ($data != null) {
                $this->graph_type = $data->graph_type;
//                if ($data->data_filter != '')
//                    $this->data_filter = $data->data_filter;
            }
        }
    }

    function render($id, $title)
    {
        global $path_to_root;
        include_once($path_to_root."/reporting/includes/class.graphic.inc");

		set_ext_domain('modules/dashboard');
        $begin = begin_fiscalyear();
        $today = Today();
        $begin1 = date2sql($begin);
        $today1 = date2sql($today);
        $sql = "SELECT SUM(amount) AS total, c.class_name, c.ctype FROM
            ".TB_PREF."gl_trans,".TB_PREF."chart_master AS a, ".TB_PREF."chart_types AS t,
            ".TB_PREF."chart_class AS c WHERE
            account = a.account_code AND a.account_type = t.id AND t.class_id = c.cid
            AND IF(c.ctype > 3, tran_date >= '$begin1', tran_date >= '0000-00-00')
            AND tran_date <= '$today1' ";
//        if ($this->data_filter != '')
//            $sql .= ' AND '.$this->data_filter;
        $sql .= " GROUP BY c.cid ORDER BY c.cid";
        $result = db_query($sql, "Transactions could not be calculated");

        $calculated = _("Calculated Return");
        if ($this->graph_type=='Table') {
            start_table(TABLESTYLE, "width=98%");
            $total = 0;
            while ($myrow = db_fetch($result))
            {
                if ($myrow['ctype'] > 3)
                {
                    $total += $myrow['total'];
                    $myrow['total'] = -$myrow['total'];
                }
                label_row($myrow['class_name'], number_format2($myrow['total'], user_price_dec()),
                    "class='label' style='font-weight:bold;'", "style='font-weight:bold;' align=right");
            }
            label_row("&nbsp;", "");
            label_row($calculated, number_format2(-$total, user_price_dec()),
                "class='label' style='font-weight:bold;'", "style='font-weight:bold;' align=right");


            end_table(0);
        } else {
        /*
            $pg = new graph();

            $i = 0;
            $total = 0;
            while ($myrow = db_fetch($result))
            {
                if ($myrow['ctype'] > 3)
                {
                    $total += $myrow['total'];
                    $myrow['total'] = -$myrow['total'];
                    $pg->x[$i] = $myrow['class_name'];
                    $pg->y[$i] = abs($myrow['total']);
                    $i++;
                }
            }
            $pg->x[$i] = $calculated;
            $pg->y[$i] = -$total;
            $pg->title     = $title;
            $pg->axis_x    = _("Class");
            $pg->axis_y    = _("Amount");
            $pg->graphic_1 = $today;
            $pg->type      = 5;
            $pg->skin      = 1;
            $pg->built_in  = false;
            $filename = "/pdf_files/test.png";
            $url= "/company/".user_company().$filename;
            $pg->display(company_path().$filename, true);
            echo "<img src='$url' border='0' alt='$title' style='max-width:100%'>";*/

            $colors = array("#F7464A", "#FF5A5E","#46BFBD",  "#5AD3D1", "#FDB45C", "#FFC870");

        echo '<canvas id="myChart" width="300" height="300"></canvas>
        <script>

            //var ctx = document.getElementById("myChart").getContext("2d");
            var ctx = $("#myChart").get(0).getContext("2d");
            // For a pie chart
            ';

echo ' var data = [ ';
          $i = 0;
            while ($myrow = db_fetch($result))
            {
                if ($myrow['ctype'] > 3)
                {
                    $myrow['total'] = -$myrow['total'];
                    //$pg->x[$i] = $myrow['class_name'];
                    //$pg->y[$i] = abs($myrow['total']);
                    if ($i > 0)
                      echo ',';
                    $i++;
                    if ($myrow['total'] <0)
                      $myrow['total'] = -$myrow['total'];
                    $myrow['total'] = (int) $myrow['total'];
                    echo '{ value: '.$myrow['total'];
                    echo ', label: "'.$myrow['class_name'].'"';
                    echo ', color: "'.$colors[2*$i].'", highlight: "'.$colors[2*$i+1].'"}';
                }
            }
              echo '];';


echo '
            var moduleDoughnut = new Chart(ctx).Pie(data,{ animation:false});
              </script>';


        }
		set_ext_domain();
    }

    function edit_param()
    {
        global $top, $sequences, $asc_desc;

        $graph_types = array(
            'PieChart' => _("Pie Chart"),
            'Table' => _("Table")
        );
        $_POST['graph_type'] = $this->graph_type;
//        $_POST['data_filter'] = $this->data_filter;
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

        $param = array('graph_type' => $_POST['graph_type'],
//                        'data_filter' => $_POST['data_filter']
        );
        return $Ajax->php2js($param);
    }

}
