<?php
// the path to the module. the probably shouldn't be changed unless you rename the status folder(s)
define('status_path', my_pligg_base . '/modules/status/');

// the path to the module. the probably shouldn't be changed unless you rename the status folder(s)
	if(!defined('lang_loc')){
		// determine if we're in root or another folder like admin
			$pos = strrpos($_SERVER["SCRIPT_NAME"], "/");
			$path = substr($_SERVER["SCRIPT_NAME"], 0, $pos);
			if ($path == "/"){$path = "";}
			
			if($path != my_pligg_base){
				define('lang_loc', '..');
			} else {
				define('lang_loc', '.');
			}
	}

define('status_lang_conf', '/modules/status/lang.conf');
define('status_pligg_lang_conf', lang_loc . "/languages/lang_" . pligg_language . ".conf");

// the path to the modules templates. the probably shouldn't be changed unless you rename the status folder(s)
define('status_tpl_path', '../modules/status/templates/');

$status_places = array(
"tpl_pligg_profile_start",
"tpl_user_center_just_below_header",
"tpl_user_center",
"tpl_pligg_profile_settings_start",
"tpl_pligg_profile_settings_end",
"tpl_pligg_profile_info_start",
"tpl_show_extra_profile",
"tpl_pligg_profile_info_middle",
"tpl_pligg_profile_info_end",
"tpl_pligg_profile_end",
"tpl_pligg_banner_top",
"tpl_pligg_banner_bottom",
"tpl_pligg_content_start",
"tpl_pligg_above_center",
"tpl_pligg_below_center",
"tpl_pligg_content_end",
"tpl_pligg_pagination_start",
"tpl_pligg_pagination_end",
"tpl_pligg_custom_status"
);

// don't touch anything past this line.

if(isset($main_smarty) && is_object($main_smarty)){
	$main_smarty->assign('status_path', status_path);
	$main_smarty->assign('status_pligg_lang_conf', status_pligg_lang_conf);
	$main_smarty->assign('status_lang_conf', status_lang_conf);
	$main_smarty->assign('status_places', $status_places);
	$main_smarty->assign('status_tpl_path', status_tpl_path);
}

?>
