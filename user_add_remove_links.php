<?php
// The source code packaged with this file is Free Software, Copyright (C) 2005 by 	 
// The Pligg Team <pligger at pligg dot com>. 	 
// It's licensed under the AFFERO GENERAL PUBLIC LICENSE unless stated otherwise. 	 
// You can get copies of the licenses here: 	 
//              http://www.affero.org/oagpl.html 	 
// AFFERO GENERAL PUBLIC LICENSE is also included in the file called "COPYING".

include_once('Smarty.class.php');
$main_smarty = new Smarty;

include('config.php');
include(mnminclude.'html1.php');
include(mnminclude.'link.php');
include(mnminclude.'smartyvariables.php');

check_referrer();


// "Save this" feature by Nick Strand, http://strandalo.us
// -------------------------------------------------------------------------------------

global $db;

if($current_user->user_id != 0)
{	
	$action = isset($_GET['action']) ? sanitize($_GET['action'], 3) : '';
	if($action == 'add') {	
		
		if(!($linkid = check_integer('link')))
		{	
			die("Invalid Link ID");
		}
		$link = new Link;
		$link->id=$linkid;
		$link->read();
		$title = $db->get_var("SELECT link_title_url FROM " . table_links . " WHERE link_id = $linkid");
		$count = $db->get_var("SELECT count(*) FROM " . table_saved_links . " WHERE saved_link_id = $linkid AND saved_user_id = $current_user->user_id");
		if ($count == 0)
		{
			$sql="INSERT INTO " . table_saved_links . " (saved_user_id, saved_link_id) VALUES ($current_user->user_id, $linkid)";
			$db->query($sql);
		}
		
	} elseif ($action == 'remove') {
		
		if(!($linkid = check_integer('link')))
		{	
			die("Invalid Link ID");
		}
		$link = new Link;
		$link->id=$linkid;
		$link->read();
		$title = $db->get_var("SELECT link_title_url FROM " . table_links . " WHERE link_id = $linkid");
		$count = $db->get_var("SELECT count(*) FROM " . table_saved_links . " WHERE saved_link_id = $linkid AND saved_user_id = $current_user->user_id");
		if ($count != 0)
		{
			$sql="DELETE FROM " . table_saved_links . " WHERE saved_user_id=$current_user->user_id AND saved_link_id=$linkid";
			$db->query($sql);
		}
		
	}
} 
?>