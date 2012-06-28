<?php

/**
 * gonxtabs class : Tabs Class Management.
 * 
 * @package 
 * @author Ben Yacoub Hatem <hatem@php.net>
 * @copyright Copyright (c) 2004
 * @version $Id$ - 04/03/2004 14:17:23 - tabs.class.php
 * @access public
 **/
class gonxtabs{
	/**
     * Constructor
     * @access protected
     */
	function gonxtabs(){

	}
	
	/**
	 * tabs::create() : Create tabs
	 * 
	 * @param $menus	Array of tabs
	 * @param $go		Selected tab
	 * @return Tabs in HTML format
	 **/
	function create($menus,$go,$tablewidth="100%"){
		$result = "\n\n<!-- GONX TABS -->
<table cellSpacing=\"0\" cellPadding=\"0\" width=\"$tablewidth\" background=\"image.php?img=stab_bg_gif\" border=\"0\" align=center>
  <tr height=\"24\">
    <td width=\"40\">
    <img height=\"24\" src=\"image.php?img=stab_bg_gif\" width=\"40\"></td>
    <td align=\"left\" width=\"600\">
	<table cellSpacing=\"0\" cellPadding=\"0\" border=\"0\">
      <tr height=\"24\">
        <td>&nbsp;</td>\n";
		
		$mk = array_keys($menus);
		$i = 1;
		foreach($menus as $k=>$v){
			if ($k==$go) {
				$m{$i} = "stab_sb_gif";
				$t{$i} = "class=\"tab-s\"";
			} else {
				$m{$i} = "stab_ub_gif";
				$t{$i} = "class=\"tab-g\"";
			}

			if (($i-1)>=0 and $mk[$i-1]==$go) {
			    $mx{$i} = "stab_mus_gif";
			} elseif (($i-2)>=0 and $mk[$i-2]==$go) {
			    $mx{$i} = "stab_msu_gif";
			} else {
			    $mx{$i} = "stab_muu_gif";
			}
				

			// First Tab
			if ($i==1) {
				$mx{$i} = "stab_bs_gif";
				$width = 1;
			} else {
				$width = 14;
			}
			
			if (preg_match('/^http:\/\//',$k)) {
			    $lien = "$k";
			} else {
				$lien = "?go=$k";
			}
			if (preg_match('/^javascript:/',$k)) {
			    $onclick = " onClick=\"window.close()\"";
				$lien = "#";
			} else $onclick ="";
			
			$result .="        <td vAlign=\"center\" noWrap background=\"image.php?img=".$m{$i}."\">
        <img src=\"image.php?img=".$mx{$i}."\" align=\"absMiddle\" width=\"$width\" height=\"24\"></td>
        <td vAlign=\"center\" noWrap background=\"image.php?img=".$m{$i}."\">
        &nbsp;&nbsp;<a ".$t{$i}." accessKey=\"$i\" href=\"$lien\" $onclick>$v</a></td>\n\n";


			$i++;
		}

		// Latest tab
		if ($go==$mk[sizeof($menus)-1]) {
		    $result .= "        <td>
        <img src=\"image.php?img=stab_es_gif\" width=\"10\" height=\"24\"></td>\n";
		} else {
		    $result .= "        <td>
        <img src=\"image.php?img=stab_eu_gif\" width=\"10\" height=\"24\"></td>\n";
		}

		$result .= "      </tr>
    </table>
	    </td>
    <td align=right> <!-- GONX LOCALE -->\n".gonxlocale::menu()."\n<!-- /GONX LOCALE -->\n</td>
  </tr>
</table>
<!-- /GONX TABS -->\n\n";
		return $result;
	}
	
	/**
	 * gonxtabs::block()	create a block of content
	 * 
	 * @param string $content
	 * @param string $tablewidth
	 * @return 
	 **/
	function block($content = "",$tablewidth="100%"){
		global $locale;
		if ($locale=="ar") {
		    $dir = " dir=rtl";
		}else $dir="";
$res =  "<br/>
<!-- GONX CONTENT -->
<table cellpadding='0' cellspacing='0' border='0' bgColor ='#F6F6F6' width='$tablewidth' align=center>
 <tr>
    <td><img src=\"image.php?img=corner_tl_gif\" border=\"0\" height=\"5\" width=\"5\" /></td>
    <td><img src=\"image.php?img=bar_t_gif\" border=\"0\" height=\"5\" width=\"100%\" /></td>
    <td><img src=\"image.php?img=corner_tr_gif\" border=\"0\" height=\"5\" width=\"5\" /></td>
 </tr>
  <tr>
    <td width='5' height='100%'><img src=\"image.php?img=bar_l_gif\" border=\"0\" height=\"100%\" width=\"5\" /></td>
    <td>
      <table cellpadding='2' cellspacing='3' border='0' width='100%' height='100%'>
        <tr> 
          <td$dir>\n$content\n</td>
        </tr>
      </table>
    </td>
    <td width='5' height='100%'><img src=\"image.php?img=bar_r_gif\" border=\"0\" height=\"100%\" width=\"5\" /></td>
  </tr>
  <tr>
    <td><img src=\"image.php?img=corner_bl_gif\" border=\"0\" height=\"5\" width=\"5\" /></td>
    <td><img src=\"image.php?img=bar_b_gif\" border=\"0\" height=\"5\" width=\"100%\" /></td>
    <td><img src=\"image.php?img=corner_br_gif\" border=\"0\" height=\"5\" width=\"5\" /></td>
  </tr>
</table>
<!-- /GONX CONTENT -->
<!-- GONX FOOTER -->
<br/>
<table cellpadding='0' cellspacing='0' border='0' bgColor ='white' width='$tablewidth' align=center>
  <tr>
    <td align=center><span class=blue>&nbsp;&nbsp;<font size=1>Author : Ben Yacoub Hatem - <a href=\"http://www.phptunisie.net/\" class=blue target=_blank>PHPTunisie.net</a><br>
    Copyright ©  2004-2005</font></span>
    </td>
  </tr>
</table>
<!-- /GONX FOOTER -->
</body>
</html>";
		return $res;
	}
	
}

?>