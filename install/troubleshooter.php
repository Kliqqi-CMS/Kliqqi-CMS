<?php
error_reporting(E_ALL^E_NOTICE);
$page = 'troubleshooter';
$include='header.php'; if (file_exists($include)) { include_once($include); }
$include='functions.php'; if (file_exists($include)) { require_once($include); }
?>
	
<script type='text/javascript' src='../templates/admin/js/zebrastripe.js'></script>

<style type="text/css">
.intro h3 {font-size:18px;border-bottom:1px solid #619ACB;}
.intro ul {margin:10px 0 28px 0;}
.intro li {margin:3px 20px;}
.intro p {padding:5px 6px 5px 6px;}
.intro table {border-collapse:collapse;width:100%;background:#fff;font-size:14px;margin:15px 0;border:1px solid #000;}
.intro table td {padding:6px;}
.intro table tr {border-top:1px solid #000;}
.intro table tr a {background:none;}
.intro table td, .intro table th {border: 1px solid #000000; }
.tableleft {width:650px;}
.good {color:#066035;}
.bad {color:#C50202;}
blockquote {border:1px solid #D5D5AA;padding:4px;background:#F6F6CB;}
.helpimage {position:relative;float:right;width:16px;height:16px}
.helpbox {width:740px;background:#FFFFD4;border:1px solid #bbb;margin:8px 0px 8px 0px;padding:10px;}
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
echo '<div class="intro"><h3>Checking Files That May Need To Be Renamed</h3><ul>';

// Start Language Check
$rename = " must be renamed to ";
function getfiles($dirname=".") {
	$pattern="\.default$";
	$files = array();
	if($handle = opendir($dirname)) {
	   while(false !== ($file = readdir($handle))){
			if(preg_match('/'.$pattern.'/i', $file)){
				echo "<li>$file</li>";
			}
	   }
		closedir($handle);
	}
	return($files);
}

if (file_exists('../languages/lang_english.conf')) {
    echo '<li class="good">File ../languages/lang_english.conf exists</li>';
}elseif (file_exists('../languages/lang_arabic.conf')) {
	echo '<li class="good">File ../languages/lang_arabic.conf exists</li>';
}elseif (file_exists('../languages/lang_chinese_simplified.conf')) {
	echo '<li class="good">File ../languages/lang_chinese_simplified.conf exists</li>';
}elseif (file_exists('../languages/lang_german.conf')) {
	echo '<li class="good">File ../languages/lang_german.conf exists</li>';
}elseif (file_exists('../languages/lang_italian.conf')) {
	echo '<li class="good">File ../languages/lang_italian.conf exists</li>';
}elseif (file_exists('../languages/lang_russian.conf')) {
	echo '<li class="good">File ../languages/lang_russian.conf exists</li>';
}elseif (file_exists('../languages/lang_thai.conf')) {
	echo '<li class="good">File ../languages/lang_thai.conf exists</li>';
}elseif (file_exists('../languages/lang_turkmen.conf')) {
	echo '<li class="good">File ../languages/lang_turkmen.conf exists</li>';
} else {
	echo '<li class="bad">No Language file has been detected! You will need to remove the .default extension from one of these language files:<ul style="margin:0px 0 5px 15px;padding:0;">';
	getfiles("../languages"); // List language files
	echo '</ul></li>';
}
// End Language Check

$settings = '../settings.php';
$settingsdefault = '../settings.php.default';
if (file_exists($settings)) {
	echo '<li class="good">File '.$settings.' exists</li>';
} else {
	if (file_exists($settingsdefault)) {
		echo '<li class="bad">'.$settingsdefault.$rename.$settings.'.</li>';
	}
}
$dbconnect = '../libs/dbconnect.php';
$dbconnectdefault = '../libs/dbconnect.php.default';
if (file_exists($dbconnect)) {
	echo '<li class="good">File '.$dbconnect.' exists</li>';
} else {
	if (file_exists($dbconnectdefault)) {
		echo '<li class="bad">'.$dbconnectdefault.$rename.$dbconnect.'.</li>';
	}
}
$bannedips = '../bannedips.txt';
$bannedipsdefault = '../bannedips.txt.default';
if (file_exists($bannedips)) {
	echo '<li class="good">File '.$bannedips.' exists</li>';
} else {
	if (file_exists($bannedipsdefault)) {
		echo '<li class="bad">'.$bannedipsdefault.$rename.$bannedips.'.</li>';
	}
}
$localantispam = '../local-antispam.txt';
$localantispamdefault = '../local-antispam.txt.default';
if (file_exists($localantispam)) {
	echo '<li class="good">File '.$localantispam.' exists</li>';
} else {
	if (file_exists($localantispamdefault)) {
		echo '<li class="bad">'.$localantispamdefault.$rename.$localantispam.'.</li>';
	}
}

include_once('../config.php');
if ($URLMethod == 2 && !file_exists('../.htaccess')) { echo '<li class="bad">URL Method 2 is enabled in your Admin Panel, but the file .htaccess does not exist! Please rename the file "htaccess.default" to ".htaccess"</li>'; }
if ((!$my_base_url) || ($my_base_url == '')) { echo '<li class="bad">Your Base URL is not set - Visit <a href = "../admin/admin_config.php?page=Location%20Installed">Admin > Config > Location Installed</a> to change your settings. You can also temporarily change the value from ../settings.php if you aren\'t able to access the Admin Panel.</li>'; }
	
echo '</ul><h3>Checking CHMOD Settings</h3><ul>';

$file='../admin/backup/';
if (!is_writable($file)) { echo '<li class="bad">'.$file.' is not writable! Please chmod this directory to 777.</span></li>'; }
if (is_writable($file)) { echo '<li class="good">'.$file.' is writable.</span></li>'; }

$file='../avatars/groups_uploaded/';
if (!is_writable($file)) { echo '<li class="bad">'.$file.' is not writable! Please chmod this directory to 777.</span></li>'; }
if (is_writable($file)) { echo '<li class="good">'.$file.' is writable.</span></li>'; }

$file='../avatars/user_uploaded/';
if (!is_writable($file)) { echo '<li class="bad">'.$file.' is not writable! Please chmod this directory to 777.</span></li>'; }
if (is_writable($file)) { echo '<li class="good">'.$file.' is writable.</span></li>'; }

$file='../cache/';
if (!is_writable($file)) { echo '<li class="bad">'.$file.' is not writable! Please chmod this directory to 777.</span></li>'; }
if (is_writable($file)) { echo '<li class="good">'.$file.' is writable.</span></li>'; }

$file='../cache/admin_c/';
if (!is_writable($file)) { echo '<li class="bad">'.$file.' is not writable! Please chmod this directory to 777.</span></li>'; }
if (is_writable($file)) { echo '<li class="good">'.$file.' is writable.</span></li>'; }

$file='../cache/templates_c/';
if (!is_writable($file)) { echo '<li class="bad">'.$file.' is not writable! Please chmod this directory to 777.</span></li>'; }
if (is_writable($file)) { echo '<li class="good">'.$file.' is writable.</span></li>'; }

$file='../languages/';
if (!is_writable($file)) { echo '<li class="bad">'.$file.' is not writable! Please chmod this directory and all contained files to 777.</span></li>'; }
if (is_writable($file)) { echo '<li class="good">'.$file.' is writable.</span></li>'; }

$file='../languages/lang_english.conf';
if (file_exists($file)) {
	if (!is_writable($file)) { echo '<li class="bad">'.$file.' is not writable! Please chmod this file to 777.</span></li>'; }
	if (is_writable($file)) { echo '<li class="good">'.$file.' is writable.</span></li>'; }
}

$file='../languages/installer_lang.php';
if (!is_writable($file)) { echo '<li class="bad">'.$file.' is not writable! Please chmod this file to 777.</span></li>'; }
if (is_writable($file)) { echo '<li class="good">'.$file.' is writable.</span></li>'; }

$file='../languages/installer_lang_default.php';
if (!is_writable($file)) { echo '<li class="bad">'.$file.' is not writable! Please chmod this file to 777.</span></li>'; }
if (is_writable($file)) { echo '<li class="good">'.$file.' is writable.</span></li>'; }

$file='../bannedips.txt';
if (file_exists($file)) {
	if (!is_writable($file)) { echo '<li class="bad">'.$file.' is not writable! Please chmod this file to 666.</span></li>'; }
	if (is_writable($file)) { echo '<li class="good">'.$file.' is writable.</span></li>'; }
}

$file='../local-antispam.txt';
if (file_exists($file)) {
	if (!is_writable($file)) { echo '<li class="bad">'.$file.' is not writable! Please chmod this file to 666.</span></li>'; }
	if (is_writable($file)) { echo '<li class="good">'.$file.' is writable.</span></li>'; }
}

$file='../libs/dbconnect.php';
if (file_exists($file)) {
	if (!is_writable($file)) { echo '<li class="bad">'.$file.' is not writable! Please chmod this file to 666.</span></li>'; }
	if (is_writable($file)) { echo '<li class="good">'.$file.' is writable.</span></li>'; }
}

$file='../settings.php';
if (file_exists($file)) {
	if (!is_writable($file)) { echo '<li class="bad">'.$file.' is not writable! Please chmod this file to 666.</span></li>'; }
	if (is_writable($file)) { echo '<li class="good">'.$file.' is writable.</span></li>'; }
}

echo '</ul><h3>Checking PHP and MySQL Features</h3>';

echo '<table cellspacing="0" border="0" class="stripes">';
echo '<tr><td>PHP Version</td><td>';

$phpversion = phpversion();
if ($phpversion < 5) {
	echo '<a href="javascript:InsertContent(\'phpversion\');"><img class="helpimage" src="../templates/admin/images/help.gif" alt="Help?" /></a><span class="bad">'.$phpversion.'</span></td></tr>';
} else if ($phpversion > 4) {
	echo '<span class="good">'.$phpversion.'</span></td></tr>';
}

ob_start();
phpinfo();
$info = ob_get_contents();
ob_end_clean();

$mysqlinfo = stristr($info, 'Client API version');
preg_match('/[1-9].[0-9].[1-9][0-9]/', $mysqlinfo, $mysqlmatch);
$mysqlversion = $mysqlmatch[0];

echo '<tr><td>MySQL Version</td><td>';
if ($mysqlversion < 5) {
	echo '<a href="javascript:InsertContent(\'mysqlversion\');"><img class="helpimage" src="../templates/admin/images/help.gif" alt="Help?" /></a><span class="bad">'.$mysqlversion.'</span></td></tr>';
} else if ($mysqlversion > 4) {
	echo '<span class="good">'.$mysqlversion.'</span></td></tr>';
}

echo '<tr><td class="tableleft">cURL</td><td> ', function_exists('curl_version') ? '<span class="good">Enabled</span>' : '<a href="javascript:InsertContent(\'curlwarning\');"><img class="helpimage" src="../templates/admin/images/help.gif" alt="Help?" /></a><span class="bad">Disabled</span>' . '</td></tr>';
echo '<tr><td>fopen</td><td> ', function_exists('fopen') ? '<span class="good">Enabled</span>' : '<a href="javascript:InsertContent(\'fopenwarning\');"><img class="helpimage" src="../templates/admin/images/help.gif" alt="Help?" /></a><span class="bad">Disabled</span>' . '</td></tr>';
echo '<tr><td>fwrite</td><td> ', function_exists('fwrite') ? '<span class="good">Enabled</span>' : '<a href="javascript:InsertContent(\'fwritewarning\');"><img class="helpimage" src="../templates/admin/images/help.gif" alt="Help?" /></a><span class="bad">Disabled</span>' . '</td></tr>';
echo '<tr><td>file_get_contents</td><td> ', file_get_contents(__FILE__) ? '<span class="good">Enabled</span>' : '<a href="javascript:InsertContent(\'fgetwarning\');"><img class="helpimage" src="../templates/admin/images/help.gif" alt="Help?" /></a><span class="bad">Disabled</span>' . '</td></tr>';
echo '<tr><td>GD Graphics Library</td><td> ', function_exists('gd_info') ? '<span class="good">Enabled</span>' : '<a href="javascript:InsertContent(\'gdwarning\');"><img class="helpimage" src="../templates/admin/images/help.gif" alt="Help?" /></a><span class="bad">Disabled</span>' . '</td></tr>';
echo '</table>';

echo '<hr /><p style="text-align:center">Please continue to the <a href="./install.php">Installation Page</a>, the <a href="./upgrade.php">Upgrade Page</a>, or the <a href="../readme.html">Pligg Readme</a>.</p></div>';

?>
	
<div id="phpversion" class="helpbox" style="display:none;">
<h3>PHP Version Warning</h3>
<p>Pligg has been tested on both PHP versions 4 and 5. We have designed the content management system based on PHP 5 technologies, so certain problems may occur when using older versions of PHP. We suggest that your server runs a mininum of PHP 5.</p>
</div>

<div id="mysqlversion" class="helpbox" style="display:none;">
<h3>MySQL Version Warning</h3>
<p>Pligg has been tested on both MySQL versions 4 and 5, during that process we have discovered that bugs will occassionally pop up is you are running MySQL 4. For this reason we suggest that you use a server with MySQL 5 or better to run a Pligg CMS website. MySQL 5 has been available for some time now and we hope that most major web hosts now support it. It offers features that are not built into MySQL 4, which we may have used when writing code for Pligg CMS.</p>
</div>

<div id="curlwarning" class="helpbox" style="display:none;">
<h3>cURL Warning</h3>
<p>Pligg and some Pligg modules may depend on cURL in order to operate. We suggest that you enable cURL on your web server to achieve the full functionality of Pligg and to avoid any errors. If the server has simply turned off cURL from you php.ini file it may be an easy fix. Open your server's php.ini file and find the line below, then remove the semicolon from the start of that line and restart Apache.</p>
<blockquote>;extension=php_curl.dll</blockquote>
<p>You may continue to install Pligg without enabling cURL, but it may result in errors when using some more advanced modules.</p>
</div>

<div id="fopenwarning" class="helpbox" style="display:none;">
<h3>fopen Warning</h3>
<p>he fopen() function opens a file or URL. Pligg requires fopen to grab external files from Pligg.com that are used for installing and upgrading Pligg CMS. It is also used for monitoring modules for updates.</p>
</div>

<div id="fwritewarning" class="helpbox" style="display:none;">
<h3>fwrite Warning</h3>
<p>fwrite() writes to an open file. The function will stop at the end of the file or when it reaches the specified length, whichever comes first. Pligg requires fwrite to grab external files from Pligg.com and save them to the local web server for installing and upgrading Pligg.</p>
</div>

<div id="fgetwarning" class="helpbox" style="display:none;">
<h3>file_get_contents Warning</h3>
<p>file_get_contents() is the preferred way to read the contents of a file into a string. Pligg requires the function file_get_contents to download the contents of external files from Pligg.com and save them to the local web server for installing and upgrading Pligg. </p>
</div>

<div id="gdwarning" class="helpbox" style="display:none;">
<h3>GD Graphics Library Warning</h3>
<p>In order to resize and save uploaded images Pligg requires that you have installed the GD library. GD is needed if you want to allow users to upload avatars or group thumbnails. It is also used for locally rendered CAPTCHAs and other various modules and features.</p>
</div>

<?php $include='footer.php'; if (file_exists($include)) { include_once($include); } ?>