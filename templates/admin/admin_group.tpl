<h2><img src="{$my_pligg_base}/templates/admin/images/page.gif" align="absmiddle" /> {#PLIGG_Visual_AdminPanel_Manage_Groups#}</h2>
<br /><br />
	<table class="stripes" cellpadding="0" cellspacing="0" border="0">
		<thead>
			<tr>
				<th>{#PLIGG_Visual_AdminPanel_Group_Name#}</th>
				<th>{#PLIGG_Visual_AdminPanel_Group_Author#}</th>
				<th width="120px">{#PLIGG_Visual_AdminPanel_Group_Privacy#}</th>
				<th width="120px">{#PLIGG_Visual_AdminPanel_Group_Date#}</th>
				<th style="width:40px;text-align:center;">{#PLIGG_Visual_AdminPanel_Group_Edit#}</th>
				<th style="width:50px;text-align:center;">{#PLIGG_Visual_AdminPanel_Group_Delete#}</th>
			</tr>
		</thead>
		<tbody>
		{foreach from=$groups item=group}
			<tr>
				<td>
					{if $group.group_status!='Enable'}
						<a href='?mode=approve&group_id={$group.group_id}'><img src="{$my_pligg_base}/templates/admin/images/icon_bury.gif" title="{#PLIGG_Visual_AdminPanel_Group_Approve#}" alt="{#PLIGG_Visual_AdminPanel_Group_Approve#}" /></a>
					{else}
						<img src="{$my_pligg_base}/templates/admin/images/icon_share_true.gif" title="{#PLIGG_Visual_AdminPanel_Group_Approve#}d" alt="{#PLIGG_Visual_AdminPanel_Group_Approve#}d" />
					{/if}
					<a href="{$my_pligg_base}/group_story.php?id={$group.group_id}">{$group.group_name}</a>
				</td>
				<td><a href="{$my_pligg_base}/admin/admin_users.php?mode=view&user={$group.user_login}">{$group.user_login}</a></td>
				<td>{$group.group_privacy}</td>
				<td>{$group.group_date}</td>
				<td style="text-align:center;"><a href='../editgroup.php?id={$group.group_id}' rel="width:800,height:700"><img src="{$my_pligg_base}/templates/admin/images/user_edit.gif" alt="{#PLIGG_Visual_AdminPanel_Group_Edit#}" title="{#PLIGG_Visual_AdminPanel_Group_Edit#}" /></a></td>
				<td style="text-align:center;"><a onclick='return confirm("{#PLIGG_Visual_Group_Delete_Confirm#}");' href='?mode=delete&group_id={$group.group_id}'><img src="{$my_pligg_base}/templates/admin/images/delete.png" alt="{#PLIGG_Visual_AdminPanel_Group_Delete#}" title="{#PLIGG_Visual_AdminPanel_Group_Delete#}" /></a></td>
			</tr>
		{/foreach}
		</tbody>
	</table>

<br />

<div class="admin_bottom_button"><a href="{$my_base_url}{$my_pligg_base}/submit_groups.php" onclick="window.open('{$my_base_url}{$my_pligg_base}/submit_groups.php','popup','width=900,height=900,scrollbars=yes,resizable=yes,toolbar=no,directories=no,location=no,menubar=no,status=no,left=0,top=0'); return false"><img src="{$my_pligg_base}/templates/admin/images/friends.gif" style="margin-top:2px;"/><p style="margin:1px 0 0 3px;float:right;">{#PLIGG_Visual_AdminPanel_New_Group#}</p></a></div>
<div style="clear:both;"> </div>