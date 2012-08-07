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
	
	function add_js($file,$inline=false){
	
		$this->js[$this->top]['file']=$file;
		$this->js[$this->top]['inline']=$inline;
		
		$this->top++;
		
	}
	

	
	function get_js(){
		global $main_smarty;
		if(count($this->js)){
		foreach($this->js as $script_name){
			if($script_name['inline']){
			$this->all_script.='<script type="text/javascript"  language="javascript">';
			$this->all_script.="\n";
			$this->all_script.=$script_name['file'];
			$this->all_script.="\n";
			$this->all_script.='</script>';
			}else{
			$this->all_script.='<script type="text/javascript" src="'.$script_name['file'].'"></script>';
			}
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