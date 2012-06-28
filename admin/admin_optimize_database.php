<?php
include_once('../Smarty.class.php');
$main_smarty = new Smarty;

include('../config.php');
include(mnminclude.'html1.php');
include(mnminclude.'link.php');
include(mnminclude.'user.php');
include(mnminclude.'smartyvariables.php');

// If called from a browser, required authentication. Cron version does not require.
if ($_SERVER['SERVER_ADDR'])
{
	check_referrer();

	// require user to log in
	force_authentication();

	// restrict access to god only
	$canIhaveAccess = 0;
	$canIhaveAccess = $canIhaveAccess + checklevel('god');

	if($canIhaveAccess == 0){	
//		$main_smarty->assign('tpl_center', '/admin/admin_access_denied');
//		$main_smarty->display($template_dir . '/admin/admin.tpl');		
		header("Location: " . getmyurl('login', $_SERVER['REQUEST_URI']));
		die();
	}
}

// $message = "";

    $query = "SHOW TABLE STATUS";
    $result=mysql_query($query);
    $table_list = "";
    while ($cur_table = mysql_fetch_object($result)) {
        $table_list .= $cur_table->Name.", ";
    }

	echo '<div style="padding:8px;margin:14px 2px;border:1px solid #bbb;background:#eee;">';
	
    if (!empty($table_list)) {
        $table_list = substr($table_list, 0, -2);
        $query = "OPTIMIZE TABLE ".$table_list;
        mysql_query($query);
	if (mysql_error())
		echo '	<p style=\'font:13px arial, "Lucida Grande","Lucida Sans Unicode",Tahoma,Verdana,sans-serif;\'>'.mysql_error().'</p>';
	else
        echo '	<h2 style="font-size: 18px;margin:0;padding:0;border-bottom:1px solid #629ACB;">'.$main_smarty->get_config_vars("PLIGG_Visual_AdminPanel_Optimized").'</h2>';
		echo '	<p style=\'font:13px arial, "Lucida Grande","Lucida Sans Unicode",Tahoma,Verdana,sans-serif;\'>'.$main_smarty->get_config_vars("PLIGG_Visual_AdminPanel_Optimized_Message").'</p>';
		echo '	<p style=\'font:13px arial, "Lucida Grande","Lucida Sans Unicode",Tahoma,Verdana,sans-serif;\'><a style="color:#094F89;" href="admin_links.php" onclick="parent.$.fn.colorbox.close(); return false;">'.$main_smarty->get_config_vars("PLIGG_Visual_AdminPanel_Return_Admin").'</a></p>';
    }
	
	echo '</div>';

?>