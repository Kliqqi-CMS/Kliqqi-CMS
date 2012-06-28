<?php
class MysqlBackup {
	var $type;
	var $fh=0;

	function MysqlBackup($type='')
	{
	    $this->type = $type;
	}

	function backup()
	{
	    global $db;
	
	    $filename = tempnam('/tmp','');
	    if ($this->type=='gzip' && function_exists('gzopen')) $filename .= '.gz';
	    $this->open($filename);
	    $tables = $db->get_results("SHOW TABLES",ARRAY_N);
	    if (sizeof($tables)>1)
	    {
	    	foreach ($tables as $table)
		    $this->table_backup($table[0]);
	    }
	    else
		$this->error("Error with SHOW TABLES.");
	    $this->close();
	    return $filename;
	}

	function table_backup($table)
	{
	    global $db;
	
	    $this->write($fh,"DROP TABLE IF EXISTS " . sql_backquote($table) . ";\n");
	    $create_table = $db->get_results("SHOW CREATE TABLE $table", ARRAY_N);
	    if ($create_table) 
	    {
		$this->write($create_table[0][1] . " ;\n");
	
		$table_data = $db->get_results("SELECT * FROM $table", ARRAY_A);
		if($table_data) {
	  	    $search = array("\x00", "\x0a", "\x0d", "\x1a");
		    $replace = array('\0', '\n', '\r', '\Z');
		    foreach ($table_data as $row) {
			$entries = 'INSERT INTO ' . sql_backquote($table) . ' VALUES (';
			$values = array();
			foreach ($row as $key => $value) {
				if ($ints[strtolower($key)]) {
					$values[] = $value;
				} else {
					$values[] = "'" . str_replace($search, $replace, sql_addslashes($value)) . "'";
				}
			}
			$this->write(" \n" . $entries . implode(', ', $values) . ') ;');
		    }
		}
	    }
	    else
		$this->error(sprintf("Error with SHOW CREATE TABLE for %s.", $table));
	}

	function open($filename) 
	{
		if ($this->type=='gzip' && function_exists('gzopen'))
			$this->fh = gzopen($filename, 'w');
		else
			$this->fh = fopen($filename, 'w');
	}

	function close() 
	{
		if ($this->type=='gzip' && function_exists('gzopen'))
			gzclose($this->fh);
		else
			fclose($this->fh);
		$this->fh = 0;
	}

	function write($text) 
	{
		if ($this->type=='gzip' && function_exists('gzopen')) {
			if(gzwrite($this->fh, $text)===FALSE) 
				$this->error('There was an error writing a line to the backup script:'.$query);
		} else {
			if(fwrite($this->fh, $text)===FALSE) 
				$this->error('There was an error writing a line to the backup script:'.$query);
		}
	}

	function error($message)
	{
		print $message;
	}

}

/**
 * Better addslashes for SQL queries.
 * Taken from phpMyAdmin.
 */
function sql_addslashes($a_string = '', $is_like = FALSE) {
	if ($is_like) $a_string = str_replace('\\', '\\\\\\\\', $a_string);
	else $a_string = str_replace('\\', '\\\\', $a_string);
	return str_replace('\'', '\\\'', $a_string);
}

/**
 * Add backquotes to tables and db-names in
 * SQL queries. Taken from phpMyAdmin.
 */
function sql_backquote($a_name) {
	if (!empty($a_name) && $a_name != '*') {
		if (is_array($a_name)) {
			$result = array();
			reset($a_name);
			while(list($key, $val) = each($a_name))
				$result[$key] = '`' . $val . '`';
			return $result;
		} else {
			return '`' . $a_name . '`';
		}
	} else {
		return $a_name;
	}
}


function au_zip_backup($fileName) {
/*		//require_once('lib/pclzip.lib.php');
		//echo "In here $fileName";
		$archiveName = ABSPATH.$this->backup_dir. $fileName;
		$this->logMessage('Creating a archive with the name '.$archiveName.'<br/ >');
		if(! class_exists('PclZip')) {
			require_once('lib/pclzip.lib.php');
		}
		$archiver = new PclZip($archiveName);
		$list = $archiver->create(ABSPATH.$this->backup_dir.$this->backup_file);
		if ($list == 0) {
			$this->logMessage('Could not archive the files ' .$archiver->errorInfo(true));
			$this->isFileWritten = false;
			return false;
		}
		else {
			$this->logMessage('<br /><strong>Succesfully Created </strong>database backup archive at '. $archiveName .'<br /><br />');
			$this->isFileWritten = true;
			if(!$basedir = @opendir(ABSPATH.$this->backup_dir)) {
				@chmod($archiveName, 0755);
				@closedir($this->backupPath);
			}
			else {
				exec("chmod 755 $archiveName");
			}
			unlink(ABSPATH.$this->backup_dir.$this->backup_file);
			return true;
		}
		unset($archiver);
*/
}

?>
