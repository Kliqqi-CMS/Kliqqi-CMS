<!-- domain_blacklist_add.tpl -->
<legend>Add {$domain_to_add|capitalize} to Blacklist?</legend>
{if $errorText neq ""}
    <div class="alert alert-danger">
		{$errorText}
    </div>
{else}
	<p>Clicking on the "Yes" button below will add <strong>{$domain_to_add}</strong> to the Blacklist file, making it so that users cannot submit articles from this domain.</p>
	<p>
		<a class="btn btn-danger" href="?id={$story_id}&doblacklist={$domain_to_add}">{#PLIGG_Visual_Ban_Link_Yes#}</a>&nbsp;&nbsp;
		<a class="btn btn-default" href="javascript:history.back()">{#PLIGG_Visual_Ban_Link_No#}</a>
	</p>
{/if}
<!--/domain_blacklist_add.tpl -->