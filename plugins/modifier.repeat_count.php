<?php
/**
 * template_lite repeat modifier plugin
 *
 * Type:     modifier
 * Name:     repeat
 * Purpose:  Wrapper for the PHP 'str_repeat' function
 * Credit:   Created for the Pligg CMS by the Pligg Dev Team
 * Instead of giving the number of times to repeat the string/smarty variable,
 * you give the string to repeat. The number of times to repeat is the smarty variable
 * example
 * PHP: $smarty->assign('numberoftimes', 2);
 * TPL: {$numberoftimes|repeat_count:'X'}
 * Will display:  XX
*/
function tpl_modifier_repeat_count($count, $string)
{
	return str_repeat($string, $count);
}
?>