<?php

/* This file is used to parse GET data sent from the ticket_index.tpl file */
include_once('../../config.php');

$canIhaveAccess = 0;
$canIhaveAccess = $canIhaveAccess + checklevel('admin');
$canIhaveAccess = $canIhaveAccess + checklevel('moderator');

function numbers_only($string)
{
	$pattern = '/[^0-9]/';
	return preg_replace($pattern, '', $string);
}

if($canIhaveAccess != 0){	
	if (!isset($_GET['do'])){ $_GET['do']= 'none';}
	if (!isset($_GET['id'])){ $_GET['id']= 'none';}
	
	$story_id = numbers_only($_GET['id']);
	
	// Get tag data
	$tags_sql = $db->get_col("SELECT link_tags FROM ".table_links." WHERE link_id='$story_id'");
	$tags = ($tags_sql[0]);
	$tags = rtrim($tags, ','); // Remove extra commas from end of tags

	if ($_GET['do'] != 'unset' && $tags != '' && $tags != 'accepted' && $tags != 'rejected' && $tags != 'completed' && $tags != 'cannot reproduce'){
		$tags = $tags.','; // Prepare the comma 
	}
	
	if($_GET['do'] == 'unset'){
		
		$old_ticket_sql = $db->get_col("SELECT ticket_status FROM ".table_links." WHERE link_id='$story_id'");
		$tag_old = ($old_ticket_sql[0]);
		$tag_new = '';
		
		if (preg_match("/$tag_old/", $tags)) { // If we need to overwrite an old ticket status
			// Replace any existing ticket tags
			$tags = str_replace($tag_old, $tag_new, $tags);

			// Delete old pligg_tags record
			$db->query("DELETE FROM ".table_prefix."tags WHERE tag_link_id='$story_id' AND tag_words='$tag_old' ");
		
			// Insert new tag into pligg_tags table
			$db->query("INSERT INTO ".table_prefix."tags (tag_link_id, tag_date, tag_words) VALUES ($story_id, '$timestamp', '$tag_new' ");

		} else {
			// Do nothing
		}
		
		// Set the new story tags
		$tags = rtrim($tags, ','); // Remove extra commas from end of tags
		$db->query("UPDATE ".table_links." SET link_tags='$tags' WHERE link_id='$story_id'");
		
		// Set the new ticket status
		$db->query("UPDATE ".table_links." SET ticket_status='' WHERE link_id='$story_id'");
		
	} elseif($_GET['do'] == 'accepted'){
		
		$old_ticket_sql = $db->get_col("SELECT ticket_status FROM ".table_links." WHERE link_id='$story_id'");
		$tag_old = ($old_ticket_sql[0]);
		$tag_new = 'accepted';
		
		if ($tag_old == ''){
			$tags = $tags.$tag_new;
			// Set the new pligg_tags values
			$timestamp = date('Y-m-d H:i:s',time());
			// Insert into pligg_tags table
			$db->query("INSERT INTO ".table_prefix."tags (tag_link_id, tag_date, tag_words) VALUES ($story_id, '$timestamp', '$tag_new' ");
		} elseif (preg_match("/$tag_old/", $tags)) {
			// Replace any existing ticket tags
			$tags = str_replace($tag_old, $tag_new, $tags);
			// Delete old pligg_tags record
			$db->query("DELETE FROM ".table_prefix."tags WHERE tag_link_id='$story_id' AND tag_words='$tag_old' ");
		
			// Insert new tag into pligg_tags table
			$db->query("INSERT INTO ".table_prefix."tags (tag_link_id, tag_date, tag_words) VALUES ($story_id, '$timestamp', '$tag_new' ");
		}
		
		// Set the new story tags
		$tags = rtrim($tags, ','); // Remove extra commas from end of tags
		$db->query("UPDATE ".table_links." SET link_tags='$tags' WHERE link_id='$story_id'");
		
		// Set the new ticket status
		$db->query("UPDATE ".table_links." SET ticket_status='accepted' WHERE link_id='$story_id'");
		
	} elseif($_GET['do'] == 'completed'){
		
		$old_ticket_sql = $db->get_col("SELECT ticket_status FROM ".table_links." WHERE link_id='$story_id'");
		$tag_old = ($old_ticket_sql[0]);
		$tag_new = 'completed';
		
		if ($tag_old == ''){
			$tags = $tags.$tag_new;
			// Set the new pligg_tags values
			$timestamp = date('Y-m-d H:i:s',time());
			// Insert into pligg_tags table
			$db->query("INSERT INTO ".table_prefix."tags (tag_link_id, tag_date, tag_words) VALUES ($story_id, '$timestamp', '$tag_new' ");
		} elseif (preg_match("/$tag_old/", $tags)) {
			// Replace any existing ticket tags
			$tags = str_replace($tag_old, $tag_new, $tags);
			// Delete old pligg_tags record
			$db->query("DELETE FROM ".table_prefix."tags WHERE tag_link_id='$story_id' AND tag_words='$tag_old' ");
		
			// Insert new tag into pligg_tags table
			$db->query("INSERT INTO ".table_prefix."tags (tag_link_id, tag_date, tag_words) VALUES ($story_id, '$timestamp', '$tag_new' ");
		}
		
		// Set the new story tags
		$tags = rtrim($tags, ','); // Remove extra commas from end of tags
		$db->query("UPDATE ".table_links." SET link_tags='$tags' WHERE link_id='$story_id'");
		
		// Set the new ticket status
		$db->query("UPDATE ".table_links." SET ticket_status='completed' WHERE link_id='$story_id'");
		
	} elseif ($_GET['do'] == 'rejected'){
		
		$old_ticket_sql = $db->get_col("SELECT ticket_status FROM ".table_links." WHERE link_id='$story_id'");
		$tag_old = ($old_ticket_sql[0]);
		$tag_new = 'rejected';
		
		if ($tag_old == ''){
			$tags = $tags.$tag_new;
			// Set the new pligg_tags values
			$timestamp = date('Y-m-d H:i:s',time());
			// Insert into pligg_tags table
			$db->query("INSERT INTO ".table_prefix."tags (tag_link_id, tag_date, tag_words) VALUES ($story_id, '$timestamp', '$tag_new' ");
		} elseif (preg_match("/$tag_old/", $tags)) {
			// Replace any existing ticket tags
			$tags = str_replace($tag_old, $tag_new, $tags);
			// Delete old pligg_tags record
			$db->query("DELETE FROM ".table_prefix."tags WHERE tag_link_id='$story_id' AND tag_words='$tag_old' ");
		
			// Insert new tag into pligg_tags table
			$db->query("INSERT INTO ".table_prefix."tags (tag_link_id, tag_date, tag_words) VALUES ($story_id, '$timestamp', '$tag_new' ");
		}
		
		// Set the new story tags
		$tags = rtrim($tags, ','); // Remove extra commas from end of tags
		$db->query("UPDATE ".table_links." SET link_tags='$tags' WHERE link_id='$story_id'");
		
		// Set the new ticket status
		$db->query("UPDATE ".table_links." SET ticket_status='rejected' WHERE link_id='$story_id'");
		
	} elseif ($_GET['do'] == 'reproduce'){
		
		$old_ticket_sql = $db->get_col("SELECT ticket_status FROM ".table_links." WHERE link_id='$story_id'");
		$tag_old = ($old_ticket_sql[0]);
		$tag_new = 'cannot reproduce';
		
		if ($tag_old == ''){
			$tags = $tags.$tag_new;
			// Set the new pligg_tags values
			$timestamp = date('Y-m-d H:i:s',time());
			// Insert into pligg_tags table
			$db->query("INSERT INTO ".table_prefix."tags (tag_link_id, tag_date, tag_words) VALUES ($story_id, '$timestamp', '$tag_new' ");
		} elseif (preg_match("/$tag_old/", $tags)) {
			// Replace any existing ticket tags
			$tags = str_replace($tag_old, $tag_new, $tags);
			// Delete old pligg_tags record
			$db->query("DELETE FROM ".table_prefix."tags WHERE tag_link_id='$story_id' AND tag_words='$tag_old' ");
		
			// Insert new tag into pligg_tags table
			$db->query("INSERT INTO ".table_prefix."tags (tag_link_id, tag_date, tag_words) VALUES ($story_id, '$timestamp', '$tag_new' ");
		}
		
		// Set the new story tags
		$tags = rtrim($tags, ','); // Remove extra commas from end of tags
		$db->query("UPDATE ".table_links." SET link_tags='$tags' WHERE link_id='$story_id'");
		
		// Set the new ticket status
		$db->query("UPDATE ".table_links." SET ticket_status='cannot reproduce' WHERE link_id='$story_id'");
		
	}
	
	// Flush tag cache
	$db->query("TRUNCATE TABLE ".table_tag_cache);
	$db->query($sql="INSERT INTO ".table_tag_cache." select tag_words, count(DISTINCT link_id) as count FROM ".table_tags.", ".table_links." WHERE tag_lang='en' and link_id = tag_link_id and (link_status='published' OR link_status='queued') GROUP BY tag_words order by count desc");
	
	header('Location: ' . $_SERVER['HTTP_REFERER']);
	
} else {
	header("Location: " . getmyurl('login', $_SERVER['REQUEST_URI']));
	die;
}


?>