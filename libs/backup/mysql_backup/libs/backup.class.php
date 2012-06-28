<?php

define ('_CONNECTION_ERROR_',"DB Connection error, please <a href=\"?option=databaseAdmin&go=config\">configure</a> your application.");

/**
 * backup class : Backup class
 * 
 * @package 
 * @author Ben Yacoub Hatem <hatem@php.net>
 * @website http://www.phptunisie.net/
 * @copyright Copyright (c) 2004
 * @version $Id$ - 10/03/2004 15:22:00 - backup.class.php
 * @access public
 **/

class backup extends db2{


	var $backupdir = "./backup";
	var $compression = "bz2";
	var $color1 = "#F57E1D";
	var $color2 = "#F5F6C4";
	var $color3 = "#FFFF40";
	var $mysqldump = true;
	var $default_sort_order = "DateDesc";
	var $file_mod = "0777";
	var $file_name = "";

	/**
     * Constructor
     * @access protected
     */
	function backup(){
		global $GonxAdmin;
		$this->compression = $GonxAdmin["compression_default"];
	}
	
	/**
	 * backup::version()	Return class version
	 * 
	 * @return 
	 **/
	function version(){
		return "1.0.8-PRE2";
	}

	
	/**
	 *
	 * @access public
	 * @return void 
	 **/
	function tables_menu(){
		global $GONX;
		
		$color3 = $this->color3;
		$color2 = $this->color2;
		$color1 = $this->color1;
		
		$res = "\n<form action='?go=backuptables' method='post'>
<table border=0 cellpadding=5>
<tr bgcolor=\"$color1\">
\t<th>Table</th>
\t<th>Rows</th>
\t<th>Create_time</th>
\t<th>Update_time</th>
\t<th>Check_time</th>
</tr>\n\n";

        $result =  $this->query('SHOW TABLE STATUS');
		$i = 0;		$bgcolor = $color3;
        while ($table = @$this->fetch_array($result)) {
			if ($table["Update_time"]!=$table["Create_time"]) {
			    $l1 = "<label for=\"tables$i\">";
				$l2 = "</label>";
			} else {
				$l1 = $l2 = "";
			};
			$res .= "<tr bgcolor=\"$bgcolor\">
\t<th align=left><input type='checkbox' id='tables$i' name='tables[]' value='".$table["Name"]."' /> ".$table["Name"]."</th>
\t<td>".$table["Rows"]."</td>
\t<td>$l1".$table["Create_time"]."$l2</td>
\t<td>$l1".$table["Update_time"]."$l2</td>
\t<td>".$table["Check_time"]."</td>
</tr>
";
			if ($bgcolor==$color3) {
			    $bgcolor = $color2;
			} else $bgcolor = $color3;
			$i++;
		}
		
		$res .= "</table>
<input type='checkbox' name='structonly' value='Yes'> ".$GONX["structonly"]."<br><br>
<input type='radio' name='chg' onclick='for(i=0;i<$i;i++){document.getElementById(\"tables\"+i).checked=true;}'> ".$GONX["checkall"]." &nbsp;&nbsp;
<input type='radio' name='chg' onclick='for(i=0;i<$i;i++){document.getElementById(\"tables\"+i).checked=false;}'> ".$GONX["uncheckall"]." &nbsp;&nbsp;
<p align=right><input type='submit' class='button'></p>
".$GONX["tablesmenuhelp"]."
</form>\n";
		return $res;
	}
	
	/**
	 *
	 * @access public
	 * @return void 
	 **/
	function tables_backup($tables,$structonly){
		global $GONX;
		foreach($tables as $v){
            $res = $this-> query("SHOW CREATE TABLE " . $this -> dbName . "." .$v);
            while ($resu[] = $this -> get_data()) {
            } 
		}

        foreach($resu as $key => $val) {
			$tbl_name_status = $this->valid_table_name($val[0]);
            if (trim($val[0]) !== "" and $tbl_name_status) {
                $Dx_Create_Tables .= "
# Drop table '" . $val[0] . "' if exist
DROP TABLE IF EXISTS " . $val[0] . ";
# create table '" . $val[0] . "'
" . $val[1] . " ;
\r\n";
		if ($structonly!="Yes") {
                $query = "Insert into `$val[0]` (";
				$this -> query("LOCK TABLES $val[0] WRITE");
                $qresult = $this -> query("Select * from $val[0]");
                while ($line = $this -> fetch_array($qresult)) {
                    unset($fields, $values);
					$j = 0;
                    while (list($col_name, $col_value) = each($line)) {
                        if (!is_int($col_name)) {
                            $fields .= "`$col_name`,";
							$values .= "'" . $this->escape_string($col_value) . "',";
                        } 
                    } 

                    $fields = substr($fields, 0, strlen($fields)-1);
                    $values = substr($values, 0, strlen($values)-1);
                    $myquery = $query . $fields . ") values (" . $values . ");";
                    $Dx_Create_Tables .= "\r\n<xquery>
" . $myquery . "
</xquery>\r\n" ;
                } 
				$this -> query("UNLOCK TABLES;");		    
		}
            } elseif (!$tbl_name_status){
				$err_msg .= "<font color=red>".$GONX["ignoredtables"]." ".$val[0]." - ".$GONX["reservedwords"].".</font><br>\n";
			}
        } 
		
		if (!is_dir($this->backupdir)) {
		    @mkdir($this->backupdir,0755);
		}
		if (sizeof($tables)==1) {
		    $prefix = "[".$tables[0]."]";
		} else $prefix = "[".sizeof($tables)."tables]";
		switch($this->compression){
			case "bz2":
				// Random 5 characters to append to file names to prevent name guessing
				$rand = substr(md5(microtime()),rand(0,26),5);
				$fname = $this->dbName.date("Y-m-d H-i-s")."_".$rand.".bz2";
				touch($this->backupdir."/".$fname);
				$fp = bzopen($this->backupdir."/".$fname, "w");
				bzwrite($fp, $Dx_Create_Tables);
				bzclose($fp);
			break;
			
		    case "zlib": 
				// Random 5 characters to append to file names to prevent name guessing
				$rand = substr(md5(microtime()),rand(0,26),5);
				$fname = $this->dbName."_".date("Y-m-d H-i-s")."_".$rand.".gz";
				touch($this->backupdir."/".$fname);
				$fp = gzopen($this->backupdir."/".$fname, "w");
				gzwrite($fp, $Dx_Create_Tables);
				gzclose($fp);
			break;
		
			default:
				// Random 5 characters to append to file names to prevent name guessing
				$rand = substr(md5(microtime()),rand(0,26),5);
				$fname = $this->dbName.date("Y-m-d_H-i-s")."_".$rand.".sql";
				touch($this->backupdir."/".$fname);
				$fp = fopen($this->backupdir."/".$fname, "w");
				fwrite($fp, $Dx_Create_Tables);
				fclose($fp);
			break;
		} // switch
        return "$err_msg<font color=green>".$GONX["backup"]." ".$this->dbName." ".$GONX["iscorrectcreat"]." : ".$this->backupdir."/$fname</font>";
	}
	
	
	/**
	 * backup::generate()		Create a backup file of the DB
	 * 
	 * @return 
	 **/
	function generate(){
		global $GONX, $GonxAdmin;
        $result =  @$this->list_tables($this->dbName);
        while ($table = @$this->fetch_row($result)) {
            $res = $this-> query("SHOW CREATE TABLE " . $this->dbName . "." . $table[0]);

            while ($resu[] = $this -> get_data()) {
            } 
        } 
        foreach($resu as $key => $val) {
			$tbl_name_status = $this->valid_table_name($val[0]);
            if (trim($val[0]) !== "" and $tbl_name_status) {
                $Dx_Create_Tables .= "";

                $query = "Insert into `$val[0]` (";
				$this -> query("LOCK TABLES $val[0] WRITE");
                $qresult = $this -> query("Select * from $val[0]");
                while ($line = $this -> fetch_array($qresult)) {
                    unset($fields, $values);
					$j = 0;
                    while (list($col_name, $col_value) = each($line)) {
                        if (!is_int($col_name)) {
                            $fields .= "`$col_name`,";
							$values .= "'" . $this->escape_string($col_value) . "',";
                        } 
                    } 

                    $fields = substr($fields, 0, strlen($fields)-1);
                    $values = substr($values, 0, strlen($values)-1);
                    $myquery = $query . $fields . ") values (" . $values . ");";
                    $Dx_Create_Tables .= $myquery . "\r\n" ;
                } 
				$this -> query("UNLOCK TABLES;");
            }  elseif (!$tbl_name_status){
				$err_msg .= "<font color=red>Ignored table ".$val[0]." - Reserved SQL word.</font><br>\n";
			}
        } 
		
		if (!is_dir($this->backupdir)) {
		    @mkdir($this->backupdir,octdec($this->file_mod));
		}
		switch($this->compression){
			case "bz2": 
				$fname = "MySQL-Data-Backup-" . $this->dbName."-".date("Y-m-d H-i-s").".bz2";
				touch($this->backupdir."/".$fname);
				$fp = bzopen($this->backupdir."/".$fname, "w");
				bzwrite($fp, $Dx_Create_Tables);
				bzclose($fp);
			break;
			
		    case "zlib": 
				$fname = "MySQL-Data-Backup-" . $this->dbName."-".date("Y-m-d H-i-s").".gz";
				touch($this->backupdir."/".$fname);
				$fp = gzopen($this->backupdir."/".$fname, "w");
				gzwrite($fp, $Dx_Create_Tables);
				gzclose($fp);
			break;
		
			default:
				// Random 5 characters to append to file names to prevent name guessing
				$rand = substr(md5(microtime()),rand(0,26),5);
				$fname = "MySQL_Data_".date("Y-m-d_H-i-s")."_".$rand.".sql";
				touch($this->backupdir."/".$fname);
				$fp = fopen($this->backupdir."/".$fname, "w");
				fwrite($fp, $Dx_Create_Tables);
				fclose($fp);
			break;
		} // switch
		// Random 5 characters to append to file names to prevent name guessing
		$rand = substr(md5(microtime()),rand(0,26),5);
		
		$this->filename = date("Y-m-d_H-i-s")."_".$rand.".sql";
        return "$err_msg<font color=green>".$GONX["backup"]." ".$this->dbName." ".$GONX["iscorrectcreat"]." : ".$this->backupdir."/$fname</font>";
	}

	/**
	 * backup::import()		Import a Backup file to DB
	 * 
	 * @param string $bfile
	 * @return 
	 **/
	function import($bfile = ""){
		global $GONX,$GonxAdmin;
		set_time_limit(0);

		if (isset($_GET["importdump"])) {
		    if (is_file($this->backupdir."/".$bfile)) {
				switch($GonxAdmin["compression_default"]){
					case "bz2": 
						$bz = bzopen($this->backupdir."/".$bfile, "r");
						while (!feof($bz)) {
	  						  $contents .= bzread($bz, 4096);
						}
	//					$contents = bzread($bz, filesize($this->backupdir."/".$bfile)*1000); // just a hack coz feof doesn't wrk for me
						bzclose($bz);
					break;
					
				    case "zlib": 
						$bz = gzopen($this->backupdir."/".$bfile, "r");
						$contents = gzread($bz, filesize($this->backupdir."/".$bfile)*1000); // just a hack coz feof doesn't wrk for me
						gzclose($bz);
					break;
				
					default:
						$bz = fopen($this->backupdir."/".$bfile, "r");
						$contents = fread($bz, filesize($this->backupdir."/".$bfile)*1000); // just a hack coz feof doesn't wrk for me
						fclose($bz);
					break;
				} // switch
				

				// Convert to mysql dump format
				$contents = str_replace("<xquery>", "", $contents);
				$contents = str_replace("</xquery>", "", $contents);

				// Create temporary file
				touch($this->backupdir."/temp.sql");
				$fp = fopen($this->backupdir."/temp.sql", "w");
				fwrite($fp, $contents);
				fclose($fp); unset($contents);

				// Execute MySQL Dump
				@shell_exec($GonxAdmin["mysqldump"]." --host ".$GonxAdmin["dbhost"]." --user=".$GonxAdmin["dbuser"]." --pass=".$GonxAdmin["dbpass"]." --databases ".$GonxAdmin["dbname"]." < ".$this->backupdir."/temp.sql");

				// Remove the temporary file.
				@unlink($this->backupdir."/temp.sql");
				return "<font color=green> $bfile ".$GONX["iscorrectimport"]." </font>";
			} else return FALSE;
		}

		if (is_file($this->backupdir."/".$bfile)) { // File existe, import it
			switch($GonxAdmin["compression_default"]){
				case "bz2": 
					$bz = bzopen($this->backupdir."/".$bfile, "r");
					while (!feof($bz)) {
  						  $contents .= bzread($bz, 4096);
					}
//					$contents = bzread($bz, filesize($this->backupdir."/".$bfile)*1000); // just a hack coz feof doesn't wrk for me
					bzclose($bz);
				break;
				
			    case "zlib": 
					$bz = gzopen($this->backupdir."/".$bfile, "r");
					$contents = gzread($bz, filesize($this->backupdir."/".$bfile)*1000); // just a hack coz feof doesn't wrk for me
					gzclose($bz);
				break;
			
				default:
					$bz = fopen($this->backupdir."/".$bfile, "r");
					$contents = fread($bz, filesize($this->backupdir."/".$bfile)*1000); // just a hack coz feof doesn't wrk for me
					fclose($bz);
				break;
			} // switch

            preg_match_all("'<xquery[?>]*?>(.*?)</xquery>'si" , $contents, $requetes);
            //<?
			unset($contents);
            foreach($requetes[1] as $key => $val) {
                $this -> query(trim($val));
            }
			return "<font color=green> $bfile ".$GONX["iscorrectimport"]." </font>";
		} else {	// Erronous file, read dir, and list available backup file.
			return false;
		}
	}
	
	/**
	 * backup::importfromfile()		Download and Import a Backup file to DB
	 * 
	 * @param string $bfile
	 * @return 
	 **/
	function importfromfile(){
		global $GONX,$HTTP_POST_FILES;
		@set_time_limit(0);

		
		$bfile = $HTTP_POST_FILES["backupfile"];
		$pathinfo = pathinfo($bfile["name"]);
		$compression = $pathinfo["extension"];
				
		if ($bfile["error"]==0) { // File existe, import it
			switch($compression){
				case "bz2": 
					$bz = bzopen($bfile["tmp_name"], "r");
					$contents = bzread($bz, $bfile["size"]); // just a hack coz feof doesn't wrk for me
					bzclose($bz);
				break;
				
			    case "gz": 
					$gz = gzopen($bfile["tmp_name"], "r");
					$contents = gzread($gz, $bfile["size"]); // just a hack coz feof doesn't wrk for me
					bzclose($gz);
				break;
			
				default:
					$f = fopen($bfile["tmp_name"], "r");
					$contents = fread($f, $bfile["size"]); // just a hack coz feof doesn't wrk for me
					fclose($f);
				break;
			} // switch
			

            preg_match_all("'<xquery[?>]*?>(.*?)</xquery>'si" , $contents, $requetes);
            //<?
            foreach($requetes[1] as $key => $val) {
                $this -> query(trim($val));
            }
			return "<font color=green> ".$bfile["name"]." ".$GONX["iscorrectimport"]." </font>";
		} else {	// Erronous file, read dir, and list available backup file.
			return $this->listbackups();
		}
	}
	
	/**
	 * backup::listbackups()		List available backup
	 * 
	 * @return 
	 **/
	function listbackups(){
		global $GONX,$GonxAdmin,$page,$orderby;
		$pagesize = $GonxAdmin["pagedisplay"];
		$GonxOrder = array("DateAsc","NameAsc","NameDesc","SizeAsc","SizeDesc","DateDesc");
		if ($orderby=="" or !in_array($orderby,$GonxOrder )) {
		    $orderby = $this->default_sort_order;
		}
		
		if( !isset( $page ) or ($page<=0) ){

			$page = 1;

			$from = $page-1;

			$to = ($pagesize*$page);

		} elseif ($page ==1){

			$from = 0;

			$to = ($pagesize*($page+1)-$pagesize);

		} else {

			$from = $pagesize * ($page-1);

			$to = ($pagesize*($page+1)-$page *$pagesize);

		}
		$res = "
<script language=\"JavaScript\" type=\"text/javascript\">
<!--
//author Philippe BENVENISTE  <info@pommef.com>
//copyright Pommef - Idées et Changements (c) 2004

function IECColor1(el) {	
	IEC_obj2.IECColor(el);
	IEC_obj1.IECColor(el);
}


function IECColor2(el){

	IEC_obj1.IECColor(el);
	IEC_obj2.IECColor(el);
	
	if(ConfirmDelete()){
	
		return true;
		
	} else {
	
		document.getElementById(el).style.background = IEC_obj1.BG2;
		document.forms[\"bform\"].reset();
		
		return false;
	}					
}

function IECColorClass(BG1, BG2){

	this.gvar = 10000;
	this.BG1 = BG1;
	this.BG2 = BG2;
	this.IECColor=IECColor;
}

function IECColor(el) {	

	document.getElementById(el).style.background = this.BG1;

	if(this.gvar < 9000 && this.gvar != el)
		document.getElementById(this.gvar).style.background = this.BG2;	
	
	this.gvar = el;
}

IEC_obj1 = new IECColorClass('khaki','#F6F6F6'); 
IEC_obj2 = new IECColorClass('#CF2B5A','#F6F6F6');


//-->
</script>
<form method=get action=\"?\" name=bform><b>".$GONX["selectbackupfile"]." :</b><br/><br/>\n";
		if (!is_dir($this->backupdir)) {
		    @mkdir($this->backupdir,octdec($this->file_mod));
		}
		$d = dir($this->backupdir);
		$i = $BackupSize = 0;
		while (false !== ($entry = $d->read())) {
			if ($entry!="." and $entry!=".." and preg_match('/.(bz2|gz|sql)$/',$entry)) {
				$mtime = date ("F d Y H:i:s.", filemtime($this->backupdir."/".$entry));
				$time = filemtime($this->backupdir."/".$entry);
				$size = filesize($this->backupdir."/".$entry);
				$fsize = round($size/1024);
				
				$GonxBackups[$i]["fname"] = $entry;
				$GonxBackups[$i]["mtime"] = $mtime;
				$GonxBackups[$i]["time"] = $time;
				$GonxBackups[$i]["fsize"] = $fsize;
				$GonxBackups[$i]["size"] = $size;			
				$BackupSize += $fsize;
				$i++;
			}
		}
		if ($i==0) {
		    $res .= "<ul><li>".$GONX["nobckupfile"]."</li></ul>";
		} else {
			/**
			* Pagination
			*/
			$allpages = round(sizeof($GonxBackups)/$pagesize); 

			$all_rest = $allpages - $allpages*$pagesize;

			if ($all_rest > 0) {$allpages++; }

			if ($page<$allpages)
			{
				$next = "<a href=\"?option=databaseAdmin&go=list&amp;page=".($page+1)."&orderby=$orderby\" class=tab-s>".$GONX["next"]."</a>";
			} else $next="";
			if ($page>1)
			{
				$prev = "<a href=\"?option=databaseAdmin&go=list&amp;page=".($page-1)."&orderby=$orderby\" class=tab-s>".$GONX["prev"]."</a>";
			} else $prev ="";
			$links = "";
			for ($i=0; $i<$allpages; $i++)
			{
				if (($i+1) == $page)
				{
					$links .= "<span class=tab-s> ".($i+1)." </span>";
				} else {
					$links .= "<a href=\"?option=databaseAdmin&go=list&amp;page=".($i+1)."&orderby=$orderby\" class=tab-g> ".($i+1)." </a>";
				}
			}
			/**
			* Order by
			*/
			$OrderMenu = "<select class=button OnChange=\"location.href='?option=databaseAdmin&go=list&page=$page&orderby='+ChgOrder.options[selectedIndex].value\" name=\"ChgOrder\">\n";
			foreach($GonxOrder as $v){
				if ($v==$orderby) {
				    $sel = " selected";
				} else $sel ="";
				$OrderMenu .= "<option$sel value=\"$v\">$v</option>\n";
			}
			$OrderMenu .= "</select>\n";
			switch($orderby){
				case "DateAsc": 
					usort($GonxBackups, array("backup","DateSortAsc"));
				break;
				
			    case "NameAsc": 
					usort($GonxBackups, array("backup","NameSortAsc"));
				break;

			    case "NameDesc": 
					usort($GonxBackups, array("backup","NameSortDesc"));
				break;
				
			    case "SizeAsc": 
					usort($GonxBackups, array("backup","SizeSortAsc"));
				break;
				
			    case "SizeDesc": 
					usort($GonxBackups, array("backup","SizeSortDesc"));
				break;
			
				default:
					usort($GonxBackups, array("backup","DateSortDesc"));
				break;
			} // switch
			
			if (is_array($GonxBackups)) {
			    $GonxBackups = array_slice($GonxBackups, $from,$to);
			}
			$res .= "\n<table align=\"center\" width=90%>
			<tr>
			<td width=10%>$prev</td>
			<td width=80% align=\"center\"> $links</td>
			<td width=10% align=\"right\">$next</td>
			</tr></table>\n<br/>
			<table align=\"center\" width=100% cellspacing=0>
\t<tr>
			<th></th>
			<th>DB</th>
			<th>Download</th>
			<th>Size</th>
			<th>Date</th>
			<th>Delete<th>
</tr>\n";


			foreach($GonxBackups as $k=>$v){
				$db = explode("-",$v['fname'] );
				$db = $db[0];
				$res .= "\t<tr id=$k>
			<td><input type=\"radio\" name=\"bfile\" value=\"".$v['fname']."\" onclick=\"IECColor1($k);\"></td>
			<th>$db</th>
			<td align=center><font size=2px> <a href=\"?option=databaseAdmin&go=getbackup&bfile=".urlencode($v['fname'])."\" target=\"_new\" title=\"Download ".$v['fname']."\">".$v['fname']."</a></td>
			<td align=center><em>size ".$v['fsize']." Ko</em></td>
			<td align=center>".$v['mtime']."</td>
			<td align=center><a href=\"?option=databaseAdmin&go=delete&fname=".$v['fname']."\" title=\"".$GONX["delete"]." ".$v['fname']."\" onclick=\"return IECColor2($k);\"><img src=\"image.php?img=delete_gif\" border=0></a></font><td>
</tr>\n\n";

			}
		$BackupSize = number_format(($BackupSize/1024),3  );
		$res .= "</table><br/><br/><em>".$GONX["totalbackupsize"]." : $BackupSize Mo</em> - ".$GONX["chgdisplayorder"]." : $OrderMenu
		<br/><br/><input type=hidden name=go value=import>
		<p align=right>";
		
		if($this->mysqldump)
			$res .="<input type=submit name=importdump value=\"".$GONX["importbackupdump"]."\" class=button>";
		
		$res .="  <input type=submit name=import value=\"".$GONX["importbackup"]."\" class=button></p></form>\n";
		$res .= "<form method=post action=\"?\" enctype=\"multipart/form-data\"><b>".$GONX["importbackupfile"]." :</b><br/><br/>
		<input type=file name=backupfile class=button>
		<br/><br/><input type=hidden name=go value=importfromfile>
		<p align=right><input type=submit name=import value=\"".$GONX["importbackup"]."\" class=button></p></form>\n";	
		}
		

		$d->close();
		return $res;
	}
	

	/**
	 * backup::NameSortAsc()
	 * 
	 * @param $a
	 * @param $b
	 * @return 
	 **/
	function NameSortAsc($a, $b) {
	
	    return strcmp($a["fname"], $b["fname"]);
	
	}
	
	/**
	 * backup::NameSortDesc()
	 * 
	 * @param $a
	 * @param $b
	 * @return 
	 **/
	function NameSortDesc($a, $b) {
	
	    return !strcmp($a["fname"], $b["fname"]);
	
	}
	
	/**
	 * backup::SizeSortAsc()
	 * 
	 * @param $a
	 * @param $b
	 * @return 
	 **/
	function SizeSortAsc($a, $b) {
	
		return ($a["size"]>$b["size"])?1:-1;
	
	}
	
	/**
	 * backup::SizeSortDesc()
	 * 
	 * @param $a
	 * @param $b
	 * @return 
	 **/
	function SizeSortDesc($a, $b) {
	
		return ($a["size"]<$b["size"])?1:-1;
	
	}
	
	/**
	 * backup::DateSortAsc()
	 * 
	 * @param $a
	 * @param $b
	 * @return 
	 **/
	function DateSortAsc($a, $b) {
	
		return ($a["time"]>$b["time"])?1:-1;
	
	}
	
	/**
	 * backup::DateSortDesc()
	 * 
	 * @param $a
	 * @param $b
	 * @return 
	 **/
	function DateSortDesc($a, $b) {

		return ($a["time"]<$b["time"])?1:-1;
	
	}
	
	/**
	 * backup::delete()	delete a backup file based on its name
	 * 
	 * @param $_fname
	 * @return 
	 **/
	function delete($_fname){
		if (is_file($this->backupdir."/".$_fname)) {
			unlink($this->backupdir."/".$_fname);
			return "<font color=green> Backup file $_fname is correctly removed </font>";
		} else return "<font color=red> Error while removing backup file $_fname</font>";
	}
	
	/**
	 * backup::keep()		Keep backup files for a limited period of days and remove all others
	 * 
	 * @param integer $days
	 * @return 
	 **/
	function keep($days = 4){
		if (is_dir($this->backupdir)) {
			$d = dir($this->backupdir);
			while (false !== ($entry = $d->read())) {
				if ($entry!="." and $entry!=".." and preg_match('/.(bz2|gz|sql)$/',$entry)) {
					if ((filemtime($this->backupdir."/".$entry)) < (strtotime('-'.$days.' days'))) {
						$this->delete($entry);
					}
				}
			}
		}
	}
	
	/**
	 * method optimize : execute an operation in all db table
	 * 
	 * @param	$operation	operation to execute on DB
	 * 
	 * @access public
	 * @return void 
	 **/
	function optimize($operation = "OPTIMIZE"){
		global $GonxAdmin;
		if ($GonxAdmin["dbtype"]!="mysql") {
		    return "Sorry this feature is available for only MySQL Databases.";
		}
		if ($operation!= "OPTIMIZE" or $operation!= "ANALYZE" or $operation!= "REPAIR") {
		    $operation = "OPTIMIZE";
		}
	$color3 = $this->color3;
		$color2 = $this->color2;
		$color1 = $this->color1;
		
		$Tables = $this->get_db_tables();
		$query = "$operation TABLE ";
		foreach($Tables as $k=>$v){
			$query .= " `$v`,";
		}
		$query = substr($query,0,strlen($query)-1);
		$result = $this->query($query);
		$res = "<table border=\"0\" cellpadding=\"5\" align=center>\n";
		$res .= "<tr>
<th bgcolor=\"$color1\">Table</font></th>
<th bgcolor=\"$color1\">Op</font></th>
<th bgcolor=\"$color1\">Msg_type</font></th>
<th bgcolor=\"$color1\">Msg_text</font></th>
</tr>";
		$bgcolor = $color3;
		while ($line = $this->fetch_array($result)) {
	        $res .= "\t<tr>\n";
	        foreach ($line as $k=>$col_value) {
				if (!is_numeric($k)) {
					if ($col_value == "OK") {
					    $optimize = " <a href=\"?option=databaseAdmin&go=optimize&op=OPTIMIZE\" class=tab-s>Optimize DB</a>";
					} else $optimize="";
		            $res .= "\t\t<td valign=\"top\"  bgcolor=\"$bgcolor\">$col_value $optimize</td>\n";   
				}
	        }
	        $res .= "\t</tr>\n";
			if ($bgcolor==$color3) {
			    $bgcolor = $color2;
			} else $bgcolor = $color3;
	    }
		$res .= "</table>\n";			
		return $res;
	}
	
	/**
	 * backup::configure()	Configuration menu for the application
	 * 
	 * @return 
	 **/
	function configure(){
		global $GONX;
		$filename = "init.php";
//		$perms = fileperms ($filename);
		$contents = implode('',file($filename));
		preg_match_all("|(.*)=(.*);|U",$contents ,$matches );
$initform = "<form action=\"?\" method=post>
<table class=config cellspacing=0 cellpadding=4>
  <tr><td colspan=2><b>".$GONX["configureapp"]."</b></td></tr>\n\n
  <tr align=center><th width=50%><i>Variable</i></th><th width=50%><i>Value</i></th></tr>\n\n";
foreach($matches[1] as $k=>$v){
	if (strstr($v,"<?php")) {
	    $v = str_replace("<?php","" , $v);
	}
	$v = trim($v);
	$value = trim(htmlentities($matches[2][$k]));
	$initform .= "  <tr><td>$v</td><td><input type=text size=40 name=vars[$k] value=\"$value\"></td></tr>\n\n";
}
$initform .= " 
</table>
<p align=right><input type=submit  style=\"width:200\"  class=button></p>
<input type=hidden name=go value=saveconfig>
</form>\n\n";
		return $initform ;
	}
	
	/**
	 * backup::saveconfig()		Save configuration to init.php
	 * 
	 * @return 
	 **/
	function saveconfig(){
		global $vars;
		$filename = "init.php";
		$contents = implode('',file($filename));
		preg_match_all("|(.*)=(.*);|U",$contents ,$matches );
		foreach($matches[1] as $k=>$v){
			$contents = str_replace($matches[1][$k]."=".$matches[2][$k].";",$matches[1][$k]."= ".stripcslashes($vars[$k]).";", $contents);
		}
		// Assurons nous que le fichier est accessible en écriture
		if (is_writable($filename)) {
		
		    // Dans notre exemple, nous ouvrons le fichier $filename en mode d'ajout
		    // Le pointeur de fichier est placé à la fin du fichier
		    // c'est là que $somecontent sera placé
		    if (!$handle = fopen($filename, 'w')) {
		         echo "Impossible d'ouvrir le fichier ($filename)";
		         exit;
		    }
		
		    // Ecrivons quelque chose dans notre fichier.
		    if (fwrite($handle, $contents) === FALSE) {
		       echo "Impossible d'écrire dans le fichier ($filename)";
		       exit;
		    }		    
		    fclose($handle);
		    return TRUE;
		} else {
		    return FALSE;
		}
	}
	
	/**
	 * backup::monitor()		Return tables status
	 * 
	 * @return 
	 **/
	function monitor(){
	
		$color3 = $this->color3;
		$color2 = $this->color2;
		$color1 = $this->color1;
		
		
		$res = '<table border=0 cellpadding=5>';
        $result =  $this->query('SHOW TABLE STATUS');
		$i = 0;		$bgcolor = $color3; $l1 = $l2 = "";
        while ($table = @$this->fetch_array($result)) {
			foreach($table as $k=>$v){
				if (!is_integer($k)) {
					$l1 .= "<th bgcolor=\"$color1\"><font size=1>$k</font></th>\n";
					$l2 .= "<td bgcolor=\"$bgcolor\"><font size=1>$v</font></td>\n"; 
				}
			}
			if ($i==0) {
			    $res .= "<tr>\n$l1</tr>\n";
			}
			$res .= "<tr>\n$l2</tr>\n";
			if ($bgcolor==$color3) {
			    $bgcolor = $color2;
			} else $bgcolor = $color3;
			$l1 = $l2 = "";
			$i++;
        }
		$res .= '</table>';
		return $res;
	}
	
	
	/**
	 * backup::getbackup()
	 * 
	 * @return 
	 **/
	function getbackup($bfile){

		if (is_file($this->backupdir."/".$bfile) and !strstr($bfile,"../")) {
			
			header("Pragma: public");
			header("Expires: 0");
			header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 			
			header("Content-Type: application/force-download");
			header("Content-Disposition: attachment; filename=".basename($this->backupdir."/".$bfile));
			header("Content-Description: File Transfer");
			@readfile($this->backupdir."/".$bfile);
			exit;
		}
	}
	
	
}

?>