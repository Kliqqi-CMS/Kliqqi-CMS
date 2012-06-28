<?php
// The source code packaged with this file is Free Software, Copyright (C) 2005 by
// Ricardo Galli <gallir at uib dot es>.
// It's licensed under the AFFERO GENERAL PUBLIC LICENSE unless stated otherwise.
// You can get copies of the licenses here:
// 		http://www.affero.org/oagpl.html
// AFFERO GENERAL PUBLIC LICENSE is also included in the file called "COPYING".

include_once('Smarty.class.php');
$main_smarty = new Smarty;

include('config.php');
include(mnminclude.'html1.php');
include(mnminclude.'smartyvariables.php');

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

// show the template
$main_smarty->assign('tpl_center', $the_template . '/live_center');
$main_smarty->display($the_template . '/pligg.tpl');
$main_smarty->display($the_template . '/live_js.tpl');
?>
