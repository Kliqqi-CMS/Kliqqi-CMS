{config_load file=links_lang_conf}

	<script type="text/javascript">
		Event.observe(window, 'load', init, false);
		function init() {ldelim}{foreach from=$editinplace_init item=html}{$html}{/foreach}{rdelim}
	</script>

<fieldset><legend> {#PLIGG_links#}</legend>
<p>{#PLIGG_links_Instructions_1#}</p>
<p>{#PLIGG_links_Instructions_2#}</p>

	<form action="" method="POST" id="thisform">
		<table border="0">
		<tr>
		<td width="180"><label>{#PLIGG_links_Convert_Comments#}: </label></td><td><input type="checkbox" name="links_comments" value="1" {if $settings.comments}checked{/if}/></td>
		</tr>
		<tr>
		<td width="180"><label>{#PLIGG_links_Convert_Stories#}: </label></td><td><input type="checkbox" name="links_stories" value="1" {if $settings.stories}checked{/if}/></td>
		</tr>
		<tr>
		<td width="180"><label>{#PLIGG_links_Convert_Nofollow#}: </label></td><td><input type="checkbox" name="links_nofollow" value="1" {if $settings.nofollow}checked{/if}/></td>
		</tr>
		<tr>
	 	<tr><td colspan="2">
		<div class="submitbuttonfloat">
		<br />
			<input type="submit" name="submit" value="{#PLIGG_links_Submit#}" class="log2" />
		</div>
		</td></tr>
		</table>
	</form>
</fieldset>


{config_load file="/languages/lang_".$pligg_language.".conf"}
