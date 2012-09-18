<?php
/**
 * License GNU/LGPL
 * @package Zip_Install
 * @copyright (C) 2007 EXP Team
 * @url http://www.pliggtemplates.eu/
 * @author XrByte <info@exp.ee>, Grusha <grusha@feellove.eu>
**/

/* for localhost uses only 
			$source_link = explode("/", $_SERVER[REQUEST_URI]);
			$dir_location = $_SERVER[DOCUMENT_ROOT]."/".$source_link[1];

$absolute_path = $dir_location;
*/
	
function zip_install_preview_admin() {
	global $main_smarty, $the_template, $db, $my_pligg_base;

	force_authentication();
	$amIgod = 0;
	$amIgod = $amIgod + checklevel('admin');
	if($amIgod == 1) {
			
		$navwhere['text1'] = $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel');
		$navwhere['link1'] = getmyurl('admin', '');

		$main_smarty->display(zip_install_tpl_path . '/blank.tpl');
		
		$navwhere['text2'] = 'ZIP Install';
		$navwhere['link2'] = my_pligg_base . '/module.php?module=zip_install';

		$navwhere['text3'] = '';
		$navwhere['link3'] = '';
		$navwhere['text4'] = '';
		$navwhere['link4'] = '';


		$main_smarty = do_sidebar($main_smarty);

		$main_smarty->assign('navbar_where', $navwhere);
		$main_smarty->assign('posttitle', " / " . $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel'));
	
		$action = $_REQUEST['action'];
		switch($action) {
			case "modules": {
				$main_smarty->assign('tpl_center', zip_install_tpl_path . 'zip_install_modules');
				$main_smarty->display($template_dir . '/admin/admin.tpl');			
				break;
			}
			case "templates": {
				$main_smarty->assign('tpl_center', zip_install_tpl_path . 'zip_install_templates');
				$main_smarty->display($template_dir . '/admin/admin.tpl');			
				break;
			}
			case "filemod": {
				if(uploadFile(zip_install_absolute_path, $_FILES, "modules"))
					redirect(my_pligg_base . '/admin/admin_modules.php?status=uninstalled');
				break;
			}
			case "filetem": {
				if(uploadFile(zip_install_absolute_path, $_FILES, "templates")) {
					redirect(my_pligg_base . '/admin/admin_config.php?page=Template');
				}
				break;
			}			
			default: {
				$main_smarty->assign('tpl_center', zip_install_tpl_path . 'zip_install');
				$main_smarty->display($template_dir . '/admin/admin.tpl');
				break;
			}
		}
 	}	
}

/**
* This function is borrowed the module ' RSS_IMPORT '. file name is rss_import_main.php
*/
function redirect($url, $msg){
	// due to some servers not redirecting the way we would like we
	// have this function to handle that

	global $main_smarty;
	
	if(strpos($_SERVER['SERVER_SOFTWARE'], "IIS") && strpos(php_sapi_name(), "cgi") >= 0){
		header("Expires: " . gmdate("r", time()-3600));
		// use js to try to redirect
		echo '<SCRIPT LANGUAGE="JavaScript">window.location="' . $url . '";</script>';
		// in case the js fails show a link
		echo $main_smarty->get_config_vars($msg) . '<a href = "'.$url.'">' . $main_smarty->get_config_vars('PLIGG_Visual_IIS_Continue') . '</a>';
	} else {
		header('Location: ' . $url);
	}
}

function uploadFile($absolute_path, $file, $extdir) {
	$noMatch = 0;
	if($file["archzip"]["size"] > 0) {
		$allowable = array (
			'zip'
		);
		$ext = explode(".", basename($file["archzip"]["name"]));
		foreach($allowable as $val) {
			if(strcasecmp( $ext[count($ext)-1], $val ) == 0 ) {
				$noMatch = 1;
			}			
		}		
		if($noMatch) {
			$dir_location = $absolute_path.$extdir;
			require_once($absolute_path."modules/zip_install/lib/pclerror.lib.php");
			require_once($absolute_path."modules/zip_install/lib/pclzip.lib.php");
			$upload_file = $dir_location."/".basename($file["archzip"]["name"]);
			if(move_uploaded_file($file["archzip"]["tmp_name"], $upload_file)) {
				$files_dir = $dir_location."/".basename($upload_file);
				$files_place = substr($files_dir, 0, strlen($files_dir)-4);			
				if(!is_dir($files_place)) {
					if (mkdir($files_place, 0777)) {
						$zip  = new PclZip($upload_file);
						$return = $zip->extract( PCLZIP_OPT_PATH, $files_place);
						if($return == 0) {
							echo "<script> alert('";
							echo "Unrecoverable error ".$zip->errorName(true);
							echo "'); window.history.go(-1); </script>\n";
							exit();
						} else {
							if(@unlink($upload_file))
								return(1);
						}
					}
					else {
						echo "<script> alert('";
						echo "Can't to create folder. Permission denied.";
						echo "'); window.history.go(-1); </script>\n";
						exit();						
					}
				}
				else {
					@unlink($upload_file);
					echo "<script> alert('";
					echo "Module directory already exists.";
					echo "'); window.history.go(-1); </script>\n";
					exit();
				}
			}
			else {
				echo "<script> alert('";
				echo "Upload Error";
				echo "'); window.history.go(-1); </script>\n";
				exit();				
			}
		}
		else {
			echo "<script> alert('";
			echo "Upload Error.";
			echo "'); window.history.go(-1); </script>\n";
			exit();				
		}
	}
	return(0);
}

?>