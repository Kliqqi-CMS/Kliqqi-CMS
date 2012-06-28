<?php
// The source code packaged with this file is Free Software, Copyright (C) 2005 by
// Ricardo Galli <gallir at uib dot es>.
// It's licensed under the AFFERO GENERAL PUBLIC LICENSE unless stated otherwise.
// You can get copies of the licenses here:
// 		http://www.affero.org/oagpl.html
// AFFERO GENERAL PUBLIC LICENSE is also included in the file called "COPYING".

include_once('Smarty.class.php');
$main_smarty = new Smarty;

include('config.php');
include(mnminclude.'html1.php');
include(mnminclude.'link.php');
include(mnminclude.'tags.php');
include(mnminclude.'user.php');
include(mnminclude.'csrf.php');
include(mnminclude.'smartyvariables.php');

#ini_set('display_errors', 1);
error_reporting(E_ALL ^ E_NOTICE);

check_referrer();

// sessions used to prevent CSRF
	$CSRF = new csrf();

// sidebar
$main_smarty = do_sidebar($main_smarty);

$canIhaveAccess = 0;
$canIhaveAccess = $canIhaveAccess + checklevel('god');
$canIhaveAccess = $canIhaveAccess + checklevel('admin');

// If not logged in, redirect to the index page
if ($_GET['login'] && $canIhaveAccess) 
	$login=$_GET['login'];
elseif ($current_user->user_id > 0 && $current_user->authenticated) 
	$login=$current_user->user_login;
else {
	header('Location: '.$my_base_url.$my_pligg_base);
	die;
}

// breadcrumbs and page title
$navwhere['text1'] = $main_smarty->get_config_vars('PLIGG_Visual_Breadcrumb_Profile');
$navwhere['link1'] = getmyurl('user2', $login, 'profile');
$navwhere['text2'] = $login;
$navwhere['link2'] = getmyurl('user2', $login, 'profile');
$navwhere['text3'] = $main_smarty->get_config_vars('PLIGG_Visual_Profile_ModifyProfile');
$navwhere['link3'] = getmyurl('profile', '');
$main_smarty->assign('navbar_where', $navwhere);
$main_smarty->assign('posttitle', $main_smarty->get_config_vars('PLIGG_Visual_Profile_ModifyProfile'));

// read the users information from the database
$user=new User();
$user->username = $login;
if(!$user->read()) {
	echo "invalid user";
	die;
}
	// uploading avatar
	if(isset($_POST["avatar"]) && sanitize($_POST["avatar"], 3) == "uploaded" && Enable_User_Upload_Avatar == true){

		if ($CSRF->check_valid(sanitize($_POST['token'], 3), 'profile_change')){

			$user_image_path = "avatars/user_uploaded" . "/";
			$user_image_apath = "/" . $user_image_path;
			$allowedFileTypes = array("image/jpeg","image/gif","image/png",'image/x-png','image/pjpeg');
			unset($imagename);

			$myfile = $_FILES['image_file']['name'];
			$imagename = basename($myfile);

			$mytmpfile = $_FILES['image_file']['tmp_name'];

			if(!in_array($_FILES['image_file']['type'],$allowedFileTypes)){
				$error['Type'] = 'Only these file types are allowed : jpeg, gif, png';
			}
		 
			if(empty($error)){
				$imagesize = getimagesize($mytmpfile);
				$width = $imagesize[0];
				$height = $imagesize[1];	
		
				$imagename = $user->id . "_original.jpg";
		
				$newimage = $user_image_path . $imagename ;

				$result = @move_uploaded_file($_FILES['image_file']['tmp_name'], $newimage);
				if(empty($result))
					$error["result"] = "There was an error moving the uploaded file.";
			}			
		
			// create large avatar
			include mnminclude . "class.pThumb.php";
			$img=new pThumb();
			$img->pSetSize(Avatar_Large, Avatar_Large);
			$img->pSetQuality(100);
			$img->pCreate($newimage);
			$img->pSave($user_image_path . $user->id . "_".Avatar_Large.".jpg");
			$img = "";
	
			// create small avatar
			$img=new pThumb();
			$img->pSetSize(Avatar_Small, Avatar_Small);
			$img->pSetQuality(100);
			$img->pCreate($newimage);
			$img->pSave($user_image_path . $user->id . "_".Avatar_Small.".jpg");
			$img = "";

		} else {
			echo 'An error occured while uploading your avatar.';
		}
			
	}		

	if(isset($error) && is_array($error)) {
		while(list($key, $val) = each($error)) {
			echo $val;
			echo "<br>";
		}
	}
// display profile
show_profile();

function show_profile() {
	global $user, $main_smarty, $the_template, $CSRF;

	if(isset($_POST['email'])){
		$savemsg = save_profile();
		$main_smarty->assign('savemsg', $savemsg);
	}

	$CSRF->create('profile_change', true, true);

	// assign avatar source to smarty
	$main_smarty->assign('UseAvatars', do_we_use_avatars());
	$main_smarty->assign('Avatar_ImgLarge', get_avatar('large', $user->avatar_source, $user->username, $user->email));
	$main_smarty->assign('Avatar_ImgSmall', get_avatar('small', $user->avatar_source, $user->username, $user->email));

	// module system hook
	$vars = '';
	check_actions('profile_show', $vars);
	
	// assign profile information to smarty
	$main_smarty->assign('user_id', $user->id);
	$main_smarty->assign('user_email', $user->email);
	$main_smarty->assign('user_login', $user->username);
	$main_smarty->assign('user_names', $user->names);
	$main_smarty->assign('user_username', $user->username);
	$main_smarty->assign('user_url', $user->url);
	$main_smarty->assign('user_publicemail', $user->public_email);
	$main_smarty->assign('user_location', $user->location);
	$main_smarty->assign('user_occupation', $user->occupation);
	$main_smarty->assign('user_language', !empty($user->language) ? $user->language : 'english');
	$main_smarty->assign('user_aim', $user->aim);
	$main_smarty->assign('user_msn', $user->msn);
	$main_smarty->assign('user_yahoo', $user->yahoo);
	$main_smarty->assign('user_gtalk', $user->gtalk);
	$main_smarty->assign('user_skype', $user->skype);
	$main_smarty->assign('user_irc', $user->irc);
	$main_smarty->assign('user_karma', $user->karma);
	$main_smarty->assign('user_joined', get_date($user->date));
	$main_smarty->assign('user_avatar_source', $user->avatar_source);
	$user->all_stats();
	$main_smarty->assign('user_total_links', $user->total_links);
	$main_smarty->assign('user_published_links', $user->published_links);
	$main_smarty->assign('user_total_comments', $user->total_comments);
	$main_smarty->assign('user_total_votes', $user->total_votes);
	$main_smarty->assign('user_published_votes', $user->published_votes);

	$languages = array();
	$files = glob("languages/*.conf");
	foreach ($files as $file)
	    if (preg_match('/lang_(.+?)\.conf/',$file,$m))
		$languages[] = $m[1];
	$main_smarty->assign('languages', $languages);
		
	// pagename	
	define('pagename', 'profile'); 
	$main_smarty->assign('pagename', pagename);
	
	$main_smarty->assign('form_action', $_SERVER["PHP_SELF"]);

	// show the template
	$main_smarty->assign('tpl_center', $the_template . '/profile_center');
	$main_smarty->display($the_template . '/pligg.tpl');	
}

function save_profile() {
	global $user, $current_user, $db, $main_smarty, $CSRF, $canIhaveAccess, $language;

	if ($CSRF->check_valid(sanitize($_POST['token'], 3), 'profile_change')){
	
		if(!isset($_POST['save_profile']) || !$_POST['process'] || (!$canIhaveAccess && sanitize($_POST['user_id'], 3) != $current_user->user_id)) return;

		if ($user->email!=sanitize($_POST['email'], 3))
		{
		    if(!check_email(sanitize($_POST['email'], 3))) {
			$savemsg = $main_smarty->get_config_vars("PLIGG_Visual_Profile_BadEmail");
			return $savemsg;
		    } 
		    elseif(email_exists(trim(sanitize($_POST['email'], 3)))) { // if email already exists
			$savemsg = $main_smarty->get_config_vars("PLIGG_Visual_Register_Error_EmailExists");
			return $savemsg;
		    }
		    else {
			if(pligg_validate()){
				$encode=md5($_POST['email'] . $user->karma .  $user->username. pligg_hash().$main_smarty->get_config_vars('PLIGG_Visual_Name'));

				$domain = $main_smarty->get_config_vars('PLIGG_Visual_Name');			
				$validation = my_base_url . my_pligg_base . "/validation.php?code=$encode&uid=".urlencode($user->username)."&email=".urlencode($_POST['email']);
				$str = $main_smarty->get_config_vars('PLIGG_PassEmail_verification_message');
				eval('$str = "'.str_replace('"','\"',$str).'";');
				$message = "$str";

				if(phpnum()>=5)
					require("libs/class.phpmailer5.php");
				else
					require("libs/class.phpmailer4.php");
				$mail = new PHPMailer();
				$mail->From = $main_smarty->get_config_vars('PLIGG_PassEmail_From');
				$mail->FromName = $main_smarty->get_config_vars('PLIGG_PassEmail_Name');
				$mail->AddAddress($_POST['email']);
				$mail->AddReplyTo($main_smarty->get_config_vars('PLIGG_PassEmail_From'));
				$mail->IsHTML(false);
				$mail->Subject = $main_smarty->get_config_vars('PLIGG_PassEmail_Subject_verification');
				$mail->Body = $message;
				$mail->CharSet = 'utf-8';

#print_r($mail);					
				if(!$mail->Send())
					return false;
				$savemsg = $main_smarty->get_config_vars("PLIGG_Visual_Register_Noemail").' '.sprintf($main_smarty->get_config_vars("PLIGG_Visual_Register_ToDo"),$main_smarty->get_config_vars('PLIGG_PassEmail_From'));
			}
			else
				$user->email=sanitize($_POST['email'], 3);
		    }
		}


		$user->url=sanitize($_POST['url'], 3);
		$user->public_email=sanitize($_POST['public_email'], 3);
		$user->location=sanitize($_POST['location'], 3);
		$user->occupation=sanitize($_POST['occupation'], 3);
		$user->aim=sanitize($_POST['aim'], 3);
		$user->msn=sanitize($_POST['msn'], 3);
		$user->yahoo=sanitize($_POST['yahoo'], 3);
		$user->gtalk=sanitize($_POST['gtalk'], 3);
		$user->skype=sanitize($_POST['skype'], 3);
		$user->irc=sanitize($_POST['irc'], 3);
		$user->names=sanitize($_POST['names'], 3);
		if (user_language)
			$user->language=sanitize($_POST['language'], 3);
	
		// module system hook
		$vars = '';
		check_actions('profile_save', $vars);
	
		$avatar_source = sanitize($_POST['avatarsource'], 3);
		if($avatar_source != "" && $avatar_source != "useruploaded"){
			loghack('Updating profile, avatar source is not one of the list options.', 'username: ' . sanitize($_POST["username"], 3) . '|email: ' . sanitize($_POST["email"], 3));
			$avatar_source == "";
		}
		$user->avatar_source=$avatar_source;
	
		if(!empty($_POST['newpassword']) || !empty($_POST['newpassword2'])) {
			$oldpass = sanitize($_POST['oldpassword'], 3);
			$userX=$db->get_row("SELECT user_id, user_pass, user_login FROM " . table_users . " WHERE user_login = '".$user->username."'");
			$saltedpass=generateHash($oldpass, substr($userX->user_pass, 0, SALT_LENGTH));
			if($userX->user_pass == $saltedpass){
				if(sanitize($_POST['newpassword'], 3) !== sanitize($_POST['newpassword2'], 3)) {
					$savemsg = $main_smarty->get_config_vars("PLIGG_Visual_Profile_BadPass");
					return $savemsg;
				} else {
					$saltedpass=generateHash(sanitize($_POST['newpassword'], 3));
					$user->pass = $saltedpass;
					$user->store();
					$savemsg = $main_smarty->get_config_vars("PLIGG_Visual_Profile_PassUpdated");
					return $savemsg;
				}
			} else {
				$savemsg = $main_smarty->get_config_vars("PLIGG_Visual_Profile_BadOldPass");
				return $savemsg;
			}
		}
		$user->store();
		$user->read();
		if ($language != $user->language)
		{
			header("Location: ".getmyurl('profile'));
			exit;
		}
		$current_user->Authenticate($user->username, $user->pass);
		if(!isset($savemsg)){$savemsg = $main_smarty->get_config_vars("PLIGG_Visual_Profile_DataUpdated");}
		return $savemsg;
	} else {
		return 'There was a token error.';
	}
}

?>
