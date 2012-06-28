<?php
$widget['widget_title'] = "Akismet Anti-Spam";
$widget['widget_has_settings'] = 1;
$widget['widget_shrink_icon'] = 1;
$widget['widget_uninstall_icon'] = 0;
$widget['name'] = 'Akismet';
$widget['desc'] = 'Akismet Anti-Spam Module';
$widget['homepage_url'] = '';
$widget['version'] = 0.1;
	
$wordpress_key = get_misc_data('wordpress_key');
if ($_REQUEST['widget']=='akismet')
{
    if(isset($_REQUEST['key']))
	$wordpress_key = sanitize($_REQUEST['key'], 3);
    else	
	$wordpress_key='';
    misc_data_update('wordpress_key', $wordpress_key);
}

if ($main_smarty)
{
    $main_smarty->assign('wordpress_key', $wordpress_key);

    if (function_exists('akismet_get_link_count')){
		$count1 = akismet_get_link_count();
		$count2 = akismet_get_comment_count();
		$main_smarty->assign('spam_links_count', $count1);
		$main_smarty->assign('spam_comments_count', $count2);
		if ($count1==0 && $count2==0){
			$widget['column'] = '';
		}
    } else {
	    $widget['column'] = '';
    }
}

?>
