<?php

if(!defined('mnminclude')){header('Location: ../error_404.php');}

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

	function showpage(){
		global $db, $my_pligg_base;
		
		?>
			<div class="admin_config_content">
		<?php

		$sql = "Select * from " . table_config . " where var_page = '$this->var_page'";
		$configs = $db->get_results($sql);
		if ($configs) {
			global $db, $main_smarty;
			echo '<table class="table table-bordered table-striped">';
			echo '<thead><tr>';
			echo '<th>Title</th>';
			echo '<th>'.$main_smarty->get_config_vars(PLIGG_Visual_Config_Description).'</th>';
			echo '<th style="min-width:120px">'.$main_smarty->get_config_vars(PLIGG_Visual_Config_Value).'</th>';
			echo '<th style="width:120px;">'.$main_smarty->get_config_vars(PLIGG_Visual_Config_Default_Value).'</th>';
			echo '<th style="width:120px;">'.$main_smarty->get_config_vars(PLIGG_Visual_Config_Expected_Values).'</th>';
			echo '</tr></thead><tbody>';
			
			foreach($configs as $config) {
//				$this->var_id=$config_id;
//				$this->read();
				foreach ($config as $k=>$v)
				    $this->$k = $v;
				$this->print_summary();
//				$EditInPlaceCode .= $this->EditInPlaceCode;
			}
			echo '</tbody></table>';
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

		echo '<span id="var_'.$this->var_id.'_span"><form onsubmit="return false">';
		echo '<tr>';
		echo "<td>".translate($this->var_title)."</td>";
		echo "<td>".translate($this->var_desc)."</td><td>";
		
		if($this->var_name == '$my_base_url'){echo translate("It looks like this should be set to")." <strong>"."http://" . $_SERVER["HTTP_HOST"]."</strong><br>";}
		
		if($this->var_name == '$my_pligg_base'){
			$pos = strrpos($_SERVER["SCRIPT_NAME"], "/admin/");
			$path = substr($_SERVER["SCRIPT_NAME"], 0, $pos);
			if ($path == "/" || $path == ""){$path = translate("Nothing - Leave it blank");}
			echo translate("It looks like this should be set to")." <strong>".$path."</strong><br>";
		}
		
		echo '<input class="form-control admin_config_input emptytext" id="editme' .$this->var_id. '" onclick="show_edit('.$this->var_id.')" value="'.htmlentities($this->var_value,ENT_QUOTES,'UTF-8').'">';
		echo '<span class="emptytext" id="showme' .$this->var_id. '" style="display:none;">';
		if (preg_match('/^\s*(.+),\s*(.+) or (.+)\s*$/',$this->var_optiontext,$m))
		{
		    echo "<select name=\"var_value\" class=\"form-control\">";
		    for($ii=1; $ii<=3; $ii++)
			echo "<option value='{$m[$ii]}' ".($m[$ii]==$this->var_value ? "selected" : "").">{$m[$ii]}</option>";
		    echo "</select><br />";
		}
		elseif (preg_match('/^\s*(.+[^\/])\s*\/\s*([^\/].+)\s*$/',$this->var_optiontext,$m) ||
		    preg_match('/^\s*(.+) or (.+)\s*$/',$this->var_optiontext,$m))
		{
		    if (preg_match('/^(\d+)\s*=\s*(.+)$/',$m[1],$m1) && 
			preg_match('/^(\d+)\s*=\s*(.+)$/',$m[2],$m2))
		    	echo "<select name=\"var_value\" class=\"form-control\"><option value='{$m1[1]}' ".($m1[1]==$this->var_value ? "selected" : "").">{$m1[2]}</option><option value='{$m2[1]}' ".($m2[1]==$this->var_value ? "selected" : "").">{$m2[2]}</option></select><br />";
		    else
		    	echo "<select name=\"var_value\" class=\"form-control\"><option value='{$m[1]}' ".($m[1]==$this->var_value ? "selected" : "").">{$m[1]}</option><option value='{$m[2]}' ".($m[2]==$this->var_value ? "selected" : "").">{$m[2]}</option></select><br />";
		}
		elseif (preg_match('/^\s*(\d+)\s*-\s*(\d+)\s*$/',$this->var_optiontext,$m))
		{
		    echo "<select name=\"var_value\" class=\"form-control\">";
		    for ($ii=$m[1]; $ii<=$m[2]; $ii++)
			echo "<option value='$ii' ".($ii==$this->var_value ? "selected" : "").">$ii</option>";
		    echo "</select><br />";
		}
		else
		{
		    echo "<input type=\"text\" class='form-control admin_config_input edit_input' name=\"var_value\" value=\"".htmlentities($this->var_value,ENT_QUOTES,'UTF-8')."\" ";
		    if (strpos($this->var_optiontext,'number')===0) {
				$min = preg_match('/at least (\d+)/',$this->var_optiontext,$m) ? $m[1] : 0;
				echo "size='5' onblur='check_number({$this->var_id},this,$min)'";
	 	    }
		    echo '>';
		}
		echo "<input style='margin:4px 4px 0 0;' type=\"submit\" class=\"btn btn-primary\" value=\"Save\" onclick=\"save_changes({$this->var_id},this.form)\">";
		echo "<input style='margin-top:3px;' type=\"reset\" class=\"btn btn-default\" value=\"Cancel\" onclick=\"hide_edit({$this->var_id})\"></span></td>";
		echo "<td>{$this->var_defaultvalue}</td>";
		echo "<td>{$this->var_optiontext}</td>";
		echo '<input type = "hidden" name = "var_id" value = "'.$this->var_id.'">';
		echo "</td></tr></form></span>";
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
						echo "<strong>Could not write to '$filename' file</strong>";
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
			echo "<strong>Could not open '$filename' file for writing</strong>";
		}
	}
}

?>
