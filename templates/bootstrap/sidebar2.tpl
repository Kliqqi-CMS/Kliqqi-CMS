{************************************
****** Second Sidebar Template ******
*************************************}

{checkActionsTpl location="tpl_pligg_sidebar_start"}

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
 
{checkActionsTpl location="tpl_pligg_sidebar_stories_u"}
{checkActionsTpl location="tpl_pligg_sidebar_stories"}
{checkActionsTpl location="tpl_pligg_sidebar_comments"}

{if $Enable_Tags} {assign var=sidebar_module value="tags"}{include file=$the_template_sidebar_modules."/wrapper.tpl"} {/if}

{checkActionsTpl location="tpl_pligg_sidebar_end"}