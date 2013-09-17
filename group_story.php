<?php
include_once('internal/Smarty.class.php');
$main_smarty = new Smarty;
include('config.php');
include(mnminclude.'html1.php');
include(mnminclude.'link.php');
include(mnminclude.'group.php');
include(mnminclude.'smartyvariables.php');
include(mnminclude.'csrf.php');

if(isset($_REQUEST['id'])){$requestID = strip_tags($_REQUEST['id']);}
if(!is_numeric($requestID)){$requestID = 0;}
if($_REQUEST['title'])
{
	$requestTitle = $db->escape(strip_tags($_REQUEST['title']));
	//$requestTitle = sanitize($_GET['title'], 3);
	$requestID = $db->get_var("SELECT group_id FROM " . table_groups . " WHERE group_safename = '".$requestTitle."';");
} elseif ($requestID)
	$requestTitle = $db->get_var("SELECT group_safename FROM " . table_groups . " WHERE group_id = '".$requestID."';");
// find the name of the current category
if(isset($_REQUEST['category'])){
	$thecat = get_cached_category_data('category_safe_name', sanitize($_REQUEST['category'], 1));
	$catID = $thecat->category_id;
	$thecat = $thecat->category_name;
}


// breadcrumbs and page titles
$navwhere['text1'] = $main_smarty->get_config_vars('PLIGG_Visual_Breadcrumb_Submit');
$navwhere['link1'] = getmyurl('submit', '');
$navwhere['text2'] = $thecat;
$main_smarty->assign('posttitle', $requestTitle);
$main_smarty = do_sidebar($main_smarty);


// pagename
define('pagename', 'group_story'); 

$main_smarty->assign('pagename', pagename); 

$privacy = $db->get_var("SELECT group_privacy FROM " . table_groups . " WHERE group_id = '$requestID';");
$view = sanitize(sanitize($_REQUEST["view"],1),3);
if($requestID > 0)
{
	//For Infinit scrolling and continue reading option 
	
    if (($privacy!='private' || isMemberActive($requestID)=='active'))
    {
		 $main_smarty->assign('group_shared_rows', group_shared($requestID,$catID,1));
		 $main_smarty->assign('group_published_rows', group_stories($requestID,$catID,'published',1));
		 $main_smarty->assign('group_new_rows', group_stories($requestID,$catID,'new',1));
		
        switch ($view) {
            case 'shared':
                group_shared($requestID,$catID);
                break;
			 case 'published':
                group_stories($requestID,$catID,'published');
                break;
			
			 case 'new':
                group_stories($requestID,$catID,'new');
                break;
					
            case 'members':
                member_display($requestID);
                break;
            default:
                group_stories($requestID,$catID,$view);
				
        }
    }
    else
    {
	$main_smarty->assign('group_shared_display', $main_smarty->get_config_vars('PLIGG_Visual_Group_Is_Private'));
	$main_smarty->assign('group_new_display', $main_smarty->get_config_vars('PLIGG_Visual_Group_Is_Private'));
	$main_smarty->assign('group_published_display', $main_smarty->get_config_vars('PLIGG_Visual_Group_Is_Private'));
	$main_smarty->assign('member_display', $main_smarty->get_config_vars('PLIGG_Visual_Group_Is_Private'));
    }
} else 
{
	$redirect = '';
	$redirect = getmyurl("groups");
	header("Location: $redirect");
	die;
}

//displaying group as story
if(isset($requestID))
	group_display($requestID);

$main_smarty->assign('group_members', get_group_members($requestID));


if($view == '') $view = 'published';
$main_smarty->assign('groupview', $view);

if(Auto_scroll==2 || Auto_scroll==3){
		$main_smarty->assign('groupID', $requestID);
		$main_smarty->assign('viewtype', $view);
	}
	

if ($view == 'new')
    $main_smarty->assign('URL_rss_page', getmyurl('rssgroup', $requestTitle, 'new'));
elseif ($view == 'published')
    $main_smarty->assign('URL_rss_page', getmyurl('rssgroup', $requestTitle));
elseif ($view != 'members')
    $main_smarty->assign('URL_rss_page', getmyurl('rssgroup', $requestTitle, $view));

$main_smarty->assign('groupview_published', getmyurl('group_story2', $requestTitle, 'published'));
$main_smarty->assign('groupview_new', getmyurl('group_story2', $requestTitle, 'new'));
if ($view == 'shared')
    $main_smarty->assign('URL_maincategory', getmyurl('group_story2', $requestTitle, 'shared',"category"));
else
    $main_smarty->assign('URL_maincategory', getmyurl('group_story2', $requestTitle, 'published',"category"));
$main_smarty->assign('URL_newcategory', getmyurl('group_story2', $requestTitle, 'new',"category"));
$main_smarty->assign('groupview_sharing', getmyurl('group_story2', $requestTitle, 'shared'));
$main_smarty->assign('groupview_members', getmyurl('group_story2', $requestTitle, 'members'));

$main_smarty->assign('group_edit_url', getmyurl('editgroup',$requestID));
$main_smarty->assign('group_delete_url', getmyurl('deletegroup',$requestID));

$CSRF = new csrf();

// uploading avatar
if($_POST["avatar"] == "uploaded")
{
	check_referrer();

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
			$main_smarty->assign('Avatar_uploaded', 'Avatar uploaded successfully. You may need to refresh the page to see the new image.');
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

	/*// create small avatar
	$img=new pThumb();
	$img->pSetSize(group_avatar_size_width, group_avatar_size_height);
	$img->pSetQuality(100);
	$img->pCreate($newimage);
	$img->pSave($user_image_path . $idname . "_".group_avatar_size_width.".jpg");
	$img = "";*/
    } else {
    	$CSRF->show_invalid_error(1);
	exit;
    }
}
$CSRF->create('edit_group', true, true);

$main_smarty->assign('tpl_center', $the_template . '/group_story_center');
$main_smarty->display($the_template . '/pligg.tpl');

function cleanit($value)
{
	$value = strip_tags($value);
	$value = trim($value);
	return $value;
}
?>
