{checkActionsTpl location="tpl_pligg_group_start"}
{include file=$the_template."/group_summary.tpl"}
{checkActionsTpl location="tpl_pligg_group_end"}
{*down tabs begins*}
<br clear="all"/>
<br clear="all"/>

{if $groupview eq "published"}
	<div id="group_published">
		<h1>{#PLIGG_Visual_Group_Published#}</h1>
		{$group_display}
		{$group_story_pagination}
	</div>
{elseif $groupview eq "upcoming"}
	<div id="group_upcoming">
		<h1>{#PLIGG_Visual_Group_Upcoming#}</h1>
		{$group_display}
		{$group_story_pagination}
	</div>
{elseif $groupview eq "shared"}
	<div id="group_shared">
		<h1>{#PLIGG_Visual_Group_Shared#}</h1>
		{$group_shared_display}
		{$group_story_pagination}
	</div>
{elseif $groupview eq "members"}
	<div id="who_are_members">
		<h1>{#PLIGG_Visual_Group_Member#}</h1>
		<div class="whovotedwrapper" id="idwhovotedwrapper">
			{$member_display}
		</div>
	</div>	
{/if}
