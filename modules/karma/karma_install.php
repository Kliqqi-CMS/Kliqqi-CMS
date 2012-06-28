<?php
	$module_info['name'] = 'Karma module';
	$module_info['desc'] = 'This module will calculate karma values for all users';
	$module_info['version'] = 0.2;
//	$module_info['update_url'] = 'http://forums.pligg.com/versioncheck.php?product=karma';
//	$module_info['homepage_url'] = 'http://www.pligg.com/pro/catalog/modules/karma-98.html';
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