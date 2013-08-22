<!-- domain_whitelist_add.tpl -->
<legend>Add {$domain_to_add|capitalize} to Whitelist</legend>
{if $errorText neq ""}
    <div class="alert alert-danger">
		{$errorText}
    </div>
{else}
	<p>Clicking on the "Yes" button below will add <strong>{$domain_to_add}</strong> to the Whitelist file, preventing the domain from accidentally being banned.</p>
	<p>
		<a class="btn btn-danger" href="?id={$story_id}&dowhitelist={$domain_to_add}">{#PLIGG_Visual_Ban_Link_Yes#}</a>&nbsp;&nbsp;
		<a class="btn btn-default" href="javascript:history.back()">{#PLIGG_Visual_Ban_Link_No#}</a>
	</p>
{/if}
<!--/domain_whitelist_add.tpl -->