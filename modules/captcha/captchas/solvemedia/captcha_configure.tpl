{config_load file=captcha_lang_conf}

<legend>SolveMedia Configuration</legend>

{if isset($msg)}
	<div class="alert alert-warning fade in">
		<a data-dismiss="alert" class="close">&times;</a>
		{$msg}
	</div>
{/if}

<form>
	<input type="hidden" name="module" value="captcha">
	<input type="hidden" name="captcha" value="solvemedia">
	<input type="hidden" name="action" value="configure">
	
	<p>Pligg CMS uses special API keys for Solve Media's CAPTCHA which allows us to enable their product across all Pligg domains. These API keys are set by default, so that you don't need to configure anything to make use of Solve Media. Please be aware that we collect a small amount of data about your website related to CAPTCHA impressions and completions. This allows us to keep an eye on how Pligg CAPTCHAs perform. The API key also generates a small profit from embedded CAPTCHAs, which we use to help fund Pligg development.</p>
	<p>If you would like to use your own Solve Media API keys, enter them in the fields below. You can sign up and find your own API keys from the <a href="http://portal.solvemedia.com/portal/public/signup">Solve Media portal</a> website.</p>
	<br />
	<table class="table table-bordered table-striped" cellpadding="0" cellspacing="0">
		<thead>
			<tr><th colspan="2">{#Pligg_Captcha_Solve_Media#} Settings</th><tr>
		</thead>
		<tbody>
			<tr>
				<td>
					Public Key: 
				</td>
				<td>
					<input type="text" class="form-control" name="pubkey" size="100" value="{$captcha_pubkey}">
				</td>
			</tr>
			<tr>
				<td>
					Private Key:
				</td>
				<td>
					<input type="text" class="form-control" name="privkey" size="100" value="{$captcha_privkey}">
				</td>
			</tr>
			<tr>
				<td>
					Hash Key:
				</td>
				<td>
					<input type="text" class="form-control" name="hashkey" size="100" value="{$captcha_hashkey}">
				</td>
			</tr>
			<tr>
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
<a class="btn btn-default" href="{$URL_captcha}"><i class="fa fa-arrow-left"></i> Return to the Captcha Settings Page</a>
{config_load file=captcha_pligg_lang_conf}