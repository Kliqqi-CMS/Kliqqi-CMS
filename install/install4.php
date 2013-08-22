<?php
if (!$step) { 
	header('Location: ./install.php'); die(); 
} else if(@$_SESSION['checked_step'] != 3){
	header('Location: ./install.php'); die(); 
}

if ($_POST['language'])
    $language = addslashes(strip_tags($_POST['language']));
if($language == 'arabic'){
	include_once('./languages/lang_arabic.php');
}elseif($language == 'catalan'){
	include_once('./languages/lang_catalan.php');
}elseif($language == 'chinese_simplified'){
	include_once('./languages/lang_chinese_simplified.php');
}elseif($language == 'french'){
	include_once('./languages/lang_french.php');
}elseif($language == 'german'){
	include_once('./languages/lang_german.php');
}elseif($language == 'italian'){
	include_once('./languages/lang_italian.php');
}elseif($language == 'russian'){
	include_once('./languages/lang_russian.php');
}elseif($language == 'thai'){
	include_once('./languages/lang_thai.php');
} else {
	$language = 'english';
	include_once('./languages/lang_english.php');
}

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
		echo '<li>' . $lang['CreatingTables'] . '</li>';
		include_once ('../libs/db.php');
		include_once("installtables.php");
		if (pligg_createtables($conn) == 1) { echo "<li>" . $lang['TablesGood'] . "</li>"; }
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
	
	// Set the site language to what the user has been using during the installation
	$language = addslashes(strip_tags($_REQUEST['language']));
	$sql = "Update " . table_config . " set `var_value` = '" . $language . "' where `var_name` = '" . '$language' . "';";
	mysql_query( $sql, $conn );

	$config = new pliggconfig;
	$config->create_file('../settings.php');

	include_once( '../config.php' );
	
	// Remove the cookie setting a template value
	setcookie("template", "", time()-60000,$my_pligg_base,$domain);

	$output='<div class="instructions"><p>' . $lang['EnterAdmin'] . '</p>
	<table>
		<form id="form1" name="form1" action="install.php" method="post">
			<tr>
				<td><label>' . $lang['AdminLogin'] . '</label></td>
				<td><input name="adminlogin" type="text" class="form-control" value="" placeholder="Admin" /></td>
			</tr>
			
			<tr>
				<td><label>' . $lang['AdminPassword'] . '</label></td>
				<td><input name="adminpassword" type="password" class="form-control" value="" /></td>
			</tr>
			
			<tr>
				<td><label>' . $lang['ConfirmPassword'] . '</label></td>
				<td><input name="adminpassword2" type="password" class="form-control" value="" /></td>
			</tr>
			
			<tr>
				<td><label>' . $lang['AdminEmail'] . '</label></td>
				<td><input name="adminemail" type="text" class="form-control" value="" placeholder="admin@domain.com" /></td>
			</tr>
			
			<tr>
				<td><label>' . $lang['SiteTitleLabel'] . '</label></td>
				<td><input name="sitetitle" type="text" class="form-control" value="" placeholder="My Site" /></td>
			</tr>
			
			<tr>
				<td><label></label></td>
				<td><input type="submit" class="btn btn-primary" name="Submit" value="' . $lang['CreateAdmin'] . '" /></td>
			</tr>
			
			<input type="hidden" name="language" value="' . addslashes(strip_tags($_REQUEST['language'])) . '">
			<input type="hidden" name="step" value="5">
		</form>
    </table>
	</div>
	';
}

	mysql_query( $sql, $conn );
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