<?php
// The source code packaged with this file is Free Software, Copyright (C) 2005 by 	 
// The Pligg Team <pligger at pligg dot com>. 	 
// It's licensed under the AFFERO GENERAL PUBLIC LICENSE unless stated otherwise. 	 
// You can get copies of the licenses here: 	 
//              http://www.affero.org/oagpl.html 	 
// AFFERO GENERAL PUBLIC LICENSE is also included in the file called "COPYING".

include_once('Smarty.class.php');
$main_smarty = new Smarty;

require('class.rssimport.php'); 
require_once('modules/rss_import/magpierss/rss_fetch.inc');

define('MAGPIE_CACHE_DIR', 'cache/');

// breadcrumbs and page title
$navwhere['text1'] = $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel');
$navwhere['link1'] = getmyurl('admin', '');
$navwhere['text2'] = $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel_RSSImport');
$navwhere['link2'] = $my_pligg_base . '/admin_rss.php';
$navwhere['text3'] = $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel_RSSImport_Feeds');
$main_smarty->assign('navbar_where', $navwhere);
$main_smarty->assign('posttitle', ' / ' . $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel_RSSImport'));

// sidebar
$main_smarty = do_sidebar($main_smarty);

// show the template
$main_smarty->assign('tpl_center', '/modules/rss_import/templates/import_fields_center');
$main_smarty->display('/templates/admin/admin.tpl');

?>
