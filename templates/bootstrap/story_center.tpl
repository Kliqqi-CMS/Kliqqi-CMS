{************************************
****** Story Wrapper Template *******
*************************************}
<!-- story_center.tpl -->
{$the_story}
<ul class="nav nav-tabs" id="storytabs">
	<li class="active"><a data-toggle="tab" href="#comments"><i class="fa fa-comments"></i> {#PLIGG_Visual_Story_Comments#}</a></li>
	{if count($voter) neq 0}<li><a data-toggle="tab" href="#who_voted"><i class="fa fa-thumbs-up"></i> {#PLIGG_Visual_Story_Who_Upvoted#}</a></li>{/if}
	{if count($downvoter) neq 0}<li><a data-toggle="tab" href="#who_downvoted"><i class="fa fa-thumbs-down"></i> {#PLIGG_Visual_Story_Who_Downvoted#}</a></li>{/if}
	{if count($related_story) neq 0}<li><a data-toggle="tab" href="#related"><i class="fa fa-tag"></i> {#PLIGG_Visual_Story_RelatedStory#}</a></li>{/if}
	{checkActionsTpl location="tpl_pligg_story_tab_end"}
</ul>
<script language="javascript">
var story_link="{$story_url}";
{literal}

	$(function () {
		$('#storytabs a[href="#who_voted"]').tab('show');
		$('#storytabs a[href="#who_downvoted"]').tab('show');
		$('#storytabs a[href="#related"]').tab('show');
		$('#storytabs a[href="#comments"]').tab('show');
	});

{/literal}

{if $urlmethod==2}
    {literal}
        function show_comments(id){
			document.location.href=story_link+'/'+id+'#comment-'+id;
        }
        function show_replay_comment_form(id){
           document.location.href=story_link+'/reply/'+id+'#comment-reply-'+id;
        }
    {/literal}
{else}
    {literal}
        function show_comments(id){
			document.location.href=story_link+'&comment_id='+id+'#comment-'+id;
        }
        function show_replay_comment_form(id){
           document.location.href=story_link+'&comment_id='+id+'&reply=1#comment-reply-'+id;
        }
    {/literal}
{/if}
</script>

<div id="tabbed" class="tab-content">

	<div class="tab-pane fade active in" id="comments" >
		{checkActionsTpl location="tpl_pligg_story_comments_start"}
		<h3>{#PLIGG_Visual_Story_Comments#}</h3>
		<a name="comments" href="#comments"></a>
		<ol class="media-list comment-list">
			{checkActionsTpl location="tpl_pligg_story_comments_individual_start"}
				{$the_comments}
			{checkActionsTpl location="tpl_pligg_story_comments_individual_end"}
			{if $user_authenticated neq ""}
				{include file=$the_template."/comment_form.tpl"}
			{else}
				{checkActionsTpl location="anonymous_comment_form_start"}
				<div align="center" class="login_to_comment">
					<br />
					<h3><a href="{$login_url}">{#PLIGG_Visual_Story_LoginToComment#}</a> {#PLIGG_Visual_Story_Register#} <a href="{$register_url}">{#PLIGG_Visual_Story_RegisterHere#}</a>.</h3>
				</div>
				{checkActionsTpl location="anonymous_comment_form_end"}
			{/if}
		</ol>
		{checkActionsTpl location="tpl_pligg_story_comments_end"}
	</div>
	
	{if count($voter) neq 0}
		<div class="tab-pane fade" id="who_voted">
			<h3>{#PLIGG_Visual_Story_WhoVoted#}</h3>
			{checkActionsTpl location="tpl_pligg_story_who_voted_start"}
			<div class="whovotedwrapper whoupvoted">
				<ul>			
					{section name=upvote loop=$voter}
						<li>
							{if $UseAvatars neq "0"}
								<a href="{$URL_user, $voter[upvote].user_login}" rel="tooltip" title="{$voter[upvote].user_login}" class="avatar-tooltip"><img src="{$voter[upvote].Avatar_ImgSrc}" alt="" align="top" title="" /></a>
							{else}
								<a href="{$URL_user, $voter[upvote].user_login}">{$voter[upvote].user_login}</a>
							{/if}
						</li>
					{/section}
				</ul>
			</div>
			{checkActionsTpl location="tpl_pligg_story_who_voted_end"}
		</div>
	{/if}
	{if count($downvoter) neq 0}
		<div class="tab-pane fade" id="who_downvoted">
			<h3>{#PLIGG_Visual_Story_Who_Downvoted_Story#}</h3>
			{checkActionsTpl location="tpl_pligg_story_who_downvoted_start"}
			<div class="whovotedwrapper whodownvoted">
				<ul>
					{section name=downvote loop=$downvoter}
						<li>
							{if $UseAvatars neq "0"}
								<a href="{$URL_user, $downvoter[downvote].user_login}" rel="tooltip" title="{$downvoter[downvote].user_login}" class="avatar-tooltip"><img src="{$downvoter[downvote].Avatar_ImgSrc}" alt="" align="top" title="" /></a>
							{/if}
							{if $UseAvatars eq "0"}<a href="{$URL_user, $downvoter[downvote].user_login}">{$downvoter[downvote].user_login}</a>{/if}
						</li>
					{/section}
				</ul>
			</div>
			<div style="clear:both;"></div>
			{checkActionsTpl location="tpl_pligg_story_who_downvoted_end"}
		</div>
	{/if}
	{if count($related_story) neq 0}
		<div class="tab-pane fade" id="related">
			<h3>{#PLIGG_Visual_Story_RelatedStory#}</h3>
			{checkActionsTpl location="tpl_pligg_story_related_start"}
			<ol>
				{* The next line checks how many related stories there are.  If there are fewer than 10 it will set the return loop to a smaller number. *}
				{if count($related_story) > 10}{assign var="related_count" value="10"}{else}{assign var="related_count" value=$related_story}{/if}
				{section name=related loop=$related_count}
					<li><a href = "{$related_story[related].url}">{$related_story[related].link_title}</a></li> 
				{/section}
			</ol>
			{checkActionsTpl location="tpl_pligg_story_related_end"}
		</div>
	{/if}
	{checkActionsTpl location="tpl_pligg_story_tab_end_content"}
</div>
<!--/story_center.tpl -->

