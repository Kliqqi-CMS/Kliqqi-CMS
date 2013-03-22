<?php

include_once('../internal/Smarty.class.php');
$main_smarty = new Smarty;

include('../config.php');
include(mnminclude.'html1.php');
include(mnminclude.'link.php');
include(mnminclude.'user.php');
include(mnminclude.'smartyvariables.php');

check_referrer();

// require user to log in
force_authentication();

// restrict access to admins
$canIhaveAccess = 0;
$canIhaveAccess = $canIhaveAccess + checklevel('admin');

if($canIhaveAccess == 0){	
	header("Location: " . getmyurl('admin_login', $_SERVER['REQUEST_URI']));
	die();
}

recursive_remove_directory('../cache',TRUE);

?>
<div class="modal-header">
	<a class="close" data-dismiss="modal">&times;</a>
	<h3><?php echo $main_smarty->get_config_vars('PLIGG_Visual_AdminPanel_Cleared_Cache') ?></h3>
</div>
<div class="modal-body">
	<p><?php echo $main_smarty->get_config_vars('PLIGG_Visual_AdminPanel_Cleared_Cache_Message') ?></p>
</div>
<div class="modal-footer">
	<a class="btn btn-primary" data-dismiss="modal">Close</a>
	<!-- <?php echo $main_smarty->get_config_vars('PLIGG_Visual_AdminPanel_Return_Admin') ?> -->
</div>