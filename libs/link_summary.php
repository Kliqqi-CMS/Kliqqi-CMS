<?php
if(!defined('mnminclude')){header('Location: ../error_404.php');die();}

	global $main_smarty, $cached_totals, $new_search, $cached_links, $current_user, $cached_saved_links, $fetch_link_summary;
	$link = new Link;
	
	if ($new_search) {
		
		// used on the search page
		$rows = $new_search['count'];
		$new_search = $new_search['rows'];
		$the_results = $new_search;
	} else {
		
		// used in the index and new pages
		$ls_debug = false;
		if($ls_debug == true){echo '--' . sanitize($linksum_count,3) . '--<br />';}
		if($linksum_count == "SELECT count(*) FROM " . table_links . " WHERE  link_status='published'  "){
			if($ls_debug == true){echo 'p';}
			$rows = $cached_totals['published'];
		}	elseif ($linksum_count == "SELECT count(*) FROM " . table_links . " WHERE  link_status='new'  ") {
			if($ls_debug == true){echo 'u';}
			$rows = $cached_totals['new'];
    } else {
    	if($ls_debug == true){echo 'r';}
			$rows = $db->get_var($linksum_count);
		}
		if($ls_debug == true){echo '<br />' . sanitize($rows,3) . '<br />';}
		$links = $db->get_col($linksum_sql);
		$the_results = $links;
	}
	
	
	//For Infinit scrolling and continue reading option 
	if(Auto_scroll==2 || Auto_scroll==3){
		
		$main_smarty->assign('total_row', $rows);			
		if(isset($_GET['part'])){
			$main_smarty->assign('part', $db->escape($_GET['part']));
		}  
		
		if(isset($_GET['order'])){
			$main_smarty->assign('searchOrder', $db->escape($_GET['order']));
		}
	
		if($catID!=0)
			$main_smarty->assign('catID', $catID);
	}
	
	
	if($the_results){
			
		// find out if the logged in user voted / reported each of
		// the stories that the search found and cache the results
		require_once(mnminclude.'votes.php');
// DB 03/02/09
//		$vote = new Vote;
//		$vote->type='links';
//		$vote->user=$current_user->user_id;
//		$vote->link=$the_results;
//		$results = $vote->user_list_all_votes();
/////
		$vote = '';
		$results = ''; // we don't actually need the results 
				// we're just calling this to cache the results
				// so when we foreach the links we don't have to 
				// run 1 extra query for each story to determine
				// current user votes
  
		// setup the link cache
		$sql = "SELECT " . table_links . ".* FROM " . table_links . " WHERE "; 
		$sql_saved = "SELECT * FROM " . table_saved_links . " WHERE saved_user_id=" . $current_user->user_id . " AND ";
		$ids = array();
		foreach($the_results as $link_id) {
			// first make sure we don't already have it cached
			if(!isset($cached_links[$link_id])){
				$ids[] = $link_id;
			}
			if(!isset($cached_saved_links[$link_id])){
				$saved_ids[] = $link_id;
			}
		}
  		
		// if count  = 0 then all the links are already cached		// so don't touch the db
		// if count  > 0 then there is at least 1 link to get
		// so get the SQL and add results to the cache

        
		if ( count ( $ids ) ) {
			$sql .= 'link_id IN ('.implode(',',$ids).')';
			foreach ( $db->get_results($sql) as $row ) {
				$cached_links[$row->link_id] = $row;
				if(!isset($link_authors[$row->link_author])){
					$link_authors[$row->link_author] = $row->link_author;
				}
			}
		}


		// get all authors at once from the users table
		$sql = 'SELECT  *  FROM ' . table_users . ' WHERE ';
		if ( count ( $link_authors ) ) {
			$sql .= 'user_id IN (' . implode(',', $link_authors) . ')';

			foreach ( $db->get_results($sql) as $user ) {
				$cached_users[$user->user_id] = $user;
			}
		}

		// user saved _links
		if ( count ( $saved_ids ) ) {
			$sql_saved .= 'saved_link_id IN ('.implode(',',$ids).')';
			$results = $db->get_results($sql_saved);

			if($results){
				foreach($results as $row){
					$sl[$row->saved_link_id] = 1;
				}
			}
			
			foreach($the_results as $link_id) {
				if(isset($sl[$link_id])){
					$cached_saved_links[$link_id] = 1;
				} else {
					$cached_saved_links[$link_id] = 0;
				}
			}
		}
		// end link cache setup
	}

	global $display_grouplinks;
	if(!isset($link_summary_output)){$link_summary_output = '';}
	if ($new_search) {
		foreach($new_search as $link_id) {
			$link->id=$link_id;
			$link->read();
			if( $display_grouplinks ) $link->link_group_id = 0;
			$link_summary_output .= $link->print_summary('summary', true);
		}
	} else {
		if ($links) {
			foreach($links as $link_id) {
				$link->id=$link_id;
				$link->read();
				$link_summary_output .= $link->print_summary('summary', true);
			}
		}
	}
	if(isset($fetch_link_summary) && $fetch_link_summary == true){
		$main_smarty->assign('link_summary_output', $link_summary_output);
	} else {	
		echo $link_summary_output;
	}
?>
