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
include(mnminclude.'link.php');
include(mnminclude.'tags.php');
include(mnminclude.'smartyvariables.php');

if(!Enable_Tags) {
	header("Location: $my_pligg_base/404error.php");
	die();
}

// breadcrumbs and page title
$navwhere['text1'] = $main_smarty->get_config_vars('PLIGG_Visual_Breadcrumb_Cloud');
$navwhere['link1'] = getmyurl('tagcloud', '');
$main_smarty->assign('navbar_where', $navwhere);
$main_smarty->assign('posttitle', $main_smarty->get_config_vars('PLIGG_Visual_Breadcrumb_Cloud'));
$main_smarty = do_sidebar($main_smarty);

// put the names of the tabs in an array for the tag cloud tpl file
$range_names  = array($main_smarty->get_config_vars('PLIGG_Visual_Tags_All'), $main_smarty->get_config_vars('PLIGG_Visual_Tags_48_Hours'), $main_smarty->get_config_vars('PLIGG_Visual_Tags_This_Week'), $main_smarty->get_config_vars('PLIGG_Visual_Tags_This_Month'), $main_smarty->get_config_vars('PLIGG_Visual_Tags_This_Year'));
// give each name a value
$range_values = array(0, 172800, 604800, 2592000, 31536000);

// show the tag cloud
$cloud=new TagCloud();
$cloud->smarty_variable = $main_smarty; // pass smarty to the function so we can set some variables
$cloud->range_values = $range_values;
if(isset($_GET['categoryID']) && is_numeric($_GET['categoryID'])){$cloud->filterCategory = $_GET['categoryID'];}
$cloud->show();
$main_smarty = $cloud->smarty_variable; // get the updated smarty back from the function

// give smarty data for the links to filter by time
if(!($current_range = check_integer('range')) || $current_range < 1 || $current_range >= count($range_values)) $current_range = 0;

// misc smarty
$main_smarty->assign('current_range', $current_range);
$main_smarty->assign('range_names', $range_names);
$main_smarty->assign('range_values', $range_values);
$main_smarty->assign('count_range_values', count($range_values));

// pagename
define('pagename', 'cloud'); 
$main_smarty->assign('pagename', pagename);

// show the template
$main_smarty->assign('tpl_center', $the_template . '/tag_cloud_center');
$main_smarty->display($the_template . '/pligg.tpl');

?>