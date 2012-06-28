<?php

// the path to the module. the probably shouldn't be changed unless you rename the akismet folder(s)
define('akismet_path', my_pligg_base . '/modules/akismet/');

// the path to the module. the probably shouldn't be changed unless you rename the module_store folder(s)
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
	
define('akismet_lang_conf', lang_loc . '/modules/akismet/lang.conf');
define('akismet_pligg_lang_conf', lang_loc . "/languages/lang_" . pligg_language . ".conf");

// the path to the modules templates. the probably shouldn't be changed unless you rename the akismet folder(s)
define('akismet_tpl_path', '../modules/akismet/templates/');

// the path to the modules libraries. the probably shouldn't be changed unless you rename the akismet folder(s)
define('akismet_lib_path', './modules/akismet/libs/');

// the path to the images. the probably shouldn't be changed unless you rename the akismet folder(s)
define('akismet_img_path', my_pligg_base . '/modules/akismet/images/');

define('URL_akismet', my_pligg_base.'/module.php?module=akismet');
define('URL_akismet_isSpam', my_pligg_base.'/module.php?module=akismet&view=isSpam&link_id=');
define('URL_akismet_isSpamcomment', 'module.php?module=akismet&view=isSpamcomment');

// don't touch anything past this line.

if(isset($main_smarty) && is_object($main_smarty)){
	$main_smarty->assign('akismet_path', akismet_path);
	$main_smarty->assign('akismet_lang_conf', akismet_lang_conf);
	$main_smarty->assign('akismet_pligg_lang_conf', akismet_pligg_lang_conf);
	$main_smarty->assign('akismet_tpl_path', akismet_tpl_path);
	$main_smarty->assign('akismet_lib_path', akismet_lib_path);
	$main_smarty->assign('akismet_img_path', akismet_img_path);

	$main_smarty->assign('URL_akismet', URL_akismet);
	$main_smarty->assign('URL_akismet_isSpam', URL_akismet_isSpam);
	$main_smarty->assign('URL_akismet_isSpamcomment', URL_akismet_isSpamcomment);
}

?>
