<?php

include_once('internal/Smarty.class.php');
$main_smarty = new Smarty;

include('config.php');
include(mnminclude.'html1.php');
include(mnminclude.'link.php');
include(mnminclude.'group.php');
include(mnminclude.'smartyvariables.php');

check_referrer();

// sidebar
$main_smarty = do_sidebar($main_smarty);
// require user to log in
force_authentication();

// restrict access to admins
$canIhaveAccess = 0;
$canIhaveAccess = $canIhaveAccess + checklevel('admin');
if($current_user->user_id != get_group_creator($_REQUEST['id']) && $canIhaveAccess == 0) {
//	$main_smarty->assign('tpl_center', '/templates/admin/admin_access_denied');
//	$main_smarty->display($template_dir . '/admin/admin.tpl');
	header("Location: " . getmyurl('login', $_SERVER['REQUEST_URI']));
	die();
}

// pagename
define('pagename', 'delete'); 
$main_smarty->assign('pagename', pagename);
if(isset($_REQUEST['id'])){
	global $db;
	$group_id = $_REQUEST['id'];
	if(!is_numeric($group_id)){die();}
	$group_delete = $db->query(" Delete from ".table_groups." where group_id =".$group_id);
	$member_delete = $db->query(" Delete from ".table_group_member." where member_group_id =".$group_id);
	$db->query(" Delete from ".table_group_shared." where share_group_id =".$group_id);
	header('Location: '.$my_base_url.$my_pligg_base);
}
?>