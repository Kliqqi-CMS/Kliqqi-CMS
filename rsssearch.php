<?php
include_once('Smarty.class.php');
$main_smarty = new Smarty;

include('config.php');
include(mnminclude.'html1.php');
include(mnminclude.'link.php');
include(mnminclude.'tags.php');
include(mnminclude.'search.php');
include(mnminclude.'smartyvariables.php');

$_REQUEST['search'] = str_replace(array('://',':/'),array(':\\',':\\'),$_REQUEST['search']);
if (strstr($_REQUEST['search'],'/') && $URLMethod == 2)
{
    $post = split('/',$_REQUEST['search']);
    $_GET['search'] = $_REQUEST['search'] = $post[0];
    for ($i=1; $i+1<sizeof($post); $i+=2)
	$_REQUEST[$post[$i]] = $post[$i+1];
}
$_GET['search'] = $_REQUEST['search'] = str_replace(array(':\\',':\\'),array('://',':/'),$_REQUEST['search']);


// module system hook
$vars = '';
//check_actions('search_top', $vars);

$search=new Search();
	if(isset($_REQUEST['from'])){$search->newerthan = sanitize($_REQUEST['from'], 3);}
	$search->searchTerm = $db->escape(sanitize($_REQUEST['search']), 3);
	if(!isset($_REQUEST['search'])){$search->orderBy = "link_modified DESC";}
	if(isset($_REQUEST['tag'])){$search->searchTerm = sanitize($_REQUEST['search'], 3); $search->isTag = true;}
	if(isset($_REQUEST['url'])){$search->url = sanitize($_REQUEST['url'], 3);}

	// figure out what "page" of the results we're on
	$search->offset = (get_current_page()-1)*$page_size;

	if(isset($_REQUEST['pagesize']))
		{$search->pagesize = sanitize($_REQUEST['pagesize'], 3);}
	else
		// $page_size is set in the admin panel
		{$search->pagesize = $page_size;}

	if(isset($_REQUEST['status'])){
		// if "status" is set, filter to that status
		$search->filterToStatus = sanitize($_REQUEST['status'], 3);
	} else {
		// we want to view "all" stories
		$search->filterToStatus = "all";
	}

	if(isset($_REQUEST['category'])){
		// filter to just the category we're looking at
		$search->category = sanitize($_REQUEST['category'], 1);
	} 


//Advanced Search
if( isset( $_REQUEST['adv'] ) && $_REQUEST['adv'] == 1 ){
	$search->adv = true;
	$search->s_group = sanitize($_REQUEST['sgroup'],2);
	$search->s_tags = sanitize($_REQUEST['stags'],2);
	$search->s_story = sanitize($_REQUEST['slink'],2);
	$search->status = sanitize($_REQUEST['status'],2);
	$search->s_user = sanitize($_REQUEST['suser'],2);
	$search->s_cat = sanitize($_REQUEST['scategory'],2);
	$search->s_comments = sanitize($_REQUEST['scomments'],2);		
	$search->s_date = sanitize($_REQUEST['date'],2);	

	if( intval( $_REQUEST['sgroup'] ) > 0 )
		$display_grouplinks = true;
}
//end Advanced Search

$new_search = $search->new_search();

$linksum_count = $search->countsql;
$linksum_sql = $search->sql;


if ($_GET['tag'])
    $title = " | " . $main_smarty->get_config_vars("PLIGG_Visual_Search_Tags");
else
    $title = " | " . $main_smarty->get_config_vars("PLIGG_Visual_Search_Keywords");
$title .= " | " . sanitize($_GET['search'],4);

do_rss_header($title);

$link = new Link;
$links = $db->get_col($linksum_sql);
if ($links) {
	foreach($links as $link_id) {
		$link->id=$link_id;
		$link->read();
		$category_name = $db->get_var("SELECT category_name FROM " . table_categories . " WHERE category_id = $link->category AND category_lang='$dblang'");

		$link->link_summary = str_replace("\n", "<br />", $link->link_summary);
		$link->link_summary = str_replace("òÀÙ", "'", $link->link_summary);
		$link->link_summary = str_replace("òÀÓ", "-", $link->link_summary);
		$link->link_summary = str_replace("òÀÔ", "-", $link->link_summary);
		$link->link_summary = str_replace("òÀÜ", "\"", $link->link_summary);
		$link->link_summary = str_replace("òÀÝ", "\"", $link->link_summary);		
		
		echo "<item>\n";
		echo "<title><![CDATA[". $link->title . "]]></title>\n"; 
		echo "<link>".getmyFullurl("storyURL", $link->category_safe_names($link->category), urlencode($link->title_url), $link->id)."</link>\n";
		echo "<comments>".getmyFullurl("storyURL", $link->category_safe_names($link->category), urlencode($link->title_url), $link->id)."</comments>\n";
		if (!empty($link_date))
			echo "<pubDate>".date('D, d M Y H:i:s T', $link->$link_date-misc_timezone*3600)."</pubDate>\n";
		else 
			echo "<pubDate>".date('D, d M Y H:i:s T', time()-misc_timezone*3600)."</pubDate>\n";
		echo "<dc:creator>" . $link->username($link->author) . "</dc:creator>\n";
		echo "<category>" . htmlspecialchars($category_name) . "</category>\n";
		echo "<guid>".getmyFullurl("storyURL", $link->category_safe_names($link->category), urlencode($link->title_url), $link->id)."</guid>\n";
		echo "<description><![CDATA[" . $link->link_summary . "<br/><br/>".$link->votes." ".$main_smarty->get_config_vars('PLIGG_Visual_RSS_Votes')." ]]></description>\n";
		echo "</item>\n\n";
	}
}

do_rss_footer();

function do_rss_header($title) {
	global $last_modified, $dblang, $main_smarty;
	header('Content-type: text/xml; charset=utf-8', true);
	echo '<?phpxml version="1.0" encoding="utf-8"?'.'>' . "\n";
	echo '<rss version="2.0" '."\n";
	echo 'xmlns:content="http://purl.org/rss/1.0/modules/content/"'."\n";
	echo 'xmlns:wfw="http://wellformedweb.org/CommentAPI/"'."\n";
	echo 'xmlns:dc="http://purl.org/dc/elements/1.1/"'."\n";
	echo '>'. "\n";
	echo '<channel>'."\n";
	echo '<title>'.htmlspecialchars($main_smarty->get_config_vars("PLIGG_Visual_Name")).$title.'</title>'."\n";
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
