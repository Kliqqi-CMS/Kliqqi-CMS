<?php

function welcome_privmsg_send(&$registration_details)
{
	global $username, $main_smarty, $current_user;

	include_once(mnminclude.'user.php');
	
	include_once('config.php');
	include_once(my_pligg_base.'/modules/simple_messaging/kmessaging/class.KMessaging.php');

	$siteName = $main_smarty->get_config_vars('PLIGG_Visual_Name'); 
	
	// User ID of Admin
	define('welcome_privmsg_admin_id', '1');
	
	// Message Subject
	define('welcome_privmsg_subject', 'Welcome to '.$siteName);
	
	// Message Body
	define('welcome_privmsg_body', 'Thanks for registering on our site!');
			
	// Check User ID != 0
	if ($registration_details['id'] > 0)
	{		
		$msg_subject = sanitize(welcome_privmsg_subject, 2);
		$msg_body = welcome_privmsg_body;
		$msg_to_ID = $registration_details['id'];
		$msg_from_ID = welcome_privmsg_admin_id;
		
		$message = new KMessaging(true);
		$msg_result = $message->SendMessage($msg_subject, $msg_body, $msg_from_ID, $msg_to_ID, 0);
		
		if ($msg_result != 0) {
			echo "Module Error #".$msg_result;
		}
		
	} else {
	
		// Unable to find User ID
		echo "Module Error #1";
		die;
	}
}
	
?>