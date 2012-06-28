<?php

/**
 * MySQL Backup Pro Dutch translation
 * 
 * @package GONX
 * @author Ben Yacoub Hatem <hatem@php.net>
 * @copyright Copyright (c) 2004
 * @version $Id$ - 08/04/2004 16:20:30 - en.php
 * @access public
 * @translated by Teye Heimans <t dot heimans at www dot cyberpoint dot nl>
 **/
 
// Application title
$GONX["title"] = "&nbsp;&nbsp;MySQL Backup Pro™ ";

$GONX["deleteconfirm"] = ' Weet u zeker dat u dit bestand wilt verwijderen ?\nKlik OK voor bevestiging.';

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
$GONX['homepage'] = "<b>".$GONX["title"]."</b> is een complete oplossing voor het maken en herstellen van een MySQL backup.<br/>
			Gebruik van de applicatie is erg makkelijk:
			<ul>
			<li>Eerst <a href=\"?go=config\" class=tab-g>configureer</a> de applicatie (init.php moet chmod rechten 0777 hebben).</li>
            <li>Om een backup te maken klik op <a href=\"?go=create\" class=tab-g>Maak een Backup</a>.</li>
			<li>Je kunt een <a href=\"?go=list\" class=tab-g>lijst</a> van beschikbare DB Backups tonen om de database te herstellen.</li>
			</ul>
			Vergeet niet de \"backup\" directory te beveiligen, en het zou nog beter zijn als dit een non-web directory zou zijn, waar
			het system de kopie van de database kan plaatsen.
			<br/><br/>
			Database welke wordt gebruikt : <b>".$GonxAdmin["dbname"]."</b>
			";
			
$GONX["installed"]          = " is geïnstalleerd";
$GONX["notinstalled"]       = " is niet geïnstalleerd";
$GONX["compression"]        = "Compression PHP Modules";
$GONX["autherror"]          = " Voer uw gebruikersnaam en wachtwoord in voor toegang tot deze pagina";

$GONX["home"]               = "Home";
$GONX["create"]             = "Maak een Backup";
$GONX["list"]               = "Toon/Importeer backup";
$GONX["optimize"]           = "Optimaliseer";
$GONX["monitor"]            = "Monitor";
$GONX["logout"]             = "Uitloggen";
			
$GONX["backup"]             = "Backup van";
$GONX["iscorrectcreat"]     = "is succesvol gemaakt in ";
$GONX["iscorrectimport"]    = "is succesvol geïmporteerd in de database";
$GONX["selectbackupfile"]   = "&nbsp;&nbsp;&nbsp;&nbsp;Selecteer één van de backup bestanden om te importeren";
$GONX["importbackupfile"]   = "Of upload hier";
$GONX["delete"]             = "Verwijder";
$GONX["nobckupfile"]        = "Geen backup bestanden aanwezig. Klik op <a href=\"?go=create\" class=tab-g>Maak een Backup</a> om een backup van je DB te maken";
$GONX["importbackup"]       = "Importeer Backup bestanden";
$GONX["importbackupdump"]   = "Gebruik MySQL Dump";
$GONX["configure"]          = "Configureer";
$GONX["configureapp"]       = "Configureer de applicatie </b><i>(Chmod 0777 init.php voor het gebruik van deze functie)</i>";
$GONX["totalbackupsize"]    = "Totale grootte van backup directory ";
$GONX["chgdisplayorder"]    = "Verander weergave volgorde";
$GONX["next"]               = "Volgende";
$GONX["prev"]               = "Vorige";

$GONX["structonly"]         = "Aleen structuur";
$GONX["checkall"]           = "Selecteer allemaal";
$GONX["uncheckall"]         = "Deselecteer allemaal";
$GONX["tablesmenuhelp"]     = "<u>Help</u>  : Als je <label>labels</label> ziet betekend het dat er veranderingen zijn in die tabellen.";
$GONX["backupholedb"]       = "Klik hier om een backup te maken van de complete database :";
$GONX["selecttables"]       = "Of selecteer hier tabel(len) om te backuppen :";

$GONX["ignoredtables"]      = "Negeerde tabel";
$GONX["reservedwords"]      = "Gereserveerd mysql woord";

?>