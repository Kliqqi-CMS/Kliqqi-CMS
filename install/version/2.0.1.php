<?php
// This file is for performing an upgrade from Pligg 2.0.0rc3 to 2.0.1

// Report all PHP errors
// error_reporting(E_ALL);

// Check for the current version within each upgrade file
$sql = "SELECT data FROM " . table_misc_data . " WHERE name = 'pligg_version'";
$pligg_version = $db->get_var($sql);

// Check if you need to run the one time upgrade to Pligg 2.0.1
if ($pligg_version = '2.0.0') {

	echo '<li>Performing one-time Pligg 2.0.1 Upgrade<ul>';
	
	// Remove the Custom Avatar Storage Directory Option
	$sql = "DELETE FROM " . table_config . " 
			WHERE var_name='User_Upload_Avatar_Folder'";
	$db->query($sql);
	echo '<li>Removed Custom Avatar Directory Option</li>';
	
	// Update version number
	$sql = "UPDATE `" . table_misc_data . "` SET `data` = '2.0.1' WHERE `name` = 'pligg_version';";
	$db->query($sql);
	echo '<li>Updated version number to 2.0.1</li>';
	
	// Finished 2.0.1 upgrade
	echo'</ul></li>';
}

	
?>