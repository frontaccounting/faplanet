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

include_once($path_to_root . "/includes/ui/ui_controls.inc");

include_once($path_to_root . "/includes/date_functions.inc");
include_once($path_to_root . "/manufacturing/includes/manufacturing_ui.inc");
$js = "";
if ($use_popup_windows)
	$js .= get_js_open_window(800, 500);

$page_id = 'customer_inquiry';
page(_($help_context = "Customers"), false, false, "", $js);

//-----------------------------------------------------------------------------------
// Ajax updates
//

//--------------------------------------------------------------------------------------

//-----------------------------------------------------------------------------
$sql = "SELECT debtor_no, name, debtor_ref, curr_code, credit_status FROM ".TB_PREF."debtors_master ";

$res = db_query($sql);

$data = array();

while ($line = db_fetch_assoc($res)) {
  $markup = '<a class="btn btn-default btn-sm" style="margin-left:6px" href="'.$path_to_root.'/sales/manage/customers.php?debtor_no='.$line['debtor_no'].'"><span class="glyphicon glyphicon-pencil"></span></a>';

  $line[] = array('option' => true, 'markup' => $markup, 'align' => 'right');
  $data[] = $line;
}

$headers = array('ID', 'Customer Name', 'Short Name', 'Currency', 'Credit Status', '');
//$headers = array('ID', 'Customer Name', 'Short Name', 'Currency', 'Credit Status');

//var_dump ($data);

function render_dynamic_table ($data, $headers, $options = array()) {

  echo '<table class="dynamic-table table table-striped table-condensed" id="pager">';
  echo '<thead><tr>';
  foreach ($headers as $cell) {
    echo '<th>'.$cell.'</th>';
  }
  echo '</tr></thead>';
  echo '<tbody>';
  foreach ($data as $row) {
    echo '<tr>';
    foreach ($row as $cell) {
      if (is_array($cell)) {
        echo '<td class="align-right">';
        echo $cell['markup'];
        echo '</td>';
      }
      else
        echo "<td>$cell</td>";
    }
    echo '</tr>';
  }
  echo '</tbody>';

  echo '</table>';
}

render_dynamic_table ($data, $headers);

end_page();
?>

