<?php
// This file is for performing an upgrade from Pligg 2.0.0rc2 to 2.0.0

// Report all PHP errors
// error_reporting(E_ALL);

// Check for the current version within each upgrade file
$sql = "SELECT data FROM " . table_misc_data . " WHERE name = 'pligg_version'";
$pligg_version = $db->get_var($sql);

// Check if you need to run the one time upgrade to Pligg 2.0.0
if ($pligg_version = '2.0.0rc2') {

	echo '<li>Performing one-time Pligg 2.0.0 Upgrade<ul>';

	// 2.0.0 RC2 incorrectly defined the group member user levels
    $sql = "ALTER TABLE ".table_group_member." 
			CHANGE member_role member_role ENUM( 'admin', 'normal', 'moderator', 'flagged', 'banned') NOT NULL;";
    $db->query($sql);
	echo '<li>Correcting group member user levels</li>';
	
	// Update version number
	$sql = "UPDATE `" . table_misc_data . "` SET `data` = '2.0.0' WHERE `name` = 'pligg_version';";
	$db->query($sql);
	echo '<li>Updated version number to 2.0.1</li>';
	
	// Finished 2.0.0 upgrade
	echo'</ul></li>';
}

?>