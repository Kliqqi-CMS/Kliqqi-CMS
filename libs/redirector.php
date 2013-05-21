<?php

if(!defined('mnminclude')){header('Location: ../error_404.php');die();}

class redirector {

	// this class handles redirects
	// this is for things like renaming a story
	// renaming will change the URL structure
	// this will allow the old URL to redirect to a NEW

	var $old_url = '';
	var $new_url = '';
	
	function redirector($old_url){
		$this->check_old($old_url);
	}

	function check_old($old_url){
		global $db;
		
		// check for redirects
		// DB 08/04/08
		$url = sanitize($old_url,4);
		/////
		$url = substr($url, strlen(my_pligg_base), 255);
		$sql = 'SELECT * FROM `' . table_redirects . '` WHERE `redirect_old` = "' . $url . '" LIMIT 1;';
		//echo $sql;
		$redirs = $db->get_row($sql);
		
		if($redirs){
			header( "HTTP/1.1 301 Moved Permanently" );
			header('Location: ' . my_pligg_base . $redirs->redirect_new);
		}	
	
	}

}
?>
