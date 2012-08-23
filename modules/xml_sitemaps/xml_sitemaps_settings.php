<?php
/*
    XML Sitemaps module for Pligg
    Copyright (C) 2007-2008  Secasiu Mihai - http://patchlog.com

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License along
    with this program; if not, write to the Free Software Foundation, Inc.,
    51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
*/
// the path to the module. the probably shouldn't be changed unless you rename the xml_sitemaps folder(s)
define('xml_sitemaps_path', my_pligg_base . '/modules/xml_sitemaps/');

// the path to the module. the probably shouldn't be changed unless you rename the xml_sitemaps folder(s)
define('xml_sitemaps_lang_conf', '/modules/xml_sitemaps/lang.conf');

// don't touch anything past this line.

if(is_object($main_smarty)){
	$main_smarty->assign('xml_sitemaps_path', xml_sitemaps_path);
	$main_smarty->assign('xml_sitemaps_conf', xml_sitemaps_lang_conf);
}

?>
