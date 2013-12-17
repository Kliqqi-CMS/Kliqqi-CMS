<?php
date_default_timezone_set('UTC');

if(!defined('mnminclude')){header('Location: ../error_404.php');die();}

function mailer_start(){
	// Usually a module will define Pligg_Mailer
	// If defined, then include call the function thats starts (includes) it

	if(defined('Pligg_Mailer') && function_exists(Pligg_Mailer . '_mailer_start')){
		call_user_func(Pligg_Mailer . '_mailer_start');
	} else {
		include_once(mnminclude.'mailer.php');
	}
}

function check_if_table_exists($table) {
	// checks to see if a table in the database exists
	$result = mysql_query('select * from ' . $table);
	if (!$result) {
		return false;
	}
	return true;
}

function pligg_version(){
	// returns the version of Pligg that's installed 
	$ver = get_misc_data('pligg_version');
	return $ver;
}

function pligg_hash(){
	// returns the version of Pligg that's installed 
	$hash = get_misc_data('hash');
	return $hash;
}


function pligg_validate(){
	// returns the value for register validation 
	$vars = array('validate' => misc_validate);
	check_actions('pligg_validate', $vars);

	return $vars['validate'];
}


function get_misc_data($name){
	// returns data from the misc_data table
	global $db;
	$sql = "SELECT `data` FROM `" . table_misc_data . "` WHERE `name` = '" . $db->escape($name) . "';";
	$var = $db->get_var($sql);
	return $var;
}

function misc_data_update($name, $data){
	// updates a row in the misc_data table
	global $db;

	$name = $db->escape($name);
	$sql = "SELECT `data` FROM `" . table_misc_data . "` WHERE `name` = '" . $name . "';";
	if(count($db->get_results($sql)) == 0){
		$sql = "INSERT INTO `" . table_misc_data . "` (`data`, `name`) VALUES ('" . $data . "', '" . $name . "');";
	} else {	
		$sql = "UPDATE `" . table_misc_data . "` SET `data` = '" . $data . "' WHERE `name` = '$name';";
	}
	$db->query($sql); 
}

function safeAddSlashes($string) {
	// if function get_magic_quotes_gpc exists, returns a string with backslashes before characters that need to be quoted in database queries etc
//	if (get_magic_quotes_gpc()) {
//		return $string;
//	} 
//	else {
		return addslashes($string);
//	}
}

function unixtimestamp($timestamp){
	if(strlen($timestamp) == 14) {
		$time = substr($timestamp,0,4)."-".substr($timestamp,4,2)."-".substr($timestamp,6,2);
		$time .= " ";
		$time .=  substr($timestamp,8,2).":".substr($timestamp,10,2).":".substr($timestamp,12,2);
		return strtotime($time);
	} else {
		if(strlen($timestamp) == 0) {
			return 0;
		} else {
			return strtotime($timestamp);
		}
	}
}

function user_exists($username) {
	// checks to see if user already exists in database
	global $db;
	$username = $db->escape($username);
	$res=$db->get_var("SELECT count(*) FROM " . table_users . " WHERE user_login='$username'");
	if ($res>0) return true;
	return false;
}

function email_exists($email) {
	// checks to see if email already exists in database
	global $db;
	$email = $db->escape($email);
	$res=$db->get_var("SELECT count(*) FROM " . table_users . " WHERE user_email='$email'");
	if ($res>0) return $res;
	return false;
}

function check_email($email) {
	// checks to see if email is valid
	return preg_match('/^[a-zA-Z0-9!#\\$%&\'\\*\\+\\-\\/=\\?\\^_`\\{\\|\\}~\\.]+@[a-zA-Z0-9_\\-\\.]+\.[a-zA-Z]{2,4}$/', $email);

}

function check_email_address($email) {
  //from http://www.ilovejackdaniels.com/php/email-address-validation/
  // First, we check that there's one @ symbol, and that the lengths are right
  if (!preg_match('/^[^@]{1,64}@[^@]{1,255}$/', $email)) {
    // Email invalid because wrong number of characters in one section, or wrong number of @ symbols.
    return false;
  }
  // Split it into sections to make life easier
  $email_array = explode("@", $email);
  $local_array = explode(".", $email_array[0]);
  for ($i = 0; $i < sizeof($local_array); $i++) {
     if (!preg_match('/^(([A-Za-z0-9!#$%&\'*+\/=?^_`{|}~-][A-Za-z0-9!#$%&\'*+\/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$/', $local_array[$i])) {
      return false;
    }
  }  
  if (!preg_match('/^\[?[0-9\.]+\]?$/', $email_array[1])) { // Check if domain is IP. If not, it should be valid domain name
    $domain_array = explode(".", $email_array[1]);
    if (sizeof($domain_array) < 2) {
        return false; // Not enough parts to domain
    }
    for ($i = 0; $i < sizeof($domain_array); $i++) {
      if (!preg_match('/^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))/', $domain_array[$i])) {
        return false;
      }
    }
  }
  return true;
}

function txt_time_diff($from, $now=0){
	global $main_smarty;

	if (empty($from))
        	return "No date provided"; 
	
	$txt = '';
	if($now==0) $now = time();

	$diff=$now-$from;
	if ($diff < 0)
	{
		$diff = -$diff;
		$txt  = '-';
	}
	$days=intval($diff/86400);
	$diff=$diff%86400;
	$hours=intval($diff/3600);
	$diff=$diff%3600;
	$minutes=intval($diff/60);

	if($days>1) $txt  .= " $days ".$main_smarty->get_config_vars('PLIGG_Visual_Story_Times_Days');
	else if ($days==1) $txt  .= " $days ".$main_smarty->get_config_vars('PLIGG_Visual_Story_Times_Day');

	if($days < 2){
		if($hours>1) $txt .= " $hours ".$main_smarty->get_config_vars('PLIGG_Visual_Story_Times_Hours');
		else if ($hours==1) $txt  .= " $hours ".$main_smarty->get_config_vars('PLIGG_Visual_Story_Times_Hour');
	
		if($hours < 3){
			if($minutes>1) $txt .= " $minutes ".$main_smarty->get_config_vars('PLIGG_Visual_Story_Times_Minutes');
			else if ($minutes==1) $txt  .= " $minutes ".$main_smarty->get_config_vars('PLIGG_Visual_Story_Times_Minute');
		}
	}
	
	if($txt=='') $txt = ' '. $main_smarty->get_config_vars('PLIGG_Visual_Story_Times_FewSeconds') . ' ';
	return $txt;
}

function txt_shorter($string, $len=80) {
	// shorten a string to 80 characters
	if (strlen($string) > $len)
		$string = substr($string, 0, $len-3) . "...";
	return $string;
}

function save_text_to_html($string) {
	$string = strip_tags(trim($string));
	$string= htmlspecialchars($string);
//	$string= text_to_html($string);
	$string = preg_replace("/[\r\n]{2,}/", "<br /><br />\n", $string);
	return $string;
}

function text_to_html($string) {
	return preg_replace('/([hf][tps]{2,4}:\/\/[^ \t\n\r]+[^ .\t,\n\r\(\)"\'])/', '<a href="$1">$1</a>', $string);
}

function check_integer($which) {
	// checks to make sure it's an integer greater than 0
	if(isset($_REQUEST[$which])){
		if (intval($_REQUEST[$which])>0) {
			return intval($_REQUEST[$which]);
		} else {
			return false;
		}
	}
	return false;
}

function check_string($which) {
	if (!empty($_REQUEST[$which])) {
		return intval($_REQUEST[$which]);
	} else {
		return false;
	}
}

function get_current_page() {
	if(($var=check_integer('page'))) {
		return $var;
	} else {
		return 1;
	}
}


function get_date($epoch) {
	// get date in the format year-month-day
    return date("Y-m-d", $epoch);
}

function get_base_url($url){
	// get base of URL. For example, get_base_url will return www.pligg.com if the URL was www.pligg.com/support/
   $req = $url;
  
   $pos = strpos($req, '://');
   $protocol = strtolower(substr($req, 0, $pos));
  
   $req = substr($req, $pos+3);
   $pos = strpos($req, '/');
   if($pos === false)
	   $pos = strlen($req);
   $host = substr($req, 0, $pos);
	
	return $host;
}


function get_permalink($id) {
	return getmyFullurl("story", $id);
}

function get_trackback($id) {
	return getmyurl("trackback", $id);
}

function checklevel($levl){
	global $current_user;
	if(isset($current_user->user_level)){
		if ($current_user->user_level == $levl)
		{
			return 1;
		}
	}
}


function makeUrlFriendly($output, $isPage=false) {
	global $db;

	if(function_exists('utils_makeUrlFriendly')) {
		$output = utils_makeUrlFriendly($output);
	}
	if ($isPage===true) return $output;
   
	// check to see if the story title already exists. If so, add an integer to the end of the title
	$n = $db->get_var("SELECT COUNT(*) FROM " . table_links . " WHERE link_title_url like '$output%'" .
				($isPage > 0 ? " AND link_id!=$isPage" : ''));
	if ($n > 0)
		return $output . '-' . ($n+1);
	else
		return $output;
}

function utils_makeUrlFriendly($output)
{
	if ($output == '') return $input;

	//$input = remove_error_creating_chars($input);
	$output = utf8_substr($output, 0, 240);
	$output = utf8_strtolower($output);

	if (file_exists(mnmpath.'languages/translit.txt'))
	{
      		$translations = parse_ini_file(mnmpath.'languages/translit.txt');
  		$output = strtr($output, $translations);
	} 
		
	$output = preg_replace("/\s/e" , "_" , $output); 	// Replace spaces with underscores
	$output = str_replace("_", "-", $output); 	
	$output = str_replace("&amp;", "", $output); 	 
	$output = str_replace("__", "_", $output); 	 
	$output = str_replace("---", "-", $output); 	 
	$output = str_replace("/", "", $output);
	$output = str_replace("\\", "", $output);
	$output = str_replace("'", "", $output); 	 
	$output = str_replace(",", "", $output); 	 
	$output = str_replace(";", "", $output); 	 
	$output = str_replace(":", "", $output); 	 
	$output = str_replace(".", "-", $output); 	 
	$output = str_replace("?", "", $output); 	 
	$output = str_replace("=", "-", $output); 	 
	$output = str_replace("+", "", $output); 	 
	$output = str_replace("$", "", $output); 	 
	$output = str_replace("&", "", $output); 	 
	$output = str_replace("!", "", $output); 	 
	$output = str_replace(">>", "-", $output); 	 
	$output = str_replace(">", "-", $output); 	 
	$output = str_replace("<<", "-", $output); 	 
	$output = str_replace("<", "-", $output); 	 
	$output = str_replace("*", "", $output); 	 
	$output = str_replace(")", "", $output); 	 
	$output = str_replace("(", "", $output);
	$output = str_replace("[", "", $output);
	$output = str_replace("]", "", $output);
	$output = str_replace("^", "", $output);
	$output = str_replace("%", "", $output);
//	$output = str_replace("»", "-", $output);
//	$output = str_replace("|", "", $output);
	$output = str_replace("#", "", $output);
	$output = str_replace("@", "", $output);
	$output = str_replace("`", "", $output);
//	$output = str_replace("”", "", $output);
//	$output = str_replace("“", "", $output);
	$output = str_replace("\"", "", $output);
	$output = str_replace("--", "-", $output);
	return $output;
}


// function makeCategoryFriendly has been moved to admin_categories.php

function remove_error_creating_chars($chars) { 
	$replace=array( 
	'Á' => 'A',
	'Å' => 'A',
	'Ä' => 'A',
	'ä' => 'a',
	'á' => 'a',
	'à' => 'a',
	'â' => 'a',
	'ã' => 'a',
	'å' => 'a',
	'Æ' => 'ae',
	'æ' => 'ae',
	'ç' => 'c',
	'Ç' => 'C',
	'é' => 'e',
	'È' => 'E',
	'É' => 'E',
	'Ë' => 'E',
	'ë' => 'e',
	'Ì' => 'I', 
	'ì' => 'i', 
	'Í' => 'I',
	'í' => 'i',
	'Ï' => 'I',
	'ï' => 'i',
	'¼' => '',
	'¾' => '',
	'¿' => '',
	'ñ' => 'n',
	'Ñ' => 'N',
	'Ò' => 'O',
	'ò' => 'o',
	'Ö' => 'O',
	'Õ' => 'O',
	'Ó' => 'O',
	'ô' => 'o',
	'ó' => 'o',
	'õ' => 'o',
	'ö' => 'o',
	'Š' => 's',
	'š' => 's',
	'ß' => 'ss',
	'Û' => 'U',
	'Ú' => 'U',
	'Ü' => 'U',
	'û' => 'u',
	'ú' => 'u',
	'ü' => 'u',
	'Ý' => 'Y',
	'ý' => 'y',
	'Ÿ' => 'Y',
	'ÿ' => 'y',
	'Ž' => 'Z', 
	'ž' => 'z', 
	'€' => ''
	);

	foreach ($replace as $key => $value) {
		$chars = str_replace($key, $value, $chars );
	}
	return $chars;
}

function loghack($page, $extradata, $silent=false){
	// This function will be used for logging hacking attempts.
	// you'd also want IP Address
	// - date / time
	// email or log to file
	if($silent == false){
		die("Hacking attempt on ". $page);
	}
}

function checkforfield($fieldname, $table) {
	// checks to see if field exists in table
	$result = mysql_query('select * from ' . $table . ' LIMIT 1');
	if (!$result) {
		echo "<HR />ERROR! The table " . $table . " is missing! Are you sure you should be doing an upgrade?<HR />";
		return true;
	}
	$i = 0;
	while ($i < mysql_num_fields($result)) {
	   $meta = mysql_fetch_field($result, $i);
	   if (!$meta) {
		   echo "No information available<br />\n";
	   }
	   else {
			if(strtolower($meta->name) == strtolower($fieldname)){
				return true;
			}
	   }
	   $i++;
	}
	return false;
}

function checkforindex($indexname, $table) {
	// checks to see if field exists in table
	$result = mysql_query('SHOW INDEX from ' . $table);
	if (!$result) {
		echo "<HR />ERROR! The table " . $table . " is missing! Are you sure you should be doing an upgrade?<HR />";
		return true;
	}
	while ($row = mysql_fetch_array($result))
	    if(strtolower($row['Key_name']) == strtolower($indexname))
		return true;
	return false;
}

function object_2_array($result, $cur_depth = 0, $depth_limit = 1000) {
	// $cur_depth and $depth_limit is used for php 4 only
	// prevents the function from doing extra checking to see if
	// it should 'explore' the object further. saves a few cpu cycles

	// using this because (array)$user will not work in php 4
	$array = array();
	if(isset($result)){
		foreach ($result as $key=>$value) {
			if ($cur_depth < $depth_limit && is_object($value)) {
				$array[$key]=object_2_array($value, $cur_depth + 1, $depth_limit);
			}
			elseif ($cur_depth < $depth_limit && is_array($value)) {
				$array[$key]=object_2_array($value, $cur_depth + 1, $depth_limit);
			}
			else {
				$array[$key]=$value;
			}
		}
	}
	return $array;
} 

function phpnum() {
	// returns the php version number
	$version = explode('.', phpversion());
	return (int) $version[0];
}
?>
