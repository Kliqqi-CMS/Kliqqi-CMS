<?php
// The source code packaged with this file is Free Software, Copyright (C) 2005 by
// Ricardo Galli <gallir at uib dot es>.
// It's licensed under the AFFERO GENERAL PUBLIC LICENSE unless stated otherwise.
// You can get copies of the licenses here:
// 		http://www.affero.org/oagpl.html
// AFFERO GENERAL PUBLIC LICENSE is also included in the file called "COPYING".

if(!defined('mnminclude')){header('Location: ../404error.php');die();}

class Friend {
	var $friend = "";

	function remove($friend)
	{
		global $db,$current_user;
		if (!is_numeric($friend)) die();

		$sql = "Delete from " . table_friends . " where friend_from = " . $current_user->user_id . " and friend_to = $friend;";
		//echo $sql;
		$db->query($sql);

		$friend_status = $this->get_friend_status($friend);
		if ($friend_status){die("there was an error");}
		
	}
	
	function add($friend)
	{
		global $db, $current_user;
		if (!is_numeric($friend)) die();
		
		if ($current_user->user_id == 0) {
        echo "<span class='success' style='border:solid1px#269900;padding:2px2px2px2px'>Please <a href=" .my_base_url.my_pligg_base. "/login.php?return=/user.php?login=god&amp;view=addfriend>login</a></span><br/>";
        return;
        }
		
		$friend_status = $this->get_friend_status($friend);
		if (!$friend_status){
			//echo "INSERT INTO " . table_friends . " (friend_from, friend_to) values ($current_user->user_id, $friend);";
			$db->query("INSERT IGNORE INTO " . table_friends . " (friend_from, friend_to) values (" . $current_user->user_id . ", " . $friend . ");");

			$friend_status = $this->get_friend_status($friend);
			if (!$friend_status){die("there was an error");}

		}
	}
	
	function get_friend_list($user_id)
	{	
		// returns an array of people you've added as a friend
		global $db, $current_user;
		//echo "SELECT " . table_users . ".user_login FROM " . table_friends . " INNER JOIN " . table_users . " ON friends.friend_to = " . table_users . ".user_id WHERE (((friends.friend_from)=$current_user->user_id));";
		$friends = $db->get_results("SELECT " . table_users . ".user_login, " . table_users . ".user_avatar_source, " . table_users . ".user_email, " . table_users . ".user_id FROM " . table_friends . " INNER JOIN " . table_users . " ON " . table_friends . ".friend_to = " . table_users . ".user_id WHERE (((" . table_friends . ".friend_from)= " . $user_id . "));",ARRAY_A);
		return $friends;

	}

	function get_friend_list_2()
	{
		// returns an array of people who have added you as a friend
		global $db, $current_user;
		$friends = $db->get_results("SELECT " . table_users . ".user_login, " . table_users . ".user_avatar_source, " . table_users . ".user_email, " . table_users . ".user_id FROM " . table_friends . " INNER JOIN " . table_users . " ON " . table_friends . ".friend_from = " . table_users . ".user_id WHERE ((" . table_friends . ".friend_to)= " . $current_user->user_id . ")",ARRAY_A);
		return $friends;
	}

	function get_friend_status($friend)
	{
		global $db, $current_user;
		if (!is_numeric($friend)) die();

		$sql = "SELECT " . table_users . ".user_id FROM " . table_friends . " INNER JOIN " . table_users . " ON " . table_friends . ".friend_to = " . table_users . ".user_id WHERE " . table_friends . ".friend_from=" . $current_user->user_id . " and " . table_friends . ".friend_to=".$friend.";";
		//echo $sql;
		$friends = $db->get_var($sql);
		//echo $friends;
		return $friends;
		
		// returns friend user_id if a friend
		// returns null if not
	}
}

?>