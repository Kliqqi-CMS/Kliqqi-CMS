<?php

// Quick "EditInPlace"
// v0.3 - 2006/09/08
// 		added default values
//		added some examples


/* example


	$QEIPA = array('table_name' => 'items',  // the name of the table to use
			          'field_name' => 'item_due',  // the name of the field in the table
			          'key' => 'item_id',  // a unique identifier for the row
			          'keyvaltype' => 'number', // this unique key, text or number		-- DEFAULT IS TEXT
			          'eip_type' => 'text',  // the type of EIP field to show			-- DEFAULT IS TEXT
			          'field_type' => 'text'); // the type of database field we are reading from / writing to 		-- DEFAULT IS TEXT
	$smarty->assign('qeip_ItemDue', $QEIPA);

	If any field has a DEFAULT, then you can skip it. Example:
	
	$QEIPA = array('table_name' => 'items',  // the name of the table to use
			          'field_name' => 'item_due',  // the name of the field in the table
			          'key' => 'item_id');  // a unique identifier for the row
	$smarty->assign('qeip_ItemDue', $QEIPA);
	
	
*/

if(!defined('mnminclude')){header('Location: ../../404error.php');}

class QuickEIP {
	var $SavedItemName = "";
	var $SavedItemFieldName = "";
	var $SavedItemValue = "";
	var $SavedItemKeyValue = "";
	

	function save_field($passed_smarty = ''){
		Global $smarty, $db;
		//$eip_item = $smarty->get_template_vars($eip_item_name);
		
		if($passed_smarty != ''){
			$smarty = $passed_smarty;
		}
		
		$eip_item_name=$_REQUEST['var_id'];

		if(strpos($eip_item_name, "_-_") > 0){
			$eip_a = substr($eip_item_name, 0, strpos($eip_item_name, "_-_"));
			$eip_b = substr($eip_item_name, strpos($eip_item_name, "_-_") + 3, 100);
			$keyval = $eip_b;
			$eip_item = $smarty->get_template_vars($eip_a);
			$this->SavedItemName = $eip_a;
		} else {
			$eip_item = $smarty->get_template_vars($eip_item_name);
			$keyval = $_REQUEST['keyval'];
			$this->SavedItemName = $eip_item_name;
		}

		$this->SavedItemFieldName = $eip_item['field_name'];
		$this->SavedItemValue = $_REQUEST['var_value'];
		$this->SavedItemKeyValue = $keyval;

		// set some defaults
		if(!isset($eip_item['keyvaltype']) || $eip_item['keyvaltype'] == ""){$eip_item['keyvaltype'] = "number";}
		if(!isset($eip_item['eip_type']) || $eip_item['eip_type'] == ""){$eip_item['eip_type'] = "text";}
		if(!isset($eip_item['field_type']) || $eip_item['field_type'] == ""){$eip_item['field_type'] = "text";}
		
		$eip_item['field_name'];
		$sql = "UPDATE " . $eip_item['table_name'] . " set " . $eip_item['field_name'] . " = ";

		if ($eip_item['field_type'] == "text"){$sql .= '"' . safeAddSlashes($_REQUEST['var_value']) . '"';} 
		if ($eip_item['field_type'] == "number"){$sql .= intval($_REQUEST['var_value']);} 
		
		$sql .= " where " . $eip_item['key'] . " = ";

		if ($eip_item['keyvaltype'] == "text"){$sql .= '"' . safeAddSlashes($keyval) . '"';} 
		if ($eip_item['keyvaltype'] == "number"){$sql .= intVal($keyval);} 
		
		$sql .= ";";
		$db->query($sql);
		
		return str_replace("_ne_st_ed_", " : ", $_REQUEST['var_value']);
		
	}
	
	
	function ShowOnloadJS(){
		global $main_smarty;
		
		$x = '<script type="text/javascript">';
		$x .= "Event.observe(window, 'load', init, false);";
		$x .= "function init() {";
		$x .= $main_smarty->get_template_vars('js_data');
		$x .= "}</script>";
		
		return $x;
	}		
		
}
?>