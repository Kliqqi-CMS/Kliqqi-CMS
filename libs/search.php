<?php
class Search {

	var $newerthan = NULL;
	var $searchTerm = '';
	var $filterToStatus = 'all';
	var $filterToTimeFrame = '';
	var $isTag = false;
	var $searchTable = '';
	var $orderBy = NULL;
	var $offset = 0;
	var $pagesize = '';
	var $sql = '';
	var $countsql = '';
	var $category = ''; // search a specific category?
//	var $search_subcats = true; // search it's subcategories? 
	var $search_extra_fields = true; // search the extra_fields (if enabled)
	var $url = '';
	
	//extra params for advance search
	var $adv = false;
	var $s_story = 0;
	var $status = '';
	var $s_tags = 0;
	var $s_user = 0;
	var $s_group = 0;
	var $s_cat = 0;	
	var $s_comments = 0;	
	var $s_date = 0;
	
  
	function doSearch($limit) {
		
		global $db, $current_user, $main_smarty;
		$search_clause = $this->get_search_clause();

		// set smarty variables
		if(isset($this->searchTerm)){
			$main_smarty->assign('search', $this->searchTerm);
			$main_smarty->assign('searchtext', htmlspecialchars($this->searchTerm));
		} else {
			$main_smarty->assign('searchtext', '');
		}
	
		$from_where = "FROM " . $this->searchTable . " WHERE ";

		if ($this->filterToStatus == 'all') {$from_where .= " link_status IN ('published','new') ";}
		if ($this->filterToStatus == 'new') {$from_where .= " link_status='new' ";}
		if ($this->filterToStatus == 'discard') {$from_where .= " link_status='discard' ";}		
		if ($this->filterToStatus == 'published') {$from_where .= " link_status='published' ";}		
		if ($this->filterToStatus == 'popular') {$from_where .= " link_status='published' ";}

		if ($this->url != '') {
			if($this->filterToStatus != ''){$from_where .= ' AND ';}
			$from_where .= " link_url LIKE '%$this->url%' ";
		}

		// Sort filters for published and new pages
		if ($this->filterToStatus == 'published') {
		
			
			if ($this->filterToTimeFrame == 'today') 
				$from_where .= " AND link_published_date > DATE_SUB(NOW(),INTERVAL 1 DAY) "; 
			elseif ($this->filterToTimeFrame == 'yesterday') 
				$from_where .= " AND link_published_date BETWEEN DATE_SUB(NOW(),INTERVAL 2 DAY) AND DATE_SUB(NOW(),INTERVAL 1 DAY) "; 
			elseif ($this->filterToTimeFrame == 'week') 
				$from_where .= " AND link_published_date > DATE_SUB(NOW(),INTERVAL 7 DAY) "; 
			elseif ($this->filterToTimeFrame == 'month') 
				$from_where .= " AND link_published_date > DATE_SUB(NOW(),INTERVAL 1 MONTH) "; 
			elseif ($this->filterToTimeFrame == 'year') 
				$from_where .= " AND link_published_date > DATE_SUB(NOW(),INTERVAL 1 YEAR) "; 
			else if($this->filterToTimeFrame == 'upvoted'){
				
				$this->searchTerm = "upvoted";
			}
			else if($this->filterToTimeFrame == 'downvoted'){

				$this->searchTerm = "downvoted";
			}
			else if($this->filterToTimeFrame == 'commented'){
				
				$this->searchTerm = "commented";
			}	
				
		} else {
			
			if ($this->filterToTimeFrame == 'today') 
				$from_where .= " AND link_date > DATE_SUB(NOW(),INTERVAL 1 DAY) "; 
			elseif ($this->filterToTimeFrame == 'yesterday') 
				$from_where .= " AND link_date BETWEEN DATE_SUB(NOW(),INTERVAL 2 DAY) AND DATE_SUB(NOW(),INTERVAL 1 DAY) "; 
			elseif ($this->filterToTimeFrame == 'week') 
				$from_where .= " AND link_date > DATE_SUB(NOW(),INTERVAL 7 DAY) "; 
			elseif ($this->filterToTimeFrame == 'month') 
				$from_where .= " AND link_date > DATE_SUB(NOW(),INTERVAL 1 MONTH) "; 
			elseif ($this->filterToTimeFrame == 'year') 
				$from_where .= " AND link_date > DATE_SUB(NOW(),INTERVAL 1 YEAR) "; 
			else if($this->filterToTimeFrame == 'upvoted'){
				
				$this->searchTerm = "upvoted";
			}
			else if($this->filterToTimeFrame == 'downvoted'){

				$this->searchTerm = "downvoted";
			}
			else if($this->filterToTimeFrame == 'commented'){
				
				$this->searchTerm = "commented";
			}
		}
		
		/////sorojit: for user selected category display
		if($_COOKIE['mnm_user'])
		{
			$user_login = $db->escape(sanitize($_COOKIE['mnm_user'],3));
			$sqlGeticategory = $db->get_var("SELECT user_categories from " . table_users . " where user_login = '$user_login';");
			if ($sqlGeticategory)
			{
				$from_where .= " AND link_category NOT IN ($sqlGeticategory)"; 
				if (Multiple_Categories)
					$from_where .= " AND ac_cat_id NOT IN ($sqlGeticategory)"; 
			}
		}
		//should we filter to just this category?
		if(isset($this->category))
		{
			//$catId = $db->get_var("SELECT category_id from " . table_categories . " where category_name = '" . $this->category . "';");
//			$catId = get_category_id($this->category);
			$catId = $this->category;
			if($catId){
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
				$from_where .= " AND (link_category=$catId " . $child_cat_sql . ")";
			}
		}
		
		if(isset($this->orderBy)){
			if(strpos($this->orderBy, "ORDER BY") != 1){
				$this->orderBy = " ORDER BY " . $this->orderBy;
			}
		}

		// always check groups (to hide private groups)
		$from_where = str_replace("WHERE"," LEFT JOIN ".table_groups." ON ".table_links.".link_group_id = ".table_groups.".group_id WHERE",$from_where);
		if (Voting_Method == 2)
		    $from_where = str_replace("WHERE"," LEFT JOIN ".table_votes. " ON vote_type='links' AND vote_link_id=link_id AND vote_value>0 WHERE",$from_where);

		// Search on additional categories
		if (Multiple_Categories)
		    $from_where = str_replace("WHERE", " LEFT JOIN ".table_additional_categories. " ON ac_link_id=link_id WHERE", $from_where);

		$groups = $db->get_results("SELECT * FROM " . table_group_member . " WHERE member_user_id = {$current_user->user_id} and member_status = 'active'");
		if ($groups)
		{
		    $group_ids = array();
		    foreach($groups as $group)
			$group_ids[] = $group->member_group_id;
		    $group_list = join(",",$group_ids);
		    $from_where .= " AND (".table_groups.".group_privacy!='private' OR ISNULL(".table_groups.".group_privacy) OR ".table_groups.".group_id IN($group_list)) ";
		}
		else
		{
		    $group_list = '';
		    $from_where .= " AND (".table_groups.".group_privacy!='private' OR ISNULL(".table_groups.".group_privacy))";
		}
		
		if(intval($limit) <= 0)
			$limit = $this->pagesize;
		
		if($this->searchTerm == "" && $this->url == ""){
			// like when on the index or new pages.
			$this->sql = "SELECT link_id, link_votes, link_karma, link_comments $from_where $search_clause GROUP BY link_id $this->orderBy LIMIT $this->offset, $limit";
		} else if($this->searchTerm == 'upvoted'){
			$usrclause = "";
			$group = "GROUP BY link_id";
			if($catId) {
				$this->sql = "SELECT DISTINCT * FROM " . table_links . ", " . table_votes . " WHERE ".$usrclause." vote_link_id=link_id AND vote_value > 0  AND (link_status='published' OR link_status='new') AND link_category=$catId ".$group." ORDER BY link_votes DESC LIMIT $this->offset, $limit"; //link_date
			}else{
				$this->sql = "SELECT DISTINCT * FROM " . table_links . ", " . table_votes . " WHERE ".$usrclause." vote_link_id=link_id AND vote_value > 0  AND (link_status='published' OR link_status='new') ".$group." ORDER BY link_votes DESC LIMIT $this->offset, $limit"; //link_date
			}
		} else if($this->searchTerm == 'downvoted'){
			$usrclause = "";
			$group = "GROUP BY link_id";
			if($catId) {
				$this->sql = "SELECT DISTINCT * FROM " . table_links . ", " . table_votes . " WHERE ".$usrclause." vote_link_id=link_id AND vote_value < 0  AND (link_status='published' OR link_status='new') AND link_category=$catId ".$group." ORDER BY link_votes ASC LIMIT $this->offset, $limit"; //link_date
			}else{
				$this->sql = "SELECT DISTINCT * FROM " . table_links . ", " . table_votes . " WHERE ".$usrclause." vote_link_id=link_id AND vote_value < 0  AND (link_status='published' OR link_status='new') ".$group." ORDER BY link_votes ASC LIMIT $this->offset, $limit"; //link_date    
			}
		} else if($this->searchTerm == "commented"){
			$usrclause = "";
			$group = "GROUP BY link_id";
			if($catId) {
				$this->sql = "SELECT DISTINCT * FROM " . table_links . ", " . table_comments . " WHERE comment_status='published' ".$usrclause." AND comment_link_id=link_id AND (link_status='published' OR link_status='new') AND link_category=$catId ".$group." ORDER BY link_comments DESC LIMIT $this->offset, $limit";
			}else{
				$this->sql = "SELECT DISTINCT * FROM " . table_links . ", " . table_comments . " WHERE comment_status='published' ".$usrclause." AND comment_link_id=link_id AND (link_status='published' OR link_status='new') ".$group." ORDER BY link_comments DESC LIMIT $this->offset, $limit";
			}
		}
		else{
			$this->sql = "SELECT link_id, link_date, link_published_date, link_votes, link_karma, link_comments $from_where $search_clause {$this->orderBy}";
		}
		
		###### START Advanced Search ######
		if($this->adv){
			$from_where = table_links;
			$search_clause = 'WHERE ';
			$search_params = array();
			$search_AND_params = array();
			$query = "SELECT ".table_links.".link_id AS link_id, ".table_links.".link_date AS link_date, ".table_links.".link_published_date AS link_published_date FROM ";

			// always check groups (to hide private groups)
			$from_where .= " LEFT JOIN ".table_groups." ON ".table_links.".link_group_id = ".table_groups.".group_id ";
			if($group_list)
			    $search_AND_params[] = " (".table_groups.".group_privacy!='private' OR ISNULL(".table_groups.".group_privacy) OR ".table_groups.".group_id IN($group_list)) ";
			else
			    $search_AND_params[] = " (".table_groups.".group_privacy!='private' OR ISNULL(".table_groups.".group_privacy))";
			
			//check if it is a literal search
			$buffKeyword = $this->searchTerm;
			$keywords = array();			
			if( substr( $this->searchTerm, 1, 1 ) == '"'  && substr( $this->searchTerm, strlen( $this->searchTerm )-1 , 1 ) == '"' ) {
				$literal = true;
				$addparam = ' COLLATE utf8_general_ci ';
				$this->searchTerm = str_replace( '\"','',$this->searchTerm );
				$keywords[] = $this->searchTerm;
			}
			else{
				$keywords = explode( ' ', $this->searchTerm );
			}
			$bufferOrig = $this->searchTerm;
				
			//search category
			if( $this->s_cat != 0 ){
				if (Multiple_Categories)
					$mult_sql = " OR ac_cat_id = '".$db->escape($this->s_cat)."'";
				$search_AND_params[] = "( ".table_links.".link_category = '".$db->escape($this->s_cat)."' $mult_sql)";
			}
						
			//search tags
			if( $this->s_tags != 0 && $this->searchTerm){
				foreach( $keywords as $key ){
					$this->searchTerm = $key;			
					$search_params[] = " ".table_links.".link_tags $addparam LIKE '%".$this->searchTerm."%' ";
				}
				$this->searchTerm = $bufferOrig;					
			}
			
			//search links
			if( $this->s_story != 0 && $this->searchTerm){
				foreach( $keywords as $key ){
					$this->searchTerm = $key;
					if( $this->s_story == 1 )
						$search_params[] = " ".table_links.".link_title $addparam LIKE '%".$this->searchTerm."%' ";
					if( $this->s_story == 2 )
						$search_params[] = " ".table_links.".link_content $addparam LIKE '%".$this->searchTerm."%' ";
					if( $this->s_story == 3 ){
						$search_params[] = " ".table_links.".link_title $addparam LIKE '%".$this->searchTerm."%' ";
						$search_params[] = " ".table_links.".link_content $addparam LIKE '%".$this->searchTerm."%' ";					
					}
				}
				$this->searchTerm = $bufferOrig;
			}
			
			//search author
			if( $this->s_user != 0 && $this->searchTerm){
					$from_where .= " INNER JOIN ".table_users." ON ".table_links.".link_author = ".table_users.".user_id ";			
					foreach( $keywords as $key ){
						$this->searchTerm = $key;
						$search_params[] = " ".table_users.".user_login $addparam LIKE '%".$this->searchTerm."%' ";
					}
					$this->searchTerm = $bufferOrig;						
			}
			
			//search group
			if( $this->s_group != 0 && $this->searchTerm){
				foreach( $keywords as $key ){
					$this->searchTerm = $key;				
					if( $this->s_group == 1 )
						$search_params[] = " ".table_groups.".group_name $addparam LIKE '%".$this->searchTerm."%' ";
					if( $this->s_group == 2 )
						$search_params[] = " ".table_groups.".group_description $addparam LIKE '%".$this->searchTerm."%' ";
					if( $this->s_group == 3 ){
						$search_params[] = " ".table_groups.".group_name $addparam LIKE '%".$this->searchTerm."%' ";
						$search_params[] = " ".table_groups.".group_description $addparam LIKE '%".$this->searchTerm."%' ";					
					}
				}
				$this->searchTerm = $bufferOrig;					
			}
			
			//search comments
			if( $this->s_comments != 0 && $this->searchTerm){
				$from_where .= " LEFT JOIN ".table_comments." ON ".table_links.".link_id = ".table_comments.".comment_link_id ";			
				foreach( $keywords as $key ){
					$this->searchTerm = $key;					
					$search_params[] = " (".table_comments.".comment_content $addparam LIKE '%".$this->searchTerm."%' AND comment_status='published')";
				}
				$this->searchTerm = $bufferOrig;					
			}	

			//search by date
			if( $this->s_date ){
				$this->s_date = date('Y-m-d',strtotime($this->s_date));
#				$from_where .= " WHERE DATE(link_date)='{$this->s_date}' ";
				$search_AND_params[] = " DATE(".table_links.".link_date)='{$this->s_date}' ";
#				$this->searchTerm = $bufferOrig;				
			}		

			if(Voting_Method == 2)
	 			$from_where .= " LEFT JOIN " . table_votes . " ON vote_type='links' AND vote_link_id=link_id AND vote_value>0";
				
			// Search on additional categories
			if (Multiple_Categories)
			    	$from_where .= " LEFT JOIN ".table_additional_categories. " ON ac_link_id=link_id";

			if( $this->status != '' && $this->status != 'all' ){
				$search_params[] = " ".table_links.".link_status = '{$this->status}' ";
			}
			
			if (sizeof($search_params))
			    $search_clause = '('.implode( ' OR ', $search_params ).' ) ';
			else
			    $search_clause = '1';
			if (sizeof($search_AND_params)>0)
				$search_clause .= ' AND ('.implode( ' AND ', $search_AND_params ).' ) ';
			$this->sql = $query.' '.$from_where.' WHERE '.$search_clause." AND ".table_links.".link_status IN ('published','new')";
			$this->searchTerm = $buffKeyword;
		}

		#echo $this->sql."<br><br>";
		###### END Advanced Search ######
		
		
		//  if this query changes be sure to make sure to update link_summary
		//  just look for $linksum_count near the top
		$this->countsql = "SELECT count(DISTINCT link_id) $from_where $search_clause ";

		return;
	}

	function new_search(){
		// do various searches and put the results in the $foundlinks array
		// if isTag == true then Just search JUST tags
		// if !== true, then search normal (title, desc,etc) AND tags
		
		
		global $db;

		if(!isset($this->searchTerm)){return false;}

		$foundlinks = array();
		$original_isTag = $this->isTag;

		// search comments
		if (Search_Comments) {
			$where = $this->explode_search('comment_content', $this->searchTerm);
			$this->sql = "SELECT link_id, link_votes, link_karma, link_comments 
						FROM ".table_comments." 
						LEFT JOIN ".table_links." ON link_id=comment_link_id 
						WHERE $where AND comment_status='published' AND link_status IN ('published','new')";
			$links = $db->get_results($this->sql);
			if ($links) {
				foreach($links as $link_id) {
					if(array_search($link_id->link_id, $foundlinks) === false){
						// if it's not already in our list, add it
						$foundlinks[] = $link_id->link_id;

						$newfoundlinks[$link_id->link_id] = (array)$link_id;
					}
				}
			}
		}
		
		// search tags
		$this->isTag = true;
		$this->doSearch();
		$links = $db->get_results($this->sql);
		if ($links) {
			foreach($links as $link_id) {
				if(array_search($link_id->link_id, $foundlinks) === false){
					// if it's not already in our list, add it
					$foundlinks[] = $link_id->link_id;

					$newfoundlinks[$link_id->link_id] = (array)$link_id;
				}
			}
		}

		if($original_isTag !== true){
			// search links
			$this->isTag = false;
			$this->doSearch();
			$links = $db->get_results($this->sql);
			if ($links) {
				foreach($links as $link_id) {
					if(array_search($link_id->link_id, $foundlinks) === false){
						// if it's not already in our list, add it
						$foundlinks[] = $link_id->link_id;

						$newfoundlinks[$link_id->link_id] = (array)$link_id;
					}
				}
			}
		}
		
		if($newfoundlinks){
			if (Voting_Method == 3)
				$rating_column = 'link_karma';
			else
				$rating_column = 'link_votes';

			$ords = $this->ords;
			$order_clauses = array ( 'newest' => 'link_date DESC',
						  'oldest' => 'link_date ASC',
						  'commented' => 'link_comments DESC',
						  'upvoted' => $rating_column . ' DESC',
						  'downvoted' => $rating_column . ' ASC'
							);
			
			if ( array_key_exists ($ords, $order_clauses) )
				$orderBy = $order_clauses[$ords];
			else
				$orderBy = $order_clauses['newest'];
			$orderBy1 = str_replace(array(' DESC',' ASC'), '', $orderBy);
			foreach($newfoundlinks as $thelink){
				$sortarray[$thelink['link_id']] = $thelink[$orderBy1];
			}
			if (strstr($orderBy, 'DESC'))
			    arsort($sortarray);
			else
			    asort($sortarray);

			$x = 0;
			$aa = $this->offset;
			$ab = $aa + $this->pagesize;
			
			foreach($sortarray as $theitemaa=>$theitemab) {
				if($x >= $aa && $x < $ab){
					$results[] = $theitemaa;
				}
				$x++;
			}			
		}
		
		$returnme['rows'] = $results;
		$returnme['count'] = count($sortarray);
		
		return $returnme;
	}

	function get_search_clause($option='') {
	
		global $db;
		if(!empty($this->searchTerm)) {
			// make sure there is a search term
			$words = $this->searchTerm;
			$SearchMethod = SearchMethod; // create a temp variable so we can change the value without possibly affecting anything else

			if($this->isTag == true){
				// search the tags table
				$this->searchTable = table_tags . " INNER JOIN " . table_links . " ON " . table_tags . ".tag_link_id = " . table_links . ".link_id";
				
				// thanks to jalso for this code
					$x = explode(",",$words);
					$sq = "(";
					foreach($x as $k=>$v){
					 $sq .= "tag_words = '".trim($x[$k])."'";
					 if($k != (count($x) - 1))$sq .= " OR ";
					}
					$sq .= ")";
					if(Voting_Method == 2)
						$where = " AND ".$sq." GROUP BY " . table_links . ".link_id, `link_votes` ORDER BY avg(vote_value) DESC ";
					else
						$where = " AND ".$sq." GROUP BY " . table_links . ".link_id, `link_votes` ORDER BY `link_votes` DESC";
				// ---
				
			} else {
				// search the links table
				$this->searchTable = table_links;
				$words = str_replace(array('-','+','/','\\','?','=','$','%','^','&','*','(',')','!','@','|'),'',$words);
				if($SearchMethod == 3){
					$SearchMethod = $this->determine_search_method($words);
				}
				if($SearchMethod == 1){
					// use SQL "against" for searching
					// doesn't work with "stopwords" or less than 4 characters

					$matchfields = '';
					if($this->search_extra_fields == true){
						if(Enable_Extra_Fields){
							if(Enable_Extra_Field_1 == true && Field_1_Searchable == true){$matchfields .= ', `link_field1`';}
							if(Enable_Extra_Field_2 == true && Field_2_Searchable == true){$matchfields .= ', `link_field2`';}
							if(Enable_Extra_Field_3 == true && Field_3_Searchable == true){$matchfields .= ', `link_field3`';}
							if(Enable_Extra_Field_4 == true && Field_4_Searchable == true){$matchfields .= ', `link_field4`';}
							if(Enable_Extra_Field_5 == true && Field_5_Searchable == true){$matchfields .= ', `link_field5`';}
							if(Enable_Extra_Field_6 == true && Field_6_Searchable == true){$matchfields .= ', `link_field6`';}
							if(Enable_Extra_Field_7 == true && Field_7_Searchable == true){$matchfields .= ', `link_field7`';}
							if(Enable_Extra_Field_8 == true && Field_8_Searchable == true){$matchfields .= ', `link_field8`';}
							if(Enable_Extra_Field_9 == true && Field_9_Searchable == true){$matchfields .= ', `link_field9`';}
							if(Enable_Extra_Field_10 == true && Field_10_Searchable == true){$matchfields .= ', `link_field10`';}
							if(Enable_Extra_Field_11 == true && Field_11_Searchable == true){$matchfields .= ', `link_field11`';}
							if(Enable_Extra_Field_12 == true && Field_12_Searchable == true){$matchfields .= ', `link_field12`';}
							if(Enable_Extra_Field_13 == true && Field_13_Searchable == true){$matchfields .= ', `link_field13`';}
							if(Enable_Extra_Field_14 == true && Field_14_Searchable == true){$matchfields .= ', `link_field14`';}
							if(Enable_Extra_Field_15 == true && Field_15_Searchable == true){$matchfields .= ', `link_field15`';}
						}
					}

					//$where = " AND MATCH (link_url, link_url_title, link_title, link_content, link_tags $matchfields) AGAINST ('$words') ";
					$words = $db->escape(str_replace('+','',stripslashes($words)));
					if (preg_match_all('/("[^"]+"|[^\s]+)/',$words,$m))
						$words = '+'.join(" +",$m[1]);
					$where = " AND MATCH (link_title, link_content, link_tags $matchfields) AGAINST ('$words' IN BOOLEAN MODE) ";

				}
				if($SearchMethod == 2){
					// use % for searching

					if($this->search_extra_fields == true){
						if(Enable_Extra_Fields){
							if(Enable_Extra_Field_1 == true && Field_1_Searchable == true){$matchfields .= " or `link_field1` like '%$words%' ";}
							if(Enable_Extra_Field_2 == true && Field_2_Searchable == true){$matchfields .= " or `link_field2` like '%$words%' ";}
							if(Enable_Extra_Field_3 == true && Field_3_Searchable == true){$matchfields .= " or `link_field3` like '%$words%' ";}
							if(Enable_Extra_Field_4 == true && Field_4_Searchable == true){$matchfields .= " or `link_field4` like '%$words%' ";}
							if(Enable_Extra_Field_5 == true && Field_5_Searchable == true){$matchfields .= " or `link_field5` like '%$words%' ";}
							if(Enable_Extra_Field_6 == true && Field_6_Searchable == true){$matchfields .= " or `link_field6` like '%$words%' ";}
							if(Enable_Extra_Field_7 == true && Field_7_Searchable == true){$matchfields .= " or `link_field7` like '%$words%' ";}
							if(Enable_Extra_Field_8 == true && Field_8_Searchable == true){$matchfields .= " or `link_field8` like '%$words%' ";}
							if(Enable_Extra_Field_9 == true && Field_9_Searchable == true){$matchfields .= " or `link_field9` like '%$words%' ";}
							if(Enable_Extra_Field_10 == true && Field_10_Searchable == true){$matchfields .= " or `link_field10` like '%$words%' ";}
							if(Enable_Extra_Field_11 == true && Field_11_Searchable == true){$matchfields .= " or `link_field11` like '%$words%' ";}
							if(Enable_Extra_Field_12 == true && Field_12_Searchable == true){$matchfields .= " or `link_field12` like '%$words%' ";}
							if(Enable_Extra_Field_13 == true && Field_13_Searchable == true){$matchfields .= " or `link_field13` like '%$words%' ";}
							if(Enable_Extra_Field_14 == true && Field_14_Searchable == true){$matchfields .= " or `link_field14` like '%$words%' ";}
							if(Enable_Extra_Field_15 == true && Field_15_Searchable == true){$matchfields .= " or `link_field15` like '%$words%' ";}
						}
					}
					
					$where = " AND ((";
					$where .= $this->explode_search('link_url', $words) . ")  OR (";
					$where .= $this->explode_search('link_url_title', $words) . " ) OR (";
					$where .= $this->explode_search('link_title', $words) . " ) OR (";
					$where .= $this->explode_search('link_content', $words) . " ) OR (";
					$where .= $this->explode_search('link_tags', $words);
					$where .= ") $matchfields) ";
					
				}
			}
			return $where;
		} else {
			$this->searchTable = table_links;
			return false;
		}
	}

	function explode_search($search_field, $words){
		global $db;
		$sq = '';
		preg_match_all('/"([^"]+)"|([^\s]+)/',$words,$m);
	        foreach ($m[1] as $v) 
		    if (trim($v)) 
			$sq .= $search_field . " LIKE '%".$db->escape(trim($v))."%' AND ";
	        foreach ($m[2] as $v) 
		    if (trim($v)) 
			$sq .= $search_field . " LIKE '%".$db->escape(trim($v))."%' AND ";
//		foreach(explode(' ',$words) as $v){

		return substr ( $sq, 0, -4 );
	}

	function determine_search_method(&$words){
		// find out which of the methods is best and then use it.

		$pieces = explode(" ", str_replace('"','',$words));
		$SearchMethod = 1; // assume that it'll be ok to use method 1

		foreach($pieces as $piece){
			if (strlen($piece) < 4) {$SearchMethod = 2;} // if the length of the searchterm is less that 4 characters.
			if ($this->is_it_stopword($piece)) {$SearchMethod = 2;} // if its a stopword
			if (strpos($piece, "*") > 0){
				$SearchMethod = 2; 
				$words = str_replace("*", "", $words); // strip the * out so we can do a like on the actual search term
			}
		}


		return $SearchMethod;
		//return 2;
	}

	function is_it_stopword($word) {
		static $word_array;

		if ( ! $word_array ) {
		 	// list came from here
		 	// http://meta.wikimedia.org/wiki/MySQL_4.0.20_stop_word_list
			$stopwordlist = "a's able about above according accordingly across actually after afterwards again against ain't all allow allows almost alone along already also although always am among amongst an and another any anybody anyhow anyone anything anyway anyways anywhere apart appear appreciate appropriate are aren't around as aside ask asking associated at available away awfully be became because become becomes becoming been before beforehand behind being believe below beside besides best better between beyond both brief but by c'mon c's came can can't cannot cant cause causes certain certainly changes clearly co com come comes concerning consequently consider considering contain containing contains corresponding could couldn't course currently definitely described despite did didn't different do does doesn't doing don't done down downwards during each edu eg eight either else elsewhere enough entirely especially et etc even ever every everybody everyone everything everywhere ex exactly example except far few fifth first five followed following follows for former formerly forth four from further furthermore get gets getting given gives go goes going gone got gotten greetings had hadn't happens hardly has hasn't have haven't having he he's hello help hence her here here's hereafter hereby herein hereupon hers herself hi him himself his hither hopefully how howbeit however i'd i'll i'm i've ie if ignored immediate in inasmuch inc indeed indicate indicated indicates inner insofar instead into inward is isn't it it'd it'll it's its itself just keep keeps kept know knows known last lately later latter latterly least less lest let let's like liked likely little look looking looks ltd mainly many may maybe me mean meanwhile merely might more moreover most mostly much must my myself name namely nd near nearly necessary need needs neither never nevertheless new next nine no nobody non none noone nor normally not nothing novel now nowhere obviously of off often oh ok okay old on once one ones only onto or other others otherwise ought our ours ourselves out outside over overall own particular particularly per perhaps placed please plus possible presumably probably provides que quite qv rather rd re really reasonably regarding regardless regards relatively respectively right said same saw say saying says second secondly see seeing seem seemed seeming seems seen self selves sensible sent serious seriously seven several shall she should shouldn't since six so some somebody somehow someone something sometime sometimes somewhat somewhere soon sorry specified specify specifying still sub such sup sure t's take taken tell tends th than thank thanks thanx that that's thats the their theirs them themselves then thence there there's thereafter thereby therefore therein theres thereupon these they they'd they'll they're they've think third this thorough thoroughly those though three through throughout thru thus to together too took toward towards tried tries truly try trying twice two un under unfortunately unless unlikely until unto up upon us use used useful uses using usually value various very via viz vs want wants was wasn't way we we'd we'll we're we've welcome well went were weren't what what's whatever when whence whenever where where's whereafter whereas whereby wherein whereupon wherever whether which while whither who who's whoever whole whom whose why will willing wish with within without won't wonder would would wouldn't yes yet you you'd you'll you're you've your yours yourself yourselves zero";
			$word_array = explode(' ', $stopwordlist);
		}

	 	if(array_search($word, $word_array) == true){
	 		return true;
	 	} else {
	 		return false;
	 	}
	}

	function do_setmek() {
		if(isset($this->setmek)){$setmek = $this->setmek;}else{$setmek = '';}
		
		if (Voting_Method == 2)
			$rating_column = 'avg(vote_value)';
		elseif (Voting_Method == 3)
			$rating_column = 'link_karma';
		else
			$rating_column = 'link_votes';

		$order_clauses = array ( 'newest' => 'link_date DESC',
						  'oldest' => 'link_date ASC',
						  'mostpopular' => $rating_column . ' DESC',
						  'leastpopular' => $rating_column . ' ASC'
						);
		
		if ($this->filterToStatus == "new") {
			$ords = $this->ords;
			if ( array_key_exists ($ords, $order_clauses) )
				$this->orderBy = $order_clauses[$ords];
			else
				$this->orderBy = $order_clauses['newest'];
		}
		
		$timeFrames = array ('today', 'yesterday', 'week', 'month', 'year', 'alltime','upvoted', 'downvoted', 'commented');
		if ( in_array ($setmek, $timeFrames) ) {
			if ($setmek == 'alltime')
				$this->filterToTimeFrame = '';
			else
				$this->filterToTimeFrame = $setmek;
				
			$this->orderBy = $order_clauses['mostpopular'];
		}
	}
}
?>