{config_load file=captcha_lang_conf}

<legend>SolveMedia Configuration</legend>

{if isset($msg)}
	<div class="alert fade in">
		<a data-dismiss="alert" class="close">&times;</a>
		{$msg}
	</div>
{/if}

<form>
	<input type="hidden" name="module" value="captcha">
	<input type="hidden" name="captcha" value="solvemedia">
	<input type="hidden" name="action" value="configure">
	
	{* A 'Public Key', a 'Private Key', and a 'Hash Key' are required. Sign up at the <a href="http://portal.solvemedia.com/portal/public/signup">Solve Media portal</a> to obtain them.<br /> *}
	To change your Solve Media settings, change the fields below and click on the Save Settings button.<br />
	<br />
	<table class="table table-bordered table-striped" cellpadding="0" cellspacing="0">
		<thead>
			<tr><th colspan="2">{#Pligg_Captcha_Solve_Media#} Settings</th><tr>
		</thead>
		<tbody>
			{*
			<tr>
				<td>
					Public Key: 
				</td>
				<td>
					<input type="text" name="pubkey" size="100" value="{$captcha_pubkey}">
				</td>
			</tr>
			<tr>
				<td>
					Private Key:
				</td>
				<td>
					<input type="text" name="privkey" size="100" value="{$captcha_privkey}">
				</td>
			</tr>
			<tr>
				<td>
					Hash Key:
				</td>
				<td>
					<input type="text" name="hashkey" size="100" value="{$captcha_hashkey}">
				</td>
			</tr>
			<tr>
			*}
				<td>
					Theme:
				</td>
				<td>
					<select name="theme" class="form-control">
						<option value="white" <?php echo get_misc_data('adcopy_theme') == 'white' ? 'selected="selected"' : '' ?> >White</option> 
						<option value="black" <?php echo get_misc_data('adcopy_theme') == 'black' ? 'selected="selected"' : '' ?> >Black</option> 
						<option value="red" <?php echo get_misc_data('adcopy_theme') == 'red' ? 'selected="selected"' : '' ?> >Red</option> 
						<option value="purple" <?php echo get_misc_data('adcopy_theme') == 'purple' ? 'selected="selected"' : '' ?> >Purple</option> 
					</select>
				</td>
			</tr>
			<tr>
				<td>
					Language:
				</td>
				<td>
					<select name="lang" class="form-control">
						<option value="en" <?php echo get_misc_data('adcopy_lang') == 'en' ? 'selected="selected"' : '' ?> >English</option> 
						<option value="de" <?php echo get_misc_data('adcopy_lang') == 'de' ? 'selected="selected"' : '' ?> >German</option> 
						<option value="fr" <?php echo get_misc_data('adcopy_lang') == 'fr' ? 'selected="selected"' : '' ?> >French</option> 
						<option value="es" <?php echo get_misc_data('adcopy_lang') == 'es' ? 'selected="selected"' : '' ?> >Spanish</option> 
						<option value="it" <?php echo get_misc_data('adcopy_lang') == 'it' ? 'selected="selected"' : '' ?> >Italian</option> 
						<option value="yi" <?php echo get_misc_data('adcopy_lang') == 'yi' ? 'selected="selected"' : '' ?> >Yiddish</option> 
					</select>
				</td>
			<tr>
				<td></td>
				<td><input type="submit" class="btn btn-primary" value="{#Pligg_Captcha_Save_Settings#}"></td>
			</tr>
		</tbody>
	</table>
</form>
<br />
<a class="btn btn-default" href="{$URL_captcha}"><i class="icon icon-arrow-left"></i> Return to the Captcha Settings Page</a>
{config_load file=captcha_pligg_lang_conf}