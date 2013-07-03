<?php

if(!defined('mnminclude')){header('Location: ../error_404.php');die();}

class Trackback {
	var $id = 0;
	var $author = 0;
	var $link = 0;
	var $type = 'out';
	var $status = 'pendent';
	var $date = false;
	var $modified = false;
	var $url  = '';
	var $title = '';
	var $content = '';
	var $read = false;

	function store() {
		global $db, $current_user;

		if(!is_numeric($this->id)) die();
		if(!$this->date) $this->date=time();
		$trackback_date=$this->date;
		$trackback_author = $this->author;
		$trackback_link = $this->link;
		$trackback_type = $this->type;
		$trackback_status = $this->status;
		$trackback_url = $db->escape(trim($this->url));
		$trackback_title = $db->escape(trim($this->title));
		$trackback_content = $db->escape(trim($this->content));
		if($this->id===0) {
			$db->query("INSERT IGNORE INTO " . table_trackbacks . " (trackback_user_id, trackback_link_id, trackback_type, trackback_date, trackback_status, trackback_url, trackback_title, trackback_content) VALUES ($trackback_author, $trackback_link, '$trackback_type', FROM_UNIXTIME($trackback_date), '$trackback_status', '$trackback_url', '$trackback_title', '$trackback_content')");
			$this->id = $db->insert_id;
		} else {
			$db->query("UPDATE " . table_trackbacks . " set trackback_user_id=$trackback_author, trackback_link_id=$trackback_link, trackback_type='$trackback_type', trackback_date=FROM_UNIXTIME($trackback_date), trackback_status='$trackback_status', trackback_url='$trackback_url', trackback_title='$trackback_title', trackback_content='$trackback_content' WHERE trackback_id=$this->id");
		}
	}
	
	function read() {
		global $db, $current_user;

		// DB 08/01/08
		if(!is_numeric($this->id)) die();
		if(!is_numeric($this->link)) die();
		//$this->link = sanitize($this->link,4);
		/////
		if($this->id == 0 && !empty($this->url) && $this->link > 0) 
			$cond = "trackback_type = '$this->type' AND trackback_link_id = $this->link AND trackback_url = '$this->url'";

		else $cond = "trackback_id = $this->id";
	
		if(($link = $db->get_row("SELECT * FROM " . table_trackbacks . " WHERE $cond"))) {
			$this->id=$link->trackback_id;
			$this->author=$link->trackback_user_id;
			$this->link=$link->trackback_link_id;
			$this->type=$link->trackback_type;
			$this->status=$link->trackback_status;
			$this->url=$link->trackback_url;
			$this->title=$link->trackback_title;
			$this->content=$link->trackback_content;
			// DB 01/08/09
			$this->date=strtotime($link->trackback_date);
			//$date=$link->trackback_date;
			//$this->date=$db->get_var("SELECT UNIX_TIMESTAMP('$date')");
			$this->published_date=strtotime($link->trackback_modified);
			//$date=$link->trackback_modified;
			//$this->modified_date=$db->get_var("SELECT UNIX_TIMESTAMP('$date')");
			/////
			$this->read = true;
			return true;
		}
		$this->read = false;
		return false;
	}

// Send a Trackback
	function send() {
		global $trackbackURL;
        if (empty($this->url))
                return;

        $title = urlencode($this->title);
        $excerpt = urlencode($this->content);
        $blog_name = urlencode($trackbackURL);
        $tb_url = $this->url;
        $url = urlencode(get_permalink($this->link));
        $query_string = "charset=UTF-8&title=$title&url=$url&blog_name=$blog_name&excerpt=$excerpt";
        $trackback_url = parse_url($this->url);
        $http_request  = 'POST ' . $trackback_url['path'] . ($trackback_url['query'] ? '?'.$trackback_url['query'] : '') . " HTTP/1.0\r\n";
        $http_request .= 'Host: '.$trackback_url['host']."\r\n";
        $http_request .= 'Content-Type: application/x-www-form-urlencoded; charset=UTF-8'."\r\n";
        $http_request .= 'Content-Length: '.strlen($query_string)."\r\n";
        $http_request .= "User-Agent: PLG (http://pligg.com) ";
        $http_request .= "\r\n\r\n";
        $http_request .= $query_string;
        if ( '' == $trackback_url['port'] )
                $trackback_url['port'] = 80;
        $fs = @fsockopen($trackback_url['host'], $trackback_url['port'], $errno, $errstr, 5);
		if($fs && ($res=@fputs($fs, $http_request)) ) {
      	@fclose($fs);
			$this->status='ok';
			$this->store();
			return true;	
		}
		$this->status='error';	
		$this->store();
        return $false;
	}
}
?>
