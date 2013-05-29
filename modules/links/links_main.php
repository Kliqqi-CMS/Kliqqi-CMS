<?php
function links_show_comment_content(&$vars)
{
	if (get_misc_data('links_comments'))
	    $vars['comment_text'] = text_to_html($vars['comment_text']);
	if (get_misc_data('links_nofollow'))
	    $vars['comment_text'] = preg_replace('/<a ([^>]+)>/i','<a rel="nofollow" $1>',$vars['comment_text']);
}

function links_summary_fill_smarty(&$vars)
{
	if (get_misc_data('links_stories'))
	    $vars['smarty']->_vars['story_content'] = text_to_html($vars['smarty']->_vars['story_content']);
	if (get_misc_data('links_nofollow'))
	    $vars['smarty']->_vars['story_content'] = preg_replace('/<a ([^>]+)>/i','<a rel="nofollow" $1>',$vars['smarty']->_vars['story_content']);
}

// 
// Read module settings
//
function links_settings()
{
    return array(
		'comments' => get_misc_data('links_comments'),
		'stories' => get_misc_data('links_stories'),
		'nofollow' => get_misc_data('links_nofollow'),
		);
}

//
// Settings page
//
function links_showpage(){
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
		if ($_POST['submit'])
		{
			misc_data_update('links_comments', sanitize($_REQUEST['links_comments'], 3));
			misc_data_update('links_stories', sanitize($_REQUEST['links_stories'], 3));
			misc_data_update('links_nofollow', sanitize($_REQUEST['links_nofollow'], 3));
			misc_data_update('links_host', sanitize($_REQUEST['links_host'], 3));
			header("Location: ".my_pligg_base."/module.php?module=links");
			die();
		}
		// breadcrumbs
		$main_smarty->assign('navbar_where', $navwhere);
		$main_smarty->assign('posttitle', " / " . $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel'));
		// breadcrumbs
		define('modulename', 'links'); 
		$main_smarty->assign('modulename', modulename);
		
		define('pagename', 'admin_modifylinks'); 
		$main_smarty->assign('pagename', pagename);

		$main_smarty->assign('settings', links_settings());
		$main_smarty->assign('tpl_center', links_tpl_path . 'links_main');
		$main_smarty->display($template_dir . '/admin/admin.tpl');
	}
	else
	{
		header("Location: " . getmyurl('login', $_SERVER['REQUEST_URI']));
	}
}	

?>
