<?php

include_once('../internal/Smarty.class.php');
$main_smarty = new Smarty;

include('../config.php');
include(mnminclude.'html1.php');
include(mnminclude.'link.php');
include(mnminclude.'tags.php');
include(mnminclude.'smartyvariables.php');

check_referrer();

// require user to log in
force_authentication();

// restrict access to admins and moderators
$amIadmin = 0;
$amIadmin = $amIadmin + checklevel('admin');
$main_smarty->assign('amIadmin', $amIadmin);

$canIhaveAccess = 0;
$canIhaveAccess = $canIhaveAccess + checklevel('admin');

if($canIhaveAccess == 0){	
//	$main_smarty->assign('tpl_center', '/admin/access_denied');
//	$main_smarty->display($template_dir . '/admin/admin.tpl');		
	header("Location: " . getmyurl('admin_login', $_SERVER['REQUEST_URI']));
	die();
}

// misc smarty
$main_smarty->assign('isAdmin', $canIhaveAccess);

// sidebar
$main_smarty = do_sidebar($main_smarty);

// pagename
define('pagename', 'admin_page'); 
$main_smarty->assign('pagename', pagename);

// read the mysql database to get the pligg version
$sql = "SELECT data FROM " . table_misc_data . " WHERE name = 'pligg_version'";
$pligg_version = $db->get_var($sql);
$main_smarty->assign('version_number', $pligg_version);

global $db;

if(isset($_REQUEST['mode'])){
$mode = $_REQUEST['mode'];
	if(is_numeric($_REQUEST['link_id'])){
		$link_id = $_REQUEST['link_id'];
		if($mode=='delete' && is_numeric($link_id)){
			$db->query(" delete from ".table_links." where link_id=".$link_id);

		        // module system hook
    			$vars = array('link_id' => $link_id);
    			check_actions('admin_story_delete', $vars);

			header("Location: ".my_pligg_base."/admin/admin_page.php");
			die();
		}
	}
}
$sql = (" SELECT * from ".table_links." where link_status='page'");

$page_id=$db->get_results($sql);
if($page_id){
	foreach($page_id as $page_results){
	$page_title .= '<tr>
						<td class="page_td_title">
							<a href="'.getmyurl("page", $page_results->link_title_url).'" title="'.$page_results->link_title.'" target="_blank">'.$page_results->link_title.'</a>
						</td>
						<td class="page_td_edit">
							<a class="btn btn-default" href="'.$my_base_url.$my_pligg_base.'/admin/edit_page.php?link_id='.$page_results->link_id.'"><i class="fa fa-edit" title="'. $main_smarty->get_config_vars("PLIGG_Visual_AdminPanel_Page_Edit") .'"></i></a>
						</td>
						<td class="page_td_delete">
							<a class="btn btn-danger" onclick="return confirm(\''.$main_smarty->get_config_vars('PLIGG_Visual_Page_Delete_Confirm').'\');" href="'.$my_base_url.$my_pligg_base.'/admin/admin_page.php?link_id='.$page_results->link_id.'&mode=delete"><i class="fa fa-trash-o" title="'. $main_smarty->get_config_vars("PLIGG_Visual_AdminPanel_Page_Delete") .'"></i></a>
						</td>
					</tr>';
	}
}

$main_smarty->assign('page_title' , $page_title);
$main_smarty->assign('page_text' , $page_text);

// show the template
$main_smarty->assign('tpl_center', '/admin/pages');
$main_smarty->display($template_dir . '/admin/admin.tpl');
?>