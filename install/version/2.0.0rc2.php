<?php
// This file is for performing an upgrade from Pligg 2.0.0rc1 to 2.0.0rc2

// Report all PHP errors
// error_reporting(E_ALL);

// Check for the current version within each upgrade file
$sql = "SELECT data FROM " . table_misc_data . " WHERE name = 'pligg_version'";
$pligg_version = $db->get_var($sql);

// Check if you need to run the one time upgrade to Pligg 2.0.0rc2
if ($pligg_version == '2.0.0rc1') {

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
	
	// Update version number
	$sql = "UPDATE `" . table_misc_data . "` SET `data` = '2.0.0rc2' WHERE `name` = 'pligg_version';";
	$db->query($sql);
	echo '<li>Updated version number to 2.0.0rc2</li>';
	
	// Finished 2.0.0rc2 upgrade
	echo'</ul></li>';
}

	
?>