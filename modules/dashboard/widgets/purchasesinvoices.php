<?php
/**********************************************************************
// Creator: Alastair Robertson
// date_:   2013-01-30
// Title:   Purchases invoices widget for dashboard
// Free software under GNU GPL
***********************************************************************/

global $path_to_root;
include_once($path_to_root . "/includes/ui.inc");
include_once($path_to_root . "/modules/dashboard/includes/dashboard_ui.inc");

class purchasesinvoices
{
    var $page_security = 'SA_SUPPPAYMREP';

    var $data_filter;
    var $days_before = 0;

    function purchasesinvoices($params='')
    {
        if (isset($params))
        {
            $data=json_decode(html_entity_decode($params, ENT_QUOTES));
            if ($data != null) {
//                if ($data->data_filter != '')
//                    $this->data_filter = $data->data_filter;
                if ($data->days_before != '')
                    $this->days_before = $data->days_before;

            }
        }
    }

    function render($id, $title)
    {
        global $path_to_root;
        include_once($path_to_root."/includes/ui.inc");

		set_ext_domain('modules/dashboard');
        if (!defined('FLOAT_COMP_DELTA'))
            define('FLOAT_COMP_DELTA', 0.004);

        $today = date2sql(Today());
        $sql = "SELECT trans.trans_no, trans.reference, trans.tran_date, trans.due_date, s.supplier_id,
            s.supp_name, s.curr_code,
            (trans.ov_amount + trans.ov_gst + trans.ov_discount) AS total,
            (trans.ov_amount + trans.ov_gst + trans.ov_discount - trans.alloc) AS remainder,
            DATEDIFF('$today', trans.due_date) AS days
            FROM ".TB_PREF."supp_trans as trans, ".TB_PREF."suppliers as s
            WHERE s.supplier_id = trans.supplier_id
                AND trans.type = ".ST_SUPPINVOICE." AND (ABS(trans.ov_amount + trans.ov_gst +
                    trans.ov_discount) - trans.alloc) > ".FLOAT_COMP_DELTA."
                AND DATEDIFF('$today', trans.due_date) >= ".(int)(-$this->days_before)." ORDER BY days DESC";
//        if ($this->data_filter != '')
//            $sql .= ' AND '.$this->data_filter;

        $result = db_query($sql);
        $title = db_num_rows($result) . _(" overdue Purchase Invoices");
        br(1);
        display_heading($title);
        br();
        $th = array("#", _("Date"), _("Due Date"), _("Supplier"), _("Currency"), _("Total"),
            _("Remainder"), _("Days"));
        start_table(TABLESTYLE,"width=98%");
        table_header($th);
        $k = 0; //row colour counter
        while ($myrow = db_fetch($result))
        {
            alt_table_row_color($k);
            label_cell(get_trans_view_str(ST_SUPPINVOICE, $myrow["trans_no"]));
            label_cell(sql2date($myrow['tran_date']));
            label_cell(sql2date($myrow['due_date']));
            $name = $myrow["supplier_id"]." ".$myrow["supp_name"];
            label_cell($name);
            label_cell($myrow['curr_code']);
            amount_cell($myrow['total']);
            amount_cell($myrow['remainder']);
            label_cell($myrow['days'], "align='right'");
            end_row();
        }
        end_table(1);
		set_ext_domain();
    }

    function edit_param()
    {

//        $_POST['data_filter'] = $this->data_filter;
//        text_row_ex(_("Filter:"), 'data_filter', 50);
        $_POST['days_before'] = $this->data_filter;
        small_amount_row(_("Show invoices due in next:"), 'days_before', $this->days_before, '', _('days'), 0);
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

        $param = array(
        // 'data_filter' => $_POST['data_filter']
			'days_before' => (int)$_POST['days_before']
        );
        return $Ajax->php2js($param);
    }

}
