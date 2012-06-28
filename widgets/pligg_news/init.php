<?php
$widget['widget_title'] = "Pligg News";
$widget['widget_has_settings'] = 1;
$widget['widget_shrink_icon'] = 1;
$widget['widget_uninstall_icon'] = 0;
$widget['name'] = 'Pligg News';
$widget['desc'] = 'The Pligg News widget displays the latest news items from the <a href="http://www.pligg.com/blog/" target="_blank">Pligg CMS Blog</a>.';
$widget['version'] = 0.1;

$news_count = get_misc_data('news_count');
if ($news_count <= 0) $news_count='3';

if ($_REQUEST['widget']=='pligg_news'){
    if(isset($_REQUEST['stories']))
		$news_count = sanitize($_REQUEST['stories'], 3);
    misc_data_update('news_count', $news_count);
}

if ($main_smarty){
    $main_smarty->assign('news_count', $news_count);
}

?>