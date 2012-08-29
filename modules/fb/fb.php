<?php
//
// FB oauth login
//
chdir('../');
include_once('../internal/Smarty.class.php');$main_smarty = new Smarty;

$do_not_include_in_pages_core[] = 'fb';
include('../config.php');

include(mnminclude.'html1.php');
include(mnminclude.'link.php');
include_once(mnminclude.'utils.php');
include(mnminclude.'user.php');
include(mnminclude.'smartyvariables.php');

require_once('fb_main.php');

function showLogin() {
	global $facebook;
	$loginUrl = $facebook->getLoginUrl(	array(
	    'scope' => 'publish_stream,email,share_item',
	    'display' => 'popup'
	));

	header("Location: ".$loginUrl."");
	exit;
}

$facebook = fb_facebook_client();
if ($_GET['mode']!='perm' || $_GET['perms']) {
  try {  
    	$uid = $facebook->getUser();
	if($uid) {
		 $me = $facebook->api('/me/accounts');
		 if($me) {
			if (!$user->authenticated) {
?>
				<script language="javascript">
				window.opener.location='login.php';
				window.close();
				</script>
<?php
#				header("Location: login.php");
				exit;
			}

#			header("Location: ../../index.php");
?>
			<script language="javascript">
			window.opener.location='../../index.php';
			window.close();
			</script>
<?php
			exit;
		}
		else showLogin();
	}
	else {
		showLogin();
	}
  } catch (Exception $e) {
	print_r($e);
	exit;
#	showLogin();
  }
}
else {
	showLogin();
}

?>