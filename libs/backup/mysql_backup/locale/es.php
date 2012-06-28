<?php

/**
 * MySQL Backup Pro traducción al castellano
 * 
 * @package GONX
 * @author Ben Yacoub Hatem <hatem@php.net>
 * @copyright Copyright (c) 2004
 * @version $Id$ - 08/04/2004 16:20:30 - en.php
 * @access public
 * @traduccion - Jose L. Calle 12/04/2004
 **/
 
// Application title
$GONX["title"] = "&nbsp;&nbsp;MySQL Backup Pro™ ";


$GONX["deleteconfirm"] = '¿Are you sure you want to delete this file ?\nClick OK to confirm.';

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
$GONX['homepage'] = "<b>".$GONX["title"]."</b> es la soluci&oacute;n para hacer copias de seguridad y restauraci&oacute;n de tus bases de datos, en MySQL.<br/>
			El uso de esta aplicaci&oacute;n es muy sencillo:
			<ul>
			<li>Primero tienes que <a href=\"?go=config\" class=tab-g>configurar</a> la aplicaci&oacute;n, para ello el fichero init.php deber&iacute;a cambiarse (chmod 0777 init.php).</li>
			<li>Para crear la copia de seguridad haz click en <a href=\"?go=create\" class=tab-g>Crear Backup</a>.</li>
			<li>Puedes ver la <a href=\"?go=list\" class=tab-g>lista</a> de copias de seguridad disponibles, para restaurarlas cuando quieras.</li>
			</ul>
			No olvides proteger el directorio de \"backup\". Ser&iacute;a aconsejable crearlo fuera de los directorios de la web, donde
			el sistema pueda crear copias seguras de la base de datos.
			<br/><br/>
			Base de datos en uso: <b>".$GonxAdmin["dbname"]."</b>
			";
			
$GONX["installed"] = " est&aacute; instalado";
$GONX["notinstalled"] = " no est&aacute; instalado";
$GONX["compression"] = "M&oacute;dulos de compresi&oacute;n PHP";
$GONX["autherror"] = " Por favor, introduce un usuario y contraseña para acceder";

$GONX["home"] = "Inicio";
$GONX["create"] = "Crear Backup";
$GONX["list"] = "Listar/Importar backup";
$GONX["optimize"] = "Optimizar";
$GONX["monitor"] = "Monitor";
$GONX["logout"] = "Salir";
			
$GONX["backup"] = "Backup de";
$GONX["iscorrectcreat"] = "ha sido correctamente creado en";
$GONX["iscorrectimport"] = "ha sido corectamente importado a la base de datos";
$GONX["selectbackupfile"] = "&nbsp;&nbsp;&nbsp;&nbsp;Selecciona de los ficheros de backup disponibles, cuales quieres importar";
$GONX["importbackupfile"] = "O b&uacute;scalos aqu&iacute;";
$GONX["delete"] = "Eliminar";
$GONX["nobckupfile"] = "No hay ficheros de backup disponibles. Haz click en <a href=\"?go=create\" class=tab-g>Crear Backup</a> para crear una copia de seguridad de tu DB";
$GONX["importbackup"] = "Importar fichero de backup";
$GONX["importbackupdump"] = "Use MySQL Dump";
$GONX["configure"] = "Configurar";
$GONX["configureapp"] = "Configura tu aplicaci&oacute;n </b><i>(Chmod 0777 init.php antes de usar esta funci&oacute;n)</i>";
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