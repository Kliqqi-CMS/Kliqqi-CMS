<?php
class sidebar{
	
	function sidebar(){
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
		
		$main_smarty->assign('dynBlocks',$dynBlocks);
		
	}
	
	function get_module_widthgets(){
		
	}
	
	function get_themes_widthgets(){
		global $db;
		
		
	}
}
?>