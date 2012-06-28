<h2><img src="{$my_pligg_base}/templates/admin/images/manage_user.gif" align="absmiddle" /> {#PLIGG_Visual_AdminPanel_User_Manage#}</h2>
<table cellpadding="0" cellspacing="0" border="0">
	<tr>
		<form action="{$my_base_url}{$my_pligg_base}/admin/admin_users.php" method="get">
			<td width="300px">
				<input type="hidden" name="mode" value="search">
				{if isset($templatelite.get.keyword) && $templatelite.get.keyword neq ""}
						{assign var=searchboxtext value=$templatelite.get.keyword|sanitize:2}
				{else}
						{assign var=searchboxtext value=#PLIGG_Visual_Search_SearchDefaultText#}			
				{/if}
				<input type="text" size="30" name="keyword" value="{$searchboxtext}" onfocus="if(this.value == '{$searchboxtext}') {ldelim}this.value = '';{rdelim}" onblur="if (this.value == '') {ldelim}this.value = '{$searchboxtext}';{rdelim}">
				<input type="submit" value="{#PLIGG_Visual_Search_Go#}">			  
			</td>
			<td width="100px">
				<select name="filter" onchange="this.form.submit()">
					<option value="">-- User Level --</option>
					<option value="god" {if $templatelite.get.filter == "god"} selected="selected" {/if}>God</option>
					<option value="admin" {if $templatelite.get.filter == "admin"} selected="selected" {/if}>Admin</option>
					<option value="normal" {if $templatelite.get.filter == "normal"} selected="selected" {/if}>Normal</option>
					<option value="spammer" {if $templatelite.get.filter == "spammer"} selected="selected" {/if}>Spammer</option>
				</select>
			</td>
			<td width="250px">
				<select name="pagesize" onchange="this.form.submit()">
					<option value="15" {if isset($pagesize) && $pagesize == 15}selected{/if}>Show 15</option>
					<option value="30" {if isset($pagesize) && $pagesize == 30}selected{/if}>Show 30</option>
					<option value="50" {if isset($pagesize) && $pagesize == 50}selected{/if}>Show 50</option>
					<option value="100" {if isset($pagesize) && $pagesize == 100}selected{/if}>Show 100</option>
					<option value="200" {if isset($pagesize) && $pagesize == 200}selected{/if}>Show 200</option>
				</select>
				{#PLIGG_Visual_AdminPanel_Pagination_Items#}
			</td>
		</form>
<form name='bulk' action="{$my_pligg_base}/admin/admin_users.php" method="post">
		<td style="float:right;margin:0px 2px 0 0"><input type="submit" name="submit" value="{#PLIGG_Visual_AdminPanel_Apply_Changes#}" class="log2" /></td>
	</tr>
</table>

{if isset($usererror)} <span class="error">{$usererror}</span><br/><br/>{/if}
{$hidden_token_admin_users_list}
<table class="stripes" cellpadding="0" cellspacing="0" border="0">
<tr>
<th style="width:40px;text-align:center;">ID</th>
<th style="width:40px"></th>
<th>{#PLIGG_Visual_Login_Username#}</th>
<th style="width:80px">{#PLIGG_Visual_View_User_Level#}</th>
<th>{#PLIGG_Visual_View_User_Email#}</th>
<th style="width:140px">{#PLIGG_Visual_User_Profile_Joined#}</th>
<th style="text-align:center;width:70px;">{#PLIGG_Visual_User_Profile_Enabled#}</th>
<th style="text-align:center;width:80px;"><input type='checkbox' onclick='check_all(this);' style="float:left;margin:2px 0 0 0;">{#PLIGG_Visual_KillSpam#}</th>
</tr>
	{section name=nr loop=$userlist}
	<tr>
	<td style="width:40px;text-align:center;">{$userlist[nr].user_id}</td>
	<td style="width:40px;text-align:center;"><img src="{$userlist[nr].Avatar}" /></td>
	<td><a href = "?mode=view&user={$userlist[nr].user_login}">{$userlist[nr].user_login}</a></td>	
	<td style="text-transform:capitalize">{$userlist[nr].user_level}</td>
	<td>
		<div style="margin:0 10px 0 0;padding:0;float:left;">
			{if $userlist[nr].user_lastlogin neq "0000-00-00 00:00:00"}
				<img src="{$my_pligg_base}/templates/admin/images/icon_share_true.gif" title="{#PLIGG_Visual_AdminPanel_Confirmed_Email#}" alt="{#PLIGG_Visual_AdminPanel_Confirmed_Email#}" />
			{else}
				<a href="{$my_base_url}{$my_pligg_base}/admin/admin_user_validate.php?id={$userlist[nr].user_id}" class="colorbox_iframe1" title="{#PLIGG_Visual_AdminPanel_Confirmed_Email#}"><img src="{$my_pligg_base}/templates/admin/images/icon_bury.gif" title="{#PLIGG_Visual_AdminPanel_Unconfirmed_Email#}" alt="{#PLIGG_Visual_AdminPanel_Unconfirmed_Email#}" /></a>
			{/if}
		</div>
		{$userlist[nr].user_email}
	</td>
	<td>{$userlist[nr].user_date}</td>
	<td><div style="text-align:center"><input type="checkbox" onclick="document.getElementById('enabled_{$userlist[nr].user_id}').value=this.checked ? 1 : 0;" {if $userlist[nr].user_enabled}checked{/if}></div>
	<input type="hidden" name="enabled[{$userlist[nr].user_id}]" id="enabled_{$userlist[nr].user_id}" value="{$userlist[nr].user_enabled}">
	</td>
	<td><div style="text-align:center"><input type='checkbox' id='delete' name='delete[]' value='{$userlist[nr].user_id}'></div></td>	
	</tr>
	{/section}
</table>
	<div style="float:right;margin:8px 2px 0 0;"><input type="submit" name="submit" value="{#PLIGG_Visual_AdminPanel_Apply_Changes#}" class="log2" /></div>
	<div style="clear:both;"> </div>
</form>

<div class="admin_bottom_button"><a href="{$my_pligg_base}/admin/admin_users.php?mode=create" class="colorbox_iframe1" title="{#PLIGG_Visual_AdminPanel_New_User#}"><img src="{$my_pligg_base}/templates/admin/images/user_add.gif" style="margin-top:2px;"/><p style="margin:1px 0 0 3px;float:right;">{#PLIGG_Visual_AdminPanel_New_User#}</p></a></div>
<div style="clear:both;"> </div>

<SCRIPT>
{literal}
function check_all(elem) {
	for (var i=0; i< document.bulk.length; i++) 
		if (document.bulk[i].id == "delete")
			document.bulk[i].checked = elem.checked;
}
{/literal}
</SCRIPT>

