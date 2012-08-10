<?php
//
// Dropbox Backup Module
// Written by Eric "Yankidank" Heikkinen
//

function dropbox_backup_showpage(){
	global $db, $main_smarty, $the_template;
		
	include_once('config.php');
	include_once(mnminclude.'html1.php');
	include_once(mnminclude.'link.php');
	include_once(mnminclude.'tags.php');
	include_once(mnminclude.'smartyvariables.php');
	
	$main_smarty = do_sidebar($main_smarty);

	force_authentication();
	$canIhaveAccess = 0;
	$canIhaveAccess = $canIhaveAccess + checklevel('admin');
	
	if($canIhaveAccess == 1)
	{	
		// Save Settings
		if ($_POST['submit'])
		{
			misc_data_update('dropbox_backup_email', sanitize($_REQUEST['dropbox_backup_email'], 3));
			//misc_data_update('dropbox_backup_save', sanitize($_REQUEST['dropbox_backup_save'], 3));
			//$dropbox_backup_save=escapeshellcmd(get_misc_data('dropbox_backup_save'));
			//if ($dropbox_backup_save == "Yes"){
				misc_data_update('dropbox_backup_pass', sanitize($_REQUEST['dropbox_backup_pass'], 3));
			//} else {
			//	misc_data_update('dropbox_backup_pass', '');
			//}
			misc_data_update('dropbox_backup_dir', sanitize($_REQUEST['dropbox_backup_dir'], 3));
		}
		
		// Perform Backup
		if ($_GET['action'] == 'backup') {
		
			// Current Directory
			$path = "admin/backup/";
			$db_path = "modules/dropbox_backup/backup/";
			
			// Check if it is Writable
			$backup_permissions = substr(sprintf('%o', fileperms($db_path)), -4);
			if ($backup_permissions !== '0777'){
				$error = 'The directory /' . $db_path . ' is not writable! Set the CHMOD permissions to 777 and try again.';
			} else {
				
				$files = array();
				$dir = opendir('admin/backup');
				while(($file = readdir($dir)) !== false) {
					if($file !== '.' && $file !== '..' && !is_dir($file) && $file !== 'index.htm') {
						$files[] = $file;  
					}
				}
				closedir($dir);  
				sort($files);  
				if (count($files) != '0'){
					
					/*
					Copyright (c) 2011 http://ramui.com. All right reserved.
					This product is protected by copyright and distributed under licenses restricting copying, distribution. Permission is granted to the public to download and use this script provided that this Notice and any statement of authorship are reproduced in every page on all copies of the script.
					*/
					class recurseZip
					{
						private function recurse_zip($src,&$zip,$path) {
							$dir = opendir($src);
							while(false !== ( $file = readdir($dir)) ) {
								if (( $file != '.' ) && ( $file != '..' )) {
									if ( is_dir($src . '/' . $file) ) {
										$this->recurse_zip($src . '/' . $file,$zip,$path);
									}
									else {
										$zip->addFile($src . '/' . $file,substr($src . '/' . $file,$path));
									}
								}
							}
							closedir($dir);
						}

						public function compress($src,$dst='')
						{
							if(substr($src,-1)==='/'){$src=substr($src,0,-1);}
							if(substr($dst,-1)==='/'){$dst=substr($dst,0,-1);}
							$path=strlen(dirname($src).'/');
							$rand = substr(md5(microtime()),rand(0,26),5);
							$zipname = 'Pligg'."_".date("Y-m-d_H-i-s").'_'.$rand.'.zip';
							$dst=empty($dst)? $zipname : $dst.'/'.$zipname;
							@unlink($dst);
							$zip = new ZipArchive;
							$res = $zip->open($dst, ZipArchive::CREATE);
							if($res !== TRUE){
								$status = 'error';
								$message = 'Error: Unable to create zip file';
							}
							if(is_file($src)){$zip->addFile($src,substr($src,$path));}
							else{
								if(!is_dir($src)){
									$zip->close();
									@unlink($dst);
									$status = 'error';
									$message = 'Error: File not found';
									}
							$this->recurse_zip($src,$zip,$path);}
							$zip->close();
							return $dst;
						}
					}
					
					//Source file or directory to be compressed.
					$src='admin/backup';
					//Destination folder where we create Zip file.
					$dst='modules/dropbox_backup/backup';
					$z=new recurseZip();
					$fullpath = $z->compress($src,$dst);
					$source = basename($fullpath);
					
					$status = 'success';
					$message = 'The file has been sent to your Dropbox account.';
	
					// Send to Dropbox
					$dropbox_email=escapeshellcmd(get_misc_data('dropbox_backup_email'));	// Dropbox email address
					$dropbox_pass=escapeshellcmd(get_misc_data('dropbox_backup_pass'));   	// Dropbox password
					//$dropbox_pass_save=escapeshellcmd(get_misc_data('dropbox_backup_save'));// Save password?
					$dropbox_dir=escapeshellcmd(get_misc_data('dropbox_backup_dir'));		// DropBox directory (optional) - Folder on the Dropbox 
					include('DropboxUploader.php');
					$uploader = new DropboxUploader($dropbox_email, $dropbox_pass);
					// $uploader->setCaCertificateFile("modules/dropbox_backup/ca-bundle.crt");
					$uploader->upload($dst.'/'.$source,$dropbox_dir);
					// Delete the file
					$delete_me = $dst.'/'.$source;
					chmod($delete_me, 0666);
					unlink($delete_me);
				}else{
					$status = 'error';
					$message = '<h3>No backup files were found!</h3><p>Please <a href="admin/admin_backup.php">make a backup from this page</a> before trying to upload to Dropbox.</p>';
				}
			}
		}
		
		$main_smarty->assign('status', $status);
		$main_smarty->assign('message', $message);
		$main_smarty->assign('error', $error);
		
		// Breadcrumbs
		$navwhere['text1'] = $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel');
		$navwhere['link1'] = getmyurl('admin', '');
		$navwhere['text2'] = "Dropbox Backup";
		$navwhere['link2'] = my_pligg_base . "/module.php?module=dropbox_backup";
		$main_smarty->assign('navbar_where', $navwhere);
		$main_smarty->assign('posttitle', " / " . $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel'));
		
		define('modulename', 'dropbox_backup'); 
		$main_smarty->assign('modulename', modulename);
		
		define('pagename', 'dropbox_backup_admin'); 
		$main_smarty->assign('pagename', pagename);
		$main_smarty->assign('settings', str_replace('"','&#034;',get_dropbox_backup_settings()));
		$main_smarty->assign('tpl_center', dropbox_backup_tpl_path . 'dropbox_backup_main');
		$main_smarty->display($template_dir . '/admin/admin.tpl');
		
	} else {
		header("Location: " . getmyurl('login', $_SERVER['REQUEST_URI']));
	}
}	

// 
// Read module settings
//
function get_dropbox_backup_settings()
{
    return array(
		'dropbox_backup_email' => get_misc_data('dropbox_backup_email'), 
		'dropbox_backup_pass' => get_misc_data('dropbox_backup_pass'),
		//'dropbox_backup_save' => get_misc_data('dropbox_backup_save'),
		'dropbox_backup_dir' => get_misc_data('dropbox_backup_dir')
		);
}

?>