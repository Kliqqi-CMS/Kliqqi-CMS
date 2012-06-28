<div style="margin:8px 10px;">
	<h1>{#PLIGG_Visual_Change_Link_Status#}</h1>
	<hr />
	<div style="margin:0 10px;">
		<h2>Are you sure that you want to change the story status to {if $action eq "queued"}Upcoming{else}{$action|capitalize}{/if}?</h2>
		<div class="admin_bottom_button" style="padding:3px 8px;background:url('../templates/admin/images/bgrepeat.png') repeat-x left -134px;"><a href="{$admin_modify_do_url}">Yes</a></div>
		<div class="admin_bottom_button" style="margin-left:12px;margin-bottom:12px;padding:3px 8px;background:url('../templates/admin/images/bgrepeat.png') repeat-x left -250px;"><a href="{$admin_modify_url}">No</a></div>
		<div style="clear:both;"> </div>
	</div>
	<hr />
	<p><strong>{#PLIGG_Visual_Change_Link_Title#}:</strong> {$link_title} </p>
	<br />
	<p><strong>{#PLIGG_Visual_Change_Link_URL#}:</strong> <a href="{$link_url}" target="_blank">{$link_url}</a> &ndash; <a href = "{$my_base_url}{$my_pligg_base}/admin/manage_banned_domains.php?id={$link_id}&add={$banned_domain_url}">{#PLIGG_Visual_Ban_This_URL#}</a></p>
	<br />
	<p><strong>{#PLIGG_Visual_Change_Link_Content#}:</strong> {$link_content}</p>
</div>


