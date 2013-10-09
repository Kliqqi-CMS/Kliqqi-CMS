<?php

if(!defined('mnminclude')){header('Location: ../error_404.php');die();}

class Comment {
	var $id = 0;
	var $randkey = 0;
	var $author = 0;
	var $link = 0;
	var $date = false;
	var $karma = 0;
	var $content = '';
	var $read = false;
	var $parent = 0;
	var $hideedit;
	var $votes = 0;
	var $status = 'published';

	function store() {
		// save the comment to the database
		global $db, $current_user, $the_template;

		if(!$this->date) $this->date=time();
		$comment_id = $this->id;
		if(!is_numeric($comment_id)){return false;}
		$comment_author = $this->author;
		$comment_link = $this->link;
		$comment_karma = $this->karma;
		$comment_date = $this->date;
		$comment_randkey = $this->randkey;
		$comment_content = $db->escape($this->content);
		$comment_votes = $this->votes;
		$comment_status = $this->status;
		$comment_parent = $this->parent;

		if($this->id===0) {

			$this->canSave = true; // assume we can save

			$vars = array('comment'=>&$this);
			check_actions('comment_save', $vars);
			$comment_status = $this->status;

			if($this->canSave == true){

				// if this is a new comment
				$sql = "INSERT IGNORE INTO " . table_comments . " (comment_parent, comment_user_id, comment_link_id, comment_karma, comment_date, comment_randkey, comment_content, comment_status) VALUES ($comment_parent, $comment_author, $comment_link, $comment_karma, FROM_UNIXTIME($comment_date), $comment_randkey, '$comment_content', '$comment_status')";
				$db->query($sql);
				$this->id = $db->insert_id;
			
				$link = new Link;
				$link->id=$this->link;
				$link->read();
				$link->adjust_comment(1);
				$link->store();
				$link='';

				$vars = array('comment'=>&$this);
				check_actions('comment_post_save', $vars);

			}
			
		} else {
			// if we're editing an existing comment
			$sql = "UPDATE " . table_comments . " set comment_votes=$comment_votes, comment_user_id=$comment_author, comment_link_id=$comment_link, comment_karma=$comment_karma, comment_date=FROM_UNIXTIME($comment_date), comment_randkey=$comment_randkey, comment_content='$comment_content', comment_status='$comment_status' WHERE comment_id=$comment_id";
			$db->query($sql);
		}

		$vars = array('comment' => $this);
		check_actions('comment_store_post_sql', $vars);		

	}
	
	function read($usecache = TRUE) {
		// read the comment from the database
		global $db, $current_user, $cached_comments;
		$this->username = false;
		$id = $this->id;
		if(!is_numeric($id)){return false;}

		if (isset($cached_comments[$id]) && $usecache == TRUE) {
			$link = $cached_comments[$id];
		} else {
			$link = $db->get_row("SELECT * FROM " . table_comments . " WHERE comment_id = $id");
			$cached_comments[$id] = $link;
		}
		if($link) {
			$this->author=$link->comment_user_id;
			$this->randkey=$link->comment_randkey;
			$this->link=$link->comment_link_id;
			$this->karma=$link->comment_karma;
			$this->parent=$link->comment_parent;
			$this->content=$link->comment_content;
			$this->status=$link->comment_status;
			$this->randkey=$link->comment_randkey;
			$this->votes=$link->comment_votes;
			$date=$link->comment_date;
			$this->date=unixtimestamp($date);
			$this->read = true;
			return true;
		}
		$this->read = false;
		return false;
	}

	function quickread() {
		global $db, $current_user;
		$this->username = false;
		$id = $this->id;
		if(!is_numeric($id)){return false;}
		if(($link = $db->get_row("SELECT * FROM " . table_comments . " WHERE comment_id = $id"))) {
			$this->content=$link->comment_content;
			return $link->comment_content;
		}
		$this->quickread = false;
		return false;
	}

	function print_summary($link, $fetch = false) {
		global $current_user, $the_template;
		static $comment_counter = 0;
		static $link_index=0;

		// setup smarty
			include_once('internal/Smarty.class.php');
			$smarty = new Smarty;
			$smarty->compile_dir = "cache/";
			$smarty->template_dir = "templates/";
			$smarty->config_dir = "";
			$smarty->assign('pligg_language', pligg_language);
			$smarty->config_load("/languages/lang_" . pligg_language . ".conf");

		// if we can't read the comment, return
			if(!$this->read) return;
		
		// counter	
			$comment_counter++;
		
		$smarty = $this->fill_smarty($smarty);
		$smarty->assign('rand', rand(1000000,100000000));

		if($fetch == false){
			$smarty->display($the_template . '/comment_show.tpl');
		} else {
			return $smarty->fetch($the_template . '/comment_show.tpl');
		}
	
	}
	
	function fill_smarty($smarty){
		global $current_user, $the_template, $comment_counter, $link, $ranklist, $db;  
	    if (!$ranklist)
	    {
		$users = $db->get_results("SELECT user_karma, COUNT(*) FROM ".table_users." WHERE user_level NOT IN ('Spammer') AND user_karma>0 GROUP BY user_karma ORDER BY user_karma DESC",ARRAY_N);
		$ranklist = array();
		$rank = 1;
		if ($users)
		    foreach ($users as $dbuser)
		    {
			$ranklist[$dbuser[0]] = $rank;
			$rank += $dbuser[1];
		    }
	    }

		$smarty->assign('comment_counter', $comment_counter);

		$text = save_text_to_html($this->content);
		$vars = array('comment_text' => $text, 'comment_id' => $this->id, 'smarty' => $smarty);
		check_actions('show_comment_content', $vars); 
		$smarty->assign('comment_content', $vars['comment_text']); 

		$vars = array('comment_form_label' => '');
		check_actions('comment_form_label', $vars); 
		$smarty->assign('comment_form_label', $vars['comment_form_label']);

		$smarty->assign('current_userid', $current_user->user_id);
		$smarty->assign('user_logged_in', $current_user->user_login);

		$vars = array('comment_username' => $this->username(), 'is_anonymous' => 0, 'comment_id' => $this->id);
		check_actions('show_comment_username', $vars); 
		$smarty->assign('user_username', $vars['comment_username']);
		$smarty->assign('user_rank', $ranklist[$this->userkarma]);
		$smarty->assign('is_anonymous', $vars['is_anonymous']);
		$smarty->assign('user_extra_fields', $this->extra_field);
		//$smarty->assign('link_submitter', $link->username());
		$smarty->assign('comment_id', $this->id);
		$smarty->assign('comment_status', $this->status);
		$smarty->assign('comment_author', $this->author);
		$smarty->assign('comment_link', $this->link);
		$smarty->assign('user_view_url', getmyurl('user', $this->username));
		$smarty->assign('comment_date_timestamp', $this->date);
		$smarty->assign('comment_date', date('F, d Y g:i A',$this->date));
		$smarty->assign('comment_age', txt_time_diff($this->date));
		$smarty->assign('comment_randkey', $this->randkey);
		$smarty->assign('comment_votes', $this->votes);
		$smarty->assign('comment_parent', $this->parent);
		$smarty->assign('hide_comment_edit', $this->hideedit);
		
		$this->user_vote_count = $this->votes($current_user->user_id);
		$smarty->assign('comment_user_vote_count', $this->user_vote_count);
		$smarty->assign('comment_shakebox_currentuser_votes', $this->votes($current_user->user_id, '>0'));
		$smarty->assign('comment_shakebox_currentuser_reports', $this->votes($current_user->user_id, '<0'));
		
		// if the person logged in is the person viewing the comment, show 'you' instead of the name
		$smarty->assign('user_userlogin', $this->username);
		
		// the url for the edit comment link
		$smarty->assign('edit_comment_url', getmyurl('editcomment', $this->id, $link->id));
		$smarty->assign('delete_comment_url', my_pligg_base.'/delete.php?comment_id='.$this->id);

		// avatars
		$smarty->assign('UseAvatars', do_we_use_avatars());
		$smarty->assign('Avatar', $avatars = get_avatar('all', '', $this->username, ''));
		$smarty->assign('Avatar_ImgSrc', $avatars['large']);
		$smarty->assign('Avatar_ImgSrc_Small', $avatars['small']);

		// does the person logged in have admin or moderator status?
		$canIhaveAccess = 0;
		$canIhaveAccess = $canIhaveAccess + checklevel('admin');
		$canIhaveAccess = $canIhaveAccess + checklevel('moderator');
		if($canIhaveAccess == 1){$smarty->assign('isadmin', 1);}
		
		// the link to upvote the comment
		$jslinky = "cvote($current_user->user_id,$this->id,$this->id," . "'" . md5($current_user->user_id.$this->randkey) . "',10,'" . my_base_url . my_pligg_base . "/')";
		$smarty->assign('link_shakebox_javascript_votey', $jslinky);

		$jslinky = "cunvote($current_user->user_id,$this->id,$this->id," . "'" . md5($current_user->user_id.$this->randkey) . "',10,'" . my_base_url . my_pligg_base . "/')";
		$smarty->assign('link_shakebox_javascript_unvotey', $jslinky);

		// the link to downvote the comment
		$jslinkn = "cvote($current_user->user_id,$this->id,$this->id," . "'" . md5($current_user->user_id.$this->randkey) . "',-10,'" . my_base_url . my_pligg_base . "/')";
		$smarty->assign('link_shakebox_javascript_voten', $jslinkn);

		$jslinkn = "cunvote($current_user->user_id,$this->id,$this->id," . "'" . md5($current_user->user_id.$this->randkey) . "',-10,'" . my_base_url . my_pligg_base . "/')";
		$smarty->assign('link_shakebox_javascript_unvoten', $jslinkn);

		// misc
		$smarty->assign('Enable_Comment_Voting', Enable_Comment_Voting);
		$smarty->assign('my_base_url', my_base_url);
		$smarty->assign('my_pligg_base', my_pligg_base);
		$smarty->assign('Default_Gravatar_Small', Default_Gravatar_Small);
		
		return $smarty;
	}

	function username() {
		global $db;
		include_once(mnminclude.'user.php');

		$user = new User;
		$user->id = $this->author;
		$user->read();
	  
		$this->username = $user->username;
		$this->userkarma = $user->karma;
		$this->author_email = $user->email;
		$this->extra_field = $user->extra_field;

		return $this->username;
	}
	
	function votes($user, $value="<> 0") {
		require_once(mnminclude.'votes.php');

		$vote = new Vote;
		$vote->type='comments';
		$vote->user=$user;
		$vote->link=$this->id;
		return $vote->anycount($value);
	}
	
	// DB 11/10/08
	function votes_from_ip($ip='', $value="<> 0") {
		require_once(mnminclude.'votes.php');

		$vote = new Vote;
		$vote->type='comments';
		$vote->user=-1;
		$vote->ip=$ip;
		$vote->link=$this->id;
		return $vote->anycount($value);
	}
	/////
	
	function remove_vote($user=0, $value=10) {
		require_once(mnminclude.'votes.php');
		if(!is_numeric($this->id)){return false;}
	
		$vote = new Vote;
		$vote->type='comments';
		$vote->user=$user;
		$vote->link=$this->id;
		$vote->value=$value;
		$vote->remove();

		$vote = new Vote;
		$vote->type='comments';
		$vote->link=$this->id;
		$this->votes=$vote->count()-$vote->count('<0');
	}
	
	function insert_vote($user=0, $value=10) {
		global $anon_karma;
		require_once(mnminclude.'votes.php');
		if(!is_numeric($this->id)){return false;}

		$vote = new Vote;
		$vote->type='comments';
		$vote->user=$user;
		$vote->link=$this->id;
		$vote->value=$value;

		if($vote->insert()) {
			$vote = new Vote;
			$vote->type='comments';
			$vote->link=$this->id;
			$this->votes=$vote->count()-$vote->count('<0');

			if(comment_buries_spam>0 && $vote->count_all("<0")>=comment_buries_spam) {
				$this->status='discard';
				$this->store();

				$vars = array('comment_id' => $this->id);
				check_actions('comment_spam', $vars);

				$link = new Link;
				$link->id=$this->link;
				$link->read();
				$link->recalc_comments();
				$link->store();
			}

			$vars = array('vote' => $this);
			check_actions('comment_insert_vote_post', $vars);		

			return $vote->sum();
		}
		return false;
	}
}
?>
