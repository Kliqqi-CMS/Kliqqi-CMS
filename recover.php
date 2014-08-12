<?php

include_once('internal/Smarty.class.php');
$main_smarty = new Smarty;

include('config.php');
include(mnminclude.'html1.php');
include(mnminclude.'link.php');
include(mnminclude.'smartyvariables.php');

// breadcrumbs and page title
$navwhere['text1'] = $main_smarty->get_config_vars('PLIGG_Visual_Breadcrumb_Recover_Password');
$navwhere['link1'] = getmyurl('loginNoVar', '');
$main_smarty->assign('navbar_where', $navwhere);
$main_smarty->assign('posttitle', $main_smarty->get_config_vars('PLIGG_Visual_Breadcrumb_Recover_Password'));

// sidebar
$main_smarty = do_sidebar($main_smarty);

// initialize error message variable
$errorMsg="";

// if user requests to logout
if($my_pligg_base){
	if (strpos($_GET['return'],$my_pligg_base)!==0) $_GET['return']=$my_pligg_base . '/';
	if (strpos($_POST['return'],$my_pligg_base)!==0) $_POST['return']=$my_pligg_base . '/';
}

$id=sanitize($_REQUEST['id'], 3);
$n=sanitize($_REQUEST['n'], 3);
$idTemp=base64_decode($id);
$username=sanitize($idTemp ,3);

$sql="SELECT * FROM `" . table_users . "` where `user_login` = '".$username."' AND `last_reset_request` = FROM_UNIXTIME('".$n."') AND user_level!='Spammer'";
		
$user = $db->get_row($sql);

if($user){
	if( (isset($_POST["processrecover"]) && is_numeric($_POST["processrecover"]))){
	
		if($_POST["processrecover"]==1){
			
			$error=false;
			
			$password = sanitize($_POST["reg_password"], 3);
			$password2 = sanitize($_POST["reg_password2"], 3);
			if(strlen($password) < 5 ) { // if password is less than 5 characters
				$form_password_error[] = $main_smarty->get_config_vars('PLIGG_Visual_Register_Error_FiveCharPass');
				$error = true;
			}
			if($password !== $password2) { // if both passwords do not match
				$form_password_error[] = $main_smarty->get_config_vars('PLIGG_Visual_Register_Error_NoPassMatch');
				$error = true;
			}	
			
			if($error==false){
			
				$saltedlogin = generateHash($username);
				
				$to = $user->user_email;
				$subject = $main_smarty->get_config_vars("PLIGG_Visual_Name").' '.$main_smarty->get_config_vars("PLIGG_PassEmail_Subject");

				$body = sprintf(
					$main_smarty->get_config_vars("PLIGG_PassEmail_PassBody"),
					$main_smarty->get_config_vars("PLIGG_Visual_Name"),
					$my_base_url . $my_pligg_base . '/login.php',
					$user->user_login,
					$password
				);
				
				$headers = 'From: ' . $main_smarty->get_config_vars("PLIGG_PassEmail_From") . "\r\n";
				$headers .= "Content-type: text/html; charset=utf-8\r\n";
				
				if (mail($to, $subject, $body, $headers))
				{
					$saltedPass = generateHash($password);
					$db->query('UPDATE `' . table_users . "` SET `user_pass` = '$saltedPass' WHERE `user_login` = '".$user->user_login."'");
					$db->query('UPDATE `' . table_users . '` SET `last_reset_request` = FROM_UNIXTIME('.time().') WHERE `user_login` = "'.$user->user_login.'"');
				
					$current_user->Authenticate($user->user_login, $password);
					$return =  my_pligg_base.'/';
					if(strpos($_SERVER['SERVER_SOFTWARE'], "IIS") && strpos(php_sapi_name(), "cgi") >= 0){
						echo '<SCRIPT LANGUAGE="JavaScript">window.location="' . $return . '";</script>';
						echo $main_smarty->get_config_vars('PLIGG_Visual_IIS_Logged_In') . '<a href = "'.$return.'">' . $main_smarty->get_config_vars('PLIGG_Visual_IIS_Continue') . '</a>';
					} else {
						header('Location: '.$return);
					}
					
				} else {
				
					$errorMsg = $main_smarty->get_config_vars('PLIGG_Visual_Login_Delivery_Failed');
					
				}
				
			}
			
			$main_smarty->assign('form_password_error', $form_password_error);
			
		}
	  
	}

} else {

	$errorMsg = $main_smarty->get_config_vars('PLIGG_Password_Invalid_URL');
	
}

// pagename
define('pagename', 'recover'); 
$main_smarty->assign('pagename', pagename);
 
// misc smarty 
$main_smarty->assign('errorMsg',$errorMsg); 
$main_smarty->assign('id',$id); 
$main_smarty->assign('n',$n); 


// show the template
$main_smarty->assign('tpl_center', $the_template . '/recover_password_center');
$main_smarty->display($the_template . '/pligg.tpl');

?>