<?php

/**
* MySQL Backup Pro Tagalog translation
*
* @package GONX
* @author Ben Yacoub Hatem <hatem@php.net>
* @copyright Copyright (c) 2004
* @version $Id$ - 08/04/2004 16:20:30 - en.php
* @translated by Janet Fransisco
* @access public
**/

// Application title
$GONX["title"] = "&nbsp;&nbsp;MySQL Backup Pro™ ";

$GONX["deleteconfirm"] = ' Sigurado ka bang aalisin ang file na ito ?\nClick OK to confirm.';

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
$GONX['homepage'] = "<b>".$GONX["title"]."</b> ay isang kumpletong solusyon para sa MySQL database Backup and restore.<br/>
			Ang pag-gamit ng programa ay napaka-dali lamang :
			<ul>
			<li>Una <a href=\"?go=config\" class=tab-g>configure</a> ang inyong aplikasyon (init.php should be chmod to 0777).</li>
			<li>Para makagawa ng back-up  <a href=\"?go=create\" class=tab-g>Pag-gawa ng backup</a>.</li>
			<li>Pwede mong <a href=\"?go=list\" class=tab-g>ilista</a> ang kasalukuyang DB Backups para ma-restore ang kopya na gusto.</li>
			</ul>
			Huwag kalimutan ingatan ang \"backup\" direktory, at maka-bubuti kung gumawang non-web direktory, kung saan ang system ay maka-gagawa ng ligtas na kopyapara sa Database.
			<br/><br/>
			Database na ginamit : <b>".$GonxAdmin["dbname"]."</b>
			";

$GONX["installed"] = " ay installed";
$GONX["notinstalled"] = " ay hindi installed";
$GONX["compression"] = "Compression PHP Modules";
$GONX["autherror"] = " Ilagay and tamang login at password para makarating sa access area";

$GONX["home"] = "Panimula";
$GONX["create"] = "Gumawa ng Backup";
$GONX["list"] = "Listahan/Import backup";
$GONX["optimize"] = "Optimize";
$GONX["monitor"] = "Pagsubaybay";
$GONX["logout"] = "Logout";

$GONX["backup"] = "Backup ng";
$GONX["iscorrectcreat"] = "tamang nagawa na";
$GONX["iscorrectimport"] = "nagawa nang ilagay sa database";
$GONX["selectbackupfile"] = "&nbsp;&nbsp;&nbsp;&nbsp;Pumili ng kaaslukuyang backup ng files para sa import";
$GONX["importbackupfile"] = "Pwede i-upload dito";
$GONX["delete"] = "Burahin";
$GONX["nobckupfile"] = "Walang backup files na meron. Pindutin ang <a href=\"?go=create\" class=tab-g>Gumawa ng Backup</a> para makagawa ng backup ng DB";
$GONX["importbackup"] = "Ilipat ang Backup file";
$GONX["importbackupdump"] = "Gamitin ang MySQL Dump";
$GONX["configure"] = "Config";
$GONX["configureapp"] = "Ayusin ang application </b><i>(Chmod 0777 init.php bago gamitin ang function)</i>";
$GONX["totalbackupsize"] = "Kabuuang sukat ng Backup directory ";
$GONX["chgdisplayorder"] = "Baguhin display order";
$GONX["next"] = "Susunod";
$GONX["prev"] = "Kasalukuyan";

$GONX["structonly"] = "Structure lang";
$GONX["checkall"] = "Check lahat";
$GONX["uncheckall"] = "Walang check lahat";
$GONX["tablesmenuhelp"] = "<u>Tulong</u>  : Kung makita mo ang <label>labels</label> ibig sabihin ay may pag-babago sa mga labels";
$GONX["backupholedb"] = "Piliin para makagawa ng backup sa hole database :";
$GONX["selecttables"] = "O pumili ng tables para sa backup :";

$GONX["ignoredtables"] = "Ignored table";
$GONX["reservedwords"] = "Reserved mysql word";

?>