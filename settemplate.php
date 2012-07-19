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

check_referrer();

// breadcrumbs and page title
$navwhere['text1'] = $main_smarty->get_config_vars('PLIGG_Visual_Change_Template');
$navwhere['link1'] = getmyurl('profile', '');
$main_smarty->assign('navbar_where', $navwhere);
$main_smarty->assign('posttitle', $main_smarty->get_config_vars('PLIGG_Visual_Change_Template'));

// pagename
define('pagename', 'settemplate'); 
$main_smarty->assign('pagename', pagename);


if(isset($_GET['template'])){
	if(file_exists("./templates/".$_GET['template']."/link_summary.tpl")){
		$domain = !strstr($_SERVER['HTTP_HOST'],'.') ? '' : preg_replace('/^www/','',$_SERVER['HTTP_HOST']);
		setcookie("template", $_GET['template'], time()+60*60*24*30,$my_pligg_base,$domain);
		header('Location: ./index.php');
		die();
	}else{
		$main_smarty->assign('message', 'Warning: Template <b>"' . sanitize($_GET['template'],3) . '"</b> does not exist!');
	}
}

// show the template	
$main_smarty->assign('tpl_center', $the_template . '/settemplate_center');
$main_smarty->display($the_template . '/pligg.tpl');
?>