<!-- comments.tpl -->
<legend>
{if $templatelite.get.user}
	{$templatelite.get.user|sanitize:2}'s {#PLIGG_Visual_Story_Comments#}
{else}
	{#PLIGG_Visual_AdminPanel_Comments_Legend#}
{/if}
</legend>
{if $moderated_comments_count neq "0"}
	<div class="alert">
		There {if $moderated_comments_count eq "1"}is{else}are{/if} <strong>{$moderated_comments_count} {if $moderated_comments_count eq "1"}comment{else}comments{/if}</strong> awaiting moderation.<br />
		<a href="admin_comments.php?filter=moderated">Click here to review {if $moderated_comments_count eq "1"}it{else}them{/if}.</a>
	</div>
{/if}
<table>
	<tr>
		<form action="{$my_base_url}{$my_pligg_base}/admin/admin_comments.php" method="get">
			<td>
				<div class="input-append">
					<input type="hidden" name="mode" value="search">
					{if isset($templatelite.get.keyword) && $templatelite.get.keyword neq ""}
						{assign var=searchboxtext value=$templatelite.get.keyword|sanitize:2}
					{else}
						{assign var=searchboxtext value=#PLIGG_Visual_Search_SearchDefaultText#}			
					{/if}
					<input type="hidden" name="user" value="{$templatelite.get.user|sanitize:2}">
					<input type="text" size="30" class="span7" name="keyword" value="{$searchboxtext}" onfocus="if(this.value == '{$searchboxtext}') {ldelim}this.value = '';{rdelim}" onblur="if (this.value == '') {ldelim}this.value = '{$searchboxtext}';{rdelim}"><button type="submit" class="btn">{#PLIGG_Visual_Search_Go#}</button>
				</div>
			</td>
			<td>
				<select name="filter" style="margin-right:10px;"onchange="this.form.submit()">
					<option value="all" {if $templatelite.get.filter == "all"} selected="selected" {/if}>{#PLIGG_Visual_AdminPanel_All_Comments#}</option>
					<option value="published" {if $templatelite.get.filter == "published"} selected="selected" {/if}>{#PLIGG_Visual_AdminPanel_Published#}</option>
					<option value="moderated" {if $templatelite.get.filter == "moderated"} selected="selected" {/if}>{#PLIGG_Visual_AdminPanel_Moderated#}</option>
					<option value="discard" {if $templatelite.get.filter == "discard"} selected="selected" {/if}>{#PLIGG_Visual_AdminPanel_Discarded#}</option>
					<option value="spam" {if $templatelite.get.filter == "spam"} selected="selected" {/if}>{#PLIGG_Visual_AdminPanel_Spam#}</option>
					<option value="all">   ---   </option>
					<option value="today" {if $templatelite.get.filter == "today"} selected="selected" {/if}>{#PLIGG_Visual_AdminPanel_Today#}</option>
					<option value="yesterday" {if $templatelite.get.filter == "yesterday"} selected="selected" {/if}>{#PLIGG_Visual_AdminPanel_Yesterday#}</option>
					<option value="week" {if $templatelite.get.filter == "week"} selected="selected" {/if}>{#PLIGG_Visual_AdminPanel_Week#}</option>
				</select>
			</td>
			<td>
				<select name="pagesize" onchange="this.form.submit()">
					<option value="15" {if isset($pagesize) && $pagesize == 15}selected{/if}>Show 15</option>
					<option value="30" {if isset($pagesize) && $pagesize == 30}selected{/if}>Show 30</option>
					<option value="50" {if isset($pagesize) && $pagesize == 50}selected{/if}>Show 50</option>
					<option value="100" {if isset($pagesize) && $pagesize == 100}selected{/if}>Show 100</option>
					<option value="200" {if isset($pagesize) && $pagesize == 200}selected{/if}>Show 200</option>
				</select>
			</td>
		</form>
		<form name="bulk_moderate" action="{$my_base_url}{$my_pligg_base}/admin/admin_comments.php?action=bulkmod&page={$templatelite.get.page|sanitize:2}" method="post">
		<td style="float:right;"><input type="submit" class="btn btn-primary" name="submit" onclick="return confirm_spam()" value="{#PLIGG_Visual_AdminPanel_Apply_Changes#}" /></td>
	</tr>
</table>
{$hidden_token_comments_edit}
<table class="table table-bordered table-condensed">
	<thead>
		<tr>
			<th style="width:125px;">{#PLIGG_Visual_View_Links_Author#}</th>
			<th>{#PLIGG_MiscWords_Comment#}</th>
			<th>{#PLIGG_Visual_User_NewsSent#}</th>
			<th nowrap style="text-align:center;"><input type='checkbox' name='all1' onclick='mark_all_publish();' style="display:none;"><a onclick='mark_all_publish();'>{#PLIGG_Visual_AdminPanel_Publish#}</a></th>
			<th nowrap style="text-align:center;"><input type='checkbox' name='all2' onclick='mark_all_queued();' style="display:none;"><a onclick='mark_all_queued();'>{#PLIGG_Visual_AdminPanel_Moderated#}</a></th>
			<th nowrap style="text-align:center;"><input type='checkbox' name='all3' onclick='mark_all_spam();' style="display:none;"><a onclick='mark_all_spam();'>{#PLIGG_Visual_AdminPanel_Spam#}</a></th>
			<th nowrap style="text-align:center;"><input type='checkbox' name='all4' onclick='mark_all_discard();' style="display:none;"><a onclick='mark_all_discard();'>{#PLIGG_Visual_AdminPanel_Discard#}</a></th>
		</tr>
	</thead>
	{if isset($template_comments)}
		{section name=id loop=$template_comments}
		<tr {if $template_comments[id].comment_status=='moderated'}class="tr_moderated"{/if}>
			<td><a href="{$my_base_url}{$my_pligg_base}/admin/admin_users.php?mode=view&user={$template_comments[id].comment_author}" title="{$template_comments[id].comment_author}'s Profile" id="comment-{$template_comments[id].comment_id}-author">{$template_comments[id].comment_author}</a></td>
			<td>
				<div style="margin:0 5px 0 0;padding:0;float:left;">
					<a href="{$my_base_url}{$my_pligg_base}/edit.php?id={$template_comments[id].comment_link_id}&commentid={$template_comments[id].comment_id}"><i class="icon icon-edit" title="{#PLIGG_Visual_AdminPanel_Page_Edit#}" alt="{#PLIGG_Visual_AdminPanel_Page_Edit#}"></i>
				</div>
				<a href="{$my_base_url}{$my_pligg_base}/story.php?id={$template_comments[id].comment_link_id}#c{$template_comments[id].comment_id}" title="{$template_comments[id].comment_content_long|truncate:50:"...":true}">{$template_comments[id].comment_content}</a>
				<input type='hidden' name='old[{$template_comments[id].comment_id}]' id="comment-{$template_comments[id].comment_id}-old" value='{$template_comments[id].comment_status}'>
			</td>
			<td width="140px">{$template_comments[id].comment_date}</td>
			<td style="text-align:center;vertical-align:middle;"><input type="radio" name="comment[{$template_comments[id].comment_id}]" id="comment-{$template_comments[id].comment_id}" {if $template_comments[id].comment_status=='published'}checked{/if} value="published"></td>
			<td style="text-align:center;vertical-align:middle;"><input type="radio" name="comment[{$template_comments[id].comment_id}]" id="comment-{$template_comments[id].comment_id}" {if $template_comments[id].comment_status=='moderated'}checked{/if} value="moderated"></td>
			<td style="text-align:center;vertical-align:middle;"><input type="radio" name="comment[{$template_comments[id].comment_id}]" id="comment-{$template_comments[id].comment_id}" {if $template_comments[id].comment_status=='spam'}checked{/if} value="spam"></td>
			<td style="text-align:center;vertical-align:middle;"><input type="radio" name="comment[{$template_comments[id].comment_id}]" id="comment-{$template_comments[id].comment_id}" {if $template_comments[id].comment_status=='discard'}checked{/if} value="discard"></td>
		</tr>
		{/section}
	{/if}		
</table>
<div style="float:right;margin:8px 2px 0 0;">
	<a data-toggle="modal" class="btn btn-danger" href="{$my_base_url}{$my_pligg_base}/admin/admin_delete_comments.php" title="{#PLIGG_Visual_AdminPanel_Delete_Comments#}"><i class="icon-trash icon-white"></i> {#PLIGG_Visual_AdminPanel_Delete_Comments#}</a> 
	<input type="submit" class="btn btn-primary" name="submit" onclick="return confirm_spam()" value="{#PLIGG_Visual_AdminPanel_Apply_Changes#}" />
</div>
<div style="clear:both;"> </div>
</form>

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
		if (document.bulk_moderate[i].value == "moderated") {
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
		if ((document.bulk_moderate[i].value == "queued")||(document.bulk_moderate[i].value == "discard")||(document.bulk_moderate[i].value == "spam")|| (document.bulk_moderate[i].value == "publish")){
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
<!--/comments.tpl -->