<?php

include_once('Smarty.class.php');
$main_smarty = new Smarty;

include('config.php');
include(mnminclude.'html1.php');
include(mnminclude.'link.php');
//include(mnminclude.'tags.php');
include(mnminclude.'search.php');
include(mnminclude.'smartyvariables.php');

// start a new search
$search=new Search();

// check for some get/post
 
$page_name=$_REQUEST['pname'];
$catID=$_REQUEST['catID'];
$groupid=$_REQUEST['groupid'];
$start_up=$_REQUEST['start_up'];
$part=$_REQUEST['part'];
$view=$_REQUEST['view'];


if(isset($catID)){$search->category = $catID;}
if(isset($part)){$search->setmek = $db->escape($part);}

// figure out what "page" of the results we're on
//$search->offset = (get_current_page()-1)*$page_size;
$search->offset = $start_up;
// pagesize set in the admin panel
$search->pagesize = 8;

// since this is index, we only want to view "published" stories
$search->filterToStatus = "published";

// this is for the tabs on the top that filter

$search->do_setmek();	

// do the search
$search->doSearch();

$linksum_count = $search->countsql;

if($page_name=='group_story'){
	
	$group_vote=4;


	
	if ($view == 'upcoming'){
			$from_where .= " AND link_votes<$group_vote AND link_status='queued'";
			$linksum_sql = "SELECT SQL_CALC_FOUND_ROWS * FROM " . table_links . " WHERE link_group_id = $groupid AND link_group_status!='discard' $from_where GROUP BY link_id ORDER BY link_published_date DESC, link_date DESC LIMIT $start_up, $page_size";
	
			
	}elseif($view== 'published'){                
			$from_where .= " AND ((link_votes >= $group_vote AND link_status = 'queued') OR link_status = 'published')";
	
			$linksum_sql = "SELECT SQL_CALC_FOUND_ROWS * FROM " . table_links . " WHERE link_group_id = $groupid AND link_group_status!='discard' $from_where GROUP BY link_id ORDER BY link_published_date DESC, link_date DESC LIMIT $start_up, $page_size";
	
	}elseif($view=="shared"){
		$linksum_sql="SELECT SQL_CALC_FOUND_ROWS b.* FROM " . table_group_shared . " a
						LEFT JOIN " . table_links . " b ON link_id=share_link_id
						WHERE share_group_id = $groupid AND !ISNULL(link_id) $from_where 
						GROUP BY link_id
						ORDER BY link_published_date DESC, link_date DESC  LIMIT $start_up, $page_size";
		
	}

}else
$linksum_sql = $search->sql;

$fetch_link_summary = true;
include(mnminclude.'link_summary.php'); // this is the code that show the links / stories
//$main_smarty->assign('link_pagination', do_pages($rows, $page_size, "published", true));

echo $link_summary_output;

?>