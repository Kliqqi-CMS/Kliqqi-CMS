<?php
// This file is for performing an upgrade from Pligg 1.0 to 2.0.

// Get your Pligg Version
$sql = "SELECT data FROM " . table_misc_data . " WHERE name = 'pligg_version'";
$pligg_version = $db->get_var($sql);

$old_version = str_replace('.', '' , $pligg_version);
$new_version = '200';

// Check if you need to run the one time upgrade to Pligg 2.0
if ($old_version < $new_version) {
	//echo $lang['UpgradingTables'] . '<br />';
	echo '<li>Performing one-time Pligg 2.0 Upgrade</li><ul>';

	$sql = "UPDATE ".table_users." SET user_level='moderator' WHERE user_level='admin';";
	$db->query($sql);
	echo '<li>Changed Admin to Moderator</li>';

	$sql = "UPDATE ".table_users." SET user_level='admin' WHERE user_level='god';";
	$db->query($sql);
	echo '<li>Changed God to Admin</li>';
	
	// Finished 2.0 upgrade
	echo'</ul>';
}

?>