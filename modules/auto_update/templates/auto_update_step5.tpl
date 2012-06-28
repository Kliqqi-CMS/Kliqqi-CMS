{config_load file=auto_update_lang_conf}

<fieldset><legend> {#AUTO_UPDATE_TITLE#}</legend>

<p>{#AUTO_UPDATE_STEP5_DESCRIPTION#}</p>
<script>
var finished = "{#AUTO_UPDATE_FINISHED_OK#}";
var submitted = 0;
var loaded = 0;
{literal}
function getStatus()
{
    document.getElementById('status').innerHTML="<font color=green>" + finished +"</font>";
}
{/literal}
</script>

{#AUTO_UPDATE_UNZIPPED#}
<br>
<span id='status'></span>
<br>
{if $upgrade_exists}
	<iframe width=90% height="500" src='install/upgrade.php' name="upload_iframe" !onload="if (++loaded>1) getStatus();" id="upload_iframe" !style='display:none;'></iframe> 
{else}
	<font color=red>{#AUTO_UPDATE_FILE_NOT_FOUND#|sprintf:'/install/upgrade.php'#}</font>
{/if}

<hr />

<a href='?module=auto_update&step=6' style="border:1px solid #ccc;background:#0A5089;color:#fff;padding:6px 8px;float:left;color:#fff;display:block;">{#AUTO_UPDATE_CONTINUE_STEP6#}</a><br style="clear:both;" />

</fieldset>
{config_load file=auto_update_pligg_lang_conf}