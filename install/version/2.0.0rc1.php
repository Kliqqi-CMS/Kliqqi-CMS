<?php
// This file is for performing an upgrade from Pligg 1.2.2 to 2.0.0rc1

// Report all PHP errors
// error_reporting(E_ALL);

// Check for the current version within each upgrade file
$sql = "SELECT data FROM " . table_misc_data . " WHERE name = 'pligg_version'";
$pligg_version = $db->get_var($sql);

// Check if you need to run the one time upgrade to Pligg 2.0.0rc1
if ($pligg_version == '1.2.2') {

	echo '<li>Performing one-time Pligg 2.0.0rc1 Upgrade<ul>';
	
	// Add option to search comment content
    $result = $db->get_results("select * from `" . table_config . "` where `var_name` = 'Search_Comments';");
    if (count($result) == 0) {
		$db->query("INSERT INTO `" . table_config . "` VALUES (NULL, 'Comments', 'Search_Comments', 'false', 'false', 'true / false', 'Search Comments', 'Use comment data when providing search results', 'define', NULL)");
    }
	
    // Renamed "Upcoming" and "Queued" to "New" in 2.0.0 Needs to be reflected in database.
    $sql = "ALTER TABLE ".table_links." 
			CHANGE link_status link_status ENUM('discard','new','published','abuse','duplicate','page','spam','moderated');";
    $db->query($sql);
    $sql = "UPDATE ".table_links." 
			SET link_status='new' 
			WHERE link_status='';";
    $db->query($sql);
    $sql = "ALTER TABLE ".table_links." 
			CHANGE link_group_status link_group_status ENUM('new','published','discard');";
    $db->query($sql);
    $sql = "UPDATE ".table_links." 
			SET link_group_status='new' 
			WHERE link_group_status='';";
    $db->query($sql);
    echo '<li>Changed story link_status and link_group_status from "queued" to "new".</li>';

	// Change log file locations to new /logs directory
	$sql = "UPDATE ".table_config." 
			SET var_value='logs/antispam.log' 
			WHERE var_name='$MAIN_SPAM_RULESET';";
	$db->query($sql);
	$sql = "UPDATE ".table_config." 
			SET var_defaultvalue='logs/antispam.log' 
			WHERE var_name='$MAIN_SPAM_RULESET';";
	$db->query($sql);
	$sql = "UPDATE ".table_config." 
			SET var_title='Domain Blacklist File' 
			WHERE var_name='$USER_SPAM_RULESET';";
	$db->query($sql);
	$sql = "UPDATE ".table_config." 
			SET var_value='logs/domain-blacklist.log' 
			WHERE var_name='$USER_SPAM_RULESET';";
	$db->query($sql);
	$sql = "UPDATE ".table_config." 
			SET var_defaultvalue='logs/domain-blacklist.log' 
			WHERE var_name='$USER_SPAM_RULESET';";
	$db->query($sql);
	$sql = "UPDATE ".table_config." 
			SET var_value='logs/spam.log' 
			WHERE var_name='$SPAM_LOG_BOOK';";
	$db->query($sql);
	$sql = "UPDATE ".table_config." 
			SET var_defaultvalue='logs/spam.log' 
			WHERE var_name='$SPAM_LOG_BOOK';";
	$db->query($sql);
	// Add friendly domain list
	$db->query("INSERT INTO `" . table_config . "` 
				VALUES (NULL, 'AntiSpam', '\$FRIENDLY_DOMAINS', 'logs/domain-whitelist.log', 'logs/domain-whitelist.log', 'Text file', 'Local Domain Whitelist File', 'File containing a list of domains that cannot be banned.', 'normal', '\"')");	
	echo '<li>Changed log file locations</li>';
	
	$sql = "ALTER TABLE `" . table_modules . "` ADD  `weight` INT NOT NULL";
	$db->query($sql);
	echo '<li>Order modules via the Admin Panel</li>';
	
	// Change the template value to Bootstrap
	$sql = "UPDATE `" . table_config . "` 
			SET `var_value` = 'bootstrap' 
			WHERE `var_name` = '$thetemp';";
	$db->query($sql);
	echo '<li>Changed template to Bootstrap</li>';	
	
	// Change default captcha to SolveMedia
	$sql = "UPDATE `" . table_misc_data . "` 
			SET `data` = 'solvemedia' 
			WHERE `pligg_misc_data`.`name` = 'captcha_method';";
	$db->query($sql);
	$sql = "INSERT INTO `" . table_misc_data . "` ( `name` , `data` ) 
			VALUES ('adcopy_lang', 'en');";
	$db->query($sql);
	$sql = "INSERT INTO `" . table_misc_data . "` ( `name` , `data` ) 
			VALUES ('adcopy_theme', 'white');";
	$db->query($sql);
	$sql = "INSERT INTO `" . table_misc_data . "` ( `name` , `data` ) 
			VALUES ('adcopy_pubkey', 'KLoj-jfX2UP0GEYOmYX.NOWL0ReUhErZ');";
	$db->query($sql);
	$sql = "INSERT INTO `" . table_misc_data . "` ( `name` , `data` ) 
			VALUES ('adcopy_privkey', 'Dm.c-mjmNP7Fhz-hKOpNz8l.NAMGp0wO');";
	$db->query($sql);
	$sql = "INSERT INTO `" . table_misc_data . "` ( `name` , `data` ) 
			VALUES ('adcopy_hashkey', 'nePptHN4rt.-UVLPFScpSuddqdtFdu2N');";
	$db->query($sql);
	echo '<li>Changed default CAPTCHA to Solve Media</li>';	
	
	// Change some user profile fields
	$sql = "ALTER TABLE ".table_users." CHANGE `user_aim` `user_facebook` VARCHAR( 64 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;";
	$db->query($sql);
	$sql = "UPDATE ".table_users." 
			SET user_facebook='';";
	$db->query($sql);
	$sql = "ALTER TABLE ".table_users." CHANGE `user_msn` `user_twitter` VARCHAR( 64 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;";
	$db->query($sql);
	$sql = "UPDATE ".table_users." 
			SET user_twitter='';";
	$db->query($sql);
	$sql = "ALTER TABLE ".table_users." CHANGE `user_yahoo` `user_linkedin` VARCHAR( 64 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;";
	$db->query($sql);
	$sql = "UPDATE ".table_users." 
			SET user_linkedin='';";
	$db->query($sql);
	$sql = "ALTER TABLE ".table_users." CHANGE `user_gtalk` `user_googleplus` VARCHAR( 64 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;";
	$db->query($sql);
	$sql = "UPDATE ".table_users." 
			SET user_googleplus='';";
	$db->query($sql);
	$sql = "ALTER TABLE ".table_users." CHANGE `user_irc` `user_pinterest` VARCHAR( 64 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;";
	$db->query($sql);
	$sql = "UPDATE ".table_users." 
			SET user_pinterest='';";
	$db->query($sql);
	echo '<li>Changed user profile fields to match new social media sites</li>';
	
	// Change default avatar to new larger png files
	$sql = "UPDATE ".table_config." 
			SET var_defaultvalue='/avatars/Avatar_100.png' 
			WHERE var_name='Default_Gravatar_Large';";
	$db->query($sql);
	// Change the large avatar location, only if it is still set to the default value
	$sql = "UPDATE ".table_config." 
			SET var_value='/avatars/Avatar_100.png' 
			WHERE var_value='/avatars/Gravatar_30.gif';";
	$db->query($sql);
	$sql = "UPDATE ".table_config." 
			SET var_defaultvalue='/avatars/Avatar_32.png' 
			WHERE var_name='Default_Gravatar_Small';";
	$db->query($sql);
	$sql = "UPDATE ".table_config." 
			SET var_value='/avatars/Avatar_32.png' 
			WHERE var_value='/avatars/Gravatar_15.gif';";
	$db->query($sql);
	// Force a change of avatar sizes
	$sql = "UPDATE ".table_config." 
			SET var_defaultvalue='32' 
			WHERE var_name='Avatar_Small';";
	$db->query($sql);
	$sql = "UPDATE ".table_config." 
			SET var_value='32' 
			WHERE var_name='Avatar_Small';";
	$db->query($sql);
	$sql = "UPDATE ".table_config." 
			SET var_defaultvalue='100' 
			WHERE var_name='Avatar_Large';";
	$db->query($sql);
	$sql = "UPDATE ".table_config." 
			SET var_value='100' 
			WHERE var_name='Avatar_Large';";
	$db->query($sql);
	// We need to regenerate avatars to the new size here
	echo '<li>Changed default avatars to larger format .png files</li>';
	
	// Update group avatar height/width sizes to 100
	$sql = "UPDATE ".table_config." 
			SET var_value='100' 
			WHERE var_name='group_avatar_size_width';";
	$db->query($sql);
	$sql = "UPDATE ".table_config." 
			SET var_defaultvalue='100' 
			WHERE var_name='group_avatar_size_width';";
	$db->query($sql);
	$sql = "UPDATE ".table_config." 
			SET var_value='100' 
			WHERE var_name='group_avatar_size_height';";
	$db->query($sql);
	$sql = "UPDATE ".table_config." 
			SET var_defaultvalue='100' 
			WHERE var_name='group_avatar_size_height';";
	$db->query($sql);
	echo '<li>Changed group avatar height/width size setting to 100px</li>';

	// Re-create user avatars
	// This is commented out by default as of the 2.0.2 release because most servers with moderate user databases can't handle regenerating all of the images, causing the update to hang.
	/*
	$user_image_path = mnmpath."avatars/user_uploaded" . "/";
	require_once(mnminclude . "class.pThumb.php");
	$results = $db->get_results("SELECT * FROM ".table_users);
	foreach ($results as $user)
	{
		$imagename = $user->user_id . "_original.jpg";
		$newimage = $user_image_path . $imagename ;
		if (file_exists($newimage))
		{
			$img=new pThumb();
			$img->pSetSize(Avatar_Large, Avatar_Large);
			$img->pSetQuality(100);
			$img->pCreate($newimage);
			$img->pSave($user_image_path . $user->user_id . "_".Avatar_Large.".jpg");
			$img = "";

			// create small avatar
			$img=new pThumb();
			$img->pSetSize(Avatar_Small, Avatar_Small);
			$img->pSetQuality(100);
			$img->pCreate($newimage);
			$img->pSave($user_image_path . $user->user_id . "_".Avatar_Small.".jpg");
			$img = "";
		}
	}
	echo '<li>Regenerated user avatars</li>';
	*/

	// Update User Levels, removing the 'god' level
	$sql = "UPDATE ".table_users." 
			SET user_level='moderator' 
			WHERE user_level='admin';";
	$db->query($sql);
	echo '<li>Changed Admin user level to Moderator</li>';
	$sql = "UPDATE ".table_users." 
			SET user_level='admin' 
			WHERE user_level='god';";
	$db->query($sql);
	echo '<li>Changed God user level to Admin</li>';
	
	// Remove the Spell Checker from Admin Config
	$sql = "DELETE FROM " . table_config . " 
			WHERE var_name='Spell_Checker'";
	$db->query($sql);
	echo '<li>Removed Spell Checker</li>';
	
	// Add a new FAQ Page
	$sql = "INSERT INTO `" . table_links . "`  (`link_id`, `link_author`, `link_status`, `link_randkey`, `link_votes`, `link_reports`, `link_comments`, `link_karma`, `link_modified`, `link_date`, `link_published_date`, `link_category`, `link_lang`, `link_url`, `link_url_title`, `link_title`, `link_title_url`, `link_content`, `link_summary`, `link_tags`, `link_field1`, `link_field2`, `link_field3`, `link_field4`, `link_field5`, `link_field6`, `link_field7`, `link_field8`, `link_field9`, `link_field10`, `link_field11`, `link_field12`, `link_field13`, `link_field14`, `link_field15`, `link_group_id`, `link_out`) VALUES (NULL, 1, 'page', 0, 0, 0, 0, '0.00', '2012-07-23 00:00:00', '2012-07-23 00:00:00', '0000-00-00 00:00:00', 0, 1, '', NULL, 'Frequently Asked Questions', 'faq', '<a name\"top\" style=\"text-decoration:none;color:#000;text-transform:uppercase;\"><h1>Frequently Asked Questions</h1></a>
<p>Welcome to the Frequently Asked Questions (FAQ) page. This page explains many of the features that are offered by this site to our members.</p>
<ol>
	<li><a rel=\"nofollow\" href=\"#what_is\">What is {#PLIGG_Visual_Name#}?</a></li>
	<li><a rel=\"nofollow\" href=\"#different\">How is {#PLIGG_Visual_Name#} different?</a></li>
	<li><a rel=\"nofollow\" href=\"#private_messages\">Private Messaging</a></li>
	<li><a rel=\"nofollow\" href=\"#profiles\">User Profiles</a></li>
	<li><a rel=\"nofollow\" href=\"#voting\">What is Voting?</a></li>
	<li><a rel=\"nofollow\" href=\"#whats_for_me\">What''s in it for me?</a></li>
	<li><a rel=\"nofollow\" href=\"#why_register\">Why Should I Register an Account?</a></li>
	<li><a rel=\"nofollow\" href=\"#how_register\">How do I register a new account?</a></li>
	<li><a rel=\"nofollow\" href=\"#activation\">I didn''t receive my activation email</a></li>
	<li><a rel=\"nofollow\" href=\"#cant_login\">I can''t login</a></li>
	<li><a rel=\"nofollow\" href=\"#submit\">How do I submit content?</a></li>
	<li><a rel=\"nofollow\" href=\"#karma\">What is Karma?</a></li>
	<li><a rel=\"nofollow\" href=\"#groups\">What are Groups?</a></li>
</ol>
<hr/>
<h2>Answers</h2>
<hr />
<p><a name=\"what_is\"><strong>1. What is {#PLIGG_Visual_Name#}? </strong></a></p>
<p>At {#PLIGG_Visual_Name#} you can discover, share and submit great articles, news and videos gathered from all around the web. We are a mix of social network and news agency. Users like yourself can contribute content, as well as help choose what submissions make it to the front page through our voting mechanism.</p>
<hr />
<p><a name=\"different\"><strong>2. How is {#PLIGG_Visual_Name#} different? </strong></a></p>
<p>The most important component of {#PLIGG_Visual_Name#} is you, the reader. Everything within the site is crowd-sourced by our visitors. Anyone has the authority to control the content through voting submissions or comments up and down, making readers like you the moderators of this site.</p>
<hr />
<p><a name=\"private_messages\"><strong>3. Private Messaging</strong></a></p>
<p>A social network site isn''t very social without the ability to communicate with other members. {#PLIGG_Visual_Name#} includes a private messaging feature so that you can send a direct message to your friends that they can respond to.</p>
<p>To send private message to any user, you have to click on the \"compose\" button on his/her profile page. In order to send or receive messages, you need to be her/his friend. This is a requirement put in place to prevent spam from arriving in your inbox.</p>
<p>You will get notified via email, whenever you receive a new message.</p>
<hr />
<p><a name=\"profiles\"><strong>4. User Profiles?</strong></a></p>
<p>Each user that signs up to {#PLIGG_Visual_Name#} gets their own profile page where they can change their settings, send messages to other users, add an avatar, and view their voting and comment history.</p>
<p>The user settings area allows you to change things like your email address, or what categories you want to follow. If you choose to de-select some categories, doing so will hide all content submitted to the un-subscribed categories.</p>
</ul>
<hr />
<p><a name=\"voting\"><strong>5. What is Voting?</strong></a></p>
<p>The content of this site is mainly contributed and moderated by members, rather than moderators or site-sponsored authors like on most other websites. Members like you are given the ability to vote on submissions and comments, and those votes determine what content is published to the front page. Stories without enough votes are left in the \"New\" section, where they eventually become ineligible for becoming published. </p>
<p>Your voting habits are tracked and displayed on your user profile. This allows you to easily see what submissions or comments you have interracted with in the past.</p>
<hr />
<p><a name=\"whats_for_me\"><strong>6. What''s in it for me?</strong></a></p>
<p>Are you a content producer who wants more traffic? Share your articles, news & videos on {#PLIGG_Visual_Name#} and get better exposure in the form of backlinks, comments, subscriptions and repeat visitors to your website.</p>
<p>Readers, {#PLIGG_Visual_Name#} offers an easy way to discover new content which is generated and filtered by our online community. <a href=\"{$URL_register}\">Join</a> to become part of that community and help determine the direction of this website.</p>
<hr />
<p><a name=\"why_register\"><strong>7. Why Should I Register an Account?</strong></a></p>
<p>Registering provides you with some great advantages:</p>
<ul>
	<li>Submit articles</li>
	<li>Vote on submissions</li>
	<li>Leave comments on articles</li>
	<li>Save stories to your account using a \"bookmark\" function</li>
	<li>Access your voting, comment, and bookmarks from your profile</li>
	<li>Favorite other members and follow their contributions</li>
</ul>
<hr />
<p><a name=\"how_register\"><strong>8. How do I register a new account?</strong></a></p>
<p>It only takes a few seconds to sign up for a new account. Just <a href=\"{$URL_register}\">click on this link to be redirected to the registration page</a>. Once you have signed up, you will need to click on a link sent to your email address to confirm your account before logging in.</p>
<hr />
<p><a name=\"activation\"><strong>9. I didn''t receive my activation email</strong></a></p>
<p>Many times these emails get stuck in you Junk email folder. Check to make sure that your email provider didn''t label the activation email as spam.</p>
<hr />
<p><a name=\"cant_login\"><strong>10. I can''t login</strong></a></p>
<p>Make sure your CAPS LOCK is off. Passwords are CasE SENsitivE. Also, your account must be validated via the link that was emailed to you during the registration process. You can also try to reset your password by using the <a href=\"{$URL_login}\">forgotten password field</a>.</p>
<hr />
<p><a name=\"submit\"><strong>11. How do I submit content?</strong></a></p>
<ul class=\"help\">
	<li>To submit the story you need to first log into a registered account. If you don''t have an account yet, you can <a href=\"{$URL_register}\">Register Here</a>.</li>
	<li>Next, navigate to the <a href=\"{$URL_submit}\">Submission Page</a></li>
	<li>Copy the URL of a story that you would like to submit and paste that into the News Source input field and click on the continue button.</li>
	<li>Enter a title, category, tags, and description for your submission.</li>
	
	<li>Submit, and you''re done!</li>
</ul>
<hr />
<p><a name=\"karma\"><strong>12. What is Karma?</strong></a></p>
<p>Karma is a mechanism used by this site that gives more weight to users who contribute frequently. The more articles, comments, and votes that you submit, the more Karma your account accrues. That Karma is then used in determining what stories make it to the front page. The higher the karma your account has, the more influence your votes will have over the direction of the website.
<hr />
<p><a name=\"groups\"><strong>13. What are Groups? </strong></a></p>
<p>Groups are a way for members with a common interest to collaborate on a specific topic. For example, if you are a person who lives in France, you could create your own group for members in France. Each group is given their own published, new, and shared pages where admins can moderate which content makes it to the group homepage.</p>
<p>Please be aware that some groups may require membership approval before you become a member.</p>
<hr />
<a href=\"#top\"><i class=\"fa fa-arrow-up\" style=\"opacity:1.0;\"></i> Top</a><br /><br />', '', '', 'Frequently Asked Questions,FAQ,Help', 'Frequently Asked Questions', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, 0);";
	$db->query($sql);
	echo '<li>Created FAQ Page</li>';

	// Update version number
	$sql = "UPDATE `" . table_misc_data . "` SET `data` = '2.0.0rc1' WHERE `name` = 'pligg_version';";
	$db->query($sql);
	echo '<li>Updated version number to 2.0.0rc1</li>';
		
	// Finished 2.0.0rc1 upgrade
	echo'</ul></li>';
}

	
?>