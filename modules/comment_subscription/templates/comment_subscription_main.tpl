{config_load file=comment_subscription_lang_conf}

{if $templatelite.post.submit}
	<div class="alert alert-success">
		<button class="close" data-dismiss="alert">×</button>
		{#PLIGG_Comment_Subscription_Saved#}
    </div>
{/if}

<legend> {#PLIGG_Comment_Subscription#}</legend>
<p>{#PLIGG_Comment_Subscription_Instructions#}</p>

<form action="" method="POST" id="thisform">
	<table class="table table-bordered table-striped">
		<tr>
			<td width="180"><label>{#PLIGG_Comment_Subscription_From#}: </label></td><td><input type="text" name="comment_subscription_from" value="{$settings.from}" size="40"/></td>
		</tr>
		<tr>
			<td width="180"><label>{#PLIGG_Comment_Subscription_From_Email#}: </label></td><td><input type="text" name="comment_subscription_from_email" value="{$settings.from_email}" size="40"/></td>
		</tr>
		<tr>
			<td width="180"><label>{#PLIGG_Comment_Subscription_Subject#}: </label></td><td><input type="text" name="comment_subscription_subject" value="{$settings.subject}" size="40"/></td>
		</tr>
		<tr>
			<td></td>
			<td>
				<input type="submit" name="submit" value="{#PLIGG_Comment_Subscription_Submit#}" class="btn btn-primary" />
			</td>
		</tr>
	</table>
</form>

{config_load file="/languages/lang_".$pligg_language.".conf"}