<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html dir="{#PLIGG_Visual_Language_Direction#}" xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	{checkActionsTpl location="tpl_pligg_admin_head_start"}

	<link rel="stylesheet" type="text/css" href="{$my_base_url}{$my_pligg_base}/templates/admin/css/bootstrap.no-icons.min.css">
	<link rel="stylesheet" type="text/css" href="{$my_base_url}{$my_pligg_base}/templates/admin/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="{$my_base_url}{$my_pligg_base}/templates/admin/css/jquery.pnotify.css" media="screen" />
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
	<script type="text/javascript" src="{$my_base_url}{$my_pligg_base}/templates/admin/js/bootstrap.min.js"></script>
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
										<li class="nav-header"><i class="fa fa-user" /></i>&nbsp; {#PLIGG_Visual_AdminPanel_Manage_Nav#}</li>
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
										{if $CHECK_SPAM}<li{if $pagename eq "domain_management"} class="active"{/if} id="domain_management"><a href="{$my_base_url}{$my_pligg_base}/admin/domain_management.php">Manage Domains</a></li>{/if}
										{checkActionsTpl location="tpl_pligg_admin_manage_sidebarnav_end"}
                                    </ul>
								</div>
							</div>
						</div>
					</ul>
				</div>
			</div>
			<div class="col-md-9">
				<div class="row">
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