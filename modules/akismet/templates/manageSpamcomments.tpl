{config_load file=akismet_lang_conf}
<fieldset>
	<legend><img src="{$akismet_img_path}shield.png" align="absmiddle"/> {#PLIGG_Akismet_manage_comments#}</legend>
	<a href="{$URL_akismet}">{#PLIGG_Akismet_return#}</a><br /><br />
	
	{if count($link_data) gt 0}
		{$spam_output}
	{/if}
	
</fieldset>
{config_load file=akismet_pligg_lang_conf}

{literal}
<SCRIPT>
function mark_all_spam() {
	document.bulk_moderate.all1.checked=1;
	document.bulk_moderate.all2.checked=0;
	for (var i=0; i< document.bulk_moderate.length; i++) {
		if (document.bulk_moderate[i].value == "spamcomment") {
			document.bulk_moderate[i].checked = true;
		}
	}
}
function mark_all_notspam() {
	document.bulk_moderate.all1.checked=0;
	document.bulk_moderate.all2.checked=1;
	for (var i=0; i< document.bulk_moderate.length; i++) {
		if (document.bulk_moderate[i].value == "notspamcomment") {
			document.bulk_moderate[i].checked = true;
		}
	}
}
</SCRIPT>
{/literal}