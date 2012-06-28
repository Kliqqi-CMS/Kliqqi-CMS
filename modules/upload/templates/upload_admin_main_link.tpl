{config_load file=upload_lang_conf}
<li{if $modulename eq "upload"} class="active"{/if}><a href="{$my_pligg_base}/module.php?module=upload">{* <img src="{$my_pligg_base}/modules/upload/templates/upload.gif" align="absmiddle"/>  *}{#PLIGG_Upload#}</a></li>
{config_load file=upload_pligg_lang_conf}