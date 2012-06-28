<div class="pagewrap">
	<table style="border-bottom:2px solid #dedede"><tr>
		<td width="70px" align="center"><strong>{#PLIGG_Visual_Comments_Date#}</strong></td>
		<td width="40px" align="center"><strong>{#PLIGG_Visual_Breadcrumb_Vote#}</strong></td>
		<td width="240px" align="center"><strong>{#PLIGG_Visual_Comments_Link#}</strong></td>
		<td width="140px" align="center"><strong>{#PLIGG_MiscWords_Category#}</strong></td>
		<td width="60px" align="center"><strong>{#PLIGG_Visual_Comments_Author#}</strong></td>
	</tr></table>
	
{section name=live_item loop=$live_items}
	
	<div class="live2-item">
		<table><tr>
			<td width="70px">{$live_items[live_item].link_date}</td>
			<td width="40px">{$live_items[live_item].link_votes}</td>
			<td width="240px" align="left"><a href="{$live_items[live_item].link_url}">{$live_items[live_item].link_title}</a></td>
			<td width="140px"><a href="{$live_items[live_item].link_category_url}">{$live_items[live_item].link_category}</a></td> 
			<td width="60px"><a href="{$URL_user, $live_items[live_item].link_username}">{$live_items[live_item].link_username}</a></td>
		</tr></table>
	</div>

{/section}

{checkActionsTpl location="tpl_pligg_pagination_start"}
{$live_pagination}
{checkActionsTpl location="tpl_pligg_pagination_end"}

</div>
