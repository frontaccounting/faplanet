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

$page_security = 'SA_ITEM';
$path_to_root = "../..";

include_once($path_to_root . "/includes/session.inc");

include_once($path_to_root . "/includes/ui/ui_table.inc");

$js = "";
if ($use_popup_windows)
	$js .= get_js_open_window(800, 500);

page(_($help_context = "Items"), false, false, "", $js);

//-----------------------------------------------------------------------------

function format_row(&$row) {
  global $path_to_root, $stock_types;

  $row['inactive'] = $row['inactive'] ? 'Inactive' : 'Active';
  $row['mb_flag'] = $stock_types[$row['mb_flag']];

  $row['description'] = '<a href="'.$path_to_root.'/inventory/manage/items.php?stock_id='.$row['stock_id'].'">'.$row['description'].'</a>'; 

  //$row[] = '<a class="btn btn-default btn-sm" style="margin-left:6px" href="'.$path_to_root.'/inventory/manage/items.php?stock_id='.$row['stock_id'].'"><span class="glyphicon glyphicon-pencil"></span></a>'; 
}

//-----------------------------------------------------------------------------

$sql = "SELECT s.stock_id, s.description, c.description as category, s.mb_flag, s.inactive
			FROM ".TB_PREF."stock_master s,".TB_PREF."stock_category c WHERE s.category_id=c.category_id";

$data = array('resource' => db_query($sql), 'callback' => 'format_row');

$headers = array('Code', 'Name', 'Category', 'Type', 'Status');

//echo '<a class="btn btn-success" style="margin-left:6px" href="'.$path_to_root.'/inventory/manage/items.php?"><span class="glyphicon glyphicon-plus"></span> Add Item</a>';

render_table ($data, $headers);

end_page();
?>

