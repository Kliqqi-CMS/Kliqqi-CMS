<?php
/*
 * template_lite plugin
 * -------------------------------------------------------------
 * Type:     function
 * Name:     eval
 * Purpose:  prints out the options for an html_select item
 * Credit:   Taken from the original Smarty
 *           http://smarty.php.net
 * -------------------------------------------------------------
 */
function tpl_function_eval($params, &$tpl)
{

    if (!isset($params['var'])) {
        $tpl->trigger_error("eval: missing 'var' parameter");
        return;
    }

    if($params['var'] == '') {
        return;
    }

    $tpl->_compile_source('evaluated template', $params['var'], $_var_compiled);

    ob_start();
    $tpl->_eval('?>' . $_var_compiled);
    $_contents = ob_get_contents();
    ob_end_clean();

    if (!empty($params['assign'])) {
        $tpl->assign($params['assign'], $_contents);
    } else {
        return $_contents;
    }
}

/* vim: set expandtab: */

?>
