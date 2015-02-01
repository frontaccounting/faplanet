<?php

$menu = NULL;

function load_menu($menu_name = 'default') {
  global $menu;

  $menu = new stdClass();
  $menu->root = array(); // root page ids
  $menu->items = array(); // page data by ids
  $menu->links = array(); // page ids by links
  $menu->current = ''; // page id of the current page
  $menu->context = array(); // sibling menu of current page

	$sql = "SELECT * FROM ".TB_PREF."menu WHERE menu=".db_escape($menu_name);
	$result = db_query($sql, "Cannot load menu from the database.");

  while ($line = db_fetch($result)) {
    $id = $line['id'];
    $parent = $line['parent'];

    if (!empty($parent)) {
      if (!array_key_exists($parent, $menu->items)) {
        user_error("Menu item $parent was not declared.", E_USER_ERROR);
        continue;
      }

      $menu->items[$parent]->weights[$id] = $line['weight'];
    }
    else
      $menu->root[] = $id;

    $menu->items[$id] = new stdClass;
    $menu->items[$id]->data = $line;
    $menu->items[$id]->parent = $parent;
    $menu->items[$id]->weights = array();

    $p = parse_url($line['link'], PHP_URL_PATH);  
    $menu->links[$p] = $id;
  }

  foreach ($menu->items as &$item) {
    //asort($item->weights, SORT_NUMERIC);
    $item->children = array_keys($item->weights);
  }

  $exclude = array();

  // Hide dimension
  $dim = get_company_pref('use_dimension');
  if ($dim == 0)
    $exclude[] = 'dimensions';

  if (@$hide_manufacturing)
    $exclude[] = 'manufacturing';

  // TODO: implement
  /*
  foreach ($exclude as $ex) {
    $key = array_search($ex, $menu->items);
    if ($key !== FALSE) {
      unset($menu->root[$key]);
    }
  }
  */

  // unset dashboard
  unset($menu->root[0]);
}

function load_page_id() {

  global $menu, $path_to_root, $page_id;

  if ($menu == NULL)
    // we are in installer
    return;

  if (empty($page_id)) {

    // Use heuristic to guess current page

    $base_path = realpath($path_to_root.'/index.php');
    $len = strlen($base_path) - strlen('index.php');

    $script_filename = realpath($_SERVER['SCRIPT_FILENAME']);
    $script_path = substr($script_filename, $len);

    if (isset($menu->links[$script_path]))
      $page_id = $menu->links[$script_path];
  }

  if (!empty($page_id)) {
    if (array_key_exists($page_id, $menu->items)) {
      $parent = $menu->items[$page_id]->parent;
      $menu->context = $menu->items[$parent]->children;
      $menu->current = $page_id;
    }
  }

}

?>
