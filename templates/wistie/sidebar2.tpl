{checkActionsTpl location="tpl_pligg_sidebar_start"}

	{if $pagename eq "published" || $pagename eq "index" || $pagename eq "upcoming" && $pagename neq "groups"}
	<!-- START SORT -->
		<div class="headline">
			<div class="sectiontitle">{#PLIGG_Visual_Pligg_Queued_Sort#} {#PLIGG_Visual_TopUsers_TH_News#}</div>
		</div>

		<div id="navcontainer">
			<ul id="navlist">
				{if $setmeka eq "" || $setmeka eq "recent"}<li id="active"><a id="current" href="{$index_url_recent}"><span class="active">{#PLIGG_Visual_Recently_Pop#}</span></a>{else}<li><a href="{$index_url_recent}">{#PLIGG_Visual_Recently_Pop#}</a>{/if}</li>
				{if $setmeka eq "today"}<li id="active" href="{$index_url_today}"><a href="{$index_url_today}" id="current"><span class="active">{#PLIGG_Visual_Top_Today#}</span></a>{else}<li><a href="{$index_url_today}">{#PLIGG_Visual_Top_Today#}</a>{/if}</li>
				{if $setmeka eq "yesterday"}<li id="active"><a id="current" href="{$index_url_yesterday}"><span class="active">{#PLIGG_Visual_Yesterday#}</span></a>{else}<li><a href="{$index_url_yesterday}">{#PLIGG_Visual_Yesterday#}</a>{/if}</li>
				{if $setmeka eq "week"}<li id="active"><a id="current" href="{$index_url_week}"><span class="active">{#PLIGG_Visual_This_Week#}</span></a>{else}<li><a href="{$index_url_week}">{#PLIGG_Visual_This_Week#}</a>{/if}</li>
				{if $setmeka eq "month"}<li id="active"><a id="current" href="{$index_url_month}"><span class="active">{#PLIGG_Visual_This_Month#}</span></a>{else}<li><a href="{$index_url_month}">{#PLIGG_Visual_This_Month#}</a>{/if}</li>
				{if $setmeka eq "year"}<li id="active"><a id="current" href="{$index_url_year}"><span class="active">{#PLIGG_Visual_This_Year#}</span></a>{else}<li><a href="{$index_url_year}">{#PLIGG_Visual_This_Year#}</a>{/if}</li>
				{if $setmeka eq "alltime"}<li id="active"><a id="current" href="{$index_url_alltime}"><span class="active">{#PLIGG_Visual_This_All#}</span></a>{else}<li><a href="{$index_url_alltime}">{#PLIGG_Visual_This_All#}</a>{/if}</li>
			</ul>
		</div>
	<!-- END SORT -->
	{/if}

	{if $pagename eq "groups"}
	<!-- START GROUP SORT -->
		<div class="headline">
			<div class="sectiontitle">{#PLIGG_Visual_Group_Sort#}</div>
		</div>
		<div id="navcontainer">
			<ul id="navlist">
				{checkActionsTpl location="tpl_pligg_group_sort_start"}
				{if $sortby eq "members"}
					<li id="active"><span class="active"><a id="current">
						{#PLIGG_Visual_Group_Sort_Members#}
					</a></span></li>
				{else} 
					<li><a href="{$group_url_members}">
						{#PLIGG_Visual_Group_Sort_Members#}
					</a></li>
				{/if}
				{if $sortby eq "name"}
					<li id="active"><span class="active"><a id="current">
						{#PLIGG_Visual_Group_Sort_Name#}
					</a></span></li> 
				{else}
					<li><a href="{$group_url_name}">
						{#PLIGG_Visual_Group_Sort_Name#}
					</a></li>
				{/if}
				{if $sortby eq "newest"}
					<li id="active"><span class="active"><a id="current">
						{#PLIGG_Visual_Group_Sort_Newest#}
					</a></span></li>
				{else}
					<li><a href="{$group_url_newest}">
						{#PLIGG_Visual_Group_Sort_Newest#}
					</a></li>
				{/if}
				{if $sortby eq "oldest"}
					<li id="active"><span class="active"><a id="current">
						{#PLIGG_Visual_Group_Sort_Oldest#}
					</a></span></li>
				{else}
					<li><a href="{$group_url_oldest}">
						{#PLIGG_Visual_Group_Sort_Oldest#}
					</a></li>
				{/if}
				{checkActionsTpl location="tpl_pligg_group_sort_end"}
			</ul>
		</div>
	<!-- END GROUP SORT -->
	{/if}

	{if $pagename eq "group_story"}
	<!-- START GROUP SORT -->
		<div class="headline">
			<div class="sectiontitle">{#PLIGG_Visual_Group_Sort#}</div>
		</div>
		<div id="navcontainer">
			<ul id="navlist">
				<div id="story_tabs">
					<span {if $groupview eq "published"}class="selected"{/if}><a href="{$groupview_published}">{#PLIGG_Visual_Group_Published#}</a></span>
					<span {if $groupview eq "upcoming"}class="selected"{/if}><a href="{$groupview_upcoming}">{#PLIGG_Visual_Group_Upcoming#}</a></span>
					<span {if $groupview eq "shared"}class="selected"{/if}><a href="{$groupview_sharing}">{#PLIGG_Visual_Group_Shared#}</a></span>
					<span {if $groupview eq "members"}class="selected"{/if}><a href="{$groupview_members}">{#PLIGG_Visual_Group_Member#}</a></span>
				</div>
			</ul>
		</div>
	<!-- END GROUP SORT -->
	{/if}
	
	{if $pagename eq "cloud"}
		<div class="headline">
			<div class="sectiontitle">{#PLIGG_Visual_Pligg_Queued_Sort#} {#PLIGG_Visual_Tags_Link_Summary#}</div>
		</div>
		<div id="navcontainer">
			<ul id="navlist">
				{section name=i start=0 loop=$count_range_values step=1}
					{if $templatelite.section.i.index eq $current_range}
						<li id="active"><a href="#"><span class="active">{$range_names[i]}</span></a></li>
					{else}	
						<li><a href="{$URL_tagcloud_range, $templatelite.section.i.index}"><span>{$range_names[i]}</span></a></li>
					{/if}
				{/section}
			</ul>   
		</div>
	{/if}

	{if $pagename eq "live" || $pagename eq "live_unpublished" || $pagename eq "live_published" || $pagename eq "live_comments"}
		<div class="headline">
			<div class="sectiontitle">{#PLIGG_Visual_Pligg_Queued_Sort#} {#PLIGG_Visual_Live#}</div>
		</div>
		<div id="navcontainer">
			<ul id="navlist">
				<li {if $pagename eq "live"}id="active"{/if}><a href="{$URL_live}"><span {if $pagename eq "live"}class="active"{/if}>{#PLIGG_Visual_Breadcrumb_All#}</span></a></li>
				<li {if $pagename eq "live_published"}id="active"{/if}><a href="{$URL_published}"><span {if $pagename eq "live_published"}class="active"{/if}>{#PLIGG_Visual_Breadcrumb_Published_Tab#}</span></a></li>
				<li {if $pagename eq "live_unpublished"}id="active"{/if}><a href="{$URL_unpublished}"><span {if $pagename eq "live_unpublished"}class="active"{/if}>{#PLIGG_Visual_Breadcrumb_Unpublished_Tab#}</span></a></li>
				<li {if $pagename eq "live_comments"}id="active"{/if}><a href="{$URL_comments}"><span {if $pagename eq "live_comments"}class="active"{/if}>{#PLIGG_Visual_Breadcrumb_Comments#}</span></a></li>
			</ul>
		</div>	
	{/if}
 
{if $user_authenticated ne true} {assign var=sidebar_module value="login"}{include file=$the_template_sidebar_modules."/wrapper2.tpl"} {/if}

{checkActionsTpl location="tpl_pligg_sidebar_stories_u"}
{checkActionsTpl location="tpl_pligg_sidebar_stories"}
{checkActionsTpl location="tpl_pligg_sidebar_comments"}

{if $Enable_Tags} {assign var=sidebar_module value="tags"}{include file=$the_template_sidebar_modules."/wrapper.tpl"} {/if}

{checkActionsTpl location="tpl_pligg_sidebar_end"}