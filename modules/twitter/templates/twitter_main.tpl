{config_load file=twitter_lang_conf}

{literal}
<style type="text/css">
input[readonly] { background:#EBDADA;cursor:help;}
</style>
{/literal}

<script type="text/javascript">
	Event.observe(window, 'load', init, false);
	function init() {ldelim}{foreach from=$editinplace_init item=html}{$html}{/foreach}{rdelim}
</script>

<legend>{#PLIGG_Twitter#}</legend>
<p>{#PLIGG_Twitter_Instructions#}</p>
<p>{#PLIGG_Twitter_Step_1_Instructions#}</p>
<pre class="prettyprint linenums">{$my_base_url}{$my_pligg_base}/modules/twitter/tweet.php?mode=callback</pre>
<form action="" method="POST" id="thisform">
	<table class="table table-bordered table-striped">
	<tr>
		<td width="240"><label>{#PLIGG_Twitter_Consumer_Key#}: </label></td><td><input type="text" class="span12" style="min-width:350px" name="twitter_consumer_key" value="{$settings.consumer_key}"/></td>
	</tr>
	<tr>
		<td width="240"><label>{#PLIGG_Twitter_Consumer_Secret#}: </label></td><td><input type="text" class="span12" style="min-width:350px" name="twitter_consumer_secre" value="{$settings.consumer_secret}"/></td>
	</tr>
	<tr>
		<td width="240"><label>{#PLIGG_BITLY_login#}: </label></td><td><input type="text" class="span12" style="min-width:350px" name="twitter_bitly_login" value="{$settings.bitly_login}"/></td>
	</tr>
	<tr>
		<td width="240"><label><a href="http://bit.ly/a/account" target="_blank">{#PLIGG_BITLY_API_KEY#}</a>: </label></td><td><input type="text" class="span12" style="min-width:350px" name="twitter_bitly_key" value="{$settings.bitly_key}"/></td>
	</tr>
	<tr>
		<td width="240"><label>{#PLIGG_Twitter_When_Twitter#}: </label></td><td><input type="radio" name="twitter_when_twitter" value="submitted" {if $settings.when_twitter == 'submitted'}checked{/if}/> {#PLIGG_Twitter_Submitted#}<br>
		<input type="radio" name="twitter_when_twitter" value="published" {if $settings.when_twitter == 'published'}checked{/if}/> {#PLIGG_Twitter_Published#}<br>
		<input type="radio" name="twitter_when_twitter" value="never" {if $settings.when_twitter == 'never'}checked{/if}/> {#PLIGG_Twitter_Never#}
		</td>
	</tr>
	<tr>
		<tr>
			<td></td>
			<td>
				<input type="submit" name="submit" value="{#PLIGG_Twitter_Submit#}" class="btn btn-primary" />
			</td>
		</tr>
	</tr>
	</table>
</form>

{config_load file="/languages/lang_".$pligg_language.".conf"}
