<br />
<h2>Math Captcha Settings</h2>
<br />

	{if isset($msg)}
		<br />
		<p>
			<b>{$msg}</b>
		<p>
		<br />
	{/if}

<form>
	<input type="hidden" name="module" value="captcha">
	<input type="hidden" name="captcha" value="math">
	<input type="hidden" name="action" value="configure">
	Random number #1 should be between <input type="text" name="q_1_low" size="3" value="{$q_1_low}"> and <input type="text" name="q_1_high" size="3" value="{$q_1_high}"><br />
	Random number #2 should be between <input type="text" name="q_2_low" size="3" value="{$q_2_low}"> and <input type="text" name="q_2_high" size="3" value="{$q_2_high}"><br />
	<input type="submit" value="Submit Settings">
</form>
<br />
<a href="{$URL_captcha}">Return to the Captcha Settings Page</a>