<?php

include_once('internal/Smarty.class.php');
$main_smarty = new Smarty;

include('config.php');
include(mnminclude.'html1.php');
include(mnminclude.'link.php');
include(mnminclude.'tags.php');
include(mnminclude.'search.php');
include(mnminclude.'smartyvariables.php');

// module system hook
$vars = '';
check_actions('new_top', $vars);

// find the name of the current category
if(isset($_REQUEST['category'])){
	$thecat = get_cached_category_data('category_safe_name', sanitize($_REQUEST['category'], 1));
	$main_smarty->assign('request_category_name', $thecat->category_name);
	$catID = $thecat->category_id;
	$thecat = $thecat->category_name;
	if (!$thecat)
	{
		header("Location: $my_pligg_base/error_404.php");
//		header("Location: error_404.php");
//		$main_smarty->assign('tpl_center', 'error_404_center');
//		$main_smarty->display($the_template . '/pligg.tpl');		
		die();
	}
	$main_smarty->assign('category', $thecat);
}

// start a new search
$search=new Search();

// order by newest first
$search->orderBy = "link_date DESC, link_id ASC";

// figure out what "page" of the results we're on
$search->offset = (get_current_page()-1)*$page_size;

// pagesize set in the admin panel
$search->pagesize = $page_size;

// since this is new, we only want to view "new" stories
$search->filterToStatus = "new";

// this is for the tabs on the top that filter
if(isset($_GET['part'])){$search->setmek = $db->escape($_GET['part']);}
if(isset($_GET['order'])){$search->ords = $db->escape($_GET['order']);}
$search->do_setmek();

// filter to just the category we're looking at
if(isset($thecat)){$search->category = $catID;}

// do the search
$search->doSearch();

// setup the links
if(isset($_GET['category'])){
	$main_smarty->assign('index_url_recent', getmyurl('newcategory', sanitize($_GET['category'],2)));
	$main_smarty->assign('index_url_today', getmyurl('new_sort', 'today', sanitize($_GET['category'],2)));
	$main_smarty->assign('index_url_yesterday', getmyurl('new_sort', 'yesterday', sanitize($_GET['category'],2)));
	$main_smarty->assign('index_url_week', getmyurl('new_sort', 'week', sanitize($_GET['category'],2)));
	$main_smarty->assign('index_url_month', getmyurl('new_sort', 'month', sanitize($_GET['category'],2)));
	$main_smarty->assign('index_url_year', getmyurl('new_sort', 'year', sanitize($_GET['category'],2)));
	$main_smarty->assign('index_url_alltime', getmyurl('new_sort', 'alltime', sanitize($_GET['category'],2)));
	$main_smarty->assign('index_url_upvoted', getmyurl('new_sort', 'upvoted', sanitize($_GET['category'],2)));
	$main_smarty->assign('index_url_downvoted', getmyurl('new_sort', 'downvoted', sanitize($_GET['category'],2)));
	$main_smarty->assign('index_url_commented', getmyurl('new_sort', 'commented', sanitize($_GET['category'],2)));	
	$main_smarty->assign('cat_url', getmyurl("newcategory"));
} else {
	$main_smarty->assign('index_url_recent', getmyurl('new'));
	$main_smarty->assign('index_url_today', getmyurl('new_sort', 'today'));
	$main_smarty->assign('index_url_yesterday', getmyurl('new_sort', 'yesterday'));
	$main_smarty->assign('index_url_week', getmyurl('new_sort', 'week'));
	$main_smarty->assign('index_url_month', getmyurl('new_sort', 'month'));
	$main_smarty->assign('index_url_year', getmyurl('new_sort', 'year'));
	$main_smarty->assign('index_url_alltime', getmyurl('new_sort', 'alltime'));
	$main_smarty->assign('index_url_upvoted', getmyurl('new_sort', 'upvoted'));
	$main_smarty->assign('index_url_downvoted', getmyurl('new_sort', 'downvoted'));
	$main_smarty->assign('index_url_commented', getmyurl('new_sort', 'commented'));
}
$linksum_count = $search->countsql;
$linksum_sql = $search->sql;


if(isset($_REQUEST['category'])) {

	$category_data = get_cached_category_data('category_safe_name', sanitize($_REQUEST['category'], 1));
	$main_smarty->assign('meta_description', $category_data->category_desc);
	$main_smarty->assign('meta_keywords', $category_data->category_keywords);

	// breadcrumbs and page title for the category we're looking at
	$main_smarty->assign('title', ''.$main_smarty->get_config_vars('PLIGG_Visual_Pligg_Queued') .$thecat . '');
	$navwhere['text1'] = $main_smarty->get_config_vars('PLIGG_Visual_Pligg_Queued');
	$navwhere['link1'] = getmyurl('new', '');
	$navwhere['text2'] = $thecat;	
	$main_smarty->assign('navbar_where', $navwhere);
	$main_smarty->assign('pretitle', $thecat );
	$main_smarty->assign('posttitle', $main_smarty->get_config_vars('PLIGG_Visual_Pligg_Queued'));
	$main_smarty->assign('page_header', $thecat . $main_smarty->get_config_vars('PLIGG_Visual_Pligg_Queued'));
} 
else {
	$navwhere['text1'] = $main_smarty->get_config_vars('PLIGG_Visual_Breadcrumb_Queued');
	$navwhere['link1'] = getmyurl('new', '');
	$main_smarty->assign('navbar_where', $navwhere);
	$main_smarty->assign('posttitle', $main_smarty->get_config_vars('PLIGG_Visual_Breadcrumb_Queued'));
	$main_smarty->assign('page_header', $main_smarty->get_config_vars('PLIGG_Visual_Pligg_Queued'));
}

$main_smarty->assign('URL_rss_page', getmyurl('rsspage', $category_data->category_safe_name, 'new'));

// sidebar
$main_smarty = do_sidebar($main_smarty);

// pagename	
define('pagename', 'new');
$main_smarty->assign('pagename', pagename);

// misc smarty
if(isset($search->setmek)){$main_smarty->assign('setmeka', $search->setmek);}else{$main_smarty->assign('setmeka', '');}
if(isset($search->ords)){$main_smarty->assign('paorder', $search->ords);}

$fetch_link_summary = true;
include('./libs/link_summary.php'); // this is the code that show the links / stories

//For Infinite scrolling and continue reading option 
if(Auto_scroll==2 || Auto_scroll==3){
	$main_smarty->assign("scrollpageSize",$page_size);
}else{
	$main_smarty->assign('link_pagination', do_pages($rows, $page_size, "new", true));
}

// show the template
$main_smarty->assign('tpl_center', $the_template . '/new_center');
$main_smarty->display($the_template . '/pligg.tpl');
?>
