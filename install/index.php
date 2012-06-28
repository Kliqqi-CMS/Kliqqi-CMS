<meta http-equiv="Refresh" content="1.2;URL=../readme.html">

<?php
$settings = '../settings.php';
$settingsdefault = '../settings.php.default';
if (file_exists($settings)) {
	echo "File /settings.php exists, skipping<br />";
} else {
	if (file_exists($settingsdefault)) {
	    rename("../settings.php.default", "../settings.php");
	} else {
		echo "/settings.php.default does not exist, the server was unable to automatically rename it to settings.php.<br />Alternatively your server might not support automatic renaming of this file.";
	}
}

$dbconnect = '../libs/dbconnect.php';
$dbconnectdefault = '../libs/dbconnect.php.default';
if (file_exists($dbconnect)) {
	echo "File /libs/dbconnect.php exists, skipping<br />";
} else {
	if (file_exists($dbconnectdefault)) {
	    rename("../libs/dbconnect.php.default", "../libs/dbconnect.php");
	} else {
		echo "/libs/dbconnect.php.default does not exist, the server was unable to automatically rename it to dbconnect.php.<br />Alternatively your server might not support automatic renaming of this file.";
	}
}

echo 'Continue to the <a href="./install.php">Installation Page</a>, the <a href="./upgrade.php">Upgrade Page</a>, or the <a href="../readme.html">Pligg Readme</a>.'

// Comment out or temporarily delete the line below if you wish to see that status of renaming the files above.

?>
