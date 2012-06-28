<?php

// Only edit below this line if you know what you're doing.  :)

// The path to the module. This probably shouldn't be changed unless you rename the welcome_privmsg folder(s)
define('welcome_privmsg_path', my_pligg_base . '/modules/welcome_privmsg/');
define('welcome_privmsg_lang_conf', '/modules/welcome_privmsg/lang.conf');

// don't touch anything past this line.
if(is_object($main_smarty)){
	$main_smarty->assign('welcome_privmsg_path', welcome_privmsg_path);
	$main_smarty->assign('welcome_privmsg_conf', welcome_privmsg_lang_conf);
	$main_smarty->assign('welcome_privmsg_tpl_path', welcome_privmsg_tpl_path);
}

?>