<?php
function get_comment_username(&$vars)
{
	global $db;
	if (($vars['comment_username']=='anonymous') && ($comment = $db->get_row("SELECT * FROM " . table_comments . " WHERE `comment_id` = '{$vars['comment_id']}'")))
	{
	    $vars['comment_username'] = $comment->comment_anonymous_username;
	    $vars['is_anonymous'] = 1;
	}
}

function get_anonymous_user_id(&$vars)
{
	global $db,$main_smarty,$the_template;
	if($anonymous = $db->get_row("SELECT user_id FROM " . table_users . " WHERE `user_login` = 'anonymous'"))
	{
		$anonymous_user_id = $anonymous->user_id;
		$main_smarty->assign('anonymous_user_id', $anonymous_user_id);
	}
}
function insert_anonymous_comment(&$vars)
{
	global $db;
	$link_id = $vars['link_id'];
	$user_id = $vars['user_id'];
	$randkey = $vars['randkey'];
	$comment_content = $db->escape($vars['comment_content']);
	$a_username = $vars['a_username'];
	$a_email = $vars['a_email'];
	$a_website = $vars['a_website'];
	
	$sql = "INSERT INTO " . table_comments . " (comment_user_id, comment_link_id, comment_date, comment_randkey, comment_content,`comment_anonymous_username`, `comment_anonymous_email`, `comment_anonymous_website` ) VALUES ($user_id, $link_id, NOW(), $randkey, '$comment_content', '$a_username','$a_email', '$a_website')";
	$result = $db->query($sql);

	// DB 04/15/11
	$vars = array('comment'=>$db->insert_id);
	check_actions('after_comment_submit', &$vars);
	/////

	// DB 12/17/08
	$link = new Link;
	$link->id=$link_id;
	$link->read();
	$link->adjust_comment(1);
	$link->store();
	/////

}
?>