<?php
// The source code packaged with this file is Free Software.
//  Copyright (C) 2005 by Ricardo Galli <gallir at uib dot es>.
//  Copyright (C) 2005 - 2008 Pligg, LLC <www.pligg.com>.
// You can get copies of the licenses here: http://www.affero.org/oagpl.html
// AFFERO GENERAL PUBLIC LICENSE is also included in the file called "COPYING".

include_once('../Smarty.class.php');
$main_smarty = new Smarty;

include('../config.php');
include(mnminclude.'html1.php');
include(mnminclude.'link.php');
include(mnminclude.'smartyvariables.php');
include(mnminclude.'csrf.php');

check_referrer();

// require user to log in
force_authentication();

// restrict access to god only
$canIhaveAccess = 0;
$canIhaveAccess = $canIhaveAccess + checklevel('god');

if($canIhaveAccess == 0){	
//	$main_smarty->assign('tpl_center', '/admin/admin_access_denied');
//	$main_smarty->display($template_dir . '/admin/admin.tpl');			
	header("Location: " . getmyurl('login', $_SERVER['REQUEST_URI']));
	die();
}

// breadcrumbs and page title
$navwhere['text1'] = $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel');
$navwhere['link1'] = getmyurl('admin', '');
$navwhere['text2'] = $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel_Editor');
$main_smarty->assign('navbar_where', $navwhere);
$main_smarty->assign('posttitle', " / " . $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel'));

// pagename
define('pagename', 'admin_editor'); 
$main_smarty->assign('pagename', pagename);

// read the mysql database to get the pligg version
$sql = "SELECT data FROM " . table_misc_data . " WHERE name = 'pligg_version'";
$pligg_version = $db->get_var($sql);
$main_smarty->assign('version_number', $pligg_version); 

$filedir = "../templates/".The_Template;
#echo $filedir;

$valid_ext[1] = "css";
$valid_ext[2] = "tpl";

if ($_SERVER['REQUEST_METHOD'] != 'POST')
{
    $files = array();
    if (is_readable($filedir)) {
	$filelist = directoryToArray($filedir, true);
	foreach ($filelist as $file) {
	    $ext = substr(strrchr($file, '.'), 1);
		if (in_array($ext,$valid_ext) && is_writable($file)) {
			$files[] = $file;
		}
	}
    }
    $main_smarty->assign('files', $files);
}
elseif ($_POST["the_file"])
{
    $file2open = fopen($_POST["the_file"], "r");
    if ($file2open) {
	    $current_data = @fread($file2open, filesize($_POST["the_file"]));
	    $current_data = str_ireplace("</textarea>", "<END-TA-DO-NOT-EDIT>", $current_data);
	    $main_smarty->assign('filedata', htmlspecialchars($current_data));
	    fclose($file2open);
    } else 
	    $main_smarty->assign('error', 1);
    $main_smarty->assign('the_file', sanitize($_POST['the_file'],3));
}
elseif ($_POST["save"])
{
	if (!$_POST["updatedfile"] && !$_POST['isempty'])
		$error = "<h3>ERROR!</h3><p>File NOT saved! <br /> You can't save blank file without confirmation. <br />  <a href=\"\">Click here to go back to the editor.</a></p>";
	elseif ($file2ed = fopen($_POST["the_file2"], "w+")) {
		$data_to_save = $_POST["updatedfile"];
		$data_to_save = str_ireplace("<END-TA-DO-NOT-EDIT>", "</textarea>", $data_to_save);
		$data_to_save = stripslashes($data_to_save);
		if (fwrite($file2ed,$data_to_save)!==FALSE) { 
			$error = "<h3>File Saved</h3><p><a href=\"\">Click here to go back to the editor.</a></p>";	
			fclose($file2ed);
		}
		else {	
			$error = "<h3>ERROR!</h3><p>cant File NOT saved! <br /> Check your CHMOD settings in case it is a file/folder permissions problem. <br />  <a href=\"\">Click here to go back to the editor.</a></p>";
			fclose($file2ed);
		}
	}
	else 
		$error = "<h3>ERROR!</h3><p>writable File NOT saved! <br />Check your CHMOD settings in case it is a file/folder permissions problem.</p>";
     	$main_smarty->assign('error', $error);
}

// show the template
$main_smarty->assign('tpl_center', '/admin/editor_center');
$main_smarty->display($template_dir . '/admin/admin.tpl');	

	
function directoryToArray($directory, $recursive) {
$me = basename($_SERVER['PHP_SELF']);	
$array_items = array();
	if ($handle = opendir($directory)) {
  	while (false !== ($file = readdir($handle))) {
			if ($file != "." && $file != ".." && $file != $me && substr($file,0,1) != '.') {
        if (is_dir($directory. "/" . $file)) {
					if($recursive) {
						$array_items = array_merge($array_items, directoryToArray($directory. "/" . $file, $recursive));
          }						 
				}
				else {
            $file = $directory . "/" . $file;
            $array_items[] = preg_replace("/\/\//si", "/", $file);
				}
      }
    }
    closedir($handle);
		asort($array_items);
  }
  return $array_items;
}

?>
