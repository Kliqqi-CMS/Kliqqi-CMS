<?php
if (!$step) { header('Location: ./install.php'); die(); }

if ($_POST['language'])
    $language = addslashes(strip_tags($_POST['language']));
if($language == 'arabic'){
	include_once('./languages/lang_arabic.php');
}elseif($language == 'catalan'){
	include_once('./languages/lang_catalan.php');
}elseif($language == 'chinese_simplified'){
	include_once('./languages/lang_chinese_simplified.php');
}elseif($language == 'french'){
	include_once('./languages/lang_french.php');
}elseif($language == 'german'){
	include_once('./languages/lang_german.php');
}elseif($language == 'italian'){
	include_once('./languages/lang_italian.php');
}elseif($language == 'russian'){
	include_once('./languages/lang_russian.php');
}elseif($language == 'thai'){
	include_once('./languages/lang_thai.php');
} else {
	$language = 'english';
	include_once('./languages/lang_english.php');
}

$file='../config.php';
if (!file_exists($file)) { $errors[]="$file " . $lang['NotFound'] ; }
elseif (filesize($file) <= 0) { $errors[]="$file " . $lang['ZeroBytes'] ; }

$file='../settings.php';
if (!file_exists($file)) { $errors[]="$file " . $lang['SettingsNotFound'] ; }
elseif (filesize($file) <= 0) { $errors[]="$file " . $lang['ZeroBytes'] ; }
elseif (!is_writable($file)) { $errors[]="$file " . $lang['NotEditable'] ; }

$file='../libs/dbconnect.php';
if (!file_exists($file)) { $errors[]="$file " . $lang['DbconnectNotFound'] ; }
elseif (!is_writable($file)) { $errors[]="$file " . $lang['NotEditable'] ; }

$file='../cache';
if (!file_exists($file)) { $errors[]="$file " . $lang['CacheNotFound'] ; }
elseif (!is_writable($file)) { $errors[]="$file " . $lang['NotEditable'] ; }

$language = addslashes(strip_tags($_REQUEST['language']));
$file="../languages/lang_$language.conf";
if (!file_exists($file)) { $errors[]="$file " . $lang['LangNotFound'] ; }
elseif (!is_writable($file)) { $errors[]="$file " . $lang['NotEditable'] ; }

if (!$errors) {

$output='
<form class="form-horizontal" id="form1" name="form1" action="install.php" method="post">
	<fieldset>
		<p>' . $lang['EnterMySQL'] . '</p>
		
		<div class="control-group">
			<label for="input01" class="control-label">' . $lang['DatabaseName'] . '</label>
			<div class="controls">
				<input class="form-control" name="dbname" type="text" value="" />
			</div>
		</div>

		<div class="control-group">
			<label for="input01" class="control-label">' . $lang['DatabaseUsername'] . '</label>
			<div class="controls">
				<input class="form-control" name="dbuser" type="text" value="" />
			</div>
		</div>
		  
		<div class="control-group">
			<label for="input01" class="control-label">' . $lang['DatabasePassword'] . '</label>
			<div class="controls">
				<input class="form-control" name="dbpass" type="password" value="" />
			</div>
		</div>
		
		<div class="control-group">
			<label for="input01" class="control-label">' . $lang['DatabaseServer'] . '</label>
			<div class="controls">
				<input class="form-control" name="dbhost" type="text" value="localhost" />
			</div>
		</div>

		<div class="control-group">
			<label for="input01" class="control-label">' . $lang['TablePrefix'] . '</label>
			<div class="controls">
				<input class="form-control" name="tableprefix" type="text" value="pligg_" />
				<p class="help-block">' . $lang['PrefixExample'] . '</p>
			</div>
		</div>
		
		<div class="form-actions">
			<input type="submit" class="btn btn-primary" name="Submit" value="' . $lang['CheckSettings'] . '" />
			<button class="btn btn-default" onclick="history.go(-1)">Back</button>
		</div>
		
		<input type="hidden" name="language" value="' . addslashes(strip_tags($_REQUEST['language'])) . '">
		<input type="hidden" name="step" value="3">
	</fieldset>
</form>
';


}
else { 
	$output=DisplayErrors($errors);
	$output.='<div class="alert">' . $lang['Errors'] . '</div>';
}

echo $output;

?>
