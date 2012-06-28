<?php
function get_anonymous_story_user_id(&$vars)
{
	global $db,$main_smarty,$the_template, $current_user;
	if($anonymous = $db->get_row("SELECT * FROM " . table_users . " WHERE `user_login` = 'anonymous'"))
	{
		$anonymous_user_id = $anonymous->user_id;
		$main_smarty->assign('anonymous_user_id', $anonymous_user_id);
		/*
		$vars['anonymous_story'] = true;
		$vars['user_id'] = $anonymous->user_id;
		$vars['user_level'] = $anonymous->user_level;
		$vars['user_login'] = $anonymous->user_login;
		$vars['authenticated'] = true;
		*/
		$vars['anonymous_story'] = true;
		$current_user->user_id = $anonymous->user_id;
		$current_user->user_level = $anonymous->user_level;
		$current_user->user_login = $anonymous->user_login;
		$current_user->authenticated = false;
	}
}
?>