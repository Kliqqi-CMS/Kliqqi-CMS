{************************************
***** Published Pages Template ******
*************************************}
<!-- index_center.tpl -->
{$link_summary_output}

{if !$link_summary_output && $pagename == 'index' && count($templatelite.get) == 0}
	{* Welcome message for new installations *}
	<div style="padding:12px 25px;" class="hero-unit">
		<h2>Welcome to Pligg CMS!</h2>
		<p style="font-size:1.0em;">It looks like you've just set up a new Pligg website. Now would be a good time to submit your first article and then publish it to the homepage.</p>
		<p><a href="submit.php" class="btn btn-primary">Submit Your First Entry</a></p>
	</div>
{/if}

{checkActionsTpl location="tpl_pligg_pagination_start"}
{$link_pagination}
{checkActionsTpl location="tpl_pligg_pagination_end"}
<!--/index_center.tpl -->