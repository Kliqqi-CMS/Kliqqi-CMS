<!-- breadcrumb.tpl -->
<ul class="breadcrumb">
	<li><a href="{$my_base_url}{$my_pligg_base}">{#PLIGG_Visual_Home#}</a> <span class="divider">/</span></li>
	{if $pagename eq "404"}<li class="active">{#PLIGG_Visual_404_Error#}</li>{/if}
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
		{if $user_view neq 'profile'}<li class="active">{$page_header} <a href="{$user_rss, $view_href}" target="_blank"><img src="{$my_pligg_base}/templates/{$the_template}/img/rss.gif" style="margin:-4px 0 0 3px;border:0;"></a></li>{/if}
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
		<div class="btn-group pull-right breadcrumb-right">
			<ul class="nav nav-pills">
				<li class="dropdown pull-right">
					<a href="#" data-toggle="dropdown" class="dropdown-toggle">Sort <span class="caret"></span></a>
					<ul class="dropdown-menu" id="menu1">
						{if $pagename eq "published" || $pagename eq "index" || $pagename eq "upcoming"}
							{if $setmeka eq "" || $setmeka eq "recent"}
								<li id="active">
									<a id="current" href="{$index_url_recent}"><span class="active">{#PLIGG_Visual_Recently_Pop#}</span></a>
								{else}
									<li><a href="{$index_url_recent}">{#PLIGG_Visual_Recently_Pop#}</a>
								{/if}
							</li>
							
							
							
							{if $user_logged_in}
								{if $setmeka eq "upvoted"}
									<li id="active" href="{$index_url_upvoted}">
									<a href="{$index_url_upvoted}" id="current"><span class="active">Most {#PLIGG_Visual_User_UpVoted#}</span></a>
								{else}
									<li><a href="{$index_url_upvoted}">Most {#PLIGG_Visual_User_UpVoted#}</a>
								{/if}
								</li>
								{if $setmeka eq "dwnvoted"}
									<li id="active" href="{$index_url_dwnvoted}">
									<a href="{$index_url_dwnvoted}" id="current"><span class="active">Most {#PLIGG_Visual_User_DownVoted#}</span></a>
								{else}
									<li><a href="{$index_url_dwnvoted}">Most {#PLIGG_Visual_User_DownVoted#}</a>
								{/if}
								</li>
								{if $setmeka eq "commented"}
									<li id="active" href="{$index_url_commented}">
									<a href="{$index_url_commented}" id="current"><span class="active">Most {#PLIGG_Visual_User_NewsCommented#}</span></a>
								{else}
									<li><a href="{$index_url_commented}">Most {#PLIGG_Visual_User_NewsCommented#}</a>
								{/if}
								</li>
							{/if}
							
							
							
							
							
							{if $setmeka eq "today"}
								<li id="active" href="{$index_url_today}">
									<a href="{$index_url_today}" id="current"><span class="active">{#PLIGG_Visual_Top_Today#}</span></a>
							{else}
								<li><a href="{$index_url_today}">{#PLIGG_Visual_Top_Today#}</a>
							{/if}
								</li>
								
							{if $setmeka eq "yesterday"}
								<li id="active">
									<a id="current" href="{$index_url_yesterday}"><span class="active">{#PLIGG_Visual_Yesterday#}</span></a>
							{else}
								<li><a href="{$index_url_yesterday}">{#PLIGG_Visual_Yesterday#}</a>
							{/if}
								</li>
								
							{if $setmeka eq "week"}<li id="active"><a id="current" href="{$index_url_week}"><span class="active">{#PLIGG_Visual_This_Week#}</span></a>{else}<li><a href="{$index_url_week}">{#PLIGG_Visual_This_Week#}</a>{/if}</li>
							
							
							{if $setmeka eq "month"}<li id="active"><a id="current" href="{$index_url_month}"><span class="active">{#PLIGG_Visual_This_Month#}</span></a>{else}<li><a href="{$index_url_month}">{#PLIGG_Visual_This_Month#}</a>{/if}</li>
							
							
							{if $setmeka eq "year"}<li id="active"><a id="current" href="{$index_url_year}"><span class="active">{#PLIGG_Visual_This_Year#}</span></a>{else}<li><a href="{$index_url_year}">{#PLIGG_Visual_This_Year#}</a>{/if}</li>
							
							
							{if $setmeka eq "alltime"}<li id="active"><a id="current" href="{$index_url_alltime}"><span class="active">{#PLIGG_Visual_This_All#}</span></a>{else}<li><a href="{$index_url_alltime}">{#PLIGG_Visual_This_All#}</a>{/if}</li>
							
							
						{elseif $pagename eq "groups"}
						
						
							{if $user_logged_in}
								{if $sortby eq "upvoted"}
									<li id="active" href="{$index_url_upvoted}">
									<a href="{$index_url_upvoted}" id="current"><span class="active">Most {#PLIGG_Visual_User_UpVoted#}</span></a>
								{else}
									<li><a href="{$index_url_upvoted}">Most {#PLIGG_Visual_User_UpVoted#}</a>
								{/if}
								</li>
								{if $sortby eq "dwnvoted"}
									<li id="active" href="{$index_url_dwnvoted}">
									<a href="{$index_url_dwnvoted}" id="current"><span class="active">Most {#PLIGG_Visual_User_DownVoted#}</span></a>
								{else}
									<li><a href="{$index_url_dwnvoted}">Most {#PLIGG_Visual_User_DownVoted#}</a>
								{/if}
								</li>
								{if $sortby eq "commented"}
									<li id="active" href="{$index_url_commented}">
									<a href="{$index_url_commented}" id="current"><span class="active">Most {#PLIGG_Visual_User_NewsCommented#}</span></a>
								{else}
									<li><a href="{$index_url_commented}">Most {#PLIGG_Visual_User_NewsCommented#}</a>
								{/if}
								</li>
							{/if}
						
						
						
						
						
							{if $sortby eq "name"}
								<li id="active"><a id="current" href="{$group_url_members}"><span class="active">{#PLIGG_Visual_Group_Sort_Members#}</span></a>{else}<li><a href="{$group_url_members}">{#PLIGG_Visual_Group_Sort_Members#}</a>{/if}</li>
								
								
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
<!--/breadcrumb.tpl -->