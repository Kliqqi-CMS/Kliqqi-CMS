<?php
// The source code packaged with this file is Free Software, Copyright (C) 2005 by
// Ricardo Galli <gallir at uib dot es>.
// It's licensed under the AFFERO GENERAL PUBLIC LICENSE unless stated otherwise.
// You can get copies of the licenses here:
// 		http://www.affero.org/oagpl.html
// AFFERO GENERAL PUBLIC LICENSE is also included in the file called "COPYING".

include_once('Smarty.class.php');
$main_smarty = new Smarty;

include('config.php');
include(mnminclude.'trackback.php');
include(mnminclude.'link.php');
include(mnminclude.'html1.php');
include(mnminclude.'smartyvariables.php');

function trackback_response($error = 0, $error_message = '') {
	header('Content-Type: text/xml; charset=UTF-8');
	if ($error) {
		echo '<?phpxml version="1.0" encoding="utf-8"?'.">\n";
		echo "<response>\n";
		echo "<error>1</error>\n";
		echo "<message>$error_message</message>\n";
		echo "</response>";
		die();
	} else {
		echo '<?phpxml version="1.0" encoding="utf-8"?'.">\n";
		echo "<response>\n";
		echo "<error>0</error>\n";
		echo "</response>";
	}
	die;
}

$tb_url    = strip_tags($_POST['url']);
$title     = strip_tags($_POST['title']);
$excerpt   = strip_tags($_POST['excerpt']);
$blog_name = strip_tags($_POST['blog_name']);
$charset   = strip_tags($_POST['charset']);

// DB 08/01/08
if (!preg_match("/^[hf]t[t]?p[s]?:\/\//",$tb_url))
    $tb_url = "";
/////


if(!empty($charset)) {
	$title = @iconv($charset, 'UTF-8//IGNORE', $title);
	$excerpt = @iconv($charset, 'UTF-8//IGNORE', $excerpt);
	$blog_name = @iconv($charset, 'UTF-8//IGNORE', $blog_name);
}

$tb_id = strip_tags($_GET['id']);

if ( !is_numeric( $tb_id ) )
	trackback_response(1, 'I really need an ID for this to work.');

if (empty($title) && empty($tb_url) && empty($blog_name)) {
	// If it doesn't look like a trackback at all...
	header('Location: ' . getmyFullurl("story", $tb_id));
	exit;
}

if ( !empty($tb_url) && !empty($title) && !empty($tb_url) ) {
	header('Content-Type: text/xml; charset=UTF-8');

	$title =  htmlspecialchars( strip_tags( $title ) );
	$title = (strlen($title) > 150) ? substr($title, 0, 150) . '...' : $title;
	$excerpt = strip_tags($excerpt);
	$excerpt = (strlen($excerpt) > 200) ? substr($excerpt, 0, 200) . '...' : $excerpt;

	$trackres = new Trackback;
	$trackres->link=$tb_id;
	$trackres->type='in';
	$trackres->url = $tb_url;
	$dupe = $trackres->read();
	if ( $dupe )
		trackback_response(1, $main_smarty->get_config_vars('PLIGG_Visual_Trackback_AlreadyPing'));
  
	$contents=@file_get_contents($tb_url);
	if(!$contents) 
		trackback_response(1, $main_smarty->get_config_vars('PLIGG_Visual_Trackback_BadURL'));
	

	$permalink=get_permalink($tb_id);
  $permalink_q=preg_quote($permalink,'/');
	$pattern="/<\s*a.*href\s*=[\"'\s]*".$permalink_q."[\"'\s]*.*>.*<\s*\/\s*a\s*>/i";
	if(!preg_match($pattern,$contents))
		trackback_response(1, $main_smarty->get_config_vars('PLIGG_Visual_Trackback_NoReturnLink'));
	
	$trackres->title=$title;
	$trackres->content=$excerpt;
	$trackres->status='ok';
	$trackres->store();

	trackback_response(0);
}

?>