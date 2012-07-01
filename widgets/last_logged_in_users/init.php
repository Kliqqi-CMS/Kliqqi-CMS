<?php
////////////////////////////////////////////////////////////////////
$widget['widget_title'] = "Last Logged in Users";
$widget['widget_has_settings'] = 1;
$widget['widget_shrink_icon'] = 1;
$widget['widget_uninstall_icon'] = 1;
$widget['name'] = 'Last Logged in Users';
$widget['desc'] = 'Shows the latest signed users.';
$widget['version'] = 1.0;
$widget['homepage_url'] = '';
////////////////////////////////////////////////////////////////////

// Fetch Size
$limit_size = get_misc_data('limit_size');

if ($_REQUEST['widget']=='setting_limit'){
    if(isset($_REQUEST['limit_size'])){
		$limit_size = sanitize($_REQUEST['limit_size'], 3);
		// Shorten size to 5 digits
		$limit_size = substr($limit_size,0,5);
		// Making sure that the user is inserting a numerical value
		if (!is_numeric($limit_size)){
			die ("Please enter a correct amount of users to show.");
		}
	}
	// Write the size to database
	misc_data_update('limit_size', $limit_size);
}

// Assign smarty tags for limit, so that they can be used in tpl files
if ($main_smarty){
    $main_smarty->assign('limit_size', $limit_size);
}

?>