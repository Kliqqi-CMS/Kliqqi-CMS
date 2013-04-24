<?php

include_once('internal/Smarty.class.php');
$main_smarty = new Smarty;

include('config.php');
include(mnminclude.'votes.php');
include(mnminclude.'link.php');
include(mnminclude.'html1.php');
include(mnminclude.'smartyvariables.php');

class LinkTotal extends Link {

	function remove_vote($user=0, $value=10) {
		parent::remove_vote($user, $value);

		$vote = new Vote;
		$vote->type='links';
		$vote->link=$this->id;
		if(Voting_Method == 2){
			$this->votes=$vote->rating("!=0");
			$this->votecount=$vote->count("!=0");
			$this->reports = $this->count_all_votes("<0");
		}
		else
		{
			$this->reports = $this->count_all_votes("<0");
			$this->votes   = $vote->count()-$this->reports;
		}
		$this->store_basic();
		
		$vars = array('link' => $this);
		check_actions('link_remove_vote_post', $vars);	
	}
	
	function insert_vote($user=0, $value=10) {
		if (parent::insert_vote($user, $value))
		{
			$vote = new Vote;
			$vote->type='links';
			$vote->link=$this->id;
			if(Voting_Method == 2){
				$this->votes=$vote->rating("!=0");
				$this->votecount=$vote->count("!=0");
				$this->reports = $this->count_all_votes("<0");
			}
			else
			{
				$this->reports = $this->count_all_votes("<0");
				$this->votes   = $vote->count()-$this->reports;
			}
			$this->store_basic();
			$this->check_should_publish();
			
			$vars = array('vote' => $this);
			check_actions('link_insert_vote_post', $vars);		
			
			return true;
		}
		return false;
	}
}

check_referrer();

$post_id = sanitize($_POST['id'], 3);

if(is_numeric($post_id) && $post_id > 0){
	
	$link = new LinkTotal;
	$link->id=$post_id;
	$link->read_basic();
	
	if ($current_user->user_id == 0 && !anonymous_vote) {
		error($main_smarty->get_config_vars('PLIGG_Visual_Vote_NoAnon'));
	}

	$post_user = sanitize($_POST['user'], 3);
	if($current_user->user_id != $post_user) {
		error($main_smarty->get_config_vars('PLIGG_Visual_Vote_BadUser'). $current_user->user_id . '-'. $post_user);
	}

	$md5=md5($post_user.$link->randkey);
	if($md5 !== sanitize($_POST['md5'], 3)){
		error($main_smarty->get_config_vars('PLIGG_Visual_Vote_BadKey'));
	}

	$value = intval($_POST['value']);
	if(sanitize($_POST['unvote'], 3) == 'true'){
	    $link->remove_vote($current_user->user_id, $value);
	} else {
		
		//Checking for ip vote
	   if($current_user->user_id!=0){	  
		if($link->votes($current_user->user_id) > 0)
		  error($main_smarty->get_config_vars('PLIGG_Visual_Vote_AlreadyVoted').$link->votes($current_user->user_id).'/'.$value);
	   }else{
		
		if($value==10 && votes_per_ip > 0 && $link->votes_from_ip() >= votes_per_ip+1)
		 error($main_smarty->get_config_vars('PLIGG_Visual_Vote_AlreadyVoted').'/'.$value);
		 
		if($value==-10 && votes_per_ip > 0 && $link->reports_from_ip() >= votes_per_ip+1)
		 error($main_smarty->get_config_vars('PLIGG_Visual_Vote_AlreadyVoted').'/'.$value);
	   }
	   /* if($link->votes($current_user->user_id, 10) > 0 || $link->votes($current_user->user_id, -10) > 0 ||
	        (votes_per_ip > 0 && $link->votes_from_ip() + $link->reports_from_ip() >= votes_per_ip)) {
			//error($main_smarty->get_config_vars('PLIGG_Visual_Vote_AlreadyVoted').$link->votes($current_user->user_id, $value).'/'.$value);
	    }*/
		
	    $link->remove_vote($current_user->user_id, -$value);
	    $link->insert_vote($current_user->user_id, $value);
	}

	if ($link->status == 'discard') {
		$link->read();
		$link->status = 'new';
		$link->store();
	}

	if(Voting_Method == 2){
		$link_rating = $link->rating($link->id)/2;
		$rating_width = $link_rating * 25;
		$vote_count = $link->countvotes();
		echo $rating_width . "~" . $link_rating . "~" . $vote_count . "~<li class='one-star-noh'>1</li><li class='two-stars-noh'>2</li><li class='three-stars-noh'>3</li><li class='four-stars-noh'>4</li><li class='five-stars-noh'>5</li>";
	}
	else
	{
		$count=$link->votes;
		echo "$count ~--~".$post_id;
	}
	$link->evaluate_formulas();
}
?>