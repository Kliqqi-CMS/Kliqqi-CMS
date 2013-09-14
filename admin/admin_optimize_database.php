<?php

include_once('../internal/Smarty.class.php');
$main_smarty = new Smarty;

include('../config.php');
include(mnminclude.'html1.php');
include(mnminclude.'link.php');
include(mnminclude.'user.php');
include(mnminclude.'smartyvariables.php');

// If called from a browser, required authentication. Cron version does not require.
if ($_SERVER['SERVER_ADDR'])
{
	check_referrer();

	// require user to log in
	force_authentication();

	// restrict access to admins
	$canIhaveAccess = 0;
	$canIhaveAccess = $canIhaveAccess + checklevel('admin');

	if($canIhaveAccess == 0){	
//		$main_smarty->assign('tpl_center', '/admin/access_denied');
//		$main_smarty->display($template_dir . '/admin/admin.tpl');		
		header("Location: " . getmyurl('admin_login', $_SERVER['REQUEST_URI']));
		die();
	}
}

// $message = "";

    $query = "SHOW TABLE STATUS";
    $result=mysql_query($query);
    $table_list = "";
    while ($cur_table = mysql_fetch_object($result)) {
        $table_list .= $cur_table->Name.", ";
    }
?>
<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h4 class="modal-title"><?php echo $main_smarty->get_config_vars('PLIGG_Visual_AdminPanel_Optimized') ?></h4>
		</div>
		<div class="modal-body">
			<?php
				if (!empty($table_list)) {
					$table_list = substr($table_list, 0, -2);
					$query = "OPTIMIZE TABLE ".$table_list;
					mysql_query($query);
				if (mysql_error())
					echo '<p>'.mysql_error().'</p>';
				else
					echo '<p>'.$main_smarty->get_config_vars("PLIGG_Visual_AdminPanel_Optimized_Message").'</p>';
				}
			?>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
		</div>
	</div><!-- /.modal-content -->
</div>
