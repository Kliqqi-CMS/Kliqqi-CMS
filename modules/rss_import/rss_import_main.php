<?php

function rss_import_showpage(){
	global $main_smarty, $the_template, $db;

	include_once('config.php');
	include_once(mnminclude.'html1.php');
	include_once(mnminclude.'link.php');
	include_once(mnminclude.'tags.php');
	include_once(mnminclude.'smartyvariables.php');
	
	require_once('class.rssimport.php'); 
	require_once('modules/rss_import/magpierss/rss_fetch.inc');
	define('MAGPIE_CACHE_DIR', 'cache/');
	define('rss_import_export_version', '0.4');
	$smarty = $main_smarty;
	include_once('modules/rss_import/qeip_0_3.php'); 
	
	force_authentication();
	$canIhaveAccess = 0;
	$canIhaveAccess = $canIhaveAccess + checklevel('admin');
		
	// pagename
	define('modulename', 'rss_import');
	$main_smarty->assign('modulename', modulename);

	// breadcrumbs and page title
	$navwhere['text1'] = $smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel');
	$navwhere['link1'] = getmyurl('admin', '');
	$navwhere['text2'] = $smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel_RSSImport');
	$smarty->assign('navbar_where', $navwhere);
	$smarty->assign('posttitle', ' / ' . $smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel_RSSImport'));
	
	define('modulename', 'rss_import'); 
	$main_smarty->assign('modulename', modulename);
	
	// sidebar
	$main_smarty = do_sidebar($main_smarty);


	if($canIhaveAccess == 1){	
	
		$tableexists = checkfortable(table_prefix . 'feeds');
		if (!$tableexists) {
			echo "First Run, Creating Tables<hr />";
			include_once( 'create_feed_tables.php' );
			die("<hr />Errors be damned! We're going to refresh this page now. <br />If you see any errors above please check your error log.<META HTTP-EQUIV='refresh' CONTENT='5'>");
		}
		
		$filename = 'create_feed_tables.php';
		if (file_exists($filename)) {
		  // die("Please delete or rename the file create_feed_tables.php, then refresh this page");
		} 
	
		$smarty->register_function('feedsListFeeds', 'smarty_function_feedsListFeeds');
		$smarty->register_function('feedsListFeedLinks', 'smarty_function_feedsListFeedLinks');
		$smarty->register_function('feedsListFeedFields', 'smarty_function_feedsListFeedFields');
		$smarty->register_function('feedsListPliggLinkFields', 'smarty_function_feedsListPliggLinkFields');
		
		$QEIPA = array('table_name' => table_prefix . 'feeds',  // the name of the table to use
						  'field_name' => 'feed_name',  // the name of the field in the table
						  'key' => 'feed_id');  // a unique identifier for the row
		$smarty->assign('qeip_FeedName', $QEIPA);
	
		$QEIPA = array('table_name' => table_prefix . 'feeds',  // the name of the table to use
						  'field_name' => 'feed_url',  // the name of the field in the table
						  'key' => 'feed_id');  // a unique identifier for the row
		$smarty->assign('qeip_FeedURL', $QEIPA);
	
		$QEIPA = array('table_name' => table_prefix . 'feeds',  // the name of the table to use
						  'field_name' => 'feed_category',  // the name of the field in the table
						  'key' => 'feed_id');  // a unique identifier for the row
		$smarty->assign('qeip_FeedCategory', $QEIPA);
	
		$QEIPA = array('table_name' => table_prefix . 'feeds',  // the name of the table to use
						  'field_name' => 'feed_freq_hours',  // the name of the field in the table
						  'key' => 'feed_id',  // a unique identifier for the row
						  'field_type' => 'number'); // the type of database field we are reading from / writing to
		$smarty->assign('qeip_FeedFreqHours', $QEIPA);
	
		$QEIPA = array('table_name' => table_prefix . 'feeds',  // the name of the table to use
						  'field_name' => 'feed_votes',  // the name of the field in the table
						  'key' => 'feed_id',  // a unique identifier for the row
						  'field_type' => 'number'); // the type of database field we are reading from / writing to
		$smarty->assign('qeip_FeedVotes', $QEIPA);
	
		$QEIPA = array('table_name' => table_prefix . 'feeds',  // the name of the table to use
						  'field_name' => 'feed_item_limit',  // the name of the field in the table
						  'key' => 'feed_id',  // a unique identifier for the row
						  'field_type' => 'number'); // the type of database field we are reading from / writing to
		$smarty->assign('qeip_FeedItemLimit', $QEIPA);
	
		$QEIPA = array('table_name' => table_prefix . 'feeds',  // the name of the table to use
						  'field_name' => 'feed_url_dupe',  // the name of the field in the table
						  'key' => 'feed_id',  // a unique identifier for the row
						  'field_type' => 'number'); // the type of database field we are reading from / writing to
		$smarty->assign('qeip_FeedURLDupe', $QEIPA);
	
		$QEIPA = array('table_name' => table_prefix . 'feeds',  // the name of the table to use
						  'field_name' => 'feed_title_dupe',  // the name of the field in the table
						  'key' => 'feed_id',  // a unique identifier for the row
						  'field_type' => 'number'); // the type of database field we are reading from / writing to
		$smarty->assign('qeip_FeedTitleDupe', $QEIPA);
	
		$QEIPA = array('table_name' => table_prefix . 'feeds',  // the name of the table to use
						  'field_name' => 'feed_submitter',  // the name of the field in the table
						  'key' => 'feed_id',  // a unique identifier for the row
						  'field_type' => 'number'); // the type of database field we are reading from / writing to
		$smarty->assign('qeip_FeedSubmitter', $QEIPA);
	
		$QEIPA = array('table_name' => table_prefix . 'feed_link',  // the name of the table to use
						  'field_name' => 'feed_field',  // the name of the field in the table
						  'key' => 'feed_link_id',  // a unique identifier for the row
						  'eip_type' => 'select');  // the type of EIP field to show 
		$smarty->assign('qeip_FeedLink_FeedField', $QEIPA);
	
		$QEIPA = array('table_name' => table_prefix . 'feed_link',  // the name of the table to use
						  'field_name' => 'pligg_field',  // the name of the field in the table
						  'key' => 'feed_link_id',  // a unique identifier for the row
						  'eip_type' => 'select');  // the type of EIP field to show 
		$smarty->assign('qeip_FeedLink_PliggField', $QEIPA);
	
		
		// feed oldest first
		$QEIPA = array('table_name' => table_prefix . 'feeds',  // the name of the table to use
						  'field_name' => 'feed_last_item_first',  // the name of the field in the table
						  'key' => 'feed_id');  // a unique identifier for the row
		$smarty->assign('qeip_FeedLastItemFirst', $QEIPA);
	
		// feed random vote
		$QEIPA = array('table_name' => table_prefix . 'feeds',  // the name of the table to use
						  'field_name' => 'feed_random_vote_enable',  // the name of the field in the table
						  'key' => 'feed_id');  // a unique identifier for the row
		$smarty->assign('qeip_FeedRandomVoteEnable', $QEIPA);
	
		// feed random vote min
		$QEIPA = array('table_name' => table_prefix . 'feeds',  // the name of the table to use
						  'field_name' => 'feed_random_vote_min',  // the name of the field in the table
						  'key' => 'feed_id',  // a unique identifier for the row
						  'field_type' => 'number'); // the type of database field we are reading from / writing to
		$smarty->assign('qeip_FeedRandomVotesMin', $QEIPA);

		// feed random vote max
		$QEIPA = array('table_name' => table_prefix . 'feeds',  // the name of the table to use
						  'field_name' => 'feed_random_vote_max',  // the name of the field in the table
						  'key' => 'feed_id',  // a unique identifier for the row
						  'field_type' => 'number'); // the type of database field we are reading from / writing to
		$smarty->assign('qeip_FeedRandomVotesMax', $QEIPA);


		
		$QEIP = new QuickEIP();	
		
		
		if(!isset($_REQUEST['action'])){
		
			$smarty->assign('tpl_center', rss_import_tpl_path . 'admin_rss_center');
			$main_smarty->display($template_dir . '/admin/admin.tpl');	
			echo $QEIP->ShowOnloadJS();
		}else{
	
			if($_REQUEST['action'] == "addnewfieldlink"){
				$RSSImport=new RSSImport;
				$RSSImport->FeedLinkId = $_REQUEST['FeedLinkId'];
				$RSSImport->new_field_link();
				redirect('module.php?module=rss_import&action=editfeed&feed_id='.$_REQUEST['FeedLinkId']);
			}		
	
			if($_REQUEST['action'] == "dropfieldlink"){
				$RSSImport=new RSSImport;
				$RSSImport->FeedLinkId=$_REQUEST['FeedLinkId'];
				$RSSImport->drop_field_link();
				redirect('module.php?module=rss_import');
			}		
	
			if($_REQUEST['action'] == "addnewfeed"){
				$RSSImport=new RSSImport;
				$RSSImport->FeedName="New Feed";
				$RSSImport->new_feed();
				redirect('module.php?module=rss_import');
			}		
	
			if($_REQUEST['action'] == "dropfeed"){
				$RSSImport=new RSSImport;
				$RSSImport->FeedId=$_REQUEST['feed_id'];
				$RSSImport->drop_feed();
				redirect('module.php?module=rss_import');
			}		

			if($_REQUEST['action'] == "save"){
				echo $QEIP->save_field($smarty);
			}		

			if($_REQUEST['action'] == "examinefeed"){
				$RSSImport=new RSSImport;
				$RSSImport->FeedId=$_REQUEST['feed_id'];
				$RSSImport->read_feed();
				$rss = fetch_rss($RSSImport->FeedURL);
				$z = $rss->items[0];
				if($z){
					echo 'First item in the feed.<hr />';
					print_r_html($z);
					echo '<hr />Feed dump.<hr />';
					print_r_html($rss);
				} else {
					echo '<hr />There are no items in this feed<hr />';
				}

			}
			
			if($_REQUEST['action'] == "editfeed"){
				$RSSImport=new RSSImport;
				$RSSImport->FeedId=$_REQUEST['feed_id'];
				$smarty->assign('tpl_center', rss_import_tpl_path . 'admin_rss_center2');
				$main_smarty->display($template_dir . '/admin/admin.tpl');	
			}

			if($_REQUEST['action'] == "exportfeed"){
				echo 'copy all the text in the box<br />';
				echo '<textarea rows=10 cols=70>' . serialize_feed($_REQUEST['feed_id']) . '</textarea>';
				echo '<br /><br /><a href = "module.php?module=rss_import">return to the rss importer</a>';
			}	

			if($_REQUEST['action'] == "importprebuiltfeed_go"){
				$feed = stripslashes($_REQUEST['prebuiltfeed']);

				if(strpos($feed, '://') < 10){					
					$r = new HTTPRequest($feed);
					$feed = $r->DownloadToString();
				}
									
				if(import_prebuilt($feed)){
					redirect(my_pligg_base . '/module.php?module=rss_import');
				} else {
					// what do we do if error?					
				}
			}	

		}	
		//echo $QEIP->ShowOnloadJS();
	}	
	


}

function import_prebuilt($serialized_feed)
{
	global $db;
	
	$x = unserialize($serialized_feed);
				
				if($x['version'] == rss_import_export_version){
		foreach($x['feeds'] as $myfeed){
	
			$feed_main = $myfeed['main'];
					
					unset($feed_main->feed_last_check);
					$feed_main->feed_submitter = 1;

		$last_feed_id = $db->get_var('SELECT `feed_id` FROM `' . table_prefix . 'feeds` order by `feed_id` DESC limit 1');

					$feed_main->feed_id = $last_feed_id + 1;

		$sql = "Insert Into `" . table_prefix . "feeds` (`feed_id`, `feed_name`, `feed_url`, `feed_freq_hours`, `feed_votes`";
					$sql .= ", `feed_submitter`, `feed_item_limit`, `feed_category`, `feed_url_dupe`, `feed_title_dupe`";
			$sql .= ", `feed_status`, `feed_last_item_first`) VALUES (";
					
					$sql .= $feed_main->feed_id . ", '" . $feed_main->feed_name . "', '"  . $feed_main->feed_url . "', ";  
					$sql .= $feed_main->feed_freq_hours . ", " . $feed_main->feed_votes . ", " . $feed_main->feed_submitter;
					$sql .= ", " . $feed_main->feed_item_limit . ", " . $feed_main->feed_category . ", ";
					$sql .= $feed_main->feed_url_dupe . ", " . $feed_main->feed_title_dupe . ", '" . $feed_main->feed_status;
			$sql .= "', '" . $feed_main->feed_last_item_first . "');";
					$db->query($sql);
					
			foreach($myfeed['links'] as $field_link){
				$sql = "insert into `" . table_prefix . "feed_link` (`feed_id`, `feed_field`, `pligg_field`)"; 
				$sql .= " VALUES (" . $feed_main->feed_id . ", '" . $field_link->feed_field;
				$sql .= "', '" . $field_link->pligg_field . "');";
				$db->query($sql);
			}
		
		return true;	
		}			
				} else {
					echo 'incompatible version';
		return false;
				}
			}	


function serialize_feed($feed_id)
{
	global $db;
	$feed_main = $db->get_row("select * from " . table_prefix . "feeds where feed_id = " . $feed_id);
	unset($feed_main->feed_last_check);
	$feed_links = $db->get_results("select * from " . table_prefix . "feed_link where feed_id = " . $feed_id);
	$x = array('version'=> rss_import_export_version, 'main' => $feed_main, 'links' => $feed_links);
	$y = array('version'=> rss_import_export_version, 'feeds' => array($x));
	return serialize($y);
}

function rss_import_do_import($insideTpl = true){
	global $main_smarty, $the_template;

	include_once('config.php');
	include_once(mnminclude.'html1.php');
	include_once(mnminclude.'link.php');
	include_once(mnminclude.'tags.php');
	include_once(mnminclude.'smartyvariables.php');
	
	require_once('class.rssimport.php'); 
	require_once('modules/rss_import/magpierss/rss_fetch.inc');
	define('MAGPIE_CACHE_DIR', 'cache/');
	
	// breadcrumbs and page title
	$navwhere['text1'] = $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel');
	$navwhere['link1'] = getmyurl('admin', '');
	$navwhere['text2'] = $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel_RSSImport');
	$navwhere['link2'] = my_pligg_base . '/module.php?module=rss_import';
	$navwhere['text3'] = $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel_RSSImport_Feeds');
	$main_smarty->assign('navbar_where', $navwhere);
	$main_smarty->assign('posttitle', ' / ' . $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel_RSSImport'));
	
	define('modulename', 'rss_import'); 
	$main_smarty->assign('modulename', modulename);
	
	// show the template
	if ($insideTpl == true){
	$main_smarty->assign('tpl_center', rss_import_tpl_path . 'import_fields_center');
	$main_smarty->display($template_dir . '/admin/admin.tpl');	
	} else {
		$main_smarty->display(rss_import_tpl_path_2 . 'import_fields_center.tpl');		
	}
}


// FEED FUNCTIONS

function smarty_function_feedsListFeeds($params, &$smarty)
{
	// get a list of feeds in the database and put them into smarty varliable $params['varname']
	global $db;
	$smarty->assign($params['varname'], $db->get_col("select feed_id from " . table_prefix . "feeds"));
}	

function smarty_function_feedsListFeedLinks($params, &$smarty)
{
	// get a list of all field_links where `feed_id` = $feed_id and put them into the smarty variable $params['varname']
	global $db;
	$smarty->assign($params['varname'], $db->get_col("select feed_link_id from " . table_prefix . "feed_link where feed_id = " . $params['feedid']));
}	

function smarty_function_feedsListFeedFields($params, &$smarty)
{
	// get a list of fields in the RSS feed and put them into the smarty variable "eip_select" for the EIP selectbox to use
	global $db;
	$smarty->assign('eip_select', "");
	//$url = "http://localhost/nik.xml";
	$feed_url = $db->get_var("select feed_url from " . table_prefix . "feeds where feed_id = " . $params['feed_id']);
	$rss = fetch_rss($feed_url);
	$x = sizeof($rss->items[0]);
	$z = $rss->items[0];

	$TheTextToReturn = "	options: {";
	
	$count = -1;
	foreach ($z as $item => $key) {
		if ($count < $x){
			if (is_array($z[$item])) {
				foreach ($z[$item] as $item2 => $key) {
					if($count > 0){$TheTextToReturn .= ", ";}
					$TheTextToReturn .= $item . "_ne_st_ed_" . $item2 . ": '" . $item . " : " . $item2 . "'";				
					$count = $count + 1;
				}				
			} else {				
				if($count > -1){$TheTextToReturn .= ", ";}
				$TheTextToReturn .= $item . ": '" . $item . "'";				
				$count = $count + 1;
			}
		}
	}
	$TheTextToReturn .= "}";

	$smarty->assign('eip_select', $TheTextToReturn);
	
}	

function get_pligg_fields(){
	global $db;
	$sql = "select * from " . table_prefix . "feed_import_fields;";
	$pligg_fields = $db->get_results($sql);
	return $pligg_fields;
}
	
function smarty_function_feedsListPliggLinkFields($params, &$smarty){
	// get a list of pligg fields and put them into the smarty variable "eip_select" for the EIP selectbox to use
	$Pligg_Fields = get_pligg_fields();
	$TheTextToReturn = "	options: {";
	$Count = 0;
	if($Pligg_Fields){
		foreach ($Pligg_Fields as $Field) {

			if($count > 0){$TheTextToReturn .= ", ";}
			$TheTextToReturn .= $Field->field_name . ": '" . $Field->field_name . "'";				
			$count = $count + 1;
			
		}
	}
	
	$TheTextToReturn .= "}";
	
	$smarty->assign('eip_select', $TheTextToReturn);
	
}	

function checkfortable($table)
{
	$result = mysql_query('select * from ' . $table);
	if (!$result) {
		return false;
	}
	return true;
}

function redirect($url, $msg){
	// due to some servers not redirecting the way we would like we
	// have this function to handle that

	global $main_smarty;
	
	if(strpos($_SERVER['SERVER_SOFTWARE'], "IIS") && strpos(php_sapi_name(), "cgi") >= 0){
		header("Expires: " . gmdate("r", time()-3600));
		// use js to try to redirect
		echo '<SCRIPT LANGUAGE="JavaScript">window.location="' . $url . '";</script>';
		// in case the js fails show a link
		echo $main_smarty->get_config_vars($msg) . '<a href = "'.$url.'">' . $main_smarty->get_config_vars('PLIGG_Visual_IIS_Continue') . '</a>';
	} else {
		header('Location: ' . $url);
	}
}


function print_r_html($data,$return_data=false)
{
    $data = print_r($data,true);
    $data = str_replace( " ","&nbsp;", $data);
    $data = str_replace( "\r\n","<br>\r\n", $data);
    $data = str_replace( "\r","<br>\r", $data);
    $data = str_replace( "\n","<br>\n", $data);

    if (!$return_data)
        echo $data;   
    else
        return $data;
}
?>