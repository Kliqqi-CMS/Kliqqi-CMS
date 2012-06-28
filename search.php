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
include(mnminclude.'html1.php');
include(mnminclude.'link.php');
include(mnminclude.'tags.php');
include(mnminclude.'search.php');
include(mnminclude.'smartyvariables.php');

$_REQUEST['search'] = str_replace(array('://',':/'),array(':\\',':\\'),$_REQUEST['search']);
if (strstr($_REQUEST['search'],'/') && $URLMethod == 2)
{
    $post = preg_split('/\//',$_REQUEST['search']);
    $_GET['search'] = $_REQUEST['search'] = $post[0];
    for ($i=1; $i+1<sizeof($post); $i+=2)
	$_GET[$post[$i]] = $_REQUEST[$post[$i]] = $post[$i+1];

    $get = array();
    foreach ($_GET as $k => $v)
	$get[$k] = stripslashes(htmlentities(strip_tags($v),ENT_QUOTES,'UTF-8'));
    $get['return'] = addslashes($get['return']);
    $main_smarty->assign('get',$get);           
}

$_REQUEST['search'] = str_replace(array(':\\',':\\','|'),array('://',':/','/'),$_REQUEST['search']);
#$_GET['search'] = $_REQUEST['search'] = sanitize(str_replace(array(':\\',':\\','|'),array('://',':/','/'),$_REQUEST['search']),2);
if ($_REQUEST['search'] == '-')
    $_GET['search'] = $_REQUEST['search'] = '';

// module system hook
$vars = '';
check_actions('search_top', $vars);

$search=new Search();
	if(isset($_REQUEST['from'])){$search->newerthan = sanitize($_REQUEST['from'], 3);}
	if (preg_match('/^\s*((http[s]?:\/+)?(www\.)?([\w_\-\d]+\.)+\w{2,4}(\/[\w_\-\d\.]+)*\/?(\?[^\s]*)?)\s*$/i',$_REQUEST['search'],$m))
	    $_REQUEST['url'] = $m[1];
	else
	    $search->searchTerm = $db->escape(sanitize($_REQUEST['search']), 3);
	if(!isset($_REQUEST['search'])){$search->orderBy = "link_modified DESC";}
	if(isset($_REQUEST['tag'])){$search->searchTerm = sanitize($_REQUEST['search'], 3); $search->isTag = true;}
	if(isset($_REQUEST['url'])){$search->url = sanitize(preg_replace('/^(http[s]?:\/+)?(www\.)?/i','',$_REQUEST['url']), 3); }

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

// breadcrumbs and page title
$navwhere['text1'] = $main_smarty->get_config_vars('PLIGG_Visual_Breadcrumb_Search') . stripslashes($search->searchTerm);
$navwhere['link1'] = getmyurl('search', urlencode($search->searchTerm));
$main_smarty->assign('navbar_where', $navwhere);
$main_smarty->assign('posttitle', $main_smarty->get_config_vars('PLIGG_Visual_Breadcrumb_Search') . stripslashes($search->searchTerm));

//sidebar
$main_smarty = do_sidebar($main_smarty);

// misc smarty
$main_smarty->assign('searchboxtext',sanitize($_REQUEST['search'],2));
$main_smarty->assign('cat_url', getmyurl("maincategory"));
$main_smarty->assign('URL_rss_page', getmyurl('rsssearch',sanitize($search->searchTerm,2)));

if(strlen($search->searchTerm) < 3 && strlen($search->url) < 3 && !$search->s_date)
{
	$main_smarty->assign('posttitle', $main_smarty->get_config_vars('PLIGG_Visual_Search_Too_Short'));
	$main_smarty->assign('pagename', 'noresults');
}
else
{
	$new_search = $search->new_search();

	$linksum_count = $search->countsql;
	$linksum_sql = $search->sql;

	// pagename	
	define('pagename', 'search'); 
	$main_smarty->assign('pagename', pagename);

	$fetch_link_summary = true;

	include('./libs/link_summary.php'); // this is the code that show the links / stories
	if($rows == false){
		$main_smarty->assign('posttitle', $main_smarty->get_config_vars('PLIGG_Visual_Search_NoResults') . ' ' . stripslashes($search->searchTerm) . stripslashes($search->url));
		$main_smarty->assign('pagename', 'noresults');
	}

	$pages = do_pages($rows, $page_size, "search", true);

	if($_REQUEST['tag'])
	    $pages = str_replace('/search/','/tag/',$pages);
	$main_smarty->assign('search_pagination', $pages);
}

// show the template
$main_smarty->assign('tpl_center', $the_template . '/search_center');
$main_smarty->display($the_template . '/pligg.tpl');
?>
