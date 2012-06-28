<?php
// The source code packaged with this file is Free Software, Copyright (C) 2005 by
// Ricardo Galli <gallir at uib dot es>.
// It's licensed under the AFFERO GENERAL PUBLIC LICENSE unless stated otherwise.
// You can get copies of the licenses here:
// 		http://www.affero.org/oagpl.html
// AFFERO GENERAL PUBLIC LICENSE is also included in the file called "COPYING".

include_once('Smarty.class.php');
$main_smarty = new Smarty;

include('config.php');
include(mnminclude.'html1.php');
include_once(mnminclude.'smartyvariables.php');

$type=sanitize($_REQUEST['type'], 2);
$name=js_urldecode($_POST["name"]);

switch ($type) {
	case 'username':
		if (utf8_strlen($name)<3) { // if username is less than 3 characters
			echo $main_smarty->get_config_vars("PLIGG_Visual_CheckField_UserShort");
			return;
		}
		if (preg_match('/\pL/u', 'a')) {	// Check if PCRE was compiled with UTF-8 support
		    if (!preg_match('/^[_\-\d\p{L}\p{M}]+$/iu', $name)) { // if username contains invalid characters
			echo $main_smarty->get_config_vars("PLIGG_Visual_CheckField_InvalidChars");
			return;
		    }
		} else {
		    if (!preg_match('/^[^~`@%&=\\/;:\\.,<>!"\\\'\\^\\.\\[\\]\\$\\(\\)\\|\\*\\+\\-\\?\\{\\}\\\\]+$/', $name)) { // if username contains invalid characters
			echo $main_smarty->get_config_vars("PLIGG_Visual_CheckField_InvalidChars");
			return;
		    }
		}
		if(user_exists($name)) { // if username already exists
			echo $main_smarty->get_config_vars("PLIGG_Visual_CheckField_UserExists");
			return;
		}
		$vars = array('name' => $name);
		check_actions('register_check_field', $vars);
		if ($vars['error'])
			echo $vars['error'];
		else
			echo "OK";
		break;
	case 'email':
		if (!check_email($name)) { // if email contains invald characters
			echo $main_smarty->get_config_vars("PLIGG_Visual_CheckField_EmailInvalid");
			return;
		}
		if(email_exists($name)) { // if email already exists
			echo $main_smarty->get_config_vars("PLIGG_Visual_CheckField_EmailExists");
			return;
		}
		$vars = array('email' => $name);
		check_actions('register_check_field', $vars);
		if ($vars['error'])
			echo $vars['error'];
		else
			echo "OK";
		break;
	default:
		echo "KO $type";
}
?>