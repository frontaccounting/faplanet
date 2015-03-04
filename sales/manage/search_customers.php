<?php
/**********************************************************************
    Copyright (C) FrontAccounting, LLC.
	Released under the terms of the GNU General Public License, GPL, 
	as published by the Free Software Foundation, either version 3 
	of the License, or (at your option) any later version.
    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  
    See the License here <http://www.gnu.org/licenses/gpl-3.0.html>.
***********************************************************************/
$page_security = 'SA_CUSTOMER';
$path_to_root = "../..";

include($path_to_root . "/includes/db_pager.inc");
include_once($path_to_root . "/includes/session.inc");

include_once($path_to_root . "/includes/ui/ui_table.inc");

$js = "";
if ($use_popup_windows)
	$js .= get_js_open_window(800, 500);

$page_id = 'search_customers';
page(_($help_context = "Customers"), false, false, "", $js);

//-----------------------------------------------------------------------------
$sql = "SELECT debtor_no, name, debtor_ref, curr_code, inactive FROM ".TB_PREF."debtors_master ";

$res = db_query($sql);

function format_row(&$row, &$options) {
  global $path_to_root;

  $row['inactive'] = $row['inactive'] ? 'Inactive' : 'Active';

  $row['name'] = '<a href="'.$path_to_root.'/sales/manage/customers.php?debtor_no='.$row['debtor_no'].'">'.$row['name'].'</a>'; 
}

$data = array('resource' => $res, 'callback' => 'format_row');

$headers = array('ID', 'Customer Name', 'Short Name', 'Currency', 'Status');

render_pager ($data, $headers);

end_page();
?>

