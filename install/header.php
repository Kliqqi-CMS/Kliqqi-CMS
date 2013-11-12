<?php
set_time_limit(0);
header('Content-type: text/html; charset=UTF-8');

if ($_GET['language'])
    $language = addslashes(strip_tags($_GET['language']));
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
	$language = 'english';
	include_once('./languages/lang_english.php');
}

?><!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>

	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="Robots" content="none" />
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	
	<link href="../templates/admin/css/bootstrap.no-icons.min.css" rel="stylesheet">
	<link href="../templates/admin/css/font-awesome.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="../templates/admin/css/style.css" media="screen" />
	<style type="text/css">
	body {
		padding-top: 75px;
		background-color: #ffffff;
		background-image: url(../templates/admin/img/grid-18px-masked.png);
		background-repeat: repeat-x;
		background-position: 0 46px;
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
			<div class="col-md-12">
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
				