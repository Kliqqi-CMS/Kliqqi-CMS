<?php

include_once('../internal/Smarty.class.php');
$main_smarty = new Smarty;

include('../config.php');
include(mnminclude.'html1.php');
include(mnminclude.'smartyvariables.php');

check_referrer();

force_authentication();

$canIhaveAccess = 0;
$canIhaveAccess = $canIhaveAccess + checklevel('admin');

if($canIhaveAccess == 0){	
	header("Location: " . getmyurl('login', $_SERVER['REQUEST_URI']));
	die();
}

// pagename
define('pagename', 'template_widgets');
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
	

	if ($_GET["acc"]=="add") {
		
		$callback_tpl=$_GET['callback_tpl'];
		$name=$_GET['name'];
		$m_type=$_GET['m_type'];
		$blocks = $db->get_results("SELECT * from " .table_block . " where callback_tpl='".$callback_tpl."' ");
		if(count($blocks)==0)
		{
			mysql_query("insert into " .table_block . " set name='".$name."', callback_tpl='".$callback_tpl."', module='".$m_type."', enabled='1'") or die(mysql_error());
			header("Location: admin_template_widgets.php");
		    exit;
		}
		
	}
	
	
	if ($_GET["acc"]=="removed") {
		$bid=$_GET['bid'];
		mysql_query("delete from " .table_block . " where bid='".$bid."'") or die(mysql_error());
			header("Location: admin_template_widgets.php");
		    exit;
		
	}
	/***

	if($_GET['action'] == 'disable'){
		$module = $db->escape(sanitize($_REQUEST['module'],3));
		$sql = "UPDATE " . table_widgets . " set enabled = 0 where `name` = '" . $module . "';";
		//echo $sql;
		$db->query($sql);

		clear_widget_cache();

		header('Location: admin_template_widgets.php');
		die();
	}	
	if($_GET['action'] == 'enable'){
		$module = $db->escape(sanitize($_REQUEST['module'],3));
		$sql = "UPDATE " . table_widgets . " set enabled = 1 where `name` = '" . $module . "';";
		//echo $sql;
		$db->query($sql);

		clear_widget_cache();

		header('Location: admin_template_widgets.php');
		die();
	}
if($_GET['action'] == 'install'){
	$widget = $db->escape(sanitize($_REQUEST['widget'],3));

	if($widget_info = include_widget_settings($widget))
	{
		$version = $widget_info['version'];
		$name = $widget_info['name'];
#		$requires = $widget_info['requires'];
#		check_widget_requirements($requires);
#		process_db_requirements($widget_info);
		
	} else {
		die('no init.php file exists');
	}
		
	$db->query("INSERT IGNORE INTO " . table_widgets . " (`name`, `version`, `folder`, `enabled`) values ('".$name."', '" . $version . "', '".$widget."', 1);");

	clear_widget_cache();

	header('Location: admin_template_widgets.php?status=uninstalled');
	die();
}	
if($_GET['action'] == 'remove'){
	$widget = $db->escape(sanitize($_REQUEST['widget'],3));
	$sql = "SELECT * FROM " . table_widgets . " WHERE `name` = '" . $widget . "';";
	$row = $db->get_row($sql);

	$sql = "Delete from " . table_widgets . " where `name` = '" . $widget . "';";
	//echo $sql;
	$db->query($sql);

	clear_widget_cache();

	header('Location: admin_template_widgets.php?status=uninstalled');
	die();
}	
*/
$dynSidebar->get_module_widthgets();
$dynSidebar->get_themes_widthgets();

	$res_block = mysql_query('SELECT * from ' .table_block . ' order by weight ASC');
	if(count(mysql_num_rows($res_block)>0)){
		while($blk=mysql_fetch_array($res_block))
		$blocks[]=$blk; 
	}

$i=0;	
$all_width=$dynSidebar->all_widget;
$all_widthgets=$dynSidebar->all_widget;
for($i=0; $i<count($all_width); $i++){

if (in_array_r($all_width[$i]['callback_tpl'], $blocks)){
unset($all_widthgets[$i]);

}

	
}

	 $main_smarty->assign('unwidgets',array_values($all_widthgets));	
	
    $main_smarty->assign('allBlocks',$blocks);	

	$main_smarty->assign('tpl_center', '/admin/template_widgets');
	$output = $main_smarty->fetch($template_dir . '/admin/admin.tpl');		

	if (!function_exists('clear_widget_cache')) {
		echo "Your template is not compatible with this version of Pligg. Missing the 'clear_widgets_cache' function in admin_template_widgets_center.tpl.";
	} else {
		echo $output;
	}

}

function clear_widget_cache () {
	global $db;
	if(caching == 1){
		// this is to clear the cache and reload it for settings_from_db.php
		$db->cache_dir = mnmpath.'cache';
		$db->use_disk_cache = true;
		$db->cache_queries = true;
		$db->cache_timeout = 0;
		// if this query is changed, be sure to also change it in modules_init.php
		$modules = $db->get_results('SELECT * from ' . table_widgets . ' where enabled=1;');
		$db->cache_queries = false;
	}
}
?>
