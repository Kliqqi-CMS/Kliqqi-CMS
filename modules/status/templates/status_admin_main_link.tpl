{config_load file=status_lang_conf}
<li{if $modulename eq "status"} class="active"{/if}><a href="{$my_pligg_base}/module.php?module=status">{#PLIGG_Status#}</a></li>
{config_load file=status_pligg_lang_conf}