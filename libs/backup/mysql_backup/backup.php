<?php
include_once '../libs/backup/mysql_backup/mysql_backup.class.php';
include_once('../config.php');


//---- Database host, name user and pass.
//---- Change these to match your mysql database.
$db_host = EZSQL_DB_HOST;	//---- Database host(usually localhost).
$db_name = EZSQL_DB_NAME;	//---- Your database name.
$db_user = EZSQL_DB_USER;	//---- Your database username.
$db_pass = EZSQL_DB_PASSWORD;	//---- Your database password.


$dowhat = "backup";
//$dowhat = "restore";


if ($dowhat == "backup") {
	
	// This code doesn't export dates 
	//$structure_only = false;
	//$output = "./backup/backup_data.txt";
	//$backup = new mysql_backup($db_host,$db_name,$db_user,$db_pass,$output,$structure_only);	
	//$backup->backup();

	require_once("../libs/backup/mysql_backup/init.php");
	$b = new backup;
	$b->dbconnect($GonxAdmin["dbhost"],$GonxAdmin["dbuser"],$GonxAdmin["dbpass"],$GonxAdmin["dbname"],"", $GonxAdmin["dbtype"]);
	$b->generate();
	
	$structure_only = true;
	$output = "./backup/MySQL_Structure_" . $b->filename;
	$backup = new mysql_backup($db_host,$db_name,$db_user,$db_pass,$output,$structure_only);	
	$backup->backup();
}

if ($dowhat == "restore") {
	$output = "./backup/backup_structure.txt";
	$backup = new mysql_backup($db_host,$db_name,$db_user,$db_pass,$output,$structure_only);	
	$backup->restore(";");

	$output = "./backup/backup_data.txt";
	$backup = new mysql_backup($db_host,$db_name,$db_user,$db_pass,$output,$structure_only);	
	$backup->restore(");");
}



?>
