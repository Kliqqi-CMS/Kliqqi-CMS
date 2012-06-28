<?php
// The source code packaged with this file is Free Software, Copyright (C) 2005 by
// Ricardo Galli <gallir at uib dot es>.
// It's licensed under the AFFERO GENERAL PUBLIC LICENSE unless stated otherwise.
// You can get copies of the licenses here:
// http://www.affero.org/oagpl.html
// AFFERO GENERAL PUBLIC LICENSE is also included in the file called "COPYING".

include_once('../Smarty.class.php');
$main_smarty = new Smarty;

include('../config.php');
include(mnminclude.'html1.php');
include(mnminclude.'smartyvariables.php');

check_referrer();

force_authentication();

$canIhaveAccess = 0;
$canIhaveAccess = $canIhaveAccess + checklevel('god');

if($canIhaveAccess == 0){	
//	$main_smarty->assign('tpl_center', '/admin/admin_access_denied');
//	$main_smarty->display($template_dir . '/admin/admin.tpl');		
	header("Location: " . getmyurl('login', $_SERVER['REQUEST_URI']));
	die();
}

// pagename
define('pagename', 'admin_modules'); 
$main_smarty->assign('pagename', pagename);

// read the mysql database to get the pligg version
$sql = "SELECT data FROM " . table_misc_data . " WHERE name = 'pligg_version'";
$pligg_version = $db->get_var($sql);
$main_smarty->assign('version_number', $pligg_version);

// breadcrumbs and page title
$navwhere['text1'] = $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel');
$navwhere['link1'] = getmyurl('admin', '');
$navwhere['text2'] = $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel_6');
$main_smarty->assign('navbar_where', $navwhere);
$main_smarty->assign('posttitle', " / " . $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel_6'));

// sidebar
$main_smarty = do_sidebar($main_smarty);


if($canIhaveAccess == 1){
	if ($_POST["enabled"]) {
		foreach($_POST["enabled"] as $id => $value) 
		{
			$sql = "UPDATE " . table_modules . " set enabled = $value where id=$id";
			$db->query($sql);
		}
		header("Location: admin_modules.php");
		exit;
	}

	if($_GET['action'] == 'disable'){
		$module = $db->escape(sanitize($_REQUEST['module'],3));
		$sql = "UPDATE " . table_modules . " set enabled = 0 where `name` = '" . $module . "';";
		//echo $sql;
		$db->query($sql);

		clear_module_cache();

		header('Location: admin_modules.php');
		die();
	}	
	if($_GET['action'] == 'enable'){
		$module = $db->escape(sanitize($_REQUEST['module'],3));
		$sql = "UPDATE " . table_modules . " set enabled = 1 where `name` = '" . $module . "';";
		//echo $sql;
		$db->query($sql);

		clear_module_cache();

		header('Location: admin_modules.php');
		die();
	}
	

	$main_smarty->assign('tpl_center', '/admin/admin_modules_center');
	$output = $main_smarty->fetch($template_dir . '/admin/admin.tpl');		

	if (!function_exists('clear_module_cache')) {
		echo "Your template is not compatible with this version of Pligg. Missing the 'clear_modules_cache' function in admin_modules_center.tpl.";
	} else {
		echo $output;
	}

}

function clear_module_cache () {
	global $db;
	if(caching == 1){
		// this is to clear the cache and reload it for settings_from_db.php
		$db->cache_dir = mnmpath.'cache';
		$db->use_disk_cache = true;
		$db->cache_queries = true;
		$db->cache_timeout = 0;
		// if this query is changed, be sure to also change it in modules_init.php
		$modules = $db->get_results('SELECT * from ' . table_modules . ' where enabled=1;');
		$db->cache_queries = false;
	}
}

?>
