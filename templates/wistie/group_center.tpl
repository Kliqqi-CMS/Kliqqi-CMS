{if $pagename eq "groups"}
	<div class="groupexplain">
		<div id="group_explain_inner">
			<div id="group_explain_description">
			{#PLIGG_Visual_Group_Explain#}
			</div>
			{if $group_allow eq "1"}
				<div id="create_group">
				<form>
					<input type="button" value="{#PLIGG_Visual_Submit_A_New_Group#}" onclick="window.location.href='{$URL_submit_groups}'" style="padding:3px 5px;">
				</form>
				</div>
			{/if}
			<div id="search_groups">
				<form action="{$my_pligg_base}/groups.php" method="get"
				{if $urlmethod eq 2}
					onsubmit="document.location.href = '{$my_base_url}{$my_pligg_base}/groups/search/' + encodeURIComponent(this.keyword.value); return false;"
				{/if}
				>
				<input type="hidden" name="view" value="search">
					{if $get.keyword neq ""}
						{assign var=searchboxtext value=$get.keyword}
					{else}
						{assign var=searchboxtext value=#PLIGG_Visual_Search_SearchDefaultText#}			
					{/if}
				<input type="text" name="keyword" class="field" value="{$searchboxtext}" onfocus="if(this.value == '{$searchboxtext}') {ldelim}this.value = '';{rdelim}" onblur="if (this.value == '') {ldelim}this.value = '{$searchboxtext}';{rdelim}">
				<input type="submit" value="{#PLIGG_Visual_Group_Search_Groups#}" class="button">
				</form>
			</div>
			<div style="clear:both;"></div>
		</div>
	</div>
{/if}

{if $get.keyword}
    {if $group_display}
		<h2>{#PLIGG_Visual_Search_SearchResults#} '{$search}'</h2>
    {else}
		<h2>{#PLIGG_Visual_Search_NoResults#} '{$search}'</h2>
    {/if}
{/if}

{$group_display}
<div style="clear:both;"></div>
{$group_pagination}