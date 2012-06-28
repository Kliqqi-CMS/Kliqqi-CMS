<?php
include_once('Smarty.class.php');
$main_smarty = new Smarty;

include('config.php');
include(mnminclude.'html1.php');
include(mnminclude.'link.php');
include(mnminclude.'group.php');
include(mnminclude.'smartyvariables.php');
include mnminclude.'extra_fields_smarty.php';

$from_where = "1";
if (!checklevel('god'))
    $from_where .= " AND group_status = 'Enable' ";
elseif ($_REQUEST["approve"] && is_numeric($_REQUEST["approve"]))
    $db->query("UPDATE ".table_groups." SET group_status='Enable' WHERE group_id=".$db->escape(sanitize($_REQUEST["approve"],3)));


    $keyword = $db->escape(sanitize(trim($_REQUEST['keyword']), 3));
    if ($keyword) 
    {
	$from_where .= " AND (group_name LIKE '%$keyword%' OR group_description LIKE '%$keyword%')";
	$main_smarty->assign('search', $keyword);
    }

if($_REQUEST["sortby"])
{
	$sortby  = $_REQUEST["sortby"];
	if($sortby == 'newest')
		$order_by = "group_date DESC";
	if($sortby == 'oldest')
		$order_by = "group_date ASC";
	if($sortby == 'members')
		$order_by = "group_members DESC";
	if($sortby == 'name')
		$order_by = "group_name Asc";
	$main_smarty->assign('sortby', $sortby);
}
// pagename
define('pagename', 'groups');
$main_smarty->assign('pagename', pagename);
$main_smarty = do_sidebar($main_smarty);

group_read($from_where,$order_by);

function group_read($from_where,$order_by)
{
	Global $db, $main_smarty, $view, $user, $rows, $page_size, $offset;
	// figure out what "page" of the results we're on
	$offset=(get_current_page()-1)*$page_size;

	// pagesize set in the admin panel
	$search->pagesize = $page_size;

	if ($order_by == "")
		$order_by = "group_date DESC";
	include_once(mnminclude.'smartyvariables.php');
	global $db,$main_smarty;
	$rows = $db->get_var("SELECT count(*) FROM " . table_groups . " WHERE ".$from_where." ");
	$group = $db->get_results("SELECT distinct(group_id) as group_id FROM " . table_groups . " WHERE ".$from_where." ORDER BY group_status DESC, ".$order_by." LIMIT $offset,$page_size ");
	if ($group)
	{
		foreach($group as $groupid)
		{
			$group_display .= group_print_summary($groupid->group_id);
		}
		$main_smarty->assign('group_display', $group_display);
	}	
	$main_smarty->assign('group_pagination', do_pages($rows, $page_size, "groups", true));
		return true;
}

// show the template
$main_smarty->assign('tpl_center', $the_template . '/group_center');
$main_smarty->display($the_template . '/pligg.tpl');
?>