<?php
	include_once('internal/Smarty.class.php');
	$main_smarty = new Smarty;
	
	include('config.php');
include(mnminclude.'html1.php');
include(mnminclude.'link.php');
include(mnminclude.'group.php');
include(mnminclude.'smartyvariables.php');
	
	$group_display = "";
	
	$offset = isset($_REQUEST['start_up'])? $_REQUEST['start_up'] : "";
	$page_size = isset($_REQUEST['pagesize']) ? $_REQUEST['pagesize'] : "";
	
	$group = $db->get_results("SELECT * FROM " . table_groups . " WHERE group_status='Enable' ORDER BY group_status DESC LIMIT $offset, $page_size");
	
	
	//echo "<pre>";
	//echo "SELECT * FROM " . table_groups . " WHERE group_status='Enable' ORDER BY group_status DESC LIMIT $offset, $page_size";
	//print_r($group);
	
	if ($group)
	{
		
		foreach($group as $groupid)
		{
			//echo "Hello";
			$group_display .= group_print_summary($groupid->group_id);
		}
		echo $group_display;
	}
	
?>