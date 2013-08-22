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
	include_once('./languages/lang_english.php');
}

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
if (!$_POST['adminlogin'] || !$_POST['adminpassword'] || !$_POST['adminemail']) {
	$errors[] = $lang['Error5-1'];
} elseif ($_POST['adminpassword'] != $_POST['adminpassword2']) {
    $errors[] = $lang['Error5-2'];
}
	
if (!$errors) {
	include_once( '../config.php' );
	include_once( '../libs/admin_config.php' );
	
//	echo "Adding the Admin user account...<br />";
	$userip=$db->escape($_SERVER['REMOTE_ADDR']);
	$saltedpass=generateHash($_POST['adminpassword']);
	$sql = "INSERT INTO `" . table_users . "` (`user_id`, `user_login`, `user_level`, `user_modification`, `user_date`, `user_pass`, `user_email`, `user_names`, `user_karma`, `user_url`, `user_lastlogin`, `user_ip`, `user_lastip`, `last_reset_request`, `user_enabled`) VALUES (1, '".$db->escape($_POST['adminlogin'])."', 'admin', now(), now(), '$saltedpass', '".$db->escape($_POST['adminemail'])."', '', '10.00', 'http://pligg.com', now(), '0', '0', now(), '1');";
	$db->query( $sql );

	// If user specified a site title, change language files.
	if (isset($_POST['sitetitle']) && $_POST['sitetitle'] != ''){
		// Change the value for PLIGG_Visual_Name in the language files
		$replacement = 'PLIGG_Visual_Name = "'.strip_tags($_POST['sitetitle']).'"';
		if (glob("../languages/*.conf")) {
			foreach (glob("../languages/*.conf") as $filename) {
				$filedata = file_get_contents($filename);
				$filedata = preg_replace('/PLIGG_Visual_Name = \"(.*)\"/iu',$replacement,$filedata);
				// print $filedata;
				
				// Write the changes to the language files
				$lang_file = fopen($filename, "w");
				fwrite($lang_file, $filedata);
				fclose($lang_file);
			}
		}
	}
	
	// Add user IP address to approved IP list, so they are never blocked for bad logins
	function get_ip_address() {
		foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key) {
			if (array_key_exists($key, $_SERVER) === true) {
				foreach (explode(',', $_SERVER[$key]) as $ip) {
					if (filter_var($ip, FILTER_VALIDATE_IP) !== false) {
						return $ip;
					}
				}
			}
		}
	}
	$approvedips = '../logs/approvedips.log';
	if (file_exists($approvedips)) {
		$user_ip = get_ip_address();
		if ($user_ip){
			$filedata = "$user_ip \n";
			// print $filedata;
			// echo 'IP: '.get_ip_address();
			
			// Write to the approvedips log file
			$ip_file = fopen($approvedips, "w");
			fwrite($ip_file, $filedata);
			fclose($ip_file);
			
		}
	}
	
	
	// Output success message
	$output = '<div class="jumbotron" style="padding:14px 25px;">
		<h2>' . $lang['InstallSuccess'] . '</h2>
		<p style="font-size:1.2em;">' . $lang['InstallSuccessMessage'] . '</p>
	</div>';
	
	$output .='<p><strong></strong></p>
	<br /><legend>' . $lang['WhatToDo'] . '</legend>
	<div class="donext"><ol>
		' . $lang['WhatToDoList'] . '
	</ol></div>';
	
	if ($_POST['sitetitle'] != ''){
		// Change the site title (PLIGG_Visual_Name) in the language file
		
	}
}

if (isset($errors)) {
	$output=DisplayErrors($errors);
	$output.='<p>' . $lang['Errors'] . '</p>';
}

echo $output;
echo '</div>';

?>
