<?php
	// do not load any of the modules on these pages
		$do_not_include_in_pages_core[] = 'jspath';
		$do_not_include_in_pages_core[] = 'xmlhttp';
		$do_not_include_in_pages_core[] = 'install';
		$do_not_include_in_pages_core[] = 'install2';
		$do_not_include_in_pages_core[] = 'install3';
		$do_not_include_in_pages_core[] = 'upgrade';
		$do_not_include_in_pages_core[] = 'modules_manage'; // we don't want a new module to break this page
	//
	if(!defined('mnmmodules')){die();}
	$module_actions=array();
	include_once(mnmmodules . 'modules_libs.php');

	// find out what page we are on
	$pos = strrpos($_SERVER["SCRIPT_NAME"], "/");
	$script_name = substr($_SERVER["SCRIPT_NAME"], $pos + 1, 100);
	$script_name = str_replace(".php", "", $script_name);

	if (!in_array($script_name, $do_not_include_in_pages_core)) {
		// get a list of all installed / enabled modules

		if(caching == 1){
			$db->cache_dir = mnmpath.'cache';
			$db->use_disk_cache = true;
			$db->cache_queries = true;
		}

		// if this query is changed, be sure to also change it in admin_modules_center.tpl
		$db->cache_queries = false;
		$modules = $db->get_results($sql='SELECT * from ' . table_modules . ' where enabled=1;');

		if($modules){
			// for each module...
			foreach($modules as $module) {
				$file=mnmmodules . $module->folder . '/' . $module->folder . '_init.php';
				// if this module has an init file then include it
				if (file_exists($file)) {		include_once($file);	}
			}
		}
	}

	function do_we_load_module() {
		// this function is typically called in the <mymodule>_init file.
		
		global $script_name, $include_in_pages, $do_not_include_in_pages, $do_not_include_in_pages_core;
		
		// by default we don't load the module
		$doit = 0;
	
		if(is_array($include_in_pages)){
			// if the module is set to be included on the page we're viewing
			// or the module is set to be included on "all" pages
			if (in_array($script_name, $include_in_pages) || in_array('all', $include_in_pages)) {
				$doit = 1;
			}
		}		
		if(is_array($do_not_include_in_pages)){
			// if page we're viewing is on the modules do_not_include list
			if (in_array($script_name, $do_not_include_in_pages)) {
				$doit = 0;
			}
		}	
		// if the page we're viewing is on the core do_not_include list
		if (in_array($script_name, $do_not_include_in_pages_core)) {
			$doit = 0;
		}			

	return $doit;
	}

?>