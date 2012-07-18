{************************************
**** Individual Comment Template ****
*************************************}

<li class="comment">
	<a id="c{$comment_id}"></a>
	{checkActionsTpl location="tpl_pligg_story_comments_single_start"}
	<div class="comment-wrapper clearfix" {if $comment_status neq "published"}style="background-color: #FFFBE4;border:1px solid #DFDFDF;"{/if}>
		<div class="comment-left span1">
			{if $UseAvatars neq "0"}<a href="{$user_view_url}"><img src="{$Avatar_ImgSrc}" align="absmiddle" class="avatar" alt="{$user_username}" title="{$user_username}" /></a>{/if}      
			{if $Enable_Comment_Voting eq 1}
				<br />
				{if $comment_user_vote_count eq 0 && $current_userid neq $comment_author}
					<span id="ratebuttons-{$comment_id}">	  
						<a href="javascript:{$link_shakebox_javascript_voten}" style='text-decoration:none;'>- </a> 
						<a id="cvote-{$comment_id}" style='text-decoration: none;'>{$comment_votes}</a> 
						<a href="javascript:{$link_shakebox_javascript_votey}" style='text-decoration:none;'> +</a> 
					</span>
				{/if}
			{/if}
		</div>
		<div class="comment-right span7" id="wholecomment{$comment_id}">
			{if $user_logged_in == $user_userlogin || $isadmin eq 1}
				<div class="btn-group pull-right">
					<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
					  <i class="icon-info-sign"></i> {#PLIGG_Visual_Admin_Links#}
					  <span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
						{if $isadmin eq 1}
							<li><a href="{$my_base_url}{$my_pligg_base}/admin/admin_users.php?mode=view&user={$user_userlogin}">{#PLIGG_Visual_Comment_Manage_User#} {$user_userlogin}</a></li>
							<li><a href="{$edit_comment_url}">{#PLIGG_Visual_Comment_Edit#}</a></li>
							<li><a href="{$delete_comment_url}">{#PLIGG_Visual_Comment_Delete#}</a></li>
						{elseif $user_logged_in == $user_userlogin}
							<li><a href="{$edit_comment_url}">{#PLIGG_Visual_Comment_Edit#}</a></li>
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
					{if $comment_parent eq 0 && $current_userid neq 0} 
						<a data-toggle="modal" href="#replymodal" >{#PLIGG_Visual_Comment_Reply#}</a>
					{/if}
				</span>
				{if $comment_votes lt 0}
					<span class="comment-hide">
						<span id = "show_hide_comment_content-{$comment_id}"> <a href = "javascript://"  onclick="var replydisplay=document.getElementById('comment_content-{$comment_id}').style.display ? '' : 'none'; document.getElementById('comment_content-{$comment_id}').style.display = replydisplay;">{#PLIGG_Visual_Comment_Show_Hide#}</a></span>
					</span>
				{/if}
			</p>
			{if $comment_votes gte 0} 
				<p id="comment_content-{$comment_id}">{$comment_content}</p> 
			{else}
				<p id = "comment_content-{$comment_id}" style="display:none">{$comment_content}</p>
			{/if}
		</div>

		{if $comment_parent eq 0 && $current_userid neq 0} 
			{* Display comment form if replying to a comment *}
			<div class="modal hide" id="replymodal">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">×</button>
					<h3>{#PLIGG_Visual_Comment_Send#}</h3>
				</div>
				<div class="modal-body">
					<div id="reply-{$comment_id}"> 
						<textarea name="reply_comment_content[{$comment_id}]" id="reply_comment_content-{$comment_id}" rows="5" style="width:98%;" />{$TheComment}</textarea>
						{if $Spell_Checker eq 1}
							<input type="button" name="spelling" value="{#PLIGG_Visual_Check_Spelling#}" onClick="openSpellChecker('reply_comment_content-{$comment_id}');" class="btn"/>
						{/if}
						<p>{#PLIGG_Visual_Comment_NoHTML#}</p>
					</div>
				</div>
				<div class="modal-footer">
					<a href="#" class="btn" data-dismiss="modal">{#PLIGG_Visual_View_User_Edit_Cancel#}</a>
					<input type="submit" name="submit[{$comment_id}]" value="{#PLIGG_Visual_Comment_Submit#}" class="btn btn-primary" />
				</div>
			</div>
		{/if}
			
	</div>
	{checkActionsTpl location="tpl_pligg_story_comments_single_end"}
</li>
