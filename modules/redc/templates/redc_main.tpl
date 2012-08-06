{config_load file=redc_lang_conf}

<fieldset><legend> {#PLIGG_REDC#}</legend>
<p>{#PLIGG_REDC_Instructions#}</p>
	<form action="" method="POST" id="thisform">
		<table>
			<tbody>
				<tr>
					<td><label>{#PLIGG_REDC_Whitelist#}: &nbsp;</label></td>
					<td><input type="radio" name="redc_white_black" value="white" {if $settings.white_black=='white' || !isset($settings.white_black)}checked{/if}/></td>
				</tr>
				<tr>
					<td><label>{#PLIGG_REDC_Blacklist#}: &nbsp;</label></td>
					<td><input type="radio" name="redc_white_black" value="black" {if $settings.white_black=='black'}checked{/if}/></td>
				</tr>
				<tr>
					<td valign="top"><label>{#PLIGG_REDC_List#}: &nbsp;</label></td>
					<td><textarea name="redc_list" rows="15" style="width:300px;">{$settings.list}</textarea></td>
				</tr>
				<tr>
					<tr>
						<td></td>
						<td>
							<br /><input type="submit" name="submit" value="{#PLIGG_REDC_Submit#}" class="btn btn-primary" />
						</td>
					</tr>
				</tr>
			</tbody>
		</table>
	</form>
</fieldset>


{config_load file="/languages/lang_".$pligg_language.".conf"}
