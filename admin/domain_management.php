<?php
// This file is used to display and manage your domain blacklist and whitelist files

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

$is_moderator = checklevel('moderator'); // Moderators have a value of '1' for the variable $is_moderator

// read the mysql database to get the pligg version
$sql = "SELECT data FROM " . table_misc_data . " WHERE name = 'pligg_version'";
$pligg_version = $db->get_var($sql);
$main_smarty->assign('version_number', $pligg_version);

// File locations
global $USER_SPAM_RULESET, $FRIENDLY_DOMAINS;
$blacklist_file = file('../'.$USER_SPAM_RULESET);
$main_smarty->assign('blacklist_file', $blacklist_file);
$whitelist_file = file('../'.$FRIENDLY_DOMAINS);
$main_smarty->assign('whitelist_file', $whitelist_file);
$blacklist = '../'.$USER_SPAM_RULESET;
$whitelist = '../'.$FRIENDLY_DOMAINS;

// breadcrumbs and page title
$navwhere['text1'] = $main_smarty->get_config_vars('PLIGG_Visual_Ban_This_URL');
$main_smarty->assign('navbar_where', $navwhere);
$main_smarty->assign('posttitle', " / " . $main_smarty->get_config_vars('PLIGG_Visual_Ban_This_URL'));

// pagename
define('pagename', 'domain_management'); 
$main_smarty->assign('pagename', pagename);

if(isset($_REQUEST["id"]) && is_numeric($_REQUEST["id"])){$id = $_REQUEST["id"];}

if($canIhaveAccess == 1){
	
	// setup breadcrumbs for the various views
	$view = isset($_GET['view']) && sanitize($_GET['view'], 3) != '' ? sanitize($_GET['view'], 3) : 'domains';
	$main_smarty->assign('view', $view);
	
	// if spam checking is not enabled in the admin panel
	if(CHECK_SPAM == false){
		$main_smarty->assign('errorText', "<b>Error:</b> You have <b>Enable spam checking</b> set to false. Please set it to true in the <a href='$my_base_url$my_pligg_base/admin/admin_config.php?page=AntiSpam' target='_blank'>admin panel</a>.");
		$main_smarty->assign('tpl_center', '/admin/domain_blacklist_add');
		if ($is_moderator == '1'){
			$main_smarty->display($template_dir . '/admin/moderator.tpl');
		} else {
			$main_smarty->display($template_dir . '/admin/admin.tpl');
		}
	}
		
	if(isset($_GET["remove"])){
		
		$domain = sanitize($_GET["remove"], 3);
		if ($domain == '') {
			$main_smarty->assign('errorText', "No domain was specified");
			$main_smarty->assign('tpl_center', '/admin/domain_management');
			if ($is_moderator == '1'){
				$main_smarty->display($template_dir . '/admin/moderator.tpl');
			} else {
				$main_smarty->display($template_dir . '/admin/admin.tpl');
			}
			exit;
		}
		
		if (is_writable($blacklist)) {
			$txt = file_get_contents($blacklist);
			$txt = str_replace(trim($domain),'', $txt);
			$txt = preg_replace('/^\n+|^[\t\s]*\n+/m','',$txt);
			file_put_contents($blacklist, $txt);
	
			// Prepare the blacklist data for display
			$main_smarty->assign('errorText', "Removed the domain $domain from $blacklist <META http-equiv='refresh' content='1;URL=domain_management.php'> ");
			$main_smarty->assign('blacklist', $blacklist);
			$main_smarty->assign('domain', $domain);
			$main_smarty->assign('tpl_center', '/admin/domain_management');
			if ($is_moderator == '1'){
				$main_smarty->display($template_dir . '/admin/moderator.tpl');
			} else {
				$main_smarty->display($template_dir . '/admin/admin.tpl');
			}

		} else {
			$main_smarty->assign('errorText', "The file $blacklist is not writable");
		}
		
		if (is_writable($whitelist)) {

			$txt = file_get_contents($whitelist);
			$txt = str_replace(trim($domain),'', $txt);
			$txt = preg_replace('/^\n+|^[\t\s]*\n+/m','',$txt);
			file_put_contents($whitelist, $txt);
			
			// Prepare the whitelist data for display
			$main_smarty->assign('errorText', "Removed the domain $domain from $whitelist <META http-equiv='refresh' content='1;URL=domain_management.php'> ");
			$main_smarty->assign('whitelist', $whitelist);
			$main_smarty->assign('domain', $domain);
			$main_smarty->assign('tpl_center', '/admin/domain_management');
			if ($is_moderator == '1'){
				$main_smarty->display($template_dir . '/admin/moderator.tpl');
			} else {
				$main_smarty->display($template_dir . '/admin/admin.tpl');
			}

		} else {
			$main_smarty->assign('errorText', "The file $whitelist is not writable");
		}
		
		$main_smarty->assign('tpl_center', '/admin/domain_management');
		if ($is_moderator == '1'){
			$main_smarty->display($template_dir . '/admin/moderator.tpl');
		} else {
			$main_smarty->display($template_dir . '/admin/admin.tpl');
		}
	}
	elseif(isset($_REQUEST['blacklist_add'])){
		$main_smarty->assign('story_id', sanitize($_REQUEST['id'], 3));
		$main_smarty->assign('domain_to_add',  sanitize($_REQUEST['blacklist_add'], 3));
		$main_smarty->assign('tpl_center', '/admin/domain_blacklist_add');
		if ($is_moderator == '1'){
			$main_smarty->display($template_dir . '/admin/moderator.tpl');
		} else {
			$main_smarty->display($template_dir . '/admin/admin.tpl');
		}
	}
	elseif(isset($_REQUEST['whitelist_add'])){
		$main_smarty->assign('story_id', sanitize($_REQUEST['id'], 3));
		$main_smarty->assign('domain_to_add',  sanitize($_REQUEST['whitelist_add'], 3));
		$main_smarty->assign('tpl_center', '/admin/domain_whitelist_add');
		if ($is_moderator == '1'){
			$main_smarty->display($template_dir . '/admin/moderator.tpl');
		} else {
			$main_smarty->display($template_dir . '/admin/admin.tpl');
		}
	}
	elseif(isset($_REQUEST['doblacklist'])){	
		$domain = strtoupper(sanitize($_REQUEST['doblacklist'], 3)) . "\n";
		if (is_writable($blacklist)) {
		
		   if (!$handle = fopen($blacklist, 'a')) {
				$main_smarty->assign('errorText', "Cannot open file ($blacklist)");
				$main_smarty->assign('tpl_center', '/admin/domain_blacklist_add');
				if ($is_moderator == '1'){
					$main_smarty->display($template_dir . '/admin/moderator.tpl');
				} else {
					$main_smarty->display($template_dir . '/admin/admin.tpl');
				}
				exit;
		   }
		   if (fwrite($handle, $domain) === FALSE) {
				$main_smarty->assign('errorText', "Cannot write to file ($blacklist)");
				$main_smarty->assign('tpl_center', '/admin/domain_blacklist_add');
				if ($is_moderator == '1'){
					$main_smarty->display($template_dir . '/admin/moderator.tpl');
				} else {
					$main_smarty->display($template_dir . '/admin/admin.tpl');
				}
				exit;
		   }

			$main_smarty->assign('domain', $domain);
			$main_smarty->assign('blacklist', $blacklist);
			$main_smarty->assign('errorText', "The domain $domain has been added to the Blacklist file $blacklist <META http-equiv='refresh' content='1;URL=domain_management.php'> ");
			$main_smarty->assign('tpl_center', '/admin/domain_management');
			if ($is_moderator == '1'){
				$main_smarty->display($template_dir . '/admin/moderator.tpl');
			} else {
				$main_smarty->display($template_dir . '/admin/admin.tpl');
			}

			fclose($handle);

		} else {
			$main_smarty->assign('errorText', "The file $blacklist is not writable");
			$main_smarty->assign('tpl_center', '/admin/domain_blacklist_add');
			if ($is_moderator == '1'){
				$main_smarty->display($template_dir . '/admin/moderator.tpl');
			} else {
				$main_smarty->display($template_dir . '/admin/admin.tpl');
			}
		}
	} elseif(isset($_REQUEST['dowhitelist'])){
		
		$domain = strtoupper(sanitize($_REQUEST['dowhitelist'], 3)) . "\n";
		if (is_writable($whitelist)) {
		   if (!$handle = fopen($whitelist, 'a')) {
				$main_smarty->assign('errorText', "Cannot open file ($whitelist)");
				$main_smarty->assign('tpl_center', '/admin/domain_whitelist_add');
				if ($is_moderator == '1'){
					$main_smarty->display($template_dir . '/admin/moderator.tpl');
				} else {
					$main_smarty->display($template_dir . '/admin/admin.tpl');
				}
				exit;
		   }
		   if (fwrite($handle, $domain) === FALSE) {
				$main_smarty->assign('errorText', "Cannot write to file ($whitelist)");
				$main_smarty->assign('tpl_center', '/admin/domain_blacklist_add');
				if ($is_moderator == '1'){
					$main_smarty->display($template_dir . '/admin/moderator.tpl');
				} else {
					$main_smarty->display($template_dir . '/admin/admin.tpl');
				}
				exit;
		   }

			$main_smarty->assign('domain', $domain);
			$main_smarty->assign('whitelist', $whitelist);
			$main_smarty->assign('storyurl', getmyurl("story", $id));
			$main_smarty->assign('errorText', "The domain $domain has been added to the Whitelist file $whitelist <META http-equiv='refresh' content='1;URL=domain_management.php'> ");
			$main_smarty->assign('tpl_center', '/admin/domain_management');
			if ($is_moderator == '1'){
				$main_smarty->display($template_dir . '/admin/moderator.tpl');
			} else {
				$main_smarty->display($template_dir . '/admin/admin.tpl');
			}

			fclose($handle);

		} else {
			$main_smarty->assign('errorText', "The file $whitelist is not writable");
			$main_smarty->assign('tpl_center', '/admin/domain_whitelist_add');
			if ($is_moderator == '1'){
				$main_smarty->display($template_dir . '/admin/moderator.tpl');
			} else {
				$main_smarty->display($template_dir . '/admin/admin.tpl');
			}
		}
	} else {
		// Default Manage Domains page
		$main_smarty->assign('tpl_center', '/admin/domain_management');
		if ($is_moderator == '1'){
			$main_smarty->display($template_dir . '/admin/moderator.tpl');
		} else {
			$main_smarty->display($template_dir . '/admin/admin.tpl');
		}
	}
} else {
	// You need to login as an admin
	header("Location: " . getmyurl('admin_login', $_SERVER['REQUEST_URI']));
}
?>
