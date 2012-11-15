<?php

if (strpos($_SERVER['SCRIPT_NAME'], 'rss_import') > 1){
	die('You need to copy this file into your root Pligg folder.');
}

include_once('/internal/Smarty.class.php');
$main_smarty = new Smarty;

		include_once('config.php');		
		include_once(mnminclude.'html1.php');
		include_once(mnminclude.'link.php');
		include_once(mnminclude.'tags.php');
		include_once(mnminclude.'smartyvariables.php');
		
	include_once('/modules/rss_import/rss_import_settings.php');
	include_once('/modules/rss_import/rss_import_main.php');
	
	rss_import_do_import(false);

?>
