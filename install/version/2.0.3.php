<?php
// This file is for performing an upgrade from Pligg 2.0.2 to 2.0.3

// Report all PHP errors
// error_reporting(E_ALL);

// Check for the current version within each upgrade file
$sql = "SELECT data FROM " . table_misc_data . " WHERE name = 'pligg_version'";
$pligg_version = $db->get_var($sql);

// Check if you need to run the one time upgrade to Pligg 2.0.1
if (version_compare($pligg_version, '2.0.2') <= 0) {

	echo '<li>Performing one-time Pligg 2.0.3 Upgrade<ul>';
	
	$sql = "UPDATE ".table_config." 
			SET `var_title` = 'Negative Votes Story Discard' 
			WHERE `var_name` = 'buries_to_spam';";
    $db->query($sql);	
	$sql = "UPDATE `" . table_config . "` 
			SET `var_desc` = 'If set to 1, stories with enough down votes will be discarded. The formula for determining what gets buried is stored in the database table table_formulas. It defaults to discarding stories with 3 times more downvotes than upvotes.'
			WHERE `var_name` = 'buries_to_spam';";
	$db->query($sql);
	$sql = "UPDATE ".table_config." 
			SET `var_optiontext` = '1 = on / 0 = off' 
			WHERE `var_name` = 'buries_to_spam';";
    $db->query($sql);	
	echo '<li>Updated the title and description for the "Negative Votes Story Discard" feature</li>';	
	
	// Update version number
	$sql = "UPDATE `" . table_misc_data . "` SET `data` = '2.0.3' WHERE `name` = 'pligg_version';";
	$db->query($sql);
	echo '<li>Updated version number to 2.0.3</li>';
		
	// Finished 2.0.3 upgrade
	echo'</ul></li>';
}

	
?>