{************************************
****** Second Sidebar Template ******
*************************************}
<!-- sidebar2.tpl -->
{checkActionsTpl location="tpl_pligg_sidebar_start"}
{checkActionsTpl location="tpl_pligg_sidebar_stories_u"}
{checkActionsTpl location="tpl_pligg_sidebar_stories"}
{checkActionsTpl location="tpl_pligg_sidebar_comments"}
{if $Enable_Tags && $pagename neq "cloud"}
	{assign var=sidebar_module value="tags"}
	{include file=$the_template_sidebar_modules."/wrapper.tpl"}
{/if}
{checkActionsTpl location="tpl_pligg_sidebar_end"}
<!--/sidebar2.tpl -->