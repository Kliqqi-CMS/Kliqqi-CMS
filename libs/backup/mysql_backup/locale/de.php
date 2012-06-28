<?php

/**
 * MySQL Backup Pro German translation
 * 
 * @package GONX
 * @author Ben Yacoub Hatem <hatem@php.net>
 * @copyright Copyright (c) 2004
 * @version $Id$ - 08/04/2004 16:20:30 - en.php
 * @access public
 * @translated by Gunther Rissmann <rissmann at gmx dot de>
 **/
 
// Application title
$GONX["title"] = "&nbsp;&nbsp;MySQL Backup Pro™ ";

$GONX["deleteconfirm"] = ' Sie wollen diese Datei löschen ?\nKlicken Sie OK zur Bestätigung.';

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
$GONX['homepage'] = "<b>".$GONX["title"]."</b> ist eine Komplettlösung für MySQL Datenbank-Backup and Wiederherstellung.<br/>
			Die Benutzung dieses Programms ist sehr einfach :
			<ul>
			<li<a href=\"?go=config\" class=tab-g>Konfigurieren</a> Sie zuerst das Programm (init.php muss auf chmod  0777 gesetzt sein).</li>
			<li>Um einen Backup zu erzeugen, klicken Sie einfach auf <a href=\"?go=create\" class=tab-g>Backup erzeugen</a>.</li>
			<li>Sie können <a href=\"?go=list\" class=tab-g>eine Liste</a> vorhandener Datenbank-Backups aufrufen.</li>
			</ul>
			Vergessen Sie nicht das \"Backup\"-Verzeichnis zu schützen. Besser ist es ein Nicht-Web-Verzeichnis zu benutzen , wo das System eine Sichere Kopie des Backups ablegen kann..
			<br/><br/>
			Benutzte Datenbank : <b>".$GonxAdmin["dbname"]."</b>
			";
			
$GONX["installed"] = " ist installiert";
$GONX["notinstalled"] = " ist nicht installiert";
$GONX["compression"] = "Kompression PHP Modules";
$GONX["autherror"] = " Bitte geben Sie einen Benutzernamen und ein Passwort ein, um in den geschützten Bereich zu gelangen";

$GONX["home"] = "Home";
$GONX["create"] = " Backup erzeugen";
$GONX["list"] = "Liste/Backup importieren";
$GONX["optimize"] = "Optimieren";
$GONX["monitor"] = "Überwachen";
$GONX["logout"] = "Ausloggen";

$GONX["backup"] = "Backup von";
$GONX["iscorrectcreat"] = "wurde korrekt erzeugt in";
$GONX["iscorrectimport"] = "wurde korrekt importiert in die Datenbank";
$GONX["selectbackupfile"] = "&nbsp;&nbsp;&nbsp;&nbsp;Wählen Sie aus den vorhandenen Backup-Dateien zum Import";
$GONX["importbackupfile"] = "Oder laden Sie es von hier hoch";
$GONX["delete"] = "Delete";
$GONX["nobckupfile"] = "keine Backup-Dateien verfügbar. Klicken Sie <a href=\"?go=create\" class=tab-g>Backup erzeugen</a> um ein Backup Ihrer Datenbank herzustellen";
$GONX["importbackup"] = "Backupdatei importieren";
$GONX["importbackupdump"] = "Use MySQL Dump";
$GONX["configure"] = "Konfigurieren";
$GONX["configureapp"] = "Konfigurieren Sie das Programm </b><i>(Chmod 0777 in init.php bevor Sie diese Funktion benutzen)</i>";
$GONX["totalbackupsize"] = "Gesamtgrösse des  Backupverzeichnisses ";
$GONX["chgdisplayorder"] = "Reihenfolge der Anzeige verändern";
$GONX["next"] = "Nächstes";
$GONX["prev"] = "Vorheriges";

$GONX["structonly"] = "Nur Struktur";
$GONX["checkall"] = "Alle ankreuzen";
$GONX["uncheckall"] = "Alle deaktivieren";
$GONX["tablesmenuhelp"] = "<u>Hilfe</u>  : Wenn Sie <label>Labels</label> sehen, wurde etwas in der Tabelle verändert.";
$GONX["backupholedb"] = "Klicken Sie hier, um einen Backup der ganzen Datenbank zu erzeugen :";
$GONX["selecttables"] = "Oder wählen Sie die Tabellen, von denen Sie ein Backup herstellen wollen, hier :";

$GONX["ignoredtables"] = "Ignorierte Tabelle";
$GONX["reservedwords"] = "Reservierter MySql Ausdruck";

?>