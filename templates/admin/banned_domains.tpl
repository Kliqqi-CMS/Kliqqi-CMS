<!-- banned_domains.tpl -->
<legend>{#PLIGG_Visual_Ban_This_URL_List_All2#} {if $lines|@count != '0'}({$lines|@count} total){/if}</legend>
{if $errorText neq ""}
    <div class="alert alert-block">
		{$errorText}
    </div>
{/if}
<p>Want to quickly add a domain to the list? Use this form to add a custom domain.</p>

<form action="manage_banned_domains.php" method="get">
    <input type="text" name="add" placeholder="domain.com">
	<button type="submit" class="btn btn-danger">Ban Domain</button>
</form>

<ol>
	{section name=line loop=$lines}
		<li><a href="manage_banned_domains.php?id=0&remove={$lines[line]}">Remove</a> - {$lines[line]} </li>
	{/section}
	
</ol>
<!--/banned_domains.tpl -->