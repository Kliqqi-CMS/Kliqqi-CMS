<a id="c{$comment_id}"></a>
{checkActionsTpl location="tpl_pligg_story_comments_single_start"}
<div class="comment-wrap" {if $comment_status neq "published"}style="background-color: #FFFBE4;border:1px solid #DFDFDF;"{/if}>
	<div class="comment-left"> 	
		{if $UseAvatars neq "0"}<a href="{$user_view_url}"><img src="{$Avatar_ImgSrc}" align="absmiddle"/></a><br />{/if}      
		<div class="subtext">
			{if $is_anonymous}<strong>{#PLIGG_Visual_Comment_Manage_Unregistered#}</strong>{/if} <span style="text-transform:capitalize"><a href="{$user_view_url}">{$user_username}</a><!-- {if $user_rank neq ''} (#{$user_rank}){/if} --></span>
			
			<br />{$comment_age} {#PLIGG_Visual_Comment_Ago#} 
			
			{if $comment_votes lt 0}
				<br /><span id = "show_hide_comment_content-{$comment_id}"> <a href = "javascript://"  onclick="var replydisplay=document.getElementById('comment_content-{$comment_id}').style.display ? '' : 'none'; document.getElementById('comment_content-{$comment_id}').style.display = replydisplay;">{#PLIGG_Visual_Comment_Show_Hide#}</a></span>
			{/if}
			
			{if $Enable_Comment_Voting eq 1}
				{if $comment_user_vote_count eq 0 && $current_userid neq $comment_author}
					<br /><span id="ratebuttons-{$comment_id}">	  
						<a href="javascript:{$link_shakebox_javascript_voten}" style='text-decoration:none;'>- </a> 
						<a id="cvote-{$comment_id}" style='text-decoration: none;'>{$comment_votes}</a> 
						<a href="javascript:{$link_shakebox_javascript_votey}" style='text-decoration:none;'> +</a> 
					</span>
				{/if}
			{/if}
			
			{if $comment_parent eq 0 && $current_userid neq 0} 
				<br /><a href = "javascript://" onClick="var replydisplay=document.getElementById('reply-{$comment_id}').style.display ? '' : 'none'; document.getElementById('reply-{$comment_id}').style.display = replydisplay;">{#PLIGG_Visual_Comment_Reply#}</a>
			{/if}

		</div>
	</div>

	<div class="comment-right" id="wholecomment{$comment_id}"> 
		{if $comment_votes gte 0} 
			<span id="comment_content-{$comment_id}">{$comment_content}</span> 
		{else}
			<span id = "comment_content-{$comment_id}" style="display:none">{$comment_content}</span>
		{/if}
	</div>	  

	{if $hide_comment_edit neq 'yes'}
		<div class="comment-hover">
			<div class="subtext commenttools">			
				{if $isadmin eq 1}
					<a href="{$my_base_url}{$my_pligg_base}/admin/admin_users.php?mode=view&user={$user_userlogin}">{#PLIGG_Visual_Comment_Manage_User#} {$user_userlogin}</a>
					| 
					<a href="{$edit_comment_url}" style="color:#d98500;">{#PLIGG_Visual_Comment_Edit#}</a> | <a href="{$delete_comment_url}" style="color:#bc0b0b;">{#PLIGG_Visual_Comment_Delete#}</a>
				{else}	  
					{if $user_username eq 'you'}
						| <a href="{$edit_comment_url}">{#PLIGG_Visual_Comment_Edit#}</a> 
					{/if}
				{/if}
			</div>
		</div>
	{/if} 
		<br clear="all" />
	{if $comment_parent eq 0 && $current_userid neq 0} 
	{* display comment form if replying to a comment *}
		<div id="reply-{$comment_id}" style="display:none;" align="left"> 
			<fieldset><legend>{#PLIGG_Visual_Comment_Send#}</legend>
				<label>{#PLIGG_Visual_Comment_NoHTML#}</label>
				<textarea name="reply_comment_content[{$comment_id}]" id="reply_comment_content-{$comment_id}" rows="3" cols="55"/>{$TheComment}</textarea><br/>
				{if $Spell_Checker eq 1}<input type="button" name="spelling" value="{#PLIGG_Visual_Check_Spelling#}" onClick="openSpellChecker('reply_comment_content-{$comment_id}');" class="log2"/>{/if}
				<input type="submit" name="submit[{$comment_id}]" value="{#PLIGG_Visual_Comment_Submit#}" class="log2" />
			</fieldset>
		</div>
	{/if}	
	  	
</div>
{checkActionsTpl location="tpl_pligg_story_comments_single_end"}
<br clear="all" />
