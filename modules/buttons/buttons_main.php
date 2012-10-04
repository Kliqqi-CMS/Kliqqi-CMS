<?php
//
// Settings page
//
function buttons_showpage(){
	global $db, $main_smarty, $the_template;
		
	include_once('config.php');
	include_once(mnminclude.'html1.php');
	include_once(mnminclude.'link.php');
	include_once(mnminclude.'tags.php');
	include_once(mnminclude.'smartyvariables.php');
	
	$main_smarty = do_sidebar($main_smarty);

	force_authentication();
	$canIhaveAccess = 0;
	$canIhaveAccess = $canIhaveAccess + checklevel('admin');
	
	if($canIhaveAccess == 1)
	{	
		// Save settings
		if ($_POST['submit'])
		{
			misc_data_update('buttons_large_height', sanitize($_REQUEST['buttons_large_height'], 3));
			misc_data_update('buttons_large_width', sanitize($_REQUEST['buttons_large_width'], 3));
			misc_data_update('buttons_large_back', sanitize($_REQUEST['buttons_large_back'], 3));
			misc_data_update('buttons_large_image', sanitize($_REQUEST['buttons_large_image'], 3));
			misc_data_update('buttons_small_height', sanitize($_REQUEST['buttons_small_height'], 3));
			misc_data_update('buttons_small_width', sanitize($_REQUEST['buttons_small_width'], 3));
			misc_data_update('buttons_small_back', sanitize($_REQUEST['buttons_small_back'], 3));
			misc_data_update('buttons_small_image', sanitize($_REQUEST['buttons_small_image'], 3));
			misc_data_update('buttons_css', sanitize($_REQUEST['buttons_css'], 3));

#			unlink('cache/evb.css');
			file_put_contents('cache/evb.css',sanitize($_REQUEST['buttons_css'], 3));
			@mkdir('cache/images');
			@copy('modules/buttons/images/large_background.png', 'cache/images/large_background.png');
			@copy('modules/buttons/images/large_buttons.png', 'cache/images/large_buttons.png');
			@copy('modules/buttons/images/small_background.png', 'cache/images/small_background.png');
			@copy('modules/buttons/images/small_buttons.png', 'cache/images/small_buttons.png');

#			$main_smarty->assign('error', $error);
		}
		// breadcrumbs
		$navwhere['text1'] = $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel');
		$navwhere['link1'] = getmyurl('admin', '');
		$navwhere['text2'] = "Modify buttons";
		$navwhere['link2'] = my_pligg_base . "/module.php?module=buttons";
		$main_smarty->assign('navbar_where', $navwhere);
		$main_smarty->assign('posttitle', " / " . $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel'));
		
		define('modulename', 'buttons'); 
		$main_smarty->assign('modulename', modulename);
		define('pagename', 'admin_modify_buttons'); 
		$main_smarty->assign('pagename', pagename);
		
		$main_smarty->assign('settings', str_replace('"','&#034;',get_buttons_settings()));
		$main_smarty->assign('tpl_center', buttons_tpl_path . 'buttons_main');
		$main_smarty->display($template_dir . '/admin/admin.tpl');
	}
	else
	{
		header("Location: " . getmyurl('login', $_SERVER['REQUEST_URI']));
	}
}	

// 
// Read module settings
//
function get_buttons_settings()
{
    return array(
		'large_height' => get_misc_data('buttons_large_height'), 
		'large_width' => get_misc_data('buttons_large_width'), 
		'large_back' => get_misc_data('buttons_large_back'), 
		'large_image' => get_misc_data('buttons_large_image'), 
		'small_height' => get_misc_data('buttons_small_height'), 
		'small_width' => get_misc_data('buttons_small_width'), 
		'small_back' => get_misc_data('buttons_small_back'), 
		'small_image' => get_misc_data('buttons_small_image'),
		'css' => get_misc_data('buttons_css') ? get_misc_data('buttons_css') : file_get_contents('modules/buttons/evb.css')
		);
}

?>