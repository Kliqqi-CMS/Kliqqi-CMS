<?php
if (!$step) { header('Location: ./install.php'); die(); }

$file=dirname(__FILE__) . '/../libs/dbconnect.php';

if(!isset($dbuser)){
  $dbuser = $_POST['dbuser'];
  $dbpass = $_POST['dbpass'];
  $dbname = $_POST['dbname'];
  $dbhost = $_POST['dbhost'];
}

if($conn = @mysql_connect($dbhost,$dbuser,$dbpass)) {
	$output.= "<p>" . $lang['ConnectionEstab'] . "</p>\n";
	if(mysql_select_db($dbname, $conn)) {
	$output.= "<p><strong>" . $lang['FoundDb'] . "</strong></p>\n";
		if($handle = fopen($file, 'w')) {
			$str  = "<?php\n";
			$str .= "define(\"EZSQL_DB_USER\", '".$dbuser."');"."\n";
			$str .= "define(\"EZSQL_DB_PASSWORD\", '".$dbpass."');"."\n";
			$str .= "define(\"EZSQL_DB_NAME\", '".$dbname."');"."\n";
			$str .= "define(\"EZSQL_DB_HOST\", '".$dbhost."');"."\n";
			$str .= "if (!function_exists('gettext')) {"."\n";
			$str .= '	function _($s) {return $s;}'."\n";
			$str .= '}'."\n";
			$str .= "?>";

			if(fwrite($handle, $str)) {
				$output.= "<p>" . $lang['dbconnect'] . "</p>\n";
				fclose($handle);
			} 
			else { $errors[] = $lang['Error2-1']; }
		} 
		else { $errors[] = $lang['Error2-2']; }
	}
	else { $errors[] = $lang['Error2-3']; }
}
else { $errors[] = $lang['Error2-4']; }

if($check_errors !== false){
  if (!$errors) {
  	$output.='<div class="instructions"><p>' . $lang['NoErrors'] . '</p>
  	<form id="form2" name="form2" method="post">
  	  <input type="hidden" name="dbuser" value="'.addslashes(strip_tags($_POST['dbuser'])).'" />
  	  <input type="hidden" name="dbpass" value="'.addslashes(strip_tags($_POST['dbpass'])).'" />
  	  <input type="hidden" name="dbname" value="'.addslashes(strip_tags($_POST['dbname'])).'" />
  	  <input type="hidden" name="dbhost" value="'.addslashes(strip_tags($_POST['dbhost'])).'" />
  	  <input type="hidden" name="tableprefix" value="'.addslashes(strip_tags($_POST['tableprefix'])).'" />
	  <input type="hidden" name="language" value="' . addslashes(strip_tags($_REQUEST['language'])) . '">
  	  <input type="hidden" name="step" value="4">
  	  <input type="submit" class="submitbutton" name="Submit" value="' . $lang['Next'] . '" />
  	  </form></div>';
  }
  else {
    $output=DisplayErrors($errors);
    $output.='<div class="instructions"><form id="thisform">
    <input class="submitbutton" type=button onclick="window.history.go(-1)" value="' . $lang['GoBack'] . '" />
    </form></div>';
  }
  echo $output;
} else {
  header("Location: $url_install3"); 
}
?>
