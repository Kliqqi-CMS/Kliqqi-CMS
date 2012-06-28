<h2><img src="{$my_pligg_base}/templates/admin/images/news_manage.gif" align="absmiddle" />
{if $templatelite.get.user}
{$templatelite.get.user|sanitize:2}'s {#PLIGG_Visual_TopUsers_TH_News#}
{else}
{#PLIGG_Visual_AdminPanel_Links#}
{/if}
</h2>

<table cellpadding="0" cellspacing="0" border="0">
	<tr>
		<form action="{$my_base_url}{$my_pligg_base}/admin/admin_links.php" method="get">
		<td width="300px">
				<input type="hidden" name="mode" value="search">
					{if isset($templatelite.get.keyword) && $templatelite.get.keyword neq ""}
						{assign var=searchboxtext value=$templatelite.get.keyword|sanitize:2}
					{else}
						{assign var=searchboxtext value=#PLIGG_Visual_Search_SearchDefaultText#}			
					{/if}
				<input type="text" size="30" name="keyword" value="{$searchboxtext}" onfocus="if(this.value == '{$searchboxtext}') {ldelim}this.value = '';{rdelim}" onblur="if (this.value == '') {ldelim}this.value = '{$searchboxtext}';{rdelim}">
				<input type="hidden" name="user" value="{$templatelite.get.user|sanitize:2}">
				<input type="submit" value="{#PLIGG_Visual_Search_Go#}">
		</td>
		<td width="100px">
				<select name="filter" onchange="this.form.submit()">
					<option value="all" {if $templatelite.get.filter == "all"} selected="selected" {/if}>{#PLIGG_Visual_AdminPanel_All#}</option>
					<option value="published" {if $templatelite.get.filter == "published"} selected="selected" {/if}>{#PLIGG_Visual_AdminPanel_Published#}</option>
					<option value="upcoming" {if $templatelite.get.filter == "upcoming"} selected="selected" {/if}>{#PLIGG_Visual_AdminPanel_Upcoming#}</option>
					<option value="discard" {if $templatelite.get.filter == "discard"} selected="selected" {/if}>{#PLIGG_Visual_AdminPanel_Discarded#}</option>
					<option value="spam" {if $templatelite.get.filter == "spam"} selected="selected" {/if}>{#PLIGG_Visual_AdminPanel_Spam#}</option>
					<option value="all">   ---   </option>
					<option value="today" {if $templatelite.get.filter == "today"} selected="selected" {/if}>{#PLIGG_Visual_AdminPanel_Today#}</option>
					<option value="yesterday" {if $templatelite.get.filter == "yesterday"} selected="selected" {/if}>{#PLIGG_Visual_AdminPanel_Yesterday#}</option>
					<option value="week" {if $templatelite.get.filter == "week"} selected="selected" {/if}>{#PLIGG_Visual_AdminPanel_Week#}</option>
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
<form name="bulk_moderate" action="{$my_pligg_base}/admin/admin_links.php?action=bulkmod&page={$templatelite.get.page|sanitize:2}" method="post">
		<td style="float:right;margin:0px 2px 0 0"><input type="submit" name="submit" onclick="return confirm_spam()" value="{#PLIGG_Visual_AdminPanel_Apply_Changes#}" class="log2" /></td>
	</tr>
</table>

{$hidden_token_admin_links_edit}
<table class="stripes" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<th>{#PLIGG_Visual_View_Links_Author#}</th>
		<th>{#PLIGG_Visual_View_Links_New_Window#}</th>
		<th nowrap><input type='checkbox' name='all1'  onclick='mark_all_publish();'><a onclick='mark_all_publish();' style="cursor:pointer;text-decoration:none;color:#fff;">{#PLIGG_Visual_AdminPanel_Publish#}</a></th>
		<th nowrap><input type='checkbox' name='all2' onclick='mark_all_queued();'><a onclick='mark_all_queued();' style="cursor:pointer;text-decoration:none;color:#fff;">{#PLIGG_Visual_AdminPanel_Upcoming#}</a></th>
		<th nowrap><input type='checkbox' name='all3' onclick='mark_all_spam();'><a onclick='mark_all_spam();' style="cursor:pointer;text-decoration:none;color:#fff;">{#PLIGG_Visual_AdminPanel_Spam#}</a></th>
		<th nowrap><input type='checkbox' name='all4' onclick='mark_all_discard();'><a onclick='mark_all_discard();' style="cursor:pointer;text-decoration:none;color:#fff;">{#PLIGG_Visual_AdminPanel_Discard#}</a></a></th>
	</tr>
	{section name=id loop=$template_stories}
	<tr>
		<td><a href="{$my_pligg_base}/admin/admin_users.php?mode=view&user={$template_stories[id].link_author}" title="{$template_stories[id].link_author}'s Articles" id="link-{$template_stories[id].link_id}-author">{$template_stories[id].link_author}</a></td>
		<td>
			<div style="margin:0 10px 0 0;padding:0;float:left;">
				<a href='{$my_pligg_base}/editlink.php?id={$template_stories[id].link_id}'><img src="{$my_pligg_base}/templates/admin/images/icon_user_edit.png" title="{#PLIGG_Visual_AdminPanel_Page_Edit#}" alt="{#PLIGG_Visual_AdminPanel_Page_Edit#}" />
			</div>
			<a href="{$my_pligg_base}/story.php?title={$template_stories[id].link_title_url}" title="{$template_stories[id].link_title|truncate:50:"...":true}" class="colorbox_iframe2">{$template_stories[id].link_title}</a>
			<input type='hidden' name='old[{$template_stories[id].link_id}]' id="link-{$template_stories[id].link_id}-old" value='{$template_stories[id].link_status}'>
		</td>
		<td style="width:70px;text-align:center;"><input type="radio" name="link[{$template_stories[id].link_id}]" id="link-{$template_stories[id].link_id}" value="published" {if $template_stories[id].link_status=='published'}checked{/if}></td>
		<td style="width:70px;text-align:center;"><center><input type="radio" name="link[{$template_stories[id].link_id}]" id="link-{$template_stories[id].link_id}" value="queued" {if $template_stories[id].link_status=='queued'}checked{/if}></td>
		<td style="width:70px;text-align:center;"><center><input type="radio" name="link[{$template_stories[id].link_id}]" id="link-{$template_stories[id].link_id}" value="spam" {if $template_stories[id].link_status=='spam'}checked{/if}></td>
		<td style="width:70px;text-align:center;"><center><input type="radio" name="link[{$template_stories[id].link_id}]" id="link-{$template_stories[id].link_id}" value="discard" {if $template_stories[id].link_status=='discard'}checked{/if}></td>
	</tr>	
	{/section}
</table>

	<div style="float:right;margin:8px 2px 0 0;"><input type="submit" name="submit" onclick="return confirm_spam()" value="{#PLIGG_Visual_AdminPanel_Apply_Changes#}" class="log2" /></div>
	<div style="clear:both;"> </div>

</form>

<div style="float:right;margin-top:12px;"><a href="{$my_pligg_base}/admin/admin_delete_stories.php" class="colorbox_iframe1" title="{#PLIGG_Visual_AdminPanel_Delete_Stories#}"><p>{#PLIGG_Visual_AdminPanel_Delete_Stories#}</p></a></div>
<div style="clear:both;"> </div>

<SCRIPT>
var confirmation = "{#PLIGG_Visual_AdminPanel_Confirm_Killspam#}\n";
{literal}
function mark_all_publish() {
	document.bulk_moderate.all1.checked=1;
	document.bulk_moderate.all2.checked=0;
	document.bulk_moderate.all3.checked=0;
	document.bulk_moderate.all4.checked=0;
	for (var i=0; i< document.bulk_moderate.length; i++) {
		if (document.bulk_moderate[i].value == "published") {
			document.bulk_moderate[i].checked = true;
		}
	}
}
function mark_all_discard() {
	document.bulk_moderate.all1.checked=0;
	document.bulk_moderate.all2.checked=0;
	document.bulk_moderate.all3.checked=0;
	document.bulk_moderate.all4.checked=1;
	for (var i=0; i< document.bulk_moderate.length; i++) {
		if (document.bulk_moderate[i].value == "discard") {
			document.bulk_moderate[i].checked = true;
		}
	}
}
function mark_all_queued() {
	document.bulk_moderate.all1.checked=0;
	document.bulk_moderate.all2.checked=1;
	document.bulk_moderate.all3.checked=0;
	document.bulk_moderate.all4.checked=0;
	for (var i=0; i< document.bulk_moderate.length; i++) {
		if (document.bulk_moderate[i].value == "queued") {
			document.bulk_moderate[i].checked = true;
		}
	}
}
function mark_all_spam() {
	document.bulk_moderate.all1.checked=0;
	document.bulk_moderate.all2.checked=0;
	document.bulk_moderate.all3.checked=1;
	document.bulk_moderate.all4.checked=0;
	for (var i=0; i< document.bulk_moderate.length; i++) {
		if (document.bulk_moderate[i].value == "spam") {
			document.bulk_moderate[i].checked = true;
		}
	}
}
function uncheck_all() {
	document.bulk_moderate.all1.checked=0;
	document.bulk_moderate.all2.checked=0;
	document.bulk_moderate.all3.checked=0;
	document.bulk_moderate.all4.checked=0;
	for (var i=0; i< document.bulk_moderate.length; i++) {
		if ((document.bulk_moderate[i].value == "queued")||(document.bulk_moderate[i].value == "discard")||(document.bulk_moderate[i].value == "spam")|| (document.bulk_moderate[i].value == "published")){
			document.bulk_moderate[i].checked = false;
		}
	}
}
function confirm_spam() {
    var checks = document.getElementsByTagName('INPUT');
    var authors = new Array();
    for (var i=0; i<checks.length; i++)
     	if (checks[i].type=="radio" && checks[i].checked && checks[i].value=="spam")
        {
            old = document.getElementById(checks[i].id+'-old');
            if (old.value!='spam')
            {
                author = document.getElementById(checks[i].id+'-author');
                authors[author.innerHTML] = 1;
            }
        }

    var message = "";
    for (name in authors)
	if (authors[name]==1)
            message += name+"\n";
    if (message.length > 0)
        	return confirm(confirmation+message);
    return 1;
}
</SCRIPT>
{/literal}