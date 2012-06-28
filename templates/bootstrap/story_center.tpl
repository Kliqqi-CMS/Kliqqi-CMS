{$the_story}

<ul class="nav nav-tabs" id="storytabs">
	<li class="active"><a data-toggle="tab" href="#comments">{#PLIGG_Visual_Story_Comments#}</a></li>
	<li><a data-toggle="tab" href="#who_voted">{#PLIGG_Visual_Story_WhoVoted#}</a></li>
	{if count($related_story) neq 0}<li><a data-toggle="tab" href="#related">{#PLIGG_Visual_Story_RelatedStory#}</a></li>{/if}
	{checkActionsTpl location="tpl_pligg_story_tab_end"}
</ul>
	
{literal}
<script>
$(function () {
	$('#storytabs a[href="#comments"]').tab('show');
	$('#storytabs a[href="#who_voted"]').tab('show');
	$('#storytabs a[href="#related"]').tab('show');
})
</script>
{/literal}

<div id="tabbed" class="tab-content">

	<div class="tab-pane fade active in" id="comments" >
		<h3>{#PLIGG_Visual_Story_Comments#}</h3>
		<a name="comments" href="#comments"></a>
		{checkActionsTpl location="tpl_pligg_story_comments_start"}
		<form action="" method="post" id="thisform">
			<ol class="comment-list">	
				{checkActionsTpl location="tpl_pligg_story_comments_individual_start"}
					{$the_comments}
				{checkActionsTpl location="tpl_pligg_story_comments_individual_end"}
				{if $user_authenticated neq ""}
					{include file=$the_template."/comment_form.tpl"}
				{else}
					{checkActionsTpl location="anonymous_comment_form"}
					<div align="center" class="login_to_comment">
						<a href="{$login_url}">{#PLIGG_Visual_Story_LoginToComment#}</a> {#PLIGG_Visual_Story_Register#} <a href="{$register_url}">{#PLIGG_Visual_Story_RegisterHere#}</a>.
					</div>
				{/if}
			</ol>	
		</form>
		{checkActionsTpl location="tpl_pligg_story_comments_end"}
	</div>
	
	<div class="tab-pane fade" id="who_voted">
		<h3>{#PLIGG_Visual_Story_WhoVoted#}</h3>
		{checkActionsTpl location="tpl_pligg_story_who_voted_start"}
		<div class="whovotedwrapper">
			<ul>
				{section name=nr loop=$voter}
					<li>
						{if $UseAvatars neq "0"}<a href="{$URL_user, $voter[nr].user_login}"><img src="{$voter[nr].Avatar_ImgSrc}" alt="" align="top" title="{$voter[nr].user_login}" /></a>{/if} 
						{if $UseAvatars eq "0"}<a href="{$URL_user, $voter[nr].user_login}">{$voter[nr].user_login}</a>{/if}
					</li>
				{/section}
			</ul>
		</div>
		{checkActionsTpl location="tpl_pligg_story_who_voted_end"}
	</div>


	{if count($related_story) neq 0}
		<div class="tab-pane fade" id="related">
			<h3>{#PLIGG_Visual_Story_RelatedStory#}</h3>
			{checkActionsTpl location="tpl_pligg_story_related_start"}
			<ol>
				{* The next line checks how many related stories there are.  If there are fewer than 10 it will set the return loop to a smaller number. *}
				{if count($related_story) > 10}{assign var="related_count" value="10"}{else}{assign var="related_count" value=$related_story}{/if}
				{section name=nr loop=$related_count}
					<li><a href = "{$related_story[nr].url}">{$related_story[nr].link_title}</a></li> 
				{/section}
			</ol>
			{checkActionsTpl location="tpl_pligg_story_related_end"}
		</div>
	{/if}
	
	{checkActionsTpl location="tpl_pligg_story_tab_end_content"}
	
</div>