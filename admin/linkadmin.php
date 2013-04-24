<?php

include_once('../internal/Smarty.class.php');
$main_smarty = new Smarty;

include('../config.php');
include(mnminclude.'html1.php');
include(mnminclude.'link.php');
include(mnminclude.'tags.php');
include(mnminclude.'smartyvariables.php');

//check_referrer();

// restrict access to admins and moderators
force_authentication();
$canIhaveAccess = 0;
$canIhaveAccess = $canIhaveAccess + checklevel('admin');
$canIhaveAccess = $canIhaveAccess + checklevel('moderator');

if($canIhaveAccess == 1)
{
	if(isset($_REQUEST["action"])){
		
		$id = sanitize($_REQUEST["id"], 3);
		$action = sanitize($_REQUEST["action"], 3);
		if (!is_numeric($id)) die();
		
		if ($action == "main"){
			if(($link = $db->get_row("SELECT * FROM " . table_links . " WHERE link_id = $id"))) {
				$author = $db->get_row("Select * from " . table_users . " where user_id = $link->link_author");
				
				//misc smarty
				$main_smarty->assign('link_id',$link->link_id);
				$main_smarty->assign('link_title',$link->link_title);
				$main_smarty->assign('link_url',$link->link_url);
				$main_smarty->assign('link_content',$link->link_content);
				$main_smarty->assign('link_status',$link->link_status);
				$main_smarty->assign('user_login',$author->user_login);
				$main_smarty->assign('banned_domain_url',get_base_url($link->link_url));
				$main_smarty->assign('admin_discard_url',getmyurl('admin_discard', $link->link_id));
				$main_smarty->assign('admin_new_url',getmyurl('admin_new', $link->link_id));
				$main_smarty->assign('admin_published_url',getmyurl('admin_published', $link->link_id));
				$main_smarty->assign('story',getmyurl('story', $link->link_id));
				
				// pagename
				define('pagename', 'linkadmin'); 
				$main_smarty->assign('pagename', pagename);
				
				// show the template
				$main_smarty->assign('tpl_center', '/admin/submission_view');
				$main_smarty->display($template_dir . '/admin/admin.tpl');
			}
			else
			{
				echo 'Error: link not found';
			}
		}
		
		if ($action == "published" or $action == "new" or $action == "discard"){
			if(($link = $db->get_row("SELECT * FROM " . table_links . " WHERE link_id = $id"))) {
				$author = $db->get_row("Select * from " . table_users . " where user_id = $link->link_author");
				
				//misc smarty
				$main_smarty->assign('link_id',$link->link_id);
				$main_smarty->assign('link_title',$link->link_title);
				$main_smarty->assign('link_url',$link->link_url);
				$main_smarty->assign('link_content',$link->link_content);
				$main_smarty->assign('link_status',$link->link_status);
				$main_smarty->assign('user_login',$author->user_login);
				$main_smarty->assign('action',$action);				
				$main_smarty->assign('banned_domain_url',get_base_url($link->link_url));
				$main_smarty->assign('admin_modify_url',getmyurl('admin_modify', $link->link_id));
				$main_smarty->assign('admin_modify_do_url',getmyurl('admin_modify_do', $link->link_id, $action));
				
				// pagename
				define('pagename', 'linkadmin'); 
			  $main_smarty->assign('pagename', pagename);
				
				//show the template
				$main_smarty->assign('tpl_center', '/admin/submission_status');
				$main_smarty->display($template_dir . '/admin/admin.tpl');
	
			}
			else
			{
				echo 'Error: link not found';
			}
		}
	
		if ($action == "dodiscard" or $action == "dopublished" or $action == "donew"){
			if(($link = $db->get_row("SELECT * FROM " . table_links . " WHERE link_id = $id"))) {
			$xaction = substr($action, 2, 100);
			$link = new Link;
			$link->id=$id;
			$link->read();
			$link->published_date = time();
			$link->status = $xaction;
			$link->store_basic();
			$main_smarty->assign('action',$xaction);
			$main_smarty->assign('story_url',getmyurl('story', $id));
			$main_smarty->assign('admin_modify_url',getmyurl('admin_modify', $id));
			$db->query("UPDATE " . table_links . " set link_status='".$xaction."' WHERE link_id=$id");
			totals_regenerate();

			// pagename
			define('pagename', 'linkadmin'); 
			$main_smarty->assign('pagename', pagename);

			// show the template
			$main_smarty->assign('tpl_center', '/admin/submission_update');
			$main_smarty->display($template_dir . '/admin/admin.tpl');
			}else{
				echo 'Error: link not found';
			}
		}			
	}else{
			//no request
	}
}
else{
//	echo "<br />We're sorry, but you do not have administrative privileges on this site.<br />If you wish to be promoted, please contact the site administrator.<br />";
	header("Location: " . getmyurl('admin_login', $_SERVER['REQUEST_URI']));
}

?>