<?
header ("Expires: ".gmdate("D, d M Y H:i:s", time())." GMT"); 
header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
header ("Cache-Control: no-cache, must-revalidate"); 
header ("Pragma: no-cache");
header ("Content-type: text/css");

chdir('../');
include_once('../internal/Smarty.class.php');
$main_smarty = new Smarty;

// Do not load modules here
$do_not_include_in_pages_core[] = 'evb';
include('../config.php');

if (file_exists(mnmpath.'/cache/style.css'))
	readfile(mnmpath.'/cache/style.css');
else
	readfile(mnmpath.'/modules/buttons/style.css');
exit;
?>