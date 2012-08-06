<?php
header ("Expires: ".gmdate("D, d M Y H:i:s", time())." GMT"); 
header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
header ("Cache-Control: no-cache, must-revalidate"); 
header ("Pragma: no-cache");

chdir('../../');

#include('config.php');
#$_SERVER['HTTP_REFERER'] = my_base_url . my_pligg_base;

$_SERVER['HTTP_REFERER'] = '';
$_POST['id'] = $_GET['id'];
$_POST['md5'] = $_GET['md5'];
$_POST['user'] = $_GET['user'];
$_POST['value'] = $_GET['value'];

ob_start();
include('vote.php');
$output = ob_get_contents();
ob_end_clean();

if(Voting_Method == 1)
{
    if (!preg_match('/^(\d+)\s*~/',$output,$m))
	exit;
}
else
{
    if (!preg_match('/~(\d+)$/',$output,$m))
	exit;
}

?>
var a = document.getElementsByTagName('A');
for (var i=0; i<a.length; i++)
    if (a[i].id.indexOf('xvotes-<?=$_POST['id']?>')==0)
	a[i].innerHTML = '<?=$m[1]?>';
<?
function error($mess)
{
    ob_end_clean();
    print "alert('$mess');";
    exit;
}
?>