<?php 
	include_once('internal/Smarty.class.php');
	$main_smarty = new Smarty;
	
	include('config.php');
	include(mnminclude.'html1.php');
	include(mnminclude.'link.php');
	include(mnminclude.'tags.php');
	include(mnminclude.'search.php');
	include(mnminclude.'smartyvariables.php');

	$search = new Search();
	
	if(isset($_REQUEST['start_up']) and $_REQUEST['start_up']!= '' and $_REQUEST['pagesize'] != ''){
		
		$pagesize = $_REQUEST['pagesize'];
		$start_up = $_REQUEST['start_up'];
		$limit = " LIMIT $start_up, $pagesize";	
	}
	if(isset($_REQUEST['sql']) and $_REQUEST['sql']!= ''){
		$sql = $_REQUEST['sql'];
		$search->sql = $sql.$limit;
	}
	
	$fetch_link_summary = true;
	$linksum_sql = $sql.$limit;
	
	
	include('./libs/link_summary.php'); // this is the code that show the links / stories
	echo $link_summary_output;
?>