<?
header ("Expires: ".gmdate("D, d M Y H:i:s", time())." GMT"); 
header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
header ("Cache-Control: no-cache, must-revalidate"); 
header ("Pragma: no-cache");
header ("Content-type: text/css");

chdir('../');
include_once('../Smarty.class.php');
$main_smarty = new Smarty;

include('../config.php');
if (file_exists(mnmpath.'/cache/evb.css'))
	readfile(mnmpath.'/cache/evb.css');
else
	readfile(mnmpath.'/modules/buttons/evb.css');
exit;

include(mnminclude.'html1.php');
include(mnminclude.'link.php');
include_once(mnminclude.'utils.php');
include(mnminclude.'user.php');
include(mnminclude.'smartyvariables.php');

if (!($large_height = get_misc_data('buttons_large_height'))) $large_height = 61;
if (!($large_width = get_misc_data('buttons_large_width'))) $large_width = 50;
if (!($large_back = get_misc_data('buttons_large_back'))) $large_back = 'images/large_background.png';
if (!($large_image = get_misc_data('buttons_large_image'))) $large_image = 'images/large_buttons.png';
if (!($small_height = get_misc_data('buttons_small_height'))) $small_height = 17;
if (!($small_width = get_misc_data('buttons_small_width'))) $small_width = 76;
if (!($small_back = get_misc_data('buttons_small_back'))) $small_back = 'images/small_background.png';
if (!($small_image = get_misc_data('buttons_small_image'))) $small_image = 'images/small_buttons.png';

?>
/* Large EVB */
.evb_large_wrapper {
	font-family: Tahoma, Verdana, Helvetica, Arial;
	padding:0;
	margin:0;
	width:<?=$large_width?>px;
	height:<?=$large_height?>px;
	overflow:hidden;
	background:transparent url(<?=$large_back?>) no-repeat center top;
	color:#000;
}
.evb_large_vote_count {
	margin:4px 0 0 0;
	padding:0;
	font-size:16px;
	font-weight:bold;
	text-align:center;
}
.evb_large_vote_count a{
	text-decoration:none;
	color:#000;
}
.evb_large_vote_text {
	margin:-3px 0 0 0;
	padding:0;
	font-size:11px;
	font-weight:normal;
	text-align:center;
}
#evb_large_button {
	margin:2px 0 0 4px;
	background:transparent url(<?=$large_image?>) no-repeat center top;
	width:42px;
	height:21px;
	padding:0;
	font-size:21px;
	letter-spacing:14px;
}
.evb_large_button a{
	text-decoration:none;
}


/* Small EVB */
.evb_small_wrapper {
	font-family: Tahoma, Verdana, Helvetica, Arial;
	padding:0;
	margin:0;
	width:<?=$small_width?>px;
	height:<?=$small_height?>px;
	overflow:show;
	background:transparent url(<?=$small_back?>) no-repeat center top;
	color:#000;
}
.evb_small_vote_count {
	float:left;
	width:35px;
	margin:0px 0 0 0;
	padding:0;
	font-size:13px;
	font-weight:bold;
	text-align:center;
}
.evb_small_vote_count a{
	text-decoration:none;
	color:#000;
}
#evb_small_vote_button {
	float:left;
	padding:0;
	margin:0;
	background:transparent url(<?=$small_image?>) no-repeat center top;
	height:17px;
	width:41px;
}
.evb_small_vote_text {
	float:left;
	margin:2px 0 0 13px;
	padding:0;
	font-size:10px;
	font-weight:normal;
}
.evb_small_vote_text a{
	text-decoration:none;
	color:#000;
}