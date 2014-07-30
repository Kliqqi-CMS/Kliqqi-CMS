<?php
// This file is for performing an upgrade from Pligg 2.0.1 to 2.0.2

// Report all PHP errors
// error_reporting(E_ALL);

// Check for the current version within each upgrade file
$sql = "SELECT data FROM " . table_misc_data . " WHERE name = 'pligg_version'";
$pligg_version = $db->get_var($sql);

// Check if you need to run the one time upgrade to Pligg 2.0.2
if ($pligg_version = '2.0.1') {

	echo '<li>Performing one-time Pligg 2.0.2 Upgrade<ul>';

	// Update version number
	$sql = "UPDATE `" . table_misc_data . "` SET `data` = '2.0.2' WHERE `name` = 'pligg_version';";
	$db->query($sql);
	echo '<li>Updated version number to 2.0.2</li>';
	
	// Finished 2.0.2 upgrade
	echo'</ul></li>';
}

	
?>