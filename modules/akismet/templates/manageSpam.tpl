{config_load file=akismet_lang_conf}

<legend>{#PLIGG_Akismet_manage_stories#}</legend>

<form name="bulk_moderate" action="{$URL_akismet_isSpam}&action=bulkmod" method="post">
	<table class="table table-bordered table-striped">
		<thead>
			<tr>
				<th style="width:250px;">{#PLIGG_Akismet_title#}</th>
				<th style="width:110px;">{#PLIGG_Akismet_author#}</th>
				<th>{#PLIGG_Akismet_url#}</th>
				<th style="width:50px;">{#PLIGG_Akismet_status#}</th>
				<th style="width:60px;"><input type='checkbox' name='all1'  onclick='mark_all_spam();'><a onclick='mark_all_spam();' style="cursor:pointer;text-decoration:none;">{#PLIGG_Akismet_spam#}</a></th>
				<th style="width:90px;"><input type='checkbox' name='all2'  onclick='mark_all_notspam();'><a onclick='mark_all_notspam();' style="cursor:pointer;text-decoration:none;">{#PLIGG_Akismet_not_spam#}</a></th>
			</tr>
		</thead>
		<tbody>
			{if count($link_data) gt 0}
				{foreach value=link from=$link_data}
					<tr>
						<td><strong>{$link.link_title|truncate:50}</strong></td>
						<td><a href="{$my_pligg_base}/admin/admin_users.php?mode=view&user={$link.user_login}">{$link.user_login|truncate:20}</a></td>
						<td><a href="{$link.link_url}" target="_blank">{$link.link_url|truncate:70}</a></td>
						<td style="text-align:center;">
							{if $link.link_status eq "moderated"}
								<img src="{$my_pligg_base}/modules/akismet/images/page_white_error.png" alt="{#PLIGG_Akismet_status_moderated#}" title="{#PLIGG_Akismet_status_moderated#}" />
							{elseif $link.link_status eq "spam"}
								<img src="{$my_pligg_base}/modules/akismet/images/page_white_delete.png" alt="{#PLIGG_Akismet_status_spam#}" title="{#PLIGG_Akismet_status_spam#}" />
							{/if}
						</td>
						<td><center><input type="radio" name="spam[{$link.link_id}]" id="spam-{$link.link_id}" value="spam"></center></td>
						<td><center><input type="radio" name="spam[{$link.link_id}]" id="spam-{$link.link_id}" value="notspam"></center></td>
					</tr>
					<tr style="margin-bottom:10px;">
						<td colspan="7">{$link.link_content|strip_tags:false}</td>
					</tr>
				{/foreach}
			{/if}
		</tbody>
	</table>
	<p align="right" style="margin-top:10px;"><input type="submit" name="submit" value="{#PLIGG_Akismet_apply_changes#}" class="btn btn-primary" /></p>
</form>

<hr />
<a href="{$URL_akismet}" class="btn btn-default">Return to the Akismet Management page</a>

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

{config_load file=akismet_pligg_lang_conf}