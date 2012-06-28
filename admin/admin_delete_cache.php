<?php
include_once('../Smarty.class.php');
$main_smarty = new Smarty;

include('../config.php');
include(mnminclude.'html1.php');
include(mnminclude.'link.php');
include(mnminclude.'user.php');
include(mnminclude.'smartyvariables.php');

check_referrer();

// require user to log in
force_authentication();

// restrict access to god only
$canIhaveAccess = 0;
$canIhaveAccess = $canIhaveAccess + checklevel('god');

if($canIhaveAccess == 0){	
	header("Location: " . getmyurl('login', $_SERVER['REQUEST_URI']));
	die();
}

// ------------ lixlpixel recursive PHP functions -------------
// recursive_remove_directory( directory to delete, empty )
// expects path to directory and optional TRUE / FALSE to empty
// of course PHP has to have the rights to delete the directory
// you specify and all files and folders inside the directory
// ------------------------------------------------------------

// to use this function to totally remove a directory, write:
// recursive_remove_directory('path/to/directory/to/delete');

// to use this function to empty a directory, write:
// recursive_remove_directory('path/to/full_directory',TRUE);

function recursive_remove_directory($directory, $empty=TRUE)
{
	// if the path has a slash at the end we remove it here
	if(substr($directory,-1) == '../cache')
	{
		$directory = substr($directory,0,-1);
	}

	// if the path is not valid or is not a directory ...
	if(!file_exists($directory) || !is_dir($directory))
	{
		// ... we return false and exit the function
		return FALSE;

	// ... if the path is not readable
	}elseif(!is_readable($directory))
	{
		// ... we return false and exit the function
		return FALSE;

	// ... else if the path is readable
	}else{

		// we open the directory
		$handle = opendir($directory);

		// and scan through the items inside
		while (FALSE !== ($item = readdir($handle)))
		{
			// if the filepointer is not the current directory
			// or the parent directory
			if($item != '.' && $item != '..')
			{
				// we build the new path to delete
				$path = $directory.'/'.$item;

				// if the new path is a directory
				if(is_dir($path)) 
				{
					// we call this function with the new path
					recursive_remove_directory($path);

				// if the new path is a file
				}else{
					// we remove the file
					unlink($path);
				}
			}
		}
		// close the directory
		closedir($handle);

		// if the option to empty is not set to true
		if($empty == FALSE)
		{
			// try to delete the now empty directory
			if(!rmdir($directory))
			{
				// return false if not possible
				return FALSE;
			}
		}
		
		//rebuild blank index.html files
		 $html = '';
		 
		 file_put_contents('../cache/index.html', $html);
		 file_put_contents('../cache/admin_c/index.html', $html);
		 file_put_contents('../cache/templates_c/index.html', $html);		
			
		// return success
		return TRUE;
	}
}
// ------------------------------------------------------------

recursive_remove_directory('../cache',TRUE);

?>
<div style="padding:8px;margin:14px 2px;border:1px solid #bbb;background:#eee;">
	<h2 style="font-size: 18px;margin:0;padding:0;border-bottom:1px solid #629ACB;"><?php echo $main_smarty->get_config_vars('PLIGG_Visual_AdminPanel_Cleared_Cache') ?></h2>
	<p style=\'font:13px arial, "Lucida Grande","Lucida Sans Unicode",Tahoma,Verdana,sans-serif;\'><?php echo $main_smarty->get_config_vars('PLIGG_Visual_AdminPanel_Cleared_Cache_Message') ?></p>
	<p style='font:13px arial, "Lucida Grande","Lucida Sans Unicode",Tahoma,Verdana,sans-serif;'><a style="color:#094F89;" href="admin_index.php" onclick="parent.$.fn.colorbox.close(); return false;"><?php echo $main_smarty->get_config_vars('PLIGG_Visual_AdminPanel_Return_Admin') ?></a></p>
</div>