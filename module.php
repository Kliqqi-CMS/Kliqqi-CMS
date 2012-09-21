<?php

include_once('internal/Smarty.class.php');
$main_smarty = new Smarty;

include_once('config.php');
include_once(mnminclude.'html1.php');
include_once(mnminclude.'link.php');
include_once(mnminclude.'tags.php');
include_once(mnminclude.'search.php');
include_once(mnminclude.'smartyvariables.php');

// pagename	
define('pagename', 'module'); 
$main_smarty->assign('pagename', pagename);

$main_smarty->assign('un_no_module_update_require', $_COOKIE['module_update_require_un_ex']);
$vars = '';
check_actions('module_page', $vars);



?>
