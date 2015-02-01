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

$page_security = 'SA_OPEN';
$path_to_root="..";
include($path_to_root . "/includes/session.inc");
include($path_to_root . "/modules/dashboard/dashboard.php");

page(_($help_context = "Welcome"));


  $dashboard_app = new dashboard_app();

  echo '<div class="row">';

  $widgets = array( 'bankbalances', 'customers', 'glreturn','salesinvoices', 'weeklysales',  'dailybankbalances');

  $rows = array(4,6);
  $i = 0;
  for ($j=0; $j < 2; $j++) {
      echo '<div class="col-md-6">';
      //echo '<div class="row">';
      $h = 3;
      $f = 5;
  for(; $i <$rows[$j]; $i++)
  {
    echo '<div class="widget ">';
    $item = array('widget' => $widgets[$i], 'column_id' => $i);
    $widgetData = $dashboard_app->get_widget($item['widget']);
    echo '
      <p class="widget-title">'._($widgetData->title).'</p>
      <div id="widget_div_'.$item['column_id'].'" class="dragbox-content" ';
    echo '>';

    if ($widgetData != null) {
      include_once ($path_to_root . $widgetData->path);
      $className = $widgetData->name;
      $widgetObject = new $className();
      $widgetObject->render($item['column_id'],$item['widget']);
    }
echo '</div>';
echo '</div>';
  }
//echo '</div>';
echo '</div>';
}
echo '</div>';

end_page();
?>


