<?php

// the path to the module. the probably shouldn't be changed unless you rename the admin_snippet folder(s)
define('admin_snippet_path', my_pligg_base . '/modules/admin_snippet/');

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

define('admin_snippet_lang_conf', lang_loc . '/modules/admin_snippet/lang.conf');
define('admin_snippet_pligg_lang_conf', lang_loc . "/languages/lang_" . pligg_language . ".conf");

// the path to the modules templates. the probably shouldn't be changed unless you rename the admin_snippet folder(s)
define('admin_snippet_tpl_path', '../modules/admin_snippet/templates/');

// Hooks list
$locations = array(
array("tpl_pligg_head_start","After &lt;head&gt; tag"),
array("tpl_pligg_head_end","Before &lt;/head&gt; tag"),
array("tpl_pligg_body_start","After &lt;body&gt; tag"),
array("tpl_pligg_body_end","Before &lt;/body&gt; tag"),
array("tpl_pligg_login_link","Next to login link (when logged out)"),
array("tpl_pligg_navbar_start","Before main navigation link list"),
array("tpl_pligg_navbar_end","After main navigation link list"),
array("tpl_pligg_secondary_navbar_start","Before secondary navigation"),
array("tpl_pligg_secondary_navbar_end","After secondary navigation"),
array("tpl_pligg_banner_top","Before the main content area starts and after any navigation"),
array("tpl_pligg_banner_bottom","Between body content and footer"),
array("tpl_pligg_content_start","Top of the content area"),
array("tpl_pligg_content_end","Bottom of the content area"),
array("tpl_pligg_breadcrumb_end","End of the breadcrumbs"),
array("tpl_pligg_sort_start","Beginning of sort (day, week, month, etc.) buttons"),
array("tpl_pligg_sort_end","End of sort (day, week, month, etc.) buttons"),
array("tpl_pligg_profile_sort_start","Beginning of profile page sort buttons"),
array("tpl_pligg_profile_sort_end","End of profile page sort buttons"),
array("tpl_pligg_profile_start","Just after profile breadcrumbs"),
array("tpl_pligg_profile_end","After profile bookmarklet"),
array("tpl_pligg_profile_info_start","Before personal info"),
array("tpl_pligg_profile_info_middle","Between personal info and stats"),
array("tpl_pligg_profile_info_end","After user stats"),
array("tpl_pligg_profile_settings_start","Start of the User Settings page"),
array("tpl_pligg_profile_settings_end","End of the User Settings page"),
array("tpl_pligg_group_start","Before the Group avatar and information"),
array("tpl_pligg_group_end","After Group Information (before the group stories on group_stories.php)"),
array("tpl_pligg_group_list_start","After individual Group title"),
array("tpl_pligg_group_list_end","After individual Group Member number"),
array("tpl_pligg_group_sort_start","Start of Group Sort list"),
array("tpl_pligg_group_sort_start","End of Group Sort list"),
array("tpl_pligg_submit_step1_start","After Submit step 1 of 3"),
array("tpl_pligg_submit_step1_middle","After Submit step 1 guideline list"),
array("tpl_pligg_submit_step1_end","After Submit step 1 link field"),
array("tpl_pligg_submit_step2_start","After step 2 of 3"),
array("tpl_pligg_submit_step2_middle","Before Submit Step 2 description"),
array("tpl_pligg_submit_step2_end","After Submit Step 2 continue button"),
array("tpl_pligg_submit_step3_start","After step 3 of 3"),
array("tpl_pligg_submit_step3_end","After Submit Step 3 continue button"),
array("tpl_pligg_story_start","Very beginning of link_summary.tpl"),
array("tpl_pligg_story_end","Very end of link_summary.tpl"),
array("tpl_pligg_story_votebox_start","Before votebox"),
array("tpl_pligg_story_votebox_end","After votebox"),
array("tpl_pligg_story_title_start","Before title"),
array("tpl_pligg_story_title_end","After votebox"),
array("tpl_pligg_story_body_start","Before story body"),
array("tpl_pligg_story_body_end","After story body"),
array("tpl_pligg_story_tools_start","Before story tools"),
array("tpl_pligg_story_tools_end","After story tools"),
array("tpl_link_summary_admin_links","End of the story admin link tools"),
array("tpl_pligg_story_who_voted_start","Before who voted"),
array("tpl_pligg_story_who_voted_end","After who voted"),
array("tpl_pligg_story_related_start","Before related"),
array("tpl_pligg_story_related_end","After related"),
array("tpl_pligg_story_comments_start","Before comments"),
array("tpl_pligg_story_comments_end","After comments"),
array("tpl_pligg_story_comments_single_start","Before individual comment"),
array("tpl_pligg_story_comments_single_end","After individual comments"),
array("tpl_pligg_story_comments_submit_start","Before comment submit"),
array("tpl_pligg_story_comments_submit_end","After comment submit"),
array("tpl_pligg_sidebar_start","Start of sidebar"),
array("tpl_pligg_sidebar_end","End of sidebar"),
array("tpl_pligg_sidebar2_start","Start of second (optional) sidebar"),
array("tpl_pligg_sidebar2_end","End of second (optional) sidebar."),
array("tpl_pligg_sidebar3_start","Start of third (optional) sidebar."),
array("tpl_pligg_sidebar3_end","End of third (optional) sidebar."),
array("tpl_pligg_pagination_start","Before pagination"),
array("tpl_pligg_pagination_end","After pagination"),
array("tpl_pligg_footer_start","Beginning of footer"),
array("tpl_pligg_footer_end","End of footer"),
array("submit_step_2_pre_extrafields","Before Submit Step 2 Submit button"),
array("tpl_pligg_admin_head_start","After admin panel &lt;head&gt; tag"),
array("tpl_pligg_admin_head_end","Before admin panel &lt;/head&gt; tag"),
array("tpl_pligg_admin_breadcrumbs","After admin panel breadcrumbs"),
array("tpl_pligg_admin_body_start","After admin panel &lt;body&gt; tag"),
array("tpl_pligg_admin_body_end","Before admin panel &lt;/body&gt; tag"),
array("tpl_pligg_admin_sidebar_start","Beginning of admin sidebar"),
array("tpl_pligg_admin_sidebar_end","End of admin sidebar"),
array("tpl_pligg_admin_navtabs_start","Beginning of admin navigation tabs"),
array("tpl_pligg_admin_navtabs_end","End of admin navigation tabs"),
array("tpl_pligg_admin_legend_before","After admin &lt;legend&gt;"),
array("tpl_pligg_admin_legend_after","Before admin &lt;/legend&gt;"),
array("tpl_header_admin_main_links","In the main admin panel link list"),
array("tpl_header_admin_links","Admin panel navigation linksarray"),
array("tpl_pligg_register_start","Before registration form"),
array("tpl_pligg_register_end","After registration form"),
array("tpl_pligg_topusers_start","Beginning of Top users"),
array("tpl_pligg_topusers_end","End of Top users")
);

// don't touch anything past this line.

if(isset($main_smarty) && is_object($main_smarty)){
	$main_smarty->assign('admin_snippet_path', admin_snippet_path);
	$main_smarty->assign('admin_snippet_pligg_lang_conf', admin_snippet_pligg_lang_conf);
	$main_smarty->assign('admin_snippet_lang_conf', admin_snippet_lang_conf);
	$main_smarty->assign('admin_snippet_tpl_path', admin_snippet_tpl_path);
	$main_smarty->assign('admin_snippet_locations', $locations);
}

?>
