<?php
error_reporting(E_ALL^E_NOTICE);
$page = 'troubleshooter';
$include='header.php'; if (file_exists($include)) { include_once($include); }
$include='functions.php'; if (file_exists($include)) { require_once($include); }
?>

<style type="text/css">
.good {color:#066035;}
.bad {color:#C50202;}
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
echo '<table class="table table-bordered table-striped">';
echo '<thead><tr><th colspan="2">Checking Files That May Need To Be Renamed</th></tr></thead>';
echo '<tbody>';

// Start Language Check
$rename = " must be renamed to ";
function getfiles($dirname=".") {
	$pattern="\.default$";
	$files = array();
	if($handle = opendir($dirname)) {
	   while(false !== ($file = readdir($handle))){
			if(preg_match('/'.$pattern.'/i', $file)){
				echo "<td>$file</td></tr>";
			}
	   }
		closedir($handle);
	}
	return($files);
}

if (file_exists('../languages/lang_english.conf')) {
    echo '<tr><td style="width:20px;"><i class="icon icon-ok"></i></td><td>../languages/lang_english.conf</td></tr>';
}elseif (file_exists('../languages/lang_arabic.conf')) {
	echo '<tr><td style="width:20px;"><i class="icon icon-ok"></i></td><td>../languages/lang_arabic.conf</td></tr>';
}elseif (file_exists('../languages/lang_chinese_simplified.conf')) {
	echo '<tr><td style="width:20px;"><i class="icon icon-ok"></i></td><td>../languages/lang_chinese_simplified.conf</td></tr>';
}elseif (file_exists('../languages/lang_german.conf')) {
	echo '<tr><td style="width:20px;"><i class="icon icon-ok"></i></td><td>../languages/lang_german.conf</td></tr>';
}elseif (file_exists('../languages/lang_italian.conf')) {
	echo '<tr><td style="width:20px;"><i class="icon icon-ok"></i></td><td>../languages/lang_italian.conf</td></tr>';
}elseif (file_exists('../languages/lang_russian.conf')) {
	echo '<tr><td style="width:20px;"><i class="icon icon-ok"></i></td><td>../languages/lang_russian.conf</td></tr>';
}elseif (file_exists('../languages/lang_thai.conf')) {
	echo '<tr><td style="width:20px;"><i class="icon icon-ok"></i></td><td>../languages/lang_thai.conf</td></tr>';
}elseif (file_exists('../languages/lang_turkmen.conf')) {
	echo '<tr><td style="width:20px;"><i class="icon icon-ok"></i></td><td>../languages/lang_turkmen.conf</td></tr>';
} else {
	echo '<tr><td style="width:20px;"><i class="icon icon-remove"></i></td><td>No Language file has been detected! You will need to remove the .default extension from one of these language files:<ul style="margin:0px 0 5px 15px;padding:0;">';
	getfiles("../languages"); // List language files
	echo '</ul></td></tr>';
}
// End Language Check

$settings = '../settings.php';
$settingsdefault = '../settings.php.default';
if (file_exists($settings)) {
	echo '<tr><td><i class="icon icon-ok"></i></td><td>'.$settings.'</td></tr>';
} else {
	if (file_exists($settingsdefault)) {
		echo '<tr><td><i class="icon icon-remove"></i></td><td>'.$settingsdefault.$rename.$settings.'.</td></tr>';
	}
}
$dbconnect = '../libs/dbconnect.php';
$dbconnectdefault = '../libs/dbconnect.php.default';
if (file_exists($dbconnect)) {
	echo '<tr><td><i class="icon icon-ok"></i></td><td>'.$dbconnect.'</td></tr>';
} else {
	if (file_exists($dbconnectdefault)) {
		echo '<tr><td><i class="icon icon-remove"></i></td><td>'.$dbconnectdefault.$rename.$dbconnect.'.</td></tr>';
	}
}
$bannedips = '../bannedips.txt';
$bannedipsdefault = '../bannedips.txt.default';
if (file_exists($bannedips)) {
	echo '<tr><td><i class="icon icon-ok"></i></td><td>'.$bannedips.'</td></tr>';
} else {
	if (file_exists($bannedipsdefault)) {
		echo '<tr><td><i class="icon icon-remove"></i></td><td>'.$bannedipsdefault.$rename.$bannedips.'.</td></tr>';
	}
}
$localantispam = '../local-antispam.txt';
$localantispamdefault = '../local-antispam.txt.default';
if (file_exists($localantispam)) {
	echo '<tr><td><i class="icon icon-ok"></i></td><td>'.$localantispam.'</td></tr>';
} else {
	if (file_exists($localantispamdefault)) {
		echo '<tr><td><i class="icon icon-remove"></i></td><td>'.$localantispamdefault.$rename.$localantispam.'.</td></tr>';
	}
}

echo '</tbody></table>';

include_once('../config.php');
if ($URLMethod == 2 && !file_exists('../.htaccess')) { echo '<tr><td><i class="icon icon-remove"></i></td><td>URL Method 2 is enabled in your Admin Panel, but the file .htaccess does not exist! Please rename the file "htaccess.default" to ".htaccess"</td></tr>'; }
if ((!$my_base_url) || ($my_base_url == '')) { echo '<tr><td><i class="icon icon-remove"></i></td><td>Your Base URL is not set - Visit <a href = "../admin/admin_config.php?page=Location%20Installed">Admin > Config > Location Installed</a> to change your settings. You can also temporarily change the value from ../settings.php if you aren\'t able to access the Admin Panel.</td></tr>'; }

echo '<table class="table table-bordered table-striped">';
echo '<thead><tr><th colspan="2">Checking CHMOD Settings</th></tr></thead>';
echo '<tbody>';

$file='../admin/backup/';
if (!is_writable($file)) { echo '<tr><td style="width:20px;"><i class="icon icon-remove"></i></td><td>'.$file.' is not writable! Please chmod this directory to 777.</span></td></tr>'; }
if (is_writable($file)) { echo '<tr><td style="width:20px;"><i class="icon icon-ok"></i></td><td>'.$file.'</span></td></tr>'; }

$file='../avatars/groups_uploaded/';
if (!is_writable($file)) { echo '<tr><td><i class="icon icon-remove"></i></td><td>'.$file.' is not writable! Please chmod this directory to 777.</span></td></tr>'; }
if (is_writable($file)) { echo '<tr><td><i class="icon icon-ok"></i></td><td>'.$file.'</span></td></tr>'; }

$file='../avatars/user_uploaded/';
if (!is_writable($file)) { echo '<tr><td><i class="icon icon-remove"></i></td><td>'.$file.' is not writable! Please chmod this directory to 777.</span></td></tr>'; }
if (is_writable($file)) { echo '<tr><td><i class="icon icon-ok"></i></td><td>'.$file.'</span></td></tr>'; }

$file='../cache/';
if (!is_writable($file)) { echo '<tr><td><i class="icon icon-remove"></i></td><td>'.$file.' is not writable! Please chmod this directory to 777.</span></td></tr>'; }
if (is_writable($file)) { echo '<tr><td><i class="icon icon-ok"></i></td><td>'.$file.'</span></td></tr>'; }

$file='../cache/admin_c/';
if (!is_writable($file)) { echo '<tr><td><i class="icon icon-remove"></i></td><td>'.$file.' is not writable! Please chmod this directory to 777.</span></td></tr>'; }
if (is_writable($file)) { echo '<tr><td><i class="icon icon-ok"></i></td><td>'.$file.'</span></td></tr>'; }

$file='../cache/templates_c/';
if (!is_writable($file)) { echo '<tr><td><i class="icon icon-remove"></i></td><td>'.$file.' is not writable! Please chmod this directory to 777.</span></td></tr>'; }
if (is_writable($file)) { echo '<tr><td><i class="icon icon-ok"></i></td><td>'.$file.'</span></td></tr>'; }

$file='../languages/';
if (!is_writable($file)) { echo '<tr><td><i class="icon icon-remove"></i></td><td>'.$file.' is not writable! Please chmod this directory and all contained files to 777.</span></td></tr>'; }
if (is_writable($file)) { echo '<tr><td><i class="icon icon-ok"></i></td><td>'.$file.'</span></td></tr>'; }

$file='../languages/lang_english.conf';
if (file_exists($file)) {
	if (!is_writable($file)) { echo '<tr><td><i class="icon icon-remove"></i></td><td>'.$file.' is not writable! Please chmod this file to 777.</span></td></tr>'; }
	if (is_writable($file)) { echo '<tr><td><i class="icon icon-ok"></i></td><td>'.$file.'</span></td></tr>'; }
}

$file='../languages/installer_lang.php';
if (!is_writable($file)) { echo '<tr><td><i class="icon icon-remove"></i></td><td>'.$file.' is not writable! Please chmod this file to 777.</span></td></tr>'; }
if (is_writable($file)) { echo '<tr><td><i class="icon icon-ok"></i></td><td>'.$file.'</span></td></tr>'; }

$file='../languages/installer_lang_default.php';
if (!is_writable($file)) { echo '<tr><td><i class="icon icon-remove"></i></td><td>'.$file.' is not writable! Please chmod this file to 777.</span></td></tr>'; }
if (is_writable($file)) { echo '<tr><td><i class="icon icon-ok"></i></td><td>'.$file.'</span></td></tr>'; }

$file='../bannedips.txt';
if (file_exists($file)) {
	if (!is_writable($file)) { echo '<tr><td><i class="icon icon-remove"></i></td><td>'.$file.' is not writable! Please chmod this file to 666.</span></td></tr>'; }
	if (is_writable($file)) { echo '<tr><td><i class="icon icon-ok"></i></td><td>'.$file.'</span></td></tr>'; }
}

$file='../local-antispam.txt';
if (file_exists($file)) {
	if (!is_writable($file)) { echo '<tr><td><i class="icon icon-remove"></i></td><td>'.$file.' is not writable! Please chmod this file to 666.</span></td></tr>'; }
	if (is_writable($file)) { echo '<tr><td><i class="icon icon-ok"></i></td><td>'.$file.'</span></td></tr>'; }
}

$file='../libs/dbconnect.php';
if (file_exists($file)) {
	if (!is_writable($file)) { echo '<tr><td><i class="icon icon-remove"></i></td><td>'.$file.' is not writable! Please chmod this file to 666.</span></td></tr>'; }
	if (is_writable($file)) { echo '<tr><td><i class="icon icon-ok"></i></td><td>'.$file.'</span></td></tr>'; }
}

$file='../settings.php';
if (file_exists($file)) {
	if (!is_writable($file)) { echo '<tr><td><i class="icon icon-remove"></i></td><td>'.$file.' is not writable! Please chmod this file to 666.</span></td></tr>'; }
	if (is_writable($file)) { echo '<tr><td><i class="icon icon-ok"></i></td><td>'.$file.'</span></td></tr>'; }
}

echo '<table class="table table-bordered table-striped">';
echo '<thead><tr><th colspan="2">Checking Server Settings</th></tr></thead>';
echo '<tbody>';

$phpversion = phpversion();
if ($phpversion < 5) {
	echo '<tr><td><i class="icon icon-remove"></i></td>';
	echo '<td><a href="javascript:InsertContent(\'phpversion\');">PHP Version ('.$phpversion.')</a></td>';
	echo '</tr>';
} else if ($phpversion > 4) {
	echo '<tr><td><i class="icon icon-ok"></i></td>';
	echo '<td><a href="javascript:InsertContent(\'phpversion\');">PHP Version ('.$phpversion.')</a></td>';
	echo '</tr>';
}

ob_start();
phpinfo();
$info = ob_get_contents();
ob_end_clean();

$mysqlinfo = stristr($info, 'Client API version');
preg_match('/[1-9].[0-9].[1-9][0-9]/', $mysqlinfo, $mysqlmatch);
$mysqlversion = $mysqlmatch[0];

if ($mysqlversion < 5) {
	echo '<tr><td><i class="icon icon-remove"></i></td>';
	echo '<td><a href="javascript:InsertContent(\'mysqlversion\');">MySQL Version ('.$mysqlversion.')</a></td>';
	echo '</tr>';
} else if ($mysqlversion > 4) {
	echo '<tr><td><i class="icon icon-ok"></i></td>';
	echo '<td><a href="javascript:InsertContent(\'mysqlversion\');">MySQL Version ('.$mysqlversion.')</a></td>';
	echo '</tr>';

}

echo '<tr><td style="width:20px;">', function_exists('curl_version') ? '<i class="icon icon-ok"></i></td>' : '<i class="icon icon-remove"></i></td>';
	echo '<td><a href="javascript:InsertContent(\'curlwarning\');">cURL</a></td></tr>';
echo '<tr><td>', function_exists('fopen') ? '<i class="icon icon-ok"></i></td>' : '<i class="icon icon-remove"></i></td>';
	echo '<td><a href="javascript:InsertContent(\'fopenwarning\');">fopen</a></td></tr>';
echo '<tr><td>', function_exists('fwrite') ? '<i class="icon icon-ok"></i></td>' : '<i class="icon icon-remove"></i></td>';
	echo '<td><a href="javascript:InsertContent(\'fwritewarning\');">fwrite</a></td></tr>';
echo '<tr><td>', file_get_contents(__FILE__) ? '<i class="icon icon-ok"></i></td>' : '<i class="icon icon-remove"></i></td>';
	echo '<td><a href="javascript:InsertContent(\'fgetwarning\');">file_get_contents</a></td></tr>';
echo '<tr><td>', function_exists('gd_info') ? '<i class="icon icon-ok"></i></td>' : '<i class="icon icon-remove"></i></td>';
	echo '<td><a href="javascript:InsertContent(\'gdwarning\');">GD Graphics Library</a></td></tr>';
echo '</tbody></table>';

echo '<div class="hero-unit" style="padding:25px 10px;"><p style="text-align:center">Please continue to the <a href="./install.php">Installation Page</a>, the <a href="./upgrade.php">Upgrade Page</a>, or the <a href="../readme.html">Pligg Readme</a>.</p></div>';

?>
	
<div id="phpversion" class="helpbox" style="display:none;">
<h3>PHP Version Warning</h3>
<p>Pligg has been tested on both PHP versions 4 and 5. We have designed the content management system based on PHP 5 technologies, so certain problems may occur when using older versions of PHP. We suggest that your server runs a mininum of PHP 5.</p>
</div>

<div id="mysqlversion" class="helpbox" style="display:none;">
<h3>MySQL Version Warning</h3>
<p>Pligg has been tested on both MySQL versions 4 and 5, during that process we have discovered that bugs will occassionally pop up is you are running MySQL 4. For this reason we suggest that you use a server with MySQL 5 or later to run a Pligg CMS website. MySQL 5 has been available for some time now and we hope that most major web hosts now support it. It offers features that are not built into MySQL 4, which we may have used when writing code for Pligg CMS.</p>
</div>

<div id="curlwarning" class="helpbox" style="display:none;">
<h3>cURL Warning</h3>
<p>Pligg and some Pligg modules may depend on cURL in order to operate. We suggest that you enable cURL on your web server to achieve the full functionality of Pligg and to avoid any errors. If the server has simply turned off cURL from you php.ini file it may be an easy fix. Open your server's php.ini file and find the line below, then remove the semicolon from the start of that line and restart Apache.</p>
<blockquote>;extension=php_curl.dll</blockquote>
<p>You may continue to install Pligg without enabling cURL, but it may result in errors when using some more advanced modules.</p>
</div>

<div id="fopenwarning" class="helpbox" style="display:none;">
<h3>fopen Warning</h3>
<p>The fopen() PHP function opens a file or URL. Pligg requires fopen to grab external files from Pligg.com that are used for installing and upgrading Pligg CMS. It is also used for monitoring modules for updates.</p>
</div>

<div id="fwritewarning" class="helpbox" style="display:none;">
<h3>fwrite Warning</h3>
<p>The fwrite() PHP function writes to an open file. The function will stop at the end of the file or when it reaches the specified length, whichever comes first. Pligg requires fwrite to grab external files from Pligg.com and save them to your local web server during the installation and upgrade process.</p>
</div>

<div id="fgetwarning" class="helpbox" style="display:none;">
<h3>file_get_contents Warning</h3>
<p>file_get_contents() is the preferred way to read the contents of a file into a string. Pligg requires this function to download the contents of external files from Pligg.com and save them to the local web server for installing and upgrading Pligg. </p>
</div>

<div id="gdwarning" class="helpbox" style="display:none;">
<h3>GD Graphics Library Warning</h3>
<p>In order to resize and save uploaded images, Pligg requires that you have installed the GD library. GD is used for all image upload functionality used in Pligg. It is also used for locally rendered CAPTCHAs and other various modules and features.</p>
</div>

<?php $include='footer.php'; if (file_exists($include)) { include_once($include); } ?>