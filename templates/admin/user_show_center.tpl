{section name=nr loop=$userdata}
	<h1>View User</h1>
	<table class="stripes" cellpadding="0" cellspacing="0">
		<th colspan="2">Viewing {$userdata[nr].user_login}</th>
		<tr><td width="160px"><strong>{#PLIGG_Visual_View_User_Login#}: </strong></td><td><img src="{$userdata[nr].Avatar}" align="absmiddle"/> {$userdata[nr].user_login}</td></tr>
		<tr><td width="160px"><strong>{#PLIGG_Visual_View_User_Level#}: </strong></td><td>{$userdata[nr].user_level}</td></tr>
		<tr><td width="160px"><strong>{#PLIGG_Visual_View_User_Email#}: </strong></td><td>{$userdata[nr].user_email}</td></tr>
		<tr><td width="160px"><strong>{#PLIGG_Visual_View_User_LL_Date#}: </strong></td><td>{$userdata[nr].user_lastlogin}</td></tr>
		<tr><td width="160px"><strong>{#PLIGG_Visual_View_User_LL_Address#}: </strong></td><td> {$userdata[nr].user_lastip}</td></tr>
		<tr><td width="160px"><strong>{#PLIGG_Visual_View_User_Groups_Belongs#}: </strong></td><td> {$userdata[nr].belongs}</td></tr>
		<tr><td width="160px"><strong>{#PLIGG_Visual_View_User_Groups_Created#}: </strong></td><td> {$userdata[nr].created}</td></tr>
		{if $userdata[nr].user_login neq "god"}<tr><td><strong>{#PLIGG_Visual_View_User_IP_Address#}:</strong></td><td> {$userdata[nr].user_ip}</td></tr>{/if}
		{checkActionsTpl location="tpl_admin_user_show_center_fields"}
		<tr><td><img src="{$my_pligg_base}/templates/admin/images/user_links.gif" align="absmiddle"/> <a href="admin_links.php?user={$userdata[nr].user_login}">{#PLIGG_Visual_View_User_Sub_Links#}</a></td> <td> {$linkcount} Total</td></tr>
		<br />
		<tr><td><img src="{$my_pligg_base}/templates/admin/images/user_comments.gif" align="absmiddle"/> <a href="admin_comments.php?user={$userdata[nr].user_login}">{#PLIGG_Visual_View_User_Sub_Comments#}</a></td> <td> {$commentcount} Total</td></tr>
	</table>	
<hr/>
		
{if $amIgod}		

	<table>
		<tr><td><img src="{$my_pligg_base}/templates/admin/images/user_edit.gif" align="absmiddle"/> <a href="?mode=edit&user={$userdata[nr].user_login}">{#PLIGG_Visual_View_User_Edit_Data#}</a></td></tr>
		{if $user_logged_in neq $userdata[nr].user_login && $userdata[nr].user_id neq '1'}
			{if $userdata[nr].user_enabled}
			<tr><td><img src="{$my_pligg_base}/templates/admin/images/user_disable.gif" align="absmiddle"/> <a href="?mode=disable&user={$userdata[nr].user_login}">{#PLIGG_Visual_View_User_Disable#}</a></td></tr>
			{else}
			<tr><td><img src="{$my_pligg_base}/templates/admin/images/user_disable.gif" align="absmiddle"/> <a href="?mode=enable&user={$userdata[nr].user_login}">{#PLIGG_Visual_View_User_Enable#}</a></td></tr>
			{/if}
			<tr><td><img src="{$my_pligg_base}/templates/admin/images/user_killspam.gif" align="absmiddle"/> <a href="?mode=killspam&user={$userdata[nr].user_login}&id={$userdata[nr].user_id}">{#PLIGG_Visual_View_User_Killspam#}</a></td></tr>
		{/if}
	</table>

{/if}

{sectionelse}
	{include file="/templates/admin/user_doesnt_exist_center.tpl"}
{/section}
