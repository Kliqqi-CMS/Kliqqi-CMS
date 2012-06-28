<?php
if(defined('mnminclude')){
	include_once('admin_snippet_settings.php');

	// tell pligg what pages this modules should be included in
	// pages are <script name> minus .php
	// index.php becomes 'index' and upcoming.php becomes 'upcoming'
	$do_not_include_in_pages = array();

	$include_in_pages = array('all');
	if( do_we_load_module() ) {		
		module_add_action_tpl('tpl_header_admin_main_links', admin_snippet_tpl_path . 'admin_snippet_admin_main_link.tpl');
		module_add_action('lib_link_summary_fill_smarty', 'admin_snippet_fill_smarty', '');
		include_once(mnmmodules . 'admin_snippet/admin_snippet_main.php');

		// Add templates for all existing snippets
		$snippet_actions_tpl = array();
		$snippets = $db->get_results("SELECT * FROM ".table_prefix."snippets ORDER BY snippet_location, snippet_order");
		$oldloc = '';
		if (is_array($snippets))
			foreach ($snippets as $snippet)
			{
			    if ($oldloc != $snippet->snippet_location)
			    {
				module_add_action_tpl($snippet->snippet_location, admin_snippet_tpl_path . 'admin_snippet_eval.tpl');
				$oldloc = $snippet->snippet_location;
			    }
			    $snippet_actions_tpl[] = (array)$snippet;
			}
		// Set entire list to smarty for eval template
		if(is_object($main_smarty))
			$main_smarty->assign("snippet_actions_tpl",(array)$snippet_actions_tpl);
	}
	
	$include_in_pages = array('module');
	if( do_we_load_module() ) {		

		$moduleName = $_REQUEST['module'];

		if($moduleName == 'admin_snippet'){
			module_add_action('module_page', 'admin_snippet_showpage', '');
		
			include_once(mnmmodules . 'admin_snippet/admin_snippet_main.php');
		}
	}
}
?>