<?php

if(!defined('mnminclude')){header('Location: ../error_404.php');die();}

class Vote {
	var $type='';
	var $user=-1;
	var $value=1;
	var $karma=0;
	var $link;
	var $ip='';
	
	function Vote() {
		return;
	}
	
	function sum(){
		global $db;
		if(!is_numeric($this->link)) die();

		$where = "vote_type='$this->type' AND vote_link_id=$this->link AND vote_value $value";
		$sum=$db->get_var("SELECT sum(vote_value) FROM " . table_votes . " WHERE $where");
		$sum = $this->adjust($sum);
		return $sum;
	}
	
	function adjust($vote_sum){
		// if not factoring karma, and just using a straight + / - voting system, we'll divide by 10.
		return $vote_sum / 10;
	}

	function reports($value="< 0") {
		global $db;
		if(!is_numeric($this->link)) die();

		$where = "vote_type='$this->type' AND vote_link_id=$this->link AND vote_value $value";
		if($this->user !== -1) {
			$where .= " AND vote_user_id=$this->user";
		}
		// DB 11/10/08
		if($this->user <= 0 || !empty($this->ip)) {	
		/////
			if ($this->ip == '') {
				require_once(mnminclude.'check_behind_proxy.php');
				$this->ip=check_ip_behind_proxy();
			}
			$where .= " AND vote_ip='$this->ip'";
		}
		$count=$db->get_var("SELECT count(*) FROM " . table_votes . " WHERE $where");
		return $count;
	}

		
	
	
	
	function user_list_all_votes($cacheit = TRUE) {
		global $db, $cached_votes, $current_user;

		$cache_results = '';
		$where = '';

		$get_data = FALSE;
		// by default we won't touch the DB
		// we'll check the cache first, and 
		// access the DB only if needed.

		$link_copy = $this->link;
		// just make a copy
		
		$cache_user = $current_user->user_id;
		// the 'user' that voted. by default its the user
		// passed to this class

	
		// if no user is set and no ip is set, check the ip
		// address and set it as the $cache_user (anonymous user)
		if($cache_user == 0 || !empty($this->ip)) {
			if ($this->ip == '') {
				require_once(mnminclude.'check_behind_proxy.php');
				$this->ip=check_ip_behind_proxy();
				$cache_user = $this->ip;
			}
		}
		

		// if we sent an array of link_id's
		if(is_array($this->link)){
			$where = " vote_type='$this->type' AND (";

			// $i is just to count how many linkid's we're going to get from the db
			$i = 0;
			foreach ($this->link as $linkid){
				if (!isset($cached_votes[$linkid][$cache_user])) {
				  // if this linkid isn't already cached, add it to the SQL query
					if ($i > 0){$where .= ' OR ';}
					$where .= ' vote_link_id = ' . $linkid;
					$get_data = TRUE;
					$i = $i + 1;
				} else {
				  // if this linkid is already cached, use it
					$cache_results[] = $cached_votes[$linkid][$cache_user];
				}
			}
			$where .= ") ";

		} else {
		  // we didnt send an array, we just send 1 link
			if (!isset($cached_votes[$this->link][$cache_user])) {
				// we dont have the data cached so we need to get it
				$get_data = TRUE;

				$where = " vote_type='$this->type' AND vote_link_id=$this->link";
			}
		}

		if($cache_user == 0 || !empty($this->ip)) {
			$where .= " AND vote_user_id=0 AND vote_ip='$this->ip'";
		} else { 
			$where .= " AND vote_user_id=$cache_user";
		}
		
		if ($get_data == TRUE) {
			$sql = $db->get_results("SELECT * FROM " . table_votes . " WHERE $where");

			if ($cacheit == TRUE){
				if ($sql){
					foreach ($sql as $vote_row){
						$cached_votes[$vote_row->vote_link_id][$vote_row->vote_user_id] = $vote_row;
						
						// link_copy is a 'copy' of $link
						// for each linkid that we just found, unset (delete) it from
						// the link_copy array. we will then be left with linkid of
						// links that were searched for but the user never voted
						// or reported. please see additional comments below.
						if(is_array($link_copy)){
							foreach($link_copy as $key => $value){
								if ($value == $vote_row->vote_link_id){
								  // delete from the array
									unset($link_copy[$key]);
								}
							}
						}
						
					}
				}
			}
			
			if (is_array($link_copy)){
				foreach($link_copy as $linkid){
				  // for each linkid in link_copy give it a dummy value
				  // of array(0). then when we process the cached_votes and we
				  // find one with a value of array(0) we know that this link
				  // was searched for but the user didnt vote for it (no results)
				  
				  // if we don't do this, then the linkid won't appear in the results
				  // list because the user never voted for it, so we will end up
				  // seaching mysql for it again, and again finding no results, wasting
				  // time
				  
					$cached_votes[$linkid][$cache_user] = array(0);
				}
			}

			return $sql;		
		} else {
			// in the cache so return the cached results only if $this->link
			// is NOT an array. if it is an array then we're just doing
			// some caching work and not expecting any results
			if(!is_array($this->link)){
			return array($cached_votes[$this->link][$cache_user]);
			}
		}
	}


	function listall() {
		global $db;
		$where = "vote_type='$this->type' AND vote_link_id=$this->link";
		$sql=$db->get_results("SELECT * FROM " . table_votes . " WHERE $where");
		return $sql;
	}
	
	function count($value="> 0") {
		global $db;
		$where = "vote_type='$this->type' AND vote_link_id=$this->link AND vote_value $value";
		if($this->user !== -1) {
			$where .= " AND vote_user_id=$this->user";
		}
		if($this->user == 0 || !empty($this->ip)) {
			if ($this->ip == '') {
				require_once(mnminclude.'check_behind_proxy.php');
				$this->ip=check_ip_behind_proxy();
			}
			$where .= " AND vote_ip='$this->ip'";
		}
		$sql = "SELECT count(*) FROM " . table_votes . " WHERE $where";
		$count=$db->get_var($sql);
		return $count;
	}

	function karma() {
		global $db;
		$where = "vote_type='$this->type' AND vote_link_id=$this->link AND vote_karma>0";
		if($this->user !== -1) {
			$where .= " AND vote_user_id=$this->user";
		}
		if($this->user == 0 || !empty($this->ip)) {
			if ($this->ip == '') {
				require_once(mnminclude.'check_behind_proxy.php');
				$this->ip=check_ip_behind_proxy();
			}
			$where .= " AND vote_ip='$this->ip'";
		}
		$sql = "SELECT SUM(vote_karma) FROM " . table_votes . " WHERE $where";
		return $db->get_var($sql)+0;
	}

	function count_all($value="> 0") {
		global $db;
		$where = "vote_type='$this->type' AND vote_link_id=$this->link AND vote_value $value";
		$sql = "SELECT count(*) FROM " . table_votes . " WHERE $where";
		$count=$db->get_var($sql);
		return $count;
	}

	function total_count($value="> 0") {
		global $db;
		$where = "vote_type='$this->type' AND vote_link_id=$this->link AND vote_value $value";
		if($this->user !== -1) {
			$where .= " AND vote_user_id=$this->user";
		}
		if($this->user == 0 || !empty($this->ip)) {
			if ($this->ip == '') {
				require_once(mnminclude.'check_behind_proxy.php');
				$this->ip=check_ip_behind_proxy();
			}
			$where .= " AND vote_ip='$this->ip'";
		}
		$count=$db->get_var("SELECT vote_value FROM " . table_votes . " WHERE $where");
		return $count;
	}

	function rating($value="> 0") {
		global $db;
		$where = "vote_type='$this->type' AND vote_link_id=$this->link AND vote_value $value";
		$sql = "SELECT avg(vote_value) FROM " . table_votes . " WHERE $where";
		$rating=$db->get_var($sql);
		return $rating;
	}

	function anycount($value="<> 0") {
		global $db;
		$where = "vote_type='$this->type' AND vote_link_id=$this->link AND vote_value $value";
		if($this->user !== -1) {
			$where .= " AND vote_user_id=$this->user";
		}
		if($this->user == 0 || !empty($this->ip)) {
			if ($this->ip == '') {
				require_once(mnminclude.'check_behind_proxy.php');
				$this->ip=check_ip_behind_proxy();
			}
			$where .= " AND vote_ip='$this->ip'";
		}
		$count=$db->get_var("SELECT count(*) FROM " . table_votes . " WHERE $where");
		return $count;
	}

	function insert() {
		global $db, $the_template;
		if(empty($this->ip)) {
			require_once(mnminclude.'check_behind_proxy.php');
			$this->ip=check_ip_behind_proxy();
		}
		$this->value=intval($this->value);
		$sql="INSERT IGNORE INTO " . table_votes . " (vote_type, vote_user_id, vote_link_id, vote_value, vote_ip, vote_karma) VALUES ('$this->type', $this->user, $this->link, $this->value, '$this->ip', '{$this->karma}')";
		
		$vars = array('vote'=>&$this);
		check_actions('vote_post_insert', $vars);

		return $db->query($sql);
	}
	
	function remove()	{
		global $db, $the_template;
		if(empty($this->ip)) {
			require_once(mnminclude.'check_behind_proxy.php');
			$this->ip=check_ip_behind_proxy();
		}
		$this->value=intval($this->value);
		if(Voting_Method == 2){
			$sql="Select vote_id from " . table_votes . " where vote_type = '$this->type' and vote_user_id = $this->user and vote_link_id = $this->link ".($this->user > 0 ? "" : "AND vote_ip = '$this->ip'" )." LIMIT 1";
		} else {
			$sql="Select vote_id from " . table_votes . " where vote_type = '$this->type' and vote_user_id = $this->user and vote_link_id = $this->link and vote_value = $this->value AND vote_ip = '$this->ip' LIMIT 1";
		}
		$the_vote = $db->get_var($sql);
		if($the_vote){
			$sql = "Delete from "	. table_votes . " where vote_id = " . $the_vote;
			return $db->query($sql);
		}	
	
	}
}
?>