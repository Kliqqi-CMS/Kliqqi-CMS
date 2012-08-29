<?php
// This file is used to regenerate karma scores manually. 
// It is designed to be run by a cronjob.

/*

include('../config.php');
include(mnminclude.'user.php');

header("Content-Type: text/plain");


/////////////////////////////
//   Configuration Vars    //
/////////////////////////////

$iDaysOfHistoryToUse = 90;
$iPoints_VotesBeforeLinkWentPublished = 2;
$iPoints_VotesAfterLinkWentPublished = 1;
$iPoints_LinksSubmittedButNotPublished = 3;
$iPoints_LinksSubmittedAndPublished = 30;
$iPoints_Comments = 2;
//$iPoints_VotesOnComments = 1;

/////////////////////////////
//  End Configuration Vars //
/////////////////////////////


$iSecondsBack = time() - 3600*24*$iDaysOfHistoryToUse;  // How far back to pull stats for

// Get the list of users
$users = $db->get_results("SELECT user_id from " . table_users . " ORDER BY user_login");

// Cycle through the list, calculating the karma for each
foreach($users as $dbuser) {
	$user = new User;
	$user->id=$dbuser->user_id;
	$user->read();
	$user->all_stats($iSecondsBack);

	if (false) {  // Set this to true if you want to see the individual components making up the user's karma
		echo "\n\n".$user->username."\n";

		echo "Votes Before Published: " . ($user->total_votes - $user->published_votes) . "\n";
	
		echo "Votes After Published: " . ($user->published_votes) . "\n";

		echo "Links Submitted, Not Published: " . ($user->total_links - $user->published_links) . "\n";

		echo "Links Submitted and Published: " . ($user->published_links) . "\n";

		echo "Comments: " . $user->total_comments . "\n";

		echo "TOTAL POINTS: (" . 
			(($user->total_votes - $user->published_votes) * $iPoints_VotesBeforeLinkWentPublished) . " + " .
			($user->published_votes * $iPoints_VotesAfterLinkWentPublished) . " + " .
			(($user->total_links - $user->published_links) * $iPoints_VotesBeforeLinkWentPublished) . " + " .
			($user->published_links * $iPoints_LinksSubmittedAndPublished) . " + " .
			($user->total_comments * $iPoints_Comments) .
			")\n";
	}
	
	// Add up the total points (karma) for the user
	$iTotalPoints = (
		(($user->total_votes - $user->published_votes) * $iPoints_VotesBeforeLinkWentPublished) +
		($user->published_votes * $iPoints_VotesAfterLinkWentPublished) +
		(($user->total_links - $user->published_links) * $iPoints_VotesBeforeLinkWentPublished) +
		($user->published_links * $iPoints_LinksSubmittedAndPublished) +
		($user->total_comments * $iPoints_Comments)
	);

	//echo "TOTAL POINTS: " . $iTotalPoints . "\n";

	echo $user->username . ": $iTotalPoints\n";
	$user->karma = $iTotalPoints;  // Set the karma
	$user->store();  // Save it in the user's record
}


/////////////////////////////
//     Output the List     //
/////////////////////////////


// Because this list only gets generated once per night, we output the list
// in a text file that's simply included in the sidebar via an include
// statement so that there's not a database hit each time a page is loaded.

$iHowManyContributorsInTheList = 10;


// Pull the list of top contributors 
$users = $db->get_results("SELECT user_id from " . table_users . " where user_level <> 'admin' order by user_karma desc limit " . $iHowManyContributorsInTheList);

// Cycle through the results, building the list 
foreach($users as $dbuser) {
	$user = new User;
	$user->id=$dbuser->user_id;
	$user->read();
	$user->all_stats($iSecondsBack);

	$sContributorLines = $sContributorLines . "	<li><a href=\"/user/profile/login/$user->username\">$user->username</a>";
	If ($user->url != '') {
		$sContributorLines = $sContributorLines . ' (<a href="';
		If (substr($user->url, 0, 4) != 'http') $sContributorLines = $sContributorLines . 'http://';
		$sContributorLines = $sContributorLines . $user->url . '" target="_blank">website</a>)';
	}
	$sContributorLines = $sContributorLines . "</li>\n";
}

*/
?>