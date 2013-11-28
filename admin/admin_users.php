<?php

include_once('../internal/Smarty.class.php');
$main_smarty = new Smarty;

include('../config.php');
include(mnminclude.'html1.php');
include(mnminclude.'link.php');
include(mnminclude.'votes.php');
include(mnminclude.'tags.php');
include(mnminclude.'user.php');
include(mnminclude.'smartyvariables.php');
include(mnminclude.'csrf.php');
include(mnminclude.'document_class.php');

check_referrer();

// require user to log in
force_authentication();

// restrict access to admins and moderators
$amIadmin = 0;
$amIadmin = $amIadmin + checklevel('admin');
$main_smarty->assign('amIadmin', $amIadmin);

$canIhaveAccess = 0;
$canIhaveAccess = $canIhaveAccess + checklevel('admin');
$canIhaveAccess = $canIhaveAccess + checklevel('moderator');

$is_moderator = checklevel('moderator'); // Moderators have a value of '1' for the variable $is_moderator

$PliggDoc->add_js(my_base_url.my_pligg_base."/templates/admin/js/jquery/jquery.tablesorter.js");

$PliggDoc->add_js("$(function() {
				
            $('#tablesorter-userTable').tablesorter({sortList: [[1,1]], headers: { 5:{sorter: false}, 6:{sorter: false}, 0:{sorter: false}}});
            
        });	", true);

$PliggDoc->get_js();


if($canIhaveAccess == 0){	
//	$main_smarty->assign('tpl_center', '/admin/access_denied');
//	$main_smarty->display($template_dir . '/admin/admin.tpl');		
	header("Location: " . getmyurl('admin_login', $_SERVER['REQUEST_URI']));
	die();
}

// read the mysql database to get the pligg version
$sql = "SELECT data FROM " . table_misc_data . " WHERE name = 'pligg_version'";
$pligg_version = $db->get_var($sql);
$main_smarty->assign('version_number', $pligg_version); 

// sidebar
$main_smarty = do_sidebar($main_smarty);

if($canIhaveAccess == 1)
{

	// sessions used to prevent CSRF
	$CSRF = new csrf();
	
	if(isset($_POST['frmsubmit'])) {
	
		if ($_POST["enabled"]) {
			
	    	$CSRF->check_expired('admin_users_list');
			
	    	if ($CSRF->check_valid(sanitize($_POST['token'], 3), 'admin_users_list')){
	        
				$value = $db->escape($_POST['admin_acction']);
			
				foreach($_POST["enabled"] as $id => $valuea) 
				{
					$_GET['id'] = $id = $db->escape($id);
					$user= $db->get_row('SELECT * FROM ' . table_users ." where user_id=$id");
					
					if($value==3)
					{
					
						if($user->user_level!="Spammer")	
							killspam($id);
						
					} elseif($value==2) {
						
						if ($user->user_enabled != 0)
						{
							canIChangeUser($user->user_level);
							$db->query("UPDATE ".table_users." SET user_enabled='0', user_level=IF(user_level='Spammer','normal',user_level) WHERE user_id='".$db->escape($id)."'");
						}
						
					} elseif($value==1) {
						
						if ($user->user_enabled != 1)
						{
							canIChangeUser($user->user_level);
							$db->query("UPDATE ".table_users." SET user_enabled='1', user_level=IF(user_level='Spammer','normal',user_level) WHERE user_id='".$db->escape($id)."'");
						}	
					}
				}
	    	} else {
				$CSRF->show_invalid_error(1);
				exit;
	    	}
	    }

	    if ($_POST['delete'])
	    {
			foreach ($_POST['delete'] as $id)
			{
				$_GET['id'] = $id = $db->escape($id);
				killspam($id);
			}
	    }
		
	    //header("Location:  ".my_pligg_base."/admin/admin_users.php");
		header("Location:".$_SERVER['HTTP_REFERER']);
	    exit;
	}

	if (isset($_REQUEST["mode"]) && sanitize($_REQUEST["mode"], 3) == "newuser"){
	   
		$CSRF->check_expired('admin_users_create');
		
	    if ($CSRF->check_valid(sanitize($_POST['token'], 3), 'admin_users_create')){
		
			$username=trim($db->escape($_POST['username']));
			$password=trim($db->escape($_POST['password']));
			$email=trim($db->escape($_POST['email']));
			$saltedpass=generateHash($password);
			
			// Only Admin accounts can create moderators and other admins
			if ($amIadmin){
				$level=trim($db->escape($_POST['level']));
			} else {
				$level='normal';
			}
			
			if (!isset($username) || strlen($username) < 3) {
				$main_smarty->assign(username_error, $main_smarty->get_config_vars('PLIGG_Visual_Register_Error_UserTooShort'));			
			}
			elseif (!preg_match('/^[a-zA-Z0-9\-]+$/', $username)) {
				$main_smarty->assign(username_error, $main_smarty->get_config_vars('PLIGG_Visual_Register_Error_UserInvalid'));
			}
			elseif (user_exists(trim($username)) ) {
				$main_smarty->assign(username_error, $main_smarty->get_config_vars('PLIGG_Visual_Register_Error_UserExists'));
			}
			elseif (!check_email(trim($email))) {
				$main_smarty->assign(email_error, $main_smarty->get_config_vars('PLIGG_Visual_Register_Error_BadEmail'));
			}
			elseif (email_exists(trim($email))) {
				$main_smarty->assign(email_error, $main_smarty->get_config_vars('PLIGG_Visual_Register_Error_EmailExists'));			
			}
			elseif (strlen($password) < 5 ) {
				$main_smarty->assign(password_error, $main_smarty->get_config_vars('PLIGG_Visual_Register_Error_FiveCharPass'));			
			}
			else {
				$db->query("INSERT IGNORE INTO " . table_users . " (user_login, user_level, user_email, user_pass, user_date, user_modification, user_lastlogin) VALUES ('$username', '$level', '$email', '$saltedpass', NOW(), NOW(), NOW())");
				header("Location:  ".my_pligg_base."/admin/admin_users.php");
				die();
			}
	    } else {
			$CSRF->show_invalid_error(1);
			exit;
	    }
	}

	if(isset($_REQUEST["mode"])) {
		// Create User Page
		if ($_GET["mode"] == "create"){ // create user
				
			$CSRF->create('admin_users_create', true, true);
			// breadcrumbs and page titles
			$navwhere['text1'] = $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel');
			$navwhere['link1'] = getmyurl('admin', '');
			$navwhere['text2'] = $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel_1');
			$navwhere['link2'] = my_pligg_base . "/admin/admin_users.php";
			$navwhere['text3'] = $main_smarty->get_config_vars('PLIGG_Visual_Breadcrumb_User_Killspam');
			$main_smarty->assign('navbar_where', $navwhere);
			$main_smarty->assign('posttitle', " / " . $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel'));
			
			// misc smarty
			$main_smarty->assign('pagename', pagename);
			
			// pagename
			define('pagename', 'admin_users'); 
			$main_smarty->assign('pagename', pagename);

			// show the template
			$main_smarty->assign('tpl_center', '/admin/user_create');
			$main_smarty->display($template_dir . '/admin/help.tpl');
			exit;

		}
		if (sanitize($_GET["mode"], 3) == "view"){ // view single user

			// code to prevent CSRF
			$CSRF->create('admin_users_resetpass', true, true);
	
			$usersql = mysql_query('SELECT * FROM ' . table_users . ' where user_id="'.sanitize($_GET["user"], 3).'" or user_login="'.sanitize($_GET["user"], 3).'"');
			$userdata = array();				
			while ($rows = mysql_fetch_array ($usersql, MYSQL_ASSOC)) array_push ($userdata, $rows);
			
		  
			foreach($userdata as $key => $val){
				$userdata[$key]['Avatar'] = get_avatar('large', "", $val['user_login'], $val['user_email']);
				$created = $db->get_results('SELECT * FROM ' . table_groups . ' where group_status="Enable" AND group_creator='.$userdata[$key]['user_id'],ARRAY_A);
				$arr = array();
				foreach ($created as $group)
				    $arr[] = $group['group_name'];
				$userdata[$key]['created']= join(',',$arr);
				$belongs = $db->get_results('SELECT * FROM ' . table_group_member . ' LEFT JOIN  ' . table_groups . ' ON member_group_id=group_id where group_status="Enable" AND member_status="active" AND member_user_id='.$userdata[$key]['user_id'],ARRAY_A);
				$arr = array();
				foreach ($belongs as $group)
				    $arr[] = $group['group_name'];
				$userdata[$key]['belongs']= join(',',$arr);
			}
		  
			$main_smarty->assign('userdata', $userdata);
			$linkcount=$db->get_var('SELECT count(*) FROM ' . table_links . ' where link_author="'.$userdata[0]['user_id'].'"');
			$main_smarty->assign('linkcount', $linkcount);
			$commentcount=$db->get_var('SELECT count(*) FROM ' . table_comments . ' where comment_user_id="'.$userdata[0]['user_id'].'"');
			$main_smarty->assign('commentcount', $commentcount);
			
			// breadcrumbs and page title
			$navwhere['text1'] = $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel');
			$navwhere['link1'] = getmyurl('admin', '');
			$navwhere['text2'] = $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel_1');
			$navwhere['link2'] = my_pligg_base . "/admin/admin_users.php";
			$navwhere['text3'] = $main_smarty->get_config_vars('PLIGG_Visual_Breadcrumb_View_User');
			$main_smarty->assign('navbar_where', $navwhere);
			$main_smarty->assign('posttitle', " / " . $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel'));
			
			// pagename
			define('pagename', 'admin_users'); 
   			$main_smarty->assign('pagename', pagename);
			
			$user=new User();
			
			$user->username = sanitize($userdata[0]['user_login'], 3);
			if(!$user->read()) {
				$main_smarty->assign('tpl_center', '/admin/user_does_not_exist');
				if ($is_moderator == '1'){
					$main_smarty->display($template_dir . '/admin/moderator.tpl');
				} else {
					$main_smarty->display($template_dir . '/admin/admin.tpl');
				}
			}
			
			// module system hook
			$vars = '';
			check_actions('admin_users_view', $vars);
			
			// show the template
			$main_smarty->assign('tpl_center', '/admin/user_view');
			if ($is_moderator == '1'){
				$main_smarty->display($template_dir . '/admin/moderator.tpl');
			} else {
				$main_smarty->display($template_dir . '/admin/admin.tpl');
			}
		}
		
		if (sanitize($_GET["mode"], 3) == "edit"){ // edit user

			$usersql = mysql_query('SELECT * FROM ' . table_users . ' where user_id="'.sanitize($_GET["user_id"], 3).'"');
			$userdata = array();
			while ($rows = mysql_fetch_array ($usersql, MYSQL_ASSOC)) array_push ($userdata, $rows);
			
			canIChangeUser($userdata[0]['user_level']);
			
			$user=new User();
			$user->username = sanitize($userdata[0]['user_login'], 3);
			
			if(!$user->read()) {
				$user = sanitize($userdata[0]['user_login'], 3);
				$main_smarty->assign('user', $user);
				$main_smarty->assign('tpl_center', '/admin/user_does_not_exist');
				if ($is_moderator == '1'){
					$main_smarty->display($template_dir . '/admin/moderator.tpl');
				} else {
					$main_smarty->display($template_dir . '/admin/admin.tpl');
				}
				die;
			}
			
			//update user date
			if(isset($_POST['token'])){
			
				$CSRF->check_expired('admin_users_edit');
				if ($CSRF->check_valid(sanitize($_POST['token'], 3), 'admin_users_edit')){
					
					$user_old = $db->get_row('SELECT * FROM ' . table_users . ' where user_id="'.sanitize($_GET["user_id"], 3).'"');
					
					$username=trim(sanitize($_POST["login"], 3));
					$email=trim(sanitize($_POST["email"], 3)); 
					$password=$_POST['password'];
						
					$error=0;
					
					if($user_old->user_login!=$username){	
						if (!isset($username) || strlen($username) < 3) {
							$main_smarty->assign(username_error, $main_smarty->get_config_vars('PLIGG_Visual_Register_Error_UserTooShort'));
							$error=1;			
						}
						elseif (!preg_match('/^[a-zA-Z0-9\-]+$/', $username)) {
							$main_smarty->assign(username_error, $main_smarty->get_config_vars('PLIGG_Visual_Register_Error_UserInvalid'));
							$error=1;
						}
						elseif (user_exists(trim($username)) ) {
							$main_smarty->assign(username_error, $main_smarty->get_config_vars('PLIGG_Visual_Register_Error_UserExists'));
							$error=1;
						}
					}
					
					if($user_old->user_email!=$email){
						if (!check_email(trim($email))) {
							$main_smarty->assign(email_error, $main_smarty->get_config_vars('PLIGG_Visual_Register_Error_BadEmail'));
							$error=1;
						}
						elseif (email_exists(trim($email))) {
							$main_smarty->assign(email_error, $main_smarty->get_config_vars('PLIGG_Visual_Register_Error_EmailExists'));
							$error=1;			
						}
					}
					
					// module system hook
					$vars = '';
					
					check_actions('admin_users_save', $vars);
					
					$user->username=$username;
					$user->level=trim(sanitize($_POST["level"], 3));
					$user->email=$email;
					
					if ($_POST["password"] && $_POST["password"]==$_POST["password2"]){
						if (strlen($password) < 5 ) {
							$main_smarty->assign(password_error, $main_smarty->get_config_vars('PLIGG_Visual_Register_Error_FiveCharPass'));
							$error=1;			
						} else {
							$user->pass = $_POST["password"];
						}
					}
					
					if($error==0){
						$user->id=$_GET["user_id"];	
						echo "save";
						$user->store();
						header("Location: ".my_pligg_base."/admin/admin_users.php?mode=view&user=".$_GET["user_id"]."");
					}
					
					if($error==1){
						$userdata[0]['user_login']=$username;
						$userdata[0]['user_email']=$email;
						$userdata[0]['cng_lavel']=$userdata->level;
					}
					
				} else {
					showmyerror('userdoesntexist');
				}
				//user save end
				
			} 				
			//update user data end	
			
			$CSRF->create('admin_users_edit', true, true);
			
			$main_smarty->assign('userdata', $userdata);
			$main_smarty->assign('levels', array('normal','admin','moderator','Spammer'));

			// breadcrumbs and page title
			$navwhere['text1'] = $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel');
			$navwhere['link1'] = getmyurl('admin', '');
			$navwhere['text2'] = $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel_1');
			$navwhere['link2'] = my_pligg_base . "/admin/admin_users.php";
			$navwhere['text3'] = $main_smarty->get_config_vars('PLIGG_Visual_Breadcrumb_Edit_User');
			$main_smarty->assign('navbar_where', $navwhere);
			$main_smarty->assign('posttitle', " / " . $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel'));
			
			// pagename
			define('pagename', 'admin_users'); 
			$main_smarty->assign('pagename', pagename);

			
			// module system hook
			$vars = '';
			check_actions('admin_users_edit', $vars);
	
			// show the template
			$main_smarty->assign('tpl_center', '/admin/user_edit');
			if ($is_moderator == '1'){
				$main_smarty->display($template_dir . '/admin/moderator.tpl');
			} else {
				$main_smarty->display($template_dir . '/admin/admin.tpl');
			}
		}	
		
		if (sanitize($_GET["mode"], 3) == "resetpass"){ // reset user password

			// code to prevent CSRF
//			$CSRF->check_expired('admin_users_resetpass');
			$CSRF->check_expired('admin_users_edit');
			// code to prevent CSRF
		
//			if ($CSRF->check_valid(sanitize($_GET['token'], 3), 'admin_users_resetpass'))
			if ($CSRF->check_valid(sanitize($_GET['token'], 3), 'admin_users_edit'))
			{
				$user= $db->get_row('SELECT * FROM ' . table_users . ' where user_login="'.sanitize($_GET["user"], 3).'"');
				
				canIChangeUser($user->user_level);
				
				if ($user) {
//					$db->query('UPDATE `' . table_users . '` SET `user_pass` = "033700e5a7759d0663e33b18d6ca0dc2b572c20031b575750" WHERE `user_login` = "'.sanitize($_GET["user"], 3).'"');
					$to = $user->user_email;
					$subject = $main_smarty->get_config_vars("PLIGG_Visual_Name").' '.$main_smarty->get_config_vars("PLIGG_PassEmail_Subject");

					$password = substr(md5(uniqid(rand(), true)),0,8);
					$saltedPass = generateHash($password);
					$db->query('UPDATE `' . table_users . "` SET `user_pass` = '$saltedPass' WHERE `user_login` = '".sanitize($_GET["user"], 3)."'");
					$body = sprintf($main_smarty->get_config_vars("PLIGG_PassEmail_PassBody"),
						$main_smarty->get_config_vars("PLIGG_Visual_Name"),
						$my_base_url . $my_pligg_base . '/login.php',
						$_GET["user"],
						$password);

					$headers = 'From: ' . $main_smarty->get_config_vars("PLIGG_PassEmail_From") . "\r\n";
					$headers .= "Content-type: text/html; charset=utf-8\r\n";

					mail($to, $subject, $body, $headers);
	
					// breadcrumbs and page title
					$navwhere['text1'] = $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel');
					$navwhere['link1'] = getmyurl('admin', '');
					$navwhere['text2'] = $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel_1');
					$navwhere['link2'] = my_pligg_base . "/admin/admin_users.php";
					$navwhere['text3'] = $main_smarty->get_config_vars('PLIGG_Visual_Breadcrumb_User_Reset_Pass');
					$main_smarty->assign('navbar_where', $navwhere);
					$main_smarty->assign('posttitle', " / " . $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel'));
					
					// pagename
					define('pagename', 'admin_users'); 
					$main_smarty->assign('pagename', pagename);
	
					// show the template
					$main_smarty->assign('tpl_center', '/admin/user_password_reset');
					$main_smarty->display($template_dir . '/admin/admin.tpl');
				} else {
					showmyerror('userdoesntexist');
				}
			} else {
				$CSRF->show_invalid_error(1);
				// invalid token / timeout error
			}
		}

		if (sanitize($_GET["mode"], 3) == "disable"){ // disable user

			// code to prevent CSRF
				// doesn't matter if a token exists. if we're viewing this page, just
				// create a new one or replace the existing.
				$CSRF->create('admin_users_disable', true, true);
			// code to prevent CSRF		
		
			if(sanitize($_GET["user"], 3) == "admin"){
				echo "You can't disable this user";
			} else {
				$user= $db->get_row('SELECT * FROM ' . table_users . ' where user_login="'.sanitize($_GET["user"], 3).'"');

				canIChangeUser($user->user_level); 
			
				if ($user) {
					
					// breadcrumbs and page title
					$navwhere['text1'] = $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel');
					$navwhere['link1'] = getmyurl('admin', '');
					$navwhere['text2'] = $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel_1');
					$navwhere['link2'] = my_pligg_base . "/admin/admin_users.php";
					$navwhere['text3'] = $main_smarty->get_config_vars('PLIGG_Visual_Breadcrumb_User_Disable');
					$main_smarty->assign('navbar_where', $navwhere);
					$main_smarty->assign('posttitle', " / " . $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel'));
					
					$main_smarty->assign('user', sanitize($_GET["user"], 3));	
								
					// pagename
					define('pagename', 'admin_users'); 
					$main_smarty->assign('pagename', pagename);					
				
					// show the template
					$main_smarty->assign('tpl_center', '/admin/user_disable');
					if ($is_moderator == '1'){
						$main_smarty->display($template_dir . '/admin/moderator.tpl');
					} else {
						$main_smarty->display($template_dir . '/admin/admin.tpl');
					}
				} else {
					showmyerror('userdoesntexist');
				}
			}
		}

		if (sanitize($_GET["mode"], 3) == "yesdisable"){ // diable user step 2
			// code to prevent CSRF
				$CSRF->check_expired('admin_users_disable');
			// code to prevent CSRF

			if ($CSRF->check_valid(sanitize($_GET['token'], 3), 'admin_users_disable'))
			{
				$user= $db->get_row('SELECT * FROM ' . table_users . ' where user_login="'.sanitize($_GET["user"], 3).'"');
				
				canIChangeUser($user->user_level); 
				
/*				$randomstring = "abcdefghijklmnopqrstuvwxyz0123456789";
				for($i=0;$i<49;$i++){
					$pos = rand(0,36);
					$str .= $randomstring{$pos};
				}
*/				
				if ($user) {
//					$db->query('UPDATE `' . table_users . '` SET `user_pass` = "'.$str.'" WHERE `user_login` = "'.sanitize($_GET["user"], 3).'"');
//					$db->query('UPDATE `' . table_users . '` SET `user_email` = "'.$user->user_email.'-disable" WHERE `user_login` = "'.sanitize($_GET["user"], 3).'"');
					$db->query('UPDATE `' . table_users . '` SET `user_enabled` = 0 WHERE `user_login` = "'.sanitize($_GET["user"], 3).'"');
					
					// breadcrumbs and page titles
					$navwhere['text1'] = $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel');
					$navwhere['link1'] = getmyurl('admin', '');
					$navwhere['text2'] = $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel_1');
					$navwhere['link2'] = my_pligg_base . "/admin/admin_users.php";
					$navwhere['text3'] = $main_smarty->get_config_vars('PLIGG_Visual_Breadcrumb_User_Disable_2');
					$main_smarty->assign('navbar_where', $navwhere);
					$main_smarty->assign('posttitle', " / " . $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel'));
					
					// pagename
					define('pagename', 'admin_users'); 
					$main_smarty->assign('pagename', pagename);
	
					header("Location: ".my_pligg_base."/admin/admin_users.php");
					die();
				} else {
					showmyerror('userdoesntexist');
				}
			} else {
				// invalid token / timeout error
				$CSRF->show_invalid_error(2);
			}
		}

		if (sanitize($_GET["mode"], 3) == "enable")
		{ 
				$user= $db->get_row('SELECT * FROM ' . table_users . ' where user_login="'.sanitize($_GET["user"], 3).'"');
				
				canIChangeUser($user->user_level); 
				
				if ($user) {
					$db->query('UPDATE `' . table_users . '` SET `user_enabled` = 1 WHERE `user_login` = "'.sanitize($_GET["user"], 3).'"');
					
					// breadcrumbs and page titles
					$navwhere['text1'] = $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel');
					$navwhere['link1'] = getmyurl('admin', '');
					$navwhere['text2'] = $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel_1');
					$navwhere['link2'] = my_pligg_base . "/admin/admin_users.php";
					$navwhere['text3'] = $main_smarty->get_config_vars('PLIGG_Visual_Breadcrumb_User_Disable_2');
					$main_smarty->assign('navbar_where', $navwhere);
					$main_smarty->assign('posttitle', " / " . $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel'));
					
					// pagename
					define('pagename', 'admin_users'); 
					$main_smarty->assign('pagename', pagename);
	
					header("Location: ".my_pligg_base."/admin/admin_users.php");
					die();
				} else {
					showmyerror('userdoesntexist');
				}
		}

		if (sanitize($_GET["mode"], 3) == "killspam"){ // killspam user
			// code to prevent CSRF
				// doesn't matter if a token exists. if we're viewing this page, just
				// create a new one or replace the existing.
				$CSRF->create('admin_users_killspam', true, true);
			// code to prevent CSRF		

			if(sanitize($_GET["user"], 3) == "admin"){
		  		echo "You can't killspam this user";
			} else {
				$user= $db->get_row('SELECT * FROM ' . table_users . ' where user_login="'.sanitize($_GET["user"], 3).'"');
			
				canIChangeUser($user->user_level);
				
				if ($user) {
	
					// breadcrumbs and page titles
					$navwhere['text1'] = $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel');
					$navwhere['link1'] = getmyurl('admin', '');
					$navwhere['text2'] = $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel_1');
					$navwhere['link2'] = my_pligg_base . "/admin/admin_users.php";
					$navwhere['text3'] = $main_smarty->get_config_vars('PLIGG_Visual_Breadcrumb_User_Killspam');
					$main_smarty->assign('navbar_where', $navwhere);
					$main_smarty->assign('posttitle', " / " . $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel'));
					
					// misc smarty
					$main_smarty->assign('pagename', pagename);
					$main_smarty->assign('user', sanitize($_GET["user"], 3));
					$main_smarty->assign('id', sanitize($_GET["id"], 3));
					
					// pagename
					define('pagename', 'admin_users'); 
					$main_smarty->assign('pagename', pagename);
		
					// show the template
					$main_smarty->assign('tpl_center', '/admin/user_killspam');
					if ($is_moderator == '1'){
						$main_smarty->display($template_dir . '/admin/moderator.tpl');
					} else {
						$main_smarty->display($template_dir . '/admin/admin.tpl');
					}
				} else {
					showmyerror('userdoesntexist');
				}
			}
		}
		
		if (sanitize($_GET["mode"], 3) == "yeskillspam"){ // killspam step 2
			// code to prevent CSRF
				$CSRF->check_expired('admin_users_killspam');
			// code to prevent CSRF
						
			if ($CSRF->check_valid(sanitize($_GET['token'], 3), 'admin_users_killspam'))
			{
				$user= $db->get_row('SELECT * FROM ' . table_users .' where user_login="'.sanitize($_GET["user"], 3).'"');
				killspam($user->user_id);
				header("Location: ".my_pligg_base."/admin/admin_users.php");
				die();

			} else {
				$CSRF->show_invalid_error(1);
			}
		}

		if (sanitize($_GET["mode"], 3) == "search"){	// search users	
			$CSRF->create('admin_users_list', true, true);
			global $offset, $page_size;
			// Items per page drop-down
			if(isset($_GET["pagesize"]) && is_numeric($_GET["pagesize"])) {
				misc_data_update('pagesize',$_GET["pagesize"]);
			}
			$pagesize = get_misc_data('pagesize');
			if ($pagesize <= 0) $pagesize = 30;
			$main_smarty->assign('pagesize', $pagesize);
		
			if($_GET["filter"]) {
			   $filter_sql = " user_level='".sanitize($_GET["filter"], 3)."' ";
			} else {
			   $filter_sql = " user_level!='Spammer' ";
			}

			if($_GET["keyword"] && $_GET["keyword"]!= $main_smarty->get_config_vars('PLIGG_Visual_Search_SearchDefaultText')){
			    $search_sql = "AND (user_login LIKE '%".sanitize($_GET["keyword"], 3)."%' OR user_email LIKE '%".sanitize($_GET["keyword"], 3)."%')";
			}

			// figure out what "page" of the results we're on
			$offset=(get_current_page()-1)*$pagesize;
			$searchsql = mysql_query($sql="SELECT SQL_CALC_FOUND_ROWS * FROM " . table_users . " where $filter_sql $search_sql ORDER BY `user_date` LIMIT $offset,$pagesize");
			$rows = $db->get_var("SELECT FOUND_ROWS()");
			$userlist = array();
			
			while ($row = mysql_fetch_array ($searchsql, MYSQL_ASSOC)) array_push ($userlist, $row);
				foreach($userlist as $key => $val){
					$userlist[$key]['Avatar'] = get_avatar('large', "", $val['user_login'], $val['user_email']);
				}					
				$main_smarty->assign('userlist', $userlist);					
				
			// breadcrumbs and page title
			$navwhere['text1'] = $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel');
			$navwhere['link1'] = getmyurl('admin', '');
			$navwhere['text2'] = $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel_1');
			$navwhere['link2'] = my_pligg_base . "/admin/admin_users.php";
			$navwhere['text3'] = $main_smarty->get_config_vars('PLIGG_Visual_Breadcrumb_Search'). sanitize($_GET["keyword"], 3);
			$main_smarty->assign('navbar_where', $navwhere);
			$main_smarty->assign('posttitle', " / " . $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel'));
			
			// pagename	
			define('pagename', 'admin_users'); 
			$main_smarty->assign('pagename', pagename);

			// show the template
			$main_smarty->assign('tpl_center', '/admin/users');
			if ($is_moderator == '1'){
				$main_smarty->display($template_dir . '/admin/moderator.tpl');
			} else {
				$main_smarty->display($template_dir . '/admin/admin.tpl');
			}

		}
	
	} else { // No options are selected, so show the list of users.			
		$CSRF->create('admin_users_list', true, true);
		global $offset, $top_users_size;
		
		// Items per page drop-down
		if(isset($_GET["pagesize"]) && is_numeric($_GET["pagesize"])) {
			misc_data_update('pagesize',$_GET["pagesize"]);
		}
		
		$pagesize = get_misc_data('pagesize');
		
		if ($pagesize <= 0) $pagesize = 30;
			$main_smarty->assign('pagesize', $pagesize);
	
	if(isset($_GET["filter"])) {
		switch (sanitize($_GET["filter"], 3)) {
		 	case 'admin':
				$filter_sql = " WHERE user_level='admin' ";
				break;
			case 'moderator':
				$filter_sql = " WHERE user_level='moderator' ";
				break;
			case 'normal':
				$filter_sql = " WHERE user_level='normal' ";
				break;
			case 'spammer':
				$filter_sql = " WHERE user_level='Spammer' ";
				break;
			case 'disabled':
				$filter_sql = " WHERE user_level!='Spammer' AND user_enabled='0' ";
				break;
			default:
				$filter_sql = " WHERE user_level!='Spammer' ";
				break;
	  	}
	} else {
	   $filter_sql = "WHERE user_level!='Spammer'";
	}

		// figure out what "page" of the results we're on
		$offset=(get_current_page()-1)*$pagesize;
		$users = mysql_query("SELECT SQL_CALC_FOUND_ROWS * FROM " . table_users . " $filter_sql ORDER BY `user_date` DESC LIMIT $offset,$pagesize");
		$rows = $db->get_var("SELECT FOUND_ROWS()");
		$userlist = array();
		
		while ($row = mysql_fetch_array ($users, MYSQL_ASSOC)) array_push ($userlist, $row);
		foreach($userlist as $key => $val){
			$userlist[$key]['Avatar'] = get_avatar('large', "", $val['user_login'], $val['user_email']);
		}
		
		$main_smarty->assign('userlist', $userlist);
		
		// breadcrumbs anf page title
		$navwhere['text1'] = $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel');
		$navwhere['link1'] = getmyurl('admin', '');
		$navwhere['text2'] = $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel_1');
		$navwhere['link2'] = my_pligg_base . "/admin/admin_users.php";
		$main_smarty->assign('navbar_where', $navwhere);
		$main_smarty->assign('posttitle', " / " . $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel'));
		
		// pagename
		define('pagename', 'admin_users'); 
		$main_smarty->assign('pagename', pagename);

		// show the template
		$main_smarty->assign('tpl_center', '/admin/users');
		if ($is_moderator == '1'){
			$main_smarty->display($template_dir . '/admin/moderator.tpl');
		} else {
			$main_smarty->display($template_dir . '/admin/admin.tpl');
		}
	}
} else {
	echo 'You don\'t have permission to view this page.';
}		
		
function showmyerror()
{
	global $main_smarty, $the_template;
	$main_smarty->assign('user', sanitize($_GET["user"], 3));

	// breadcrumbs and page title
	$navwhere['text1'] = $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel');
	$navwhere['link1'] = getmyurl('admin', '');
	$navwhere['text2'] = $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel_1');
	$navwhere['link2'] = my_pligg_base . "/admin/admin_users.php";
	$navwhere['text3'] = $main_smarty->get_config_vars('PLIGG_Visual_Breadcrumb_User_Does_Not_Exist');
	$main_smarty->assign('navbar_where', $navwhere);
	$main_smarty->assign('posttitle', " / " . $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel'));
	
	// pagename	define('pagename', 'admin_users'); 

	$main_smarty->assign('pagename', pagename);

	// show the template
	$main_smarty->assign('tpl_center', '/admin/user_does_not_exist');
	if ($is_moderator == '1'){
		$main_smarty->display($template_dir . '/admin/moderator.tpl');
	} else {
		$main_smarty->display($template_dir . '/admin/admin.tpl');
	}
}
?>
