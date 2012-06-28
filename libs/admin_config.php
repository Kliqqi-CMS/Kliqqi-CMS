<?php
// The source code packaged with this file is Free Software, Copyright (C) 2005 by
// The Pligg Team <developers at pligg dot com>.
// It's licensed under the AFFERO GENERAL PUBLIC LICENSE unless stated otherwise.
// You can get copies of the licenses here:
// 		http://www.affero.org/oagpl.html
// AFFERO GENERAL PUBLIC LICENSE is also included in the file called "COPYING".

if(!defined('mnminclude')){header('Location: ../404error.php');}

class pliggconfig {
	var $id = 0;
	var $var_page = 0;
	var $var_name = 0;
	var $var_value = 0;
	var $var_defaultvalue = 0;
	var $var_optiontext = false;
	var $var_title = 0;
	var $var_desc = '';
	var $EditInPlaceCode = '';

	function listpages(){
		global $db, $main_smarty;
		$sql = "Select var_page from " . table_config . " group by var_page;";
		$configs = $db->get_col($sql);
		if ($configs) {
			echo "<div class='admin_config'><h1><img src=\"".my_pligg_base."/templates/admin/images/manage_config.gif\" align='absmiddle' /> ". $main_smarty->get_config_vars('PLIGG_Visual_AdminPanel_Configure')."</h1><table style=border:none>";
			foreach($configs as $config_id) {
				if($config_id != "Hidden"){
					echo '<tr><td onClick="document.location.href=\'?page='.$config_id.'\';" style="cursor:pointer;cursor:hand"><a href = "?page='.$config_id.'">'.translate($config_id).'</a></tr></td>';
				}	
			}
			echo '</table></div>';
		} else {
			echo translate("nothing found");
		}
		
	}

	function showpage(){
		global $db, $my_pligg_base;
		
		?>
			
			<div class="admin_config_content">
			<style type="text/css">
				.eip_editable { background-color: #ff9; padding: 3px; }
				.eip_savebutton { background-color: #36f; color: #fff; }
				.eip_cancelbutton { background-color: #000; color: #fff; }
				.eip_saving { background-color: #903; color: #fff; padding: 3px; }
				.eip_empty { color: #afafaf; }
				.emptytext {padding:0px 5px 0px 5px;border-top:2px solid #828177;border-left:2px solid #828177;border-bottom:1px solid #B0B0B0;border-right:1px solid #B0B0B0;background:#F5F5F5;}
			</style>
		<?php

		$sql = "Select * from " . table_config . " where var_page = '$this->var_page'";
		$configs = $db->get_results($sql);
		if ($configs) {
			foreach($configs as $config) {
//				$this->var_id=$config_id;
//				$this->read();
				foreach ($config as $k=>$v)
				    $this->$k = $v;
				$this->print_summary();
//				$EditInPlaceCode .= $this->EditInPlaceCode;
			}
		} else {
			echo "No Configuration Tables Found";
		}
		echo '</div><div style="clear:both;"> </div>';
	}

	function read(){
		global $db;
		$config = $db->get_row("SELECT * FROM " . table_config . " WHERE var_id = $this->var_id");

			$this->var_page=$config->var_page;
			$this->var_name=$config->var_name;
			$this->var_value=htmlentities($config->var_value);
			$this->var_defaultvalue=$config->var_defaultvalue;
			$this->var_optiontext=$config->var_optiontext;
			$this->var_title=$config->var_title;
			$this->var_desc=$config->var_desc;

		return true;
	}
		
	function store($loud = true){
		global $db;
		if(strtolower($this->var_value) == 'true'){$this->var_value = 'true';}
		if(strtolower($this->var_value) == 'false'){$this->var_value = 'false';}
		$sql = "UPDATE " . table_config . " set var_value = '".$this->var_value."' where var_id = ".$this->var_id;
		$db->query($sql);
		$this->create_file();

		$content = $this->var_value;
		if($loud == true){
			print(htmlspecialchars($content));
		}

		return true;
	}
		
	function print_summary(){
		global $db, $main_smarty;

		echo '<span id = var_'.$this->var_id.'_span><form onsubmit="return false">';
		echo "<fieldset><legend><b>".translate($this->var_title)."</b></legend>";
		echo $main_smarty->get_config_vars(PLIGG_Visual_Config_Description).": ".translate($this->var_desc)."<br>";
		
		if($this->var_name == '$my_base_url'){echo translate("It looks like this should be set to")." <b>"."http://" . $_SERVER["HTTP_HOST"]."</b><br>";}
		
		if($this->var_name == '$my_pligg_base'){
			$pos = strrpos($_SERVER["SCRIPT_NAME"], "/admin/");
			$path = substr($_SERVER["SCRIPT_NAME"], 0, $pos);
			if ($path == "/" || $path == ""){$path = translate("nothing - just leave it blank");}
			echo translate("It looks like this should be set to")." <b>".$path."</b><br>";
		}
		
		echo '<b>'.$main_smarty->get_config_vars(PLIGG_Visual_Config_Value).':</b> <span class="emptytext" id="editme' .$this->var_id. '" onclick="show_edit('.$this->var_id.')">'.htmlentities($this->var_value,ENT_QUOTES,'UTF-8').'</span>';
		echo '<span id="showme' .$this->var_id. '" style="display:none;">';
		if (preg_match('/^\s*(.+),\s*(.+) or (.+)\s*$/',$this->var_optiontext,$m))
		{
		    echo "<select name=\"var_value\">";
		    for($ii=1; $ii<=3; $ii++)
			echo "<option value='{$m[$ii]}' ".($m[$ii]==$this->var_value ? "selected" : "").">{$m[$ii]}</option>";
		    echo "</select>";
		}
		elseif (preg_match('/^\s*(.+[^\/])\s*\/\s*([^\/].+)\s*$/',$this->var_optiontext,$m) ||
		    preg_match('/^\s*(.+) or (.+)\s*$/',$this->var_optiontext,$m))
		{
		    if (preg_match('/^(\d+)\s*=\s*(.+)$/',$m[1],$m1) && 
			preg_match('/^(\d+)\s*=\s*(.+)$/',$m[2],$m2))
		    	echo "<select name=\"var_value\"><option value='{$m1[1]}' ".($m1[1]==$this->var_value ? "selected" : "").">{$m1[2]}</option><option value='{$m2[1]}' ".($m2[1]==$this->var_value ? "selected" : "").">{$m2[2]}</option></select>";
		    else
		    	echo "<select name=\"var_value\"><option value='{$m[1]}' ".($m[1]==$this->var_value ? "selected" : "").">{$m[1]}</option><option value='{$m[2]}' ".($m[2]==$this->var_value ? "selected" : "").">{$m[2]}</option></select>";
		}
		elseif (preg_match('/^\s*(\d+)\s*-\s*(\d+)\s*$/',$this->var_optiontext,$m))
		{
		    echo "<select name=\"var_value\">";
		    for ($ii=$m[1]; $ii<=$m[2]; $ii++)
			echo "<option value='$ii' ".($ii==$this->var_value ? "selected" : "").">$ii</option>";
		    echo "</select>";
		}
		else
		{
		    echo "<input type=\"text\" name=\"var_value\" value=\"".htmlentities($this->var_value,ENT_QUOTES,'UTF-8')."\" ";
		    if (strpos($this->var_optiontext,'number')===0)
		    {
			$min = preg_match('/at least (\d+)/',$this->var_optiontext,$m) ? $m[1] : 0;
			echo "size='5' onblur='check_number({$this->var_id},this,$min)'";
	 	    }
		    echo '>';
		}
		echo "<br><input type=\"submit\" value=\"Save\" onclick=\"save_changes({$this->var_id},this.form)\">";
		echo "<input type=\"reset\" value=\"Cancel\" onclick=\"hide_edit({$this->var_id})\"></span><br>";
		echo $main_smarty->get_config_vars(PLIGG_Visual_Config_Default_Value).": {$this->var_defaultvalue}<br>";
		echo $main_smarty->get_config_vars(PLIGG_Visual_Config_Default_Value).": {$this->var_optiontext}";
		echo '<input type = "hidden" name = "var_id" value = "'.$this->var_id.'">';
		echo "</fieldset></form></span>";
//		$this->EditInPlaceCode = "EditInPlace.makeEditable( {type: 'text', action: 'save', id: 'editme" .$this->var_id. "',	save_url: 'admin_config.php'} );";		
		
	}


	function create_file($filename = "../settings.php"){
		global $db;
		if($handle = fopen($filename, 'w')) {
		
			fwrite($handle, "<?php\n");
			$usersql = $db->get_results('SELECT * FROM ' . table_prefix . 'config');
			foreach($usersql as $row) {
				$value = $row->var_enclosein . $row->var_value. $row->var_enclosein;
				
				$write_vars = array('table_prefix', '$my_base_url', '$my_pligg_base', '$dblang', '$language' );
				
				if(in_array($row->var_name, $write_vars)){
				
					if ($row->var_method == "normal"){
						$line =  $row->var_name . " = " . $value . ";";
					}
					if ($row->var_method == "define"){
						$line = "define('" . $row->var_name . "', ". $value . ");";
					}
				
					if(fwrite($handle, $line . "\n")) {
			
					} else {
						echo "<b>Could not write to '$filename' file</b>";
					}
				}				
			}
			fwrite($handle, "include_once mnminclude.'settings_from_db.php';\n");
			fwrite($handle, "?>");
			fclose($handle);

			if(caching == 1){
				// this is to clear the cache and reload it for settings_from_db.php
				$db->cache_dir = mnmpath.'cache';
				$db->use_disk_cache = true;
				$db->cache_queries = true;
				$db->cache_timeout = 0;
				$usersql = $db->get_results('SELECT var_name, var_value, var_method, var_enclosein FROM ' . table_prefix . 'config');
				$db->cache_queries = false;
			}

		} else {
			echo "<b>Could not open '$filename' file for writing</b>";
		}
	}
}

?>
