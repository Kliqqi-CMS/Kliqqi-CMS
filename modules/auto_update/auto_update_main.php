<?php
function auto_update_showpage(){
	global $db, $main_smarty, $the_template, $template_dir;
		
	include_once('config.php');
	include_once(mnminclude.'html1.php');
	include_once(mnminclude.'link.php');
	include_once(mnminclude.'tags.php');
	include_once(mnminclude.'smartyvariables.php');
    	include_once("archive.php");

	// Create mysql backup
	if ($_GET['download']=='mysql')
	{
	    set_time_limit(0);
    	    require("auto_update_backup.php");
	    $b = new MysqlBackup($_GET['type']=='zip' ? '' : $_GET['type']);
    	    $tmpfname = $b->backup();

		header('Content-Description: File Transfer'); 
		header('Pragma: no-cache');
		header('Content-Type: application/force-download');
	    	header('Cache-Control: no-cache, must-revalidate');
	    	header("Content-Disposition: attachment; filename=pligg_db_backup_".date("Y_m_d").".sql".($_GET['type']=='gzip' ? '.gz' : ($_GET['type']=='zip' ? '.zip' : ''))); 

	    if ($_GET['type']=='zip')
	    {
	    	$test = new zip_file(tempnam('/tmp','')); 
	    	$test->set_options(array('inmemory' => 1, 'storepaths' => 0)); 
	    	$test->add_files(array($tmpfname)); 
	    	$test->create_archive(); 

		print($test->archive);
	    } else {
		readfile($tmpfname);
		unlink($tmpfname);
	    }
	    exit;
	}
	// Create backup of php scripts
	elseif ($_GET['download']=='files')
	{
	    set_time_limit(0);
	    $tmpfname = tempnam('/tmp','');

	    if ($_GET['type']=='gzip')
	    {
		$test = new gzip_file($tmpfname); 
		$test->set_options(array('inmemory' => 1, 'basedir' => "./", 'overwrite' => 1, 'level' => 1)); 
	    }
	    else {
		$test = new zip_file($tmpfname); 
		$test->set_options(array('inmemory' => 1, 'recurse' => 1, 'storepaths' => 1)); 
	    }
	    $test->add_files("*"); 
	    $test->exclude_files("./cache/*");
	    $test->create_archive(); 

	    // Check for errors (you can check for errors at any point) 
	    if (count($test->errors) > 0) 
	    	print ("Errors occurred."); // Process errors here 

		header('Content-Description: File Transfer'); 
		header('Pragma: no-cache');
		header('Content-Type: application/force-download');
	    	header('Cache-Control: no-cache, must-revalidate');
	    	header("Content-Disposition: attachment; filename=pligg_backup_".date("Y_m_d").($_GET['type']=='gzip' ? '.tar.gz' : '.zip')); 

		// Send archive to user for download 
		print($test->archive);
		exit;
	}

	
	$main_smarty = do_sidebar($main_smarty);

	force_authentication();
	$canIhaveAccess = 0;
	$canIhaveAccess = $canIhaveAccess + checklevel('god');
	
	if($canIhaveAccess == 1)
	{	
		// breadcrumbs
		$main_smarty->assign('navbar_where', $navwhere);
		$main_smarty->assign('posttitle', " / " . $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel'));
		// breadcrumbs
		define('modulename', 'status'); 
		$main_smarty->assign('modulename', modulename);
		
		define('pagename', 'admin_modifystatus'); 
		$main_smarty->assign('pagename', pagename);
		if ($_GET['step']==2)
		{
		    $main_smarty->assign('gzip', function_exists('gzopen'));
		    $main_smarty->assign('zip', class_exists('ZipArchive',FALSE));
		    $main_smarty->assign('tpl_center', auto_update_tpl_path . 'auto_update_step2');
		}
		elseif ($_GET['step']==3)
		{
    		    $_SESSION['upload_files'] = array();
		    $main_smarty->assign('exists', !file_exists(mnmpath."latest.zip") ? 'disabled' : '');
		    $main_smarty->assign('tpl_center', auto_update_tpl_path . 'auto_update_step3');
		}
		elseif ($_GET['step']==4)
		    $main_smarty->assign('tpl_center', auto_update_tpl_path . 'auto_update_step4');
		elseif ($_GET['step']==5)
		{
		    $main_smarty->assign('upgrade_exists', file_exists('install/upgrade.php'));
		    $main_smarty->assign('tpl_center', auto_update_tpl_path . 'auto_update_step5');
		}
		elseif ($_GET['step']==6)
		    $main_smarty->assign('tpl_center', auto_update_tpl_path . 'auto_update_step6');
		else
		    $main_smarty->assign('tpl_center', auto_update_tpl_path . 'auto_update_main');

		list($yourversion,$latestversion) = auto_update_detect_version();

	        $main_smarty->assign('yourversion', $yourversion);
	        $main_smarty->assign('latestversion', $latestversion);

		$main_smarty->display($template_dir . '/admin/admin.tpl');
	}
	else
	{
		header("Location: " . getmyurl('login', $_SERVER['REQUEST_URI']));
		die();
	}
}	

function auto_update_detect_version()
{
	if (!session_id())
	    session_start();
	if (!$_SESSION['latestversion'])
	{
		$url = 'http://www.pligg.com/download.php';
		$data = file_get_contents($url);
		if (preg_match('/<h1>Pligg Version(.+?)<\/h1>/',$data,$m))
		    $latestversion = trim(strip_tags($m[1]));
		$_SESSION['latestversion'] = $latestversion;
	}
	
	if (!$_SESSION['yourversion'])
	{
		$sql = "SELECT data FROM " . table_misc_data . " WHERE name = 'pligg_version'";
		if ($result=mysql_query($sql)) {
		  if ($row=mysql_fetch_row($result)) {
		    $yourversion = $row[0];
		  }
		}
		$_SESSION['yourversion'] = $yourversion;
	}
	return array($_SESSION['yourversion'],$_SESSION['latestversion']);
}

?>
