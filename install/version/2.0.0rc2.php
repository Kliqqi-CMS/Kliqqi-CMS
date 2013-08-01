<?php
// This file is for performing an upgrade from Pligg 2.0.0 to 2.0.0rc2

// Report all PHP errors
// error_reporting(E_ALL);

$new_version = '200.2';

// Check if you need to run the one time upgrade to Pligg 2.0.1
if ($old_version < $new_version) {

	echo '<li>Performing one-time Pligg 2.0.0 RC2 Upgrade<ul>';

    // Fixed a user level bug that users upgrading from 2.0.0 beta might now have fixed on their own
    $sql = "ALTER TABLE ".table_users." 
			CHANGE user_level user_level ENUM('normal','moderator','admin','Spammer') NOT NULL DEFAULT 'normal';";
    $db->query($sql);
    echo '<li>Fixing a user level bug for Beta users</li>';
	
	// Add new pagination methods
	$result = $db->get_results("select * from `" . table_config . "` where `var_name` = 'Auto_scroll';");
	if (count($result) == 0) {
		$db->query("INSERT INTO `" . table_config . "` VALUES (NULL, 'Misc', 'Auto_scroll', '1', '1', '1-3', 'Pagination Mode', '<strong>1.</strong> Use normal pagination links <br /><strong>2.</strong> JavaScript that automatically adds more articles to the bottom of the page<br /><strong>3</strong> JavaScript button to manually load more articles', 'define', NULL)");
	}
	echo '<li>Added new pagination modes</li>';
	
	// Finished 2.0.0 upgrade
	echo'</ul></li>';
}

	
?>