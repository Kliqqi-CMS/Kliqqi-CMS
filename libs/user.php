<?php

if(!defined('mnminclude')){header('Location: ../error_404.php');die();}

class User {
	var $read = false;
	var $id = 0;
	var $username = '';
	var $level = 'normal';
	var $modification = false;
	var $date = false;
	var $pass = '';
	var $email = '';
	var $names = '';
	var $lang = 1;
	var $karma = 10;
	var $public_email = '';
	var $location = '';
	var $occupation = '';
	var $language = '';
	var $url = '';
	var $facebook = '';
	var $twitter = '';
	var $linkedin = '';
	var $googleplus = '';
	var $skype = '';
	var $pinterest = '';
	var $avatar_source = '';
	// For stats
	var $total_votes = 0;
	var $published_votes = 0;
	var $total_links = 0;
	var $published_links = 0;
	var $extra = '';
	

	function User($id=0) {
		if ($id>0) {
			$this->id = $id;
			$this->read();
		}
	}

function Create(){
		global $db, $main_smarty,$the_template,$my_base_url,$my_pligg_base;
		
		if($this->username == ''){return false;}
		if($this->pass == ''){return false;}
		if($this->email == ''){return false;}
		

		if (!user_exists($this->username)) {

			require_once(mnminclude.'check_behind_proxy.php');
			$userip=check_ip_behind_proxy();
			$saltedpass=generateHash($this->pass);
			
			if(pligg_validate()){
				if ($db->query("INSERT IGNORE INTO " . table_users . " (user_login, user_email, user_pass, user_date, user_ip,user_categories) VALUES ('".$this->username."', '".$this->email."', '".$saltedpass."', now(), '".$userip."', '')")) {
				
					$result = $db->get_row("SELECT user_email, user_pass, user_karma, user_lastlogin FROM " . table_users . " WHERE user_login = '".$this->username."'");
					$encode = md5($this->email . $result->user_karma .  $this->username. pligg_hash().$main_smarty->get_config_vars('PLIGG_Visual_Name'));

					$username = $this->username;
					$password = $this->pass;
					
					$my_base_url=$my_base_url;
					$my_pligg_base=$my_pligg_base;
					
					$domain = $main_smarty->get_config_vars('PLIGG_Visual_Name');			
					$validation = my_base_url . my_pligg_base . "/validation.php?code=$encode&uid=".$this->username;
					$str = $main_smarty->get_config_vars('PLIGG_PassEmail_verification_message');
					eval('$str = "'.str_replace('"','\"',$str).'";');
					$message = "$str";

					if(phpnum()>=5)
						require("class.phpmailer5.php");
					else
						require("class.phpmailer4.php");

					$mail = new PHPMailer();
					$mail->From = $main_smarty->get_config_vars('PLIGG_PassEmail_From');
					$mail->FromName = $main_smarty->get_config_vars('PLIGG_PassEmail_Name');
					$mail->AddAddress($this->email);
					$mail->AddReplyTo($main_smarty->get_config_vars('PLIGG_PassEmail_From'));
					$mail->IsHTML(false);
					$mail->Subject = $main_smarty->get_config_vars('PLIGG_PassEmail_Subject_verification');
					$mail->CharSet = 'utf-8';
					$mail->Body = $message;
				
					
					if(!$mail->Send())
					{
						return false;
						exit;
					}
					return true;
				} else {
					return false;
				}
			} else{
			
					if ($db->query("INSERT IGNORE INTO " . table_users . " (user_login, user_email, user_pass, user_date, user_ip, user_lastlogin,user_categories) VALUES ('".$this->username."', '".$this->email."', '".$saltedpass."', now(), '".$userip."', now(),'')")) {
						return true;
					} else {
						return false;
					}
			
			}
		} else {
			die('User already exists');
		}
	}

	function store() {
		global $db, $current_user, $cached_users;

		if(!$this->date) $this->date=time();
		$user_login = $db->escape($this->username);
		$user_level = $this->level;
		$user_karma = $this->karma;
		$user_date = $this->date;
		$user_pass = $db->escape($this->pass);
		$user_email = $db->escape($this->email);
		$user_names = $db->escape($this->names);
		$user_url = $db->escape(htmlentities($this->url));
		$user_public_email = $db->escape($this->public_email);
		$user_location = $db->escape($this->location);
		$user_occupation = $db->escape($this->occupation);
		$user_language = $db->escape($this->language);
		$user_facebook = $db->escape($this->facebook);
		$user_twitter = $db->escape($this->twitter);
		$user_linkedin = $db->escape($this->linkedin);
		$user_googleplus = $db->escape($this->googleplus);
		$user_skype = $db->escape($this->skype);
		$user_pinterest = $db->escape(htmlentities($this->pinterest));
		$user_avatar_source = $db->escape($this->avatar_source);
		if (strlen($user_pass) < 49){
			$saltedpass=generateHash($user_pass);}
		else{
			$saltedpass=$user_pass;}
			
		if($this->id===0) {
			$this->id = $db->insert_id;
		} else {
			// Username is never updated
			$sql = "UPDATE " . table_users . " set user_avatar_source='$user_avatar_source' ";
			$extra_vars = $this->extra;
			if(is_array($extra_vars)){
				foreach($extra_vars as $varname => $varvalue){
					$sql .= ", " . $varname . " = '" . $varvalue . "' ";
				}
			}
			$sql .= " , user_login='$user_login', user_occupation='$user_occupation', user_language='$user_language', user_location='$user_location', public_email='$user_public_email', user_level='$user_level', user_karma=$user_karma, user_date=FROM_UNIXTIME($user_date), user_pass='$saltedpass', user_email='$user_email', user_names='$user_names', user_url='$user_url', user_facebook='$user_facebook', user_twitter='$user_twitter', user_linkedin='$user_linkedin', user_googleplus='$user_googleplus', user_skype='$user_skype', user_pinterest='$user_pinterest' WHERE user_id=$this->id";
			//die($sql);
			$db->query($sql);
			//lets remove the old cached data
			if(array_key_exists($this->id, $cached_users))
			{
				unset($cached_users[$this->id]);
			}
		}
	}
	
	function read($data = "long") {
		// $data = long -- return all user data
		// $data = short -- return just basic info
		global $db, $current_user, $cached_users;

		if($this->id > 0)
		{
			$where = "user_id = $this->id";
		}	
		else if(!empty($this->username))
		{
			$where = "user_login='".$db->escape($this->username)."'";

			// if we only know the users login, check the cache to see if it's 
			// already in there and set $this->id so the code below can find it in the cache.
			foreach($cached_users as $user){
				if($user->user_login == $this->username){$this->id = $user->user_id;}
			}
		}

		if(!empty($where)) {
			
			// this is a simple cache type system
			// when we lookup a user from the DB, store the results in memory
			// in case we need to lookup that user information again
			// good for sites where the content is submitted by the same group of people

			if(isset($cached_users[$this->id])){
				$user = $cached_users[$this->id];
			}else{
				if(!$user = $db->get_row("SELECT  *  FROM " . table_users . " WHERE $where")){return false;}
				
				if($this->id > 0)
				{
					//only cache when the id is provided.
					$cached_users[$this->id] = $user;
				}	
			}

			$this->id = $user->user_id;
			$this->username = $user->user_login;
			$this->level = $user->user_level;
			$this->email = $user->user_email;
			$this->avatar_source = $user->user_avatar_source;
			$this->karma = $user->user_karma;
			// if short, then stop here
			if($data == 'short'){return true;}
			$this->names = $user->user_names;
			$date=$user->user_date;
			$this->date=unixtimestamp($date);
			$date=$user->user_modification;
			$this->modification=unixtimestamp($date);
			$this->pass = $user->user_pass;
			$this->public_email = $user->public_email;
			$this->location = $user->user_location;
			$this->occupation = $user->user_occupation;
			$this->language = $user->user_language;
			$this->url = $user->user_url;
			$this->facebook = $user->user_facebook;
			$this->twitter = $user->user_twitter;
			$this->linkedin = $user->user_linkedin;
			$this->googleplus = $user->user_googleplus;
			$this->skype = $user->user_skype;
			$this->pinterest = $user->user_pinterest;
			$this->read = true;

			$this->extra_field = object_2_array($user, 0, 0);

			return true;
		}
		$this->read = false;
		return false;
	}

	function all_stats($from = false) {
		global $db;
		if (!is_numeric($this->id)) die();

		if ($from !== false) {
			$link_date = "AND link_date > FROM_UNIXTIME($from)";
			$vote_date = "AND vote_date > FROM_UNIXTIME($from)";
			$comment_date = "AND comment_date > FROM_UNIXTIME($from)";
		} else {
			$link_date = "";
			$vote_date = "";
			$comment_date = "";
		}
		if(!$this->read) $this->read();

		$this->total_votes = $db->get_var("SELECT count(*) FROM " . table_votes . "," . table_links . " WHERE link_status != 'discard' AND vote_user_id = $this->id $vote_date AND link_id = vote_link_id");
		$this->published_votes = $db->get_var("SELECT count(*) FROM " . table_votes . "," . table_links . " WHERE vote_user_id = $this->id AND link_id = vote_link_id AND link_status = 'published' AND vote_date < link_published_date $vote_date");
		$this->total_links = $db->get_var("SELECT count(*) FROM " . table_links . " WHERE link_author = $this->id and (link_status='published' OR link_status='new') $link_date");
		$this->published_links = $db->get_var("SELECT count(*) FROM " . table_links . " WHERE link_author = $this->id AND link_status = 'published' $link_date");
		$this->total_comments = $db->get_var("SELECT count(*) FROM " . table_comments . " WHERE comment_status='published' AND comment_user_id = $this->id $comment_date");
		return true;
	}
	
	function fill_smarty($main_smarty, $stats = 1){
		global $db;
		$vars = '';
		check_actions('profile_show', $vars);
		$main_smarty->assign('user_publicemail', $this->public_email);
		$main_smarty->assign('user_location', $this->location);
		$main_smarty->assign('user_occupation', $this->occupation);
		$main_smarty->assign('user_language', $this->language);
		$main_smarty->assign('user_facebook', $this->facebook);
		$main_smarty->assign('user_twitter', $this->twitter);
		$main_smarty->assign('user_linkedin', $this->linkedin);
		$main_smarty->assign('user_googleplus', $this->googleplus);
		$main_smarty->assign('user_skype', $this->skype);
		$main_smarty->assign('user_pinterest', $this->pinterest);
		$main_smarty->assign('user_karma', $this->karma);
		$main_smarty->assign('user_joined', get_date($this->date));
		$main_smarty->assign('user_login', $this->username);
		$main_smarty->assign('user_names', $this->names);
		$main_smarty->assign('user_username', $this->username);
		
		$users = $db->get_results("SELECT user_karma, COUNT(*) FROM ".table_users." WHERE user_level NOT IN ('Spammer') AND user_karma>0 AND (user_login!='anonymous' OR user_lastip) GROUP BY user_karma ORDER BY user_karma DESC",ARRAY_N);
		$ranklist = array();
		$rank = 1;
		if ($users)
		    foreach ($users as $dbuser)
		    {
				$ranklist[$dbuser[0]] = $rank;
				$rank += $dbuser[1];
		    }
		$main_smarty->assign('user_rank', $ranklist[$this->karma]);

/*		global $db;
		$groups = $db->get_results($sql="SELECT * FROM " . table_group_member . "  	
					LEFT JOIN " . table_groups . " ON group_id=member_group_id
					WHERE member_user_id = {$this->id} 
						AND member_status = 'active'
						AND group_status = 'Enable'");
//print $sql;
		for ($i=0; $i<sizeof($groups); $i++)
		    $groups[$i]->link = getmyurl("group_story", $groups[$i]->group_id);
		$main_smarty->assign('user_groups', $groups);
print_r($main_smarty);
*/
		user_group_read($this->id);
			
		if($stats == 1){		
			$this->all_stats();
			$main_smarty->assign('user_total_links', $this->total_links);
			$main_smarty->assign('user_published_links', $this->published_links);
			$main_smarty->assign('user_total_comments', $this->total_comments);
			$main_smarty->assign('user_total_votes', $this->total_votes);
			$main_smarty->assign('user_published_votes', $this->published_votes);
		}
					
		return $main_smarty;
	}

	function getFollowersCount() {
	    global $db;
	    return $db->get_var($sql="SELECT COUNT(*) 
					FROM ".table_friends." 
					LEFT JOIN ".table_users." ON friend_from=user_id 
					WHERE friend_to=$this->id AND friend_from!=$this->id AND user_enabled=1");
	}

	function getFollowingCount() {
	    global $db;
	    return $db->get_var("SELECT COUNT(*) 
					FROM ".table_friends." 
					LEFT JOIN ".table_users." ON friend_to=user_id 
					WHERE friend_from=$this->id AND friend_to!=$this->id AND user_enabled=1");
	}
}

function user_group_read($user_id,$order_by='')
{
	global $db, $main_smarty, $view, $user, $rows, $page_size, $offset;

	if (!is_numeric($user_id)) die();

	if ($order_by == "")
		$order_by = "group_name DESC";
	include_once(mnminclude.'smartyvariables.php');

	$groups = $db->get_results($sql="SELECT * FROM " . table_group_member . "  	
					LEFT JOIN " . table_groups . " ON group_id=member_group_id
					WHERE member_user_id = $user_id 
						AND member_status = 'active'
						AND group_status = 'Enable'
						ORDER BY $order_by");
	if ($groups) {
		foreach($groups as $groupid){
			$group_display .= "<tr><td><a href='".getmyurl("group_story_title", $groupid->group_safename)."'>".$groupid->group_name."</a></td><td style='text-align:center;'>".$groupid->group_members."</td></tr>"; 
		}
		$main_smarty->assign('group_display', $group_display);
	}	
	return true;
}

function killspam($id)
{
	global $db;

	require_once(mnminclude.'link.php');
	require_once(mnminclude.'votes.php');
	require_once(mnminclude.'tags.php');

	$user= $db->get_row('SELECT * FROM ' . table_users ." where user_id=$id");
	if (!$user->user_id) return;
	canIChangeUser($user->user_level);

	$db->query('UPDATE `' . table_users . "` SET user_enabled=0, `user_pass` = '63205e60098a9758101eeff9df0912ccaaca6fca3e50cdce3', user_level = 'Spammer' WHERE `user_id` = $id");
	$results = $db->get_results($sql="SELECT comment_id, comment_link_id FROM `" . table_comments . "` WHERE `comment_user_id` = $id");
	if ($results)
	    foreach ($results as $result)
	    {
		$db->query($sql='UPDATE `' . table_comments . '` SET `comment_status` = "spam" WHERE `comment_id` = "'.$result->comment_id.'"');

	   	$vars = array('comment_id' => $result->comment_id);
	   	check_actions('comment_spam', $vars);

		$link = new Link;
		$link->id=$result->comment_link_id;
		$link->read();

		$link->recalc_comments();
		$link->store();
	    }

	ban_ip($user->user_ip,$user->user_lastip);

	$results = $db->get_results("SELECT * FROM `" . table_groups . "` WHERE group_creator = '$id'");
	if ($results)
	    foreach ($results as $result)
	    {
		$db->query('DELETE FROM `' . table_group_member . '` WHERE member_group_id = '.$result->group_id);
		$db->query('DELETE FROM `' . table_group_shared . '` WHERE share_group_id = '.$result->group_id);
	    }
	$db->query("DELETE FROM `" . table_groups . "` WHERE group_creator = '$id'");

	$results = $db->get_results("SELECT vote_id,vote_link_id FROM `" . table_votes . "` WHERE `vote_user_id` = $id");
	if ($results)
	    foreach ($results as $result)
	    {
		$db->query('DELETE FROM `' . table_votes . '` WHERE `vote_id` = "'.$result->vote_id.'"');
		$link = new Link;
		$link->id=$result->vote_link_id;
		$link->read();

		$vote = new Vote;
		$vote->type='links';
		$vote->link=$result->vote_link_id;

		if(Voting_Method == 1){
			$link->votes=$vote->count();
			$link->reports = $link->count_all_votes("<0");
		} elseif(Voting_Method == 2) {
			$link->votes=$vote->rating();
			$link->votecount=$vote->count();
			$link->reports = $link->count_all_votes("<0");
		}
		elseif(Voting_Method == 3){
			$link->votes=$vote->count();
			$link->karma = $vote->karma();
			$link->reports = $link->count_all_votes("<0");
		}
		$link->store_basic();
		$link->check_should_publish();
	    }

	$results = $db->get_results($sql="SELECT link_id, link_url FROM `" . table_links . "` WHERE `link_author` = $id");
	global $USER_SPAM_RULESET, $FRIENDLY_DOMAINS;
	$filename = mnmpath.$USER_SPAM_RULESET;
	$lines = file($filename,FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
	$approved = file(mnmpath.$FRIENDLY_DOMAINS,FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
	if ($results)
	    foreach ($results as $result)
	    {
			if (preg_match('/:\/\/(www\.)?([^\/]+)(\/|$)/',$result->link_url,$m))
			{
				$domain = strtoupper($m[2]) . "\n";
				if (!in_array($domain,$lines) && !in_array($domain,$approved))
				{
					$lines[] = $domain;
					$changed = 1;
				}
			}
			$vars = array('link_id' => $result->link_id);
			check_actions('story_spam', $vars);
	    }
	if ($changed)
	{
		if (is_writable($filename)) {
		   if ($handle = fopen($filename, 'w')) {
		   	fwrite($handle,join("\n",$lines)); 
			fclose($handle);
		   } 
		}
	}
	$db->query($sql='UPDATE `' . table_links . '` SET `link_status` = "spam" WHERE `link_author` = "'.$id.'"');
	$db->query('DELETE FROM `' . table_saved_links . '` WHERE `saved_user_id` = "'.$id.'"');
	$db->query('DELETE FROM `' . table_trackbacks . '` WHERE `trackback_user_id` = "'.$id.'"');
	$db->query('DELETE FROM `' . table_friends . '` WHERE `friend_id` = "'.$id.'"');
	$db->query('DELETE FROM `' . table_messages . "` WHERE `sender`=$id OR `receiver`=$id");
}		

function canIChangeUser($user_level) {
    // Don't let admins delete other admins and moderators
    $amIadmin = checklevel('admin');

    if (($user_level == 'admin' || $user_level == 'moderator') && !$amIadmin) {
        echo "Access denied";
        die;
    } 
}	
?>