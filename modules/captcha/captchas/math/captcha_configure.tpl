<legend>Math Captcha Settings</legend>

{if isset($msg)}
	<div class="alert alert-error fade in">
		<a data-dismiss="alert" class="close">&times;</a>
		{$msg}
	</div>
{/if}

<form>
	<input type="hidden" name="module" value="captcha">
	<input type="hidden" name="captcha" value="math">
	<input type="hidden" name="action" value="configure">
    <div class="control-group">
		<label class="control-label">Random number #1 should be between</label>
		<div class="controls">
		<input type="text" name="q_1_low" size="3" class="form-control input-sm" style="display:inline;width:100px;" value="{$q_1_low}"> 
		and 
		<input type="text" name="q_1_high" size="3" class="form-control input-sm" style="display:inline;width:100px;" value="{$q_1_high}">		
		</div>
    </div>
	<br />
    <div class="control-group">
		<label class="control-label">Random number #2 should be between</label>
		<div class="controls">
		<input type="text" name="q_2_low" size="3" class="form-control input-sm" style="display:inline;width:100px;" value="{$q_2_low}"> 
		and 
		<input type="text" name="q_2_high" size="3" class="form-control input-sm" style="display:inline;width:100px;" value="{$q_2_high}">		
		</div>
    </div>
	<br />
	<input type="submit" class="btn btn-primary" value="Submit Settings">
</form>

<hr />
<a href="{$URL_captcha}" class="btn btn-default">Return to the Captcha Settings Page</a>