<?php

include_once('../internal/Smarty.class.php');
$main_smarty = new Smarty;

include('../config.php');
include(mnminclude.'html1.php');
include(mnminclude.'link.php');
include(mnminclude.'user.php');
include(mnminclude.'smartyvariables.php');

$canIhaveAccess = 0;
$canIhaveAccess = $canIhaveAccess + checklevel('admin');
$canIhaveAccess = $canIhaveAccess + checklevel('moderator');

// initialize error message variable
$errorMsg="";

// if user tries to log in
if( (isset($_POST["processlogin"]) && is_numeric($_POST["processlogin"])) || (isset($_GET["processlogin"]) && is_numeric($_GET["processlogin"])) ){
	if($_POST["processlogin"] == 1) { // users logs in with username and password
		$username = sanitize(trim($_POST['username']), 3);
		$password = sanitize(trim($_POST['password']), 3);
		if(isset($_POST['persistent'])){$persistent = sanitize($_POST['persistent'], 3);}else{$persistent = '';}

		$dbusername=sanitize($db->escape($username),4);
		require_once(mnminclude.'check_behind_proxy.php');
		$lastip=check_ip_behind_proxy();
		$login=$db->get_row("SELECT *, UNIX_TIMESTAMP()-UNIX_TIMESTAMP(login_time) AS time FROM " . table_login_attempts . " WHERE login_ip='$lastip'");
		if ($login->login_id)
		{
			$login_id = $login->login_id;
			if ($login->time < 3) $errorMsg=sprintf($main_smarty->get_config_vars('PLIGG_Visual_Login_Error'),3);
			elseif ($login->login_count>=3)
			{
			if ($login->time < min(60*pow(2,$login->login_count-3),3600))
				$errorMsg=sprintf($main_smarty->get_config_vars('PLIGG_Login_Incorrect_Attempts'),$login->login_count,min(60*pow(2,$login->login_count-3),3600)-$login->time);
			}
		}
		elseif (!is_ip_approved($lastip))
		{
			$db->query("INSERT INTO ".table_login_attempts." SET login_username = '$dbusername', login_time=NOW(), login_ip='$lastip'");
			$login_id = $db->insert_id;
			if (!$login_id) $errorMsg=sprintf($main_smarty->get_config_vars('PLIGG_Visual_Login_Error'),3);
		}

		if (!$errorMsg)
		{
			if($current_user->Authenticate($username, $password, $persistent) == false) {
				$db->query("UPDATE ".table_login_attempts." SET login_username='$dbusername', login_count=login_count+1, login_time=NOW() WHERE login_id=".$login_id);
				$user=$db->get_row("SELECT * FROM " . table_users . " WHERE user_login = '$username' or user_email= '$username'");
				if (pligg_validate() && $user->user_lastlogin == "0000-00-00 00:00:00"){
					$errorMsg=$main_smarty->get_config_vars('PLIGG_Visual_Resend_Email') .
						"<form method='post'>
							<div class='input-append notvalidated'>
								<input type='text' class='form-control col-md-12' name='email'> 
								<input type='submit' class='btn btn-default col-md-12' value='Send'>
								<input type='hidden' name='processlogin' value='5'/>
							</div>
						</form>";
				} else {
					$errorMsg=$main_smarty->get_config_vars('PLIGG_Visual_Login_Error');
				}
			} else {
				$sql = "DELETE FROM " . table_login_attempts . " WHERE login_ip='$lastip' ";
				$db->query($sql);

				if(strlen(sanitize($_POST['return'], 3)) > 1) {
					$return = sanitize($_POST['return'], 3);
				} else {
					$return =  my_pligg_base.'/admin/admin_index.php';
				}
				
				define('logindetails', $username . ";" . $password . ";" . $return);

				$vars = '';
				check_actions('login_success_pre_redirect', $vars);

				if(strpos($_SERVER['SERVER_SOFTWARE'], "IIS") && strpos(php_sapi_name(), "cgi") >= 0){
					echo '<SCRIPT LANGUAGE="JavaScript">window.location="' . $return . '";</script>';
					echo $main_smarty->get_config_vars('PLIGG_Visual_IIS_Logged_In') . '<a href = "'.$return.'">' . $main_smarty->get_config_vars('PLIGG_Visual_IIS_Continue') . '</a>';
				} else {
					header('Location: '.$return);
				}
				die;
			}
		}
	}
}   

// misc smarty 
$main_smarty->assign('errorMsg',$errorMsg);  
$main_smarty->assign('post_username',$username);  

// pagename
define('pagename', 'admin_login'); 
$main_smarty->assign('pagename', pagename);

if($canIhaveAccess == 0){
	// show the template
	$main_smarty->assign('tpl_center', '/admin/login');
	$main_smarty->display($template_dir . '/admin/admin.tpl');
	
} else {
	// Send you to the admin panel
	$return =  my_pligg_base.'/admin/admin_index.php';
	header('Location: '.$return);
}


?>