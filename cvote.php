<?php
// The source code packaged with this file is Free Software, Copyright (C) 2005 by
// Ricardo Galli <gallir at uib dot es>.
// It's licensed under the AFFERO GENERAL PUBLIC LICENSE unless stated otherwise.
// You can get copies of the licenses here:
// 		http://www.affero.org/oagpl.html
// AFFERO GENERAL PUBLIC LICENSE is also included in the file called "COPYING".

if(isset($_POST['id'])){

	include_once('Smarty.class.php');
	$main_smarty = new Smarty;

	include('config.php');
	include(mnminclude.'comment.php');
	include(mnminclude.'html1.php');
	include(mnminclude.'smartyvariables.php');

	check_referrer();

	
	$comment = new Comment;
	$comment->id=sanitize($_POST['id'], 3);
	if(!is_numeric($comment->id)){die();}
	$comment->read();
	
	if ($current_user->user_id == 0 && !anonnymous_vote) {
		error($main_smarty->get_config_vars('PLIGG_Visual_Vote_NoAnon'));
	}

	if($current_user->user_id != sanitize($_POST['user'], 3)) {
		error($main_smarty->get_config_vars('PLIGG_Visual_Vote_BadUser'). $current_user->user_id . '-'. sanitize($_POST['user'], 3));
	}

	$md5=md5(sanitize($_POST['user'], 3).$comment->randkey);
	if($md5 !== sanitize($_POST['md5'], 3)){
		error($main_smarty->get_config_vars('PLIGG_Visual_Vote_BadKey'));
	}

	if($comment->votes($current_user->user_id) <> 0 ||
	   // DB 11/10/08
	   (votes_per_ip > 0 && $comment->votes_from_ip() >= votes_per_ip)) {
	   /////
		error($main_smarty->get_config_vars('PLIGG_Visual_Vote_AlreadyVoted'));
	}
	
	$value = sanitize($_POST['value'], 3);
	
	if($value < -10 || $value > 10){
		error('Invalid vote value');
	}

	$votes = $comment->insert_vote($current_user->user_id, $value);

	$comment->votes = $votes;
	$comment->store();

	$count=$comment->votes;
	echo "$count ~--~".sanitize($_POST['id'], 3);

}

?>