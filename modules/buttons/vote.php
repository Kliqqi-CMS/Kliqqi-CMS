<?php
/**
 * Proxy script for AJAX voting calls
 *
 * 
 * http://www.pligg.domain/modules/buttons/vote.php?id=6&user=1&md5=d2a0e309be40a671fbb25e6249d2d235&value=-10&unvote=1
 */
header ("Expires: ".gmdate("D, d M Y H:i:s", time())." GMT"); 
header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
header ("Cache-Control: no-cache, must-revalidate"); 
header ("Pragma: no-cache");

chdir('../../');

$_SERVER['HTTP_REFERER'] = '';
$_POST['id'] = $_GET['id'];
$_POST['md5'] = $_GET['md5'];
$_POST['user'] = $_GET['user'];
$_POST['value'] = $_GET['value'];
$_POST['unvote'] = $_GET['unvote'];

// To catch die() messages 
register_shutdown_function('shutdown');

// Call vote_total to process button click
ob_start();
include('vote_total.php');


/**
 * Shutdown function
 * Grab output from the buffer and return proper JSON
 */
function shutdown()
{
    $output = array(
	'htmlid' => $_GET['id'],
	'value'  => $_GET['value']
    );
    $output['message'] = ob_get_contents();
    ob_end_clean();

    $callback = $_GET['callback'];
    print "$callback(".json_encode($output).')';
}
?>
