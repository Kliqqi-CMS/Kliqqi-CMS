<?php
include_once('Smarty.class.php');
$main_smarty = new Smarty;

include('config.php');
include(mnminclude.'html1.php');
include(mnminclude.'link.php');
include(mnminclude.'smartyvariables.php');

check_referrer();

// sidebar
$main_smarty = do_sidebar($main_smarty);
// require user to log in
force_authentication();

// restrict access to god only
$canIhaveAccess = 0;
$canIhaveAccess = $canIhaveAccess + checklevel('god');
if($canIhaveAccess == 0){	
//	$main_smarty->assign('tpl_center', '/templates/admin/admin_access_denied');
//	$main_smarty->display($template_dir . '/admin/admin.tpl');		
	header("Location: " . getmyurl('login', $_SERVER['REQUEST_URI']));
	die();
}
function dowork(){	
	$canIhaveAccess = 0;
	$canIhaveAccess = $canIhaveAccess + checklevel('god');
	if($canIhaveAccess == 1)
	{
		if(is_writable('settings.php') == 0){
			die("Error: settings.php is not writeable.");
		}
		if(isset($_REQUEST['action'])){
			$action = $_REQUEST['action'];
		} else {
			$action = "view";
		}
		if($action == "view"){
			$config = new pliggconfig;
			if(isset($_REQUEST['page'])){
				$config->var_page = $_REQUEST['page'];
				$config->showpage();
			}else{
				$config->listpages();
			}
		}
		if($action == "save"){
			$config = new pliggconfig;
			$config->var_id = substr($_REQUEST['var_id'], 6, 10);
			$config->var_value = $_REQUEST['var_value'];
			$config->store();
		}
	}
}	
// pagename
define('pagename', 'delete'); 
$main_smarty->assign('pagename', pagename);
if(isset($_REQUEST['link_id'])){
	global $db;
	$link_id = $_REQUEST['link_id'];
	if(!is_numeric($link_id)){die();}
	$linkres=new Link;
	$linkres->id=$link_id;
	$linkres->read();
	//echo $linkres->status;
	totals_adjust_count($linkres->status, -1);
	//$linkres->store_basic();
	
    // module system hook
	$vars = array('link_id' => $linkres->id);
	check_actions('admin_story_delete', $vars);
	
	$link_delete = $db->query(" Delete from ".table_links." where link_id =".$linkres->id);
	//echo $link_delete."<br />";
	$vote_delete = $db->query(" Delete from ".table_votes." where vote_link_id =".$linkres->id);
	//echo $vote_delete."<br />";
	$comment_delete = $db->query(" Delete from ".table_comments." where comment_link_id =".$linkres->id);
	//echo $comment_delete."<br />";
	$tag_delete = $db->query(" Delete from ".table_tags." where tag_link_id =".$linkres->id);
	//echo $tag_delete."<br />";
	$saved_delete = $db->query(" Delete from ".table_saved_links." where saved_link_id =".$linkres->id);
	//echo $saved_delete."<br />";
	$trackback_delete = $db->query(" Delete from ".table_trackbacks." where trackback_link_id =".$linkres->id);
	//echo $trackback_delete."<br />";

	$db->query("DELETE FROM ".table_additional_categories." WHERE ac_link_id =".$linkres->id);

	$db->query("DELETE FROM ".table_tag_cache);

	header('Location: '.$my_base_url.$my_pligg_base);
}
if(isset($_REQUEST['comment_id'])){
	global $db;
	$comment_id = $_REQUEST['comment_id'];
	if(!is_numeric($comment_id)){die();}
	$link_id = $db->get_var("SELECT comment_link_id FROM `" . table_comments . "` WHERE `comment_id` = $comment_id");
	
	$vars = array('comment_id' => $comment_id);
	check_actions('comment_deleted', $vars);
	
	$db->query('DELETE FROM `' . table_comments . '` WHERE `comment_id` = "'.$comment_id.'"');
	$comments = $db->get_results($sql="SELECT comment_id FROM " . table_comments . " WHERE `comment_parent` = '$comment_id'");
	foreach($comments as $comment)
	{
	   	$vars = array('comment_id' => $comment->comment_id);
	   	check_actions('comment_deleted', $vars);
	}
	$db->query('DELETE FROM `' . table_comments . '` WHERE `comment_parent` = "'.$comment_id.'"');
	$link = new Link;
	$link->id=$link_id;
	$link->read();
	$link->recalc_comments();
	$link->store();
	$link='';
	if ($_SERVER['HTTP_REFERER'] && strpos($_SERVER['HTTP_REFERER'],$my_base_url.$my_pligg_base)===0)
	    header('Location: '.$_SERVER['HTTP_REFERER']);
	else
	    header('Location: '.$my_base_url.$my_pligg_base);
}
?>