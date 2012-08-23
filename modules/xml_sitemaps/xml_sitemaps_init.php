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
if(defined('mnminclude')){
	include_once('xml_sitemaps_settings.php');

	$include_in_pages = array('all');
	$do_not_include_in_pages = array();

	if( do_we_load_module() ) {
                if($moduleName == 'xml_sitemaps_show_sitemap'){
                        module_add_action('module_page', 'xml_sitemaps_show_sitemap', '');
                        include_once(mnmmodules . 'xml_sitemaps/xml_sitemaps_main.php');
                }
           	module_add_action('do_submit3', 'xml_sitemaps_sites_ping', '');
                include_once(mnmmodules . 'xml_sitemaps/xml_sitemaps_main.php');
 	}       
}
?>
