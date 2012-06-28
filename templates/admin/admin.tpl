<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html dir="{#PLIGG_Visual_Language_Direction#}" xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>

{if $pagename eq "admin_users"}{literal}
	<script language="javascript" type="text/javascript">
		parent.$.fn.colorbox.close()
	</script>
{/literal}{/if}

	{checkActionsTpl location="tpl_pligg_admin_head_start"}
	<link rel="stylesheet" type="text/css" href="{$my_pligg_base}/templates/admin/css/fraxi.css" media="screen">
	{checkForCss}
	
	<meta name="Language" content="en-us">
	<meta name="Robots" content="none">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />	
	
	<title>{#PLIGG_Visual_Name#} Admin Panel</title>
	<link rel="icon" href="{$my_pligg_base}/favicon.ico" type="image/x-icon"/>	
	
	<!--[if lte IE 6]><link rel="stylesheet" href="{$my_pligg_base}/templates/admin/css/ie6.css" type="text/css" media="all" /><![endif]-->

	<script type='text/javascript' src='{$my_pligg_base}/templates/admin/js/zebrastripe.js'></script>
	
	{if $pagename eq "admin_categories" || $modulename eq "admin_language" || $modulename eq "rss_import" || $pagename eq "admin_config"}
		<script type='text/javascript' src='{$my_pligg_base}/templates/admin/js/simpleedit.js'></script>
		<script type='text/javascript' src='{$my_pligg_base}/templates/admin/js/move.js'></script>
		<script type='text/javascript' src='{$my_pligg_base}/templates/admin/js/accordian.pack.js'></script>
	{/if}

	{checkActionsTpl location="tpl_pligg_admin_head_end"}

	{if $pagename neq "admin_categories"}
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script> 
	{/if}
	
	{if $pagename eq "admin_index"}
		<link type="text/css" href="../templates/admin/css/jquery.ui.theme.css" rel="stylesheet" /> 
		<link type="text/css" href="../templates/admin/css/admin_home.css" rel="stylesheet" />
		<script type="text/javascript" src="../templates/admin/js/jquery.ui.core.js"></script> 
		<script type="text/javascript" src="../templates/admin/js/jquery.ui.widget.js"></script> 
		<script type="text/javascript" src="../templates/admin/js/jquery.ui.mouse.js"></script> 
		<script type="text/javascript" src="../templates/admin/js/jquery.ui.sortable.js"></script>
		
		<link type="text/css" href="../templates/admin/css/coda-slider-2.0.css" rel="stylesheet" media="screen" /> 
		<script type="text/javascript" src="../templates/admin/js/jquery.easing.1.3.js"></script>
		<script type="text/javascript" src="../templates/admin/js/jquery.coda-slider-2.0.js"></script> 
	{/if}
	
	{if $pagename neq "admin_categories"}
	<!-- START Colorbox Lightbox -->
		<link media="screen" rel="stylesheet" href="{$my_pligg_base}/templates/admin/css/colorbox.css" />
		<script src="{$my_pligg_base}/templates/admin/js/jquery.colorbox.js"></script>
		{literal}
		<script>
			$(document).ready(function(){
				//Examples of how to assign the ColorBox event to elements
				$("a[rel='colorbox_image_1']").colorbox();
				$("a[rel='colorbox_image_2']").colorbox({transition:"fade"});
				$("a[rel='colorbox_image_3']").colorbox({transition:"none", width:"75%", height:"75%"});
				$("a[rel='colorbox_image_4']").colorbox({slideshow:true});
				$(".colorbox_ajax").colorbox();
				$(".colorbox_iframe1").colorbox({iframe:true, innerWidth:425, innerHeight:344});
				$(".colorbox_iframe2").colorbox({width:"80%", height:"80%", iframe:true});
				$(".colorbox_inline").colorbox({width:"50%", inline:true, href:"#inline_example1"});
			});
		</script>
		{/literal}
	<!-- END Colorbox Lightbox -->
	{/if}
	
	{if $pagename eq "admin_index"}
		{literal}
		<script type="text/javascript">
		$(function() {
			$(".column").sortable({
				connectWith: '.column'
			});

			$(".portlet").addClass("ui-widget ui-widget-content ui-helper-clearfix ui-corner-all")
				.find(".portlet-header")
					.addClass("ui-widget-header")
					.end()
				.find(".portlet-content");

			$(".ui-icon-minusthick").click(function() {
				$(this).toggleClass("ui-icon-minusthick").toggleClass("ui-icon-plusthick");
				$(this).parents(".portlet:first").find(".portlet-content:first").toggle();
				$(this).parents(".portlet:first").find(".portlet-content:first").each(function(index) {
					$.get("admin_index.php", { action: "minimize", display: this.style.display, id: this.parentNode.id }, function(data){
					});
				});
			});
			$(".ui-icon-plusthick").click(function() {
				$(this).toggleClass("ui-icon-plusthick").toggleClass("ui-icon-minusthick");
				$(this).parents(".portlet:first").find(".portlet-content:first").toggle();
				$(this).parents(".portlet:first").find(".portlet-content:first").each(function(index) {
					$.get("admin_index.php", { action: "minimize", display: this.style.display, id: this.parentNode.id }, function(data){
					});
				});
				var panelHeight = $(this).parents(".portlet:first").find(".panel:first").height();
				var codaslider = $(this).parents(".portlet:first").find(".coda-slider:first");
				codaslider.codaSlider();
	//			codaslider.css({ height: panelHeight });
			});


			jQuery(document).ajaxError(function(event, request, settings){ alert("Error"); });

			$( ".column" ).sortable({
				stop: function(event, ui) { 
					var data = '';
					$(".portlet").each(function(index) {
						data += this.id + ',';
					});
					$.get("admin_index.php", { action: "move", left: ui.offset.left, top: ui.offset.top, id: ui.item[0].id, list: data }, function(data){
	//  					alert("data load " + data);
					});

				}
			});

	//		$(".column").disableSelection();

		});
		$().ready(function() {
			$(".coda-slider").each(function(index) {
			$('#'+this.id).codaSlider();
			});
		});
		</script>
		{/literal}
	{/if}

</head>
<body dir="{#PLIGG_Visual_Language_Direction#}">
{checkActionsTpl location="tpl_pligg_admin_body_start"}
<div id="header">
	<div class="logo"><a href="{$my_pligg_base}/"><img src="{$my_pligg_base}/templates/admin/images/logo.gif" alt="Pligg CMS" title="Pligg CMS"/></a></div>
	<div id="head-nav">
		<ul class="nav-menu">
			<li><a href="{$my_pligg_base}/admin/admin_index.php" {if $pagename eq "admin_index"}class="navcur"{else}class="nav"{/if}>{#PLIGG_Visual_AdminPanel#}</a></li>
			<li><a href="{$my_pligg_base}/admin/admin_links.php" {if $pagename eq "admin_categories" || $pagename eq "admin_comments" || $pagename eq "admin_links" || $pagename eq "admin_users" || $pagename eq "admin_user_validate" || $pagename eq "admin_page"}class="navcur"{else}class="nav"{/if} >{#PLIGG_Visual_AdminPanel_Manage_Nav#}</a></li> 
			<li><a href="{$my_pligg_base}/admin/admin_config.php" {if $pagename eq "admin_config"}class="navcur"{else}class="nav"{/if} >{#PLIGG_Visual_AdminPanel_Configure#}</a></li>
			<li><a href="{$my_pligg_base}/admin/admin_modules.php" {if $pagename eq "admin_modules"}class="navcur"{else}class="nav"{/if} >{#PLIGG_Visual_AdminPanel_Modules_Nav#}</a></li>
			<li><a href="{$my_pligg_base}/admin/admin_widgets.php" {if $pagename eq "admin_widgets"}class="navcur"{else}class="nav"{/if} >{#PLIGG_Visual_AdminPanel_Widgets_Nav#}</a></li>
			<li><a href="{$my_pligg_base}/admin/admin_editor.php" {if $pagename eq "admin_editor"}class="navcur"{else}class="nav"{/if} >{#PLIGG_Visual_AdminPanel_Template_Nav#}</a></li>
			{checkActionsTpl location="tpl_header_admin_links"}
			<li><a href="{$my_pligg_base}/" class="nav">{#PLIGG_Visual_Home#}</a></li>
		</ul>
		<div id="navbar">
			  <a href="{$my_pligg_base}/">{#PLIGG_Visual_Home#}</a> &rsaquo; <a href="{$my_pligg_base}/admin/admin_index.php">{#PLIGG_Visual_AdminPanel#}</a> &rsaquo; 
			  {if $pagename eq "admin_backup"}{#PLIGG_Visual_AdminPanel_Backup#}{/if}
			  {if $module eq "captcha"}{#PLIGG_Visual_AdminPanel_Captcha#}{/if}
			  {if $pagename eq "admin_categories" || $pagename eq "admin_categories_tasks"}{#PLIGG_Visual_AdminPanel_Categories#}{/if}
			  {if $pagename eq "admin_comments"}{#PLIGG_Visual_AdminPanel_Comments#}{/if}
			  {if $pagename eq "admin_config"}{#PLIGG_Visual_AdminPanel_Configure#}{/if}
			  {if $pagename eq "admin_index"}{#PLIGG_Visual_AdminPanel_Home#}{/if}
			  {if $module eq "admin_language"}{#PLIGG_Visual_AdminPanel_Language#}{/if}
			  {if $pagename eq "admin_modules"}{#PLIGG_Visual_AdminPanel_Modules_Nav#}{/if}
			  {if $pagename eq "admin_widgets"}{#PLIGG_Visual_AdminPanel_Widgets_Nav#}{/if}
			  {if $pagename eq "admin_page"}{#PLIGG_Visual_AdminPanel_Pages#}{/if}
			  {if $pagename eq "admin_links"}{#PLIGG_Visual_AdminPanel_News#}{/if}
			  {if $pagename eq "admin_editor"}{#PLIGG_Visual_AdminPanel_Template_Nav#}{/if}
			  {if $pagename eq "admin_users"}{#PLIGG_Visual_AdminPanel_Users#}{/if}
			  {if $pagename eq "admin_group"}{#PLIGG_Visual_AdminPanel_Groups#}{/if}
			  {checkActionsTpl location="tpl_pligg_admin_breadcrumbs"}
		</div>
	</div>
</div>
<div style="clear:both;"></div>

{if $pagename eq "admin_links" || $pagename eq "admin_users" || $pagename eq "admin_comments" || $pagename eq "admin_categories" || $pagename eq "admin_categories_tasks" || $pagename eq "admin_page" || $pagename eq "edit_page" || $pagename eq "submit_page" || $pagename eq "admin_group"}
	<div class="tab-nav-spacing"><div class="tab-nav">
		<ul>
			{checkActionsTpl location="tpl_pligg_admin_navtabs_start"}
			<li {if $pagename eq "admin_links"}class="cur"{/if}><span><a href="{$my_pligg_base}/admin/admin_links.php">{#PLIGG_Visual_AdminPanel_News#}</a></span></li>
			<li {if $pagename eq "admin_users"}class="cur"{/if}><span><a href="{$my_pligg_base}/admin/admin_users.php">{#PLIGG_Visual_AdminPanel_Users#}</a></span></li>
			<li {if $pagename eq "admin_comments"}class="cur"{/if}><span><a href="{$my_pligg_base}/admin/admin_comments.php">{#PLIGG_Visual_AdminPanel_Comments#}</a></span></li>
			<li {if $pagename eq "admin_categories" || $pagename eq "admin_categories_tasks"}class="cur"{/if}><span><a href="{$my_pligg_base}/admin/admin_categories.php">{#PLIGG_Visual_AdminPanel_Categories#}</a></span></li>
			<li {if $pagename eq "admin_page" || $pagename eq "edit_page" || $pagename eq "submit_page"}class="cur"{/if}><span><a href="{$my_pligg_base}/admin/admin_page.php">{#PLIGG_Visual_AdminPanel_Pages#}</a></span></li>
			<li {if $pagename eq "admin_group"}class="cur"{/if}><span><a href="{$my_pligg_base}/admin/admin_group.php">{#PLIGG_Visual_AdminPanel_Groups#}</a></span></li>
			{checkActionsTpl location="tpl_pligg_admin_navtabs_end"}
		</ul>
	</div></div>
{/if}

{if $pagename eq "admin_modules"}
	<div class="tab-nav-spacing"><div class="tab-nav">
		<ul>
			<li {if $pagename eq "admin_modules" && $templatelite.get.status ne "uninstalled"}class="cur"{/if}><span><a href="{$my_pligg_base}/admin/admin_modules.php">{#PLIGG_Visual_Modules_Installed#}</a></span></li>
			<li {if $pagename eq "admin_modules" && $templatelite.get.status eq "uninstalled"}class="cur"{/if}><span><a href="{$my_pligg_base}/admin/admin_modules.php?status=uninstalled">{#PLIGG_Visual_Modules_Uninstalled#}</a></span></li>
		</ul>
	</div></div>
{/if}

{if $pagename eq "admin_widgets"}
	<div class="tab-nav-spacing"><div class="tab-nav">
		<ul>
			<li {if $templatelite.get.status ne "uninstalled"}class="cur"{/if}><span><a href="{$my_pligg_base}/admin/admin_widgets.php">{#PLIGG_Visual_Widgets_Installed#}</a></span></li>
			<li {if $templatelite.get.status eq "uninstalled"}class="cur"{/if}><span><a href="{$my_pligg_base}/admin/admin_widgets.php?status=uninstalled">{#PLIGG_Visual_Widgets_Uninstalled#}</a></span></li>
		</ul>
	</div></div>
{/if}

<div style="clear:both;"></div>
<div class="demo" id="main_content">
	<div class="bluerndcontent">
		{checkActionsTpl location="tpl_pligg_admin_legend_before"}
		{include file=$tpl_center.".tpl"}
		{* Start Pagination *}
			{if ($pagename eq "admin_users" && $templatelite.get.mode!='view') || $pagename eq "admin_comments" || $pagename eq "admin_links" || $pagename eq "admin_user_validate"}	
				<br />
				{php} 
				Global $db, $main_smarty, $rows, $offset, $URLMethod;
				$oldURLMethod=$URLMethod;
				$URLMethod=1;
				$pagesize=get_misc_data('pagesize');
				do_pages($rows, $pagesize ? $pagesize : 30, $the_page); 
				$URLMethod=$oldURLMethod;
				{/php}
			{/if} 
		{* End Pagination *}
		{checkActionsTpl location="tpl_pligg_admin_legend_after"}

	</div>
</div>

<div id="footer-wrap">
	<div class="footer">
		<div class="rss-feeds">
		<h1>Pligg RSS Feeds</h1>
		<ul>
			<li><a href="http://www.pligg.com/blog/feed/" target="_blank">Blog</a></li>
			<li><a href="http://twitter.com/statuses/user_timeline/6024362.rss" target="_blank">Twitter</a></li>
			<li><a href="http://forums.pligg.com/external.php" target="_blank">Forum</a></li>
		</ul>
		</div>
	</div>
	<div id="about">
	<h3><a href="http://forums.pligg.com/" target="_blank">{#PLIGG_Visual_AdminPanel_Help#}!</a></h3>
	<br /><div class="design">{#PLIGG_Visual_AdminPanel_Help_1#} <a href="http://www.pligg.com">Pligg.com</a> {#PLIGG_Visual_AdminPanel_Help_2#} <a href="http://forums.pligg.com">Pligg Forum.</a></div>
	<br>
	</div>
</div>

{checkActionsTpl location="tpl_pligg_admin_body_end"}
</body>
</html>
