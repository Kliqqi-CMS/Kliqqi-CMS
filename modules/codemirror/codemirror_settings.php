<?php

define('codemirror_path', my_pligg_base . '/modules/codemirror/');
define('codemirror_tpl', '../modules/codemirror/templates/');
define('codemirror_source', '../modules/codemirror/source/');
// don't touch anything past this line.

if(is_object($main_smarty)){
	$main_smarty->assign('codemirror_path', codemirror_path);
	$main_smarty->assign('codemirror_tpl', codemirror_tpl);
	$main_smarty->assign('codemirror_source', codemirror_source);
}

?>