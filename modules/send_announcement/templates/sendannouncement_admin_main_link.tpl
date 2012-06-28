{config_load file=send_announcement_lang_conf}
<li{if $modulename eq "sendannouncement"} class="active"{/if}><a href="{$my_pligg_base}/module.php?module=sendannouncement">{* <img src="{$my_pligg_base}/templates/admin/images/email.gif" align="absmiddle"/> *}{#Pligg_Send_Announcemet#}</a></li>
{config_load file=send_announcement_pligg_lang_conf}