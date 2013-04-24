{php}

include_once('internal/Smarty.class.php');
$main_smarty = new Smarty;

include_once('config.php');
include_once(mnminclude.'html1.php');
include_once(mnminclude.'link.php');
include_once(mnminclude.'tags.php');
include_once(mnminclude.'search.php');
include_once(mnminclude.'smartyvariables.php');

global $the_template, $main_smarty, $db;

$body = '';

$res = "SELECT * FROM ".table_comments."
  LEFT JOIN ".table_links." ON comment_link_id = link_id
  LEFT JOIN ".table_users." ON comment_user_id=user_id
  WHERE (link_status='published' OR link_status='new') AND comment_status='published'
  ORDER BY comment_date DESC
  LIMIT ".comments_size_sidebar."";
$list_comments = $db->get_results($res);

if($list_comments)
	{
	foreach($list_comments as $row){
		if ($row->link_title_url == ""){
			$story_url = getmyurl("story", $row->link_id);
		} else {
			$link = new Link;
			$link->id=$row->link_id;
			$link->read();
			$story_url = getmyurl("storyURL", $link->category_safe_names(), urlencode($row->link_title_url), $row->link_id);
		}
			$main_smarty->assign('comment_url', $story_url."#c".$row->comment_id);
			$main_smarty->assign('comment_text', ShortenText(save_text_to_html($row->comment_content)));
			$main_smarty->assign('Avatar_ImgSmall', get_avatar('small', '', $row->user_login, $row->user_email));
			$main_smarty->assign('Avatar_ImgLarge', get_avatar('large', '', $row->user_login, $row->user_email));
			$main_smarty->assign('username', $row->user_login);
			$main_smarty->assign('user_view_url', getmyurl('user', $row->user_login));
			$body .= $main_smarty->fetch($my_base_url . './modules/sidebar_comments/templates/sidebar_comments.tpl');		
		}
	}

$main_smarty->assign('live_url', getmyurl("comments"));
$main_smarty->assign('sc_body', $body);
$main_smarty->display($my_base_url . './modules/sidebar_comments/templates/sidebar_comments_wrapper.tpl');
$main_smarty->assign('ss_toggle_id', 'latcomments');

// determine the amount of characters to show for each comment
function ShortenText($text) {
	$chars = comments_length_sidebar;

	$text = strip_tags($text);
	$text = $text." ";
	$text = substr($text,0,$chars);
	$text = substr($text,0,strrpos($text,' '));
	$text = $text."...";
	return $text;
}

function comments_category_safe_name($category) {
	global $dblang, $the_cats;

	foreach($the_cats as $cat){
	if($cat->category_id == $category && $cat->category_lang == $dblang)
		{
		return $cat->category_safe_name;
		}
	}
}

{/php}