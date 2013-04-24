<?php

include_once('internal/Smarty.class.php');
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


$page_size=$_REQUEST['pagesize'];
$catID=$_REQUEST['catID'];
$groupid=$_REQUEST['groupid'];
$start_up=$_REQUEST['start_up'];
$part=$_REQUEST['part'];
$view=$_REQUEST['view'];


$sorder=$_REQUEST['sorder'];
$group_vote=$_REQUEST['group_vote'];
$userid=$_REQUEST['userid'];
$curuserid=$_REQUEST['curuserid'];


if(isset($catID) && (!empty($catID))){$search->category = $catID;}
if(isset($part) && $part!="" ){$search->setmek = $db->escape($part);}
if(isset($sorder)){$search->ords = $db->escape($sorder);}

if(isset($_REQUEST['search'])){$search->searchTerm = sanitize($_REQUEST['search'], 3);}
if(isset($_REQUEST['search'])){$search->filterToStatus = "all";}
if(!isset($_REQUEST['search'])){$search->orderBy = "link_published_date DESC, link_date DESC";}
if(isset($_REQUEST['tag'])){$search->searchTerm = sanitize($_REQUEST['search'], 3); $search->isTag = true;}


// figure out what "page" of the results we're on
//$search->offset = (get_current_page()-1)*$page_size;
$search->offset = $start_up;
// pagesize set in the admin panel
$search->pagesize = $page_size;

if($page_name=="new"){  // For upcomming page
	// since this is new, we only want to view "new" stories
	$search->filterToStatus = "new";
}else{ // For Index page
	// since this is index, we only want to view "published" stories
	$search->filterToStatus = "published";
}
	// this is for the tabs on the top that filter

$search->do_setmek();	

// do the search
$search->doSearch();



if($page_name=='group_story'){
	
	if ($catID)
		$from_where=gen_query_forCatId($catID);

    
	
	if ($view == 'new'){
			$from_where .= " AND link_votes < $group_vote AND link_status='new'";
			$sql = "SELECT SQL_CALC_FOUND_ROWS * FROM " . table_links . " WHERE link_group_id = $groupid AND link_group_status!='discard' $from_where GROUP BY link_id ORDER BY link_published_date DESC, link_date DESC LIMIT $start_up, $page_size";
	
	 $load_page=1;		
	}elseif($view== 'published'){                
			$from_where .= " AND ((link_votes >= $group_vote AND link_status = 'new') OR link_status = 'published')";
	
			$sql = "SELECT SQL_CALC_FOUND_ROWS * FROM " . table_links . " WHERE link_group_id = $groupid AND link_group_status!='discard' $from_where GROUP BY link_id ORDER BY link_published_date DESC, link_date DESC LIMIT $start_up, $page_size";
			
			$load_page=1;
	
	}elseif($view=="shared"){
		$sql="SELECT SQL_CALC_FOUND_ROWS b.* FROM " . table_group_shared . " a
						LEFT JOIN " . table_links . " b ON link_id=share_link_id
						WHERE share_group_id = $groupid AND !ISNULL(link_id) $from_where 
						GROUP BY link_id
						ORDER BY link_published_date DESC, link_date DESC  LIMIT $start_up, $page_size";
						
	 	
		$load_page=1;
	}
	 if ($catID)
	     $sql = str_replace("WHERE", " LEFT JOIN ".table_additional_categories. " ON ac_link_id=link_id WHERE", $sql);
		 
	 $linksum_sql=$sql;					
	
	

} elseif($page_name=='user'){
	
	switch($view){
		
		case 'history':
		$sql="SELECT * FROM " . table_links . " WHERE link_author=$userid AND (link_status='published' OR link_status='new') ORDER BY link_date DESC LIMIT $start_up,$page_size";
		$load_page=1;
		break;
		
		case 'published':
		$sql="SELECT * FROM " . table_links . " WHERE link_author=$userid AND link_status='published'  ORDER BY link_published_date DESC, link_date DESC LIMIT $start_up,$page_size";
		$load_page=1;
		break;
		
		case 'new':
		$sql="SELECT * FROM " . table_links . " WHERE link_author=$userid AND link_status='new' ORDER BY link_date DESC LIMIT $start_up,$page_size";
		$load_page=1;
		break;
		
		case 'commented':
		$sql="SELECT DISTINCT * FROM " . table_links . ", " . table_comments . " WHERE comment_status='published' AND comment_user_id=$userid AND comment_link_id=link_id AND (link_status='published' OR link_status='new')  ORDER BY link_comments DESC LIMIT $start_up, $page_size";
		$load_page=1;
		break;
		
		case 'voted':
		$sql="SELECT DISTINCT * FROM " . table_links . ", " . table_votes . " WHERE vote_user_id=$userid AND vote_link_id=link_id AND vote_value > 0  AND (link_status='published' OR link_status='new') ORDER BY link_date DESC LIMIT $start_up, $page_size";
		$load_page=1;
		break;
		
		case 'upvoted':
		$sql="SELECT DISTINCT * FROM " . table_links . ", " . table_votes . " WHERE vote_user_id=$userid AND vote_link_id=link_id AND vote_value > 0  AND (link_status='published' OR link_status='new') ORDER BY link_votes DESC LIMIT $start_up, $page_size";
		$load_page=1;
		break;
		
		case 'downvoted':
		$sql="SELECT DISTINCT * FROM " . table_links . ", " . table_votes . " WHERE vote_user_id=$userid AND vote_link_id=link_id AND vote_value < 0  AND (link_status='published' OR link_status='new') ORDER BY link_votes ASC LIMIT $start_up, $page_size";
		$load_page=1;
		break;

		case 'saved':
		$load_page=1;
		 $fieldexists = checkforfield('saved_privacy', table_saved_links);
			if($fieldexists)
			{
				if ($curuserid == $userid)
				{	
					$sql = "SELECT " . table_links . ".* FROM " . table_saved_links . " 
									LEFT JOIN " . table_links . " ON saved_link_id=link_id
									WHERE saved_user_id=$userid ORDER BY saved_link_id DESC LIMIT $start_up,$page_size";
				}
				else
				{
					$sql = "SELECT " . table_links . ".* FROM " . table_saved_links . " 
									LEFT JOIN " . table_links . " ON saved_link_id=link_id
									WHERE saved_user_id=$userid and saved_privacy = 'public' ORDER BY saved_link_id DESC LIMIT $start_up,$page_size";	
				}
			}
			else
			{
				$sql = "SELECT " . table_links . ".* FROM " . table_saved_links . " 
								LEFT JOIN " . table_links . " ON saved_link_id=link_id
								WHERE saved_user_id=$userid ORDER BY saved_link_id DESC LIMIT $start_up,$page_size";
			}
			break;
	}

	$linksum_sql = $sql;
	
} else if($page_name=="index" || $page_name == "new" || $page_name == "published"){
	$linksum_sql = $search->sql;
	$load_page = 1;
}

if($load_page==1){
	$fetch_link_summary = true;
	include(mnminclude.'link_summary.php'); // this is the code that show the links / stories
	//$main_smarty->assign('link_pagination', do_pages($rows, $page_size, "published", true));

	echo $link_summary_output;
}

function gen_query_forCatId($catId){
	
	if ($catId) 
	{
		$child_cats = '';
		// do we also search the subcategories? 
		if(! Independent_Subcategories){
			$child_array = '';

			// get a list of all children and put them in $child_array.
			children_id_to_array($child_array, table_categories, $catId);
			if ($child_array != '') {
				// build the sql
				foreach($child_array as $child_cat_id) {
					$child_cat_sql .= ' OR `link_category` = ' . $child_cat_id . ' ';
					if (Multiple_Categories)
						$child_cat_sql .= ' OR ac_cat_id = ' . $child_cat_id . ' ';
				}
			}
		}
		if (Multiple_Categories)
			$child_cat_sql .= " OR ac_cat_id = $catId ";
			
		$from_where = " AND (link_category=$catId " . $child_cat_sql . ")";
        }	
		
	 return $from_where	;	
}
?>