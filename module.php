<?php

include_once('Smarty.class.php');
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

$vars = '';
check_actions('module_page', $vars);



?>
