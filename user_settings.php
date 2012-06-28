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
include(mnminclude.'group.php');
include(mnminclude.'user.php');
include(mnminclude.'friend.php');
include(mnminclude.'smartyvariables.php');
include(mnminclude.'csrf.php');

check_referrer();
$CSRF = new csrf();


$offset=(get_current_page()-1)*$page_size;
$main_smarty = do_sidebar($main_smarty);

define('pagename', 'user'); 
$main_smarty->assign('pagename', pagename);


// if not logged in, redirect to the index page
	$login = isset($_COOKIE['mnm_user'] ) ? sanitize($_COOKIE['mnm_user'] , 3) : '';
	//$login = isset($_GET['login']) ? sanitize($_GET['login'], 3) : '';
	if($login === ''){
		if ($current_user->user_id > 0) {
			$login = $current_user->user_login;
		} else {
			header('Location: ./');
			die;
		}
	}

if (Allow_User_Change_Templates && file_exists("./templates/".$_POST['template']."/header.tpl"))
{
	$domain = $_SERVER['HTTP_HOST']=='localhost' ? '' : preg_replace('/^www/','',$_SERVER['HTTP_HOST']);
	setcookie("template", $_POST['template'], time()+60*60*24*30,'/',$domain);
}

$CSRF->check_expired('user_settings');
if (!$CSRF->check_valid(sanitize($_POST['token'], 3), 'user_settings')){
    	$CSRF->show_invalid_error(1);
	exit;
}

$login_user = $db->escape($login);
//$login_user = $_GET['login'];
$sqlGetiUserId = $db->get_var("SELECT user_id from " . table_users . " where user_login = '" . $login_user. "';");
$select_check = $_POST['chack'];
		/* $geturl = $_SERVER['HTTP_REFERER'];
		$url = strtolower(end(explode('/', $geturl)));
		$vowels = array($url);
		$Get_URL = str_replace($vowels, "", $geturl); */
if ($_SERVER['HTTP_REFERER'] && strpos($_SERVER['HTTP_REFERER'],$my_base_url.$my_pligg_base)===0)
    $geturl = $_SERVER['HTTP_REFERER'];
else
    $geturl = sanitize($_SERVER['HTTP_REFERER'],3);
$url = strtolower(end(explode('/', $geturl)));

	$sqlGetiCategory = "SELECT category__auto_id from " . table_categories . " where category__auto_id!= 0;";
	$sqlGetiCategoryQ = mysql_query($sqlGetiCategory);
	$arr = array();
	while ($row = mysql_fetch_array($sqlGetiCategoryQ, MYSQL_NUM)) 
		$arr[] = $row[0];

	if (!$select_check) $select_check = array();
	$diff = array_diff($arr,$select_check);

	$select_checked = $db->escape(implode(",",$diff));

	$sql = "UPDATE " . table_users . " set user_categories='$select_checked' WHERE user_id = '$sqlGetiUserId'";	
	$query = mysql_query($sql);
	$to_page = preg_replace("/&err=.+$/","",$geturl);
	header("location:".$to_page."");

?>
