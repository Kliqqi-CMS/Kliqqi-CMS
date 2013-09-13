<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html dir="{#PLIGG_Visual_Language_Direction#}" xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	{checkActionsTpl location="tpl_pligg_admin_head_start"}

	<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.no-icons.min.css" rel="stylesheet">
	<link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="{$my_base_url}{$my_pligg_base}/templates/{$the_template}/css/jquery.pnotify.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="{$my_base_url}{$my_pligg_base}/templates/admin/css/bootstrap-fileupload.min.css" media="screen">
	<link rel="stylesheet" type="text/css" href="{$my_base_url}{$my_pligg_base}/templates/admin/css/style.css" media="screen">
	{checkForCss}

	<meta name="Language" content="en-us">
	<meta name="Robots" content="none">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<title>{#PLIGG_Visual_Name#} Admin Panel</title>
	
	<link rel="icon" href="{$my_base_url}{$my_pligg_base}/favicon.ico" type="image/x-icon"/>	
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js"></script>
	<script type="text/javascript" src="{$my_base_url}{$my_pligg_base}/templates/admin/js/jquery/jquery.easing.1.3.js"></script>
	<script type="text/javascript" src="{$my_base_url}{$my_pligg_base}/templates/admin/js/jquery/jquery.coda-slider-2.0.js"></script> 
	<script type="text/javascript" src="{$my_base_url}{$my_pligg_base}/templates/admin/js/jquery/jquery.pnotify.js"></script>
	<script type="text/javascript" src="{$my_base_url}{$my_pligg_base}/templates/admin/js/jquery/jquery.masonry.min.js"></script>
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="{$my_base_url}{$my_pligg_base}/templates/admin/js/bootstrap-fileupload.min.js"></script>
    <script type="text/javascript" src="{$my_base_url}{$my_pligg_base}/templates/admin/js/jquery/jquery_cookie.js"></script>
    <script type="text/javascript" src="{$my_base_url}{$my_pligg_base}/templates/admin/js/leftmenu.js"></script>
	 
	{if $pagename eq "admin_index"}
		<script type="text/javascript" src="{$my_base_url}{$my_pligg_base}/templates/admin/js/jquery/jquery.ui.widget.js"></script> 
		<script type="text/javascript" src="{$my_base_url}{$my_pligg_base}/templates/admin/js/jquery/jquery.ui.mouse.js"></script> 
		<script type="text/javascript" src="{$my_base_url}{$my_pligg_base}/templates/admin/js/jquery/jquery.ui.sortable.js"></script>
		<link type="text/css" href="{$my_base_url}{$my_pligg_base}/templates/admin/css/jquery.ui.theme.css" rel="stylesheet" /> 
		<link type="text/css" href="{$my_base_url}{$my_pligg_base}/templates/admin/css/admin_home.css" rel="stylesheet" />		
		<link type="text/css" href="{$my_base_url}{$my_pligg_base}/templates/admin/css/coda-slider-2.0.css" rel="stylesheet" media="screen" />
	{/if}
	
    {$Jscript}
	
	<script src="{$my_base_url}{$my_pligg_base}/templates/admin/js/simpleedit.js" type="text/javascript"></script>
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
	{checkActionsTpl location="tpl_pligg_admin_head_end"}
</head>
<body dir="{#PLIGG_Visual_Language_Direction#}">
{if $pagename neq "admin_login"}
	
	{checkActionsTpl location="tpl_pligg_admin_body_start"}
	
	<header role="banner" class="navbar navbar-inverse">
		<div class="container">
			<div class="navbar-header">
				<button data-target=".bs-navbar-collapse" data-toggle="collapse" type="button" class="navbar-toggle">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="http://pligg.com/"><img src="{$my_base_url}{$my_pligg_base}/templates/admin/img/pligg.png" /></a>
			</div>
			<nav role="navigation" class="collapse navbar-collapse bs-navbar-collapse">
				<ul class="nav navbar-nav">
					<li{if $pagename eq "admin_index"} class="active"{/if}><a href="{$my_base_url}{$my_pligg_base}/admin/admin_index.php">{#PLIGG_Visual_AdminPanel#} Panel</a></li>
					<li><a href="{$my_base_url}{$my_pligg_base}/">{#PLIGG_Visual_Home#}</a></li>
					{checkActionsTpl location="tpl_header_admin_links"}
					<li><a href="{$URL_logout}">{#PLIGG_Visual_Logout#}</a></li>
				</ul><!--/.nav -->
			</nav>
		</div>
	</header>
	
	<div class="container">
		<div class="row">
			<div class="col-md-3">
				<div class="well sidebar-nav">
					<ul class="nav nav-list">
						<div id="AdminAccordion" class="accordion">
							<div class="accordion-group">
								<div class="btn btn-default col-md-12 accordion-heading">
									<span class="accordion-heading-title">
										<li class="nav-header"><img src="{$my_base_url}{$my_pligg_base}/templates/admin/img/manage.png" width="16px" height="16px" /> {#PLIGG_Visual_AdminPanel_Manage_Nav#}</li>
									</span>
									{if $moderated_total_count neq ''}
										<span class="badge accordion-heading-alert">
											{$moderated_total_count}
										</span>
									{/if}
								</div>
								<div class="accordion-body " id="CollapseManage">
									<ul class="accordion-inner">
										<li{if $pagename eq "admin_links"} class="active"{/if} id="manage_submissions"><a href="{$my_base_url}{$my_pligg_base}/admin/admin_links.php">Submissions {if $moderated_submissions_count != '0'}<span class="pull-right badge badge-gray">{$moderated_submissions_count}</span>{/if}</a></li>
										<li{if $pagename eq "admin_comments"} class="active"{/if} id="manage_comments"><a href="{$my_base_url}{$my_pligg_base}/admin/admin_comments.php">Comments {if $moderated_comments_count != '0'}<span class="pull-right badge badge-gray">{$moderated_comments_count}</span>{/if}</a></li>
										<li{if $pagename eq "admin_users" || $pagename eq "admin_user_validate"} class="active"{/if} id="manage_users"><a href="{$my_base_url}{$my_pligg_base}/admin/admin_users.php">Users {if $moderated_users_count != '0'}<span class="pull-right badge badge-gray">{$moderated_users_count}</span>{/if}</a></li>
										<li{if $pagename eq "admin_group"} class="active"{/if} id="manage_groups"><a href="{$my_base_url}{$my_pligg_base}/admin/admin_group.php">Groups {if $moderated_groups_count != '0'}<span class="pull-right badge badge-gray">{$moderated_groups_count}</span>{/if}</a></li>
										<li{if $pagename eq "admin_page" || $pagename eq "edit_page" || $pagename eq "submit_page"} class="active"{/if} id="manage_pages"><a href="{$my_base_url}{$my_pligg_base}/admin/admin_page.php">Pages</a></li> 
										<li{if $pagename eq "admin_categories" || $pagename eq "admin_categories_tasks"} class="active"{/if} id="manage_categories"><a href="{$my_base_url}{$my_pligg_base}/admin/admin_categories.php">Categories</a></li> 
										{if $CHECK_SPAM}<li{if $pagename eq "domain_management"} class="active"{/if} id="domain_management"><a href="{$my_base_url}{$my_pligg_base}/admin/domain_management.php">Manage Domains</a></li>{/if}
										<li{if $pagename eq "admin_log"} class="active"{/if} id="manage_errors"><a href="{$my_base_url}{$my_pligg_base}/admin/admin_log.php">Error Log {if $error_count != '0'}<span class="pull-right badge badge-gray">{$error_count}</span>{/if}</a></li>
										<li{if $pagename eq "admin_backup"} class="active"{/if} id="settings_backup"><a href="{$my_base_url}{$my_pligg_base}/admin/admin_backup.php">{#PLIGG_Visual_AdminPanel_Backup#}{if $backup_count != '0'}<span class="pull-right badge badge-gray">{$backup_count}</span>{/if}</a></li>
										{checkActionsTpl location="tpl_pligg_admin_manage_sidebarnav_end"}
                                    </ul>
								</div>
							</div>
							<div class="accordion-group">
								<div class="btn btn-default col-md-12 accordion-heading">
									<span class="accordion-heading-title">
										<li class="nav-header"><img src="{$my_base_url}{$my_pligg_base}/templates/admin/img/configure.png" width="16px" height="16px" /> Settings</li>
									</span>
								</div>
								<div class="accordion-body " id="CollapseSettings">
									<ul class="accordion-inner">
										<li{if $pagename eq "admin_config" && $templatelite.get.page eq "Anonymous"} class="active"{/if} id="settings_anonymous"><a href="{$my_base_url}{$my_pligg_base}/admin/admin_config.php?page=Anonymous">Anonymous</a></li>
										<li{if $pagename eq "admin_config" && $templatelite.get.page eq "AntiSpam"} class="active"{/if} id="settings_antispam"><a href="{$my_base_url}{$my_pligg_base}/admin/admin_config.php?page=AntiSpam">AntiSpam</a></li>
										<li{if $pagename eq "admin_config" && $templatelite.get.page eq "Avatars"} class="active"{/if} id="settings_avatars"><a href="{$my_base_url}{$my_pligg_base}/admin/admin_config.php?page=Avatars">Avatars</a></li>
										<li{if $pagename eq "admin_config" && $templatelite.get.page eq "Comments"} class="active"{/if} id="settings_comments"><a href="{$my_base_url}{$my_pligg_base}/admin/admin_config.php?page=Comments">Comments</a></li>
										<li{if $pagename eq "admin_config" && $templatelite.get.page eq "Groups"} class="active"{/if} id="settings_groups"><a href="{$my_base_url}{$my_pligg_base}/admin/admin_config.php?page=Groups">Groups</a></li>
										<li{if $pagename eq "admin_config" && $templatelite.get.page eq "Live"} class="active"{/if} id="settings_live"><a href="{$my_base_url}{$my_pligg_base}/admin/admin_config.php?page=Live">Live</a></li>
										<li{if $pagename eq "admin_config" && $templatelite.get.page eq "Location Installed"} class="active"{/if} id="settings_location"><a href="{$my_base_url}{$my_pligg_base}/admin/admin_config.php?page=Location Installed">Location Installed</a></li>
										<li{if $pagename eq "admin_config" && $templatelite.get.page eq "Misc"} class="active"{/if} id="settings_misc"><a href="{$my_base_url}{$my_pligg_base}/admin/admin_config.php?page=Misc">Miscellaneous</a></li>
										<li{if $pagename eq "admin_config" && $templatelite.get.page eq "OutGoing"} class="active"{/if} id="settings_outgoing"><a href="{$my_base_url}{$my_pligg_base}/admin/admin_config.php?page=OutGoing">OutGoing</a></li>
										<li{if $pagename eq "admin_config" && $templatelite.get.page eq "SEO"} class="active"{/if} id="settings_seo"><a href="{$my_base_url}{$my_pligg_base}/admin/admin_config.php?page=SEO">SEO</a></li>
										<li{if $pagename eq "admin_config" && $templatelite.get.page eq "Story"} class="active"{/if} id="settings_story"><a href="{$my_base_url}{$my_pligg_base}/admin/admin_config.php?page=Story">Story</a></li>
										<li{if $pagename eq "admin_config" && $templatelite.get.page eq "Submit"} class="active"{/if} id="settings_submit"><a href="{$my_base_url}{$my_pligg_base}/admin/admin_config.php?page=Submit">Submit</a></li>
										<li{if $pagename eq "admin_config" && $templatelite.get.page eq "Tags"} class="active"{/if} id="settings_tags"><a href="{$my_base_url}{$my_pligg_base}/admin/admin_config.php?page=Tags">Tags</a></li>
										<li{if $pagename eq "admin_config" && $templatelite.get.page eq "Voting"} class="active"{/if} id="settings_voting"><a href="{$my_base_url}{$my_pligg_base}/admin/admin_config.php?page=Voting">Voting</a></li>
										{checkActionsTpl location="tpl_pligg_admin_navtabs_end"}
									</ul>
								</div>
							</div>
							<div class="accordion-group">
								<div class="btn btn-default col-md-12 accordion-heading">
									<span class="accordion-heading-title">
										<li class="nav-header"><img src="{$my_base_url}{$my_pligg_base}/templates/admin/img/template.png" width="16px" height="16px" /> Template</li>
									</span>
								</div>
								<div class="accordion-body " id="CollapseTemplate">
									<ul class="accordion-inner">
										<li{if $pagename eq "admin_config" && $templatelite.get.page eq "Template"} class="active"{/if} id="template_settings"><a href="{$my_base_url}{$my_pligg_base}/admin/admin_config.php?page=Template">Template Settings</a></li>
										<li{if $pagename eq "admin_editor"} class="active"{/if} id="template_editor"><a href="{$my_base_url}{$my_pligg_base}/admin/admin_editor.php">{#PLIGG_Visual_AdminPanel_Template_Nav#} Editor</a></li>
									    {checkActionsTpl location="tpl_pligg_admin_template_sidebarnav_end"}
                                    </ul>
								</div>
							</div>
							<div class="accordion-group">
								<div class="btn btn-default col-md-12 accordion-heading">
									<span class="accordion-heading-title">
										<li class="nav-header"><img src="{$my_base_url}{$my_pligg_base}/templates/admin/img/module.png" width="16px" height="16px" /> Modules</li>
									</span>
									{if $total_update_required_mod neq "0"}
										<span class="badge accordion-heading-alert">
											<a href="{$my_base_url}{$my_pligg_base}/admin/admin_modules.php">{$total_update_required_mod}</a>
										</span>
									{/if}
								</div>
								<div class="accordion-body " id="CollapseModules">
									<ul class="accordion-inner">
										<li{if $pagename eq "admin_modules"}{php} if ($_GET["status"] == ""){ echo ' class="active"'; } {/php}{/if} id="modules_installed"><a href="{$my_base_url}{$my_pligg_base}/admin/admin_modules.php" {if $pagename eq "admin_modules"}class="active"{/if} >Installed {#PLIGG_Visual_AdminPanel_Modules_Nav#} {if $in_no_module_update_require neq "0"}<span class="pull-right badge badge-gray">{$in_no_module_update_require}</span>{/if}</a></li> 
										<li{if $pagename eq "admin_modules"}{php} if ($_GET["status"] == "uninstalled"){ echo ' class="active"'; } {/php}{/if} id="modules_uninstalled"><a href="{$my_base_url}{$my_pligg_base}/admin/admin_modules.php?status=uninstalled" {if $pagename eq "admin_modules"}{php} if ($_GET["status"] == "uninstalled"){ echo ' class="active"'; } {/php}{/if} >Uninstalled {#PLIGG_Visual_AdminPanel_Modules_Nav#} {if $un_no_module_update_require neq "0"}<span class="pull-right badge badge-gray">{$un_no_module_update_require}</span>{/if}</a></li> 
										{checkActionsTpl location="tpl_header_admin_main_links"}
									</ul>
								</div>
							</div>
							<div class="accordion-group">
								<div class="btn btn-default col-md-12 accordion-heading">
									<span class="accordion-heading-title">
										<li class="nav-header"><img src="{$my_base_url}{$my_pligg_base}/templates/admin/img/widgets.png" width="16px" height="16px" /> Widgets</li>
									</span>
									<span class="badge accordion-heading-alert">
										<a href="{$my_base_url}{$my_pligg_base}/admin/admin_widgets.php">1</a>
									</span>
								</div>
								<div class="accordion-body " id="CollapseWidgets">
									<ul class="accordion-inner">
										<li {if $pagename eq "admin_widgets"}{php} if ($_GET["status"] == ""){ echo 'class="active"'; } {/php}{/if} id="widgets_installed"><a href="{$my_base_url}{$my_pligg_base}/admin/admin_widgets.php">Installed {#PLIGG_Visual_AdminPanel_Widgets_Nav#} <span class="pull-right badge badge-gray">1</span></a></li> 
										<li {if $pagename eq "admin_widgets"}{php} if ($_GET["status"] == "uninstalled"){ echo 'class="active"'; } {/php}{/if} id="widgets_uninstalled"><a href="{$my_base_url}{$my_pligg_base}/admin/admin_widgets.php?status=uninstalled">Uninstalled {#PLIGG_Visual_AdminPanel_Widgets_Nav#}</a></li>
								        {checkActionsTpl location="tpl_pligg_admin_widgets_sidebarnav_end"}
                                    </ul>
								</div>
							</div>
						</div>
					</ul>
				</div>
			</div>
			<div class="col-md-9">
				<div class="row">
					{*
					<ul class="breadcrumb">
						<li><a href="{$my_base_url}{$my_pligg_base}/">{#PLIGG_Visual_Home#}</a> <span class="divider">/</span></li> <li><a href="{$my_base_url}{$my_pligg_base}/admin/admin_index.php">{#PLIGG_Visual_AdminPanel#}</a>  <span class="divider">/</span></li>
						{if $pagename eq "admin_backup"}<li class="active">{#PLIGG_Visual_AdminPanel_Backup#}</li>{/if}
						{if $module eq "captcha"}<li class="active">{#PLIGG_Visual_AdminPanel_Captcha#}</li>{/if}
						{if $pagename eq "admin_categories" || $pagename eq "admin_categories_tasks"}<li class="active">{#PLIGG_Visual_AdminPanel_Categories#}</li>{/if}
						{if $pagename eq "admin_comments"}<li class="active">{#PLIGG_Visual_AdminPanel_Comments#}</li>{/if}
						{if $pagename eq "admin_config"}<li class="active">{#PLIGG_Visual_AdminPanel_Configure#}</li>{/if}
						{if $pagename eq "admin_index"}<li class="active">{#PLIGG_Visual_AdminPanel_Home#}</li>{/if}
						{if $modulename eq "admin_language"}<li class="active">{#PLIGG_Visual_AdminPanel_Language#}</li>{/if}
						{if $pagename eq "admin_modules"}<li class="active">{#PLIGG_Visual_AdminPanel_Modules_Nav#}</li>{/if}
						{if $pagename eq "admin_widgets"}<li class="active">{#PLIGG_Visual_AdminPanel_Widgets_Nav#}</li>{/if}
						{if $pagename eq "admin_page"}<li class="active">{#PLIGG_Visual_AdminPanel_Pages#}</li>{/if}
						{if $pagename eq "admin_links"}<li class="active">{#PLIGG_Visual_AdminPanel_News#}</li>{/if}
						{if $pagename eq "admin_editor"}<li class="active">{#PLIGG_Visual_AdminPanel_Template_Nav#}</li>{/if}
						{if $pagename eq "admin_users"}<li class="active">{#PLIGG_Visual_AdminPanel_Users#}</li>{/if}
						{if $pagename eq "admin_group"}<li class="active">{#PLIGG_Visual_AdminPanel_Groups#}</li>{/if}
						{checkActionsTpl location="tpl_pligg_admin_breadcrumbs"}
					</ul>
					*}
					<div id="main_content">
						{checkActionsTpl location="tpl_pligg_admin_legend_before"}
						{include file=$tpl_center.".tpl"}
						{* Start Pagination *}
						{if ($pagename eq "admin_users" && $templatelite.get.mode=='') || $pagename eq "admin_comments" || $pagename eq "admin_links" || $pagename eq "admin_user_validate"}	
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
					{checkActionsTpl location="tpl_pligg_admin_body_end"}
				</div><!-- /row -->
			</div><!-- /col-md-9 -->
		</div><!-- /row -->
		<hr />
		<footer>
			<p>Powered by <a href="http://pligg.com/">Pligg CMS</a></p>
			{checkActionsTpl location="tpl_pligg_admin_footer_end"}
		</footer>
	</div><!-- /container -->
	{* JavaScript to prevent the carousel function from automatically changing content *}
	{literal}
		<script type='text/javascript'>//<![CDATA[ 
			$(window).load(function(){
				$(function() {
					$('.carousel').each(function(){
						$(this).carousel({
							interval: false
						});
					});
				});
			});//]]>  
		</script>
		<!-- JavaScript to allow multiple sidebar accordions to be open -->
		<script type='text/javascript'>//<![CDATA[ 
			$(window).load(function(){
				$('.collapse').collapse({
					toggle: false
				});
				//$(".collapse").collapse()
			});//]]>  
		</script>
		<script type="text/javascript">
			$(document).ready(function() {
			// https://gist.github.com/1688900
			// Support for AJAX loaded modal window.
			// Focuses on first input textbox after it loads the window.
				$('[data-toggle="modal"]').click(function(e) {
					e.preventDefault();
					var href = $(this).attr('href');
					if (href.indexOf('#') == 0) {
						$(href).modal('open');
					} else {
						$.get(href, function(data) {
							$('<div class="modal" >' + data + '</div>').modal();
						}).success(function() { $('input:text:visible:first').focus(); });
					}
				});
			});
		</script>
	{/literal}
{else}{include file=$tpl_center.".tpl"}{/if}
</body>
</html>