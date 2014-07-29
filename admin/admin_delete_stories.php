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


function delete_storylink($linkid) {
    if (!is_numeric($linkid)) return;
   

    $query="SELECT * FROM " . table_links . " WHERE link_id = '$linkid'";
    if (! $result=mysql_query($query)) {error_page(mysql_error());}
    else {$sql_array = mysql_fetch_object($result); }

    # delete the story link
    $query="DELETE FROM " . table_links . " WHERE link_id = '$linkid'";
    if (! $result=mysql_query($query)) {error_page(mysql_error());}

    # delete the story comments
    $query="DELETE FROM " . table_comments . " WHERE comment_link_id = '$linkid'";
    if (! $result=mysql_query($query)) {error_page(mysql_error());}

    # delete the saved links
    $query="DELETE FROM " . table_saved_links . " WHERE saved_link_id = '$linkid'";
    if (! $result=mysql_query($query)) {error_page(mysql_error());}

    # delete the story tags
    $query="DELETE FROM " . table_tags . " WHERE tag_link_id = '$linkid'";
    if (! $result=mysql_query($query)) {error_page(mysql_error());}

    # delete the story trackbacks
    $query="DELETE FROM " . table_trackbacks . " WHERE trackback_link_id = '$linkid'";
    if (! $result=mysql_query($query)) {error_page(mysql_error());}

    # delete the story votes
    $query="DELETE FROM " . table_votes . " WHERE vote_link_id = '$linkid'";
    if (! $result=mysql_query($query)) {error_page(mysql_error());}

    # delete additional categories
    $query="DELETE FROM ".table_additional_categories." WHERE ac_link_id = '$linkid'";
    if (! $result=mysql_query($query)) {error_page(mysql_error());}

    // module system hook
    $vars = array('link_id' => $linkid);
    check_actions('admin_story_delete', $vars);
}


$sql_query = "SELECT * FROM " . table_links . " WHERE link_status = 'discard'";

$result_storylinks = mysql_query($sql_query);
$num_rows = mysql_num_rows($result_storylinks);
                while($storylink = mysql_fetch_object($result_storylinks))
                {
                        delete_storylink($storylink->link_id);
                }

# set discards total to zero
$query="UPDATE " . table_totals . " SET total = '0' WHERE name = 'discard'";
if (!mysql_query($query)) error_page(mysql_error());

$query="DELETE FROM " . table_tag_cache;
if (!mysql_query($query)) {error_page(mysql_error());}

# Redwine - Sidebar tag cache fix
$sql="INSERT INTO ".table_tag_cache." select tag_words, count(DISTINCT link_id) as count FROM ".table_tags.", ".table_links." WHERE tag_lang='en' and link_id = tag_link_id and (link_status='published' OR link_status='new') GROUP BY tag_words order by count desc";
if (!mysql_query($sql)) {error_page(mysql_error());}


?>

<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h4 class="modal-title"><?php echo $main_smarty->get_config_vars('PLIGG_Visual_AdminPanel_Discarded_Stories_Removed') ?></h4>
		</div>
		<div class="modal-body">
			<?php
				$query = "SHOW TABLE STATUS";
				$result=mysql_query($query);
				$table_list = "";
				while ($cur_table = mysql_fetch_object($result)) {
					$table_list .= $cur_table->Name.", ";
				}

				if (!empty($table_list)) {
					$table_list = substr($table_list, 0, -2);
					$query = "OPTIMIZE TABLE ".$table_list;
					mysql_query($query);
				if (mysql_error())
					echo '<p>'.mysql_error().'</p>';
				else
					echo '<p><strong>'.$num_rows.'</strong> '.$main_smarty->get_config_vars("PLIGG_Visual_AdminPanel_Discarded_Stories_Removed_Message").'</p>';
				}
			?>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
		</div>
	</div><!-- /.modal-content -->
</div>
