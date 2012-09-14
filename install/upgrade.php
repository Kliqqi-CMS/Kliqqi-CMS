<?php
error_reporting(E_ALL^E_NOTICE);
$page = 'upgrade';
include('class_HTTPRequest.php');
if ($_GET['language'])
    $language = addslashes(strip_tags($_GET['language']));
include ('header.php');
define("mnmpath", dirname(__FILE__).'/../');
define("mnminclude", dirname(__FILE__).'/../libs/');
define("mnmmodules", dirname(__FILE__).'/../modules/');
include_once '../settings.php';
if ($_GET['language'])
    $language = $_GET['language'];
if($language != 'local'){
	include_once('../languages/installer_lang.php');
} else {
	include_once('../languages/installer_lang_default.php');
}

if($language == '' && $_POST['submit'] == ''){
	$url = 'http://www.pligg.com/languages/check/getLanguageList.php?type=upgrade&version=200';

	$r = new CD_HTTPRequest($url);
	$data = $r->DownloadToString();
	if(strpos($data, '!--Pligg Language Select-->') > 0){
		echo $data;
	} else {
	    echo '<div class="alert">';
		echo 'We just tried to connect to Pligg.com to get all of the language files available for installation, but there was a problem. That\'s okay because we can continue by using the local English version.';
		echo '</div>';
		echo '<a class="btn btn-primary" href = "upgrade.php?language=local">Click to Continue in English</a>';
	}

	include ('footer.php');
	
	die();

} else {

	if($language != 'local'){
	    $url = 'http://www.pligg.com/languages/check/getLanguageFile.php?type=installer&version=200&language=' . $language;
	    $r = new CD_HTTPRequest($url);
	    $data = $r->DownloadToString();

	    if (strpos($data,'$lang[') > 0) {
		$filename = '../languages/installer_lang.php';
		$fh=fopen($filename,"w");

		if (fwrite($fh, $data)) {
			fclose($fh);
		} else {
			$url = 'http://www.pligg.com/languages/check/chmod_' . $language . '.php';
			$r = new CD_HTTPRequest($url);
			echo $r->DownloadToString();
			die();
		}
	    } else {
	    echo '<div class="alert">';
		echo 'We just tried to connect to Pligg.com to get all of the language files available for installation, but there was a problem. That\'s okay because we can continue by using the local English version.';
		echo '</div>';
		echo '<a class="btn btn-primary" href = "upgrade.php?language=local">Click to Continue in English</a>';
		include ('footer.php');
		die();
	    }		
	}	

	$step = 1;

}


$include='header.php'; if (file_exists($include)) { include_once($include); }
$include='functions.php'; if (file_exists($include)) { include_once($include); }


echo '<h3>' . $lang['UpgradeTop'] . '</h3>';

$file='../config.php';
if (!file_exists($file)) { $errors[]="$file " . $lang['NotFound'] ; }
elseif (filesize($file) <= 0) { $errors[]="$file " . $lang['ZeroBytes'] ; }

$file='../settings.php';
if (!file_exists($file)) { $errors[]="$file " . $lang['NotFound'] ; }
elseif (filesize($file) <= 0) { $errors[]="$file " . $lang['ZeroBytes'] ; }
elseif (!is_writable($file)) { $errors[]="$file " . $lang['NotEditable'] ; }

$file='../libs/dbconnect.php';
if (!file_exists($file)) { $errors[]="$file " . $lang['NotFound'] ; }
elseif (filesize($file) <= 0) { $errors[]="$file " . $lang['ZeroBytes'] ; }

if (!$errors) {
    echo '<p>' . $lang['UpgradeHome'] . '</p>';

    //this checks to see if they actually do want to upgrade.
    if (!$_POST['submit']) {
	echo '<p><strong>' . $lang['UpgradeAreYouSure'] . '</strong></p>
	<form id="form" name="form" method="post">
	<input type="submit" class="btn btn-primary" name="submit" value="' . $lang['UpgradeYes'] . '" />
	</form>';
    }       	
    else { //they clicked yes!
	$include='../config.php';
	if (file_exists($include)) { 
		include_once($include);
		include(mnminclude.'html1.php');
	}
	
	// Language File Upgrade
	$languageContent = '../languages/lang_' . $language . '.conf';
	$languageContent = file_get_contents($languageContent);

	// Lets start with 1.0.0 and work our way up to the latest version available.
	$oldLanguage100 = "// End 1.0.0 Language File";
	$newLanguage101='http://www.pligg.com/languages/update/lang_' . $language . '_update_101.conf';
	//echo $newLanguage101;
	$r = new CD_HTTPRequest($newLanguage101);
	$content = $r->DownloadToString();
	if($content)
		$languageContent = str_replace($oldLanguage100 , $content , $languageContent);

	$oldLanguage101 = "// End 1.0.1 Language File";
	$newLanguage102='http://www.pligg.com/languages/update/lang_' . $language . '_update_102.conf';
	$r = new CD_HTTPRequest($newLanguage102);
	$content = $r->DownloadToString();
	if($content)
		$languageContent = str_replace($oldLanguage101 , $content , $languageContent);
		
	$oldLanguage102 = "// End 1.0.2 Language File";
	$newLanguage103='http://www.pligg.com/languages/update/lang_' . $language . '_update_103.conf';
	$r = new CD_HTTPRequest($newLanguage103);
	$content = $r->DownloadToString();
	if($content)
		$languageContent = str_replace($oldLanguage102 , $content , $languageContent);
		
	$oldLanguage103 = "// End 1.0.3 Language File";
	$newLanguage104='http://www.pligg.com/languages/update/lang_' . $language . '_update_104.conf';
	$r = new CD_HTTPRequest($newLanguage104);
	$content = $r->DownloadToString();
	if($content)
		$languageContent = str_replace($oldLanguage103 , $content , $languageContent);
		
	$oldLanguage104 = "// End 1.0.4 Language File";
	$newLanguage110='http://www.pligg.com/languages/update/lang_' . $language . '_update_110.conf';
	$r = new CD_HTTPRequest($newLanguage110);
	$content = $r->DownloadToString();
	if($content)
		$languageContent = str_replace($oldLanguage104 , $content , $languageContent);
		
	$oldLanguage110 = "// End 1.1.0 Language File";
	$newLanguage111='http://www.pligg.com/languages/update/lang_' . $language . '_update_111.conf';
	$r = new CD_HTTPRequest($newLanguage111);
	$content = $r->DownloadToString();
	if($content)
		$languageContent = str_replace($oldLanguage110 , $content , $languageContent);
		
	$oldLanguage111 = "// End 1.1.1 Language File";
	$newLanguage112='http://www.pligg.com/languages/update/lang_' . $language . '_update_112.conf';
	$r = new CD_HTTPRequest($newLanguage112);
	$content = $r->DownloadToString();
	if($content)
		$languageContent = str_replace($oldLanguage111 , $content , $languageContent);
	
	$oldLanguage112 = "// End 1.1.2 Language File";
	$newLanguage113='http://www.pligg.com/languages/update/lang_' . $language . '_update_113.conf';
	$r = new CD_HTTPRequest($newLanguage113);
	$content = $r->DownloadToString();
	if($content)
		$languageContent = str_replace($oldLanguage112 , $content , $languageContent);

	$oldLanguage113 = "// End 1.1.3 Language File";
	$newLanguage114='http://www.pligg.com/languages/update/lang_' . $language . '_update_114.conf';
	$r = new CD_HTTPRequest($newLanguage114);
	$content = $r->DownloadToString();
	if($content)
		$languageContent = str_replace($oldLanguage113 , $content , $languageContent);
	
	$oldLanguage114 = "// End 1.1.4 Language File";
	$newLanguage115='http://www.pligg.com/languages/update/lang_' . $language . '_update_115.conf';
	$r = new CD_HTTPRequest($newLanguage115);
	$content = $r->DownloadToString();
	if($content)
		$languageContent = str_replace($oldLanguage114 , $content , $languageContent);
	
	$oldLanguage115 = "// End 1.1.5 Language File";
	$newLanguage120='http://www.pligg.com/languages/update/lang_' . $language . '_update_120.conf';
	$r = new CD_HTTPRequest($newLanguage120);
	$content = $r->DownloadToString();
	if($content)
		$languageContent = str_replace($oldLanguage115 , $content , $languageContent);
		
	$oldLanguage120 = "// End 1.2.0 Language File";
	$newLanguage121='http://www.pligg.com/languages/update/lang_' . $language . '_update_121.conf';
	$r = new CD_HTTPRequest($newLanguage121);
	$content = $r->DownloadToString();
	if($content)
		$languageContent = str_replace($oldLanguage120 , $content , $languageContent);
		
	$oldLanguage121 = "// End 1.2.1 Language File";
	$newLanguage122= "// End 1.2.2 Language File";
	$languageContent = str_replace($oldLanguage121 , $newLanguage122 , $languageContent);
	
	$oldLanguage122 = "// End 1.2.2 Language File";
	$newLanguage200='http://www.pligg.com/languages/update/lang_' . $language . '_update_200.conf';
	$r = new CD_HTTPRequest($newLanguage200);
	$content = $r->DownloadToString();
	if($content)
		$languageContent = str_replace($oldLanguage122 , $content , $languageContent);
		
// echo $languageContent;

	// Point to the file that's going to be written to.
	$filename = '../languages/lang_' . $language . '.conf';
	echo '<p>'.$lang['LanguageUpdate'] . '</p>';
	// Let's make sure the language file exists and is writable first.
	if (is_writable($filename)) {

		if (!$handle = fopen($filename, 'w')) {
			 echo '<p>$filename' . $lang['NotFound'] . '</p>';
			 exit;
		}

		// Write $languageContent to the opened language file.
		if (fwrite($handle, $languageContent) === FALSE) {
			echo '<p>$filename' . $lang['NotEditable'] . '</p>';
			exit;
		}

		echo '<p>'.$lang['UpgradeLanguage'] . '</p>';

		fclose($handle);
	} else {
		echo '<p>$filename' . $lang['NotEditable'] . '</p>';
	}
	// End Language File Upgrade

	echo '<p>'.$lang['UpgradingTables'] . '<ul>';
    
	$tableexists = checkfortable(table_misc_data);
	if (!$tableexists) {
		$sql = "CREATE TABLE `" . table_misc_data . "` (
			`name` VARCHAR( 20 ) NOT NULL ,
			`data` TEXT NOT NULL ,
			PRIMARY KEY ( `name` )
			) ENGINE = MyISAM;";
		$db->query($sql);
		
	
			
		$sql = "INSERT INTO `" . table_misc_data . "` ( `name` , `data` ) VALUES ('pligg_version', '2.0.0');";
		$db->query($sql);
		//Captcha upgrade:
		$sql = "INSERT INTO `" . table_misc_data . "` ( `name` , `data` ) VALUES ('captcha_method', 'reCaptcha');";
		$db->query($sql);
		$sql = "INSERT INTO `" . table_misc_data . "` ( `name` , `data` ) VALUES ('reCaptcha_pubkey', '6LfwKQQAAAAAAPFCNozXDIaf8GobTb7LCKQw54EA');";
		$db->query($sql);
		$sql = "INSERT INTO `" . table_misc_data . "` ( `name` , `data` ) VALUES ('reCaptcha_prikey', '6LfwKQQAAAAAALQosKUrE4MepD0_kW7dgDZLR5P1');";
		$db->query($sql);
	} else {
		// Get version specific updates
		$sql = "SELECT data FROM " . table_misc_data . " WHERE name = 'pligg_version'";
		$pligg_version = $db->get_var($sql);
		$old_version = str_replace('.', '' , $pligg_version);
		
		include_once('version/1.x.php');
		include_once('version/2.0.php');
		$sql = "UPDATE `" . table_misc_data . "` SET `data` = '2.0.0' WHERE `name` = 'pligg_version';";
		$db->query($sql);
	}
	
	echo '<li>Regenerating the totals table</li>';
	totals_regenerate();
	
	echo '<li>Clearing /cache directory</li>';
	include_once('../internal/Smarty.class.php');
	$smarty = new Smarty;
	$smarty->config_dir= '';
	$smarty->compile_dir = "../cache";
	$smarty->template_dir = "../templates";
	$smarty->config_dir = "..";
	$smarty->clear_compiled_tpl();
	
	include(mnminclude.'admin_config.php');
	$config = new pliggconfig;
	$config->create_file("../settings.php");
	
	echo '</ul></p><div class="alert alert-info">' . $lang['IfNoError'] . '</div></p>';

    //end of if post submit is Yes.
    }
//end of no errors
}
else { 
	echo DisplayErrors($errors);
	echo '<p>' . $lang['PleaseFix'] . '</p>';
}

$include='footer.php'; if (file_exists($include)) { include_once($include); }
?>