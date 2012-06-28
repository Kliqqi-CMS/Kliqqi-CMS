<?php 
if(!defined('mnminclude')){header('Location: ../404error.php');die();}

	// after your Pligg is installed, change this to false
	$do_check = true;

	if($do_check == true){
		if (strpos($_SERVER['SCRIPT_NAME'], "install.php") == 0){
			$errors = array();
			$file = dirname(__FILE__) . '/../settings.php'; 
			if (!file_exists($file)) { $errors[]="<div style='background:#FFFFCC;margin:0 20px;padding:10px;border:1px solid #000;'>/settings.php was not found!<br /> Try renaming 'settings.php.default' to 'settings.php'</div>"; }
			elseif (filesize($file) <= 0) { $errors[]="<div style='background:#FFFFCC;margin:0 20px;padding:10px;'>/settings.php is 0 bytes!</div>"; }
	
			$file = dirname(__FILE__) . '/../libs/dbconnect.php'; 
			if (!file_exists($file)) { $errors[]="<div style='background:#FFFFCC;margin:0 20px;padding:10px;border:1px solid #000;'>/libs/dbconnect.php was not found!<br />Try renaming 'dbconnect.php.default' to 'dbconnect.php'</div>"; }
	
			$file= dirname(__FILE__) . '/../cache/templates_c'; 
			if (!file_exists($file)) { $errors[]="<div style='background:#FFFFCC;margin:0 20px;padding:10px;border:1px solid #000;'>/cache/templates_c/ was not found!<br />Create a directory called templates_c in your cache directory.</div>"; }
			elseif (!is_writable($file)) { $errors[]="<div style='background:#FFFFCC;margin:0 20px;padding:10px;border:1px solid #000;'>/cache/templates_c/ is not writable!<br />Please chmod this directory to 777</div>"; }
	
			$file= dirname(__FILE__) . '/../cache'; 
			if (!file_exists($file)) { $errors[]="<div style='background:#FFFFCC;margin:0 20px;padding:10px;border:1px solid #000;'>/cache/ was not found! Create a directory called cache in your root directory.</div>"; }
			elseif (!is_writable($file)) { $errors[]="<div style='background:#FFFFCC;margin:0 20px;padding:10px;border:1px solid #000;'>/cache/ is not writable!<br />Please chmod this directory to 777</div>"; }
	
			if (sizeof($errors)) {	
				$output = '';
				echo "<body style='background:#fff url(./templates/admin/images/pre_install.png) repeat-x top center;'><ol style='width:600px;'><h1 style='color:#fff;margin-top:25px;margin-bottom:35px;'> No Installation Detected!</h1><p><strong>Haven't set up your Pligg site yet?</strong><br />Please fix the errors below and proceed to the <a href='./readme.html'>Pligg Readme</a> or the <a href='./install/'>Pligg Installation</a> which will attempt to rename the .default files for you.</p><div style='position:absolute;bottom:0;left:0;width:100%;height:40px;font-size:20px;text-align:center;'><a style='color:#000;' href='http://www.pligg.com'>Pligg CMS</a></div>";
				foreach ($errors as $error) {
					$output.="<li style='font-size:34px'> </li> $error \n";
					$output.='<div style="background:#CC0000;color:#fff;font-weight:bold;margin:0 20px;padding:10px;">Please fix the above error, install halted!</div><br />';
				}
				die($output);
				echo '</ol></body>';
			}
			
			
		}
	}
?>
