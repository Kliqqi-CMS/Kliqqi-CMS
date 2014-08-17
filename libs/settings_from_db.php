<?php

if(!defined('mnminclude')){header('Location: ../error_404.php');die();}

// this file pulls settings directly from the DB

	include_once mnminclude.'db.php';

	if(caching == 1){
		$db->cache_dir = mnmpath.'cache';
		$db->use_disk_cache = true;
		$db->cache_queries = true;
	}

	// if this query changes, update the 'cache clear' query in /libs/admin_config.php
	$usersql = $db->get_results('SELECT var_name, var_value, var_method, var_enclosein FROM ' . table_prefix . 'config');

	if(!$usersql){die('Error. The ' . table_prefix . 'config table is empty or does not exist');}
	
	foreach($usersql as $row) {
		$value = $row->var_value;
		if ($row->var_method == "normal"){
			$pligg_vars[$row->var_name] = $value;
			if ($main_smarty) $main_smarty->assign(str_replace("$","",$row->var_name), $value);
		}elseif ($row->var_method == "define"){
			if($row->var_name != 'table_prefix'){
				$thenewval = $value;
				if($row->var_enclosein == ""){
					if($value == "true"){
						$thenewval = true;
					} elseif($value == "false"){
						$thenewval = false;
					} else {
						$thenewval = $value;
					}
				} else {
					$thenewval = $value;
				}
				define($row->var_name, $thenewval);
				if ($main_smarty) $main_smarty->assign($row->var_name, $thenewval);
			}
		}else{
			if ($main_smarty) $main_smarty->assign($row->var_name, $value);
		}
	}
	$db->cache_queries = false;

// if you have a better way of doing this, please let us know
// other than converting these to a "define" which we will eventually do

define('StorySummary_ContentTruncate', maxSummaryLength);
$URLMethod = $pligg_vars['$URLMethod'] ;
$trackbackURL = $pligg_vars['$trackbackURL'];
$tags_min_pts = $pligg_vars['$tags_min_pts'];
$tags_max_pts = $pligg_vars['$tags_max_pts'];
$tags_words_limit = $pligg_vars['$tags_words_limit'];
$MAIN_SPAM_RULESET = $pligg_vars['$MAIN_SPAM_RULESET'];
$USER_SPAM_RULESET = $pligg_vars['$USER_SPAM_RULESET'];
$FRIENDLY_DOMAINS = $pligg_vars['$FRIENDLY_DOMAINS'];
$SPAM_LOG_BOOK = $pligg_vars['$SPAM_LOG_BOOK'];
$CommentOrder = $pligg_vars['$CommentOrder'];
$anon_karma = $pligg_vars['$anon_karma'];
$page_size = $pligg_vars['$page_size'];
$top_users_size = $pligg_vars['$top_users_size'];
$thetemp = $pligg_vars['$thetemp'];

?>
