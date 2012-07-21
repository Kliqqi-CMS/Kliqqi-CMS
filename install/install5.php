<?php
if (!$step) { header('Location: ./install.php'); die(); }
echo '<div class="instructions">';
$file='../config.php';
if (!file_exists($file)) { $errors[]="$file " . $lang['NotFound'] ; }
elseif (filesize($file) <= 0) { $errors[]="$file " . $lang['ZeroBytes'] ; }

$file='../settings.php';
if (!file_exists($file)) { $errors[]="$file " . $lang['SettingsNotFound'] ; }
elseif (filesize($file) <= 0) { $errors[]="$file " . $lang['ZeroBytes'] ; }
elseif (!is_writable($file)) { $errors[]="$file " . $lang['NotEditable'] ; }

define("mnminclude", dirname(__FILE__).'/../libs/');
include_once mnminclude.'db.php';
include_once mnminclude.'html1.php';

// Check user input here
if (!$_POST['adminlogin'] ||
    !$_POST['adminpassword'] ||
    !$_POST['adminemail'])
    	$errors[] = $lang['Error5-1'];
elseif ($_POST['adminpassword'] != $_POST['adminpassword2'])
    	$errors[] = $lang['Error5-2'];
		
if (!$errors) {
	include_once( '../config.php' );
	include_once( '../libs/admin_config.php' );
	
	echo "Adding the Admin user account...<br />";
	$userip=$db->escape($_SERVER['REMOTE_ADDR']);
	$saltedpass=generateHash($_POST['adminpassword']);
	$sql = "INSERT INTO `" . table_users . "` (`user_id`, `user_login`, `user_level`, `user_modification`, `user_date`, `user_pass`, `user_email`, `user_names`, `user_karma`, `user_url`, `user_lastlogin`, `user_ip`, `user_lastip`, `last_reset_request`, `user_enabled`) VALUES (1, '".$db->escape($_POST['adminlogin'])."', 'admin', now(), now(), '$saltedpass', '".$db->escape($_POST['adminemail'])."', '', '10.00', 'http://pligg.com', now(), '0', '0', now(), '1');";
	$db->query( $sql );

	//done
	$output='<p><strong>' . $lang['InstallSuccess'] . '</strong></p>
	<br /><h2>' . $lang['WhatToDo'] . '</h2>
	<div class="donext"><ol>
		' . $lang['WhatToDoList'] . '
	</ol></div>';
}

if (isset($errors)) {
	$output=DisplayErrors($errors);
	$output.='<p>' . $lang['Errors'] . '</p>';
}

echo $output;
echo '</div>';

?>
