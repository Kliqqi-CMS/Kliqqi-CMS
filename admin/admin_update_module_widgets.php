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
	header("Location: " . getmyurl('admin_login', $_SERVER['REQUEST_URI']));
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
	$action 				= mysql_real_escape_string($_POST['action']);
	$updateRecordsArray 	= $_POST['recordsArray'];
	if ($action == "updateRecordsListings"){
		$listingCounter = 1;
		foreach ($updateRecordsArray as $recordIDValue) {
			$query = "UPDATE " .table_modules. " SET weight = " . $listingCounter . " WHERE id = " . $recordIDValue;
			mysql_query($query) or die('Error, insert query failed');
			$listingCounter = $listingCounter + 1;
		}
	}

}

?>