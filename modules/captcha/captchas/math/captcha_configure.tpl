<legend>Math Captcha Settings</legend>

{if isset($msg)}
	<div class="alert fade in">
		<a data-dismiss="alert" class="close">&times;</a>
		{$msg}
	</div>
{/if}

<form>
	<input type="hidden" name="module" value="captcha">
	<input type="hidden" name="captcha" value="math">
	<input type="hidden" name="action" value="configure">
	Random number #1 should be between <input type="text" name="q_1_low" size="3" class="input-mini" value="{$q_1_low}"> and <input type="text" name="q_1_high" size="3" class="input-mini" value="{$q_1_high}"><br />
	Random number #2 should be between <input type="text" name="q_2_low" size="3" class="input-mini" value="{$q_2_low}"> and <input type="text" name="q_2_high" size="3" class="input-mini" value="{$q_2_high}"><br />
	<input type="submit" class="btn btn-primary" value="Submit Settings">
</form>

<hr />
<a href="{$URL_captcha}" class="btn">Return to the Captcha Settings Page</a>