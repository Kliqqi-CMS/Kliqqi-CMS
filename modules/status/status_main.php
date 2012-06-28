<?php
function status_is_allowed($user)
{
	global $db;
	$settings = get_status_settings();
	$users = explode(',', $settings['users']);
	$groups = explode(',', sanitize($settings['groups']));
	array_walk($users, 'status_trim_value');
	array_walk($groups, 'status_trim_value');

	    if (!strstr($settings['level'],$user->level) && 
		!in_array($user->username,$users) &&
		(!$settings['groups'] ||
		 !$db->get_row($sql="SELECT group_id FROM ".table_groups." 
					INNER JOIN ".table_group_member." ON member_group_id=group_id AND member_user_id='{$user->id}' AND member_status='active'
					WHERE group_name IN ('".join("','",$groups)."')")))
		return false;
	    else
		return true;
}

function status_trim_value(&$value) 
{ 
    $value = trim($value); 
}

function status_comment_submit($vars)
{
	global $db, $main_smarty;

	if (get_misc_data('status_switch')!='1') return;

	$comment = $vars['comment'];
	if (!$comment->id) return;


	$user=new User();
	$user->id = $comment->author;
	$linkres=new Link;
	$linkres->id = $comment->link;
	if($user->read() && $linkres->read()) 
	{
	    if (!status_is_allowed($user) || !$user->extra_field['status_switch'] || !$user->extra_field['status_comment']) return;

 	    $main_smarty->config_load(status_lang_conf);
	    $text = $main_smarty->get_config_vars('PLIGG_Status_Comment_Update');
	    $limit = get_misc_data('status_max_chars');
	    if ($limit>0 && strlen($text)+strlen($user->username)+strlen($linkres->title)-4 > $limit)
	    	$linkres->title = substr($linkres->title,0,max($limit+4-strlen($text)-strlen($user->username)-3,10)).'...';
	    $text = sprintf( $text, $user->username, '<a href="'.$linkres->get_internal_url().'">'.$linkres->title.'</a>' );
	    $db->query($sql="INSERT INTO ".table_prefix."updates SET update_time=UNIX_TIMESTAMP(), 
							    update_type='c',
							    update_user_id='{$comment->author}',
							    update_link_id='{$comment->id}',
							    update_text='$text'
							    ");
	}
}

function status_story_submit($vars)
{
	global $db, $main_smarty;

	if (get_misc_data('status_switch')!='1') return;

	$linkres = $vars['linkres'];
	if (!$linkres->id) return;

	$user=new User();
	$user->id = $linkres->author;
	if($user->read()) 
	{
	    if (!status_is_allowed($user) || !$user->extra_field['status_switch'] || !$user->extra_field['status_story']) return;

 	    $main_smarty->config_load(status_lang_conf);
	    $text = $main_smarty->get_config_vars('PLIGG_Status_Story_Update');
	    $limit = get_misc_data('status_max_chars');
	    if ($limit>0 && strlen($text)+strlen($user->username)+strlen($linkres->title)-4 > $limit)
	    	$linkres->title = substr($linkres->title,0,max($limit+4-strlen($text)-strlen($user->username)-3,10)).'...';
	    $text = sprintf( $text, $user->username, '<a href="'.$linkres->get_internal_url().'">'.$linkres->title.'</a>' );
	    $db->query($sql="INSERT INTO ".table_prefix."updates SET update_time=UNIX_TIMESTAMP(), 
							    update_type='s',
							    update_user_id='{$linkres->author}',
							    update_link_id='{$linkres->id}',
							    update_text='$text'
							    ");
	}
}

//
// Settings page
//
function status_showpage(){
	global $db, $main_smarty, $the_template;
		
	include_once('config.php');
	include_once(mnminclude.'html1.php');
	include_once(mnminclude.'link.php');
	include_once(mnminclude.'tags.php');
	include_once(mnminclude.'smartyvariables.php');
	
	$main_smarty = do_sidebar($main_smarty);

	force_authentication();
	$canIhaveAccess = 0;
	$canIhaveAccess = $canIhaveAccess + checklevel('god');
	
	if($canIhaveAccess == 1)
	{	
		if ($_POST['submit'])
		{
			if ($_REQUEST['status_level'])
			    $level = join(',',$_REQUEST['status_level']);
			if ($_REQUEST['status_profile_level'])
			    $level1 = join(',',$_REQUEST['status_profile_level']);

			$_REQUEST = str_replace('"',"'",$_REQUEST);
			misc_data_update('status_level', mysql_real_escape_string($level));
			misc_data_update('status_profile_level', mysql_real_escape_string($level1));
			misc_data_update('status_switch', mysql_real_escape_string($_REQUEST['status_switch']));
			misc_data_update('status_allowsearch', mysql_real_escape_string($_REQUEST['status_allowsearch']));
			misc_data_update('status_place', mysql_real_escape_string($_REQUEST['status_place']));
			misc_data_update('status_pre_format', mysql_real_escape_string($_REQUEST['status_pre_format']));
			misc_data_update('status_post_format', mysql_real_escape_string($_REQUEST['status_post_format']));
			misc_data_update('status_pre_comment', mysql_real_escape_string($_REQUEST['status_pre_comment']));
			misc_data_update('status_post_comment', mysql_real_escape_string($_REQUEST['status_post_comment']));
			misc_data_update('status_pre_story', mysql_real_escape_string($_REQUEST['status_pre_story']));
			misc_data_update('status_post_story', mysql_real_escape_string($_REQUEST['status_post_story']));
			misc_data_update('status_pre_username', mysql_real_escape_string($_REQUEST['status_pre_username']));
			misc_data_update('status_post_username', mysql_real_escape_string($_REQUEST['status_post_username']));
			misc_data_update('status_pre_search', mysql_real_escape_string($_REQUEST['status_pre_search']));
			misc_data_update('status_post_search', mysql_real_escape_string($_REQUEST['status_post_search']));
			misc_data_update('status_pre_submit', mysql_real_escape_string($_REQUEST['status_pre_submit']));
			misc_data_update('status_post_submit', mysql_real_escape_string($_REQUEST['status_post_submit']));
			misc_data_update('status_email', mysql_real_escape_string($_REQUEST['status_email']));
			misc_data_update('status_clock', mysql_real_escape_string($_REQUEST['status_clock']));
			misc_data_update('status_permalinks', mysql_real_escape_string($_REQUEST['status_permalinks']));
			misc_data_update('status_inputonother', mysql_real_escape_string($_REQUEST['status_inputonother']));
			misc_data_update('status_show_permalin', mysql_real_escape_string($_REQUEST['status_show_permalinks']));
			misc_data_update('status_results', mysql_real_escape_string($_REQUEST['status_results']));
			misc_data_update('status_max_chars', mysql_real_escape_string($_REQUEST['status_max_chars']));
			misc_data_update('status_avatar', mysql_real_escape_string($_REQUEST['status_avatar']));
			misc_data_update('status_groups', mysql_real_escape_string($_REQUEST['status_groups']));
			misc_data_update('status_users', mysql_real_escape_string($_REQUEST['status_users']));
			misc_data_update('status_user_switch', mysql_real_escape_string($_REQUEST['status_user_switch']));
			misc_data_update('status_user_friends', mysql_real_escape_string($_REQUEST['status_user_friends']));
			misc_data_update('status_user_story', mysql_real_escape_string($_REQUEST['status_user_story']));
			misc_data_update('status_user_comment', mysql_real_escape_string($_REQUEST['status_user_comment']));
			misc_data_update('status_user_group', mysql_real_escape_string($_REQUEST['status_user_group']));
			misc_data_update('status_user_email', mysql_real_escape_string($_REQUEST['status_user_email']));
			$db->query("ALTER TABLE ".table_users." 
					CHANGE  `status_switch`  `status_switch` TINYINT(1) DEFAULT '".($_REQUEST['status_user_switch']+0)."',
					CHANGE  `status_friends` `status_friends` TINYINT(1) DEFAULT '".($_REQUEST['status_user_friends']+0)."',
					CHANGE  `status_story`  `status_story` TINYINT(1) DEFAULT  '".($_REQUEST['status_user_story']+0)."',
					CHANGE  `status_comment`  `status_comment` TINYINT(1) DEFAULT  '".($_REQUEST['status_user_comment']+0)."',
					CHANGE  `status_group`  `status_group` TINYINT(1) DEFAULT  '".($_REQUEST['status_user_group']+0)."',
					CHANGE  `status_email`  `status_email` TINYINT(1) DEFAULT  '".($_REQUEST['status_user_email']+0)."'");
			header("Location: ".my_pligg_base."/module.php?module=status");
			die();
		}
		// breadcrumbs
		$main_smarty->assign('navbar_where', $navwhere);
		$main_smarty->assign('posttitle', " / " . $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel'));
		// breadcrumbs
		define('modulename', 'status'); 
		$main_smarty->assign('modulename', modulename);
		
		define('pagename', 'admin_modifystatus'); 
		$main_smarty->assign('pagename', pagename);

		$main_smarty->assign('settings', get_status_settings());
		$main_smarty->assign('tpl_center', status_tpl_path . 'status_main');
		$main_smarty->display($template_dir . '/admin/admin.tpl');
	}
	else
	{
		header("Location: " . getmyurl('login', $_SERVER['REQUEST_URI']));
	}
}	

// 
// Read module settings
//
function get_status_settings()
{
    return array(
		'level' => get_misc_data('status_level'), 
		'profile_level' => get_misc_data('status_profile_level'), 
		'switch' => get_misc_data('status_switch'),
		'allowsearch' => get_misc_data('status_allowsearch'),
		'place' => get_misc_data('status_place'),
		'pre_format' => get_misc_data('status_pre_format'),
		'post_format' => get_misc_data('status_post_format'),
		'pre_comment' => get_misc_data('status_pre_comment'),
		'post_comment' => get_misc_data('status_post_comment'),
		'pre_story' => get_misc_data('status_pre_story'),
		'post_story' => get_misc_data('status_post_story'),
		'pre_search' => get_misc_data('status_pre_search'),
		'post_search' => get_misc_data('status_post_search'),
		'pre_submit' => get_misc_data('status_pre_submit'),
		'post_submit' => get_misc_data('status_post_submit'),
		'pre_username' => get_misc_data('status_pre_username'),
		'post_username' => get_misc_data('status_post_username'),
		'email' => get_misc_data('status_email'),
		'clock' => get_misc_data('status_clock'),
		'permalinks' => get_misc_data('status_permalinks'),
		'inputonother' => get_misc_data('status_inputonother'),
		'show_permalinks' => get_misc_data('status_show_permalin'),
		'results' => get_misc_data('status_results'),
		'max_chars' => get_misc_data('status_max_chars'),
		'avatar' => get_misc_data('status_avatar'),
		'groups' => get_misc_data('status_groups'),
		'users' => get_misc_data('status_users'),
		'user_switch' => get_misc_data('status_user_switch'),
		'user_friends' => get_misc_data('status_user_friends'),
		'user_story' => get_misc_data('status_user_story'),
		'user_comment' => get_misc_data('status_user_comment'),
		'user_group' => get_misc_data('status_user_group'),
		'user_email' => get_misc_data('status_user_email')
		);
}

function status_profile_save(){
	global $user, $users_extra_fields_field;

	$user->extra['status_switch']=sanitize($_POST['status_switch']);	
	$user->extra['status_friends']=sanitize($_POST['status_friends']);	
	$user->extra['status_all_friends']=sanitize($_POST['status_all_friends']);	
	$user->extra['status_friend_list']=sanitize(@join(',',$_POST['status_friend_list']));	
	$user->extra['status_comment']=sanitize($_POST['status_comment']);	
	$user->extra['status_group']=sanitize($_POST['status_group']);	
	$user->extra['status_story']=sanitize($_POST['status_story']);	
	$user->extra['status_email']=sanitize($_POST['status_email']);	
}

function status_profile_show(){
	global $main_smarty, $user, $users_extra_fields_field;
	$main_smarty->assign('status_switch', $user->extra_field['status_switch']);
	$main_smarty->assign('status_friends', $user->extra_field['status_friends']);
	$main_smarty->assign('status_all_friends', $user->extra_field['status_all_friends']);
	$main_smarty->assign('status_friend_list', preg_split('/[, ]/', $user->extra_field['status_friend_list']));
	$main_smarty->assign('status_comment', $user->extra_field['status_comment']);
	$main_smarty->assign('status_group', $user->extra_field['status_group']);
	$main_smarty->assign('status_story', $user->extra_field['status_story']);
	$main_smarty->assign('status_email', $user->extra_field['status_email']);
}
?>
