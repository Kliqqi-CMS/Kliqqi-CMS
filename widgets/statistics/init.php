<?php
$widget['widget_title'] = "Statistics";
$widget['widget_has_settings'] = 1;
$widget['widget_shrink_icon'] = 1;
$widget['widget_uninstall_icon'] = 1;
$widget['name'] = 'Statistics';
$widget['desc'] = 'This widget inserts common statistics about your website. Examples include the number of members, stories, votes, comments, and your Pligg version.';
$widget['version'] = 0.2;

$sw_version = get_misc_data('sw_version');
if ($sw_version == '') $sw_version='1';
$sw_members = get_misc_data('sw_members');
if ($sw_members == '') $sw_members='1';
$sw_groups = get_misc_data('sw_groups');
if ($sw_groups == '') $sw_groups='1';
$sw_links = get_misc_data('sw_links');
if ($sw_links == '') $sw_links='1';
$sw_published = get_misc_data('sw_published');
if ($sw_published == '') $sw_published='1';
$sw_new = get_misc_data('sw_new');
if ($sw_new == '') $sw_new='1';
$sw_votes = get_misc_data('sw_votes');
if ($sw_votes == '') $sw_votes='1';
$sw_comments = get_misc_data('sw_comments');
if ($sw_comments == '') $sw_comments='1';
$sw_newuser = get_misc_data('sw_newuser');
if ($sw_newuser == '') $sw_newuser='1';
$phpver = get_misc_data('phpver');
if ($phpver == '') $phpver='1';
$mysqlver = get_misc_data('mysqlver');
if ($mysqlver == '') $mysqlver='1';
$sw_dbsize = get_misc_data('sw_dbsize');
if ($sw_dbsize == '') $sw_dbsize='1';


if ($_REQUEST['widget']=='statistics'){
    if(isset($_REQUEST['version']))
		$sw_version = sanitize($_REQUEST['version'], 3);
    misc_data_update('sw_version', $sw_version);
    if(isset($_REQUEST['members']))
		$sw_members = sanitize($_REQUEST['members'], 3);
    misc_data_update('sw_members', $sw_members);
    if(isset($_REQUEST['groups']))
		$sw_groups = sanitize($_REQUEST['groups'], 3);
    misc_data_update('sw_groups', $sw_groups);
    if(isset($_REQUEST['links']))
		$sw_links = sanitize($_REQUEST['links'], 3);
    misc_data_update('sw_links', $sw_links);
    if(isset($_REQUEST['published']))
		$sw_published = sanitize($_REQUEST['published'], 3);
    misc_data_update('sw_published', $sw_published);
    if(isset($_REQUEST['new']))
		$sw_new = sanitize($_REQUEST['new'], 3);
    misc_data_update('sw_new', $sw_new);
    if(isset($_REQUEST['votes']))
		$sw_votes = sanitize($_REQUEST['votes'], 3);
    misc_data_update('sw_votes', $sw_votes);
    if(isset($_REQUEST['comments']))
		$sw_comments = sanitize($_REQUEST['comments'], 3);
    misc_data_update('sw_comments', $sw_comments);
    if(isset($_REQUEST['latestuser']))
		$sw_newuser = sanitize($_REQUEST['latestuser'], 3);
    misc_data_update('sw_newuser', $sw_newuser);
	if(isset($_REQUEST['phpver']))
		$phpver = sanitize($_REQUEST['phpver'], 3);
    misc_data_update('phpver', $phpver);
	if(isset($_REQUEST['mysqlver']))
		$mysqlver = sanitize($_REQUEST['mysqlver'], 3);
    misc_data_update('mysqlver', $mysqlver);
    if(isset($_REQUEST['dbsize']))
		$sw_dbsize = sanitize($_REQUEST['dbsize'], 3);
    misc_data_update('sw_dbsize', $sw_dbsize);
}

// Database Size
include_once('../libs/dbconnect.php');

function CalcFullDatabaseSize($database, $db) {
    $result = mysql_query("SHOW TABLES FROM $database");
    if (!$result) { return -1; }

    $table_count = mysql_num_rows($result);
    $size = 0;

    while ($row = mysql_fetch_row($result)) {
	$tname = $row[0];
        $r = mysql_query("SHOW TABLE STATUS FROM ".$database." LIKE '".$tname."'");
        $data = mysql_fetch_array($r);
        $size += ($data['Index_length'] + $data['Data_length']);
    };
 
    $units = array(' B', ' KB', ' MB', ' GB', ' TB');
    for ($i = 0; $size > 1024; $i++) { $size /= 1024; }
    return round($size, 2).$units[$i];
}

// open mysql connection:
$handle = mysql_connect(EZSQL_DB_HOST, EZSQL_DB_USER, EZSQL_DB_PASSWORD); 
if (!$handle) { die('Connection failed!'); }

// get the size of all tables in this database:
$dbsize = CalcFullDatabaseSize(EZSQL_DB_NAME, $handle);

// close connection:
mysql_close($handle);


// Smarty Assign
if ($main_smarty){
    $main_smarty->assign('sw_version', $sw_version);
	$main_smarty->assign('sw_members', $sw_members);
	$main_smarty->assign('sw_groups', $sw_groups);
	$main_smarty->assign('sw_links', $sw_links);
	$main_smarty->assign('sw_published', $sw_published);
	$main_smarty->assign('sw_new', $sw_new);
	$main_smarty->assign('sw_votes', $sw_votes);
	$main_smarty->assign('sw_comments', $sw_comments);
	$main_smarty->assign('sw_newuser', $sw_newuser);
	$main_smarty->assign('sw_dbsize', $sw_dbsize);
	$main_smarty->assign('phpver', $phpver);
	$main_smarty->assign('mysqlver', $mysqlver);
	$main_smarty->assign('dbsize', $dbsize);
}
?>
