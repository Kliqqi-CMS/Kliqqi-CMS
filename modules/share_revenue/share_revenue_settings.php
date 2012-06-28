<?php

// the path to the module. the probably shouldn't be changed unless you rename the share_revenue folder(s)
define('share_revenue_path', my_pligg_base . '/modules/share_revenue/');
// the path to the module. the probably shouldn't be changed unless you rename the share_revenue folder(s)
define('share_revenue_lang_conf', '/modules/share_revenue/lang.conf');
// the path to the modules templates. the probably shouldn't be changed unless you rename the share_revenue folder(s)
define('share_revenue_tpl_path', '../modules/share_revenue/templates/');
// the path for smarty / template lite plugins
define('share_revenue_plugins_path', '../modules/share_revenue/plugins');

$users_extra_fields_field[]=array(
	'name' => 'google_adsense_id',
	'show_to_user' => true,
	'show_to_user_text' => 'google adsense ID:',
	'show_to_user_text_2' => '<em>begins with: pub-</em>',
	'show_to_admin' => false,
	'editby_user' => true,
	'editby_admin' => true,
	);


$users_extra_fields_field[]=array(
	'name' => 'google_adsense_channel',
	'show_to_user_text' => 'adsense channel (optional):',
	'show_to_user_text_2' => '<em>numerical value</em>',
	'show_to_user' => true,
	'show_to_admin' => false,
	'editby_user' => true,
	'editby_admin' => true,
	);

$users_extra_fields_field[]=array(
	'name' => 'google_adsense_percent',
	'show_to_admin_text' => 'Adsense Revenue Share %: ',
	'show_to_user' => false,
	'show_to_admin' => true,
	'editby_user' => false,
	'editby_admin' => true,
	);


// don't touch anything past this line.

if(is_object($main_smarty)){
	$main_smarty->assign('share_revenue_path', share_revenue_path);
	$main_smarty->assign('share_revenue_lang_conf', share_revenue_lang_conf);
	$main_smarty->assign('share_revenue_tpl_path', share_revenue_tpl_path);
}

?>