{*Eval here*}
{foreach from=$snippet_actions_tpl item=snippet1}
{*$snippet1.snippet_location*}
    {if $snippet1.snippet_location == $location}
{*$snippet1.snippet_content*}
	{eval var=$snippet1.snippet_content}
    {/if}
{/foreach}
