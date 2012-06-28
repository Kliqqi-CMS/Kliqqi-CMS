<?php
include_once('../Smarty.class.php');
$main_smarty = new Smarty;

include('../config.php');
include(mnminclude.'html1.php');
include(mnminclude.'link.php');
include(mnminclude.'tags.php');
include(mnminclude.'smartyvariables.php');

check_referrer();

// require user to log in
force_authentication();

// restrict access to god and admin only
$amIgod = 0;
$amIgod = $amIgod + checklevel('god');
$main_smarty->assign('amIgod', $amIgod);

$canIhaveAccess = 0;
$canIhaveAccess = $canIhaveAccess + checklevel('god');

if($canIhaveAccess == 0){	
	header("Location: " . getmyurl('login', $_SERVER['REQUEST_URI']));
	die();
}

// misc smarty
$main_smarty->assign('isAdmin', $canIhaveAccess);

// sidebar
$main_smarty = do_sidebar($main_smarty);

// pagename
define('pagename', 'admin_group'); 
$main_smarty->assign('pagename', pagename);

// read the mysql database to get the pligg version
$sql = "SELECT data FROM " . table_misc_data . " WHERE name = 'pligg_version'";
$pligg_version = $db->get_var($sql);
$main_smarty->assign('version_number', $pligg_version); 

global $db;

if(isset($_REQUEST['mode'])){
	$mode = $_REQUEST['mode'];
	$group_id = $_REQUEST['group_id'];
	if($mode=='delete' && is_numeric($group_id)){
		$db->query("DELETE FROM ".table_groups." WHERE group_id=".$group_id);
		$db->query("DELETE FROM ".table_group_member." WHERE member_group_id=".$group_id);
		$db->query("DELETE FROM ".table_group_shared." WHERE share_group_id=".$group_id);

		header("Location: ".my_pligg_base."/admin/admin_group.php");
		die();
	}
	elseif($mode=='approve' && is_numeric($group_id)){
	        $db->query("UPDATE ".table_groups." SET group_status='Enable' WHERE group_id=$group_id");

		header("Location: ".my_pligg_base."/admin/admin_group.php");
		die();
	}
}

$sql = "SELECT * FROM ".table_groups." LEFT JOIN ".table_users." ON user_id=group_creator ORDER BY group_name";
$main_smarty->assign('groups',$db->get_results($sql,ARRAY_A));

//$main_smarty->assign('page_title' , $page_title);
//$main_smarty->assign('page_text' , $page_text);

// show the template
$main_smarty->assign('tpl_center', '/admin/admin_group');
$main_smarty->display($template_dir . '/admin/admin.tpl');
?>