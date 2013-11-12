{************************************
******* User History Template ********
 This template controls the user history pages (upvote history, downvote history, submitted, commented on, etc.)
*************************************}

<!-- user_comment_center.tpl -->
<div class="user_comment_history">
	
	{*
	<span class="user_comment_story_votes">
		{$link_shakebox_votes}
		<div class="user_comment_story_votebox">
			<div class="user_comment_story_vote">
				{checkActionsTpl location="tpl_pligg_story_votebox_start"}
				<div class="user_comment_story_votenumber">
					{$link_shakebox_votes}
				</div>
				<div id="xvote-{$link_shakebox_index}" class="user_comment_story_votebutton">
					{if $anonymous_vote eq "false" and $user_logged_in eq ""}
						<a data-toggle="modal" href="#loginModal" class="btn btn-xs {if $link_shakebox_currentuser_votes eq 1}btn-success{else}btn-default{/if}"><i class="fa {if $link_shakebox_currentuser_votes eq 1}fa-white {/if}fa-thumbs-up"></i></a>
						<a data-toggle="modal" href="#loginModal" class="btn btn-xs {if $link_shakebox_currentuser_reports eq 1}btn-danger{else}btn-default{/if}"><i class="fa {if $link_shakebox_currentuser_reports eq 1}fa-white {/if}fa-thumbs-down"></i></a>
					{else}
						{if $link_shakebox_currentuser_votes eq 0}
							<!-- Vote For It -->
							<a class="btn btn-default btn-xs linkVote_{$link_id}" {if $vote_from_this_ip neq 0 and $user_logged_in eq ""} data-toggle="modal" href="#loginModal" {else} href="javascript:{$link_shakebox_javascript_vote}" {/if} title="{$title_short}" ><i class="fa fa-thumbs-up"></i></a>
						{elseif $link_shakebox_currentuser_votes eq 1}
							<!-- Already Voted -->
							<a class="btn btn-xs btn-success linkVote_{$link_id}" href="javascript:{$link_shakebox_javascript_unvote}" title="{$title_short}"><i class="fa fa-white fa-thumbs-up"></i></a>
						{/if}
						{if $link_shakebox_currentuser_reports eq 0}
							<!-- Bury It -->
							<a class="btn btn-default btn-xs linkVote_{$link_id}" {if $report_from_this_ip neq 0 and $user_logged_in eq ""} data-toggle="modal" href="#loginModal" {else} href="javascript:{$link_shakebox_javascript_report}" {/if} title="{$title_short}" ><i class="fa fa-thumbs-down"></i></a>
						{elseif $link_shakebox_currentuser_reports eq 1}
							<!-- Already Buried -->
							<a class="btn btn-xs btn-danger linkVote_{$link_id}"   href="javascript:{$link_shakebox_javascript_unbury}" title="{$title_short}" }><i class="fa fa-white fa-thumbs-down"></i></a>
						{/if}
					{/if}
					<!-- Votes: {$link_shakebox_currentuser_votes} Buries: {$link_shakebox_currentuser_reports} -->
				</div><!-- /.votebutton -->
				{checkActionsTpl location="tpl_pligg_story_votebox_end"}
			</div><!-- /.vote -->
		</div><!-- /.votebox -->
	</span>
	*}
	<span class="user_comment_story_title">
		<a href="{$story_url}">{$title_short}</a>
	</span>
	<span class="user_comment_story_author">
		by 
		{if $UseAvatars neq "0"}
			<a href="{$submitter_profile_url}"><img class="user_comment_story_author_avatar" src="{$Avatar_ImgSrcs}" /></a>
		{/if}
		<a href="{$submitter_profile_url}">{$link_submitter}</a>
	</span>
	<span class="user_comment_story_timestamp">
		{$link_submit_timeago} {#PLIGG_Visual_Comment_Ago#}
	</span>

	<div class="user_comment_data">
		<div class="user_comment_details">
			<span class="user_comment_author">
				{if $UseAvatars neq "0"}
					<a href="{$user_view_url}"><img class="user_comment_comment_author_avatar" src="{$Avatar.small}" /></a>
				{/if}
				<a href="{$user_view_url}">{$user_username}</a>
			</span>
			<span class="user_comment_timestamp">
				{$comment_age} {#PLIGG_Visual_Comment_Ago#}
			</span>
		</div>
		<div class="user_comment_content">
			{if $Enable_Comment_Voting eq 1}
				{if $comment_user_vote_count eq 0 && $current_userid neq $comment_author}
					<span id="ratebuttons-{$comment_id}">	  
						<a href="javascript:{$link_shakebox_javascript_voten}" style='text-decoration:none;'>- </a> 
						<a id="cvote-{$comment_id}" style='text-decoration: none;'>{$comment_votes}</a> 
						<a href="javascript:{$link_shakebox_javascript_votey}" style='text-decoration:none;'> +</a> 
					</span>
				{/if}
			{/if}
			<span class="user_comment_content">
				{$comment_content}
			</span>	
		</div>
	</div>

</div>
<!--/user_comment_center.tpl -->