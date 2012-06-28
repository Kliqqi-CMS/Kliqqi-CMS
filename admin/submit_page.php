<?php
// The source code packaged with this file is Free Software, Copyright (C) 2005 by
// Ricardo Galli <gallir at uib dot es>.
// It's licensed under the AFFERO GENERAL PUBLIC LICENSE unless stated otherwise.
// You can get copies of the licenses here:
// 		http://www.affero.org/oagpl.html
// AFFERO GENERAL PUBLIC LICENSE is also included in the file called "COPYING".

include_once('../Smarty.class.php');
$main_smarty = new Smarty;

include('../config.php');
include(mnminclude.'html1.php');
include(mnminclude.'link.php');
include(mnminclude.'tags.php');
include(mnminclude.'user.php');
include(mnminclude.'csrf.php');
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
$canIhaveAccess = $canIhaveAccess + checklevel('admin');

if($canIhaveAccess == 0){	
//	$main_smarty->assign('tpl_center','/admin/admin_access_denied');
//	$main_smarty->display($template_dir . '/admin/admin.tpl');	
	header("Location: " . getmyurl('login', $_SERVER['REQUEST_URI']));
	die();
}

// misc smarty
$main_smarty->assign('isAdmin', $canIhaveAccess);

// sidebar
$main_smarty = do_sidebar($main_smarty);

	$randkey = rand(1000000,100000000);
	$main_smarty->assign('randkey', $randkey);
	
// pagename	
define('pagename', 'submit_page'); 
$main_smarty->assign('pagename', pagename);

// read the mysql database to get the pligg version
$sql = "SELECT data FROM " . table_misc_data . " WHERE name = 'pligg_version'";
$pligg_version = $db->get_var($sql);
$main_smarty->assign('version_number', $pligg_version);

if($_REQUEST['process']=='new_page'){
	global $current_user,$db;
   if (!$_REQUEST['page_url'])
	$_REQUEST['page_url'] = $_REQUEST['page_title'];
   $page_url=makeUrlFriendly($db->escape(trim($_REQUEST['page_url'])), true);
   $page_title=$db->escape(trim($_REQUEST['page_title']));
   $page_content= $db->escape(trim($_REQUEST['page_content']));
   $page_keywords= $db->escape(trim($_REQUEST['page_keywords']));
   $page_description= $db->escape(trim($_REQUEST['page_description']));
   $page_randkey= $db->escape(trim($_REQUEST['randkey']));
   $sql = "INSERT IGNORE INTO " . table_links . " (link_author, link_status, link_randkey, link_category, link_date, link_published_date, link_votes, link_karma, link_title, link_title_url, link_content, link_field1, link_field2) 
				VALUES (".$current_user->user_id.", 'page', $page_randkey, '0', NOW( ), '', 0, 0, '$page_title', '$page_url', '$page_content', '$page_keywords', '$page_description')";
	$result = @mysql_query ($sql); 
	if($result==1){
		header('Location: '.getmyurl("page", $page_url));
		die();
	}
  }
// show the template
$main_smarty->assign('tpl_center', $template_dir . '/admin/submit_page');
$main_smarty->display($template_dir . '/admin/admin.tpl');

?>

