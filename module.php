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

$res_for_update=mysql_query("select var_value from " . table_config . "  where var_name = 'uninstall_module_updates'");
$data_for_update_uninstall_mod=mysql_fetch_array($res_for_update);
//count uninstalled modules with updates available

$main_smarty->assign('un_no_module_update_require', $data_for_update_uninstall_mod['var_value']);

$vars = '';
check_actions('module_page', $vars);



?>
