<?php
set_time_limit(120);
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
include(mnminclude.'user.php');
include(mnminclude.'smartyvariables.php');

if (!$_COOKIE['referrer'])
    check_referrer();

// html tags allowed during submit
if (checklevel('god'))
    $Story_Content_Tags_To_Allow = Story_Content_Tags_To_Allow_God;
elseif (checklevel('admin'))
    $Story_Content_Tags_To_Allow = Story_Content_Tags_To_Allow_Admin;
else
    $Story_Content_Tags_To_Allow = Story_Content_Tags_To_Allow_Normal;
$main_smarty->assign('Story_Content_Tags_To_Allow', htmlspecialchars($Story_Content_Tags_To_Allow));

// breadcrumbs and page titles
$navwhere['text1'] = $main_smarty->get_config_vars('PLIGG_Visual_Breadcrumb_Submit');
$navwhere['link1'] = getmyurl('submit', '');
$main_smarty->assign('navbar_where', $navwhere);
$main_smarty->assign('posttitle', $main_smarty->get_config_vars('PLIGG_Visual_Breadcrumb_Submit'));
$main_smarty = do_sidebar($main_smarty);

//to check anonymous mode activated
global $current_user;
if($current_user->authenticated != TRUE)
{
	$vars = '';
	check_actions('anonymous_story_user_id', $vars);
	if ($vars['anonymous_story'] != true)
		force_authentication();
}
/*
if ($vars['anonymous_story'] == true)
{
	$anonymous_userid = $db->get_row("SELECT user_id from " . table_users . " where user_login = 'anonymous' ");
	$anonymous_user_id = $anonymous_userid->user_id;
	//echo "val".$anonymous_user_id;
}
*/
// module system hook
$vars = '';
check_actions('submit_post_authentication', $vars);

// this is for direct links from weblogs
if(empty($_POST['phase']) && (!empty($_GET['url']) || is_numeric($_GET['id']))) {
	$_POST['phase'] = 1;
	if(!empty($_GET['url'])) 
	{
	    $_POST['url'] = $_GET['url'];
	}
	else
	{
	    $row = $db->get_row("SELECT * FROM ".table_links." WHERE link_id='".$db->escape($_GET['id'])."' AND link_author='{$current_user->user_id}'",ARRAY_A);
	    if (!$row['link_id'])
	    {
		define('pagename', 'submit'); 
		$main_smarty->assign('pagename', pagename);
		$main_smarty->assign('submit_error', 'badkey');
		$main_smarty->assign('tpl_center', $the_template . '/submit_errors');
		$main_smarty->display($the_template . '/pligg.tpl');
		die();
	    }
	    $_POST['url'] = $row['link_url'];
	}
	    $_POST['randkey'] = rand(10000,10000000);
	if(!empty($_GET['trackback'])) 
	    $_POST['trackback'] = $_GET['trackback'];
}

// determine which step of the submit process we are on
$phase = isset($_POST["phase"]) && is_numeric($_POST["phase"]) ? $_POST["phase"] : 0;

// If show URL input box is disabled, go straight to step 2
if($phase == 0 && Submit_Show_URL_Input == false) {
	$phase = 1;
}
switch ($phase) {
	case 0:
		do_submit0();
		break;
	case 1:
		do_submit1();
		break;
	case 2:
		do_submit2();
		break;
	case 3:
		do_submit3();
		break;
}

exit;

// enter URL before submit process
function do_submit0() {
	global $main_smarty, $the_template;
	$main_smarty->assign('submit_rand', rand(10000,10000000));
	$main_smarty->assign('Submit_Show_URL_Input', Submit_Show_URL_Input);
	$main_smarty->assign('Submit_Require_A_URL', Submit_Require_A_URL);
	
	define('pagename', 'submit'); 
	$main_smarty->assign('pagename', pagename);
	
	$main_smarty->assign('tpl_center', $the_template . '/submit_step_1');
	$vars = '';
	check_actions('do_submit0', $vars);
	$main_smarty->display($the_template . '/pligg.tpl');
}

// submit step 1
function do_submit1() {
	global $main_smarty, $db, $dblang, $current_user, $the_template;

	$url = htmlspecialchars(sanitize($_POST['url'], 3));
	$url = str_replace('&amp;', '&', $url);  
	$url = html_entity_decode($url);
	if (strpos($url,'http')!==0)
	    $url = "http://$url";
	
	$linkres=new Link;
	$linkres->randkey = sanitize($_POST['randkey'], 3);

	if(Submit_Show_URL_Input == false) {
		$url = "http://";	
		$linkres->randkey = rand(10000,10000000);
	}
	$Submit_Show_URL_Input = Submit_Show_URL_Input;
	if($url == "http://" || $url == ""){
		$Submit_Show_URL_Input = false;
	}
	
	$edit = false;
	if (is_numeric($_GET['id']))
	{
	    $linkres->id = $_GET['id'];
	    $linkres->read(FALSE);
	    $trackback=$_GET['trackback'];
	}
	else
	{
	    $linkres->get($url);
	    if ($_POST['title'])
	    	$linkres->title = stripslashes(sanitize($_POST['title'], 4, $Story_Content_Tags_To_Allow));
	    if ($_POST['tags'])
	    	$linkres->tags = stripslashes(sanitize($_POST['tags'], 4));
	    if ($_POST['description'])
	    	$linkres->content = stripslashes(sanitize($_POST['description'], 4, $Story_Content_Tags_To_Allow));

	    if ($_POST['category'])
	    {
		$cats = explode(',',$_POST['category']);
		foreach ($cats as $cat)
		    if ($cat_id = $db->get_var("SELECT category_id FROM ".table_categories." WHERE category_name='".$db->escape(trim($cat))."'"))
		    {
			$linkres->category = $cat_id;
			break;
		    }
	    }
	    $trackback=$linkres->trackback;
	}
	$main_smarty->assign('randkey', $linkres->randkey);	
	$main_smarty->assign('submit_url', $url);
	$data = parse_url($url);
	$main_smarty->assign('url', $url);
	$main_smarty->assign('url_short', 'http://'.$data['host']);
	$main_smarty->assign('Submit_Show_URL_Input', $Submit_Show_URL_Input);
	$main_smarty->assign('Submit_Require_A_URL', Submit_Require_A_URL);


	if($url == "http://" || $url == ""){
		if(Submit_Require_A_URL == false){
			$linkres->valid = true;}
		else{
			$linkres->valid = false;
		}
		$linkres->url_title = "";
	}
	
	$vars = array("url" => $url,'linkres'=>$linkres);
	check_actions('submit_validating_url', $vars);
	$linkres = $vars['linkres'];
	
	if(!$linkres->valid) {
		$main_smarty->assign('submit_error', 'invalidurl');
		$main_smarty->assign('tpl_center', $the_template . '/submit_errors');
		
		$main_smarty->display($the_template . '/pligg.tpl');
		return;
	}
	
	if(Submit_Require_A_URL == true || ($url != "http://" && $url != "")){
		if(!is_numeric($_GET['id']) && $linkres->duplicates($url) > 0) {
			$main_smarty->assign('submit_search', getmyurl("search_url", htmlentities($url)));
			$main_smarty->assign('submit_error', 'dupeurl');
			$main_smarty->assign('tpl_center', $the_template . '/submit_errors');
			
			define('pagename', 'submit'); 
		     	$main_smarty->assign('pagename', pagename);
			
			$main_smarty->display($the_template . '/pligg.tpl');
			return;
		}
	}

	$vars = array("url" => $url);
	check_actions('submit_validating_url', $vars);
	
	totals_adjust_count('discard', 1);
	//echo 'id'.$current_user->user_id;
	$linkres->status='discard';
	$linkres->author=$current_user->user_id;
	$linkres->store();

	$main_smarty->assign('StorySummary_ContentTruncate', StorySummary_ContentTruncate);
	$main_smarty->assign('SubmitSummary_Allow_Edit', SubmitSummary_Allow_Edit);
	$main_smarty->assign('enable_tags', Enable_Tags);
	$main_smarty->assign('submit_url_title', str_replace('"',"&#034;",$linkres->url_title));
	$main_smarty->assign('submit_url_description', $linkres->url_description);
	$main_smarty->assign('submit_id', $linkres->id);
	$main_smarty->assign('submit_type', $linkres->type());
	if(isset($link_title)){$main_smarty->assign('submit_title', str_replace('"',"&#034;",$link_title));}
	if(isset($link_content)){$main_smarty->assign('submit_content', $link_content);}
	$main_smarty->assign('submit_trackback', $trackback);
	$main_smarty->assign('submit_link_field1', $linkres->link_field1);
	$main_smarty->assign('submit_link_field2', $linkres->link_field2);
	$main_smarty->assign('submit_link_field3', $linkres->link_field3);
	$main_smarty->assign('submit_link_field4', $linkres->link_field4);
	$main_smarty->assign('submit_link_field5', $linkres->link_field5);
	$main_smarty->assign('submit_link_field6', $linkres->link_field6);
	$main_smarty->assign('submit_link_field7', $linkres->link_field7);
	$main_smarty->assign('submit_link_field8', $linkres->link_field8);
	$main_smarty->assign('submit_link_field9', $linkres->link_field9);
	$main_smarty->assign('submit_link_field10', $linkres->link_field10);
	$main_smarty->assign('submit_link_field11', $linkres->link_field11);
	$main_smarty->assign('submit_link_field12', $linkres->link_field12);
	$main_smarty->assign('submit_link_field13', $linkres->link_field13);
	$main_smarty->assign('submit_link_field14', $linkres->link_field14);
	$main_smarty->assign('submit_link_field15', $linkres->link_field15);
	$main_smarty->assign('submit_link_group_id', $linkres->link_group_id);

//	$main_smarty->assign('submit_id', $_GET['id']);
	$main_smarty->assign('submit_title', str_replace('"',"&#034;",$linkres->title));
	$main_smarty->assign('submit_content', str_replace("<br />", "\n", $linkres->content));
	$main_smarty->assign('storylen', utf8_strlen(str_replace("<br />", "\n", $linkres->content)));
	$main_smarty->assign('submit_summary', $linkres->link_summary);
	$main_smarty->assign('submit_group', $linkres->link_group_id);
	$main_smarty->assign('submit_category', $linkres->category);
	$main_smarty->assign('submit_additional_cats', $linkres->additional_cats);
	$main_smarty->assign('tags_words', $linkres->tags);

	include_once(mnminclude.'dbtree.php');
	$array = tree_to_array(0, table_categories, FALSE);

	$array = array_values(array_filter($array, "allowToAuthorCat"));

	$main_smarty->assign('submit_lastspacer', 0);
	$main_smarty->assign('submit_cat_array', $array);

	/*include_once(mnminclude.'group.php');
	$group_arr=array();
	$group_arr = get_groupdetail_user();
	//echo "group".print_r($group_arr);
	$main_smarty->assign('submit_group_array', get_groupdetail_user());*/
	
	//to display group drop down
	if(enable_group == "true")
	{
		$output = '';
		$group_membered = $db->get_results("SELECT group_id,group_name FROM " . table_groups . " 
							LEFT JOIN ".table_group_member." ON member_group_id=group_id
							WHERE member_user_id = $current_user->user_id AND group_status = 'Enable' AND member_status='active'
							ORDER BY group_name ASC");
		if ($group_membered)
		{
			$output .= "<select name='link_group_id'>";
			$output .= "<option value = ''>".$main_smarty->get_config_vars('PLIGG_Visual_Group_Select_Group')."</option>";
			foreach($group_membered as $results)
			{
				$output .= "<option value = ".$results->group_id. ($linkres->link_group_id ? ' selected' : '') . ">".$results->group_name."</option>";
			}
			$output .= "</select>";
		}
		$main_smarty->assign('output', $output);
	}
	if($current_user->authenticated != TRUE){
		$vars = '';
		check_actions('register_showform', $vars);
	}

	$main_smarty->assign('Spell_Checker', Spell_Checker);

	$main_smarty->assign('tpl_extra_fields', $the_template . '/submit_extra_fields');
	$main_smarty->assign('tpl_center', $the_template . '/submit_step_2');
	
	define('pagename', 'submit'); 
	$main_smarty->assign('pagename', pagename);
	
	$vars = '';
	check_actions('do_submit1', $vars);
	$_SESSION['step'] = 1;
	$main_smarty->display($the_template . '/pligg.tpl');
}

// submit step 2
function do_submit2() {
	global $db, $main_smarty, $dblang, $the_template, $linkres, $current_user, $Story_Content_Tags_To_Allow;

	$main_smarty->assign('auto_vote', auto_vote);
	$main_smarty->assign('Submit_Show_URL_Input', Submit_Show_URL_Input);
	$main_smarty->assign('Submit_Require_A_URL', Submit_Require_A_URL);
	$main_smarty->assign('link_id', sanitize($_POST['id'], 3));
	define('pagename', 'submit'); 
	$main_smarty->assign('pagename', pagename);

	if($current_user->authenticated != TRUE){
		$vars = array('username' => $current_user->user_login);
		check_actions('register_check_errors', $vars);
	}
	check_actions('submit2_check_errors', $vars);
	if($vars['error'] == true){
	}else
	{

	$linkres=new Link;
	$linkres->id = sanitize($_POST['id'], 3);
	if($_SESSION['step']!=1)die('Wrong step');
	if(!is_numeric($linkres->id))die();
	if(!$linkres->verify_ownership($current_user->user_id))	die($main_smarty->get_config_vars('PLIGG_Visual_Submit2Errors_NoAccess'));
		
	$linkres->read(FALSE);

	if($linkres->votes($current_user->user_id) == 0 && auto_vote == true) {
		$linkres->insert_vote($current_user->user_id, '10');
		$linkres->store_basic();
		$linkres->read(FALSE); 
	}
	
	if (is_array($_POST['category']))
	{
	    $linkres->category=sanitize($_POST['category'][0], 3);
	    $linkres->additional_cats=array_slice($_POST['category'],1);
	}
	else
	    $linkres->category=sanitize($_POST['category'], 3);

	$thecat = get_cached_category_data('category_id', $linkres->category);
	$main_smarty->assign('request_category_name', $thecat->category_name);

	$linkres->title = stripslashes(sanitize($_POST['title'], 3));
	$linkres->title_url = makeUrlFriendly($linkres->title, $linkres->id);
	$linkres->tags = tags_normalize_string(stripslashes(sanitize($_POST['tags'], 3)));
	$linkres->content = close_tags(stripslashes(sanitize($_POST['bodytext'], 4, $Story_Content_Tags_To_Allow)));
	$linkres->content = str_replace("\n", "<br />", $linkres->content);
	// Steef 2k7-07 security fix start ----------------------------------------------------------
		if(isset($_POST['link_field1'])){$linkres->link_field1 = sanitize($_POST['link_field1'], 4, $Story_Content_Tags_To_Allow);}
		if(isset($_POST['link_field2'])){$linkres->link_field2 = sanitize($_POST['link_field2'], 4, $Story_Content_Tags_To_Allow);}
		if(isset($_POST['link_field3'])){$linkres->link_field3 = sanitize($_POST['link_field3'], 4, $Story_Content_Tags_To_Allow);}
		if(isset($_POST['link_field4'])){$linkres->link_field4 = sanitize($_POST['link_field4'], 4, $Story_Content_Tags_To_Allow);}
		if(isset($_POST['link_field5'])){$linkres->link_field5 = sanitize($_POST['link_field5'], 4, $Story_Content_Tags_To_Allow);}
		if(isset($_POST['link_field6'])){$linkres->link_field6 = sanitize($_POST['link_field6'], 4, $Story_Content_Tags_To_Allow);}
		if(isset($_POST['link_field7'])){$linkres->link_field7 = sanitize($_POST['link_field7'], 4, $Story_Content_Tags_To_Allow);}
		if(isset($_POST['link_field8'])){$linkres->link_field8 = sanitize($_POST['link_field8'], 4, $Story_Content_Tags_To_Allow);}
		if(isset($_POST['link_field9'])){$linkres->link_field9 = sanitize($_POST['link_field9'], 4, $Story_Content_Tags_To_Allow);}
		if(isset($_POST['link_field10'])){$linkres->link_field10 = sanitize($_POST['link_field10'], 4, $Story_Content_Tags_To_Allow);}
		if(isset($_POST['link_field11'])){$linkres->link_field11 = sanitize($_POST['link_field11'], 4, $Story_Content_Tags_To_Allow);}
		if(isset($_POST['link_field12'])){$linkres->link_field12 = sanitize($_POST['link_field12'], 4, $Story_Content_Tags_To_Allow);}
		if(isset($_POST['link_field13'])){$linkres->link_field13 = sanitize($_POST['link_field13'], 4, $Story_Content_Tags_To_Allow);}
		if(isset($_POST['link_field14'])){$linkres->link_field14 = sanitize($_POST['link_field14'], 4, $Story_Content_Tags_To_Allow);}
		if(isset($_POST['link_field15'])){$linkres->link_field15 = sanitize($_POST['link_field15'], 4, $Story_Content_Tags_To_Allow);}
	// Steef 2k7-07 security fix end --------------------------------------------------------------

	if(!isset($_POST['summarytext'])){
		$linkres->link_summary = utf8_substr(sanitize($_POST['bodytext'], 4, $Story_Content_Tags_To_Allow), 0, StorySummary_ContentTruncate - 1);
		$linkres->link_summary = close_tags(str_replace("\n", "<br />", $linkres->link_summary));		
	} else {
		$linkres->link_summary = sanitize($_POST['summarytext'], 4, $Story_Content_Tags_To_Allow);
		$linkres->link_summary = close_tags(str_replace("\n", "<br />", $linkres->link_summary));
		if(utf8_strlen($linkres->link_summary) > StorySummary_ContentTruncate){
			loghack('SubmitAStory-SummaryGreaterThanLimit', 'username: ' . sanitize($_POST["username"], 3).'|email: '.sanitize($_POST["email"], 3), true);
			$linkres->link_summary = utf8_substr($linkres->link_summary, 0, StorySummary_ContentTruncate - 1);
			$linkres->link_summary = close_tags(str_replace("\n", "<br />", $linkres->link_summary));
		}
	}
		//get link_group_id
		if((isset($_REQUEST['link_group_id']))&&($_REQUEST['link_group_id']!='')){
			$linkres->link_group_id = intval($_REQUEST['link_group_id']);
		}
		else{
			$linkres->link_group_id=0;
		}
	
	$linkres->store();
	tags_insert_string($linkres->id, $dblang, $linkres->tags);

	if (link_errors($linkres)) {
		return;
	}

		//comment subscription
		if(isset($_POST['comment_subscription']))
		{
			
			$vars = array('link_id' => $linkres->id);
			check_actions('comment_subscription_insert_function', $vars);
		}	
		//comment subscription
		if(isset($_POST['timestamp_date_day']))
		{
			//open date
			$timestamp_date_day = $_POST['timestamp_date_day'];
			$timestamp_date_month = $_POST['timestamp_date_month'];
			$timestamp_date_year = $_POST['timestamp_date_year'];
			if (!is_numeric($timestamp_date_day) || !is_numeric($timestamp_date_month) || !is_numeric($timestamp_date_year))
				$timestamp_date = date("m-d-Y");
			else
				$timestamp_date = $timestamp_date_month."-".$timestamp_date_day."-".$timestamp_date_year;
			
			$vars = array('link_id' => $linkres->id);
			$vars = array('timestamp_date' => $timestamp_date,'link_id' => $linkres->id);
			check_actions('comment_subscription_insert_function', $vars);
		}

	$vars = '';
	check_actions('submit_step_3_after_first_store', $vars);
	if ($vars['error'] == true && link_catcha_errors('captcha_error'))
			return;

	$linkres->read(FALSE);
	$edit = true;
	$link_title = $linkres->title;
	$link_content = $linkres->content;
	$link_title = stripslashes(sanitize($_POST['title'], 3));
	$main_smarty->assign('the_story', $linkres->print_summary('full', true));
	
	$main_smarty->assign('tags', $linkres->tags);
	if (!empty($linkres->tags)) {
		$tags_words = str_replace(",", ", ", $linkres->tags);
		$tags_url = urlencode($linkres->tags);
		$main_smarty->assign('tags_words', $tags_words);
		$main_smarty->assign('tags_url', $tags_url);
	}

	if(isset($url)){
		$main_smarty->assign('submit_url', $url);
	} else {
		$main_smarty->assign('submit_url', '');
	}
	$data = parse_url($linkres->url);
	$main_smarty->assign('url_short', $data['host']);
	$main_smarty->assign('submit_url_title', $linkres->url_title);
	$main_smarty->assign('submit_id', $linkres->id);
	$main_smarty->assign('submit_type', $linkres->type());
	$main_smarty->assign('submit_title', str_replace('"',"&#034;",$link_title));
	$main_smarty->assign('submit_content', $link_content);
	if(isset($trackback)){
		$main_smarty->assign('submit_trackback', $trackback);
	} else {
		$main_smarty->assign('submit_trackback', '');
	}
			
	$main_smarty->assign('tpl_extra_fields', $the_template . '/submit_extra_fields');
	$main_smarty->assign('tpl_center', $the_template . '/submit_step_3');
	

	$vars = '';	
	check_actions('do_submit2', $vars);
	$_SESSION['step'] = 2;
	if (Submit_Complete_Step2)
	    do_submit3();
	else
	    $main_smarty->display($the_template . '/pligg.tpl');
	}
}

// submit step 3
function do_submit3() {
	global $db;

	$linkres=new Link;
	$linkres->id = sanitize($_POST['id'], 3);
	if(!is_numeric($linkres->id))die();

	if(!Submit_Complete_Step2 && $_SESSION['step']!=2)die('Wrong step');
	$linkres->read();

	totals_adjust_count($linkres->status, -1);
	totals_adjust_count('queued', 1);

	$linkres->status='queued';

	$vars = array('linkres'=>&$linkres);
	check_actions('do_submit3', $vars);

	if ($vars['linkres']->status=='discard')
	{
		$vars = array('link_id' => $linkres->id);
		check_actions('story_discard', $vars);
	}
	elseif ($vars['linkres']->status=='spam')
	{
		$vars = array('link_id' => $linkres->id);
		check_actions('story_spam', $vars);
	}
	

	$linkres->store_basic();
	$linkres->check_should_publish();
	
	if(isset($_POST['trackback']) && sanitize($_POST['trackback'], 3) != '') {
		require_once(mnminclude.'trackback.php');
		$trackres = new Trackback;
		$trackres->url=sanitize($_POST['trackback'], 3);
		$trackres->link=$linkres->id;
		$trackres->title=$linkres->title;
		$trackres->author=$linkres->author;
		$trackres->content=$linkres->content;
		$res = $trackres->send();
	}

	$vars = array('linkres'=>$linkres);
	check_actions('submit_pre_redirect', $vars);
	if ($vars['redirect'])
	    header('Location: '.$vars['redirect']);
	elseif($linkres->link_group_id == 0)
		header("Location: " . getmyurl('upcoming'));
	else
	{
		$redirect = getmyurl("group_story", $linkres->link_group_id);
		header("Location: $redirect");
	}	
	die;
}

// assign any errors found during submit
function link_errors($linkres)
{
	global $main_smarty, $the_template, $cached_categories;
	$error = false;

	if(sanitize($_POST['randkey'], 3) !== $linkres->randkey) { // random key error
		$main_smarty->assign('submit_error', 'badkey');
		$error = true;
	}
	if($linkres->status != 'discard' && $linkres->status != 'draft') { // if link has already been submitted
		$main_smarty->assign('submit_error', 'hashistory');
		$main_smarty->assign('submit_error_history', $linkres->status);
		$error = true;
	}
	$story = preg_replace('/[\s]+/',' ',strip_tags($linkres->content));
	if(utf8_strlen($linkres->title) < minTitleLength  || utf8_strlen($story) < minStoryLength ) {
		$main_smarty->assign('submit_error', 'incomplete');
		$error = true;
	}
	if(utf8_strlen($linkres->title) > maxTitleLength) {
		$main_smarty->assign('submit_error', 'long_title');
		$error = true;
	}
  	if (utf8_strlen($linkres->content) > maxStoryLength ) { 
		$main_smarty->assign('submit_error', 'long_content');
		$error = true;
	}
	if(utf8_strlen($linkres->tags) > maxTagsLength) {
		$main_smarty->assign('submit_error', 'long_tags');
		$error = true;
	}
  	if (utf8_strlen($linkres->summary) > maxSummaryLength ) { 
		$main_smarty->assign('submit_error', 'long_summary');
		$error = true;
	}
	if(preg_match('/.*http:\//', $linkres->title)) { // if URL is found in link title
		$main_smarty->assign('submit_error', 'urlintitle');
		$error = true;
	}
	if(!$linkres->category > 0) { // if no category is selected
		$main_smarty->assign('submit_error', 'nocategory');
		$error = true;
	}
	foreach($cached_categories as $cat) {
		if($cat->category__auto_id == $linkres->category && !allowToAuthorCat($cat)) { // category does not allow authors of this level
			$main_smarty->assign('submit_error', 'nocategory');
			$error = true;
		}
	}
	
	if($error == true){
		$main_smarty->assign('link_id', $linkres->id);
		$main_smarty->assign('tpl_center', $the_template . '/submit_errors');
		$main_smarty->display($the_template . '/pligg.tpl');
		die();
	}
	
	return $error;
}
// assign any errors found during captch checking
function link_catcha_errors($linkerror)
{
	global $main_smarty, $the_template;
	$error = false;

	if($linkerror == 'captcha_error') { // if no category is selected
		$main_smarty->assign('submit_error', 'register_captcha_error');
		$main_smarty->assign('tpl_center', $the_template . '/submit_errors');
		$main_smarty->display($the_template . '/pligg.tpl');
#		$main_smarty->display($the_template . '/submit_errors.tpl');
		$error = true;
	}
	return $error;
}

function allowToAuthorCat($cat) {
	global $current_user, $db;

	$user = new User($current_user->user_id);
	if($user->level == "god")
		return true;
	else if($user->level == "admin" && ((is_array($cat) && $cat['authorlevel'] != "god") || $cat->category_author_level != "god"))
		return true;
	else if((is_array($cat) && $cat['authorlevel'] == "normal") || $cat->category_author_level == "normal")
	// DB 11/12/08
	{
	    $group = is_array($cat) ? $cat['authorgroup'] : $cat->category_author_group;
	    if (! $group)
		return true;
	    else
	    {
		$group = "'".preg_replace("/\s*(,\s*)+/","','",$group)."'";
		$groups = $db->get_row($sql = "SELECT a.* FROM ".table_groups." a, ".table_group_member." b 
							WHERE   a.group_id=b.member_group_id AND 
							 	b.member_user_id=$user->id   AND 
								a.group_status='Enable' AND 
								b.member_status='active' AND
								a.group_name IN ($group)");
		if ($groups->group_id)
		    return true;
	    }
	}
	/////
	return false;
}
?>
