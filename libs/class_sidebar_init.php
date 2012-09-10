<?php
class sidebar{
	
	var $all_widget;
	var $top;
	var $installed_block;
	
	function sidebar(){
		$this->all_widget=array();
		$this->top=0;
	}
	
	function load_sidebar_admin(){
		
	}
	
	function init_widthgets(){
	global $db, $thetemp, $module_actions_tpl, $main_smarty;
	
	$blocks = $db->get_results('SELECT * from ' .table_block . ' where enabled=1 order by weight ASC');
	$i=0;
	
	foreach($blocks as $block)
	{
		if($block->module=='template_include'){
			   if(file_exists(mnmpath."templates/".$thetemp."/sidebar_modules/".$block->callback_tpl)){
				$dynBlocks[$i]['callback']=$block->callback_tpl;
				$dynBlocks[$i]['type']="include";
			   }
		 }
		
			if (array_key_exists($block->callback_tpl, $module_actions_tpl)){
			 $dynBlocks[$i]['callback']=$block->callback_tpl;
			 $dynBlocks[$i]['type']="module";	
			 
			 $blocksarr[$block->callback_tpl]=$module_actions_tpl[$block->callback_tpl];
			}
		  $i++;
		}
		
		$this->installed_block=$dynBlocks;
		if ($main_smarty)
			$main_smarty->assign('dynBlocks',$dynBlocks);
		
	}
	
	function get_module_widthgets(){
	$module_widgets= array();	
	global $db, $module_actions_tpl;
	$i=0;
	foreach($module_actions_tpl as $action_name => $actions_tpl){
		$pos = strpos($action_name, "_");
		if(!empty($pos)){
		$action_array=@explode("_",$action_name);
		if($action_array[0]=="widget" && $pos==6){
			$name=str_replace("_"," ",$action_name);
			$name=str_replace("widget","",$name);
			$this->all_widget[$this->top]['name']=$name;
			$this->all_widget[$this->top]['callback_tpl']=$action_name;
			$this->all_widget[$this->top]['m_type']="dynamic_module";
			$this->top++;
		}
		
		}
		
	}
	
		
	}
	
	function get_themes_widthgets(){
		global $db;
		$path=mnmpath."templates/".The_Template."/sidebar_modules";
		if ($handle = opendir($path)) {
		while (false !== ($entry = readdir($handle))) {
			if($entry!="index.html" && $entry!="wrapper.tpl" && $entry!="wrapper2.tpl" && $entry!="" && $entry!="." && $entry!=".."){
			$name=str_replace(".tpl","",$entry);
			$name=str_replace(".php","",$name);
			$name=str_replace("_"," ",$name);
			$this->all_widget[$this->top]['name']=$name;
			$this->all_widget[$this->top]['callback_tpl']=$entry;
			$this->all_widget[$this->top]['m_type']="template_include";
			$this->top++;
			}
		}
		
				
		closedir($handle);
		}
		
		
	}
	
	
 function get_uninstall_widgets(){
	 global $db;
	 
	 $blocks = $db->get_results('SELECT * from ' .table_block );
	  $i=0;
	  if(count($blocks))
	  while($blocks){
		  
	  }
	 
	 $this->get_module_widthgets();
	 $this->get_themes_widthgets();
	 
	 print_r($this->installed_block);
	 foreach($this->all_widget as $uwidgeth)
	 {
		 
	 }
	 
	 
	 //array_diff($this->all_widget,$this->installed_block);
	 
	}
}


function in_array_r($needle, $haystack, $strict = true) {
    foreach ($haystack as $item) {
        if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_r($needle, $item, $strict))) {
            return true;
        }
    }

    return false;
}

?>