{************************************
****** Second Sidebar Template ******
*************************************}
<!-- sidebar2.tpl -->

{section name=nrid loop=$dynBlocks}
	{if $dynBlocks[nrid].type eq 'include'}
		{include file=$the_template_sidebar_modules."/$dynBlocks[nrid].callback"}
	{elseif $dynBlocks[nrid].type eq 'module'} 
		{checkActionsTpl location="$dynBlocks[nrid].callback"}
	{/if} 
{/section}

<!--/sidebar2.tpl -->