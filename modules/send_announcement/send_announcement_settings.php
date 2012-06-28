<?php

// the path to the module. the probably shouldn't be changed unless you rename the sidebar_stats folder(s)
define('send_announcement_path', my_pligg_base . '/modules/send_announcement/');

// the path to the module. the probably shouldn't be changed unless you rename the sidebar_stats folder(s)
define('send_announcement_lang_conf', '/modules/send_announcement/lang.conf');

// the path to the modules templates. the probably shouldn't be changed unless you rename the sidebar_stats folder(s)
define('send_announcement_tpl_path', '../modules/send_announcement/templates/');



// don't touch anything past this line.

if(is_object($main_smarty)){
	//$main_smarty->assign('send_announcement_path', send_announcement_path);
	//$main_smarty->assign('send_announcement_lang_conf', send_announcement_lang_conf);
	//$main_smarty->assign('send_announcement_tpl_path', send_announcement_tpl_path);
}

?>