<?php
////////////////////////////////////////////////////////////////////////////////
//
//		Class name: mysql_backup
//		PHP version: 4.0.2
//		Function: Back up/Restore a MySql db.
//		Written by: Peyman Hooshmandi Raad
//		Date: Jan 9, 2003
//		Contact: captain5ive@yahoo.com
//=============================================================================
//
//		Methods:
//=============================================================================
//		1) Backup this method will back up the whole database.
//		$output: text file name and path(the one that holds backup)
//		$structure_only: (true / false)
//				true : backup method will only make backup from tables NOT the data.
//				false : backup method will make backup from tables and the data(WHOLE DB).
//		
//		2) Restor This method will create table with data from a txt file.
//		
//		Copyright: this class is free for non commercial uses.		
//
////////////////////////////////////////////////////////////////////////////////
class mysql_backup
	{
	//---- Class Variables.
	//---------------------
	var $host; //---- host name e.g. localhost
	var $db; //---- db name
	var $user; //---- db username
	var $pass; //---- db password
	var $output; //---- file name(sqldata.txt)
	var $structure_only; //---- Output method : true/false
	var $fptr; //---- Do Not change this.
	//---------------------
	
	//---- Constructor function: This will Inisialize variables.
	//----------------------------------------------------------
	function mysql_backup($host,$db,$user,$pass,$output,$structure_only)
		{
		set_time_limit (120);
		$this->host = $host;
		$this->db = $db;
		$this->user = $user;
		$this->pass = $pass;
		$this->output = $output;
		$this->structure_only = $structure_only;
		}
	//----------------------------------------------------------

	//---- This will create the sqldata.txt file.
	//-------------------------------------------	
	function _Mysqlbackup($host,$dbname, $uid, $pwd, $output, $structure_only)  
		{  
	
		if (strval($this->output)!="") $this->fptr=fopen($this->output,"w"); else $this->fptr=false;  
	
		//connect to MySQL database 
		$con=mysql_connect($this->host,$this->user, $this->pass);  
		$db=mysql_select_db($dbname,$con);  
	
		//open back-up file ( or no file for browser output) 
	
		//set up database 
		//out($this->fptr, "create database $dbname;\n\n");  
	
		//enumerate tables 
		$res=mysql_list_tables($dbname);  
		$nt=mysql_num_rows($res);  
	
		for ($a=0;$a<$nt;$a++)  
			{  
			$row=mysql_fetch_row($res);  
			$tablename=$row[0];  
	
			//start building the table creation query 
			$sql="create table $tablename\n(\n";  
	
			$res2=mysql_query("select * from $tablename",$con);  
			$nf=mysql_num_fields($res2);  
			$nr=mysql_num_rows($res2);  
	
			$fl="";  
	
			//parse the field info first 
			for ($b=0;$b<$nf;$b++)  
				{  
				$fn=mysql_field_name($res2,$b);  
				$ft=mysql_fieldtype($res2,$b);  
				$fs=mysql_field_len($res2,$b);  
				$ff=mysql_field_flags($res2,$b);  
	
				$sql.="    $fn ";  
	
				$is_numeric=false;  
				switch(strtolower($ft))  
					{  
					case "int":  
						$sql.="int";  
						$is_numeric=true;  
						break;  
	
					case "blob":  
						$sql.="text";  
						$is_numeric=false;  
						break;  
	
					case "real":  
						$sql.="real";  
						$is_numeric=true;  
						break;  
	
					case "string":  
						$sql.="char($fs)";  
						$is_numeric=false;  
						break;  
	
					case "unknown":  
						switch(intval($fs))  
							{  
							case 4:    //little weakness here...there is no way (thru the PHP/MySQL interface) to tell the difference between a tinyint and a year field type 
								$sql.="tinyint";  
								$is_numeric=true;  
								break;  
	
							default:    //we could get a little more optimzation here! (i.e. check for medium ints, etc.) 
								$sql.="int";  
								$is_numeric=true;  
								break;   
							}  
						break;  
	
					case "timestamp":  
						$sql.="timestamp";   
						$is_numeric=true;  
						break;  
	
					case "date":  
						$sql.="date";   
						$is_numeric=false;  
						break;  
	
					case "datetime":  
						$sql.="datetime";   
						$is_numeric=false;  
						break;  
	
					case "time":  
						$sql.="time";   
						$is_numeric=false;  
						break;  
	
					default: //future support for field types that are not recognized (hopefully this will work without need for future modification) 
						$sql.=$ft;  
						$is_numeric=true; //I'm assuming new field types will follow SQL numeric syntax..this is where this support will breakdown 
						break;  
					}  
	
				//VERY, VERY IMPORTANT!!! Don't forget to append the flags onto the end of the field creator 
	
				if (strpos($ff,"unsigned")!=false)  
					{  
					//timestamps are a little screwy so we test for them 
					if ($ft!="timestamp") $sql.=" unsigned";  
					}  
	
				if (strpos($ff,"zerofill")!=false)  
					{  
					//timestamps are a little screwy so we test for them 
					if ($ft!="timestamp") $sql.=" zerofill";  
					}  
	
				if (strpos($ff,"auto_increment")!=false) $sql.=" auto_increment";  
				if (strpos($ff,"not_null")!=false) $sql.=" not null";  
				if (strpos($ff,"primary_key")!=false) $sql.=" primary key";  
	
				//End of field flags 
	
				if ($b<$nf-1)  
					{  
					$sql.=",\n";  
					$fl.=$fn.", ";  
					}  
				else  
					{  
					$sql.="\n);\n\n";  
					$fl.=$fn;  
					}  
	
				//we need some of the info generated in this loop later in the algorythm...save what we need to arrays 
				$fna[$b]=$fn;  
				$ina[$b]=$is_numeric;  
				  
				}  
	
			//$this->_Out($sql);  
	
			if ($this->structure_only!=true)  
				{  
				//parse out the table's data and generate the SQL INSERT statements in order to replicate the data itself... 
				for ($c=0;$c<$nr;$c++)  
					{  
					$sql="insert into $tablename ($fl) values (";  
	
					$row=mysql_fetch_row($res2);  
	
					for ($d=0;$d<$nf;$d++)  
						{  
						$data=strval($row[$d]);  
					  
						if ($ina[$d]==true)  
							$sql.= intval($data);  
						else  
							$sql.="\"".mysql_escape_string($data)."\"";  
	
						if ($d<($nf-1)) $sql.=", ";  
		  
						}  
	
					$sql.=");\n";  
					//echo $sql;
					$this->_Out($sql);  
	
					}  
	
				$this->_Out("\n\n");  
	
				}  
	
			mysql_free_result($res2);      
	
			}  
		  
		if ($this->fptr!=false) fclose($this->fptr);  





		if ($this->structure_only==true)  
			{  

			$fname = $output;
			if (!mysql_connect($host, $uid, $pwd)) {
			   echo 'Could not connect to mysql';
			   exit;
			}
			
			$sql = "SHOW TABLES FROM $dbname";
			$result = mysql_query($sql);
			
			if (!$result) {
			   echo "DB Error, could not list tables\n";
			   echo 'MySQL Error: ' . mysql_error();
			   exit;
			}
			
			$fp = fopen($fname, "w");
			
			while ($row = mysql_fetch_row($result)) {
			
				$result2 = mysql_query("SHOW CREATE TABLE `".$row[0]."`");
				$row2 = mysql_fetch_row($result2);
				
				fwrite($fp, "DROP TABLE IF EXISTS `".$row[0]."`;\n\n");
			
				fwrite($fp, $row2[1] . ";\n\n");
				
			}
			
			fclose($fp);
			
			mysql_free_result($result2);
			mysql_free_result($result);

		}






		return 0;  
	
		}
	//-------------------------------------------
	
	//---- This will Open sqldata.txt.
	//--------------------------------	
	function _Open()
		{
		$filename = $this->output;
		$fp = fopen( $filename, "r" ) or die("Couldn't open $filename");
		while ( ! feof( $fp ) )
			{
			$line = fgets( $fp, 1024 );
			$SQL .= "$line";
			}
		return $SQL;
		}
	//--------------------------------
	
	//---- This will Restore data in sqldata.txt
	//------------------------------------------
	function Restore($sep=";")
		{
		//---- Calls _Open function to make an array of sql peices.
		//---------------------------------------------------------
		$SQL = explode($sep, $this->_Open($this->output));
		//---------------------------------------------------------
		
		//---- Make connection to MySql and the specified db.
		//---------------------------------------------------
		$link = mysql_connect($this->host, $this->user, $this->pass) or (die (mysql_error()));
		mysql_select_db($this->db, $link) or (die (mysql_error()));
		//---------------------------------------------------
		
		
		//---- This loop will execute every peice of SQL.
		//-----------------------------------------------
		for ($i=0;$i<count($SQL)-1;$i++)
			{			
				//echo $SQL[$i] . $sep . '<BR>';
				mysql_unbuffered_query($SQL[$i] . $sep) or (die (mysql_error()));
			}
		//-----------------------------------------------
	}
	//---------------------------------------------------------
	
	//---- This will put data in sqldata.txt
	//------------------------------------------
	function _out($s)  
		{  
		if ($this->fptr==false) echo("$s"); else fputs($this->fptr,$s);  
		}
	//------------------------------------------
	
	//---- This is the function to be called for backup.
	//--------------------------------------------------
	function Backup()
		{
		$this->_Mysqlbackup($this->host,$this->db,$this->user,$this->pass,$this->output,$this->structure_only); 
		return 1;
		}
	//--------------------------------------------------
	}
?>