{config_load file=rss_import_lang_conf}
<legend><img src="{$my_pligg_base}/modules/rss_import/images/manage_rss.gif" align="absmiddle"/> {#PLIGG_RSS_Import#}</legend>

{php}

// MJE: mod to add $dblang global, used by tag inserter function call

	global $db, $dblang;

function do_the_import_stuff($feed) { 
	global $db, $dblang, $RSSImport;

	$RSSImport=new RSSImport;
	$added_one = false;

	$url = $feed->feed_url;
	$rss = fetch_rss($url);
	if($_GET['override'] == $feed->feed_id){
		$canIhaveAccess = 0;
		$canIhaveAccess = $canIhaveAccess + checklevel('admin');
		
		if(!$canIhaveAccess == 1){
			die('You are not authorized to override.');
		}
	}
	$MyArray = array();
	$Feed_Links = $RSSImport->get_feed_field_links($feed->feed_id);
	if(count($Feed_Links) > 0){
		foreach ($Feed_Links as $link ) {
			if($link->pligg_field == 'link_title'){$MyArray['title'] = $link->feed_field;}
			if($link->pligg_field == 'link_content'){$MyArray['content'] = $link->feed_field;}
			if($link->pligg_field == 'link_url'){$MyArray['link_url'] = $link->feed_field;}
			if($link->pligg_field == 'link_tags'){$MyArray['link_tags'] = $link->feed_field;}
			if($link->pligg_field == 'link_field1'){$MyArray['link_field1'] = $link->feed_field;}
			if($link->pligg_field == 'link_field2'){$MyArray['link_field2'] = $link->feed_field;}
			if($link->pligg_field == 'link_field3'){$MyArray['link_field3'] = $link->feed_field;}
			if($link->pligg_field == 'link_field4'){$MyArray['link_field4'] = $link->feed_field;}
			if($link->pligg_field == 'link_field5'){$MyArray['link_field5'] = $link->feed_field;}
			if($link->pligg_field == 'link_field6'){$MyArray['link_field6'] = $link->feed_field;}
			if($link->pligg_field == 'link_field7'){$MyArray['link_field7'] = $link->feed_field;}
			if($link->pligg_field == 'link_field8'){$MyArray['link_field8'] = $link->feed_field;}
			if($link->pligg_field == 'link_field9'){$MyArray['link_field9'] = $link->feed_field;}
			if($link->pligg_field == 'link_field10'){$MyArray['link_field10'] = $link->feed_field;}
			if($link->pligg_field == 'link_field11'){$MyArray['link_field11'] = $link->feed_field;}
			if($link->pligg_field == 'link_field12'){$MyArray['link_field12'] = $link->feed_field;}
			if($link->pligg_field == 'link_field13'){$MyArray['link_field13'] = $link->feed_field;}
			if($link->pligg_field == 'link_field14'){$MyArray['link_field14'] = $link->feed_field;}
			if($link->pligg_field == 'link_field15'){$MyArray['link_field15'] = $link->feed_field;}
		}
	
	
		$thecount = 0;

		if($feed->feed_last_item_first == 0){
			$the_items = array_reverse($rss->items);
		} else {
			$the_items = $rss->items;
		}

		foreach ($the_items as $item) {
			echo "<strong>Title:</strong> " . get_val($item, $MyArray['title']) . "<br/>";
			echo "<strong>Content:</strong> " . strip_tags(substr(get_val($item, $MyArray['content']),0,256)) . "...<br>";
			echo "<strong>URL:</strong> " . get_val($item, $MyArray['link_url'])."<br/>";
			
			$skipthis = 0;
			$linkres=new Link;
			$linkres->randkey = rand(10000,10000000);
			$linkres->status=$feed->feed_status;
			$linkres->author=$feed->feed_submitter;
			$linkres->title=get_val($item, $MyArray['title']);
			$linkres->title = strip_tags($linkres->title);
			$linkres->tags = get_val($item, $MyArray['link_tags']);

// MJE: MOD to include title words as tags ----------------------------
			if (trim($linkres->tags) == '') { 
				$temp1 = utf8_strtolower($linkres->title);
				if (!is_array($stopwords))
				{
					$stopwords = file(mnmpath.'/modules/rss_import/templates/stopwords.txt');
					array_walk($stopwords, 'rss_trim_value');
				}

				$temp1 = str_replace(' ', ", ", $temp1);
				// strip all except letters and spaces and commas
				$temp1 = preg_replace('/[^\w\pL-,]/iu', '', $temp1);

				$temp2 = preg_split('/,/',$temp1);
				foreach ($temp2 as $key => $str)
				{
					if (in_array($str,$stopwords)) 
					unset($temp2[$key]);
				}
				$linkres->tags = join(', ',$temp2);
			}
//----------------------------------------------------------------------

if (checklevel('admin'))
$Story_Content_Tags_To_Allow = Story_Content_Tags_To_Allow_God;
elseif (checklevel('moderator'))
$Story_Content_Tags_To_Allow = Story_Content_Tags_To_Allow_Admin;
else
$Story_Content_Tags_To_Allow = Story_Content_Tags_To_Allow_Normal;

			$linkres->title_url = makeUrlFriendly($linkres->title);
			$linkres->url=get_val($item, $MyArray['link_url']);
			$linkres->url_title=$linkres->title;
			$linkres->content=get_val($item, $MyArray['content']);
			$linkres->content = strip_tags($linkres->content, $Story_Content_Tags_To_Allow);
			$linkres->content = str_replace("\n", "<br />", $linkres->content);
			$linkres->link_field1=get_val($item, $MyArray['link_field1']);
			$linkres->link_field2=get_val($item, $MyArray['link_field2']);
			$linkres->link_field3=get_val($item, $MyArray['link_field3']);
			$linkres->link_field4=get_val($item, $MyArray['link_field4']);
			$linkres->link_field5=get_val($item, $MyArray['link_field5']);
			$linkres->link_field6=get_val($item, $MyArray['link_field6']);
			$linkres->link_field7=get_val($item, $MyArray['link_field7']);
			$linkres->link_field8=get_val($item, $MyArray['link_field8']);
			$linkres->link_field9=get_val($item, $MyArray['link_field9']);
			$linkres->link_field10=get_val($item, $MyArray['link_field10']);
			$linkres->link_field11=get_val($item, $MyArray['link_field11']);
			$linkres->link_field12=get_val($item, $MyArray['link_field12']);
			$linkres->link_field13=get_val($item, $MyArray['link_field13']);
			$linkres->link_field14=get_val($item, $MyArray['link_field14']);
			$linkres->link_field15=get_val($item, $MyArray['link_field15']);

			$linkres->category=$feed->feed_category;
//MJE: MOD
			$linkres->link_summary = close_tags(utf8_substr(strip_tags($linkres->content), 0, StorySummary_ContentTruncate - 1));
//---------			

			if($thecount >= $feed->feed_item_limit && $skipthis == 0){
				echo "Reached import limit, skipping<HR>";
				$skipthis = 1;
			}

		  
		if($feed->feed_title_dupe == 0 && $skipthis == 0){  // 0 means don't allow, 1 means allow
			if($linkres->duplicates_title($linkres->title) > 0) {
					//echo "Title Match, skipping: " . $linkres->title . "<HR>";
					echo '<span style="color:#fc0000;">Title Match, skipping</span> <hr>';
					$skipthis = 1;
				}
		}
			
		if($feed->feed_url_dupe == 0 && $linkres->url != "" && $skipthis == 0){  // 0 means don't allow, 1 means allow
			if($linkres->duplicates($linkres->url) > 0) {
					//echo "URL Match, skipping: " . $linkres->title . "<HR>";
					echo '<span style="color:#fc0000;">URL Match, skipping</span> <hr>';
					$skipthis = 1;
			}
		}	
				  
			if ($skipthis == 0) {
				echo "Importing <hr>";
				$added_one = true;
				$linkres->store();
				totals_adjust_count($linkres->status, 1);
				tags_insert_string($linkres->id, $dblang, $linkres->tags);
				
				require_once(mnminclude.'votes.php');
				
				if($feed->feed_random_vote_enable == 1){
					$feed->feed_votes = rand($feed->feed_random_vote_min, $feed->feed_random_vote_max);
				}
				
				$votes = 0;
				for($i=1; $i <= $feed->feed_votes ; $i++){
					$value=1;
					$vote = new Vote;
					$vote->type='links';
					$vote->user=0;
					$vote->link=$linkres->id;
					$vote->ip='0.0.0.' . $i;
					$vote->value=$value;						
					$vote->insert();
					$vote = "";
					$votes+=$value;
					
//								$vote = new Vote;
//								$vote->type='links';
//								$vote->link=$linkres->id;
				}
				$linkres->votes=$votes;
				$linkres->store_basic();
				$linkres->check_should_publish();					
										
				$thecount = $thecount + 1;
			}
		}

		$sql = "UPDATE `" . table_feeds . "` SET `feed_last_check` = FROM_UNIXTIME(" . (time()-300) . ") WHERE `feed_id` = $feed->feed_id;";
		//echo $sql;
		$db->query($sql);
		
	} else {
		echo "Feed not fully setup, skipping <hr>";
	}

	if ($added_one) return true; else return false;
}


$RSSImport=new RSSImport;
$feeds_list = $RSSImport->get_feeds_lists();


if(!$feeds_list) {
	echo "<h4>You have not setup any feeds yet!</h4>";
	echo "Go <a href='javascript: history.go(-1)'>back</a> and add a feed.";
} else {

	$added_any = false;

	foreach ($feeds_list as $feed) {
	
		// if we're overriding the update time: 	
		if ($_GET['override'] == $feed->feed_id) { 

			echo "<h3>Site: ", $feed->feed_name, "</h3><hr>";
			$added_any = do_the_import_stuff($feed); 

		// otherwise, check to see if it's time to update as along as we're not overriding: 
		} elseif ( ( (time() - ($feed->feed_freq_hours * 3600)) > strtotime($feed->feed_last_check) ) && ($_GET['override'] == '') ) {

			echo "<h3>Site: ", $feed->feed_name, "</h3><hr>";
			$added_any = do_the_import_stuff($feed); 

		} 

		if (!$_GET['override']) {
			
			echo "<h3>Site: ", $feed->feed_name, "</h3>";
			echo "Feed Frequency is " . $feed->feed_freq_hours . ".<br>";
			$x = strtotime($feed->feed_last_check);
			$y = (time() - ($feed->feed_freq_hours * 3600));
			echo "Next run in " . (intval(($x - $y) / 60 / 60* 100) / 100) . " hours.";
			echo '<br><a href = "?module=rss_import_do_import&override='.$feed->feed_id.'">Run Anyway</a>';
			
		}	
	}

	// MJE: mod - do XML pings when new stories are added, requires XML Site map module
	if ($added_any) check_actions('do_submit3', $vars);
	//
}

function get_val($item, $theField) {
	$nestPos = strpos($theField, "_ne_st_ed_");
	if ($nestPos > 0){
		$first = substr($theField, 0 , $nestPos);
		$second = trim(substr($theField, $nestPos + 10, 100));
		return trim($item[$first][$second]);
	} else {
		return trim($item[$theField]);
	}
}

function rss_trim_value(&$value) 
{ 
    $value = trim($value); 
}
{/php}

{config_load file=rss_import_pligg_lang_conf}