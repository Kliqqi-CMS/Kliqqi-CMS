<?php
include('class_HTTPRequest.php');
$language = addslashes(strip_tags($_REQUEST['language']));
include ('header.php');

if($language != 'local'){
	include_once('../languages/installer_lang.php');
} else {
	include_once('../languages/installer_lang_default.php');
}

if($_GET['language'] == ''){
	$url = 'http://www.pligg.com/languages/check/getLanguageList.php?version=200';
	$r = new CD_HTTPRequest($url);
	$data = $r->DownloadToString();
	if(strpos($data, '<!--Pligg Language Select-->') > 0){
		echo $data;
	} else {
	    echo '<div class="alert">';
		echo 'We just tried to connect to Pligg.com to get all of the language files available for installation, but there was a problem. That\'s okay because we can continue by using the local English version.';
		echo '</div>';
		echo '<a class="btn btn-primary" href = "install.php?language=local">Click to Continue in English</a>';
	}
	include ('footer.php');
	die();

} else {

	$language = addslashes(strip_tags($_GET['language']));
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
		
		$r = new CD_HTTPRequest('http://www.pligg.com/languages/check/lang_' . $language . '.conf');
		$contents = $r->DownloadToString();
		if ($contents)
		{
			$ml = fopen('../languages/lang_' . $language . '.conf', 'w') or die("Can't open local language file!");
			fwrite($ml, $contents);
			$_SESSION['language'] = $language;
		}
	    } else {
			echo '<div class="alert">';
			echo 'We just tried to connect to Pligg.com to get all of the language files available for installation, but there was a problem. That\'s okay because we can continue by using the local English version.';
			echo '</div>';
			echo '<a class="btn btn-primary" href = "install.php?language=local">Click to Continue in English</a>';
			include ('footer.php');
		die();
	    }
	}

	$step = 1;

}

?>
<meta http-equiv="refresh" content="0;url=install.php?step=1">


