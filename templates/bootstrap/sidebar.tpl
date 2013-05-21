{************************************
****** First Sidebar Template *******
*************************************}
<!-- sidebar.tpl -->
{if $pagename neq "submit"}
	{checkActionsTpl location="tpl_pligg_sidebar2_start"}
	<!-- START SEARCH BOX -->
		{include file=$the_template."/search_box.tpl"}
	<!-- END SEARCH BOX -->
	{checkActionsTpl location="tpl_pligg_sidebar_middle"}
	<!-- START ABOUT BOX -->
		{include file=$the_template."/about_box.tpl"}
	<!-- END ABOUT BOX -->
	{checkActionsTpl location="tpl_pligg_sidebar2_end"}
{/if}
<!--/sidebar.tpl -->