{config_load file=akismet_lang_conf}
<li{if $modulename eq "akismet"} class="active"{/if}>{*<img src="{$akismet_img_path}shield.png" align="absmiddle"/> *}<a href="{$URL_akismet}">{#PLIGG_Akismet_BreadCrumb#}</a></li>
{config_load file=akismet_pligg_lang_conf}
