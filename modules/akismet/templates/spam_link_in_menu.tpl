{config_load file=akismet_lang_conf}
	<li>
		<a href="{$URL_akismet}&view=manageSpam" class="main">
			<span> {if $menu_spam gt 0}<img src="{$akismet_img_path}exclamation.png" align="absmiddle"/> {/if}{$menu_spam} Spam </span>
		</a>
	</li>
{* this is a temporary fix. When you load a new config file the existing config gets dropped. *}
{config_load file=akismet_pligg_lang_conf}