<!-- banned_domains.tpl -->
<legend>{#PLIGG_Visual_Ban_This_URL_List_All2#} {if $lines|@count != '0'}({$lines|@count} total){/if}</legend>
{if $errorText neq ""}
    <div class="alert alert-block">
		{$errorText}
    </div>
{/if}
<ol>
	{section name=line loop=$lines}
		<li><a href="manage_banned_domains.php?id=0&remove={$lines[line]}">Remove</a> - {$lines[line]} </li>
	{/section}
	
</ol>
<!--/banned_domains.tpl -->