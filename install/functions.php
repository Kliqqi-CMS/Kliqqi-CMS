<?php

//old functions - no longer used, kept just incase for now...
function DoesExist ( $canContinue, $file, $mode, $desc )
{
	@chmod( $file, $mode );
	$good = file_exists( $file ) ? 1 : 0;
	Message ( $desc.' does exist.: ', $good );
	return ( $canContinue && $good );
}

function isWriteable ( $canContinue, $file, $mode, $desc )
{
	@chmod( $file, $mode );
	$good = is_writable( $file ) ? 1 : 0;
	Message ( $desc.' is writable: ', $good );
	return ( $canContinue && $good );
}

function Message( $message, $good )
{
	if ( $good )
		$yesno = '<b><font color="green">Yes</font></b>';
	else
		$yesno = '<b><font color="red">No</font></b>';

	echo '<tr><td class="normal">'. $message .'</td><td>'. $yesno .'</td></tr>';
}
//end old functions

function DisplayErrors($errors) {
	foreach ($errors as $error) {
		$output.="<p><b>Error:</b> $error</p>\n";
	}
	return $output;
}

function checkfortable($table)
{
	$result = mysql_query('select * from ' . $table);
	if (!$result) {
		return false;
	}
	return true;
}

function check_lang_conf($version) {
	$file = '../libs/lang_english.conf';
	$data=file_get_contents($file);
	$lines=explode("\n",$data);
	foreach ($lines as $line) {
		if (preg_match("#\/\/<VERSION>$version<\/VERSION>#",$line)) { return TRUE; }
	}
}

?>