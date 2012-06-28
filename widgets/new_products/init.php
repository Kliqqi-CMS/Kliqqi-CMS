<?php
$widget['widget_title'] = "New Products";
$widget['widget_has_settings'] = 1;
$widget['widget_shrink_icon'] = 0;
$widget['widget_uninstall_icon'] = 0;
$widget['name'] = 'New Products';
$widget['desc'] = 'This widget displays the latest products available in the Pligg Pro Shop';
$widget['version'] = 0.1;

$product_count = get_misc_data('product_count');
if ($product_count<=0) $product_count='3';

if ($_REQUEST['widget']=='pligg_products'){
    if(isset($_REQUEST['products']))
		$product_count = sanitize($_REQUEST['products'], 3);
    misc_data_update('product_count', $product_count);
}

if ($main_smarty){
    $main_smarty->assign('product_count', $product_count);
}

?>