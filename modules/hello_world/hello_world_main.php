<?php


function hello_world_showpage(){
	global $main_smarty, $the_template, $db;

	force_authentication();
	$canIhaveAccess = 0;
	$canIhaveAccess = $canIhaveAccess + checklevel('god');
	
	if($canIhaveAccess == 1)
	{
		define('pagename', 'hello_world'); 
		$main_smarty->assign('pagename', pagename);
		
		// Method for identifying modules rather than pagename
		define('modulename', 'hello_world'); 
		$main_smarty->assign('modulename', modulename);

		$navwhere['text1'] = $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel');
		$navwhere['link1'] = getmyurl('admin', '');

		$main_smarty->display(hello_world_tpl_path . '/blank.tpl');
		
		$navwhere['text2'] = $main_smarty->get_config_vars('PLIGG_hello_world_BreadCrumb');
		$navwhere['link2'] = URL_hello_world;

		$navwhere['text3'] = '';
		$navwhere['link3'] = '';
		$navwhere['text4'] = '';
		$navwhere['link4'] = '';


		$main_smarty = do_sidebar($main_smarty);

		$main_smarty->assign('navbar_where', $navwhere);
		$main_smarty->assign('posttitle', " / " . $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel'));
		
		$main_smarty->assign('tpl_center', hello_world_tpl_path . 'hello_world_main');
		$main_smarty->display($template_dir . '/admin/admin.tpl');
	} else {
		header("Location: " . getmyurl('login', $_SERVER['REQUEST_URI']));
	}
}
?>