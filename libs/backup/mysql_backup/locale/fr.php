<?php

/**
 * MySQL Backup Pro French translation
 * 
 * @package GONX
 * @author Ben Yacoub Hatem <hatem@php.net>
 * @copyright Copyright (c) 2004
 * @version $Id$ - 08/04/2004 16:20:30 - fr.php
 * @access public
 **/
 
// Application title
$GONX["title"] = "&nbsp;&nbsp;MySQL Backup Pro™ ";


$GONX["deleteconfirm"] = ' Etes vous sur de vouloir supprimer cette copie ?\nCliquer sur OK pour confirmer.';

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
$GONX['homepage'] = "<b>".$GONX["title"]."</b> est une solution compléte pour les copies de sauvegardes de bases de données MySQL.<br/>
			L'utilisation de l'application est assez simple :
			<ul>
			<li>En premier lieu <a href=\"?go=config\" class=tab-g>configurer</a> votre application (init.php doit être accessible en écriture - chmod 0777).</li>
			<li>Pour créer une backup veuillez cliquer sur <a href=\"?go=create\" class=tab-g>Créer une sauvegarde</a>.</li>
			<li>Vous pouvez <a href=\"?go=list\" class=tab-g>lister</a> les copies de sauvegardes disponible et restaurer la version que vous voulez.</li>
			</ul>
			Attention !! Vous devez protéger le répertoire \"backup\", et il sera préférable d'utiliser un répertoire non-web et vérifier que ce fichier
			est accessible en lecture écriture (chmod 666).
			<br/><br/>
			Base de données utilisée : <b>".$GonxAdmin["dbname"]."</b>
			";
			
$GONX["installed"] = " est installé";
$GONX["notinstalled"] = " n'est pas installé";
$GONX["compression"] = "Compression PHP Modules";
$GONX["autherror"] = " Veuillez entrer un login et mot de passe correct pour accéder à cette page";

$GONX["home"] = "Accueil";
$GONX["create"] = "Créer copie";
$GONX["list"] = "Lister / Importer";
$GONX["optimize"] = "Optimiser";
$GONX["monitor"] = "Moniteur";
$GONX["logout"] = "Déconnecter";
			
$GONX["backup"] = "Copie de sauvegarde de ";
$GONX["iscorrectcreat"] = "est correctement crée dans";
$GONX["iscorrectimport"] = "est correctement crée importé dans la base de données";
$GONX["selectbackupfile"] = "&nbsp;&nbsp;&nbsp;&nbsp;Veuillez choisir la copie de sauvegarde à importer depuis cette liste";
$GONX["importbackupfile"] = "Ou bien télécharger votre fichier de sauvegarde";
$GONX["delete"] = "Supprimer";
$GONX["nobckupfile"] = "Aucune copie de sauvegarde disponible. Cliquer sur <a href=\"?go=create\" class=tab-g>Créer une sauvegarde</a> pour sauvegarder votre BD";
$GONX["importbackup"] = "Importer une copie de sauvegarde";
$GONX["importbackupdump"] = "Utiliser MySQL Dump";
$GONX["configure"] = "Config";
$GONX["configureapp"] = "Configurer votre application </b><i>(Chmod 0777 init.php avant d'utiliser cette fonction)</i>";
$GONX["totalbackupsize"] = "Taille totale du répertoire de sauvegarde ";
$GONX["chgdisplayorder"] = "Modifier l'ordre d'affichage";
$GONX["next"] = "Suivante";
$GONX["prev"] = "Précédente";

$GONX["structonly"] = "Structure uniquement";
$GONX["checkall"] = "Sélectionner tout";
$GONX["uncheckall"] = "Sélectionner aucun";
$GONX["tablesmenuhelp"] = "<u>Aide</u>  : Si vous trouvez <label>un label</label> ça veut dire qu'il y a eu des changements dans cette table.";
$GONX["backupholedb"] = "Cliquez ici pour créer une copie de sauvegarde de la base entiére :";
$GONX["selecttables"] = "Ou bien sélectionnez les tables à sauvegarder :";

$GONX["ignoredtables"] = "Table ignorée ";
$GONX["reservedwords"] = "Mot MySQL réservé";

?>