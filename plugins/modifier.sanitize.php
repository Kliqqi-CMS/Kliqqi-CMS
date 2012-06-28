<?php
/**
 * template_lite replace modifier plugin
 *
 * Type:     modifier
 * Name:     sanitize
 * Purpose:  
 */
function tpl_modifier_sanitize($var, $santype)
{
	if ($santype == 1) {return strip_tags($var);}
	if ($santype == 2) {return htmlentities(strip_tags($var),ENT_QUOTES,'UTF-8');}
	if ($santype == 3) {return addslashes(htmlentities(strip_tags($var),ENT_QUOTES,'UTF-8'));}
}
?>