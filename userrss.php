<?php
// The source code packaged with this file is Free Software, Copyright (C) 2005 by
// Ricardo Galli <gallir at uib dot es>.
// It's licensed under the AFFERO GENERAL PUBLIC LICENSE unless stated otherwise.
// You can get copies of the licenses here:
// 		http://www.affero.org/oagpl.html
// AFFERO GENERAL PUBLIC LICENSE is also included in the file called "COPYING".

include_once('Smarty.class.php');
$main_smarty = new Smarty;

include('config.php');
include(mnminclude.'link.php');
include(mnminclude.'html1.php');
include(mnminclude.'search.php');
include(mnminclude.'user.php');
include_once(mnminclude.'smartyvariables.php');

	//status = 'published', 'queued' or 'all' 		// link/story status
	//rows = x 		// number of links/stories to show
	//user = x 		// the users name
	//time = x 		// how far back in time (seconds) to go

if(isset($_GET['user']) && sanitize($_GET['user'], 3) != ''){
	$login = sanitize($_GET['user'], 3);
} else {
	header("Location: $my_pligg_base/404error.php");
	die;
}
$user=new User();
$user->username = $login;
if(!$user->read()) {
	//echo "error: user does not exist";
	header("Location: $my_pligg_base/404error.php");
//	header('Location: 404error.php');
	die;
}

	
$rows = isset($_GET['rows']) && is_numeric($_GET['rows']) ? $_GET['rows'] : 40;

$time = isset($_GET['time']) && is_numeric($_GET['time']) ? $_GET['time'] : 0;
if($time > 0) {
	// Prepare for times
	$sql = "SELECT *, count(*) as votes FROM " . table_votes . ", " . table_links . " 
			LEFT JOIN " . table_users . " ON link_author=user_id 
			WHERE  ";	
	if ($time > 0) {
		$from = time()-$time;
		$sql .= "vote_date > FROM_UNIXTIME($from) AND ";
	}
	$sql .= "vote_link_id=link_id  AND (link_status='published' OR link_status='queued') GROUP BY vote_link_id  ORDER BY votes DESC LIMIT $rows";

	$last_modified = time();
	$title = $main_smarty->get_config_vars("PLIGG_Visual_RSS_Recent") . ' ' . txt_time_diff($from);
	$link_date = "";

} else {
	// All the others
	$tmpsearch = new Search;
	$search = $tmpsearch->get_search_clause();
	// The link_status to search
	$status = isset($_GET['status']) && sanitize($_GET['status'], 3) != '' ? sanitize($_GET['status'], 3) : 'submitted';
	
	switch ($status) {
		case 'published':
			$order_field = 'link_published_date';
			$link_date = 'published_date';
			$title = $main_smarty->get_config_vars("PLIGG_Visual_Published_News");
			$from_where = "FROM " . table_links . " 
						LEFT JOIN " . table_users . " ON link_author=user_id 
						WHERE link_status='published' ";
			$from_where .= " AND link_author=$user->id ";
			break;
		case 'upcoming':
			$title = $main_smarty->get_config_vars("PLIGG_Visual_Pligg_Queued");
			$order_field = 'link_date';
			$link_date = "date";
			$from_where = "FROM " . table_links . " 
						LEFT JOIN " . table_users . " ON link_author=user_id 
						WHERE link_status='queued' ";
			$from_where .= " AND link_author=$user->id ";
			break;
		case 'submitted':
			$title = $main_smarty->get_config_vars("PLIGG_Visual_RSS_All");
			$order_field = 'link_date';
			$link_date = "date";
			$from_where = "FROM " . table_links . " 
						LEFT JOIN " . table_users . " ON link_author=user_id 
						WHERE (link_status='published' OR link_status='queued') ";
			$from_where .= " AND link_author=$user->id ";
			break;
		case 'voted':
			$title = $main_smarty->get_config_vars("PLIGG_Visual_RSS_Voted");
			$order_field = 'link_date';
			$link_date = "date";
			$from_where = "FROM " . table_links . "
						LEFT JOIN " . table_votes . " ON vote_link_id=link_id
						LEFT JOIN " . table_users . " ON link_author=user_id 
						WHERE vote_user_id=$user->id AND (link_status='published' OR link_status='queued') ";
			break;
		case 'commented':
			$title = $main_smarty->get_config_vars("PLIGG_Visual_RSS_Commented");
			$user->username = $login;
			$order_field = 'link_date';
			$link_date = "date";
			$from_where = "FROM " . table_links . "
						LEFT JOIN " . table_comments . " ON comment_link_id=link_id 
						LEFT JOIN " . table_users . " ON link_author=user_id 
						WHERE comment_status='published' AND comment_user_id=$user->id AND (link_status='published' OR link_status='queued') ";
			break;
		case 'saved':
			$title = $main_smarty->get_config_vars("PLIGG_Visual_RSS_Saved");
			$user->username = $login;
			$order_field = 'saved_id';
			$link_date = "date";
			$from_where = "FROM " . table_links . "
						LEFT JOIN " . table_saved_links . " ON saved_link_id=link_id
						LEFT JOIN " . table_users . " ON link_author=user_id 
						WHERE saved_user_id=$user->id AND (link_status='published' OR link_status='queued') ";
			break;		
	}
	
	$cat = isset($_GET['category']) && is_numeric($_GET['category']) ? $_GET['category'] : 0;
	if($cat > 0) {
		$child_cats = '';
		// do we also search the subcategories? 
		if(! Independent_Subcategories){
			$child_array = '';

			// get a list of all children and put them in $child_array.
			children_id_to_array($child_array, table_categories, $cat);
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
	        {
		    $from_where = str_replace("WHERE", " LEFT JOIN ".table_additional_categories. " ON ac_link_id=link_id WHERE", $from_where);
		    $child_cat_sql .= " OR ac_cat_id = $cat ";
		}
		$from_where .= " AND (link_category=$cat " . $child_cat_sql . ")";

		$category_name = $db->get_var("SELECT category_name FROM " . table_categories . " WHERE category_id = $cat AND category_lang='$dblang'");
		$title .= " | ".$category_name;
	}
	
	//This doesn't seem to work -kb
	if($search) {
		$from_where .= $search;
		$title = htmlspecialchars(sanitize($_GET['search'], 3));
	}
	
	
	$order_by = " ORDER BY $order_field DESC ";
	$last_modified = $db->get_var("SELECT UNIX_TIMESTAMP(max($order_field)) links $from_where");
	$sql = "SELECT DISTINCT * $from_where GROUP BY link_id $order_by LIMIT $rows";
}

do_rss_header($title);

$link = new Link;
$links = $db->get_results($sql);
if ($links) {
	foreach($links as $dblink) {
		$link->id=$dblink->link_id;
		$cached_links[$dblink->link_id] = $dblink;
		$link->read();
		$category_name = $db->get_var("SELECT category_name FROM " . table_categories . " WHERE category_id = $link->category AND category_lang='$dblang'");

		$link->content = str_replace("\n", "<br />", $link->content);
		$link->content = str_replace("’", "'", $link->content);
		$link->content = str_replace("–", "-", $link->content);
		$link->content = str_replace("—", "-", $link->content);
		$link->content = str_replace("“", "\"", $link->content);
		$link->content = str_replace("”", "\"", $link->content);
		
		echo "<item>\n";
		echo "	<title><![CDATA[". $link->title ."]]></title>\n";
		echo "	<link>".getmyFullurl("storyURL", $link->category_safe_names($link->category), $link->title_url, $link->id)."</link>\n";
		$vars = array('link' => $link);
		check_actions('rss_add_data', $vars);
		echo '	<source url="'.getmyFullurl("storyURL", $link->category_safe_names($link->category), $link->title_url, $link->id).'"><![CDATA['. $link->title .']]></source>';
		echo "\n	<description><![CDATA[" . $link->content . " ]]></description>\n";
		if (!empty($link_date))
			echo "	<pubDate>".date("r", $link->$link_date-misc_timezone*3600)."</pubDate>\n";
		else 
			echo "	<pubDate>".date("r", time()-misc_timezone*3600)."</pubDate>\n";
		echo "	<author>" . $dblink->user_login . "</author>\n";
		echo "	<category>" . htmlspecialchars($category_name) . "</category>\n";
		echo "	<votes>".$link->votes."</votes>\n";
		echo "	<guid>".getmyFullurl("storyURL", $link->category_safe_names($link->category), $link->title_url, $link->id)."</guid>\n";
		echo "</item>\n\n";
	}
}

do_rss_footer();

function do_rss_header($title) {
	global $last_modified, $dblang, $login, $main_smarty;
	header('Content-type: text/xml; charset=utf-8', true);
	echo '<?phpxml version="1.0" encoding="utf-8"?'.'>' . "\n";
	echo '<rss version="2.0" '."\n";
	echo 'xmlns:content="http://purl.org/rss/1.0/modules/content/"'."\n";
	echo 'xmlns:wfw="http://wellformedweb.org/CommentAPI/"'."\n";
	echo 'xmlns:dc="http://purl.org/dc/elements/1.1/"'."\n";
	echo '>'. "\n";
	echo '<channel>'."\n";
	echo '<title>'.htmlspecialchars($main_smarty->get_config_vars("PLIGG_Visual_Name")).' / '.$login.' / '.$title.'</title>'."\n";
	echo '<link>'.my_base_url.my_pligg_base.'</link>'."\n";
	echo '<description>'.$main_smarty->get_config_vars("PLIGG_Visual_RSS_Description").'</description>'."\n";
	echo '<pubDate>'.date("r", $last_modified-misc_timezone*3600).'</pubDate>'."\n";
	echo '<language>'.$dblang.'</language>'."\n";
}

function do_rss_footer() {
	echo "</channel>\n</rss>\n";
}

function onlyreadables($string) {
  for ($i=0;$i<strlen($string);$i++) {
   $chr = $string{$i};
   $ord = ord($chr);
   if ($ord<32 or $ord>126) {
     $chr = "~";
     $string{$i} = $chr;
   }
  }
  return str_replace("~", "", $string);
}

?>
