{************************************
***** Individual Group Template *****
*************************************}
<!-- group_story_center.tpl -->
{if $enable_group eq "true"}
	{checkActionsTpl location="tpl_pligg_group_start"}
	{include file=$the_template."/group_summary.tpl"}
	{checkActionsTpl location="tpl_pligg_group_end"}
	<ul id="storytabs" class="nav nav-tabs">
		{checkActionsTpl location="tpl_pligg_group_sort_start"}
		<li {if $groupview eq "published"}class="active"{/if}>
			<a href="{$groupview_published}">
				<span>{#PLIGG_Visual_Group_Published#}</span>
				{if $group_published_rows}
					<span class="badge badge-gray">{$group_published_rows}</span>
				{/if}
			</a>
		</li>
		<li {if $groupview eq "new"}class="active"{/if}>
			<a href="{$groupview_new}">
				<span>{#PLIGG_Visual_Group_New#}</span>
				{if $group_new_rows}
					<span class="badge badge-gray">{$group_new_rows}</span>
				{/if}
			</a>
		</li>
		<li {if $groupview eq "shared"}class="active"{/if}>
			<a href="{$groupview_sharing}">
				<span>{#PLIGG_Visual_Group_Shared#}</span>
				{if $group_shared_rows}
					<span class="badge badge-gray">{$group_shared_rows}</span>
				{/if}
			</a>
		</li>
		<li {if $groupview eq "members"}class="active"{/if}>
			<a href="{$groupview_members}">
				<span class="active">{#PLIGG_Visual_Group_Member#}</span>
				{*
				{if $group_members}
					<span class="badge badge-gray">{$group_members}</span>
				{/if}
				*}
			</a>
		</li>
		{checkActionsTpl location="tpl_pligg_group_sort_end"}
	</ul>
	<div class="tab-content" id="tabbed">
		{if $groupview eq "published"}
			{$group_display}
			<div style="clear:both;"></div>
			{$group_story_pagination}
		{elseif $groupview eq "new"}
			{$group_display}
			<div style="clear:both;"></div>
			{$group_story_pagination}
		{elseif $groupview eq "shared"}
			{$group_shared_display}
			<div style="clear:both;"></div>
			{$group_story_pagination}
		{elseif $groupview eq "members"}
			<table class="table table-bordered table-striped">
				<thead>
					<tr>
						<th style="width:32px">&nbsp;</th>
						<th>Username</th>
						{if $is_group_admin}
							<th style="width:100px;">Role</th>
							<th style="width:75px;">Edit</th>
							<th style="width:105px;">Activation</th>
						{/if}
					</tr>
				</thead>
				<tbody>
					{$member_display}
				</tbody>
			</table>
		{/if}
	</div>
{/if}
<!--/group_story_center.tpl -->