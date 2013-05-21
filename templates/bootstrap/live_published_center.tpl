{************************************
******** Live Published Page ********
*************************************}
<!-- live_published_center.tpl -->
<legend>{#PLIGG_Visual_Live#} {#PLIGG_Visual_Breadcrumb_Published#}</legend>
<table class="table table-bordered table-striped">
	<thead>
		<tr class="live2-item">
			<th><strong>{#PLIGG_Visual_Comments_Date#}</strong></th>
			<th><strong>{#PLIGG_Visual_Breadcrumb_Vote#}</strong></th>
			<th><strong>{#PLIGG_Visual_Comments_Link#}</strong></th>
			<th><strong>{#PLIGG_MiscWords_Category#}</strong></th>
			<th><strong>{#PLIGG_Visual_Comments_Author#}</strong></th>
		</tr>
	</thead>
	<tbody>
	{section name=live_item loop=$live_items}
		<tr>
			<td>{$live_items[live_item].link_date}</td>
			<td>{$live_items[live_item].link_votes}</td>
			<td><a href="{$live_items[live_item].link_url}">{$live_items[live_item].link_title}</a></td>
			<td><a href="{$live_items[live_item].link_category_url}">{$live_items[live_item].link_category}</a></td> 
			<td><a href="{$URL_user, $live_items[live_item].link_username}">{$live_items[live_item].link_username}</a></td>
		</tr>
	{/section}
	</tbody>
</table>
{checkActionsTpl location="tpl_pligg_pagination_start"}
{$live_pagination}
{checkActionsTpl location="tpl_pligg_pagination_end"}
<!--/live_published_center.tpl -->