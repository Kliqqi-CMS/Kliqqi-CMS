<?php

if(!defined('mnminclude')){header('Location: ../error_404.php');die();}

function tags_normalize_string($string) {
	$string = preg_replace('/[\.\,] *$/', "", $string);
	$string = str_replace(array(chr(216).chr(140),'+'),array(',',','),$string);
	return utf8_strtolower($string);
}


function tags_insert_string($link, $lang, $string, $date = 0) {
	global $db;
	if (!is_numeric($link)) die();

	$string = tags_normalize_string($string);
	if ($date == 0) $date=time();
	$words = preg_split('/[,;]+/', $string);
	if ($words) {
		$db->query("delete from " . table_tags . " where tag_link_id = $link");
		foreach ($words as $word) {
			$word=trim($word);
			if (!$inserted[$word] && !empty($word)) {
				$db->query("insert IGNORE into " . table_tags . " (tag_link_id, tag_lang, tag_words, tag_date) values ($link, '$lang', '$word', from_unixtime($date))");
				$inserted[$word] = true;
			}
		}
		$db->query("TRUNCATE TABLE ".table_tag_cache);
		$db->query($sql="INSERT INTO ".table_tag_cache." select tag_words, count(DISTINCT link_id) as count FROM ".table_tags.", ".table_links." WHERE tag_lang='en' and link_id = tag_link_id and (link_status='published' OR link_status='new') GROUP BY tag_words order by count desc");

		return true;
	}
	return false;

}



class TagCloud {
    var $word_limit = NULL; // limit to cloud to this many words
    var $smarty_variable = '';
    var $filterTo = 'all'; // published, new or ALL (does not include discarded)
    var $filterCategory = 0; // a specific category
    var $range_values = NULL; // only used on the tagcloud page where there is a list of time ranges to filter to.
    var $min_points = NULL; // the size of the smallest tag
    var $max_points = NULL; // the size of the largest tag
    
    //CDPDF
    var $search_subcats = true; // search it's subcategories? 
    //CDPDF
    
    function show(){
        // CDPDF old = global $db, $dblang, $URLMethod, $tags_words_limit, $tags_min_pts, $tags_max_pts;
        global $db, $dblang, $URLMethod, $tags_words_limit, $tags_min_pts, $tags_max_pts, $thecat;
        // if we didnt set a word limit, use the default set in the config.php
            if ($this->word_limit == NULL) {$this->word_limit = $tags_words_limit;}

        // if we didnt set the minimum font points, use the default set in the config.php
            if ($this->min_points == NULL) {$this->min_points = $tags_min_pts;}

        // if we didnt set the maximum font points, use the default set in the config.php
            if ($this->max_points == NULL) {$this->max_points = $tags_max_pts;}

        // see if we clicked on a link to filter to a specific time range
        if(($from = check_integer('range')) >= 0 && $from < count($this->range_values) && $this->range_values[$from] > 0 ) {
            $from_time = time() - $this->range_values[$from];
            $from_where = "FROM " . table_tags . ", " . table_links . " WHERE  tag_lang='$dblang' and tag_date > FROM_UNIXTIME($from_time) and link_id = tag_link_id and ";
            $time_query = "&amp;from=$from_time";
            $this->smarty_variable->assign('time_query', $time_query);
        } else {
            $from_where = "FROM " . table_tags . ", " . table_links . " WHERE tag_lang='$dblang' and link_id = tag_link_id and ";
	    $cache_possible=1;
        }

        if ($this->filterTo == 'all') {$from_where .= " (link_status='published' OR link_status='new') "; $cache_possible++;}
        if ($this->filterTo == 'new') {$from_where .= " link_status='new' ";}
        if ($this->filterTo == 'published') {$from_where .= " link_status='published' ";}

        if(is_numeric($this->filterCategory) && $this->filterCategory > 0){
		$catId = $this->filterCategory;
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

		$cache_possible=0;
	}
        
        //CDPDF
        if(isset($_REQUEST['category'])){
            $catId = $db->get_var("SELECT category_id from " . table_categories . " where category_safe_name = '".$db->escape($_REQUEST['category'])."';");
			$category_name = $db->get_var("SELECT category_name from " . table_categories . " where category_safe_name = '".$db->escape($_REQUEST['category'])."';");
			
			$this->smarty_variable->assign('category_name', $category_name);

            //$catId = get_category_id($this->category);
            if(isset($catId)){
                $child_cats = '';
                // do we also search the subcategories? 
		if (! Independent_Subcategories){
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
		$cache_possible=0;
                $from_where .= " AND (link_category=$catId " . $child_cat_sql . ")";

		// Search on additional categories
		if (Multiple_Categories)
		    $from_where = str_replace("WHERE", " LEFT JOIN ".table_additional_categories. " ON ac_link_id=link_id WHERE", $from_where);
            }
        }
        //CDPDF
        
        $from_where .= " GROUP BY tag_words";
        
   /*CDPDF : we calculate the coefficient with the following queries
        $max = max($db->get_var("select count(*) as words $from_where order by words desc limit 1"), 2);
        $coef = ($this->max_points - $this->min_points)/($max-1);
        CDPDF */
        
	if ($cache_possible==2)
	{
            $sql = "select * FROM ".table_tag_cache." limit $this->word_limit";
            $res = $db->get_results($sql);
	}	
	else
	{
            $sql = "select tag_words, count(DISTINCT link_id) as count $from_where order by count desc limit $this->word_limit";
            //echo $sql;
            $res = $db->get_results($sql);
	}
        
        if ($res) {
            foreach ($res as $item) {
                //echo $item->tag_words;
                $words[$item->tag_words] = $item->count;
                $tagcount[] = $item->count;
            }
            //CDPDF modification 
            $max = max($tagcount);
	    // DB 12/10/08
	    if ($max != 1)
            	$coef = ($this->max_points - $this->min_points)/($max-1);
	    else
	    	$coef = 0;
	    /////
            //cdpdf mofiification
            ksort($words);


            $tag_number = array();
            $tag_name = array();
            $tag_count = array();
            $tag_size = array();
            $tag_url = array();
            
            $tagnumber = 0;
            foreach (array_keys($words) as $theword) {
                
                $tag_number[$tagnumber] = $tagnumber;
                $tag_name[$tagnumber] = $theword;
                $tag_count[$tagnumber] = $words[$theword];
                $tag_size[$tagnumber] = $tags_min_pts + ($tag_count[$tagnumber] - 1) * $coef;
                
                if(isset($time_query)){
                    $tag_url[$tagnumber] = getmyurl('tag2', urlencode($tag_name[$tagnumber]), $from_time);
                } else {
                    $tag_url[$tagnumber] = getmyurl('tag', urlencode($tag_name[$tagnumber]));
                }
                
                $tagnumber = $tagnumber + 1;
            }
        }

        // Set the smarty variables
            if(isset($words)){$this->smarty_variable->assign('words', $words);}
            if(isset($tag_number)){$this->smarty_variable->assign('tag_number', $tag_number);}else{$this->smarty_variable->assign('tag_number', 0);}
            if(isset($tag_name)){$this->smarty_variable->assign('tag_name', $tag_name);}
            if(isset($tag_count)){$this->smarty_variable->assign('tag_count', $tag_count);}
            if(isset($tag_size)){$this->smarty_variable->assign('tag_size', $tag_size);}
            if(isset($tag_url)){
                $tag_url = str_replace(" ", "+", $tag_url); // Steef 2k7-07 tag search fix
                $this->smarty_variable->assign('tag_url', $tag_url);
            }

            $this->smarty_variable->assign('tags_words_limit', $this->word_limit);
            $this->smarty_variable->assign('tags_min_pts', $this->min_points);
            $this->smarty_variable->assign('tags_max_pts', $this->max_points);

            $this->smarty_variable->assign('tags_largest_tag', $max);
            $this->smarty_variable->assign('tags_coef', $coef);
    }
}  


?>
