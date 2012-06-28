{php}
global $db;
$links = $db->get_var("SELECT COUNT(*) FROM ".table_links." WHERE link_status='moderated'");
$comments = $db->get_var("SELECT COUNT(*) FROM ".table_comments." WHERE comment_status='moderated'");
if ($links>0 || $comments>0)
{
    print('<p>');
    printf($this->_confs['PLIGG_Spam_Trigger_Notification'], 
	$links>0 ? "<strong>There are <a href='admin_links.php?filter=moderated' style='text-decoration:underline;'>$links stories awaiting moderation</a>!</strong>" : 'There are no stories awaiting moderation.', 
	$comments>0 ? "<strong>There are <a href='admin_comments.php?filter=moderated' style='text-decoration:underline;'>$comments comments awaiting moderation</a>!</strong>" : 'There are no comments awaiting moderation.');
    print('</p>');
}
{/php}