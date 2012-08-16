<?php
//
// Settings page
//
function redc_showpage(){
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
			misc_data_update('redc_white_black', trim(sanitize($_REQUEST['redc_white_black'], 3)));
			misc_data_update('redc_list', trim(sanitize($_REQUEST['redc_list'], 3)));

#			$main_smarty->assign('error', $error);
		}
		// breadcrumbs
			$navwhere['text1'] = $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel');
			$navwhere['link1'] = getmyurl('admin', '');
			$navwhere['text2'] = "Modify redc";
			$navwhere['link2'] = my_pligg_base . "/module.php?module=redc";
			$main_smarty->assign('navbar_where', $navwhere);
			$main_smarty->assign('posttitle', " / " . $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel'));
		// breadcrumbs
		define('modulename', 'redc'); 
		$main_smarty->assign('modulename', modulename);
		
		define('pagename', 'admin_modify_redc'); 
		$main_smarty->assign('pagename', pagename);
		$main_smarty->assign('settings', get_redc_settings());
		$main_smarty->assign('tpl_center', redc_tpl_path . 'redc_main');
		$main_smarty->display($template_dir . '/admin/admin.tpl');
	}
	else
	{
		header("Location: " . getmyurl('login', $_SERVER['REQUEST_URI']));
	}
}	

function redc_check_errors(&$vars){
	global $main_smarty, $the_template, $module_actions;

	$settings = get_redc_settings();

	$email = strtolower($vars['email']);
	$list = preg_split('/\s+/',strtolower($settings['list']),-1,PREG_SPLIT_NO_EMPTY);
	if ($settings['white_black']=='white')
	{
	    foreach ($list as $domain)
		if (strrpos($email,$domain)===strlen($email)-strlen($domain))
		    return;

	    $error = true;
	}
 	else
	{
	    foreach ($list as $domain)
		if (strrpos($email,$domain)===strlen($email)-strlen($domain))
		    $error = true;
	}

	if ($error)
	{
		// Show email field + captcha only
		define('pagename', 'register'); 
		$main_smarty->assign('pagename', pagename);

		$main_smarty = do_sidebar($main_smarty);

		chdir(mnmpath);
		$vars = '';
		foreach ( $module_actions['register_showform'] as $kk => $vv ) 
		    if (strpos($kk,'captcha_')===0)
			call_user_func_array($kk, array(&$vars));

		if (preg_match('/@(.+)$/',$email,$m))
		$main_smarty->assign('domain', $m[1]);    
		$main_smarty->assign('tpl_center', redc_tpl_path . '/redc_register');    
		$main_smarty->display($the_template . '/pligg.tpl');
		exit;
	}
}

function redc_check_field(&$vars){
	global $main_smarty, $the_template;

	$settings = get_redc_settings();

	$email = strtolower($vars['email']);
	$list = preg_split('/\s+/',strtolower($settings['list']),-1,PREG_SPLIT_NO_EMPTY);
	if ($settings['white_black']=='white')
	{
	    foreach ($list as $domain)
		if (strrpos($email,$domain)===strlen($email)-strlen($domain))
		    return;

	    $vars['error'] = "Forbidden Domain";
	}
 	else
	{
	    foreach ($list as $domain)
		if (strrpos($email,$domain)===strlen($email)-strlen($domain))
		    $vars['error'] = "Forbidden Domain";
	}
}

// 
// Read module settings
//
function get_redc_settings()
{
    return array(
		'white_black' => get_misc_data('redc_white_black'), 
		'list' => get_misc_data('redc_list')
		);
}

?>