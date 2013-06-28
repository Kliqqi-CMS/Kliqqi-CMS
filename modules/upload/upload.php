<?php
session_start();
include_once('../../internal/Smarty.class.php');
$main_smarty = new Smarty;
$main_smarty->compile_dir = "../../cache";

include('../../config.php');
include('../../libs/html1.php');
include('../../libs/link.php');
include_once('../../libs/utils.php');
#include('../../libs/smartyvariables.php');

$upload_dir = mnmpath . get_misc_data('upload_directory');
$thumb_dir  = mnmpath . get_misc_data('upload_thdirectory');
$isadmin = checklevel('admin');

// Upload a file 
if ($_POST['id'])
{
	$linkres=new Link;
	$linkres->id = sanitize($_POST['id'], 3);
	if(!is_numeric($linkres->id)) die("Wrong ID");
	if(!is_numeric($_POST['number']) || $_POST['number']<=0) die("Wrong number");
	if($_POST['number'] > get_misc_data('upload_maxnumber')) die("Too many files");

	// Remove old file and thumbnails with same number
	$sql = "SELECT * FROM ".table_prefix."files WHERE ".($isadmin ? "" : "file_user_id='{$current_user->user_id}' AND")." file_link_id='{$_POST['id']}' AND file_number='{$_POST['number']}' AND file_comment_id='$_POST[comment]'";
    	if ($files = $db->get_results($sql))
	    foreach ($files as $row)
	    {
	    	if ($row->file_size=='orig')
		    @unlink("$upload_dir/{$row->file_name}");
		else
		    @unlink("$thumb_dir/{$row->file_name}");
	    }
	$sql = "DELETE FROM ".table_prefix."files WHERE ".($isadmin ? "" : "file_user_id='{$current_user->user_id}' AND")." file_link_id='{$_POST['id']}' AND file_number='{$_POST['number']}' AND file_comment_id='$_POST[comment]'";
	$db->query($sql); 

	// Save unique file ID
	$id = upload_save_files();
	if (is_numeric($id))
	{	
	    if ($id > 0)
	    {
	    	$_SESSION['upload_files'][$_POST['number']] = array('id' => $id, 'comment' => $_POST[comment]);
	    	$db->query("UPDATE ".table_prefix."files SET file_number='{$_POST['number']}' WHERE file_id='$id' OR file_orig_id='$id'");
	    	print "File uploaded successfully";
	    }
	    else
	    	$_SESSION['upload_files'][$_POST['number']] = array('error' => "No files to upload");
	} else 
	    $_SESSION['upload_files'][$_POST['number']] = array('error' => $id);
}
// Check upload status by linkID and file number
elseif ($_GET['id'] && $_GET['number'] && is_numeric($_GET['id']) && is_numeric($_GET['number']) && $_SESSION['upload_files'][$_GET['number']])
{
	if ($_SESSION['upload_files'][$_GET['number']]['error'])
	{
	    print "ERROR: ".$_SESSION['upload_files'][$_GET['number']]['error'];
	    exit;
	}

	$main_smarty->assign('my_base_url', my_base_url);
	$main_smarty->assign('my_pligg_base', my_pligg_base);
	$main_smarty->assign('upload_directory',get_misc_data('upload_directory')); 
	$main_smarty->assign('upload_thdirectory',get_misc_data('upload_thdirectory'));
	$main_smarty->assign('upload_allow_hide',get_misc_data('upload_allow_hide'));

	$id = $_SESSION['upload_files'][$_GET['number']]['id'];
	$main_smarty->assign("number",$_GET['number']);
	$sql =  "SELECT * FROM ".table_prefix."files WHERE ".($isadmin ? "" : "file_user_id='{$current_user->user_id}' AND")." (file_id='$id' OR file_orig_id='$id') ORDER BY file_orig_id";
	if ($images = $db->get_results($sql,ARRAY_A))
	{
	    // Check if file is an image
	    $main_smarty->assign("file",$images[0]['file_name']);
	    $main_smarty->assign("ispicture",$images[0]['file_ispicture']);
	    if (strpos($images[0]['file_name'],'http')===0)
	    	$filename = $images[0]['file_name'];
	    else
	    	$filename = $upload_dir."/".$images[0]['file_name'];

	    if (!$images[0]['file_ispicture']) 
		$images = array();
	}
	$main_smarty->assign ("display",unserialize(get_misc_data('upload_display')));
	$main_smarty->assign ("images",$images);
	$main_smarty->assign ("submit_id",$_GET['id']);
	$main_smarty->config_load('../lang.conf');
	$main_smarty->display("upload_ajax.tpl");
}
// Delete uploaded image
elseif ($_GET['delid'] && $_GET['number'] && is_numeric($_GET['delid']) && is_numeric($_GET['number']) && $_SESSION['upload_files'][$_GET['number']]['id'])
{
    $id = $_SESSION['upload_files'][$_GET['number']]['id'];
    $sql = "SELECT * FROM ".table_prefix."files WHERE ".($isadmin ? "" : "file_user_id='{$current_user->user_id}' AND")." (file_id='$id' OR file_orig_id='$id')";
    if ($files = $db->get_results($sql))
    	foreach ($files as $row)
	{
    	    if ($row->file_size=='orig')
		unlink("$upload_dir/{$row->file_name}");
	    else
		unlink("$thumb_dir/{$row->file_name}");
	}
    $sql = "DELETE FROM ".table_prefix."files WHERE ".($isadmin ? "" : "file_user_id='{$current_user->user_id}' AND")." (file_id='$id' OR file_orig_id='$id')";
    $db->query($sql); 
    unset ($_SESSION['upload_files'][$_GET['number']]);
    print "OK";
}
// Turn thumbnails and files on/off
elseif ($_GET['switchid'] && $_GET['number'] && is_numeric($_GET['switchid']) && is_numeric($_GET['number']) && $_SESSION['upload_files'][$_GET['number']]['id'])
{
    $id  = $_SESSION['upload_files'][$_GET['number']]['id'];
    $sql = "UPDATE ".table_prefix."files SET ".
				($_GET['mode']=='thumb' ? 'file_hide_thumb=1-file_hide_thumb' : 'file_hide_file=1-file_hide_file').
				" WHERE ".($isadmin ? "" : "file_user_id='{$current_user->user_id}' AND")." (file_id='$id' OR file_orig_id='$id')";
    mysql_query($sql);
    print "OK";
}
?>
