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


function delete_comment($key) {
    global $db;
    if (!is_numeric($key)) return;
   
	$link_id = $db->get_var("SELECT comment_link_id FROM `" . table_comments . "` WHERE `comment_id` = ".$key.";");
	
	$vars = array('comment_id' => $key);
	check_actions('comment_deleted', $vars);

	$comments = $db->get_results($sql="SELECT comment_id FROM " . table_comments . " WHERE `comment_parent` = '$key'");
	foreach($comments as $comment)
	{
	   	$vars = array('comment_id' => $comment->comment_id);
	   	check_actions('comment_deleted', $vars);
	}
	$db->query('DELETE FROM `' . table_comments . '` WHERE `comment_parent` = "'.$key.'"');
	$db->query('DELETE FROM `' . table_comments . '` WHERE `comment_id` = "'.$key.'"');

	$link = new Link;
	$link->id=$link_id;
	$link->read();
	$link->recalc_comments();
	$link->store();
}

$sql_query = "SELECT comment_id FROM " . table_comments . " WHERE comment_status = 'discard'";
$result = mysql_query($sql_query);
$num_rows = mysql_num_rows($result);
while($comment = mysql_fetch_object($result))
        delete_comment($comment->comment_id);
?>
<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h4 class="modal-title"><?php echo $main_smarty->get_config_vars('PLIGG_Visual_AdminPanel_Discarded_Comments_Removed') ?></h4>
		</div>
		<div class="modal-body">
			<?php 
			$query = "OPTIMIZE TABLE comments";
			mysql_query($query);
			if (mysql_error()){
				echo '<p>'.mysql_error().'</p>';
			}else{
				echo '<p><strong>'.$num_rows.'</strong> '.$main_smarty->get_config_vars("PLIGG_Visual_AdminPanel_Discarded_Comments_Removed_Message").'</p>';
			}
			?>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
		</div>
	</div><!-- /.modal-content -->
</div>
