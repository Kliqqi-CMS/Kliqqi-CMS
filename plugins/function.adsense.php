<?php
 /******************************************************************
* template_lite Adsense Plugin for Pligg
*
* Name: adsense
* Type: function
* Purpose: use the authors adsense ID or not?
* Author: Ryan 'Dravis' Knowles http://www.PlugIM.com
* Parameters:
*	params: parameters array
*	tpl: template_lite instance
* Returns: nothing, assigns new value to a template_lite variable
******************************************************************/
function tpl_function_adsense($params, &$tpl)
{
	// check to make sure this is a full story
	if (strcasecmp(pagename, "story") != 0){
		// not a full story, no adsense sharing
		$tpl->assign($params['assign'], 0);
		return;
	}
	
	// check to see if the author has an adsense id on their profile
	if ($tpl->get_template_vars("google_adsense_id") == ""){
		// this author hasn't provided their adsense id, no sharing
		$tpl->assign($params['assign'], 0);
		return;
	}
	
	// make sure the logged in user isn't the same user who submitted the story
	// using a case insensitive compare because the user name isn't case sensitive
	if (strcasecmp($tpl->get_template_vars("user_logged_in"), $tpl->get_template_vars("link_submitter")) == 0){
		// the user viewing the story is also the author, can't show them their own ads, no sharing
		$tpl->assign($params['assign'], 0);
		return;
	}

	// generate a random number between 1 and 100
	srand((float) microtime() * 10000000);
	$random = rand(1, 100);

	// check the random number against their adsense percent (defaults to 50% but can be adjusted)	
	if ($random > $tpl->get_template_vars("google_adsense_percent")){
		// if the random number is higher than their percent of revenue sharing, no sharing this time
		$tpl->assign($params['assign'], 0);
		return;
	}

	// passed all checks, use the users adsense ID for this page	
	$tpl->assign($params['assign'], 1);
	return;
}
?>