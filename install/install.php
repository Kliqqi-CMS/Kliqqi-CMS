<?php
session_start();
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING ^ E_STRICT);

$page = 'install';

if (isset($_REQUEST['step'])) { $step=addslashes(strip_tags($_REQUEST['step'])); }

//check for no steps, start on step1
if ((!isset($step)) || ($step == "")) { $step = 0; }


if ($step == 0) { 
	include('install_language.php');
}

$include='header.php'; 
if (file_exists($include)) { include_once($include); }
$include='functions.php'; 
if (file_exists($include)) { require_once($include); }

echo '<div class="steps"><legend>' . $lang['Step'] . ' '.$step.'</legend></div>';
echo '<div class="installercontent">';

// intro

if ($step == 1) { 
	include('install1.php');
	$_SESSION['checked_step'] = 0;
}

//error checking and enter database settings
if ($step == 2) {
	$_SESSION['checked_step'] = 0;
	include('install2.php');
}

//check database settings, store to file
if ($step == 3) {
	include('install3.php');
}

//update config settings file, 
if ($step == 4) {
	include('install4.php'); 
}

//update config settings file, 
if ($step == 5) {
	include('install5.php');
}

echo '</div>';

$include='footer.php'; if (file_exists($include)) {include_once($include);}

?>