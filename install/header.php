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

?><!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>

	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="Robots" content="none" />
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	
	<link rel="stylesheet" type="text/css" href="../templates/admin/css/bootstrap.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="../templates/admin/css/bootstrap-responsive.css">
	<link rel="stylesheet" type="text/css" href="../templates/admin/css/style.css" media="screen" />
	<style type="text/css">
	body {
		padding-top: 60px;
		position: relative;
		background-color: #fff;
		background-image: url(../templates/admin/img/grid-18px-masked.png);
		background-repeat: repeat-x;
		background-position: 0 40px;
	}
	.navbar-fixed-top, .navbar-fixed-bottom {
		position:absolute;
	}
	.navbar .nav > li > a {
		padding-top:11px;
	}
	.popover {
		width:500px;
	}
	</style>
	
	<title>Pligg CMS <?php $lang['installer'] ?></title>
		
</head>
<body>
<?php
include("menu.php");
?>

<div class="container">
	<section id="maincontent">
		<div class="row">
			<div class="span12">
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
				