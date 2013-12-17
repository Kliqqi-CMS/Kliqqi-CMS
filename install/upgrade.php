<?php
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING ^ E_STRICT);
$page = 'upgrade';
define("mnmpath", dirname(__FILE__).'/../');
define("mnminclude", dirname(__FILE__).'/../libs/');
define("mnmmodules", dirname(__FILE__).'/../modules/');
include_once '../settings.php';

// Set $step
if (isset($_REQUEST['step'])) { $step=addslashes(strip_tags($_REQUEST['step'])); }

//check for no steps, start on step1
if ((!isset($step)) || ($step == "")) { $step = 0; }

// If they haven't selected a step yet, start them off at the language selection screen
if ($step == 0) { 
	include('upgrade_language.php');
}

$include='header.php'; 

// Sanitize and set $language
if ($_GET['language'])
    $language = addslashes(strip_tags($_GET['language']));
	
// Set connect $language to install language file
if($language == 'arabic'){
	include_once('./languages/lang_arabic.php');
} elseif($language == 'catalan'){
	include_once('./languages/lang_catalan.php');
} elseif($language == 'chinese_simplified'){
	include_once('./languages/lang_chinese_simplified.php');
} elseif($language == 'french'){
	include_once('./languages/lang_french.php');
} elseif($language == 'german'){
	include_once('./languages/lang_german.php');
} elseif($language == 'italian'){
	include_once('./languages/lang_italian.php');
} elseif($language == 'russian'){
	include_once('./languages/lang_russian.php');
} elseif($language == 'thai'){
	include_once('./languages/lang_thai.php');
} else {
	include_once('./languages/lang_english.php');
}

if ($step == 1) { 
	include('upgrade1.php');
}

if($language == '' && $_POST['submit'] == ''){
	$data = file_get_contents('./languages/language_list_upgrade.html');

	if(strpos($data, '<!--Pligg Language Select-->') > 0){
		echo $data;
	} else {
	    echo '<div class="alert">';
		echo 'We just tried to get all of the language files available for installation, but there was a problem. That\'s okay because we can continue by using the local English version.';
		echo '</div>';
		echo '<a class="btn btn-primary" href = "upgrade.php?language=local">Click to Continue in English</a>';
	}

	include ('footer.php');
	
	die();

} else {
	$step = 1;
}

$include='footer.php'; if (file_exists($include)) { include_once($include); }
?>