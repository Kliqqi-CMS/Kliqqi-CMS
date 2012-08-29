<?php

include_once('internal/Smarty.class.php');
$main_smarty = new Smarty;

include('config.php');
include(mnminclude.'html1.php');
include(mnminclude.'link.php');
include(mnminclude.'tags.php');
include(mnminclude.'user.php');
include(mnminclude.'smartyvariables.php');

// -------------------------------------------------------------------------------------

// breadcrumbs and page titles
$navwhere['text1'] = ($main_smarty->get_config_vars('PLIGG_Visual_Search_Advanced'));
$navwhere['link1'] = 'advancedsearch.php';//getmyurl('advancesearch', '');
$main_smarty->assign('navbar_where', $navwhere);
$main_smarty->assign('posttitle', $main_smarty->get_config_vars('PLIGG_Visual_Search_Advanced'));


$query = "SELECT *
		  FROM ".table_categories."
		  ORDER BY category_name";
$result = mysql_query( $query );

while( $row = mysql_fetch_array( $result ) ){
	$category_option .= '<option value="'.$row['category_id'].'">'.ucfirst( $row['category_name'] ).'</option>'."\n";	
}

$main_smarty->assign('category_option', $category_option );
		  

// pagename
define('pagename', 'advancedsearch'); 
$main_smarty->assign('pagename', pagename);

// sidebar
$main_smarty = do_sidebar($main_smarty);

$main_smarty->assign('headers', $header_items);

// show the template
$main_smarty->assign('tpl_center', $the_template . '/search_advanced_center');
$main_smarty->display($the_template . '/pligg.tpl');
?>
