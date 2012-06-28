{config_load file=akismet_lang_conf}
<fieldset>
	<legend><img src="{$akismet_img_path}shield.png" align="absmiddle"/> {#PLIGG_Akismet_manage_stories#}</legend>
	<a href="{$URL_akismet}">Return to the Akismet Management page</a><br /><br />
	
	<form name="bulk_moderate" action="{$URL_akismet_isSpam}&action=bulkmod" method="post">
		<table class="stripes" cellpadding="0" cellspacing="0" border="0">
			<tr>
				<th style="width:110px;">{#PLIGG_Akismet_author#}</th>
				<th>{#PLIGG_Akismet_url#}</th>
				{* <th>{#PLIGG_Akismet_status#}</th> *}
				<th style="width:250px;">{#PLIGG_Akismet_title#}</th>
				{* <th>{#PLIGG_Akismet_content#}</th> *}
				<th style="width:60px;"><input type='checkbox' name='all1'  onclick='mark_all_spam();'><a onclick='mark_all_spam();' style="cursor:pointer;text-decoration:none;color:#fff;">{#PLIGG_Akismet_spam#}</a></th>
				<th style="width:90px;"><input type='checkbox' name='all2'  onclick='mark_all_notspam();'><a onclick='mark_all_notspam();' style="cursor:pointer;text-decoration:none;color:#fff;">{#PLIGG_Akismet_not_spam#}</a></th>
			</tr>
			{if count($link_data) gt 0}
				{ foreach value=link from=$link_data }
					{*<a href = "{$URL_akismet_isSpam}{$link.link_id}">{#PLIGG_Akismet_spam_yes#}</a><br />
					<a href = "{$URL_akismet_isNotSpam}{$link.link_id}">{#PLIGG_Akismet_spam_no#}</a><br /><br />*}
					<tr>
						<td><a href="{$my_pligg_base}/admin/admin_users.php?mode=view&user={$link.user_login}">{$link.user_login|truncate:20}</a></td>
						<td><a href="{$link.link_url}" target="_blank">{$link.link_url|truncate:70}</a></td>
						{* <td>
							{if $link.link_status eq "discard"}
								<img src="./modules/akismet/images/page_white_delete.png" alt="{#PLIGG_Akismet_status_discarded#}" title="{#PLIGG_Akismet_status_discarded#}" />
							{elseif $link.link_status eq "spam"}
								<img src="./modules/akismet/images/page_white_error.png" alt="{#PLIGG_Akismet_status_spam#}" title="{#PLIGG_Akismet_status_spam#}" />
							{/if}
						</td> *}
						<td>{$link.link_title|truncate:50}</td>
						<td><center><input type="radio" name="spam[{$link.link_id}]" id="spam-{$link.link_id}" value="spam"></center></td>
						<td><center><input type="radio" name="spam[{$link.link_id}]" id="spam-{$link.link_id}" value="notspam"></center></td>
					</tr>
					<tr colspan="4" style="margin-bottom:10px;">
						<td colspan="3">{$link.link_content|strip_tags:false}</td>
						<td></td>
						<td></td>
					</tr>
				{ /foreach }
			{/if}
		</table>
		<p align="right" style="margin-top:10px;"><input type="submit" name="submit" value="{#PLIGG_Akismet_apply_changes#}" class="log2" /></p>
	</form>
</legend>
{config_load file=akismet_pligg_lang_conf}

{literal}
<SCRIPT>
function mark_all_spam() {
	document.bulk_moderate.all1.checked=1;
	document.bulk_moderate.all2.checked=0;
	for (var i=0; i< document.bulk_moderate.length; i++) {
		if (document.bulk_moderate[i].value == "spam") {
			document.bulk_moderate[i].checked = true;
		}
	}
}
function mark_all_notspam() {
	document.bulk_moderate.all1.checked=0;
	document.bulk_moderate.all2.checked=1;
	for (var i=0; i< document.bulk_moderate.length; i++) {
		if (document.bulk_moderate[i].value == "notspam") {
			document.bulk_moderate[i].checked = true;
		}
	}
}
</SCRIPT>
{/literal}