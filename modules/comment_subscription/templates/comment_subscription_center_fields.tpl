{config_load file=comment_subscription_lang_conf}
<table class="table table-bordered table-striped span4">
	<thead class="table_title">
		<tr>
			<td colspan="2"><strong>{#PLIGG_Comment_Subscription_Title#}</strong></td>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td><input type="checkbox" name="comment_subscription" id="comment_subscription" value="1" {if $comment_subscription}checked{/if}/></td>
			<td><label>{#PLIGG_Comment_Subscription_Switch#}</label></td>
		</tr>
	</tbody>
</table>
{config_load file="/languages/lang_".$pligg_language.".conf"}
