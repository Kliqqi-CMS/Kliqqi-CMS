<h1>{#PLIGG_Visual_Top_Users#}</h1><br />

{checkActionsTpl location="tpl_pligg_topusers_start"}

<table class="table table-bordered table-striped">
	<thead>
		<tr>
			<th>{#PLIGG_Visual_Rank#}</th>
			{foreach from=$headers item=header key=number}
				<th>
					{ if $number eq $templatelite.GET.sortby }
						<span>{$header}</span>
					{ else }
						<a href="?sortby={$number}">{$header}</a>
					{ /if }
				</th>
			{/foreach}

			<th>
				{#PLIGG_Visual_TopUsers_TH_Karma#}
			</th>
		</tr>
	</thead>

	{$users_table}

</table>
{checkActionsTpl location="tpl_pligg_topusers_end"}

{checkActionsTpl location="tpl_pligg_pagination_start"}
{$topusers_pagination}
{checkActionsTpl location="tpl_pligg_pagination_end"}