{************************************
****** Second Sidebar Template ******
*************************************}
<!-- sidebar2.tpl -->
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
{checkActionsTpl location="tpl_pligg_sidebar_stories_u"}
{checkActionsTpl location="tpl_pligg_sidebar_stories"}
{checkActionsTpl location="tpl_pligg_sidebar_comments"}
{if $Enable_Tags}
	{assign var=sidebar_module value="tags"}
	{include file=$the_template_sidebar_modules."/wrapper.tpl"}
{/if}
{checkActionsTpl location="tpl_pligg_sidebar_end"}
<!--/sidebar2.tpl -->