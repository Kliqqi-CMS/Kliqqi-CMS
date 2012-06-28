<div style="margin:8px 10px;">
	<h1>{#PLIGG_Visual_Change_Link_Status#}</h1>
	<hr />
	<ul style="list-style-type:none;margin:4px 0;padding:4px 8px;">
		<li><a href="{$admin_queued_url}">Set as Upcoming</a> &ndash; {#PLIGG_Visual_Change_Link_Queued#}</li>
		<li><a href="{$admin_published_url}">Set as Published</a> &ndash; {#PLIGG_Visual_Change_Link_Published#}</li>
		<li><a href="{$admin_discard_url}">Discard the Story</a> &ndash; {#PLIGG_Visual_Change_Link_Discard#}</li>
	</ul>
	<hr />
	<p><strong>{#PLIGG_Visual_Change_Link_Title#}:</strong> {$link_title} </p>
	<br />
	<p><strong>{#PLIGG_Visual_Change_Link_URL#}:</strong> <a href="{$link_url}" target="_blank">{$link_url}</a> &ndash; <a href = "{$my_base_url}{$my_pligg_base}/admin/manage_banned_domains.php?id={$link_id}&add={$banned_domain_url}">{#PLIGG_Visual_Ban_This_URL#}</a></p>
	<br />
	<p><strong>{#PLIGG_Visual_Change_Link_Content#}:</strong> {$link_content}</p>
	<br />
	<p><strong>{#PLIGG_Visual_Change_Link_Status2#}:</strong> {if $link_status eq "queued"}Upcoming{else}{$link_status|capitalize}{/if}</p>
	<br />
	<p><strong>{#PLIGG_Visual_Change_Link_Submitted_By#}:</strong> <a href="../user.php?login={$user_login}">{$user_login}</a> &ndash; <a href ="{$my_base_url}{$my_pligg_base}/admin/admin_users.php?mode=view&user={$user_login}">{#PLIGG_Visual_AdminPanel_User_Manage#}</a></p>
</div>
<br style="clear:both;" />