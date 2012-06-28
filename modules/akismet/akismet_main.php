<?php
function akismet_save_profile(&$x){
	global $current_user;

	$text = join(' ',$_POST);

	$user = new User;
	$user->id = $current_user->user_id;
	$user->read();

	if(phpnum()>=5){
		include akismet_lib_path . 'Akismet.class_5.php'; 
			
		$akismet = new Akismet(my_base_url . my_pligg_base, get_misc_data('wordpress_key'));
		$akismet->setCommentAuthor($user->username);
		$akismet->setCommentAuthorEmail($user->email);
		$akismet->setCommentContent($text);
		$akismet->setPermalink(my_base_url.getmyurl('user', $user->username));
			
		if($akismet->isCommentSpam()){
			$x['error'] = 'Spam';
		} else {
		}
	} else {
		include akismet_lib_path . 'Akismet.class_4.php'; 

		$story['author'] = $user->username;
		//$story['email'] = $user->email;
		$story['body'] = $text;
		$story['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
		$story['referrer']   = $_SERVER['HTTP_REFERER'];
		$story['user_ip'] = $user->extra_field['user_lastip'];

		$akismet = new Akismet(my_base_url . my_pligg_base, get_misc_data('wordpress_key'), $story); 

		if($akismet->errorsExist()) { // returns true if any errors exist 
			if($akismet->isError('AKISMET_INVALID_KEY')) { 
				 echo 'invalid key';
			} elseif($akismet->isError('AKISMET_RESPONSE_FAILED')) { 
				 echo 'response failed';
			} elseif($akismet->isError('AKISMET_SERVER_NOT_FOUND')) { 
				 echo 'server not found';
			} 
		} else { // No errors, check for spam 
			if ($akismet->isSpam()){
				$x['error'] = 'Spam';
			} else {
			}
		}
	}
}


function akismet_save_comment(&$x){
	if(phpnum()>=5){
		include akismet_lib_path . 'Akismet.class_5.php'; 
			
		$comment = $x['comment'];
		$user = new User;
		$user->id = $comment->author;
		$user->read();
			
		$akismet = new Akismet(my_base_url . my_pligg_base, get_misc_data('wordpress_key'));
		$akismet->setCommentAuthor($user->username);
		$akismet->setCommentAuthorEmail($user->email);
		$akismet->setCommentContent($comment->content);
		$akismet->setPermalink(my_base_url.getmyurl('story', $comment->link));
			
		if($akismet->isCommentSpam()){
			$x['comment']->canSave = false;
#			$x['comment']->status = 'spam';
			// store the comment but mark it as spam (in case of a mis-diagnosis)
			akismet_comment_to_spam($comment);
		} else {
			// echo 'not spam';
			$x['comment']->canSave = true;
		}
	} else {
		include akismet_lib_path . 'Akismet.class_4.php'; 
// echo "this is version 4";
		$comment = $x['comment'];
		
// print_r($comment);
		$user = new User;
		$user->id = $comment->author;
		$user->read();

		$story['author'] = $user->username;
		//$story['email'] = $user->email;
		$story['body'] = $comment->content;
		$story['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
		$story['referrer']   = $_SERVER['HTTP_REFERER'];
		$story['user_ip'] = $user->extra_field['user_lastip'];

		$akismet = new Akismet(my_base_url . my_pligg_base, get_misc_data('wordpress_key'), $story); 

		if($akismet->errorsExist()) { // returns true if any errors exist 
			if($akismet->isError('AKISMET_INVALID_KEY')) { 
				 echo 'invalid key';
			} elseif($akismet->isError('AKISMET_RESPONSE_FAILED')) { 
				 echo 'response failed';
			} elseif($akismet->isError('AKISMET_SERVER_NOT_FOUND')) { 
				 echo 'server not found';
			} 
		} else { // No errors, check for spam 
			if ($akismet->isSpam()){
				$x['comment']->canSave = false;
#				$x['comment']->status = 'spam';
				akismet_comment_to_spam($comment);
			} else {
				$x['comment']->canSave = true;
			}
		}
	}
}


function akismet_check_submit(&$vars){
	if(phpnum()>=5){
		include akismet_lib_path . 'Akismet.class_5.php'; 

		$user = new User;
		$user->id = $vars['linkres']->author;
		$user->read();
	
		$akismet = new Akismet(my_base_url . my_pligg_base, get_misc_data('wordpress_key'));
		$akismet->setCommentAuthor($user->username);
		$akismet->setCommentAuthorEmail($user->email);
		$akismet->setCommentAuthorURL($vars['linkres']->url);
		$akismet->setCommentContent($vars['linkres']->content);
		$akismet->setPermalink(my_base_url.getmyurl('story', $vars['linkres']->id));
		if($akismet->isCommentSpam()) {
			// store the comment but mark it as spam (in case of a mis-diagnosis)
			akismet_link_to_spam($vars['linkres']->id);

			totals_adjust_count($vars['linkres']->status, -1);
			totals_adjust_count('discard', 1);
			$vars['linkres']->status = 'discard';
		}
		else {
			// echo 'not spam';
		}
	}
	else{
		include akismet_lib_path . 'Akismet.class_4.php'; 

		$user = new User;
		$user->id = $vars['linkres']->author;
		$user->read();

		$story['author'] = $user->username;
		$story['email'] = $user->email;
		$story['website'] = $vars['linkres']->url;
		$story['body'] = $vars['linkres']->content;
		$story['permalink'] = my_base_url.getmyurl('story', $vars['linkres']->id);
		$story['user_ip'] = $user->extra_field['user_lastip'];

		$akismet = new Akismet(my_base_url . my_pligg_base, get_misc_data('wordpress_key'), $story); 

		// test for errors 

		if($akismet->errorsExist()) { // returns true if any errors exist 
			if($akismet->isError('AKISMET_INVALID_KEY')) { 
				// echo 'invalid key';
			} elseif($akismet->isError('AKISMET_RESPONSE_FAILED')) { 
				// echo 'response failed';
			} elseif($akismet->isError('AKISMET_SERVER_NOT_FOUND')) { 
				// echo 'server not found';
			} 
		} else { // No errors, check for spam 
			if ($akismet->isSpam()) { // returns true if Akismet thinks the comment is spam 
				akismet_link_to_spam($vars['linkres']->id);

				totals_adjust_count($vars['linkres']->status, -1);
				totals_adjust_count('discard', 1);
				$vars['linkres']->status = 'discard';
			} else { 
				// echo 'not spam';
			} 
		} 
	}
}

// verified 03/19/10 
function akismet_top(){

	global $main_smarty, $the_template, $current_user, $db;

	//force_authentication();
	$canIhaveAccess = 0;
	$canIhaveAccess = $canIhaveAccess + checklevel('god');

	if($canIhaveAccess == 1)
	{
		$main_smarty->assign('menu_spam_comments', akismet_get_comment_count());
	}
}

function akismet_showpage(){

	global $main_smarty, $the_template, $current_user, $db;


	force_authentication();
	$canIhaveAccess = 0;
	$canIhaveAccess = $canIhaveAccess + checklevel('god');

	if($canIhaveAccess == 1)
	{	
		$navwhere['text1'] = 'Akismet';
		$navwhere['link1'] = URL_akismet;

		define('pagename', 'akismet'); 
		$main_smarty->assign('pagename', pagename);
		
		define('modulename', 'akismet'); 
		$main_smarty->assign('modulename', modulename);

		if(isset($_REQUEST['view'])){$view = sanitize($_REQUEST['view'], 3);}else{$view='';}

		if($view == ''){
			$wordpress_key = get_misc_data('wordpress_key');
			if($wordpress_key == ''){header('Location: ' . URL_akismet . '&view=manageKey');die();}

			$main_smarty->assign('spam_links_count', akismet_get_link_count());
			$main_smarty->assign('spam_comments_count', akismet_get_comment_count());
			
			$main_smarty = do_sidebar($main_smarty, $navwhere);
			$main_smarty->assign('posttitle', " / " . $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel'));

			$main_smarty->assign('tpl_center', akismet_tpl_path . 'main');
			$main_smarty->display($template_dir . '/admin/admin.tpl');
		}

		if($view == 'manageKey'){
			$wordpress_key = get_misc_data('wordpress_key');
			$main_smarty->assign('wordpress_key', $wordpress_key);

			$main_smarty = do_sidebar($main_smarty, $navwhere);
			$main_smarty->assign('posttitle', " / " . $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel'));

			$main_smarty->assign('tpl_center', akismet_tpl_path . 'manageKey');
			$main_smarty->display($template_dir . '/admin/admin.tpl');
		}

		if($view == 'updateKey'){
			if(isset($_REQUEST['key'])){$wordpress_key = sanitize($_REQUEST['key'], 3);}else{$wordpress_key='';}
			misc_data_update('wordpress_key', $wordpress_key);
			header('Location: ' . URL_akismet);
			die();
		}

		if($view == 'manageSpam'){

			$sql = "SELECT " . table_links . ".*, " . table_users . ".user_login FROM " . table_links . " 
					LEFT JOIN " . table_users . " ON link_author=user_id 
					LEFT JOIN " . table_prefix. "spam_links ON linkid=link_id
					WHERE !ISNULL(linkid)";
			$link_data = $db->get_results($sql);	
			if (sizeof($link_data)) {
				$main_smarty->assign('link_data', object_2_array($link_data));
			} else {
				header("Location: ".my_pligg_base."/admin/admin_index.php");
//				header('Location: ' . URL_akismet);
				die();
			}

			$main_smarty = do_sidebar($main_smarty, $navwhere);
			$main_smarty->assign('posttitle', " / " . $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel'));

			$main_smarty->assign('tpl_center', akismet_tpl_path . 'manageSpam');
			$main_smarty->display($template_dir . '/admin/admin.tpl');

		}

		if($view == 'manageSettings'){

			$main_smarty = do_sidebar($main_smarty, $navwhere);
			$main_smarty->assign('posttitle', " / " . $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel'));

			$main_smarty->assign('tpl_center', akismet_tpl_path . 'manageSettings');
			$main_smarty->display($template_dir . '/admin/admin.tpl');

		}
		if($view == 'manageSpamcomments'){
			$sql = "SELECT * FROM ".table_prefix . "spam_comments "; 
			$link_data = $db->get_results($sql);
			if (sizeof($link_data))
			{
				$user_cmt = new User;
				$user_cmt_link = new Link;
				$spam_output .=' <form name="bulk_moderate" action="'.URL_akismet_isSpamcomment.'&action=bulkmod" method="post">';
				$spam_output .='<table class="stripes" cellpadding="0" cellspacing="0" border="0">';
				$spam_output .="<tr><th style='width:100px;'>Author</th><th>Content</th><th style='width:60px;'><input type='checkbox' name='all1'  onclick='mark_all_spam();'><a onclick='mark_all_spam();' style='cursor:pointer;text-decoration:none;color:#fff;'>Spam</a></th>
						<th style='width:90px;'><input type='checkbox' name='all2'  onclick='mark_all_notspam();'><a onclick='mark_all_notspam();' style='cursor:pointer;text-decoration:none;color:#fff;'>Not Spam</a></th></tr>";
				foreach($link_data as $spam_cmts){
					$user_cmt->id=$spam_cmts->userid;
					$user_cmt->read();
					$user_name = $user_cmt->username;
							
					$user_cmt_link->id=$spam_cmts->linkid;
					$user_cmt_link->read();
							
					$spam_output .="<tr>";
					$spam_output .= "<td>".$user_name."</td>";
					$spam_output .= "<td>".save_text_to_html($spam_cmts->cmt_content)."</td>";
					$spam_output .= '<td><center><input type="radio" name="spamcomment['.$spam_cmts->auto_id.']" id="spamcomment-'.$spam_cmts->auto_id.'" value="spamcomment"></center></td>';
					$spam_output .= '<td><center><input type="radio" name="spamcomment['.$spam_cmts->auto_id.']" id="spamcomment-'.$spam_cmts->auto_id.'" value="notspamcomment"></center></td>';
					$spam_output .="</tr>";
				}
				$spam_output .="</table>";
				$spam_output .='<p align="right" style="margin-top:10px;"><input type="submit" name="submit" value="Apply Changes" class="log2" /></p>';
				$spam_output .="</form>";
					
				$main_smarty->assign('spam_output', $spam_output);
				$main_smarty->assign('link_data', object_2_array($link_data));
			} else {
				header("Location: ".my_pligg_base."/admin/admin_index.php");
//				header('Location: ' . URL_akismet);
				die();
			}

			$main_smarty = do_sidebar($main_smarty, $navwhere);
			$main_smarty->assign('posttitle', " / " . $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel'));

			$main_smarty->assign('tpl_center', akismet_tpl_path . 'manageSpamcomments');
			$main_smarty->display($template_dir . '/admin/admin.tpl');

		}
		
		if(phpnum()>=5)
			include_once akismet_lib_path . 'Akismet.class_5.php';
		else
			include_once akismet_lib_path . 'Akismet.class_4.php';

		if($view == 'isSpam'){
			if ($_GET['action'] == "bulkmod") 
			{
				if(isset($_POST['submit'])) 
				{
					$spam = array();
					foreach ($_POST["spam"] as $k => $v) 
						$spam[intval($k)] = $v;
					foreach($spam as $key => $value) {
						if(isset($key)){ $link_id = sanitize($key, 3); } else { continue; }

						$link = new Link;
						$link->id = $link_id;
						$link->read();

						$user = new User;
						$user->id = $link->author;
						$user->read();

						if(phpnum()<5) {
							$comment = array(
							       'author'    => $user->username,
							       'email'     => $user->email,
							       'website'   => $link->url,
							       'body'      => $link->content,
							       'permalink' => my_base_url.getmyurl('story', $link->id)
							       );
							$akismet = new Akismet(my_base_url . my_pligg_base, get_misc_data('wordpress_key'), $comment);
						} else {
							$akismet = new Akismet(my_base_url . my_pligg_base, get_misc_data('wordpress_key'));
							$akismet->setCommentAuthor($user->username);
							$akismet->setCommentAuthorEmail($user->email);
							$akismet->setCommentAuthorURL($link->url);
							$akismet->setCommentContent($link->content);
							$akismet->setPermalink(my_base_url.getmyurl('story', $link->id));
						}
						if ($value == "spam") {
							$link->status = 'spam';
							$link->store();
							killspam($user->id);

							$akismet->submitSpam();
						}
						elseif ($value == "notspam") {
							$link->status = 'queued';
							$link->store();
							
							$akismet->submitHam();

						}
						$db->query("DELETE FROM ".table_prefix . "spam_links WHERE linkid=$link_id");
					}
				}
			}
			header('Location: ' . URL_akismet . '&view=manageSpam');
			die();
		}
		
		if($view == 'isSpamcomment'){
			if ($_GET['action'] == "bulkmod") 
			{
				if(isset($_POST['submit'])) 
				{
					$spamcomment = array();
					foreach ($_POST["spamcomment"] as $k => $v)
						$spamcomment[intval($k)] = $v;

					foreach($spamcomment as $key => $value) 
					{
						if(isset($key)){ $link_id = sanitize($key, 3); } else { continue; }
						$sql_result = "Select * from ".table_prefix . "spam_comments where auto_id=".$link_id;
						$result=$db->get_row($sql_result);
#print_r($result);

						$link = new Link;
						$link->id = $result->linkid;
						$link->read();
									
						$user = new User;
						$user->id = $result->userid;
						$user->read();
#print_r($user);

						if(phpnum()<5) {
							$comment = array(
							       'author'    => $user->username,
							       'email'     => $user->email,
							       'website'   => $link->url,
							       'body'      => $result->cmt_content,
							       'permalink' => my_base_url.getmyurl('story', $link->id)
							       );
							$akismet = new Akismet(my_base_url . my_pligg_base, get_misc_data('wordpress_key'), $comment);
						} else {
							$akismet = new Akismet(my_base_url . my_pligg_base, get_misc_data('wordpress_key'));
							$akismet->setCommentAuthor($user->username);
							$akismet->setCommentAuthorEmail($user->email);
							$akismet->setCommentAuthorURL($link->url);
							$akismet->setCommentContent($result->cmt_content);
							$akismet->setPermalink(my_base_url.getmyurl('story', $link->id));
						}
						if ($value == "spamcomment") 
							$akismet->submitSpam();
						elseif ($value == "notspamcomment") 
						{
							$akismet->submitHam();
									
							$sql = "INSERT INTO " . table_comments . " (comment_parent, comment_user_id, comment_link_id , comment_date, comment_randkey, comment_content) VALUES ('{$result->cmt_parent}', '{$result->userid}', '{$result->linkid}', now(), '{$result->cmt_rand}', '{$result->cmt_content}')";
							$db->query($sql);
#print $sql;
						}

						$link->adjust_comment(1);
						$link->store();
						$db->query(' Delete from '.table_prefix . 'spam_comments where auto_id='.$link_id);
					}
					
				}
				header('Location: ' . URL_akismet . '&view=manageSpamcomments');
				die();
			}
		}
	}
	else
	{
		header("Location: " . getmyurl('login', $_SERVER['REQUEST_URI']));
		die();
	}
}

function akismet_link_to_spam($link_id)
{
	global $db;
	$link = new Link;
	$link->id = $link_id;
	$link->read();
	$link->status = 'spam';
	$link->store();

	$db->query("INSERT INTO ".table_prefix . "spam_links (`auto_id` , `userid` , `linkid`) VALUES (NULL, $link->author, $link_id)");
}

function akismet_link_to_ham($link_id)
{
	global $db;
	$db->query("DELETE FROM ".table_prefix . "spam_links WHERE linkid=$link_id");
}


function akismet_comment_to_spam($comment)
{
	$sql = (" INSERT INTO ".table_prefix . "spam_comments ( `auto_id` , `userid` , `linkid` , `cmt_rand` , `cmt_content`, `cmt_date` , `cmt_parent`) VALUES ( NULL , $comment->author, $comment->link, $comment->randkey, '$comment->content', now(), $comment->parent) ");
	$result  = mysql_query($sql);
}

function akismet_get_link_count()
{
	global $db;
	return $db->get_var("SELECT COUNT(*) FROM " . table_links . " 
					LEFT JOIN " . table_prefix. "spam_links ON linkid=link_id
					WHERE !ISNULL(linkid)");

}

function akismet_get_comment_count()
{
	global $db;
	return $db->get_var("SELECT COUNT(*) FROM ".table_prefix . "spam_comments");
}
?>
