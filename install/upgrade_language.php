<?php
$language = addslashes(strip_tags($_REQUEST['language']));
include ('header.php');

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

if($_GET['language'] == '' && $_GET['step'] == ''){
	$data = file_get_contents('./languages/language_list_upgrade.html');
	if(strpos($data, '<!--Pligg Language Select-->') > 0){
		echo $data;
	} else {
	    echo '<div class="alert">';
		echo 'We are having issues with displaying the local language file list. You can continue by using the default English installer.';
		echo '</div>';
		echo '<a class="btn btn-primary" href = "upgrade.php?step=1&language=english">Click to Continue in English</a>';
	}
	//include ('footer.php');
	die();

} else {

	$step = 1;

}

?>
<meta http-equiv="refresh" content="0;url=upgrade.php?step=1">
