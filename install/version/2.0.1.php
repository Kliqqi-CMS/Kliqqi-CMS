<?php
// This file is for performing an upgrade from Pligg 2.0.0 to 2.0.1

// Report all PHP errors
// error_reporting(E_ALL);

$new_version = '201';

// Check if you need to run the one time upgrade to Pligg 2.0.1
if ($old_version < $new_version) {

	echo '<li>Performing one-time Pligg 2.0.1 Upgrade<ul>';

    // Fixed a user level bug that users upgrading from 2.0.0 beta might now have fixed on their own
    $sql = "ALTER TABLE ".table_users." 
			CHANGE user_level user_level ENUM('normal','moderator','admin','Spammer') NOT NULL DEFAULT 'normal';";
    $db->query($sql);
    echo '<li>Fixing a user level bug for Beta users</li>';

	// Finished 2.0.0 upgrade
	echo'</ul></li>';
}

	
?>