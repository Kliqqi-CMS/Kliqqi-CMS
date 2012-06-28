<?php

// the path to the module. the probably shouldn't be changed unless you rename the welcome_email folder(s)
define('welcome_email_path', my_pligg_base . '/modules/welcome_email/');

// the path to the module. the probably shouldn't be changed unless you rename the welcome_email folder(s)
define('welcome_email_lang_conf', '/modules/welcome_email/lang.conf');

// don't touch anything past this line.

if(is_object($main_smarty)){
	$main_smarty->assign('welcome_email_path', welcome_email_path);
	$main_smarty->assign('welcome_email_conf', welcome_email_lang_conf);
	$main_smarty->assign('welcome_email_tpl_path', welcome_email_tpl_path);
}

?>