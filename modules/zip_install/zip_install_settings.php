<?php

/**
* License GNU/LGPL
* @package Zip_Install
* @copyright (C) 2007 EXP Team
* @url http://www.pliggtemplates.eu/
* @author XrByte <info@exp.ee>, Grusha <grusha@feellove.eu>
**/

// the path to the module. the probably shouldn't be changed unless you rename the exp_gallery folder(s)
define('zip_install_path', my_pligg_base . '/modules/zip_install/');

define('zip_install_tpl_path', '../modules/zip_install/templates/');
define('zip_install_lib_path', '../modules/zip_install/lib/');

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

define('zip_install_lang_conf', lang_loc . '/modules/zip_install/lang.conf');
define('zip_install_pligg_lang_conf', lang_loc . "/languages/lang_" . pligg_language . ".conf");
   
   $path = getcwd();
   if (preg_match("/\/modules/i", "$path"))
	   $abspath = str_replace('/modules',"",$path);
   else
	   $abspath = str_replace('\modules',"",$path);
  
define('zip_install_absolute_path', $abspath."/");

if(is_object($main_smarty))
{
   $main_smarty->assign('zip_install_path', zip_install_path);
   $main_smarty->assign('zip_install_lang_conf', zip_install_lang_conf);
   $main_smarty->assign('zip_install_tpl_path', zip_install_tpl_path);
   $main_smarty->assign('zip_install_lib_path', zip_install_lib_path);
}

?>