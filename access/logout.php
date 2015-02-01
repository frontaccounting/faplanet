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

define("FA_LOGOUT_PHP_FILE","");

$page_security = 'SA_OPEN';
$path_to_root="..";
include($path_to_root . "/includes/session.inc");
//add_js_file('login.js');

//include($path_to_root . "/includes/page/header.inc");
//page_header(_("Logout"), true, false, '');

//include($path_to_root . "/access/login.php");
//end_page(false, true);
session_unset();
@session_destroy();

header("HTTP/1.1 303 See Other");
header("Location: ".$path_to_root.'/index.php');
//header("Location: ".$path_to_root.'/index.php?logout=1');

?>


