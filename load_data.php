<?php

include_once('Smarty.class.php');
$main_smarty = new Smarty;

include('config.php');
include(mnminclude.'html1.php');
include(mnminclude.'link.php');
//include(mnminclude.'tags.php');
include(mnminclude.'search.php');
include(mnminclude.'smartyvariables.php');

// start a new search
$search=new Search();

// check for some get/post
if(isset($_REQUEST['from'])){$search->newerthan = sanitize($_REQUEST['from'], 3);}
unset($_REQUEST['search']);
unset($_POST['search']);
unset($_GET['search']);
if(isset($_REQUEST['search'])){$search->searchTerm = sanitize($_REQUEST['search'], 3);}
if(isset($_REQUEST['search'])){$search->filterToStatus = "all";}
if(!isset($_REQUEST['search'])){$search->orderBy = "link_published_date DESC, link_date DESC";}
if(isset($_REQUEST['tag'])){$search->searchTerm = sanitize($_REQUEST['search'], 3); $search->isTag = true;}


$catID=$_REQUEST['catID'];


if(isset($catID)){$search->category = $catID;}

// figure out what "page" of the results we're on
//$search->offset = (get_current_page()-1)*$page_size;
$start_up=$_REQUEST['start_up'];
$search->offset = $start_up;
// pagesize set in the admin panel
$search->pagesize =3;

// since this is index, we only want to view "published" stories
$search->filterToStatus = "published";

// this is for the tabs on the top that filter
if(isset($_GET['part'])){$search->setmek = $db->escape($_GET['part']);}
$search->do_setmek();	

// do the search
$search->doSearch();

$linksum_count = $search->countsql;
echo $linksum_sql = $search->sql;

$fetch_link_summary = true;
include(mnminclude.'link_summary.php'); // this is the code that show the links / stories
//$main_smarty->assign('link_pagination', do_pages($rows, $page_size, "published", true));

echo $link_summary_output;



?>