<?php
function sendannouncement_showpage(){

	// Method for identifying modules rather than pagename
	define('modulename', 'send_announcement'); 
	// $main_smarty->assign('modulename', modulename);

	force_authentication();
	$canIhaveAccess = 0;
	$canIhaveAccess = $canIhaveAccess + checklevel('admin');
	
	if($canIhaveAccess == 0){	
		header("Location: " .my_base_url.my_pligg_base );
		die();
	}

	global $main_smarty, $the_template;

	include_once('config.php');
	include_once(mnminclude.'html1.php');
	include_once(mnminclude.'link.php');
	include_once(mnminclude.'tags.php');
	include_once(mnminclude.'smartyvariables.php');
	
	$main_smarty = do_sidebar($main_smarty);
	
	
	// breadcrumbs
	$navwhere['text1'] = $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel');
	$navwhere['link1'] = getmyurl('admin', '');
	$navwhere['text2'] = "Send Announcement";
	$main_smarty->assign('navbar_where', $navwhere);
	$main_smarty->assign('posttitle', "Send Annoucement");
	// breadcrumbs
	
	$main_smarty->assign('tpl_center', send_announcement_tpl_path . 'sendannouncement');
	$main_smarty->display($the_template . '/pligg.tpl');
}

?>

