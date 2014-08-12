{************************************
******** Individual Comment *********
*************************************}
<!-- comment_show.tpl -->
<li class="media comment">
	<a id="c{$comment_id}"></a>
	{checkActionsTpl location="tpl_pligg_story_comments_single_start"}
	<div class="comment-wrapper {if $user_username == $link_submitter}alert alert-success comment-author{/if}{if $comment_votes lt 0}alert alert-danger comment-negative{/if}{if $comment_status neq "published"}alert alert-warning comment-moderated{/if} clearfix">
		<div class="pull-left comment_left">
			{if $Enable_Comment_Voting eq 1}
				<div class="comment_voting" id="cxvote-{$comment_id}">
					{if $Enable_Comment_Voting eq 1}
						{if $comment_shakebox_currentuser_votes eq 0}
							<!-- Vote For It -->
							<a class="btn btn-xs btn-default" href="javascript:{$link_shakebox_javascript_votey}"><i class="fa fa-thumbs-up"></i></a>
						{else}
							<!-- Already Voted -->
							<a class="btn btn-xs btn-success" href="javascript:{$link_shakebox_javascript_unvotey}"><i class="fa fa-white fa fa-thumbs-up"></i></a>
						{/if}
						<a id="cvote-{$comment_id}" class="btn btn-default btn-xs comment_vote_count" disabled>{$comment_votes}</a>
						{if $comment_shakebox_currentuser_reports eq 0}
							<!-- Bury It -->
							<a class="btn btn-xs btn-default" href="javascript:{$link_shakebox_javascript_voten}"><i class="fa fa-thumbs-down"></i></a>
						{else}
							<!-- Already Buried -->
							<a class="btn btn-xs btn-danger" href="javascript:{$link_shakebox_javascript_unvoten}"><i class="fa fa-white fa fa-thumbs-down"></i></a>
						{/if}
					{/if}
					
				</div>
			{/if}
			{if $UseAvatars neq "0"}
				<div class="comment_avatar">
					<a href="{$user_view_url}"><img src="{$Avatar.small}" class="avatar" alt="{$user_username}" title="{$user_username}" /></a>
				</div>
			{/if}      
		</div>
		<div class="media-body comment-content" id="wholecomment{$comment_id}">
			{if $user_logged_in == $user_userlogin || $isadmin eq 1}
				<div class="btn-group pull-right admin-links">
					<a class="btn btn-default dropdown-toggle" data-toggle="dropdown" href="#">
					  <i class="fa fa-cog"></i>
					  <span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
						{if $isadmin eq 1}
							<li><a href="{$my_base_url}{$my_pligg_base}/admin/admin_users.php?mode=view&user={$user_userlogin}"><i class="fa fa-user"></i> {#PLIGG_Visual_Comment_Manage_User#} {$user_userlogin}</a></li>
							<li><a href="{$edit_comment_url}"><i class="fa fa-edit"></i> {#PLIGG_Visual_Comment_Edit#}</a></li>
							<li><a href="{$delete_comment_url}"><i class="fa fa-trash-o"></i> {#PLIGG_Visual_Comment_Delete#}</a></li>
						{elseif $user_logged_in == $user_userlogin}
							<li><a href="{$edit_comment_url}"><i class="fa fa-edit"></i> {#PLIGG_Visual_Comment_Edit#}</a></li>
						{/if}
						{checkActionsTpl location="tpl_pligg_story_comments_admin"}
					</ul>
				</div>
			{/if}
			<p class="comment-data">
				<span class="comment-author">
					{if $is_anonymous}
						{#PLIGG_Visual_Comment_Manage_Unregistered#}
					{/if}
					<a href="{$user_view_url}">{$user_username}</a>
					<!-- {if $user_rank neq ''} (#{$user_rank}){/if} -->
				</span>
				<span class="comment-date">
					{$comment_age} {#PLIGG_Visual_Comment_Ago#} 
				</span>
                <span class="comment-reply">
                <a href="#" onclick="show_comments('{$comment_id}')" id="comment-{$comment_id}">Permalink</a>
                </span>
				<span class="comment-reply">
					{if $current_userid neq 0} 
						<a href="#" onclick="show_replay_comment_form('{$comment_id}')" id="comment-reply-{$comment_id}" >{#PLIGG_Visual_Comment_Reply#}</a>
					{/if}
				</span>
				{if $comment_votes lt 0}
					<span class="label label-danger comment-hide">
						<span id="show_hide_comment_content-{$comment_id}"> <a href = "javascript://"  onclick="var replydisplay=document.getElementById('comment_content-{$comment_id}').style.display ? '' : 'none'; document.getElementById('comment_content-{$comment_id}').style.display = replydisplay;">{#PLIGG_Visual_Comment_Show_Hide#}</a></span>
					</span>
				{/if}
			</p>
			{if $comment_votes gte 0} 
				<p class="comment-content" id="comment_content-{$comment_id}">{$comment_content}</p> 
			{else}
				<p class="comment-content" id="comment_content-{$comment_id}" style="display:none">{$comment_content}</p>
			{/if}
		</div>
	</div>
	{checkActionsTpl location="tpl_pligg_story_comments_single_end"}
</li>
<!--/comment_show.tpl -->