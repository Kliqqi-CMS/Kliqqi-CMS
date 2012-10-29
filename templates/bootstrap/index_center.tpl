{************************************
***** Published Pages Template ******
*************************************}
<!-- index_center.tpl -->
{$link_summary_output}
{if !$link_summary_output}
	
{/if}
{checkActionsTpl location="tpl_pligg_pagination_start"}
{$link_pagination}
{checkActionsTpl location="tpl_pligg_pagination_end"}
<!--/index_center.tpl -->