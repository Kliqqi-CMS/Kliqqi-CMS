{config_load file=tweet_lang_conf}

{literal}
<style type="text/css">
input[readonly] { background:#EBDADA;cursor:help;}
h3 {margin:2px 0 0 0;padding:0;}
hr {background:#CCCCCC;border-top:1px solid #C2C2C2;border-bottom:1px solid #DBDBDB;}
</style>
{/literal}
	<script type="text/javascript">
		Event.observe(window, 'load', init, false);
		function init() {ldelim}{foreach from=$editinplace_init item=html}{$html}{/foreach}{rdelim}
	</script>

<legend> {#PLIGG_Tweet#}</legend>
<p>{#PLIGG_Tweet_Instructions#}</p>
<hr />

<form action="" method="POST" id="thisform">
	<table border="0" width=100%>
	<tr>
		<td colspan="2">
			<h3>{#PLIGG_Tweet_Step_1#}</h3>
			<p>{#PLIGG_Tweet_Step_1_Instructions#}
			<br /><br />
			<span style="font-style:italic;margin-left:15px;">{$my_base_url}{$my_pligg_base}/modules/tweet/tweet.php?mode=callback</span>
			</p>
		</td>
	</tr>
	<tr>
		<td width="238"><label>{#PLIGG_Tweet_Consumer_Key#}: </label></td><td><input type="text" class="span7" size="80" name="tweet_consumer_key" value="{$settings.consumer_key}"/></td>
	</tr>
	<tr>
		<td width="238"><label>{#PLIGG_Tweet_Consumer_Secret#}: </label></td><td><input type="text" class="span7" size="80" name="tweet_consumer_secre" value="{$settings.consumer_secret}"/></td>
	</tr>
	<tr>
		<td colspan="2">
			<hr />
			<h3>{#PLIGG_Tweet_Step_2#}</h3>
			<p>{#PLIGG_Tweet_Step_2_Instructions#}
				<br /><br /><a href='modules/tweet/tweet.php?mode=start' class="btn btn-primary">{#PLIGG_Tweet_Click_Here#}</span></a>
				<br /><br />
			</p>
		</td>
	</tr>
	<tr>
		<td width="238"><label>{#PLIGG_Tweet_Access_Key#}: </label></td>
		<td><input type="text" name="tweet_access_key" class="span7" size="80" value="{$settings.access_key}" readonly/></td>
	</tr>
	<tr>
		<td width="238"><label>{#PLIGG_Tweet_Access_Secret#}: </label></td><td><input type="text" class="span7" size="80" name="tweet_access_secret" value="{$settings.access_secret}" readonly/></td>
	</tr>
	<tr>
		<td colspan="2">
			<hr />
			<h3>{#PLIGG_Tweet_Bitly#}</h3>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<p>{#PLIGG_Tweet_Bitly_Description#}</p>
		</td>
	</tr>
	<tr>
		<td width="238"><label>{#PLIGG_BITLY_login#}: </label></td><td><input type="text" name="tweet_bitly_login" class="span7" size="80" value="{$settings.bitly_login}"/></td>
	</tr>
	<tr>
		<td width="238"><label><a href="http://bit.ly/a/account" target="_blank">{#PLIGG_BITLY_API_KEY#}</a>: </label></td><td><input type="text" name="tweet_bitly_key" class="span7" size="80" value="{$settings.bitly_key}"/></td>
	</tr>
	<tr>
		<td colspan="2">
			<hr />
			<h3>{#PLIGG_Tweet_Settings#}</h3>
		</td>
	</tr>
	<tr>
		<td width="238"><label>{#PLIGG_Tweet_When_Tweet#}: </label></td><td><input type="radio" name="tweet_when_tweet" value="submitted" {if $settings.when_tweet == 'submitted'}checked{/if}/> {#PLIGG_Tweet_Submitted#}<br>
		<input type="radio" name="tweet_when_tweet" value="published" {if $settings.when_tweet == 'published'}checked{/if}/> {#PLIGG_Tweet_Published#}
		</td>
	</tr>
	<tr>
		<td width="238"><label>{#PLIGG_Tweet_From_Users#}: </label></td><td><input type="text" class="span7" size="80" name="tweet_from_users" value="{$settings.from_users}"/></td>
	</tr>

	<tr>
		<tr>
			<td colspan="2">
				<div class="submitbuttonfloat">
					<br />
					<input type="submit" name="submit" value="{#PLIGG_Tweet_Submit#}" class="log2" />
				</div>
			</td>
		</tr>
	</tr>
	</table>
</form>


{config_load file="/languages/lang_".$pligg_language.".conf"}
