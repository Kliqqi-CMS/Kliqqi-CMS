<?php

include_once('internal/Smarty.class.php');
$main_smarty = new Smarty;

include('config.php');
include(mnminclude.'html1.php');
include(mnminclude.'link.php');
include(mnminclude.'tags.php');
include(mnminclude.'smartyvariables.php');
include(mnminclude.'csrf.php');

check_referrer();
$CSRF = new csrf();

// html tags allowed during submit
//$main_smarty->assign('Story_Content_Tags_To_Allow', htmlspecialchars(Story_Content_Tags_To_Allow));

// breadcrumbs and page titles
$navwhere['text1'] = $main_smarty->get_config_vars('PLIGG_Visual_Submit_A_New_Group');
$navwhere['link1'] = getmyurl('submit', '');
$main_smarty->assign('navbar_where', $navwhere);
$main_smarty->assign('posttitle', $main_smarty->get_config_vars('PLIGG_Visual_Submit_A_New_Group'));
$main_smarty = do_sidebar($main_smarty);
$main_smarty->assign('auto_approve_group', auto_approve_group);

// make sure user is logged in
force_authentication();
$current_user_level = $current_user->user_level;
if(enable_group == "true" && (group_submit_level == $current_user_level || group_submit_level == 'normal' || $current_user_level == 'admin'))
//if(enable_group == "true" && group_allow == 1)
{
	if(isset($_POST['group_title'])){
		$group_title = mysql_real_escape_string(stripslashes(strip_tags(trim($_POST['group_title']))));
	}
	if(isset($_POST['group_description'])){
		$group_description = mysql_real_escape_string(stripslashes(strip_tags(trim($_POST['group_description']))));
	}
	if(isset($_POST['group_vote_to_publish'])){
		$group_vote_to_publish = mysql_real_escape_string(stripslashes(strip_tags(trim($_POST['group_vote_to_publish']))));
	}
	if($_POST['group_notify_email']>0) $group_notify_email = 1;
	else $group_notify_email = 0;
	$group_author = $current_user->user_id;
	$group_members = 1;
	$g_date=time();
	$group_date = $g_date;
	$group_published_date = 943941600;
	$group_name = $group_title;
	$group_description = $group_description;
	
//	$group_safename = str_replace(' ', '-', $group_title);
	$group_safename = makeUrlFriendly($group_title, true);
	
	if(isset($_POST['group_privacy']))
		$group_privacy = $db->escape(sanitize($_POST['group_privacy'],3));
	
	if(auto_approve_group == 'true')
		$group_status = 'enable';
	else
		$group_status = 'disable';
	if(isset($_POST['group_title']))
	{
	    $CSRF->check_expired('submit_group');
	    if (!$CSRF->check_valid(sanitize($_POST['token'], 3), 'submit_group')){
	    	$CSRF->show_invalid_error(1);
		exit;
	    }

	    $errors = '';
	    if (!$group_name) $errors = $main_smarty->get_config_vars('PLIGG_Visual_Group_Empty_Title');
	    elseif ($group_vote_to_publish<=0) $errors = $main_smarty->get_config_vars('PLIGG_Visual_Group_Empty_Votes');
	    else
	    {
		$exists = $db->get_var("select COUNT(*) from ".table_groups." WHERE group_name='$group_name'");
	 	if ($exists) $errors = $main_smarty->get_config_vars('PLIGG_Visual_Group_Title_Exists');
	    }

	    if (!$errors)
	    {
		//to insert a group
		$insert_group = "INSERT IGNORE INTO " . table_groups . " (group_creator, group_status, group_members, group_date, group_safename, group_name, group_description, group_privacy, group_vote_to_publish, group_notify_email) VALUES ($group_author, '$group_status', $group_members,FROM_UNIXTIME($group_date),'$group_safename','$group_name', '$group_description', '$group_privacy', '$group_vote_to_publish', '$group_notify_email')";
		$result = $db->query($insert_group);
		
		//get linkid inserted above
		$in_id = $db->get_var("select max(group_id) as group_id from ".table_groups." ");
		//echo 'sdgfdsgds'.$in_id;
		
		//to make group creator a member
		$insert_member = "INSERT IGNORE INTO ". table_group_member ." (`member_user_id` , `member_group_id`, `member_role`) VALUES (".$group_author.", ".$in_id.",'moderator' )";
		$db->query($insert_member);
		
		if(isset($_POST['group_mailer']))
		{
			if(phpnum() == 4) {
				require_once(mnminclude.'class.phpmailer4.php');
			} else {
				require_once(mnminclude.'class.phpmailer5.php');
			}
			if(isset($_POST['group_mailer']))
			{
				Global $db,$current_user;
				$names = $_POST['group_mailer'];
				$v1 = explode (",", $names);
				$name = "";
				
				$user = new User;
				$user->id = $current_user->user_id;
				$user->read();
				
				$author_email = $user->email;
				$username = $user->username;
				
				
				foreach ($v1 as $t)
				{
					//echo $t;
					$str='';
					$from = "email@example.com";
					$subject = $main_smarty->get_config_vars('PLIGG_InvitationEmail_Subject');
					$to = $t;
					
					$message = sprintf($main_smarty->get_config_vars('PLIGG_InvitationEmail_Message'),"<a href='".my_base_url.my_pligg_base."/group_story.php?id=".$in_id."'>".$group_name."</a>","<a href='".my_base_url.my_pligg_base."/user.php?login=".$username."'>".$username."</a>");
					
					//echo $to.":".$site_mail.":".$subject."$message<br/>";
					
					$mail = new PHPMailer();
					$mail->From = $site_mail;
					$mail->FromName = $main_smarty->get_config_vars('PLIGG_PassEmail_Name');
					$mail->AddAddress($to);
					$mail->AddReplyTo($site_mail);
					$mail->IsHTML(true);
					$mail->Subject = $subject;
					$mail->Body = $message;
					$mail->CharSet = 'utf-8';
					$mail->Send();
				}
			}
		}
		if($result)
		{
			//redirect
			$redirect = '';
			$redirect = getmyurl("group_story", $in_id);
			header("Location: $redirect");
			die;
		}
	    }
	}
    	$CSRF->create('submit_group', true, true);
	
	//echo $sql;
}

// pagename
define('pagename', 'submit_groups');
$main_smarty->assign('error', $errors);
$main_smarty->assign('pagename', pagename);

// show the template
$main_smarty->assign('tpl_center', $the_template . '/submit_groups_center');
$main_smarty->display($the_template . '/pligg.tpl');
?>