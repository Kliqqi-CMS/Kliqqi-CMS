{************************************
****** Top Users Page Template ******
*************************************}
<!-- topusers_center.tpl -->
<legend>{#PLIGG_Visual_Top_Users#}</legend>
{checkActionsTpl location="tpl_pligg_topusers_start"}
<table class="tablesorter table table-bordered table-striped" id="tablesorter-demo" >
	<thead>
		<tr>
			<th>{#PLIGG_Visual_Rank#}</th>
			{foreach from=$headers item=header key=number}
				<th>
					{$header}
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
<!--/topusers_center.tpl -->