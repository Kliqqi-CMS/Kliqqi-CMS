<?php

$GonxAdmin["dbhost"] = EZSQL_DB_HOST;
$GonxAdmin["dbname"] = EZSQL_DB_NAME;
$GonxAdmin["dbuser"] = EZSQL_DB_USER;
$GonxAdmin["dbpass"] = EZSQL_DB_PASSWORD;
$GonxAdmin["dbtype"] = "mysql";
$GonxAdmin["compression"] = array("bz2","zlib");
$GonxAdmin["compression_default"] = "zlib";
$GonxAdmin["login"] = "admin";
$GonxAdmin["pass"] = "pass";
$GonxAdmin["locale"] = "en";
$GonxAdmin["pagedisplay"] = 10;
//$GonxAdmin["mysqldump"] = "D:/mysql/bin/mysqldump.exe";


require_once("libs/db.class.php");
require_once("libs/gonxtabs.class.php");
require_once("libs/backup.class.php");
require_once("libs/locale.class.php");	// Localisation class


?>