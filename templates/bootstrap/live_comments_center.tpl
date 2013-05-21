{************************************
********* Live Comments Page ********
*************************************}
<!-- live_comments_center.tpl -->
<legend>{#PLIGG_Visual_Live#} {#PLIGG_Visual_Comments#}</legend>
<table class="table table-bordered table-striped">
	<thead>
		<tr class="live2-item">
			<td><strong>{#PLIGG_Visual_Comments_Comment#}</th>
			<td><strong>{#PLIGG_Visual_Comments_Author#}</th>
			<td><strong>{#PLIGG_Visual_Comments_Link#}</th>
			<td><strong>{#PLIGG_Visual_Comments_Date#}</th>
		</tr>
	</thead>
		{section name=live_item loop=$live_items}
		<tr>
			<td>{$live_items[live_item].comment_content}</td>
			<td><a href="{$URL_user, $live_items[live_item].comment_author}">{$live_items[live_item].comment_author}</a></td>
			<td><a href="{$live_items[live_item].comment_link_url}">{$live_items[live_item].comment_link_title}</a></td>
			<td>{$live_items[live_item].comment_date}</td>
		</tr>
		{/section}
	</tbody>
</table>
{checkActionsTpl location="tpl_pligg_pagination_start"}
{$live_pagination}
{checkActionsTpl location="tpl_pligg_pagination_end"}
<!--/live_comments_center.tpl -->