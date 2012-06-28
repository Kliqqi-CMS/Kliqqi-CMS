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
	$url = 'http://www.pligg.com/languages/check/getLanguageList.php?version=122';
	$r = new CD_HTTPRequest($url);
	$data = $r->DownloadToString();
	if(strpos($data, '<!--Pligg Language Select-->') > 0){
		echo $data;
	} else {
		echo 'We just tried to connect to Pligg.com to get a list of available languages but there was a problem.<br /><br /><a href = "install.php?language=local">Click to Continue in English</a>';
	}
	include ('footer.php');
	die();

} else {

	$language = addslashes(strip_tags($_GET['language']));
	if($language != 'local'){
	    $url = 'http://www.pligg.com/languages/check/getLanguageFile.php?type=installer&version=122&language=' . $language;
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
		echo 'We just tried to connect to Pligg.com to get language file but there was a problem.<br /><br /><a href = "install.php?language=local">Click to Continue in English</a>';
		include ('footer.php');
		die();
	    }
	}

	$step = 1;

}

?>
<meta http-equiv="refresh" content="0;url=install.php?step=1">


