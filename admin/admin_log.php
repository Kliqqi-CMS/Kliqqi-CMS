<?php

include_once('../internal/Smarty.class.php');
$main_smarty = new Smarty;

include('../config.php');
include(mnminclude.'html1.php');
include(mnminclude.'smartyvariables.php');

check_referrer();

// require user to log in
force_authentication();

// restrict access to admins
$canIhaveAccess = 0;
$canIhaveAccess = $canIhaveAccess + checklevel('admin');

if($canIhaveAccess == 0){	
	header("Location: " . getmyurl('admin_login', $_SERVER['REQUEST_URI']));
	die();
}

if ($_GET['clear'])
{
    $fp = fopen('../'.LOG_FILE, "a");
    ftruncate($fp,0);
    fclose($fp);
    header("Location: admin_log.php");
    exit;
}

// pagename
define('pagename', 'admin_log'); 
$main_smarty->assign('pagename', pagename);

// show the template
$main_smarty->assign('tpl_center', '/admin/error_log');
$main_smarty->display($template_dir . '/admin/admin.tpl');

?>