<?php

/**
 * gonxlocale class : Localisation class
 * 
 * @package 
 * @author Ben Yacoub Hatem <hatem@php.net>
 * @copyright Copyright (c) 2004
 * @version $Id$ - 12/04/2004 14:48:04 - locale.class.php
 * @access public
 **/
class gonxlocale{
	/**
     * Constructor
     * @access protected
     */
	function locale(){
		
	}
	
	/**
	 *
	 * @access public
	 * @return void 
	 **/
	function init(){
		global $locale,$GonxAdmin,$HTTP_SESSION_VARS;
		if (session_is_registered('gonxlocale') and !isset($_GET["locale"])) {
		    $locale = $HTTP_SESSION_VARS["gonxlocale"];
		} elseif (!isset($_GET["locale"])) {
		    $locale = $GonxAdmin["locale"];
			session_register('gonxlocale');
			$gonxlocale = $locale;
		} elseif (isset($_GET["locale"])) {
			if (is_file("locale/".$_GET["locale"].".php")) {
				session_register('gonxlocale');
				$HTTP_SESSION_VARS["gonxlocale"] = $_GET["locale"];
			}
		}
		return $locale;
	}
	
	
	/**
	 * locale::menu()		Create locale menu for available translation
	 * 
	 * @return 
	 **/
	function menu(){
		global $go,$locale;
		$locale_menu = "";
		$d = dir("./locale");
		while (false !== ($entry = $d->read())) {
		   if ($entry!="." and $entry!=".." and preg_match('/(.*).php$/',$entry,$regs)) {
		   		if ($locale == $regs[1]) {
		   		    $sel = "selected";
		   		}else $sel="";
		       $locale_menu .= "\t<option value=$regs[1] $sel>$regs[1]</option>\n";
		   }
		}
		$locale_menu = "<form><select class=tab-s OnChange=\"location.href='?go=$go&locale='+ChgLocale.options[selectedIndex].value\" name=\"ChgLocale\">\n\n$locale_menu</select></form>\n\n";
		$d->close();
		return $locale_menu;
	}
}

?>