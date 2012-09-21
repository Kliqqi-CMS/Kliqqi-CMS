<!-- banned_domains.tpl -->
<legend>{#PLIGG_Visual_Ban_This_URL_List_All2#} ({$lines|@count} total)</legend>
{if $errorText neq ""}
    <div class="alert alert-block">
		{$errorText}
    </div>
{/if}
<ol>
	{section name=line loop=$lines}
		<li>{$lines[line]}</li>
	{/section}
	
</ol>
<!--/banned_domains.tpl -->