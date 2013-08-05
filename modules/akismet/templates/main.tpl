{config_load file=akismet_lang_conf}
<fieldset>
	<legend>{#PLIGG_Akismet_BreadCrumb#}</legend>

	<h2>{#PLIGG_Akismet_settings_title#}</h2>

	<img src="{$akismet_img_path}key.png" align="absmiddle"/> <a href = "{$URL_akismet}&view=manageKey">{#PLIGG_Akismet_manage_key#}</a><br />
	{* <img src="{$akismet_img_path}wrench.png" align="absmiddle"/> <a href = "{$URL_akismet}&view=manageSettings">{#PLIGG_Akismet_change_settings#}</a><br /> *}
	
	<br />

	{if $spam_links_count eq 0}
		<img src="{$akismet_img_path}tick.png" align="absmiddle"/> {#PLIGG_Akismet_no_spam_stories#}
	{else}
		<img src="{$akismet_img_path}exclamation.png" align="absmiddle"/> <a href = "{$URL_akismet}&view=manageSpam">{$spam_links_count} {#PLIGG_Akismet_stories_need_reviewed#}</a>
	{/if}
	<br />
	{if $spam_comments_count eq 0}
		<img src="{$akismet_img_path}tick.png" align="absmiddle"/> {#PLIGG_Akismet_no_spam_comments#}
	{else}
		<img src="{$akismet_img_path}exclamation.png" align="absmiddle"/> <a href = "{$URL_akismet}&view=manageSpamcomments">{$spam_comments_count} {#PLIGG_Akismet_comments_need_reviewed#}</a>
	{/if}

</fieldset>
{config_load file=akismet_pligg_lang_conf}