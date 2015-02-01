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
	if (!isset($path_to_root) || isset($_GET['path_to_root']) || isset($_POST['path_to_root']))
		die(_("Restricted access"));
	include_once($path_to_root . "/includes/ui.inc");
	include_once($path_to_root . "/includes/page/header.inc");

	$js = "<script language='JavaScript' type='text/javascript'>
function defaultCompany()
{
	document.forms[0].company_login_name.options[".$_SESSION["wa_current_user"]->company."].selected = true;
}
</script>";
	add_js_file('login.js');

	if (check_faillog())
	{
		$login_msg = _('Too many failed login attempts.<br>Please wait a while or try later.');

    $js .= "<script>setTimeout(function() {
      document.getElementsByName('SubmitUser')[0].disabled=0;
      document.getElementById('log_msg').innerHTML='$demo_text'}, 1000*$login_delay);</script>";
	}

	if (!isset($def_coy))
		$def_coy = 0;
	$def_theme = "default";
	$theme = "default";

	$login_timeout = $_SESSION["wa_current_user"]->last_act;

	$title = $login_timeout ? _('Authorization timeout') : $app_title." ".$version." - "._("Login");
	$encoding = isset($_SESSION['language']->encoding) ? $_SESSION['language']->encoding : "iso-8859-1";
	$rtl = isset($_SESSION['language']->dir) ? $_SESSION['language']->dir : "ltr";
	$onload = !$login_timeout ? "onload='defaultCompany()'" : "";

	echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\" \"http://www.w3.org/TR/html4/loose.dtd\">\n";
	echo "<html dir='$rtl' >\n";
	echo "<head profile=\"http://www.w3.org/2005/10/profile\"><title>$title</title>\n";
 	echo "<meta http-equiv='Content-type' content='text/html; charset=$encoding' />\n";

	echo "<link href='$path_to_root/themes/$theme/css/bootstrap.css' rel='stylesheet' type='text/css'> \n";
	echo "<link href='$path_to_root/themes/$theme/css/bootstrap-custom.css' rel='stylesheet' type='text/css'> \n";
	echo "<link href='$path_to_root/themes/$theme/default.css' rel='stylesheet' type='text/css'> \n";
 	echo "<link href='$path_to_root/themes/default/images/favicon.ico' rel='icon' type='image/x-icon'> \n";
 	echo "<script language='javascript' type='text/javascript' src='$path_to_root/themes/$theme/js/jquery-1.11.2.min.js'></script>";
 	echo "<script language='javascript' type='text/javascript' src='$path_to_root/themes/$theme/js/bootstrap.min.js'></script>";

	send_scripts();
	if (!$login_timeout)
	{
		echo $js;
	}
	echo "</head>\n";

	echo "<body id='loginscreen' $onload>\n";

	div_start('_page_body');
	start_form(false, false, $_SESSION['timeout']['uri'], "loginform");

  echo ' <div class="container"><div class="panel panel-default">';
  echo '<h3 class="">Please login here</h3>';

	echo "<input type='hidden' id=ui_mode name='ui_mode' value='".$_SESSION["wa_current_user"]->ui_mode."' />\n";
	$value = $login_timeout ? $_SESSION['wa_current_user']->loginname : ($allow_demo_mode ? "demouser":"");

	if ($login_timeout) {
		$login_msg = _('Authorization timeout');
	} 

  if ($login_fail) {
    $login_msg = _("Incorrect Password");
  }

  if (isset($_GET['logout']))
  {
    echo '<div class="alert alert-success alert-dismissible" role="alert">';
    echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
    echo _('You have been logged out.');
    echo '</div>';
  }

  if (isset($login_msg) && !empty($login_msg))
  {
    echo '<div class="alert alert-danger alert-dismissible" role="alert">';
    echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
    echo $login_msg;
    echo '</div>';
  }
	// Display demo user name and password within login form if "$allow_demo_mode" is true
	if ($allow_demo_mode == true)
	{
    echo '
    <input type="hidden" name="user_name_entry_field" value="demouser"/>
    <input type="hidden" name="password" value="password"/>
    ';
	}
	else
	{
		$demo_text = _("Please login here");
    if (@$allow_password_reset) {
      $demo_text .= " "._("or")." <a href='$path_to_root/index.php?reset=1'>"._("request new password")."</a>";
    }
    echo '
    <label for="user_name_entry_field" class="sr-only">Username</label>
    <input type="text" name="user_name_entry_field" id="user_name_entry_field" class="form-control" placeholder="Username" required autofocus>
    <label for="password" class="sr-only">Password</label>
    <input type="password" id="password" name="password" class="form-control" placeholder="Password">
    ';
	}

	if ($login_timeout) {
		hidden('company_login_name', $_SESSION["wa_current_user"]->company);
	} else {
		if (isset($_SESSION['wa_current_user']->company))
			$coy =  $_SESSION['wa_current_user']->company;
		else
			$coy = $def_coy;
    echo '<label for="company_login_name" class="sr-only">Company</label>';
		if (!@$text_company_selection) {
			echo "<select name='company_login_name' class='form-control'>\n";
			for ($i = 0; $i < count($db_connections); $i++)
				echo "<option value=$i ".($i==$coy ? 'selected':'') .">" . $db_connections[$i]["name"] . "</option>";
			echo "</select>\n";
		} else {
//			$coy = $def_coy;
			echo '<input type="text" id="company_login_name" class="form-control" placeholder="Company" required>';
		}
	}; 

	if ($allow_demo_mode)
    echo '<button name="SubmitUser" class="btn btn-lg btn-primary btn-block" type="submit">View demo</button> ';
  else
    echo '<button name="SubmitUser" class="btn btn-lg btn-primary btn-block" type="submit">Log in</button>';


	//echo "<center><input type='submit' value='&nbsp;&nbsp;"._("Login -->")."&nbsp;&nbsp;' name='SubmitUser'"
		//.($login_timeout ? '':" onclick='set_fullmode();'").(isset($blocked_msg) ? " disabled" : '')." /></center>\n";

	foreach($_SESSION['timeout']['post'] as $p => $val) {
		// add all request variables to be resend together with login data
		if (!in_array($p, array('ui_mode', 'user_name_entry_field', 
			'password', 'SubmitUser', 'company_login_name'))) 
			if (!is_array($val))
				echo "<input type='hidden' name='$p' value='$val'>";
			else
				foreach($val as $i => $v)
					echo "<input type='hidden' name='{$p}[$i]' value='$v'>";
	}
    echo "</div></div>";
	end_form(1);
	$Ajax->addScript(true, "document.forms[0].password.focus();");

    echo "<script language='JavaScript' type='text/javascript'>
    //<![CDATA[
            <!--
            document.forms[0].user_name_entry_field.select();
            document.forms[0].user_name_entry_field.focus();
            //-->
    //]]>
    </script>";
    div_end();
	echo "</body></html>\n";

?>
