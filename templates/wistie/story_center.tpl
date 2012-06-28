{if $pagename eq "story"}<br />{/if}

{$the_story}

<br/>

{checkActionsTpl location="tpl_pligg_story_who_voted_start"}
<div id="who_voted">
	<h2>{#PLIGG_Visual_Story_WhoVoted#}</h2>
	<div class="whovotedwrapper" id="idwhovotedwrapper">
		<ol>
			{section name=nr loop=$voter}
				<li>
					{if $UseAvatars neq "0"}<img src="{$voter[nr].Avatar_ImgSrc}" alt="Avatar" align="top" />{/if} 
					<a href = "{$URL_user, $voter[nr].user_login}">{$voter[nr].user_login}</a><br/>
				</li>
			{/section}
		</ol>
	</div>
</div>
{checkActionsTpl location="tpl_pligg_story_who_voted_end"}

<br style="clear:both" />
{if count($related_story) neq 0}
{checkActionsTpl location="tpl_pligg_story_related_start"}
<div id="related">
	<h2>{#PLIGG_Visual_Story_RelatedStory#}</h2>	
	<ol>
		{section name=nr loop=$related_story}
			<li><a href = "{$related_story[nr].url}">{$related_story[nr].link_title}</a><br/></li> 
		{/section}
	</ol>
</div>
{checkActionsTpl location="tpl_pligg_story_related_end"}
{/if}

{checkActionsTpl location="tpl_pligg_story_comments_start"}
<div id="comments">
	<form action="" method="post" id="thisform">
		<h3><a name="comments" class="comments_title">{#PLIGG_Visual_Story_Comments#}</a></h3>
		{checkActionsTpl location="tpl_pligg_story_comments_individual_start"}
			{$the_comments}
		{checkActionsTpl location="tpl_pligg_story_comments_individual_end"}
		{if $user_authenticated neq ""}
			{include file=$the_template."/comment_form.tpl"}
		{else}
			<br/>
			{checkActionsTpl location="anonymous_comment_form"}
			<div align="center" class="login_to_comment">
				<a href="{$login_url}">{#PLIGG_Visual_Story_LoginToComment#}</a> {#PLIGG_Visual_Story_Register#} <a href="{$register_url}">{#PLIGG_Visual_Story_RegisterHere#}</a>.
			</div>
		{/if}
	</form>
</div>
{checkActionsTpl location="tpl_pligg_story_comments_end"}
