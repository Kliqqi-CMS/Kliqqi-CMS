<?php
/*
    XML Sitemaps module for Pligg
    Copyright (C) 2007-2008  Secasiu Mihai - http://patchlog.com

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License along
    with this program; if not, write to the Free Software Foundation, Inc.,
    51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
*/

function xml_sitemaps_show_sitemap(){
	ob_end_clean();
	header("Content-type: text/xml");
	if(isset($_GET['i']))
	{
		if(is_numeric($_GET['i'])) create_sitemap_links($_GET['i'],XmlSitemaps_Links_per_sitemap);
		else if ($_GET['i']=="main") create_sitemap_main();
		else if (preg_match('/pages(\d+)/',$_GET['i'],$m))  create_sitemap_pages($m[1],XmlSitemaps_Links_per_sitemap);
		else if (preg_match('/users(\d+)/',$_GET['i'],$m))  create_sitemap_users($m[1],XmlSitemaps_Links_per_sitemap);
		else if (preg_match('/groups(\d+)/',$_GET['i'],$m)) create_sitemap_groups($m[1],XmlSitemaps_Links_per_sitemap);
	} else create_sitemaps_index(XmlSitemaps_Links_per_sitemap);
}

//
// XML sitemap index file
//
function create_sitemaps_index($max_rec)
{
	global $db,$my_base_url,$my_pligg_base;
	$nr=0;

	if (sitemap_header("index",true)) return true;

	// Stories
        $sql = "select link_modified AS date from ".table_links." where link_status='published' OR link_status='new' order by link_modified DESC";
	sitemap_index_body($sql,'',$max_rec);

	// Static Pages
        $sql = "SELECT link_modified AS date FROM ".table_links." WHERE link_status='page' order by link_modified DESC";
	sitemap_index_body($sql,'pages',$max_rec);

	// User profiles
        $sql = "SELECT user_modification AS date FROM ".table_users." WHERE user_enabled order by user_modification DESC";
	sitemap_index_body($sql,'users',$max_rec);

	// Groups
        $sql = "SELECT group_date AS date FROM ".table_groups." WHERE group_status='Enable' ORDER BY group_date DESC";
	sitemap_index_body($sql,'groups',$max_rec);

	// Main pages
	echo "<sitemap>\n";
	if(XmlSitemaps_friendly_url){
	        echo "<loc>$my_base_url$my_pligg_base/sitemap-main.xml</loc>\n";
	}else{
		echo "<loc>$my_base_url$my_pligg_base/module.php?module=xml_sitemaps_show_sitemap&amp;i=main</loc>\n";
	}
        echo "</sitemap>";

	sitemap_footer("index",true);
}

//
// User profiles list
//
function create_sitemap_users($index,$max_rec)
{
	if (sitemap_header("users$index")) return true;

	$sql = "SELECT * FROM " . table_users . " WHERE user_enabled ORDER BY user_modification DESC";
	sitemap_body($sql,'user_modification',"user",'user_login',0.9,$index,$max_rec);

	sitemap_footer("users$index");
}

//
// Groups list
//
function create_sitemap_groups($index,$max_rec)
{
	if (sitemap_header("groups$index")) return true;

	$sql = "SELECT * FROM " . table_groups . " WHERE group_status='Enable' ORDER BY group_date DESC";
	sitemap_body($sql,'group_date',"group_story_title",'group_safename',1,$index,$max_rec);

	sitemap_footer("groups$index");
}

//
// Pligg static pages
//
function create_sitemap_pages($index,$max_rec)
{
	if (sitemap_header("pages$index")) return true;

	$sql = "SELECT * FROM ".table_links." WHERE link_status='page' order by link_modified DESC";
	sitemap_body($sql,'link_modified',"page",'link_title_url',0.0001,$index,$max_rec);

	sitemap_footer("pages$index");
}

//
// Pligg stories
//
function create_sitemap_links($index,$max_rec)
{
	global $db;

	if (sitemap_header($index)) return true;

	$sql = "SELECT link_id FROM ".table_links." WHERE link_status='new' OR link_status='published' ORDER BY link_modified DESC LIMIT ".($index*$max_rec).",$max_rec";
	$link = new Link;
	$links = $db->get_col($sql);
	if ($links) {
		foreach($links as $link_id) {
			$link->id=$link_id;
			$link->read();
			$freq = freq_calc($link->modified);
			echo "<url>\n";
			echo "<loc>".getmyFullurl("storyURL", urlencode($link->category_safe_name($link->category)), urlencode($link->title_url), $link->id)."</loc>\n";
			//c / v  * 30   + vo /v * 10 +  ( 100 / acum-mod  ) * 60  
			$v=(time()-$link->date)/60;
			$pri=max(0.0001,(( $link->comments /$v ) * 30  + ( $link->votes * 10  / $v ) + ( 100 / max(100,time()-$link->modified) )  * 60 )/ 100 );
			echo "<lastmod>";
			echo my_format_date($link->modified);
			echo "</lastmod>\n";
			echo "<changefreq>$freq</changefreq>\n";
			echo "<priority>".$pri."</priority>\n";
			echo "</url>\n";
		}
	}	

	sitemap_footer($index);
}

//
// Pligg main pages
//
function create_sitemap_main()
{
	global $db,$my_base_url,$my_pligg_base,$URLMethod;

	if (sitemap_header("main")) return true;

	sitemap_add_page('index',   "SELECT MAX(UNIX_TIMESTAMP(link_modified)) FROM ".table_links." WHERE link_status='published'");
	sitemap_add_page('new',"SELECT MAX(UNIX_TIMESTAMP(link_modified)) FROM ".table_links." WHERE link_status='new'");
	sitemap_add_page('groups',  "SELECT MAX(UNIX_TIMESTAMP(group_date)) FROM ".table_groups." WHERE group_status='Enable'");
	sitemap_add_page('tagcloud',"SELECT MAX(UNIX_TIMESTAMP(tag_date)) FROM ".table_tags);
	sitemap_add_page('live',    "SELECT MAX(UNIX_TIMESTAMP(link_date)) FROM ".table_links." WHERE link_status='new' OR link_status='published'");
	sitemap_add_page('topusers',"SELECT MAX(UNIX_TIMESTAMP(user_modification)) FROM " . table_users . " WHERE user_enabled");
	
	create_entry(mktime(0,0,0,1,1,date('Y')),getmyFullurl('submit'));
	create_entry(mktime(0,0,0,1,1,date('Y')),getmyFullurl('advancedsearch'));

	//////////////////////...........categories.................
	$sql = "SELECT category_id,category_name,category_safe_name FROM ".table_categories." WHERE category_enabled=1 AND category_name!='new category'";
	$cat = $db->get_results($sql);
	$maxtime = 0;
	foreach ($cat as $i){
		$sql = "SELECT UNIX_TIMESTAMP(link_published_date),link_id FROM ".table_links." WHERE link_category=".$i->category_id." AND link_status='published' ORDER BY link_published_date DESC, link_date DESC LIMIT 1";
		$res = $db->get_col($sql);
		if (isset($res[0])){
			$path = getmyFullurl('maincategory',urlencode($i->category_safe_name));
			create_entry($res[0],$path);
			if ($res[0] > $maxtime) $maxtime = $res[0];
		}
		$sql = "SELECT UNIX_TIMESTAMP(link_date) FROM ".table_links." WHERE link_category=".$i->category_id." AND link_status='new' ORDER BY link_date DESC LIMIT 1";	
		$res = $db->get_col($sql);
                if (isset($res[0])){
			$path = getmyFullurl('newcategory',urlencode($i->category_safe_name));
			create_entry($res[0],$path);
                }
	}
	// rssfeeds
	create_entry($maxtime,"$my_base_url$my_pligg_base/rssfeeds.php");
	
 	$vars = '';
	check_actions('xml_sitemaps_main', $vars);

	sitemap_footer("main");
}

//
// Ping search engines
//
function xml_sitemaps_sites_ping(){
	global $my_base_url,$my_pligg_base;
	$res= "";

	if (XmlSitemaps_friendly_url) 
		$Url = "$my_base_url$my_pligg_base/sitemapindex.xml";
	else {
		$Url = "$my_base_url$my_pligg_base/modules.php?module=xml_sitemaps_show_sitemap";
		$Url = urlencode($Url);
	}
//	if (XmlSitemaps_use_cache && ($s=stat('cache/sitemapindex.xml')) && time()-$s['mtime']<XmlSitemaps_cache_ttl){
//		return true;
//	}
	if (XmlSitemaps_ping_google)
		sitemap_call_url("http://www.google.com/webmasters/sitemaps/ping?sitemap=".$Url);

	if (XmlSitemaps_ping_ask)
		sitemap_call_url("http://submissions.ask.com/ping?sitemap=".$Url);

	if (XmlSitemaps_ping_yahoo)
		sitemap_call_url("http://search.yahooapis.com/SiteExplorerService/V1/updateNotification?appid=".Xml_Sitemaps_yahoo_key."&url=".$Url);
}

//
// Call given URL
//
function sitemap_call_url($pingUrl)
{
	$pingres=fopen($pingUrl,'r');
	while ($res=fread($pingres,8192)){	
//		echo $res."\n";
	}
	fclose($pingres);
}

//
// Create xml for sitemap index file using given SQL
// $sql should be 'SELECT <modification_datetime_field> AS date FROM xxx WHERE yyy'
// $name is a filename
//
function sitemap_index_body($sql,$name,$max_rec)
{
	global $db,$my_base_url,$my_pligg_base;

	// Calculate total data size using given query
        $db->query($sql1=str_ireplace('select ','SELECT SQL_CALC_FOUND_ROWS ',$sql)." LIMIT 0,1");
        $res = $db->get_var("SELECT FOUND_ROWS()");

	// Separate into pages if needed
        if ($res > $max_rec)
	    $nr = ceil($res/$max_rec)-1;
	else
	    $nr = 0;
	for ($i=$nr; $i>=0; $i--)
	{
		// Get last modification timestamp for next part of the data
		$r=$db->get_var($sql1="SELECT MAX(UNIX_TIMESTAMP(l.date)) FROM ($sql LIMIT ".$i*$max_rec.",$max_rec ) l");
		echo "<sitemap>\n";
		if (XmlSitemaps_friendly_url) 
			echo "<loc>$my_base_url$my_pligg_base/sitemap-$name$i.xml</loc>\n";
		else 
			echo "<loc>$my_base_url$my_pligg_base/module.php?module=xml_sitemaps_show_sitemap&amp;i=$name$i</loc>\n";
		echo "<lastmod>";
		echo my_format_date($r);
		echo "</lastmod>";
		echo "</sitemap>";

	}		
}

//
// Create xml for any sitemap file based on given SQL data query
//
function sitemap_body($sql, $datefield, $urlname, $urlfield, $pri, $index, $max_rec)
{
	global $db;

	$results = $db->get_results($sql." LIMIT ".($index*$max_rec).",$max_rec");
	if ($results) 
	{
		foreach($results as $result) {
			$timestamp = strtotime($result->$datefield);
			$freq = freq_calc($timestamp);
			echo "<url>\n";
			echo "<loc>".getmyFullurl($urlname, $result->$urlfield)."</loc>\n";
			echo "<lastmod>";
			echo my_format_date($timestamp);
			echo "</lastmod>\n";
			echo "<changefreq>$freq</changefreq>\n";
			echo "<priority>".$pri."</priority>\n";
			echo "</url>\n";
		}
	}	
}

//
// Create an entry for given pligg URL specified by $name, depending of data last modification
// $sql should be 'SELECT MAX(UNIX_TIMESTAMP(<modification_datetime_field)) FROM xxx'
//
function sitemap_add_page($name,$sql)
{
	global $db;

        $res = $db->get_var($sql);
        if ($res) create_entry($res,getmyFullurl($name));
}

//
// Create XML header for all files or return it from a cache
// $isindex==true for sitemap index page
//
function sitemap_header($name,$isindex)
{
	if(XmlSitemaps_use_cache){
		$icf="cache/sitemap-$name.xml";
		if(file_exists($icf) && ($s=stat($icf)) && time()-$s['mtime']<XmlSitemaps_cache_ttl){
			echo file_get_contents($icf);
			return true;			
		}
		ob_start();
	}

	echo '<?xml version="1.0" encoding="UTF-8"?>'."\n";
	if ($isindex)
	    echo "<sitemapindex xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";
	else
       	    echo '<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/09/sitemap.xsd"     xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n";
}

//
// Create XML footer for all files and put xml to the cache if needed
// $isindex==true for sitemap index page
//
function sitemap_footer($name,$isindex)
{
	if ($isindex)
	    echo '</sitemapindex>';
	else
	    echo '</urlset>';

	if(XmlSitemaps_use_cache){
		$icf="cache/sitemap-$name.xml";
		$ret=ob_get_contents();
		ob_end_flush();
		file_put_contents($icf,$ret);
	}
}

function create_entry($m_time,$path){
	$freq = freq_calc($m_time);
        echo "<url>\n";
        echo "<loc>$path</loc>";
        echo "<lastmod>";
	echo my_format_date($m_time);
	echo "</lastmod>\n";
        echo "<changefreq>$freq</changefreq>\n";
        echo "</url>\n";
}

//
// Calculate update frequency from given last modification timestamp
//
function freq_calc($d){
	$freq = time()-$d;
	if ($freq<3600) $freq = "hourly";
        elseif ($freq<86400) $freq = "daily";
        else if ($freq<604800) $freq = "weekly";
        else if($freq<2678400) $freq = "monthly";
        else if($freq<32140800) $freq = "yearly";
        else $freq = "Never";
	return $freq;
}

function my_format_date($mtime)
{

	$ret=date('Y-m-d\TH:i:s',$mtime);
	$ret.=preg_replace('/(\+|\-)([0-9]{2})([0-9]{2})/','$1$2:$3',date('O',$mtime));
	return $ret;
}

?>
