<?php

include_once('internal/Smarty.class.php');
$main_smarty = new Smarty;

include('config.php');
include(mnminclude.'html1.php');
include(mnminclude.'link.php');
include(mnminclude.'smartyvariables.php');
include_once(mnminclude.'user.php');

$user=$_GET['user'];

$usr = new User();
$usr->username = $user;
if ($usr->read()){
	$email = $usr->email;
}

// pagename
define('pagename', 'register_complete'); 
$main_smarty->assign('pagename', pagename);

$main_smarty = do_sidebar($main_smarty, $navwhere);
$main_smarty->assign('tpl_center', $the_template . '/register_complete_center');
$main_smarty->display($the_template . '/pligg.tpl');
?>