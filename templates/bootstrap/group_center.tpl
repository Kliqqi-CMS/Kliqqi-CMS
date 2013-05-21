{************************************
******* Groups Main Template ********
*************************************}
<!-- group_center.tpl -->
{if $enable_group eq "true"}
	{if $pagename eq "groups"}
		<div class="hero-unit group_explain">
			<div class="group_explain_inner">
				<h2>Groups</h2>
				<div class="group_explain_description">
					{#PLIGG_Visual_Group_Explain#}
				</div>
				{if $group_allow eq "1"}
					<div class="create_group">
						<form>
							<input type="button" value="{#PLIGG_Visual_Submit_A_New_Group#}" onclick="window.location.href='{$URL_submit_groups}'" class="btn btn-success">
						</form>
					</div>
				{/if}
				<div class="search_groups">
					<div class="input-append">
						<form action="{$my_pligg_base}/groups.php" method="get"	{if $urlmethod eq 2}onsubmit="document.location.href = '{$my_base_url}{$my_pligg_base}/groups/search/' + encodeURIComponent(this.keyword.value); return false;"{/if}>
							<input type="hidden" name="view" value="search">
								{if $get.keyword neq ""}
									{assign var=searchboxtext value=$get.keyword}
								{else}
									{assign var=searchboxtext value=#PLIGG_Visual_Search_SearchDefaultText#}			
								{/if}
							<input type="text" name="keyword" value="{$searchboxtext}" onfocus="if(this.value == '{$searchboxtext}') {ldelim}this.value = '';{rdelim}" onblur="if (this.value == '') {ldelim}this.value = '{$searchboxtext}';{rdelim}" class="input-medium"><button class="btn" type="submit">{#PLIGG_Visual_Group_Search_Groups#}</button>
						</form>
					</div>
				</div>
				<div style="clear:both;"></div>
			</div>
		</div>
	{/if}
	{if $get.keyword}
		{if $group_display}
			<legend>{#PLIGG_Visual_Search_SearchResults#} &quot;{$search}&quot;</legend>
		{else}
			<legend>{#PLIGG_Visual_Search_NoResults#} &quot;{$search}&quot;</legend>
		{/if}
	{/if}
	{$group_display}
	<div style="clear:both;"></div>
	{$group_pagination}
{/if}
   {if $enable_group neq "true"}
       {literal}
                <script type="text/javascript">
   <!--
   window.location="{/literal}{$my_base_url}{$my_pligg_base}/error_404.php{literal}";
   //-->
                </script>
      {/literal}
   {/if}
<!-- group_center.tpl -->