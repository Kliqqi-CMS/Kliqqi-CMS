<?php
	// version 1.0 -- 2006/09/01
	// version 1.1 -- 2006/09/08
	// version 1.2 -- 2006/11/19
	
	function tpl_function_eipItem($params, &$smarty)
	{
		$params['eip_item'] = $params['item'];

		//if(isset($params['item'])){$params['eip_item'] = $params['item'];}
		if(strpos($params['eip_item'], "_-_") > 0){
			$eip_a = substr($params['eip_item'], 0, strpos($params['eip_item'], "_-_"));
			$eip_b = substr($params['eip_item'], strpos($params['eip_item'], "_-_") + 3, 100);
			$keyval = $eip_b;
			$eip_item = $smarty->get_template_vars($eip_a);
		} else {
			$eip_item = $smarty->get_template_vars($params['eip_item']);
			if(isset($eip_item['keyval'])){$keyval = $eip_item['keyval'];}else{$keyval='';}
			if(isset($params['unique'])){
				$eip_b = $params['unique'];
				$keyval = $eip_b;
				$params['eip_item'] .= '_-_' . $keyval;
			}
		}
		
		global $db;

		// set some defaults
		if(!isset($eip_item['keyvaltype']) || $eip_item['keyvaltype'] == ""){$eip_item['keyvaltype'] = "number";}
		if(!isset($eip_item['eip_type']) || $eip_item['eip_type'] == ""){$eip_item['eip_type'] = "text";}
		if(!isset($eip_item['field_type']) || $eip_item['field_type'] == ""){$eip_item['field_type'] = "text";}
		
		$sql = "SELECT " . $eip_item['field_name'] . " FROM " . $eip_item['table_name'] . " WHERE " . $eip_item['key'] . " = ";
	
		if ($eip_item['keyvaltype'] == "text"){$sql .= "'" . $keyval . "'";} 
		if ($eip_item['keyvaltype'] == "number"){$sql .= $keyval;} 
	
		//echo $sql . "<BR>";
	
		$n = str_replace("_ne_st_ed_", " : ", $db->get_var($sql));
		
		$html_data = '<span id="'.$params['eip_item'].'">'.$n.'</span>';
	
		if(isset($eip_item['keyval'])){$keyval = $eip_item['keyval'];}else{$keyval='';}
		$js_data = "EditInPlace.makeEditable( {type: '".$eip_item['eip_type']."', pagename: '".$smarty->get_template_vars('eip_page_name')."', keyval: '".$keyval."', action: 'save', id: '".$params['eip_item']."',	save_url: '".$_SERVER['SCRIPT_NAME'];
		if($_SERVER['QUERY_STRING'] != ''){
			$js_data .= '?'.$_SERVER['QUERY_STRING']."'";
		} else { 
			$js_data .= "'";
		}
		if ($eip_item['eip_type'] == "select"){$js_data .= ", " . $smarty->get_template_vars('eip_select');}
		$js_data .= "} );";
	
		$smarty->assign('js_data', $smarty->get_template_vars('js_data') . $js_data);
		
		// Added in 1.2
		// If a TPL is INCLUDED (like in pligg.tpl) the ASSIGNed varibles do not make it back to PHP
		// so we cannot call the ShowOnloadJS() function at the end of the page and have all the
		// JS in one spot. The quickest solution was to show the JS along with the HTML (ugly, I know, but it works)
		if(isset($params['ShowJS'])){
			$x = '<script type="text/javascript">';
			$x .= "Event.observe(window, 'load', init, false);";
			$x .= "function init() {";
			$x .= $js_data;
			$x .= "}</script>";
		} else {
			$x = "";
		}
		
		return $html_data . $x;
	
	}
?>