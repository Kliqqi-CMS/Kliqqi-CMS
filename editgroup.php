<?php

include_once('internal/Smarty.class.php');
$main_smarty = new Smarty;

include('config.php');
include(mnminclude.'html1.php');
include(mnminclude.'link.php');
include(mnminclude.'group.php');
include(mnminclude.'smartyvariables.php');
include(mnminclude.'csrf.php');

check_referrer();

if(isset($_REQUEST['id'])){$requestID = strip_tags($_REQUEST['id']);}
if(!is_numeric($requestID)){$requestID = 0;}
if(isset($_REQUEST['title'])){$requestTitle = $db->escape(strip_tags($_REQUEST['title']));}

//check group admin
$canIhaveAccess = checklevel('admin');
$canIhaveAccess = checklevel('moderator');

if($current_user->user_id != get_group_creator($requestID) && $canIhaveAccess != 1)
{
	//page redirect
	$redirect = '';
	$redirect = getmyurl("group_story", $requestID);
//	header("Location: $redirect");
	die;
}

// pagename
define('pagename', 'editgroup'); 
$main_smarty->assign('pagename', pagename); 

$CSRF = new csrf();

// uploading avatar
if($_POST["avatar"] == "uploaded")
{
    $CSRF->check_expired('edit_group');
    if ($CSRF->check_valid(sanitize($_POST['token'], 3), 'edit_group')){
		$user_image_path = "avatars/groups_uploaded" . "/";
		$user_image_apath = "/" . $user_image_path;
		$allowedFileTypes = array("image/jpeg","image/gif","image/png",'image/x-png','image/pjpeg');
		unset($imagename);
		$myfile = $_FILES['image_file']['name'];
		$imagename = basename($myfile);
		$mytmpfile = $_FILES['image_file']['tmp_name'];
		if(!in_array($_FILES['image_file']['type'],$allowedFileTypes))
		{
			$error['Type'] = 'Only these file types are allowed : jpeg, gif, png';
		}
	 
		if(empty($error))
		{
			$imagesize = getimagesize($mytmpfile);
			$width = $imagesize[0];
			$height = $imagesize[1];
			$idname = $_POST["idname"];
			if(!is_numeric($idname)){die();}
			$imagename = $idname . "_original.jpg";
			$newimage = $user_image_path . $imagename ;
			$result = @move_uploaded_file($_FILES['image_file']['tmp_name'], $newimage);
			if(empty($result))
				$error["result"] = "There was an error moving the uploaded file.";
			else {
				$avatar_source = cleanit($_POST['avatarsource']);

				$sql = "UPDATE " . table_groups . " set group_avatar='uploaded' WHERE group_id=$idname";
				$db->query($sql);
				$main_smarty->assign('Avatar_uploaded', 'Avatar uploaded successfully! You may need to refresh the page to see the new image.');
				/*if($avatar_source != "" && $avatar_source != "useruploaded"){
					loghack('Updating profile, avatar source is not one of the list options.', 'username: ' . $_POST["username"].'|email: '.$_POST["email"]);
					$avatar_source == "";
				}*/
				//$user->avatar_source=$avatar_source;
				//$user->store();
			}
		}
		// create large avatar
		include mnminclude . "class.pThumb.php";
		$img=new pThumb();
		$img->pSetSize(group_avatar_size_width, group_avatar_size_height);
		$img->pSetQuality(100);
		$img->pCreate($newimage);
		$img->pSave($user_image_path . $idname . "_".group_avatar_size_width.".jpg");
		$img = "";
    } else {
    	$CSRF->show_invalid_error(1);
		exit;
    }
}
elseif(isset($_POST["action"]))
{
    $CSRF->check_expired('edit_group');
    if ($CSRF->check_valid(sanitize($_POST['token'], 3), 'edit_group')){
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
	$group_name = $group_title;
	$group_safename = makeUrlFriendly($group_title, true);
	if(isset($_POST['group_privacy']))
		$group_privacy = $db->escape(sanitize($_POST['group_privacy'],3));
	
	if (!$group_title) $errors = $main_smarty->get_config_vars('PLIGG_Visual_Group_Empty_Title');
	elseif ($group_vote_to_publish<=0) $errors = $main_smarty->get_config_vars('PLIGG_Visual_Group_Empty_Votes');
	else
	{
		$exists = $db->get_var("select COUNT(*) from ".table_groups." WHERE group_name='$group_name' AND group_id != '$requestID'");
	 	if ($exists) $errors = $main_smarty->get_config_vars('PLIGG_Visual_Group_Title_Exists');
	}

	if (!$errors && 
	    $db->query("update ". table_groups ." set group_name = '".$group_title."', group_safename='$group_safename', group_description = '".$group_description."', group_privacy = '".$group_privacy."', group_vote_to_publish = '".$group_vote_to_publish."', group_notify_email=$group_notify_email where group_id = '".$requestID."'"))
		$errors = $main_smarty->get_config_vars('PLIGG_Visual_Group_Saved_Changes');

	$main_smarty->assign("errors",$errors);
    } else {
    	$CSRF->show_invalid_error(1);
	exit;
    }
}
$CSRF->create('edit_group', true, true);

//displaying group as story
if(isset($requestID))
	group_display($requestID);

$main_smarty->assign('tpl_center', $the_template . '/edit_group_center');
$main_smarty->display($the_template . '/pligg.tpl');

function cleanit($value)
{
	$value = strip_tags($value);
	$value = trim($value);
	return $value;
}
?>
