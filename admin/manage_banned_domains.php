<?php

include_once('../internal/Smarty.class.php');
$main_smarty = new Smarty;

include('../config.php');
include(mnminclude.'html1.php');
include(mnminclude.'user.php');
include(mnminclude.'smartyvariables.php');

check_referrer();

force_authentication();

$canIhaveAccess = 0;
$canIhaveAccess = $canIhaveAccess + checklevel('admin');
$canIhaveAccess = $canIhaveAccess + checklevel('moderator');

// read the mysql database to get the pligg version
$sql = "SELECT data FROM " . table_misc_data . " WHERE name = 'pligg_version'";
$pligg_version = $db->get_var($sql);
$main_smarty->assign('version_number', $pligg_version);

// sidebar
$main_smarty = do_sidebar($main_smarty);

// breadcrumbs and page title
$navwhere['text1'] = $main_smarty->get_config_vars('PLIGG_Visual_Ban_This_URL');
$main_smarty->assign('navbar_where', $navwhere);
$main_smarty->assign('posttitle', " / " . $main_smarty->get_config_vars('PLIGG_Visual_Ban_This_URL'));

if(isset($_REQUEST["id"]) && is_numeric($_REQUEST["id"])){$id = $_REQUEST["id"];}

if($canIhaveAccess == 1){
	// if spam checking is not enabled in the admin panel
	if(CHECK_SPAM == false){
		$main_smarty->assign('errorText', "<b>Error:</b> You have <b>Enable spam checking</b> set to false. Please set it to true in the <a href='$my_base_url$my_pligg_base/admin/admin_config.php?page=AntiSpam' target='_blank'>admin panel</a>.");
		$main_smarty->assign('tpl_center', '/admin/banned_domain_add');
		$main_smarty->display($template_dir . '/admin/admin.tpl');
	}
	elseif(isset($_REQUEST['add'])){
		$main_smarty->assign('story_id', sanitize($_REQUEST['id'], 3));
		$main_smarty->assign('domain_to_ban',  sanitize($_REQUEST['add'], 3));
		$main_smarty->assign('tpl_center', '/admin/banned_domain_add');
		$main_smarty->display($template_dir . '/admin/admin.tpl');
	}
	elseif(isset($_REQUEST['doban'])){
		$filename = '../local-antispam.log';
		$somecontent = strtoupper(sanitize($_REQUEST['doban'], 3)) . "\n";
		if (is_writable($filename)) {
		   if (!$handle = fopen($filename, 'a')) {
				$main_smarty->assign('errorText', "Cannot open file ($filename)");
				$main_smarty->assign('tpl_center', '/admin/banned_domain_add');
				$main_smarty->display($template_dir . '/admin/admin.tpl');
				exit;
		   }
		   if (fwrite($handle, $somecontent) === FALSE) {
				$main_smarty->assign('errorText', "Cannot write to file ($filename)");
				$main_smarty->assign('tpl_center', '/admin/banned_domain_add');
				$main_smarty->display($template_dir . '/admin/admin.tpl');
				exit;
		   }

			$main_smarty->assign('somecontent', $somecontent);
			$main_smarty->assign('filename', $filename);
			$main_smarty->assign('storyurl', getmyurl("story", $id));
			$main_smarty->assign('tpl_center', '/admin/banned_domain_added');
			$main_smarty->display($template_dir . '/admin/admin.tpl');

			fclose($handle);

		} 
		else {
			$main_smarty->assign('errorText', "The file $filename is not writable");
			$main_smarty->assign('tpl_center', '/admin/banned_domain_add');
			$main_smarty->display($template_dir . '/admin/admin.tpl');
		}
	}
	elseif(isset($_REQUEST['list']))
	{
		$lines = file('../local-antispam.log');
		$main_smarty->assign('lines', $lines);
		$main_smarty->assign('tpl_center', '/admin/banned_domains');
		$main_smarty->display($template_dir . '/admin/admin.tpl');
	}
}
else
{
//	$main_smarty->assign('errorText', "<br />We're sorry, but you do not have administrative privileges on this site.<br />If you wish to be promoted, please contact the site administrator.<br />");
//	$main_smarty->assign('tpl_center', '/admin/banned_domain_add');
//	$main_smarty->display($template_dir . '/admin/admin.tpl');
	header("Location: " . getmyurl('login', $_SERVER['REQUEST_URI']));
}
?>
