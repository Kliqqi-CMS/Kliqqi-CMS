{config_load file=fb_lang_conf}

	<script type="text/javascript">
		Event.observe(window, 'load', init, false);
		function init() {ldelim}{foreach from=$editinplace_init item=html}{$html}{/foreach}{rdelim}
	</script>

<legend> {#PLIGG_FB#}</legend>
<p>{#PLIGG_FB_Instructions_1#}</p>
<p>{#PLIGG_FB_Instructions_2#}</p>

{if $templatelite.post.fb_key}
	<div class="alert alert-success fade in">
		<a data-dismiss="alert" class="close">&times;</a>
		{#PLIGG_FB_Saved#}
	</div>
{/if}

<form action="" method="POST" id="thisform">
	<table class="table table-bordered table-striped">
		<tbody>
			<tr>
				<td width="180"><label>{#PLIGG_FB_Key#}:</label></td>
				<td><input type="text" name="fb_key" id="fb_key" class="span12" style="min-width:350px" value="{$settings.key}"/></td>
			</tr>
			<tr>
				<td><label>{#PLIGG_FB_Secret#}:</label></td>
				<td><input type="text" name="fb_secret" id="fb_secret" class="span12" style="min-width:350px" value="{$settings.secret}"/></td>
			</tr>
			<tr>
				<td></td>
				<td>
					<div class="submitbuttonfloat">
						<input type="submit" name="submit" value="{#PLIGG_FB_Submit#}" class="btn btn-primary" />
					</div>
				</td>
			</tr>
		</tbody>
	</table>
</form>
<p>Need a Facebook API Key? <a href="http://www.facebook.com/developers/createapp.php">Click here to set one up</a>.</p>


{config_load file=fb_pligg_lang_conf}
