<?php

$menu = NULL;

function load_menu($menu_name = 'default') {
  global $menu;

  $menu = new stdClass();
  $menu->items = array(); // page data by ids
  $menu->root = array(); // root page ids
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

      if (!$line['inactive'])
        $menu->items[$parent]->weights[$id] = $line['weight'];
    }
    else {
      if (!$line['inactive'])
        $menu->root[] = $id;
    }

    $menu->items[$id] = new stdClass;
    $menu->items[$id]->data = $line;
    $menu->items[$id]->parent = $parent;
    $menu->items[$id]->weights = array();
  }

  foreach ($menu->items as &$item) {
    //asort($item->weights, SORT_NUMERIC);
    $item->children = array_keys($item->weights);
  }

  //$exclude = array('dashboard');
  $exclude = array();

  // Hide dimension
  $dim = get_company_pref('use_dimension');
  if ($dim == 0)
    $exclude[] = 'dimensions';

  if (@$hide_manufacturing)
    $exclude[] = 'manufacturing';

  foreach ($exclude as $id) {
    if (array_key_exists($id, $menu->items)) {
      $parent = $menu->items[$id]->parent;
      if (empty($parent)) {
        $key = array_search($id, $menu->root);
        unset ($menu->root[$key]);
      }
      else {
        $key = array_search($id, $menu->items[$parent]->children);
        unset($menu->items[$parent]->children[$key]);
      }
    }
  }
}

function load_page_id() {

  global $menu, $path_to_root, $page_id;

  if ($menu == NULL)
    // we are in installer
    return;

  // create link to id mapping
  $paths = array();
  foreach ($menu->items as $item) {
    $p = parse_url($item->data['link'], PHP_URL_PATH);  
    $paths[$p] = $item->data['id'];
  }

  if (empty($page_id)) {

    // Use heuristic to guess current page

    $base_path = realpath($path_to_root.'/index.php');
    $len = strlen($base_path) - strlen('index.php');

    $script_filename = realpath($_SERVER['SCRIPT_FILENAME']);
    $script_path = substr($script_filename, $len);

    if (isset($paths[$script_path]))
      $page_id = $paths[$script_path];
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
