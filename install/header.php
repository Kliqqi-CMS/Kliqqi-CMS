<?php
set_time_limit(0);
header('Content-type: text/html; charset=UTF-8');

if ($_GET['language'])
    $language = addslashes(strip_tags($_GET['language']));
if($language != 'local'){
	include_once('../languages/installer_lang.php');
} else {
	include_once('../languages/installer_lang_default.php');
}
//remember to escape any ' that are added (eg: \')

print '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>

	<link rel="stylesheet" type="text/css" href="../templates/admin/css/fraxi.css" media="screen" />

	<meta name="Robots" content="none" />
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	
	<title>Pligg CMS ' . $lang['installer'] . '</title>
	<link rel="icon" href="../favicon.ico" type="image/x-icon"/>
	
	<!--[if lte IE 6]><link rel="stylesheet" href="../templates/admin/css/ie6.css" type="text/css" media="all" /><![endif]-->
	
</head>
<body>';
include("menu.php");
print '
<div id="main_content">
	<div class="bluerndcontent">
		<div class="instructions">';

?>
<script>
function Set_Cookie( name, value, expires, path, domain, secure )
{
var today = new Date();
today.setTime( today.getTime() );

if ( expires )
    expires = expires * 1000 * 60 * 60 * 24;
var expires_date = new Date( today.getTime() + (expires) );

document.cookie = name + "=" +escape( value ) +
( ( expires ) ? ";expires=" + expires_date.toGMTString() : "" ) +
( ( path )    ? ";path=" + path : "" ) +
( ( domain )  ? ";domain=" + domain : "" ) +
( ( secure )  ? ";secure" : "" );
}
</script>
