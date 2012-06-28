<?php
if (!$step) { header('Location: ./install.php'); die(); }
echo '<div class="instructions">';
$file='../config.php';
if (!file_exists($file)) { $errors[]="$file " . $lang['NotFound'] ; }
elseif (filesize($file) <= 0) { $errors[]="$file " . $lang['ZeroBytes'] ; }

$file='../settings.php';
if (!file_exists($file)) { $errors[]="$file " . $lang['SettingsNotFound'] ; }
elseif (filesize($file) <= 0) { $errors[]="$file " . $lang['ZeroBytes'] ; }
elseif (!is_writable($file)) { $errors[]="$file " . $lang['NotEditable'] ; }

define("mnminclude", dirname(__FILE__).'/../libs/');
include_once mnminclude.'db.php';
		
if (!$errors) {
	$dbuser = EZSQL_DB_USER;
	$dbpass = EZSQL_DB_PASSWORD;
	$dbname = EZSQL_DB_NAME;
	$dbhost = EZSQL_DB_HOST;

	if($conn = @mysql_connect($dbhost,$dbuser,$dbpass))
	 {
		$db_selected = mysql_select_db($dbname, $conn);
		if (!$db_selected) { die ('Error: '.$dbname.' : '.mysql_error()); }
		define('table_prefix', $_POST['tableprefix']);

		include_once '../libs/define_tables.php';

		//time to create the tables
		echo '<p>' . $lang['CreatingTables'] . '</p>';
		include_once ('../libs/db.php');
		include_once("installtables.php");
		if (pligg_createtables($conn) == 1) { echo "<p>" . $lang['TablesGood'] . "</p>"; }
		else { $errors[] = $lang['Error3-1']; }
	}
	else { $errors[] = $lang['Error3-2']; }
}

if (!$errors) {
	// refresh / recreate settings
	// this is needed to update it with table_prefix if it has been changed from "pligg_"
	include_once( '../libs/admin_config.php' );
	
	$config = new pliggconfig;
	$config->create_file('../settings.php');

	$my_base_url = "http://" . $_SERVER["HTTP_HOST"];
	$my_pligg_base=dirname($_SERVER["PHP_SELF"]); $my_pligg_base=str_replace("/".substr(strrchr($my_pligg_base, '/'), 1),'',$my_pligg_base);

	$sql = "Update " . table_config . " set `var_value` = '" . $my_base_url . "' where `var_name` = '" . '$my_base_url' . "';";
	mysql_query( $sql, $conn );

	$sql = "Update " . table_config . " set `var_value` = '" . $my_pligg_base . "' where `var_name` = '" . '$my_pligg_base' . "';";
	mysql_query( $sql, $conn );

	$config = new pliggconfig;
	$config->create_file('../settings.php');

	include_once( '../config.php' );
	$output='<div class="instructions"><p>' . $lang['EnterGod'] . '</p>
	<table>
		<form id="form1" name="form1" action="install.php" method="post">
		<tr>
			<td><label>' . $lang['GodLogin'] . '</label></td>
			<td><input name="godlogin" type="text" value="" /></td>
		</tr>
		
		<tr>
			<td><label>' . $lang['GodPassword'] . '</label></td>
			<td><input name="godpassword" type="password" value="" /></td>
		</tr>
			
		<tr>
			<td><label>' . $lang['ConfirmPassword'] . '</label></td>
			<td><input name="godpassword2" type="password" value="" /></td>
		</tr>
			  
		<tr>
			<td><label>' . $lang['GodEmail'] . '</label></td>
			<td><input name="godemail" type="text" value="" /></td>
		</tr>

		<tr>
			<td><label></label></td>
			<td><input type="submit" class="submitbutton" name="Submit" value="' . $lang['CreateAdmin'] . '" /></td>
		</tr>
		
		<input type="hidden" name="language" value="' . addslashes(strip_tags($_REQUEST['language'])) . '">
		<input type="hidden" name="step" value="5">
		</form>
    </table>
	</div>
	';
}
	
if (isset($errors)) {
	$output=DisplayErrors($errors);
	$output.='<p>' . $lang['Errors'] . '</p>';
}

if(function_exists("gd_info")) {}
else {
$config = new pliggconfig;
$config->var_id = 60;
$config->var_value = "false";
$config->store();
$config->var_id = 69;
$config->var_value = "false";
$config->store();
}


echo $output;
echo '</div>';

?>
