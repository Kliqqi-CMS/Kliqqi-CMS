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

$rows = isset($_GET['rows']) && is_numeric($_GET['rows']) ? $_GET['rows'] : 20;
$status = sanitize($_GET['status'], 3) != '' ? sanitize($_GET['status'], 3) : 'published';
$time = isset($_GET['time']) && is_numeric($_GET['time']) ? $_GET['time'] : 0;

if($time > 0) {
	// Prepare for times
	$sql = "SELECT link_id, count(*) as votes FROM " . table_votes . ", " . table_links . " WHERE  ";
	if ($time > 0) {
		$from = time()-$time;
		$sql .= "vote_date > FROM_UNIXTIME($from) AND ";
	}
	$sql .= "vote_link_id=link_id  AND (link_status='published' OR link_status='queued') GROUP BY vote_link_id  ORDER BY votes DESC LIMIT $rows";

	$last_modified = time();
	$title = $main_smarty->get_config_vars('PLIGG_Visual_RSS_Recent') . ' ' . txt_time_diff($from);
	$link_date = "";

} else {
	// All the others
	$tmpsearch = new Search;
	$tmpsearch->searchTerm = isset($_GET['search']) && sanitize($_GET['search'], 3) != '' ? sanitize($_GET['search'], 3) : '';	
	$search = $tmpsearch->get_search_clause();
	if ($search) $status='all';

	switch ($status) {
		case 'published':
			$order_field = 'link_date';
			$link_date = 'date';
			$title = " | " . $main_smarty->get_config_vars("PLIGG_Visual_Published_News");
			break;
		case 'upcoming':
		case 'queued':
			$title = " | " . $main_smarty->get_config_vars("PLIGG_Visual_Pligg_Queued");
			$order_field = 'link_date';
			$link_date = "date";
                        $status = 'queued';
			break;
		case 'shared':
			$order_field = 'link_date';
			$link_date = 'date';
			$title = " | " . $main_smarty->get_config_vars("PLIGG_Visual_Group_Shared");
			break;
		case 'all':
			$title = "";
			$order_field = 'link_date';
			$link_date = "date";
			break;
		default:
			header("Location: $my_pligg_base/404error.php");
//			$main_smarty->assign('tpl_center', '404error');
//			$main_smarty->display($the_template . '/pligg.tpl');
			die();
			break;
	}

	$from  = "FROM " . table_links .
		        " LEFT JOIN " . table_groups . " ON group_id=link_group_id ";
#			" LEFT JOIN " . table_categories . " ON category_id=link_category ".
#			" LEFT JOIN " . table_users . " ON link_author=user_id ";
	if($status == 'shared') {
		$from .= " LEFT JOIN " . table_group_shared . " ON share_link_id=link_id ";
	}
	$where = " WHERE (ISNULL(group_privacy) OR group_privacy!='private') ";
	if($status == 'all') {
		$where .= " AND (link_status='published' OR link_status='queued') ";
	} elseif($status == 'shared') {
		$where .= " AND !ISNULL(share_link_id) AND (link_status='published' OR link_status='queued') ";
	} else {
		$where .= " AND link_status='$status' ";
	}

	if($_REQUEST['category']){
	    if(!($cat=check_integer('category'))) {
		$thecat = get_cached_category_data('category_safe_name', sanitize($_REQUEST['category'], 1));
		$cat = $thecat->category_id;
		if (!$cat)
		{
			header("Location: $my_pligg_base/storyrss.php?title=".urlencode($_REQUEST['category']));
			die();
		}	
	    }
	    $where .= " AND link_category IN (SELECT category_ID from ". table_categories ." where category_id=$cat OR category_parent=$cat )";
	    $category_name = $db->get_var("SELECT category_name FROM " . table_categories . " WHERE category_id = $cat AND category_lang='$dblang'");
	    $title .= " | " . htmlspecialchars($category_name);
	}

	if(isset($_REQUEST['group'])){
	    if(!($group=check_integer('group')))
		$group = $db->get_var("SELECT group_id FROM " . table_groups . " WHERE group_safename = '".$db->escape(strip_tags($_REQUEST['group']))."';");

    	    $group_name = $db->get_var("SELECT group_name FROM " . table_groups . " WHERE group_id = '$group'");
	    if ($group_name)
	    {
		$title .= " | " . $group_name;
		$where .= " AND link_group_id = '$group' ";
	    }
	}
	
	// This doesn't seem to work -kb
	if($search) {
		$where .= $search;
		$title = htmlspecialchars(sanitize($_GET['search'], 3));
	}

	$order_by = " ORDER BY $order_field DESC ";
	$last_modified = $db->get_var($sql="SELECT UNIX_TIMESTAMP(max($order_field)) $from $where");
	$sql = "SELECT * $from $where $order_by LIMIT $rows";
}

do_rss_header($title);
$link = new Link;
$links = $db->get_results($sql);
if ($links) {
	foreach($links as $dblink) {
		$link->id=$dblink->link_id;
		$cached_links[$dblink->link_id] = $dblink;
		$link->read();

		$user = new User($link->author);
		#print_r($link);
		$category_name = $db->get_var($sql="SELECT category_name FROM " . table_categories . " WHERE category_id = {$link->category}");
		#print $sql;

		$link->link_summary = str_replace("\n", "<br />", $link->link_summary);
		$link->link_summary = str_replace("â€™", "'", $link->link_summary);
		$link->link_summary = str_replace("â€“", "-", $link->link_summary);
		$link->link_summary = str_replace("â€”", "-", $link->link_summary);
		$link->link_summary = str_replace("â€œ", "\"", $link->link_summary);
		$link->link_summary = str_replace("â€", "\"", $link->link_summary);		
		
		echo "<item>\n";
		echo "	<title>". $link->title . "</title>\n"; 
		echo "	<link>".getmyFullurl("storyURL", $link->category_safe_names($link->category), urlencode($link->title_url), $link->id)."</link>\n";
		$vars = array('link' => $link);
		check_actions('rss_add_data', $vars);
		$story_url = $link->url;
		if ($story_url != '' && $story_url != 'http://'){
			echo '	<source url="'.urlencode($story_url).'">'. $link->title .'</source>';
		}
		echo "\n	<description><![CDATA[ " . $link->content . " ]]></description>\n";
		if (!empty($link_date))
			echo "	<pubDate>".date('D, d M Y H:i:s T', $link->$link_date-misc_timezone*3600)."</pubDate>\n";
		else 
			echo "	<pubDate>".date('D, d M Y H:i:s T', time()-misc_timezone*3600)."</pubDate>\n";
		echo "	<dc:creator>" . $user->username . "</dc:creator>\n";
		echo "	<category>" . htmlspecialchars($category_name) . "</category>\n";
		echo "	<votes>" . $link->votes . "</votes>\n";
		echo "	<guid>".getmyFullurl("storyURL", $link->category_safe_names($link->category), urlencode($link->title_url), $link->id)."</guid>\n";
		echo "</item>\n\n";
	}
}

do_rss_footer();

function do_rss_header($title) {
	global $last_modified, $dblang, $main_smarty;
	header('Content-type: text/xml; charset=utf-8', true);
	echo '<?xml version="1.0"?>' . "\n";
	echo '<rss xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:media="http://search.yahoo.com/mrss/" xmlns:atom="http://www.w3.org/2005/Atom" version="2.0">'. "\n";
	echo '<channel>'."\n";
	echo '<title>'.htmlspecialchars($main_smarty->get_config_vars("PLIGG_Visual_Name")).' '.trim($title).'</title>'."\n";
	echo '<link>'.my_base_url.my_pligg_base.'</link>'."\n";
	echo '<description>'.$main_smarty->get_config_vars("PLIGG_Visual_RSS_Description").'</description>'."\n";
	echo '<pubDate>'.date('D, d M Y H:i:s T', $last_modified-misc_timezone*3600).'</pubDate>'."\n";
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