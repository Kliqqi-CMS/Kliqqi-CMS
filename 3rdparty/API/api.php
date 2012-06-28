<?php
	/*
	############### About  ###################
	Script name : Pligg API (mini)
	Version : 0.1 
	Developer : Thawatchai Fhaipolsan (powerpc)
	Email : inside3d at hotmail.com
	Website : http://www.jum.name
	Forum : http://forum.articles-host.com
	Download Pligg API website at http://api.jum.name
	Release date : 27/09/08
	*/

/* REMOVE TO ACTIVATE

	$version = '0.1';
	include_once '../../config.php';
	include_once '../../settings.php';
	include_once '../../libs/dbconnect.php';

	mysql_connect(EZSQL_DB_HOST,EZSQL_DB_USER,EZSQL_DB_PASSWORD);
	mysql_select_db(EZSQL_DB_NAME);
	
	// API Configuration
	// Submit links status configuration
	// 1 'discard'
	// 2 'queued' 
	// 3 'published'
	$status = 2; // queued or upcomming
	$autovote = 1; // 0 = no vote, 1 = auto vote
	$filter = 1; // 0 = not filter (fast), 1 = filter (slow)
	// End API Configuration
	
	
	$username = sanitize(trim($_REQUEST['username']), 3);
	$password = sanitize(trim($_REQUEST['password']), 3);
	$fn = sanitize(trim($_REQUEST['fn']), 3); // login, submit, list , version, ping
	$category = sanitize(trim($_REQUEST['category']), 3); 	// category id
	$url = sanitize(trim($_REQUEST['url']), 3); 			// http://www.domain.com
	$title = sanitize(trim($_REQUEST['title']), 3); 		// Title of story
	$content = sanitize(trim($_REQUEST['content']), 3); 	// Content to submit
	$tags = sanitize(trim($_REQUEST['tags']), 3); 			// tag,tag,tag
	
	if($fn == 'ping'){
		echo "Active";
	}else if($fn == 'version'){
		echo "Pligg API Version ".$version;
	}else if($fn == 'login'){
		if($username == '' || $password == ''){
			echo "Input Error!";
			exit();
		}else{
			echo authen($username,$password);
		}
	}else if($fn == 'submit' || $fn == 'post' || $fn == 'new'){
		if($category == '' || strlen($url) < 12 || strlen($title) < 10 || strlen($content) < 10 || $tags == ''){
			echo "Input Error!, emptry or less";
			exit();
		}
		if($filter){
			if(filterBadWords($content) || filterBadWords($title)){
				echo "Input Error!, bad word(s) found";
				exit();
			}else if(!is_valid_url($url)){
				echo "Invalid URL!";
				exit();
			}
		}
		
		echo submitnew($username,$password,$status,$category,$url,$title,$content,$tags,$autovote);
		
	}else if($fn == 'list' || $fn == 'cate' || $fn == 'category'){
		echo categorylist($username,$password);
	}else{
		$gogo = 'http://api.jum.name/?action=check&ref='.curPageURL();
		if(is_valid_url($gogo))
			echo "Pligg API Version $version <br>Powered by <a href=\"http://api.jum.name\">Jum.name</a>";
		else
			echo "Connection error!, <br>Try again <a href=\"".$_SERVER['PHP_SELF']."\">here</a>.";
	}
	
	function curPageURL() {
		 $pageURL = 'http';
		 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
		 	$pageURL .= "://";
		 if ($_SERVER["SERVER_PORT"] != "80") {
		  	$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
		 } else {
		  	$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		 }
		 return $pageURL;
	}

	function sanitize($var, $santype = 1){
		if ($santype == 1) {return strip_tags($var);}
		if ($santype == 2) {return htmlentities(strip_tags($var),ENT_QUOTES,'UTF-8');}
		if ($santype == 3) {
			if (!get_magic_quotes_gpc()) {
				return addslashes(htmlentities(strip_tags($var),ENT_QUOTES,'UTF-8'));
			} 
			else {
			   return htmlentities(strip_tags($var),ENT_QUOTES,'UTF-8');
			}
		}
	}

	function generateHash($plainText, $salt = null)
	{
		if ($salt === null)
		{
			$salt = substr(md5(uniqid(rand(), true)), 0, 9);
		}
		else
		{
			$salt = substr($salt, 0, 9);
		}
	
		return $salt . sha1($salt . $plainText);
	} 

	function is_valid_url ( $url )
	{
		$url = @parse_url($url);

		if ( ! $url) {
			return false;
		}

		$url = array_map('trim', $url);
		$url['port'] = (!isset($url['port'])) ? 80 : (int)$url['port'];
		$path = (isset($url['path'])) ? $url['path'] : '';

		if ($path == '')
		{
			$path = '/';
		}

		$path .= ( isset ( $url['query'] ) ) ? "?$url[query]" : '';

		if ( isset ( $url['host'] ) AND $url['host'] != gethostbyname ( $url['host'] ) )
		{
			if ( PHP_VERSION >= 5 )
			{
				//$headers = get_headers("$url[scheme]://$url[host]:$url[port]$path");
				$ccc = "$url[scheme]://$url[host]:$url[port]$path";
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $ccc);
				curl_setopt($ch, CURLOPT_HEADER, 1);
				curl_setopt($ch, CURLOPT_NOBODY, 1);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				$headers = curl_exec ($ch);
				curl_close ($ch);
			}
			else
			{
				$fp = fsockopen($url['host'], $url['port'], $errno, $errstr, 30);

				if ( ! $fp )
				{
					return false;
				}
				fputs($fp, "HEAD $path HTTP/1.1\r\nHost: $url[host]\r\n\r\n");
				$headers = fread ( $fp, 128 );
				fclose ( $fp );
			}
			$headers = ( is_array ( $headers ) ) ? implode ( "\n", $headers ) : $headers;
			return ( bool ) preg_match ( '#^HTTP/.*\s+[(200|301|302)]+\s#i', $headers );
		}
		return false;
	}

	function filterBadWords($str) {
	  $badFlag = 0;
	  $badWords = array("fuck","sex","anal","ass","asshole","boob","blowjobs","blowjob","bondage","boobs","cock","cum","cumshot","cumshots","dick","dicks","dildo","doggystyle","dogging","erotica","exhibtionism","facial","facials","fetish","fisting","flikker","footjob","foursome","foursomes","gangbang","gay","gloryhole","groupsex","gspot","handjob","handjobs","hardcore","homosexual","homosexuals","interracial","jackoff","lesbian","lesbians","lolita","milf","naked","nigger","nude","nudes","orgasm","orgasms","orgies","orgy","penis","porn","pussies","pussy","rape","raped","rapes","sadism","sadist","softcore","sperm","strap-on","suck","sucking","sucks","threesome","tit","tits","topless","tranny","transsexual","upskirt","vagina","vaginas","vibrator","xxx","adult","hentai");
	  
	  foreach ($badWords as $badWord) {
		if(!$badWord) continue; 
		else {
		  $regexp = "/\b".$badWord."\b/i";
		  if(preg_match($regexp,$str)) $badFlag = 1;
		}
	  }
		if(preg_match("/\[url/",$str)) $badFlag = 1;
	  return $badFlag;
	}

	function authen($username, $password){ // return 0 on error or return user id
		$sql = "select user_pass from ".table_prefix."users where user_login = '$username'";
		$rs = mysql_query($sql) or die(mysql_error());
		$row = mysql_fetch_array($rs);
		$row[user_pass];
		if($row[user_pass] == '') return 0;
		
		$saltedpass = generateHash($password,$row[user_pass]);  
		
		$sql = "select user_id from ".table_prefix."users where user_login = '$username' and user_pass = '".substr($saltedpass,-49)."'";
		$rs = mysql_query($sql) or die(mysql_error());
		$row2 = mysql_fetch_array($rs);
		if($row2[user_id] == '') return 0;
		else return $row2[user_id];
	}
	
	function cutText($string, $length) {
		if($length<strlen($string)){
			while ($string{$length} != " ") {
				$length--;
			}
			return substr($string, 0, $length);
		}else return $string;
	}
		
	function submitnew($username,$password,$status,$category,$url,$title,$content,$tags,$autovote){
		$uid = authen($username,$password);
		if($uid == 0){
			echo "Login fail!";
			exit();
		}
		
		$sql = "select link_id from ".table_prefix."links where link_url like '$url'";
		$rx = mysql_query($sql) or die(mysql_error());
		$n = mysql_num_rows($rx);
		if($n > 0){
			echo "Duplicate Story!!!";
			exit();
		}
		
		if($category == '') $category = 0; // all category
		
		if($status == 1)
			$link_status = 'discard'; // do not show
		else if ($status == 2)
			$link_status = 'queued'; // upconmming
		else if ($status == 3)
			$link_status = 'published'; // show
		else
			$link_status = 'discard'; // spam

		$randkey = rand(10000,10000000);
		$dt = date('Y-m-d H:i:s',time());
		
		$mtitle = ereg_replace("[^A-Za-z0-9 ]", "", $title);
		if($mtitle == ''){
			echo "Submit error!, English title only.";
			exit();
		}
		
		
		$mtitle = strtolower($mtitle);
		$mtitle = str_replace(" ","-",$mtitle);
		
		$sql = "select link_id from ".table_prefix."links where link_title like '$title'";
		$rm = mysql_query($sql) or die(mysql_error());
		$m = mysql_num_rows($rm);
		if($m > 0){
			$mtitle = $mtitle."-".$m;
		}
		
		$scontent = cutText($content,150);
				
		$sql = "insert into ".table_prefix."links(link_author, link_status, link_randkey, link_votes, link_karma, link_modified, link_date, link_published_date, link_category, link_url, link_url_title, link_title, link_title_url, link_content, link_summary, link_tags) values($uid, '$link_status', $randkey, 1, 1, '$dt', '$dt', '1999-11-30 13:00:00', $category, '$url', '$title', '$title', '$mtitle', '$content', '$scontent', '$tags' )";
		$rs = mysql_query($sql) or die(mysql_error());
		if($rs){
			$lastid = mysql_insert_id();
			$dt = date('Y-m-d H:i:s',time());
			$tag = explode(",",$tags);
			for($i=0;$i<sizeof($tag);$i++){
				// insert tag tables
				$sql = "insert into ".table_prefix."tags(tag_link_id, tag_date, tag_words) values($lastid, '$dt', '".$tag[$i]."')";
				mysql_query($sql) or die(mysql_error());
			}
			// update totals table
			$sql = "update ".table_prefix."totals set total = total + 1 where name = '".$link_status."'";
			mysql_query($sql) or die(mysql_error());
			
			// Default Vote
			$dt = date('Y-m-d H:i:s',time());
			$ip = $_SERVER['REMOTE_ADDR'];
			$sql = "insert into ".table_prefix."votes(vote_date, vote_link_id, vote_user_id, vote_value, vote_ip) values('$dt', $lastid, $uid, 10, '$ip')";
			mysql_query($sql) or die(mysql_error());
			
			// count links
			$sql = "select link_id from ".table_prefix."links";
			$rr = mysql_query($sql) or die(mysql_error());
			$num = mysql_num_rows($rr);
			
			// Random Vote
			if($autovote && $num > 1){
				while(1){
					srand((double) microtime() * 1000000); 
					$lucky = rand(1,$num);
					
					$sql = "select link_id from ".table_prefix."links where link_status <> 'discard' and link_id != $lastid and link_id = ".$lucky;
					$ru = mysql_query($sql) or die(mysql_error());
					$u = mysql_num_rows($ru);
					if($u > 0)	break;
					
				}
				
				$sql = "update ".table_prefix."links set link_votes = link_votes + 1 where link_status <> 'discard' and link_id = ".$lucky;
				mysql_query($sql) or die(mysql_error());
				
				$dt = date('Y-m-d H:i:s',time());
				//$ip = $_SERVER['REMOTE_ADDR'];
				$sql = "insert into ".table_prefix."votes(vote_date, vote_link_id, vote_user_id, vote_value, vote_ip) values('$dt', $lucky, $uid, 10, '$ip')";
				mysql_query($sql) or die(mysql_error());
			} // end auto vote
			
			echo "Submit complete!<br>";
		}else{
			echo "Submit fail!<br>";
		}
	}
	
	function categorylist($username, $password){
		if(authen($username, $password) == 0){
			echo "Login fail!";
			exit();
		}else{
			header("Content-type: text/xml");
			
			$sql = "select category_id, category_safe_name from ".table_prefix."categories where category_enabled = 1";
			$rs = mysql_query($sql) or die(mysql_error());
			$xml_output  = "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>\n";
			$xml_output  .= "<categorylist>\n";
			while($row = mysql_fetch_array($rs)){
				$xml_output  .= " <cate><id>". $row[category_id]."</id>\n<name>".$row[category_safe_name]."</name></cate>\n";
			}
			$xml_output  .= "</categorylist>\n";
			echo $xml_output;
		}
	}
 REMOVE TO ACTIVATE */
?>