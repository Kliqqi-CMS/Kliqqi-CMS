<?php
	$module_info['name'] = 'Karma module';
	$module_info['desc'] = 'Configure the karma algorithms used to generate a karma scores';
	$module_info['version'] = 1.0;
	$module_info['homepage_url'] = 'http://pligg.com/downloads/module/karma/';
	$module_info['update_url'] = 'http://pligg.com/downloads/module/karma/version/';
	$module_info['settings_url'] = '../module.php?module=karma';
	// this is where you set the modules "name" and "version" that is required
	// if more that one module is required then just make a copy of that line

	$module_info['db_sql'][] =  "INSERT  into " . table_misc_data . " (name,data) VALUES ('karma_submit_story','+15')";
	$module_info['db_sql'][] =  "INSERT  into " . table_misc_data . " (name,data) VALUES ('karma_submit_comment','+10')";
	$module_info['db_sql'][] =  "INSERT  into " . table_misc_data . " (name,data) VALUES ('karma_story_publish','+50')";
	$module_info['db_sql'][] =  "INSERT  into " . table_misc_data . " (name,data) VALUES ('karma_story_vote','+1')";
	$module_info['db_sql'][] =  "INSERT  into " . table_misc_data . " (name,data) VALUES ('karma_story_unvote','-5')";
	$module_info['db_sql'][] =  "INSERT  into " . table_misc_data . " (name,data) VALUES ('karma_comment_vote','0')";
	$module_info['db_sql'][] =  "INSERT  into " . table_misc_data . " (name,data) VALUES ('karma_story_discard','-250')";
	$module_info['db_sql'][] =  "INSERT  into " . table_misc_data . " (name,data) VALUES ('karma_story_spam','-10000')";
	$module_info['db_sql'][] =  "INSERT  into " . table_misc_data . " (name,data) VALUES ('karma_comment_delete','-50')";

?>