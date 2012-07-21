<?php
include('../config.php');
include(mnminclude.'html1.php');

// require user to log in
force_authentication();

// restrict access to admins
$canIhaveAccess = 0;
$canIhaveAccess = $canIhaveAccess + checklevel('admin');

if($canIhaveAccess == 0){	
	header("Location: " . getmyurl('login', $_SERVER['REQUEST_URI']));
	die();
}

if ($_GET['clear'])
{
    $fp = fopen('../'.LOG_FILE, "a");
    ftruncate($fp,0);
    fclose($fp);
    header("Location: admin_log.php");
    exit;
}

print "<button onclick='document.location.href=\"admin_log.php?clear=1\"'>Clear log</button><br><br>";
print "<pre>";

@readfile('../'.LOG_FILE);
?>