<?php
class PliggDoc{
	
	var $js;
	var $all_script;
	var $top;
	
	function PliggDoc(){
		$this->js=array();
		$this->all_script="";
		$this->top=0;
	}
	
	function add_js($file){
	
		$this->js[$this->top++]=$file;
		
	}
	
	function get_js(){
		global $main_smarty;
		if(count($this->js)){
		foreach($this->js as $script_name){
			$this->all_script.='<script type="text/javascript" src="'.$script_name.'"></script>';
			$this->all_script.="\n";
		}
		}
		//if(class_exists("main_smarty"))
		$main_smarty->assign("Jscript",$this->all_script);
		
		return $this->all_script;
		
	}
}

$PliggDoc= new PliggDoc();

?>