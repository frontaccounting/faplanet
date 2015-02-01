<?php
// ----------------------------------------------------------------
// $ Revision:  1.0 $
// Creator: Alastair Robertson
// date_:   2013-01-30
// Title:   UI functions for dashboard
// Free software under GNU GPL
// ----------------------------------------------------------------

include_once($path_to_root . "/reporting/includes/class.graphic.inc");

function widget_list_row($widgets, $label, $name, $selected_id=null, $submit_on_change=false)
{
    echo "<tr><td class='label'>$label</td><td>";
    echo array_selector($name, $selected_id, $widgets,
        array(
            'select_submit'=> $submit_on_change
        ) );
    echo "</td></tr>\n";
}

function select_row($label, $name, $selected_id=null, $items, $options)
{
    // add missing function for generic selector row
    echo "<tr><td class='label'>$label</td><td>";
    echo array_selector($name, $selected_id, $items, $options);
    echo "</td></tr>\n";
}

function text_input($label, $name, $value=null, $size="", $max="", $title=false,
    $labparams="", $post_label="", $inparams="")
{
    global $Ajax;

    default_focus($name);
    if ($label != null)
        label_cell($label, $labparams);

    if ($value === null)
        $value = get_post($name);
    echo "<input $inparams type=\"text\" name=\"$name\" size=\"$size\" maxlength=\"$max\" value=\"$value\""
        .($title ? " title='$title'" : '')
        .">";

    if ($post_label != "")
        echo " " . $post_label;

    $Ajax->addUpdate($name, $name, $value);
}

function start_cell()
{
    echo "<td>";
}

function end_cell()
{
    echo "</td>";
}

function render_graphic_widget($graph_type, $id, $title, $data)
{
		global $path_to_root, $Ajax, $graph_skin;

		$gtypes = array(
            'Table' => 0,
            'LineChart' => 4,
            'ColumnChart' => 1,
            'PieChart' => 5,
        );
		$type = $gtypes[$graph_type];
    $type = 'PieChart';

		if (!$type)
		{
			foreach ($data['cols'] as $col)
				$th[] = $col['label'];

			start_table(TABLESTYLE);
			table_header($th);
			$k=0;
			foreach($data['rows'] as $d)
			{
				alt_table_row_color($k);
				foreach($d['c'] as $n => $cell)
					{ label_cell($cell['f'], $data['cols'][$n]['type']=='number' ? "align='right'":'');}
				end_row();
			}
			end_table();
			return;
		}

        echo '<canvas id="myChart-'.$id.'" width="300" height="300"></canvas>
        <script>

            //var ctx = document.getElementById("myChart-'.$id.'").getContext("2d");
            var ctx = $("#myChart").get(0).getContext("2d");
            // For a pie chart
            ';

echo ' var data = [ ';

    $i = 0;
		foreach($data['rows'] as $i => $d)
		{
			/*foreach($d['c'] as $j => $row)
				if (!$j)
					$pg->x[$i] = $row['f'];
				else
					$pg->y[$j-1][$i] = $row['v'];
          */
			foreach($d['c'] as $j => $row)
				if (!$j)
					$pg->x[$i] = $row['f'];
				else
					$pg->y[$j-1][$i] = $row['v'];
		}

          /*$i = 0;

            while ($myrow = db_fetch($result))
            {
                if ($myrow['ctype'] > 3)
                {
                    $total += $myrow['total'];
                    $myrow['total'] = -$myrow['total'];
                    //$pg->x[$i] = $myrow['class_name'];
                    //$pg->y[$i] = abs($myrow['total']);
                    if ($i > 0)
                      echo ',';
                    $i++;
                    $myrow['total'] = (int) $myrow['total'];
                    if ($myrow['total'] <0)
                      $myrow['total'] = -$myrow['total'];
                    echo '{ value: '.$myrow['total'];
                    echo ', label: "'.$myrow['class_name'].'"';
                    echo ', color: "#444444", highlight: "#744477"}';
                }
            }*/
              echo '];';


echo '
            var moduleDoughnut = new Chart(ctx).Pie(data,{ animation:false});
              </script>';



		$pg = new graph();
//		$pg->title     = $title; // redundant here
		$pg->skin      = $graph_skin;
		$pg->type      = $type;

		// legend
		foreach($data['cols'] as $i => $col)
			if (!$i)
				; // $pg->axis_x = $col['label'];
			else
				$pg->graphic[$i-1] = $col['label'];

		foreach($data['rows'] as $i => $d)
		{
			foreach($d['c'] as $j => $row)
				if (!$j)
					$pg->x[$i] = $row['f'];
				else
					$pg->y[$j-1][$i] = $row['v'];
		}

}

