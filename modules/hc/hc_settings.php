<?php

// the path to the module. the probably shouldn't be changed unless you rename the hc folder(s)
define('hc_path', my_pligg_base . '/modules/hc/');

// the language path for the module
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

define('hc_lang_conf', lang_loc . '/modules/hc/lang.conf');
define('hc_pligg_lang_conf', lang_loc . "/languages/lang_" . pligg_language . ".conf");

// the path to the modules templates. the probably shouldn't be changed unless you rename the hc folder(s)
define('hc_tpl_path', '../modules/hc/templates/');

// the path to the modules libraries. the probably shouldn't be changed unless you rename the hc folder(s)
define('hc_lib_path', './modules/hc/libs/');

// the path to the hcs. the probably shouldn't be changed unless you rename the hc folder(s)
define('hc_hcs_path', './modules/hc/');

// the path to the images. the probably shouldn't be changed unless you rename the hc folder(s)
define('hc_img_path',  my_pligg_base . '/modules/hc/images/');

$hc_single_step = (get_misc_data('reg_single_step') == '') ? false : get_misc_data('reg_single_step');
$hc_single_step = ($hc_single_step == 'true') ? true : false;
define('hc_single_step', $hc_single_step);

$hc_reg_enabled = (get_misc_data('hc_reg_en') == '') ? true : get_misc_data('hc_reg_en');
$hc_reg_enabled = ($hc_reg_enabled == 'true') ? true : false;
define('hc_reg_enabled', $hc_reg_enabled);
$hc_story_enabled = (get_misc_data('hc_story_en') == '') ? true : get_misc_data('hc_story_en');
$hc_story_enabled = ($hc_story_enabled == 'true') ? true : false;
define('hc_story_enabled', $hc_story_enabled);
$hc_comment_enabled = (get_misc_data('hc_comment_en') == '') ? true : get_misc_data('hc_comment_en');
$hc_comment_enabled = ($hc_comment_enabled == 'true') ? true : false;
define('hc_comment_enabled', $hc_comment_enabled);

define('URL_hc', './module.php?module=hc');

$hc_registered = false;
$hc_checked = false;

// don't touch anything past this line.

if(isset($main_smarty) && is_object($main_smarty)){
	$main_smarty->assign('hc_path', hc_path);
	$main_smarty->assign('hc_pligg_lang_conf', hc_pligg_lang_conf);
	$main_smarty->assign('hc_lang_conf', hc_lang_conf);
	$main_smarty->assign('hc_tpl_path', hc_tpl_path);
	$main_smarty->assign('hc_lib_path', hc_lib_path);
	$main_smarty->assign('hc_img_path', hc_img_path);
	$main_smarty->assign('hc_hcs_path', hc_hcs_path);
	$main_smarty->assign('hc_single_step_reg', hc_single_step);
	$main_smarty->assign('hc_reg_enabled', hc_reg_enabled);
	$main_smarty->assign('hc_story_enabled', hc_story_enabled);
	$main_smarty->assign('hc_comment_enabled', hc_comment_enabled);

	$main_smarty->assign('URL_hc', URL_hc);
}

?>
