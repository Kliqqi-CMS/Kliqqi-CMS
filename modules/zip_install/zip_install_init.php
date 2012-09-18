<?php
/**
 * License GNU/LGPL
 * @package Zip_Install
 * @copyright (C) 2007 EXP Team
 * @url http://www.pliggtemplates.eu/
 * @author XrByte <info@exp.ee>, Grusha <grusha@feellove.eu>
**/

if(defined('mnminclude')){
	include_once('zip_install_settings.php');

	// tell pligg what pages this modules should be included in
	// pages are <script name> minus .php
	// index.php becomes 'index' and shakeit.php becomes 'shakeit'
	$do_not_include_in_pages = array();

	$include_in_pages = array('all');
	if( do_we_load_module() ) {		
		module_add_action_tpl('tpl_header_admin_main_links', zip_install_tpl_path . 'zip_install_admin_main_link.tpl');
	}
	

	$include_in_pages = array('module');
	if( do_we_load_module() ) {		

		$moduleName = $_REQUEST['module'];

		if($moduleName == 'zip_install'){

			module_add_action('module_page', 'zip_install_preview_admin', '');
		
			include_once(mnmmodules . 'zip_install/zip_install_main.php');
		}
	}
}	
?>

