<!-- admin_banned_domain_add.tpl -->
<legend>{#PLIGG_Visual_Ban_This_URL#}</legend>
{if $errorText neq ""}
    <div class="alert alert-block">
		{$errorText}
    </div>
{else}
	<h3>{#PLIGG_Visual_This_Will_Ban#}"{$domain_to_ban}." {#PLIGG_Visual_Are_You_Sure#}</h3>
	<p>
		<a class="btn btn-danger" href="?id={$story_id}&doban={$domain_to_ban}">{#PLIGG_Visual_Ban_Link_Yes#}</a>&nbsp;&nbsp;
		<a class="btn" href="javascript:history.back()">{#PLIGG_Visual_Ban_Link_No#}</a>
	</p>
{/if}
<!--/admin_banned_domain_add.tpl -->