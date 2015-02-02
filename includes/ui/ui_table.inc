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

function html_attrs ($attrs = array()) {
  if (!empty($attrs)) {
    return ' class="'. $attrs['class']. '"';
  }

  return '';
}

function render_pager ($data, $headers, $options = array()) {

  $cols = array();
  $output = '<table class="table table-striped table-condensed" id="table-pager">'. "\n";

  if ($headers) {
    $output .= '<thead><tr>'. "\n";

    $i = 0;
    foreach ($headers as $cell) {
      if (is_array($cell)) {
        $text = isset($cell['text']) ? $cell['text'] : '&nbsp;';
        $attrs['class'] = isset($cell['class']) ? $cell['class'] : '';
        $output .= '<th '. html_attrs($attrs). '>'.$text.'</th>'. "\n";
        $cols[$i] = array('class' => $attrs['class']);
      }
      else {
        $output .= '<th>'.$cell.'</th>'. "\n";
        $cols[$i] = array();
      }

      $i++;
    }

    $output .= '</tr></thead>'. "\n";
  }

  $num_rows = db_num_rows($data['resource']);

  if ($num_rows > 0) {
    $output .= "<tbody>\n";

    while ($row = db_fetch_assoc($data['resource'])) {

      $output .= "<tr>\n";

      $options = array();
      if (isset($data['callback']) && function_exists($data['callback']))
          $data['callback']($row, $options);

      $i = 0;
      foreach ($row as $cell) {
        $output .= '<td '. html_attrs($cols[$i]). '>'. $cell. "</th>\n";
        $i++;
      }

      $output .= "</tr>\n";
    }

    $output .= "</tbody>\n";
  }

  $output .= "</table>\n";
  
  echo $output;
}

?>
