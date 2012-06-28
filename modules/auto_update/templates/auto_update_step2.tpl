{config_load file=auto_update_lang_conf}
<fieldset><legend> {#AUTO_UPDATE_TITLE#}</legend>

<p>{#AUTO_UPDATE_STEP2_DESCRIPTION#}</p>

<script>
var mysql=0, files=0;
</script>

{#AUTO_UPDATE_DOWNLOAD_MYSQL#}: {if $gzip}<a href='?module=auto_update&download=mysql&type=gzip' onclick='mysql=1'>gzip</a>{/if} <a href='?module=auto_update&download=mysql&type=zip' onclick='mysql=1'>zip</a> <a href='?module=auto_update&download=mysql' onclick='mysql=1'>text</a><br />
{#AUTO_UPDATE_DOWNLOAD_FILES#}: <a href='?module=auto_update&download=files&type=gzip' onclick='files=1'>gzip</a> <a href='?module=auto_update&download=files&type=zip' onclick='files=1'>zip</a><br />


<hr />

<a href='?module=auto_update&step=3' onclick='if (!mysql || !files) return confirm("{#AUTO_UPDATE_CONFIRM_STEP3#}");' style="border:1px solid #ccc;background:#0A5089;color:#fff;padding:6px 8px;float:left;color:#fff;display:block;">{#AUTO_UPDATE_CONTINUE_STEP3#}</a><br style="clear:both;" />

</fieldset>
{config_load file=auto_update_pligg_lang_conf}