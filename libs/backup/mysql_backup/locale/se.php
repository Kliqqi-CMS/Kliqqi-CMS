<?php

/**
 * MySQL Backup Pro Swedish translation
 * 
 * @package GONX
 * @author Ben Yacoub Hatem <hatem@php.net>
 * @copyright Copyright (c) 2004
 * @version $Id$ - 08/04/2004 16:20:30 - en.php
 * @access public
 * @Swedish localization by Björn Mildh <bjorn at mildh dot se>
 **/
 
// Application title
$GONX["title"] = "&nbsp;&nbsp;MySQL Backup Pro™ ";

$GONX["deleteconfirm"] = ' Vill du verkligen radera den här filen?\nKlicka OK för att bekräfta.';

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
$GONX['homepage'] = "<b>".$GONX["title"]."</b> är en komplett lösning för att säkerhetskopiera och återställa en MySQL-databas.<br/>
			Det är enkelt att använda detta program:
			<ul>
			<li>Börja med dina <a href=\"?go=config\" class=tab-g>inställningar</a> (init.php ska vara chmod till 0777).</li>
			<li>För att skapa en säkerhetskopia, klicka på <a href=\"?go=create\" class=tab-g>Skapa en säkerhetskopia</a>.</li>
			<li>Du kan <a href=\"?go=list\" class=tab-g>lista</a> tillgängliga säkerhetskopior för att återställa till den kopia du vill ha.</li>
			</ul>
			Glöm inte att skydda \"backup\"-katalogen. Det bästa är om du skapar den utanför webb-katalogen där systemet kan skapa en skyddade kopior av databasen.
			<br/><br/>
			Använd databas: <b>".$GonxAdmin["dbname"]."</b>
			";
			
$GONX["installed"] = " är installerad";
$GONX["notinstalled"] = " är inte installerad";
$GONX["compression"] = "PHP kompressions-moduler";
$GONX["autherror"] = " Fyll i korrekt användarnamn och lösenord för att fortsätta";

$GONX["home"] = "Hem";
$GONX["create"] = "Skapa en säkerhetskopia";
$GONX["list"] = "Lista/Importera säkerhetskopior";
$GONX["optimize"] = "Optimera";
$GONX["monitor"] = "Detaljer";
$GONX["logout"] = "Logga ut";
			
$GONX["backup"] = "Säkerhetskopia från";
$GONX["iscorrectcreat"] = "blev korrekt skapad i";
$GONX["iscorrectimport"] = "blev korrekt importerad i databasen";
$GONX["selectbackupfile"] = "&nbsp;&nbsp;&nbsp;&nbsp;Välj någon av de tillgängliga säkerhetskopiorna att återställa från";
$GONX["importbackupfile"] = "Eller ladda upp den här";
$GONX["delete"] = "Radera";
$GONX["nobckupfile"] = "Ingen säkerhetskopia tillgänglig. Välj <a href=\"?go=create\" class=tab-g>Skapa säkerhetskopia</a> för att skapa en säkerhetskopia av din databas";
$GONX["importbackup"] = "Importera säkerhetskopia från fil";
$GONX["importbackupdump"] = "Använd MySQL Dump";
$GONX["configure"] = "Inställningar";
$GONX["configureapp"] = "Gör inställningar för ditt program </b><i>(init.php måste vara chmod 0777 innan denna funktion används)</i>";
$GONX["totalbackupsize"] = "Total storlek av alla säkerhetskopior ";
$GONX["chgdisplayorder"] = "Ändra listans sortering";
$GONX["next"] = "Nästa";
$GONX["prev"] = "Förra";

$GONX["structonly"] = "Endast struktur";
$GONX["checkall"] = "Markera alla";
$GONX["uncheckall"] = "Avmarkera alla";
$GONX["tablesmenuhelp"] = "<u>Hjälp</u>  : om du ser <label>rubriker</label> betyder det att tabellen ändrats.";
$GONX["backupholedb"] = "Klicka här för att skapa en säkerhetskopia av hela databasen:";
$GONX["selecttables"] = "Eller välj de tabeller du vill säkerhetskopiera här:";

$GONX["ignoredtables"] = "Ignorerade tabeller";
$GONX["reservedwords"] = "Reserverade ord för MySQL";

?>