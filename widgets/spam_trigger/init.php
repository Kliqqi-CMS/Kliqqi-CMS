<?php
$widget['widget_title'] = "Spam Trigger Alert!";
$widget['widget_has_settings'] = 0;
$widget['widget_shrink_icon'] = 1;
$widget['widget_uninstall_icon'] = 1;
$widget['name'] = 'Spam Trigger';
$widget['desc'] = 'This widget will alert you when the Spam Trigger module has an article or comment awaiting moderation.';
$widget['version'] = 1.0;

if ($_REQUEST['widget']=='Spam Trigger')
{
global $db;
$links = $db->get_var("SELECT COUNT(*) FROM ".table_links." WHERE link_status='moderated'");
$comments = $db->get_var("SELECT COUNT(*) FROM ".table_comments." WHERE comment_status='moderated'");
if ($links==0 || $comments==0){
	$widget['column'] = '';
}
}

?>
