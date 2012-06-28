<?php

/**
 * MySQL Backup Pro English translation
 * 
 * @package GONX
 * @author Ben Yacoub Hatem <hatem@php.net>
 * @copyright Copyright (c) 2004
 * @version $Id$ - 08/04/2004 16:20:30 - en.php
 * @access public
 **/
 
// Application title
$GONX["title"] = "&nbsp;&nbsp;MySQL Backup Pro™ ";

$GONX["deleteconfirm"] = ' Are you sure you want to delete this file ?\nClick OK to confirm.';

$GONX["header"] = '<html>
<head>
<title>'.$GONX["title"].'</title>
<style type="text/css" media="screen">@import "style.css";</style>
<script language="JavaScript" type="text/javascript">
<!--
function ConfirmDelete() {
	return confirm("'.$GONX["deleteconfirm"].'");
}
//-->
</script>
</head>
<body>
';

// Home page content
$GONX['homepage'] = "<b>".$GONX["title"]."</b> is a complete solution for MySQL database Backup and restore.<br/>
			Usage of the application is very easy :
			<ul>
			<li>First <a href=\"?go=config\" class=tab-g>configure</a> your application (init.php should be chmod to 0777).</li>
			<li>To create a backup just click on <a href=\"?go=create\" class=tab-g>Create a Backup</a>.</li>
			<li>You can <a href=\"?go=list\" class=tab-g>list</a> available DB Backups to restore the copy you want.</li>
			</ul>
			Don't forget to protect \"backup\" directory, and it would be better if you create a non-web directory, where
			the system can create safe copy of the Database.
			<br/><br/>
			Database used : <b>".$GonxAdmin["dbname"]."</b>
			";
			
$GONX["installed"] = " is installed";
$GONX["notinstalled"] = " is not installed";
$GONX["compression"] = "Compression PHP Modules";
$GONX["autherror"] = " Please enter a correct login and password to access this area";

$GONX["home"] = "Home";
$GONX["create"] = "Create a Backup";
$GONX["list"] = "List/Import backup";
$GONX["optimize"] = "Optimize";
$GONX["monitor"] = "Monitor";
$GONX["logout"] = "Logout";
			
$GONX["backup"] = "Backup of";
$GONX["iscorrectcreat"] = "is correctly created in";
$GONX["iscorrectimport"] = "is correctly imported to database";
$GONX["selectbackupfile"] = "&nbsp;&nbsp;&nbsp;&nbsp;Select from the available backup files to import";
$GONX["importbackupfile"] = "Or upload it from here";
$GONX["delete"] = "Delete";
$GONX["nobckupfile"] = "No backup files available. Click on <a href=\"?go=create\" class=tab-g>Create a Backup</a> to create a backup of your DB";
$GONX["importbackup"] = "Import Backup file";
$GONX["importbackupdump"] = "Use MySQL Dump";
$GONX["configure"] = "Config";
$GONX["configureapp"] = "Configure your application </b><i>(Chmod 0777 init.php before using this function)</i>";
$GONX["totalbackupsize"] = "Total size of Backup directory ";
$GONX["chgdisplayorder"] = "Change display order";
$GONX["next"] = "Next";
$GONX["prev"] = "Prev";

$GONX["structonly"] = "Structure only";
$GONX["checkall"] = "Check All";
$GONX["uncheckall"] = "Uncheck All";
$GONX["tablesmenuhelp"] = "<u>Help</u>  : If you see <label>labels</label> it mean that there are changes in that tables.";
$GONX["backupholedb"] = "Click here to create a backup of the hole database :";
$GONX["selecttables"] = "Or select tables to backup from here :";

$GONX["ignoredtables"] = "Ignored table";
$GONX["reservedwords"] = "Reserved mysql word";

?>