<?php

// the path to the module. the probably shouldn't be changed unless you rename the captcha folder(s)
define('captcha_path', my_pligg_base . '/modules/captcha/');

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

define('captcha_lang_conf', lang_loc . '/modules/captcha/lang.conf');
define('captcha_pligg_lang_conf', lang_loc . "/languages/lang_" . pligg_language . ".conf");

// the path to the modules templates. the probably shouldn't be changed unless you rename the captcha folder(s)
define('captcha_tpl_path', '../modules/captcha/templates/');

// the path to the modules libraries. the probably shouldn't be changed unless you rename the captcha folder(s)
define('captcha_lib_path', './modules/captcha/libs/');

// the path to the captchas. the probably shouldn't be changed unless you rename the captcha folder(s)
define('captcha_captchas_path', './modules/captcha/captchas/');

// the path to the images. the probably shouldn't be changed unless you rename the captcha folder(s)
define('captcha_img_path',  my_pligg_base . '/modules/captcha/images/');

$captcha_single_step = (get_misc_data('reg_single_step') == '') ? false : get_misc_data('reg_single_step');
$captcha_single_step = ($captcha_single_step == 'true') ? true : false;
define('captcha_single_step', $captcha_single_step);

$captcha_reg_enabled = (get_misc_data('captcha_reg_en') == '') ? true : get_misc_data('captcha_reg_en');
$captcha_reg_enabled = ($captcha_reg_enabled == 'true') ? true : false;
define('captcha_reg_enabled', $captcha_reg_enabled);
$captcha_story_enabled = (get_misc_data('captcha_story_en') == '') ? true : get_misc_data('captcha_story_en');
$captcha_story_enabled = ($captcha_story_enabled == 'true') ? true : false;
define('captcha_story_enabled', $captcha_story_enabled);
$captcha_comment_enabled = (get_misc_data('captcha_comment_en') == '') ? true : get_misc_data('captcha_comment_en');
$captcha_comment_enabled = ($captcha_comment_enabled == 'true') ? true : false;
define('captcha_comment_enabled', $captcha_comment_enabled);

define('URL_captcha', './module.php?module=captcha');

$captcha_registered = false;
$captcha_checked = false;

// don't touch anything past this line.

if(isset($main_smarty) && is_object($main_smarty)){
	$main_smarty->assign('captcha_path', captcha_path);
	$main_smarty->assign('captcha_pligg_lang_conf', captcha_pligg_lang_conf);
	$main_smarty->assign('captcha_lang_conf', captcha_lang_conf);
	$main_smarty->assign('captcha_tpl_path', captcha_tpl_path);
	$main_smarty->assign('captcha_lib_path', captcha_lib_path);
	$main_smarty->assign('captcha_img_path', captcha_img_path);
	$main_smarty->assign('captcha_captchas_path', captcha_captchas_path);
	$main_smarty->assign('captcha_single_step_reg', captcha_single_step);
	$main_smarty->assign('captcha_reg_enabled', captcha_reg_enabled);
	$main_smarty->assign('captcha_story_enabled', captcha_story_enabled);
	$main_smarty->assign('captcha_comment_enabled', captcha_comment_enabled);

	$main_smarty->assign('URL_captcha', URL_captcha);
}

?>
