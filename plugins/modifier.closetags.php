<?php
/**
 * template_lite closetags modifier plugin
 *
 * Type:     modifier
 * Name:     closetags
 * Purpose:  Close open HTML tags when truncating content.
 * Credit:   From Répás @ http://stackoverflow.com/questions/2671053/truncate-a-html-formatted-text-with-smarty
 */

function tpl_modifier_closetags($string) {
	preg_match_all('#<(?!meta|img|br|hr|input\b)\b([a-z]+)(?: .*)?(?<![/|/ ])>#iU', $string, $result);
	$openedtags = $result[1];
	preg_match_all('#</([a-z]+)>#iU', $string, $result);
	$closedtags = $result[1];
	$len_opened = count($openedtags);
	if (count($closedtags) == $len_opened) {
		return $string;
	}
	$openedtags = array_reverse($openedtags);
	for ($i=0; $i < $len_opened; $i++) {
		if (!in_array($openedtags[$i], $closedtags)) {
			$string .= '</'.$openedtags[$i].'>';
		} else {
			unset($closedtags[array_search($openedtags[$i], $closedtags)]);
		}
	}
	return $string;
}

?>