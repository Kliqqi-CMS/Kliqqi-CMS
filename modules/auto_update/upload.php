<?php
session_start();
include_once('../../Smarty.class.php');
$main_smarty = new Smarty;
$main_smarty->compile_dir = "../../cache/templates_c";

include('../../config.php');
include('../../libs/html1.php');
include('../../libs/link.php');
include_once('../../libs/utils.php');
include_once('archive.php');
set_time_limit(0);

if (!isset($_SESSION['upload_files']))
    $_SESSION['upload_files'] = array();

// Upload a file 
if ($_POST['where']=='upload')
{
	$_SESSION['upload_files'] = array();

	if ($_FILES["latest"]["error"] == UPLOAD_ERR_OK) 
	{
            $tmp_name = $_FILES["latest"]["tmp_name"];
            $name = $_FILES["latest"]["name"];
            if (@move_uploaded_file($tmp_name, mnmpath."latest.zip"))
	    {
	    	$_SESSION['upload_files'] = array('percent' => 100);
	    	print "File uploaded successfully";
	    }
	    else
		$error = "Error copying file to ".mnmpath."latest.zip";
        }
	else
	    $error = "Error uploading file";

	if ($error)
	    $_SESSION['upload_files'] = array('error' => $error);
}
// Download from pligg.com
elseif ($_REQUEST['where']=='download')
{
	$_SESSION['upload_files'] = array();

        $crlf = "\r\n";
        $req = 'GET http://www.pligg.com/downloads/latest.zip HTTP/1.0' . $crlf
           .    'Host: www.pligg.com' . $crlf
           .    $crlf;
	$fp = fsockopen('www.pligg.com', 80, $errno, $errstr, 30);
	if(!$fp)
	    $error = $errstr;
	else
	{
	    $res = fopen(mnmpath."latest.zip", 'w');
	    if (!$res)
		$error = "Can't open file ".mnmpath."latest.zip";
	    else
	    {
		fwrite($fp, $req);
		$header = true;
	        while(is_resource($fp) && $fp && !feof($fp))
		{
	           $response = fgets($fp, 1024);
		   if (!$header)
		   {
		   	fwrite($res,$response);	
			if (!strstr($headers,' 200 '))
			    $error = "HTTP error";
		   }
		   else
			$headers .= $response;
		   if ($response == "\r\n") $header = false;
		}
	        fclose($res);
		$_SESSION['upload_files']['percent']=100;
	    }
	    fclose($fp);
	}
	if ($error)
	    $_SESSION['upload_files'] = array('error' => $error);
}
// Unzip latest.zip
elseif ($_POST['where']=='unzip')
{
	$_SESSION['upload_files'] = array();

	require "zip.class.php"; // Get the zipfile class 
	$zipfile = new zipfile; // Create an object 
	$zipfile->unzip("../../latest.zip",mnmpath); 

	// Check for errors	
	foreach($zipfile->files as $filea) 
	{
	    $_SESSION['upload_files'] = array('error' => $filea['error']);
	    exit;
	}

	$_SESSION['upload_files']['percent']=100;

}
elseif ($_GET['cleanup'])
{
	if (file_exists("../../settings.php.default") && !@unlink("../../settings.php.default"))
	    $error .= "Can't remove settings.php.default<br>";
	if (file_exists("../../libs/dbconnect.php.default") && !@unlink("../../libs/dbconnect.php.default"))
	    $error .= "Can't remove /libs/dbconnect.php.default<br>";

	$dir = '../../install';
	if($dh = @opendir($dir)) 
	{
	    while (false !== ($obj = readdir($dh))) 
	    { 
	        if($obj == '.' || $obj == '..' || is_dir("$dir/$obj")) 
	            continue; 
	
	        if (!@unlink($dir . '/' . $obj)) 
		    $error .= "Can't remove $dir/$obj<br>";
	    } 
	    closedir($dh); 
            @rmdir($dir); 
	} 

    	if (file_exists("../../latest.zip") && !@unlink("../../latest.zip"))
	    $error .= "Can't remove latest.zip<br>";

	if (!session_id())
	    session_start();
	unset($_SESSION['latestversion']);
	unset($_SESSION['yourversion']);

	if ($error)
	    print "ERROR: $error";
	else
	    print "100";
}
// Check upload status by linkID and file number
elseif ($_GET['status'] && isset($_SESSION['upload_files']))
{
	if ($_SESSION['upload_files']['error'])
	{
	    print "ERROR: ".$_SESSION['upload_files']['error'];
	    exit;
	}
	print $_SESSION['upload_files']['percent'];
}

?>
