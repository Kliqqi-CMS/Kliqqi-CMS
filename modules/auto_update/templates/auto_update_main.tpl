{config_load file=auto_update_lang_conf}
<fieldset><legend> {#AUTO_UPDATE_TITLE#} </legend>

{#AUTO_UPDATE_STEP1_DESCRIPTION#}
{#AUTO_UPDATE_STEP2_DESCRIPTION#}
{#AUTO_UPDATE_STEP3_DESCRIPTION#|sprintf:$yourversion:$latestversion}
{#AUTO_UPDATE_STEP4_DESCRIPTION#}
{#AUTO_UPDATE_STEP5_DESCRIPTION#}
{#AUTO_UPDATE_STEP6_DESCRIPTION#}
<hr />

<a href='?module=auto_update&step=2' style="border:1px solid #ccc;background:#0A5089;color:#fff;padding:6px 8px;float:left;color:#fff;display:block;">{#AUTO_UPDATE_CONTINUE_STEP2#}</a><br style="clear:both;" />

</fieldset>
{config_load file=auto_update_pligg_lang_conf}