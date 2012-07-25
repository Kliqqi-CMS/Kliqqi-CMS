{if $maintenance_mode eq "true" && $user_level neq 'admin'}{include file=$the_template"/maintenance.tpl"}{else}<!DOCTYPE html>
<html dir="{#PLIGG_Visual_Language_Direction#}" xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	{checkActionsTpl location="tpl_pligg_head_start"}
	{include file=$the_template"/meta.tpl"}
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="stylesheet" type="text/css" href="{$my_pligg_base}/templates/{$the_template}/css/dropdown.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="{$my_pligg_base}/templates/{$the_template}/css/dropdown-default.css" media="screen" />

	<link rel="stylesheet" type="text/css" href="{$my_pligg_base}/templates/{$the_template}/css/bootstrap.css" media="screen" />
	
	<link rel="stylesheet" type="text/css" href="{$my_pligg_base}/templates/{$the_template}/css/jquery.pnotify.css" media="screen" />
	{if $pagename eq "submit"}<link rel="stylesheet" type="text/css" href="{$my_pligg_base}/templates/{$the_template}/css/bootstrap-wysihtml5.css"></link>{/if}
	
	<link rel="stylesheet" type="text/css" href="{$my_pligg_base}/templates/{$the_template}/css/style.css" media="screen" />

	{if $Voting_Method eq 2}
	<link rel="stylesheet" type="text/css" href="{$my_pligg_base}/templates/{$the_template}/css/star_rating/star.css" media="screen" />
	{/if}

	{checkForCss}
	{checkForJs}	

	{if preg_match('/index.php$/',$templatelite.server.SCRIPT_NAME)}
		{if $get.category}
			{if $get.page>1}
				<title>{$navbar_where.text2} | {#PLIGG_Page_Title#} {$get.page} | {#PLIGG_Visual_Breadcrumb_Published_Tab#} | {#PLIGG_Visual_Name#}</title>
			{else}
				<title>{$navbar_where.text2} | {#PLIGG_Visual_Breadcrumb_Published_Tab#} | {#PLIGG_Visual_Name#}</title>
			{/if}
		{elseif $get.page>1}
			<title>{#PLIGG_Visual_Breadcrumb_Published_Tab#} | {#PLIGG_Page_Title#} {$get.page} | {#PLIGG_Visual_Name#}</title>
		{else}
			<title>{#PLIGG_Visual_Name#} - {#PLIGG_Visual_RSS_Description#}</title>
		{/if}
	{elseif preg_match('/upcoming.php$/',$templatelite.server.SCRIPT_NAME)}	
		{if $get.category}
			{if $get.page>1}
				<title>{$navbar_where.text2} | {#PLIGG_Page_Title#} {$get.page} | {#PLIGG_Visual_Breadcrumb_Unpublished_Tab#} | {#PLIGG_Visual_Name#}</title>
			{else}
				<title>{$navbar_where.text2} | {#PLIGG_Visual_Breadcrumb_Unpublished_Tab#} | {#PLIGG_Visual_Name#}</title>
			{/if}
		{elseif $get.page>1}
			<title>{#PLIGG_Visual_Breadcrumb_Unpublished_Tab#} | {#PLIGG_Page_Title#} {$get.page} | {#PLIGG_Visual_Name#}</title>
		{else}
			<title>{#PLIGG_Visual_Breadcrumb_Unpublished_Tab#} | {#PLIGG_Visual_Name#}</title>
		{/if}
	{elseif preg_match('/submit.php$/',$templatelite.server.SCRIPT_NAME)}	
		<title>{#PLIGG_Visual_Submit#} | {#PLIGG_Visual_Name#}</title>
	{elseif preg_match('/editlink.php$/',$templatelite.server.SCRIPT_NAME)}	
		<title>{#PLIGG_Visual_EditStory_Header#}: {$submit_title} | {#PLIGG_Visual_Name#}</title>
	{elseif preg_match('/advancedsearch.php$/',$templatelite.server.SCRIPT_NAME)}	
		<title>{#PLIGG_Visual_Search_Advanced#} | {#PLIGG_Visual_Name#}</title>
	{elseif preg_match('/rssfeeds.php$/',$templatelite.server.SCRIPT_NAME)}
		<title>{#PLIGG_Visual_RSS_Feeds#} | {#PLIGG_Visual_Name#}</title>
	{elseif preg_match('/search.php$/',$templatelite.server.SCRIPT_NAME)}	
		<title>{#PLIGG_Visual_Search_SearchResults#} &quot;{if $get.search}{$get.search}{else}{$get.date}{/if}&quot; | {#PLIGG_Visual_Name#}</title>
	{elseif preg_match('/groups.php$/',$templatelite.server.SCRIPT_NAME)}	
		{if $get.page>1}
			<title>{#PLIGG_Visual_Groups#} | {#PLIGG_Page_Title#} {$get.page} | {#PLIGG_Visual_Name#}</title>
		{else}
			<title>{#PLIGG_Visual_Groups#} | {#PLIGG_Visual_Name#}</title>
		{/if}
	{elseif preg_match('/editgroup.php$/',$templatelite.server.SCRIPT_NAME)}	
		<title>{$group_name} | {#PLIGG_Visual_Name#}</title>
	{elseif preg_match('/group_story.php$/',$templatelite.server.SCRIPT_NAME)}	
		{if $groupview!='published'}
			{if $groupview eq "upcoming"}
				{assign var='tview' value=#PLIGG_Visual_Group_Upcoming#}
			{elseif $groupview eq "shared"}
				{assign var='tview' value=#PLIGG_Visual_Group_Shared#}
			{elseif $groupview eq "members"}
				{assign var='tview' value=#PLIGG_Visual_Group_Member#}
			{/if}

			{if $get.page>1}
				<title>{$group_name} | {if $get.category}{$navbar_where.text2} | {/if}{$tview} | {#PLIGG_Page_Title#} {$get.page} | {#PLIGG_Visual_Name#}</title>
			{else}
				<title>{$group_name} | {if $get.category}{$navbar_where.text2} | {/if}{$tview} | {#PLIGG_Visual_Name#}</title>
			{/if}
		{elseif $get.page>1}
			<title>{$group_name} | {#PLIGG_Page_Title#} {$get.page} | {#PLIGG_Visual_Name#}</title>
		{else}
			<title>{$group_name} - {$group_description} | {#PLIGG_Visual_Name#}</title>
		{/if}
	{elseif $pagename eq "register_complete"}
		<title>{#PLIGG_Validate_user_email_Title#} | {#PLIGG_Visual_Name#}</title>
	{elseif $pagename eq "404"}
		<title>{#PLIGG_Visual_404_Error#} | {#PLIGG_Visual_Name#}</title>
	{else}	
		<title>{$posttitle} | {$pretitle} {#PLIGG_Visual_Name#}</title>
	{/if}
	
	<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="{$my_base_url}{$my_pligg_base}/rss.php"/>
	<link rel="icon" href="{$my_pligg_base}/favicon.ico" type="image/x-icon"/>
	{if $pagename eq 'published'}<link rel="canonical" href="{$my_base_url}{$my_pligg_base}/{$navbar_where.text2}/" />{/if}
	{if $pagename eq 'index'}<link rel="canonical" href="{$my_base_url}{$my_pligg_base}/" />{/if}
	{if $pagename eq 'story'}<link rel="canonical" href="{$my_base_url}{$my_pligg_base}{$navbar_where.link2}" />{/if}
	{checkActionsTpl location="tpl_pligg_head_end"}
</head>
<body dir="{#PLIGG_Visual_Language_Direction#}" {$body_args}>
	{if $maintenance_mode eq "true" && $user_level eq 'admin'}
		<div class="alert alert-error" style="margin-bottom:0;"><button class="close" data-dismiss="alert">×</button>{#PLIGG_Maintenance_Admin_Warning#}</div>
	{/if}
	{checkActionsTpl location="tpl_pligg_body_start"}
	{include file=$tpl_header.".tpl"}
	<div class="container">
		<section id="maincontent">
			<div class="row">
				{checkActionsTpl location="tpl_pligg_banner_top"}
				<!-- START LEFT COLUMN -->
			  {if $pagename eq "submit"}
				<div class="span12">
			  {else}
				<div class="span9">
			  {/if}
					<ul class="breadcrumb">
						<li><a href="{$my_base_url}{$my_pligg_base}">{#PLIGG_Visual_Home#}</a> <span class="divider">/</span></li>
						{if $pagename eq "submit"}<li class="active">{#PLIGG_Visual_Submit#}</li>{/if}
						{if $pagename eq "submit_groups"}<li><a href="{$URL_groups}">{#PLIGG_Visual_Groups#}</a> <span class="divider">/</span></li><li class="active">{#PLIGG_Visual_Submit_A_New_Group#}</li>{/if}
						{if $pagename eq "groups"}<li class="active">{#PLIGG_Visual_Groups#}</li>{/if}
						{if $pagename eq "editgroup"}<li><a href="{$URL_groups}">{#PLIGG_Visual_Groups#}</a> <span class="divider">/</span></li><li><a href="{$group_story_url}">{$group_name}</a> <span class="divider">/</span></li><li class="active">{#PLIGG_Visual_Group_Edit#}</li>{/if}
						{if $pagename eq "group_story" }<li><a href="{$URL_groups}">{#PLIGG_Visual_Groups#}</a> <span class="divider">/</span></li><li class="active">{$group_name}</li>{/if}
						{if $pagename eq "login"}<li class="active">{#PLIGG_Visual_Login#}</li>{/if}
						{if $pagename eq "recover"}<li class="active">{#PLIGG_Visual_Breadcrumb_Recover_Password#}</li>{/if}
						{if $pagename eq "register"}<li class="active">{#PLIGG_Visual_Register#}</li>{/if}
						{if $pagename eq "editlink"}<li><a href="{$my_base_url}{$my_pligg_base}/story.php?id={$submit_id}">{$submit_title}</a> <span class="divider">/</span></li><li class="active">{#PLIGG_Visual_LS_Admin_Edit#}</li>{/if}
						{if $pagename eq "rssfeeds"}<li class="active">{#PLIGG_Visual_RSS_Feeds#}</li>{/if}
						{if $pagename eq "topusers"}<li class="active">{#PLIGG_Visual_TopUsers_Statistics#}</li>{/if}
						{if $pagename eq "cloud"}<li class="active">{#PLIGG_Visual_Tags_Tags#}</li>{/if}
						{if $pagename eq "live"}<li class="active">{#PLIGG_Visual_Live#}</li>{/if}
						{if $pagename eq "live_unpublished" || $pagename eq "live_published" || $pagename eq "live_comments"}<li><a href="{$URL_live}">{#PLIGG_Visual_Breadcrumb_Live#}</a> <span class="divider">/</span></li>{/if}
							{if $pagename eq "live_unpublished"}<li class="active">{#PLIGG_Visual_Breadcrumb_Unpublished#}</li>{/if}
							{if $pagename eq "live_published"}<li class="active">{#PLIGG_Visual_Breadcrumb_Published#}</li>{/if}
							{if $pagename eq "live_comments"}<li class="active">{#PLIGG_Visual_Breadcrumb_Comments#}</li>{/if}
						{if $pagename eq "advancedsearch"}<li class="active">{#PLIGG_Visual_Search_Advanced#}</li>{/if}
						{if $pagename eq "profile"}
							<li><a href="{$URL_userNoVar}">{$user_login}</a> <span class="divider">/</span></li> 
							<li class="active">{#PLIGG_Visual_Profile_ModifyProfile#}</li>
						{/if}
						{if $pagename eq "user"}
							<li>{if $user_view neq 'profile'}<a href="{$user_url_personal_data}">{/if}{$username}{if $user_view neq 'profile'}</a> <span class="divider">/</span></li> {/if}
							{if $user_view neq 'profile'}<li class="active">{$page_header} <a href="{$user_rss, $view_href}" target="_blank"><img src="{$my_pligg_base}/templates/{$the_template}/images/rss.gif" style="margin-left:6px;border:0;"></a></li>{/if}
						{/if}
						{if $pagename eq "published" && $get.category eq '' || $pagename eq "index"}<li class="active">{#PLIGG_Visual_Published_News#}{/if}
						{if $pagename eq "upcoming" && $get.category eq ''}<li class="active">{#PLIGG_Visual_Pligg_Queued#}{/if}
						{if $get.category}
							{if $pagename eq "published" || $pagename eq "index"}<li><a href="{$my_base_url}{$my_pligg_base}">{#PLIGG_Visual_Published_News#}</a></li>{/if}
							{if $pagename eq "upcoming"}<li><a href="{$URL_upcoming}">{#PLIGG_Visual_Pligg_Queued#}</a></li>{/if}
						{/if}
						{if $pagename eq "noresults"}<li class="active">{$posttitle}
						{elseif isset($get.search)}<li class="active">{#PLIGG_Visual_Search_SearchResults#} &quot;{if $get.search}{$get.search}{else}{$get.date}{/if}&quot;{/if}
						{if isset($get.q)}<li class="active">{#PLIGG_Visual_Search_SearchResults#} &quot;{$get.q}&quot;{/if} 
						{if $pagename eq "index" || $pagename eq "published" || $pagename eq "upcoming" || isset($get.search) || isset($get.q)}
							{if isset($navbar_where.link2) && $navbar_where.link2 neq ""} <span class="divider">/</span> <a href="{$navbar_where.link2}">{$navbar_where.text2}</a>{elseif isset($navbar_where.text2) && $navbar_where.text2 neq ""} <span class="divider">/</span> {$navbar_where.text2}{/if}
							{if isset($navbar_where.link3) && $navbar_where.link3 neq ""} <span class="divider">/</span> <a href="{$navbar_where.link3}">{$navbar_where.text3}</a>{elseif isset($navbar_where.text3) && $navbar_where.text3 neq ""} <span class="divider">/</span> {$navbar_where.text3}{/if}
							{if isset($navbar_where.link4) && $navbar_where.link4 neq ""} <span class="divider">/</span> <a href="{$navbar_where.link4}">{$navbar_where.text4}</a>{elseif isset($navbar_where.text4) && $navbar_where.text4 neq ""} <span class="divider">/</span> {$navbar_where.text4}{/if}
							</li>
						{/if}
						{if $posttitle neq "" && $pagename eq "page"}<li>{$posttitle}</li>{/if}
						{checkActionsTpl location="tpl_pligg_breadcrumb_end"}
						{if $pagename eq "published" || $pagename eq "index" || $pagename eq "upcoming" || $pagename eq "cloud" || $pagename eq "groups" || $pagename eq "live" || $pagename eq "live_published" || $pagename eq "live_unpublished" || $pagename eq "live_comments" }
							{* Sort Dropdown *}
							<div class="btn-group pull-right" style="margin-top:-8px;margin-right:-14px;">
								<ul class="nav nav-pills">
									<li class="dropdown pull-right">
										<a href="#" data-toggle="dropdown" class="dropdown-toggle">Sort <span class="caret"></span></a>
										<ul class="dropdown-menu" id="menu1">
											{if $pagename eq "published" || $pagename eq "index" || $pagename eq "upcoming"}
												{if $setmeka eq "" || $setmeka eq "recent"}<li id="active"><a id="current" href="{$index_url_recent}"><span class="active">{#PLIGG_Visual_Recently_Pop#}</span></a>{else}<li><a href="{$index_url_recent}">{#PLIGG_Visual_Recently_Pop#}</a>{/if}</li>
												{if $setmeka eq "today"}<li id="active" href="{$index_url_today}"><a href="{$index_url_today}" id="current"><span class="active">{#PLIGG_Visual_Top_Today#}</span></a>{else}<li><a href="{$index_url_today}">{#PLIGG_Visual_Top_Today#}</a>{/if}</li>
												{if $setmeka eq "yesterday"}<li id="active"><a id="current" href="{$index_url_yesterday}"><span class="active">{#PLIGG_Visual_Yesterday#}</span></a>{else}<li><a href="{$index_url_yesterday}">{#PLIGG_Visual_Yesterday#}</a>{/if}</li>
												{if $setmeka eq "week"}<li id="active"><a id="current" href="{$index_url_week}"><span class="active">{#PLIGG_Visual_This_Week#}</span></a>{else}<li><a href="{$index_url_week}">{#PLIGG_Visual_This_Week#}</a>{/if}</li>
												{if $setmeka eq "month"}<li id="active"><a id="current" href="{$index_url_month}"><span class="active">{#PLIGG_Visual_This_Month#}</span></a>{else}<li><a href="{$index_url_month}">{#PLIGG_Visual_This_Month#}</a>{/if}</li>
												{if $setmeka eq "year"}<li id="active"><a id="current" href="{$index_url_year}"><span class="active">{#PLIGG_Visual_This_Year#}</span></a>{else}<li><a href="{$index_url_year}">{#PLIGG_Visual_This_Year#}</a>{/if}</li>
												{if $setmeka eq "alltime"}<li id="active"><a id="current" href="{$index_url_alltime}"><span class="active">{#PLIGG_Visual_This_All#}</span></a>{else}<li><a href="{$index_url_alltime}">{#PLIGG_Visual_This_All#}</a>{/if}</li>
											{elseif $pagename eq "groups"}
												{if $sortby eq "name"}<li id="active"><a id="current" href="{$group_url_members}"><span class="active">{#PLIGG_Visual_Group_Sort_Members#}</span></a>{else}<li><a href="{$group_url_members}">{#PLIGG_Visual_Group_Sort_Members#}</a>{/if}</li>
												{if $sortby eq "name"}<li id="active"><a id="current" href="{$group_url_name}"><span class="active">{#PLIGG_Visual_Group_Sort_Name#}</span></a>{else}<li><a href="{$group_url_name}">{#PLIGG_Visual_Group_Sort_Name#}</a>{/if}</li>
												{if $sortby eq "newest"}<li id="active"><a id="current" href="{$group_url_newest}"><span class="active">{#PLIGG_Visual_Group_Sort_Newest#}</span></a>{else}<li><a href="{$group_url_newest}">{#PLIGG_Visual_Group_Sort_Newest#}</a>{/if}</li>
												{if $sortby eq "oldest"}<li id="active"><a id="current" href="{$group_url_oldest}"><span class="active">{#PLIGG_Visual_Group_Sort_Oldest#}</span></a>{else}<li><a href="{$groupview_published}">{#PLIGG_Visual_Group_Published#}</a>{/if}</li>
											{elseif $pagename eq "live" || $pagename eq "live_published" || $pagename eq "live_unpublished" || $pagename eq "live_comments"}
												<li {if $pagename eq "live"}id="active"{/if}><a href="{$URL_live}"><span {if $pagename eq "live"}class="active"{/if}>{#PLIGG_Visual_Breadcrumb_All#}</span></a></li>
												<li {if $pagename eq "live_published"}id="active"{/if}><a href="{$URL_published}"><span {if $pagename eq "live_published"}class="active"{/if}>{#PLIGG_Visual_Breadcrumb_Published_Tab#}</span></a></li>
												<li {if $pagename eq "live_unpublished"}id="active"{/if}><a href="{$URL_unpublished}"><span {if $pagename eq "live_unpublished"}class="active"{/if}>{#PLIGG_Visual_Breadcrumb_Unpublished_Tab#}</span></a></li>
												<li {if $pagename eq "live_comments"}id="active"{/if}><a href="{$URL_comments}"><span {if $pagename eq "live_comments"}class="active"{/if}>{#PLIGG_Visual_Breadcrumb_Comments#}</span></a></li>
											{elseif $pagename eq "cloud"}
											{if $pagename eq "cloud"}
												{section name=i start=0 loop=$count_range_values step=1}
													{if $templatelite.section.i.index eq $current_range}
														<li id="active"><a href="#"><span class="active">{$range_names[i]}</span></a></li>
													{else}	
														<li><a href="{$URL_tagcloud_range, $templatelite.section.i.index}"><span>{$range_names[i]}</span></a></li>
													{/if}
												{/section}
											{/if}
											{/if}
										</ul>
									</li>
								</ul>
							</div>
						{/if}
					</ul>
					{literal}
						<script type="text/javascript" language="JavaScript">
						function checkForm() {
						answer = true;
						if (siw && siw.selectingSomething)
							answer = false;
						return answer;
						}//
						</script>
					{/literal}
					{checkActionsTpl location="tpl_pligg_content_start"}
					{checkActionsTpl location="tpl_pligg_above_center"}
					{include file=$tpl_center.".tpl"}
					{checkActionsTpl location="tpl_pligg_below_center"}
					{checkActionsTpl location="tpl_pligg_content_end"}
				</div><!--/span-->
				<!-- END LEFT COLUMN -->
		  
				{checkActionsTpl location="tpl_pligg_columns_start"}	

				{if $pagename neq "submit"}
				<!-- START RIGHT COLUMN -->
					<div class="span3">
						<div class="well sidebar-nav">
							<div id="rightcol">
								{include file=$tpl_right_sidebar.".tpl"}
				{/if}
								{if $pagename neq "submit" && $pagename neq "user" && $pagename neq "profile" && $pagename neq "login" && $pagename neq "register" && $pagename neq "edit"}
									{include file=$tpl_second_sidebar.".tpl"}
								{/if}	
				{if $pagename neq "submit"}
							</div>
						</div><!--/.well -->
					</div><!--/span-->
					<!-- END RIGHT COLUMN -->
				{/if}
			{checkActionsTpl location="tpl_pligg_banner_bottom"}
			</div><!--/.row-->
		</section><!--/#maincontent-->
		
		<hr>
		<footer class="footer">
			{include file=$tpl_footer.".tpl"}
		</footer>
		
	</div><!--/.container-->
	
	{if $Voting_Method == 2}
		{include file=$the_template"/functions/vote_star.tpl"}
	{else}
		{include file=$the_template"/functions/vote_normal.tpl"}
	{/if}
	{if $pagename eq "story"}
		{include file=$the_template"/functions/vote_comments.tpl"}
	{/if}
	
	
     {if $anonymous_vote eq "false" and $user_logged_in eq ""}
		{include file=$the_template"/modal_login_form.tpl"}
     {elseif $votes_per_ip>0 and $user_logged_in eq ""}  
        {include file=$the_template"/modal_login_form.tpl"}  
	 {/if}
	
	
	{checkActionsTpl location="tpl_pligg_body_end"}
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js"></script>
	<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/themes/smoothness/jquery-ui.css" media="all" rel="stylesheet" type="text/css" />
	
	<!--[if lt IE 7]>
	<script type="text/javascript" src="{$my_pligg_base}/templates/{$the_template}/js/jquery/jquery.dropdown.js"></script>
	<![endif]-->
	
	<!--for registration validation-->
	<script type="text/javascript" src="{$my_pligg_base}/templates/{$the_template}/js/registration_verify.js"></script>
	<script type="text/javascript" src="{$my_pligg_base}/templates/{$the_template}/js/bootstrap.js"></script>
	<script type="text/javascript" src="{$my_pligg_base}/templates/{$the_template}/js/bootstrap-fileupload.js"></script>
	<script type="text/javascript" src="{$my_pligg_base}/templates/{$the_template}/js/jquery/jquery.pnotify.js"></script>
	<script type="text/javascript" src="{$my_pligg_base}/templates/{$the_template}/js/jquery/jquery.masonry.min.js"></script>
	{include file=$the_template"/functions/update_story_link.tpl"}
    {if $pagename eq "topusers"}
     <script type="text/javascript" src="{$my_pligg_base}/templates/{$the_template}/js/jquery.tablesorter.js"></script>
    {literal}
    <script type="text/javascript">
        $(function() {		
            $("#tablesorter-demo").tablesorter({sortList:[[0,0]], widgets: ['zebra']});
            $("#options").tablesorter({sortList: [[0,0]], headers: { 3:{sorter: false}, 1:{sorter: false}}});
        });	
    </script>
    {/literal}
    {/if}
    
	{* JavaScript for tooltips on avatar hover *}
	{literal}
		<script> 
		$('.avatar-tooltip').tooltip()
		</script>
	{/literal}
	
	{if $pagename eq "submit"}
		<script src="{$my_pligg_base}/templates/{$the_template}/js/wysihtml5-0.3.0_rc3.js"></script>
		<script src="{$my_pligg_base}/templates/{$the_template}/js/bootstrap-wysihtml5.js"></script>
		{literal}<script>
			$('#bodytext').wysihtml5();
		</script>{/literal}
	{/if}
	{if $pagename eq "profile"}
		{literal}
		<script>
		  $(function(){
			var $container = $('#profile_container');
			$container.imagesLoaded( function(){
			  $container.masonry({
				itemSelector : '.table'
			  });
			});
		  });
		</script>
		{/literal}
	{/if}
</body>
</html>
{/if}{*END Maintenance Mode *}