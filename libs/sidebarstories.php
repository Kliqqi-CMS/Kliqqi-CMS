<?php

if(!defined('mnminclude')){header('Location: ../error_404.php');die();}

class SidebarStories {
  var $pagesize = 5; // The number of items to show
  var $orderBy = ""; // The sorting order
  var $filterToStatus = "all"; // Filter to "all" or just "published" or "new"
  var $filterToTimeFrame = ""; // Filter to "all" or just "published" or "new"
  var $header = ""; // The text to show at the top
  var $template = ""; // The template to use, including folder
  var $category = "";
  var $TitleLengthLimit = '';
  
	function show($fetch = false) {
		global $main_smarty, $db, $cached_links, $current_user;
		include_once(mnminclude.'search.php');
		$search=new Search();
		$search->orderBy = $this->orderBy;
		$search->pagesize = $this->pagesize;
		$search->filterToStatus = $this->filterToStatus;
		$search->filterToTimeFrame = $this->filterToTimeFrame;
		if ($this->category)
		{
			$thecat = get_cached_category_data('category_safe_name', $this->category);
			$search->category = $thecat->category_id;
		}
		$search->doSearch();
	
		$linksum_sql = $search->sql;
	
		$link = new Link;
		$links = $db->get_col($linksum_sql);
	
	
		$the_results = $links;
		
		if($the_results){
			// find out if the logged in user voted / reported each of
			// the stories that the search found and cache the results
			require_once(mnminclude.'votes.php');
// DB 03/02/09
//			$vote = new Vote;
//			$vote->type='links';
//			$vote->user=$current_user->user_id;
//			$vote->link=$the_results;
//			$results = $vote->user_list_all_votes();
//////
			$vote = '';
			$results = ''; // we don't actually need the results 
					// we're just calling this to cache the results
					// so when we foreach the links we don't have to 
					// run 1 extra query for each story to determine
					// current user votes
	  
			// setup the link cache
			$i = 0;
			// if this query changes also change it in the read() function in /libs/link.php
			$sql = "SELECT " . table_links . ".* FROM " . table_links . " WHERE "; 
			foreach($the_results as $link_id) {
				// first make sure we don't already have it cached
				if(!isset($cached_links[$link_id])){
					if ($i > 0){$sql .= ' OR ';}
					$sql .= " link_id = $link_id ";
					$i = $i + 1;
				}
			}
	  		
			// if $i = 0 then all the links are already cached
			// so don't touch the db
			// if $i > 0 then there is at least 1 link to get
			// so get the SQL and add results to the cache
			if ($i > 0){
				$results = $db->get_results($sql);
	
				// add the results to the cache  
				foreach ($results as $row){
					$cached_links[$row->link_id] = $row;
				}
			}
			// end link cache setup
		}

		$ssLinks = '';

		if ($links) {
			foreach($links as $link_id) {
				$link->id=$link_id;
				$link->check_saved = false;
				$link->get_author_info = false;
				$link->check_friends = false;
				$link->read();
				
				if(is_numeric($this->TitleLengthLimit) && strlen($link->title) > $this->TitleLengthLimit){
					$link->title = utf8_substr($link->title, 0, $this->TitleLengthLimit) . '...';
				}
				
				$main_smarty = $link->fill_smarty($main_smarty);
				$ssLinks .= $main_smarty->fetch($this->template);
			 }
		}
		if($fetch == true){
			return $ssLinks;
		} else {
			echo $ssLinks;
		}
	}
}
?>
