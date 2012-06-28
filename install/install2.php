<?php
if (!$step) { header('Location: ./install.php'); die(); }

$file='../config.php';
if (!file_exists($file)) { $errors[]="$file " . $lang['NotFound'] ; }
elseif (filesize($file) <= 0) { $errors[]="$file " . $lang['ZeroBytes'] ; }

$file='../settings.php';
if (!file_exists($file)) { $errors[]="$file " . $lang['SettingsNotFound'] ; }
elseif (filesize($file) <= 0) { $errors[]="$file " . $lang['ZeroBytes'] ; }
elseif (!is_writable($file)) { $errors[]="$file " . $lang['NotEditable'] ; }

$file='../libs/dbconnect.php';
if (!file_exists($file)) { $errors[]="$file " . $lang['DbconnectNotFound'] ; }
elseif (!is_writable($file)) { $errors[]="$file " . $lang['NotEditable'] ; }

$file='../cache/templates_c';
if (!file_exists($file)) { $errors[]="$file " . $lang['TemplatesCNotFound'] ; }
elseif (!is_writable($file)) { $errors[]="$file " . $lang['NotEditable'] ; }

$file='../cache';
if (!file_exists($file)) { $errors[]="$file " . $lang['CacheNotFound'] ; }
elseif (!is_writable($file)) { $errors[]="$file " . $lang['NotEditable'] ; }

if (!$errors) {

$output='<div class="instructions"><p>' . $lang['EnterMySQL'] . '</p>
<table>
<form id="form1" name="form1" action="install.php" method="post">
<tr>
<td><label>' . $lang['DatabaseName'] . '</label></td>
<td><input name="dbname" type="text" value="" /></td>
</tr>

<tr>
<td><label>' . $lang['DatabaseUsername'] . '</label></td>
<td><input name="dbuser" type="text" value="" /></td>
</tr>

<tr>
<td><label>' . $lang['DatabasePassword'] . '</label></td>
<td><input name="dbpass" type="password" value="" /></td>
</tr>
  
<tr>
<td><label>' . $lang['DatabaseServer'] . '</label></td>
<td><input name="dbhost" type="text" value="localhost" /></td>
</tr>

<tr>
<td><label>' . $lang['TablePrefix'] . '</label></td>
<td><input name="tableprefix" type="text" value="pligg_" />
</tr>

<tr>
<td colspan=2>' . $lang['PrefixExample'] . '</td>
</tr>

<tr>
<td><label></label></td>
<td><input type="submit" class="submitbutton" name="Submit" value="' . $lang['CheckSettings'] . '" /></td>
</tr>
<input type="hidden" name="language" value="' . addslashes(strip_tags($_REQUEST['language'])) . '">
<input type="hidden" name="step" value="3">
</form>
</table>
</div>
';


}
else { 
	$output=DisplayErrors($errors);
	$output.='<p>' . $lang['Errors'] . '</p>';
}

echo $output;

?>
