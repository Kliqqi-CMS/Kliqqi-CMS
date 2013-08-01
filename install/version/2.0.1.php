<?php
// This file is for performing an upgrade from Pligg 2.0.0rc2 to 2.0.1

// Report all PHP errors
// error_reporting(E_ALL);

$new_version = '201';

// Check if you need to run the one time upgrade to Pligg 2.0.1
if ($old_version < $new_version) {

	echo '<li>Performing one-time Pligg 2.0.1 Upgrade<ul>';


	// Finished 2.0.0 upgrade
	echo'</ul></li>';
}

	
?>