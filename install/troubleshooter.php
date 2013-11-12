<?php
error_reporting(E_ALL^E_NOTICE);
$page = 'troubleshooter';
$include='header.php'; if (file_exists($include)) { include_once($include); }
$include='functions.php'; if (file_exists($include)) { require_once($include); }
?>
<style type="text/css">
.popover-inner {
width:500px;
}
</style>

<script type="text/javascript" language="JavaScript"><!--
function InsertContent(tid) {
if(document.getElementById(tid).style.display == "none") {
	document.getElementById(tid).style.display = "";
	}
else {
	document.getElementById(tid).style.display = "none";
	}
}
//--></script>

<?php

// MySQL Version
// No easy way to determine the version without having established a connection to the database. This method reads the phpinfo data.
ob_start();
phpinfo();
$info = ob_get_contents();
ob_end_clean();
$start = explode("<h2><a name=\"module_mysql\">mysql</a></h2>",$info,1000);
if(count($start) < 2){
	$mysqlversion = '0';
}else{
	$again = explode("<tr><td class=\"e\">Client API version </td><td class=\"v\">",$start[1],1000);
	$last_time = explode(" </td></tr>",$again[1],1000);
	$mysqlversion = $last_time[0];
} 
$pattern = '/[^0-9-.]/i';
$replacement = '';
$mysqlversion = preg_replace($pattern, $replacement, $mysqlversion); 


// Tally up how many items are fulfilled.
$required = 23; // This should be the number of checks being performed
$tally = 0;
if (glob("../languages/*.conf")) { $tally = $tally+1;}
if (phpversion() > 4) { $tally = $tally+1; }
if ($mysqlversion > 4) { $tally = $tally+1; }
if (function_exists('curl_version')){ $tally = $tally+1; }
if (function_exists('fopen')){ $tally = $tally+1; }
if (function_exists('fwrite')){ $tally = $tally+1; }
if (file_get_contents(__FILE__)){ $tally = $tally+1; }
if (function_exists('gd_info')){ $tally = $tally+1; }
if (file_exists('../settings.php')) { $tally = $tally+1; }
if (file_exists('../libs/dbconnect.php')) { $tally = $tally+1; }
if (file_exists('../logs/bannedips.log')) { $tally = $tally+1; }
if (is_writable('../logs/bannedips.log')) { $tally = $tally+1; }
if (file_exists('../logs/domain-blacklist.log')) { $tally = $tally+1; }
if (is_writable('../logs/domain-blacklist.log')) { $tally = $tally+1; }
if (file_exists('../logs/domain-whitelist.log')) { $tally = $tally+1; }
if (is_writable('../logs/domain-whitelist.log')) { $tally = $tally+1; }
if (is_writable('../admin/backup/')) { $tally = $tally+1; }
if (is_writable('../avatars/groups_uploaded/')) { $tally = $tally+1; }
if (is_writable('../avatars/user_uploaded/')) { $tally = $tally+1; }
if (is_writable('../cache/')) { $tally = $tally+1; }
if (is_writable('../languages/')) { $tally = $tally+1; }
foreach (glob("../languages/*.conf") as $filename) { $required = $required+1; if (is_writable($filename)) {$tally = $tally+1;} }
if (is_writable('../libs/dbconnect.php')) { $tally = $tally+1; }
if (is_writable('../settings.php')) { $tally = $tally+1; }
$percent = percent($tally,$required);

if ($tally < $required ){
	echo '<div class="alert alert-warning">
		<p><strong>Warning:</strong> Your server has only met <strong>'.$tally.'</strong> of  the <strong>'.$required.'</strong> requirements to run Pligg CMS. While not all of the items on this page are required to run Pligg, we suggest that you try to comply with the suggestions made on this page. Please see the list below to discover what issues need to be addressed.</p><br />';
		
		echo '<div class="progress" style="margin-bottom: 9px;">
				<div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="'.$percent.'" aria-valuemin="0" aria-valuemax="100" style="width: '.$percent.'%;">
					<span class="sr-only">'.$percent.'% Complete</span>
				</div>
			</div>';
} else {
	echo '<div class="alert alert-success">
		<p>Your server met all of the requirements needed to run Pligg CMS. See the information below for a detailed report.</p><br />';
	
		echo '<div class="progress" style="margin-bottom: 9px;">
				<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="'.$percent.'" aria-valuemin="0" aria-valuemax="100" style="width: '.$percent.'%;">
					<span class="sr-only">'.$percent.'% Complete</span>
				</div>
			</div>';
}
?>
</div>
<?php
echo '<table class="table table-bordered table-striped">';
echo '<thead><tr><th colspan="2">Checking for files need to be renamed</th></tr></thead>';
echo '<tbody>';

// Start Language Check
$rename = " must be renamed to ";

$language_file_count = 0;
foreach (glob("../languages/*.conf") as $filename) { $language_file_count = $language_file_count+1;}
if (!glob("../languages/*.conf")) { 
	echo '<tr><td style="width:20px;" class="bad"><i class="fa fa-times"></i></td><td>No Language file has been detected! You will need to remove the .default extension from one of these language files:<ul style="margin:0px 0 5px 15px;padding:0;">';
	getfiles("../languages"); // List language files
	echo '</ul></td></tr>';
}else{
    echo "<tr><td style='width:20px;' class='good'><i class='fa fa-check'></i></td><td>You have renamed ";
	echo '<a id="langfiles" data-trigger="hover" data-html="true" data-content="<ul>';
	foreach (glob("../languages/*.conf") as $filename) {
		echo "<li>$filename</li>";
	}
	echo '</ul>" rel="popover" href="#" data-original-title="Renamed Language Files">'.$language_file_count.' language file(s)</a>, which are ready to be used</td></tr>'."\n";
}

$settings = '../settings.php';
$settingsdefault = '../settings.php.default';
if (file_exists($settings)) {
	echo '<tr><td ckass="good"><i class="fa fa-check" ></i></td><td>'.$settings.'</td></tr>';
} else {
	if (file_exists($settingsdefault)) {
		echo '<tr><td class="bad"><i class="fa fa-times"></i></td><td>'.$settingsdefault.$rename.$settings.'.</td></tr>';
	}
}
$dbconnect = '../libs/dbconnect.php';
$dbconnectdefault = '../libs/dbconnect.php.default';
if (file_exists($dbconnect)) {
	echo '<tr><td><i class="fa fa-check"></i></td><td>'.$dbconnect.'</td></tr>';
} else {
	if (file_exists($dbconnectdefault)) {
		echo '<tr><td><i class="fa fa-times"></i></td><td>'.$dbconnectdefault.$rename.$dbconnect.'.</td></tr>';
	}
}
$bannedips = '../logs/bannedips.log';
$bannedipsdefault = '../logs.default/bannedips.log';
if (file_exists($bannedips)) {
	echo '<tr><td><i class="fa fa-check"></i></td><td>'.$bannedips.'</td></tr>';
} else {
	if (file_exists($bannedipsdefault)) {
		echo '<tr><td><i class="fa fa-times"></i></td><td>'.$bannedipsdefault.$rename.$bannedips.'.</td></tr>';
	}
}
$localantispam = '../logs/domain-blacklist.log';
$localantispamdefault = '../logs.default/domain-blacklist.log';
if (file_exists($localantispam)) {
	echo '<tr><td><i class="fa fa-check"></i></td><td>'.$localantispam.'</td></tr>';
} else {
	if (file_exists($localantispamdefault)) {
		echo '<tr><td><i class="fa fa-times"></i></td><td>'.$localantispamdefault.$rename.$localantispam.'.</td></tr>';
	}
}
$localwhitelist = '../logs/domain-whitelist.log';
$localwhitelistdefault = '../logs.default/domain-whitelist.log';
if (file_exists($localwhitelist)) {
	echo '<tr><td><i class="fa fa-check"></i></td><td>'.$localwhitelist.'</td></tr>';
} else {
	if (file_exists($localwhitelistdefault)) {
		echo '<tr><td><i class="fa fa-times"></i></td><td>'.$localwhitelistdefault.$rename.$localwhitelist.'.</td></tr>';
	}
}
echo '</tbody></table>';

/* This causes a conflict if there is no lang_english.conf language file. */
/*
include_once('../config.php');
if ($URLMethod == 2 && !file_exists('../.htaccess')) { echo '<tr><td><i class="fa fa-times"></i></td><td>URL Method 2 is enabled in your Admin Panel, but the file .htaccess does not exist! Please rename the file "htaccess.default" to ".htaccess"</td></tr>'; }
if ((!$my_base_url) || ($my_base_url == '')) { echo '<tr><td><i class="fa fa-times"></i></td><td>Your Base URL is not set - Visit <a href = "../admin/admin_config.php?page=Location%20Installed">Admin > Config > Location Installed</a> to change your settings. You can also temporarily change the value from ../settings.php if you aren\'t able to access the Admin Panel.</td></tr>'; }
*/

echo '<table class="table table-bordered table-striped">';
echo '<thead><tr><th colspan="2">Checking <a id="chmod" data-trigger="hover" data-html="true" data-content="<span style=\'font-weight:normal;\'>CHMOD represents the read, write, and execute permissions given to files and directories. Pligg CMS requires that certain files and directories are given a CHMOD status of 0777, allowing Pligg to have access to make changes to files. Any lines that return as an error represent files that need to be updated to CHMOD 0777.<span>" rel="popover" href="http://en.wikipedia.org/wiki/Chmod" data-original-title="CHMOD">CHMOD Settings</a></th></tr></thead>';
echo '<tbody>';

$file='../admin/backup/';
if (!is_writable($file)) { echo '<tr><td style="width:20px;"><i class="fa fa-times"></i></td><td>'.$file.' is not writable! Please chmod this directory to 777.</span></td></tr>'; }
if (is_writable($file)) { echo '<tr><td style="width:20px;"><i class="fa fa-check"></i></td><td>'.$file.'</span></td></tr>'; }

$file='../avatars/groups_uploaded/';
if (!is_writable($file)) { echo '<tr><td><i class="fa fa-times"></i></td><td>'.$file.' is not writable! Please chmod this directory to 777.</span></td></tr>'; }
if (is_writable($file)) { echo '<tr><td><i class="fa fa-check"></i></td><td>'.$file.'</span></td></tr>'; }

$file='../avatars/user_uploaded/';
if (!is_writable($file)) { echo '<tr><td><i class="fa fa-times"></i></td><td>'.$file.' is not writable! Please chmod this directory to 777.</span></td></tr>'; }
if (is_writable($file)) { echo '<tr><td><i class="fa fa-check"></i></td><td>'.$file.'</span></td></tr>'; }

$file='../cache/';
if (!is_writable($file)) { echo '<tr><td><i class="fa fa-times"></i></td><td>'.$file.' is not writable! Please chmod this directory to 777.</span></td></tr>'; }
if (is_writable($file)) { echo '<tr><td><i class="fa fa-check"></i></td><td>'.$file.'</span></td></tr>'; }

$file='../languages/';
if (!is_writable($file)) { echo '<tr><td><i class="fa fa-times"></i></td><td>'.$file.' is not writable! Please chmod this directory and all contained files to 777.</span></td></tr>'; }
if (is_writable($file)) { echo '<tr><td><i class="fa fa-check"></i></td><td>'.$file.'</span></td></tr>'; }

foreach (glob("../languages/*.conf") as $filename) {
	if (!is_writable($file)) { echo '<tr><td><i class="fa fa-times"></i></td><td>'.$filename.' is not writable! Please chmod this file to 777.</span></td></tr>'; }
	if (is_writable($file)) { echo '<tr><td><i class="fa fa-check"></i></td><td>'.$filename.'</span></td></tr>'; }
}

$file='../logs/bannedips.log';
if (file_exists($file)) {
	if (!is_writable($file)) { echo '<tr><td><i class="fa fa-times"></i></td><td>'.$file.' is not writable! Please chmod this file to 666.</span></td></tr>'; }
	if (is_writable($file)) { echo '<tr><td><i class="fa fa-check"></i></td><td>'.$file.'</span></td></tr>'; }
}

$file='../logs/domain-blacklist.log';
if (file_exists($file)) {
	if (!is_writable($file)) { echo '<tr><td><i class="fa fa-times"></i></td><td>'.$file.' is not writable! Please chmod this file to 666.</span></td></tr>'; }
	if (is_writable($file)) { echo '<tr><td><i class="fa fa-check"></i></td><td>'.$file.'</span></td></tr>'; }
}

$file='../logs/domain-whitelist.log';
if (file_exists($file)) {
	if (!is_writable($file)) { echo '<tr><td><i class="fa fa-times"></i></td><td>'.$file.' is not writable! Please chmod this file to 666.</span></td></tr>'; }
	if (is_writable($file)) { echo '<tr><td><i class="fa fa-check"></i></td><td>'.$file.'</span></td></tr>'; }
}

$file='../libs/dbconnect.php';
if (file_exists($file)) {
	if (!is_writable($file)) { echo '<tr><td><i class="fa fa-times"></i></td><td>'.$file.' is not writable! Please chmod this file to 666.</span></td></tr>'; }
	if (is_writable($file)) { echo '<tr><td><i class="fa fa-check"></i></td><td>'.$file.'</span></td></tr>'; }
}

$file='../settings.php';
if (file_exists($file)) {
	if (!is_writable($file)) { echo '<tr><td><i class="fa fa-times"></i></td><td>'.$file.' is not writable! Please chmod this file to 666.</span></td></tr>'; }
	if (is_writable($file)) { echo '<tr><td><i class="fa fa-check"></i></td><td>'.$file.'</span></td></tr>'; }
}

echo '<table class="table table-bordered table-striped">';
echo '<thead><tr><th colspan="2">Checking Server Settings</th></tr></thead>';
echo '<tbody>';

// PHP
$phpversion = phpversion();
echo '<tr><td>';
if ($phpversion < 5) {
	echo '<i class="fa fa-times"></i>';
} else if ($phpversion > 4) {
	echo '<i class="fa fa-check"></i>';

}
echo '</td><td><a id="phpversion" data-trigger="hover" data-content="Pligg has been tested on both PHP versions 4 and 5. We have designed the content management system based on PHP 5 technologies, so certain problems may occur when using older versions of PHP. We suggest that your server runs a mininum of PHP 5." rel="popover" href="http://us3.php.net/tut.php" data-original-title="PHP Version">PHP Version ('.$phpversion.')</a></td>';
echo '</tr>';

echo '<tr><td>';
if ($mysqlversion < 5) {
	echo '<i class="fa fa-times"></i>';
} else if ($mysqlversion > 4) {
	echo '<i class="fa fa-check"></i>';
}
echo '</td><td><a id="mysqlversion" data-trigger="hover" data-content="Pligg has been tested on both MySQL versions 4 and 5, during that process we have discovered that bugs will occassionally pop up is you are running MySQL 4. For this reason we suggest that you use a server with MySQL 5 or later to run a Pligg CMS website. MySQL 5 has been available for some time now and we hope that most major web hosts now support it. It offers features that are not built into MySQL 4, which we may have used when writing code for Pligg CMS." rel="popover" href="http://dev.mysql.com/doc/" data-original-title="MySQL Version">MySQL Version ('.$mysqlversion.')</a></td>';
echo '</tr>';

echo '<tr><td style="width:20px;">', function_exists('curl_version') ? '<i class="fa fa-check"></i></td>' : '<i class="fa fa-times"></i></td>';
	echo '<td><a id="curlwarning" data-trigger="hover" data-content="cURL is a PHP library that allows Pligg to connect to external websites." rel="popover" href="http://php.net/manual/en/book.curl.php" data-original-title="cURL PHP Extension">cURL</a></td></tr>';

echo '<tr><td>', function_exists('fopen') ? '<i class="fa fa-check"></i></td>' : '<i class="fa fa-times"></i></td>';
	echo '<td><a id="fopenwarning" data-trigger="hover" data-content="The fopen function for PHP allows us to create, read, and manipulate local files." rel="popover" href="http://www.w3schools.com/php/func_filesystem_fopen.asp" data-original-title="fopen PHP Function">fopen</a></td></tr>';

echo '<tr><td>', function_exists('fwrite') ? '<i class="fa fa-check"></i></td>' : '<i class="fa fa-times"></i></td>';
	echo '<td><a id="fwritewarning" data-trigger="hover" data-content="The fwrite function is used in conjunction with the fopen function. It allows PHP to write to an opened file." rel="popover" href="http://www.w3schools.com/php/func_filesystem_fwrite.asp" data-original-title="fwrite PHP Function">fwrite</td></tr>';
	
echo '<tr><td>', file_get_contents(__FILE__) ? '<i class="fa fa-check"></i></td>' : '<i class="fa fa-times"></i></td>';
	echo '<td><a id="fgetwarning" data-trigger="hover" data-content="The file_get_contents() function for PHP reads a file into a string." rel="popover" href="http://www.w3schools.com/php/func_filesystem_file_get_contents.asp" data-original-title="fgetwarning PHP Function">file_get_contents</a></td></tr>';
	
echo '<tr><td>', function_exists('gd_info') ? '<i class="fa fa-check"></i></td>' : '<i class="fa fa-times"></i></td>';
	echo '<td><a id="gdwarning" data-trigger="hover" data-content="The GD Graphics Library is a graphics software library for dynamically manipulating images. Any images handled by Pligg, like user avatar or group images, use GD to manipulate the file." rel="popover" href="http://php.net/manual/en/book.image.php" data-original-title="GD Graphics Library">GD Graphics Library</a></td></tr>';
	
echo '</tbody></table>';

echo '<div class="jumbotron" style="padding:25px 10px;"><p style="text-align:center">Please continue to the <a href="./install.php">Installation Page</a>, the <a href="./upgrade.php">Upgrade Page</a>, or the <a href="../readme.html">Pligg Readme</a>.</p></div>';

?>

<?php $include='footer.php'; if (file_exists($include)) { include_once($include); } ?>

<script>  
$(function ()  
{ 
	$("#langfiles").popover();
	$("#chmod").popover();
	$("#phpversion").popover();
	$("#mysqlversion").popover();
	$("#curlwarning").popover();
	$("#fopenwarning").popover();
	$("#fwritewarning").popover();
	$("#fgetwarning").popover();
	$("#gdwarning").popover();
});
</script> 