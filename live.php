<?php

include_once('internal/Smarty.class.php');
$main_smarty = new Smarty;

include('config.php');
include(mnminclude.'html1.php');
include(mnminclude.'smartyvariables.php');

if(!Enable_Live) {
	header("Location: $my_pligg_base/error_404.php");
	die();
}

// breadcrumbs and page title
$navwhere['text1'] = $main_smarty->get_config_vars('PLIGG_Visual_Breadcrumb_Live');
$navwhere['link1'] = getmyurl('live', '');
$main_smarty->assign('navbar_where', $navwhere);
$main_smarty->assign('posttitle', $main_smarty->get_config_vars('PLIGG_Visual_Breadcrumb_Live'));
$main_smarty->assign('page_header', $main_smarty->get_config_vars('PLIGG_Visual_Breadcrumb_Live'));

$globals['body-args'] = 'onload="start()"';

// misc smarty
$main_smarty->assign('items_to_show', items_to_show);
$main_smarty->assign('showsideleftsidebar', "no");
$main_smarty->assign('showsiderightsidebar', "no");

// pagename
define('pagename', 'live'); 
$main_smarty->assign('pagename', pagename);

// sidebar
$main_smarty = do_sidebar($main_smarty);

// module system hook
$vars = '';
check_actions('live', $vars);

// misc smarty that has to come after do_sidebar
$main_smarty->assign('body_args', 'onload="start()"');

// restrict access to admins
$canIhaveAccess = 0;
$canIhaveAccess = $canIhaveAccess + checklevel('admin');
$canIhaveAccess = $canIhaveAccess + checklevel('moderator');
$main_smarty->assign('isAdmin', $canIhaveAccess);

// show the template
$main_smarty->assign('tpl_center', $the_template . '/live_center');
$main_smarty->display($the_template . '/pligg.tpl');
$main_smarty->display($the_template . '/functions/live_js.tpl');
?>