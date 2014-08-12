{************************************
*********** Story Content ***********
*************************************}
<!-- link_summary.tpl -->
{checkActionsTpl location="tpl_link_summary_start"}
<div class="stories" id="xnews-{$link_shakebox_index}" {* if $link_shakebox_currentuser_reports gt 0} style="opacity:0.5;filter:alpha(opacity = 50)"{/if *}>
	{if $isadmin || $user_logged_in eq $link_submitter}
		<div class="btn-group pull-right admin-links">
			<a class="btn btn-default dropdown-toggle" data-toggle="dropdown" href="#">
			  <i class="fa fa-cog"></i>
			  <span class="caret"></span>
			</a>
			<ul class="dropdown-menu">
				{if $user_logged_in eq $link_submitter || $isadmin}<li><a href="{$story_edit_url}"><i class="fa fa-pencil"></i> {#PLIGG_Visual_LS_Admin_Edit#}</a></li>{/if}
				{if $isadmin}
					<li><a href="{$story_admin_url}"><i class="fa fa-arrows-v"></i> {#PLIGG_Visual_LS_Admin_Status#}</a></li>
					<li><a href="{$my_base_url}{$my_pligg_base}/admin/admin_users.php?mode=view&user={$link_submitter}"><i class="fa fa-user"></i> {#PLIGG_Visual_Comment_Manage_User#} {$link_submitter}</a></li>
				{/if}
				{checkActionsTpl location="tpl_link_summary_admin_links"}
				{if $link_group_id neq 0}<li><a target="story_status" href="javascript://" onclick="show_hide_user_links(document.getElementById('stories_status-{$link_shakebox_index}'));"><i class="fa fa-group"></i> {#PLIGG_Visual_Group_Story_Status#}</a></li>{/if}
				{if $isadmin}
					<li><a href="{$my_pligg_base}/admin/admin_users.php?mode=killspam&user={$link_submitter}"><i class="fa fa-ban"></i> {#PLIGG_Visual_View_User_Killspam#}</a></li>
					<li><a href="{$my_pligg_base}/delete.php?link_id={$link_id}"><i class="fa fa-trash-o"></i> {#PLIGG_Visual_AdminPanel_Discard#}</a></li>
				{/if}
			</ul>
			
		</div>		
	{/if}
	{checkActionsTpl location="tpl_pligg_story_start"}
	<div class="story_data">
		{if $Voting_Method eq 2}
			<h4 id="ls_title-{$link_shakebox_index}">
				<ul class='star-rating{$star_class}' id="xvotes-{$link_shakebox_index}">
					<li class="current-rating" style="width: {$link_rating_width}px;" id="xvote-{$link_shakebox_index}"></li>
					<span id="mnmc-{$link_shakebox_index}" {if $link_shakebox_currentuser_votes ne 0}style="display: none;"{/if}>
						<li><a href="javascript:{$link_shakebox_javascript_vote_1star}" class='one-star'>1</a></li>
						<li><a href="javascript:{$link_shakebox_javascript_vote_2star}" class='two-stars'>2</a></li>
						<li><a href="javascript:{$link_shakebox_javascript_vote_3star}" class='three-stars'>3</a></li>
						<li><a href="javascript:{$link_shakebox_javascript_vote_4star}" class='four-stars'>4</a></li>
						<li><a href="javascript:{$link_shakebox_javascript_vote_5star}" class='five-stars'>5</a></li>
					</span>
					<span id="mnmd-{$link_shakebox_index}" {if $link_shakebox_currentuser_votes eq 0}style="display: none;"{/if}>
						<li class='one-star-noh'>1</li>
						<li class='two-stars-noh'>2</li>
						<li class='three-stars-noh'>3</li>
						<li class='four-stars-noh'>4</li>
						<li class='five-stars-noh'>5</li>
					</span>
				</ul>
			</h4>
		{else}
		  {if $story_status eq "published"}
			<div class="votebox votebox-published">
		  {else}
			<div class="votebox votebox-new">
		  {/if}			
				<div class="vote">
					{checkActionsTpl location="tpl_pligg_story_votebox_start"}
					<div class="votenumber">
						{$link_shakebox_votes}
					</div>
					<div id="xvote-{$link_shakebox_index}" class="votebutton">
						{if $anonymous_vote eq "false" and $user_logged_in eq ""}
							<a data-toggle="modal" href="#loginModal" class="btn {if $link_shakebox_currentuser_votes eq 1}btn-success{else}btn-default{/if}"><i class="fa {if $link_shakebox_currentuser_votes eq 1}fa-white {/if}fa-thumbs-up"></i></a>
							<a data-toggle="modal" href="#loginModal" class="btn {if $link_shakebox_currentuser_reports eq 1}btn-danger{else}btn-default{/if}"><i class="fa {if $link_shakebox_currentuser_reports eq 1}fa-white {/if}fa-thumbs-down"></i></a>
                        
                        {else}
							{if $link_shakebox_currentuser_votes eq 0}
								<!-- Vote For It -->
								<a class="btn btn-default linkVote_{$link_id}" {if $vote_from_this_ip neq 0 and $user_logged_in eq ""} data-toggle="modal" href="#LoginModal" {else} href="javascript:{$link_shakebox_javascript_vote}" {/if} title="{$title_short}" ><i class="fa fa-thumbs-up"></i></a>
							{elseif $link_shakebox_currentuser_votes eq 1}
								<!-- Already Voted -->
								<a class="btn btn-success linkVote_{$link_id}" href="javascript:{$link_shakebox_javascript_unvote}" title="{$title_short}"><i class="fa fa-white fa-thumbs-up"></i></a>
							{/if}
							{if $link_shakebox_currentuser_reports eq 0}
								<!-- Bury It -->
								<a class="btn btn-default linkVote_{$link_id}" {if $report_from_this_ip neq 0 and $user_logged_in eq ""} data-toggle="modal" href="#LoginModal" {else} href="javascript:{$link_shakebox_javascript_report}" {/if} title="{$title_short}" ><i class="fa fa-thumbs-down"></i></a>
							{elseif $link_shakebox_currentuser_reports eq 1}
								<!-- Already Buried -->
								<a class="btn btn-danger linkVote_{$link_id}"   href="javascript:{$link_shakebox_javascript_unbury}" title="{$title_short}" }><i class="fa fa-white fa-thumbs-down"></i></a>
							{/if}
						{/if}
						<!-- Votes: {$link_shakebox_currentuser_votes} Buries: {$link_shakebox_currentuser_reports} -->
					</div><!-- /.votebutton -->
				{checkActionsTpl location="tpl_pligg_story_votebox_end"}
				</div><!-- /.vote -->
			</div><!-- /.votebox -->
		{/if}
		<div class="title" id="title-{$link_shakebox_index}">
			<h2>
				{checkActionsTpl location="tpl_pligg_story_title_start"}
				{if $use_title_as_link eq true}
					{if $url_short neq "http://" && $url_short neq "://"}
						<a href="{$url}" {if $open_in_new_window eq true} target="_blank"{/if} {if $story_status neq "published"}rel="nofollow"{/if}>{$title_short}</a>
					{else}
						<a href="{$story_url}" {if $open_in_new_window eq true} target="_blank"{/if}>{$title_short}</a>
					{/if}
				 {else}
					{if $pagename eq "story" && $url_short neq "http://" && $url_short neq "://"}
						<a href="{$url}" {if $open_in_new_window eq true} target="_blank"{/if} {if $story_status neq "published"}rel="nofollow"{/if}>{$title_short}</a>
					{else} 
					  <a href="{$story_url}">{$title_short}</a>
					{/if}
				{/if}
				{checkActionsTpl location="tpl_pligg_story_title_end"}
			</h2>
			<span class="subtext">
				{if $UseAvatars neq "0"}<span id="ls_avatar-{$link_shakebox_index}"><img src="{$Avatar_ImgSrcs}" width="16px" height="16px" alt="" title="Avatar" /></span>{else}<i class="fa fa-user"></i>{/if}
				<a href="{$submitter_profile_url}">{$link_submitter}{if $submitter_rank neq ''} (#{$submitter_rank}){/if}</a> 
				<i class="fa fa-time"></i>
				{$link_submit_timeago} {#PLIGG_Visual_Comment_Ago#}
				
				<i class="fa fa-folder"></i> 
				<a href="{$category_url}">{$link_category}</a>
				{if $link_additional_cats}
					{foreach from=$link_additional_cats item=catname key=caturl}
						<a href="{$caturl}">{$catname}</a>
					{/foreach}
				{/if}
				
				{if $enable_tags}
					{if $tags}
						<i class="fa fa-tag"></i>
						{section name=thistag loop=$tag_array}
							{if $tag_array[thistag] neq ''}
								<a href="{$tags_url_array[thistag]}">{$tag_array[thistag]}</a>
							{/if}
						{/section}
					{/if}
				{/if}
				
				{if $url_short neq "http://" && $url_short neq "://"}
					<i class="fa fa-globe"></i>
					<a href="{$url}" {if $open_in_new_window eq true} target="_blank"{/if}  {if $story_status neq "published"}rel="nofollow"{/if}>{$url_short}</a>
				{/if}
				{checkActionsTpl location="tpl_pligg_story_tools_start"}
				&nbsp;
				<span id="ls_comments_url-{$link_shakebox_index}">
					{if $story_comment_count eq 0}
						<i class="fa fa-comment"></i> <span id="linksummaryDiscuss"><a href="{$story_url}#discuss" class="comments">{#PLIGG_MiscWords_Discuss#}</a>&nbsp;</span>
					{/if}
					{if $story_comment_count eq 1}
						<i class="fa fa-comment"></i> <span id="linksummaryHasComment"><a href="{$story_url}#comments" class="comments2">{$story_comment_count} {#PLIGG_MiscWords_Comment#}</a>&nbsp;</span>
					{/if}
					{if $story_comment_count gt 1}
						<i class="fa fa-comment"></i> <span id="linksummaryHasComment"><a href="{$story_url}#comments" class="comments2">{$story_comment_count} {#PLIGG_MiscWords_Comments#}</a>&nbsp;</span>
					{/if}
				</span> 
				{if $user_logged_in}  
					<iframe height="0px;" width="0px;" frameborder="0" name="add_stories"></iframe>
					{if $link_mine eq 0}
						<i class="fa fa-star"></i> <span id="linksummarySaveLink">
						<a id="add" linkid="{$link_id}" title="{$title_short}" class="favorite" >{#PLIGG_MiscWords_Save_Links_Save#}</a>
					{else}
						<i class="fa fa-star-o"></i> <span id="linksummaryRemoveLink">
						<a id="remove" linkid="{$link_id}" title="{$title_short}" class="favorite" >{#PLIGG_MiscWords_Save_Links_Remove#}</a>
					{/if}
					</span>&nbsp;
					<span id="stories-{$link_shakebox_index}" class="label label-success" style="display:none;line-height:1em;">{#PLIGG_MiscWords_Save_Links_Success#}</span>
				{/if}
				{if $link_shakebox_currentuser_votes eq 1 && $link_shakebox_currentuser_reports eq 1}
					<i class="fa fa-minus-sign"></i> 
					<span id="linksummaryUnvote"><a href="javascript:{$link_shakebox_javascript_unvote}">{#PLIGG_Visual_Unvote_For_It#}</a></span>&nbsp; 
				{/if}
				{if $enable_group eq "true" && $user_logged_in}
					<span class="group-tool-wrapper">
						<i class="fa fa-group"></i> 
						<span class="group_sharing"><a href="javascript://" onclick="{if $get_group_membered}var replydisplay=document.getElementById('group_share-{$link_shakebox_index}').style.display ? '' : 'none';document.getElementById('group_share-{$link_shakebox_index}').style.display = replydisplay;{else}alert('{#PLIGG_Visual_No_Groups#}');{/if}">{#PLIGG_Visual_Group_Share#}</a></span>
						<span id = "group_share-{$link_shakebox_index}" style="display:none;">
							<div class="group-share-popup">{$get_group_membered}</div>
						</span>
					</span>
				{/if}
				{checkActionsTpl location="tpl_pligg_story_tools_end"}
				<iframe height="0" width="0" frameborder="0" name="story_status" class="invisible"></iframe>
				<span id="stories_status-{$link_shakebox_index}" style="display:none;">
					<a target="story_status" href="{$group_story_links_publish}" onclick="show_hide_user_links(document.getElementById('story_status_success-{$link_shakebox_index}'))">{#PLIGG_Visual_AdminPanel_Published#}</a>
					<a target="story_status" href="{$group_story_links_new}" onclick="show_hide_user_links(document.getElementById('story_status_success-{$link_shakebox_index}'))">{#PLIGG_Visual_AdminPanel_New#}</a>
					<a target="story_status" href="{$group_story_links_discard}" onclick="show_hide_user_links(document.getElementById('story_status_success-{$link_shakebox_index}'))">{#PLIGG_Visual_AdminPanel_Discard#}</a>
				</span>
				<span id="story_status_success-{$link_shakebox_index}" class="label label-success" style="display:none;">
					{#PLIGG_MiscWords_Save_Links_Success#}
				</span>
			</span>
		</div><!-- /.title -->
	</div> <!-- /.story_data -->
	<div class="storycontent">
		{checkActionsTpl location="tpl_link_summary_pre_story_content"}
		{if $pagename eq "story"}{checkActionsTpl location="tpl_pligg_story_body_start_full"}{else}{checkActionsTpl location="tpl_pligg_story_body_start"}{/if}
		{if $viewtype neq "short"}
			<div class="news-body-text" id="ls_contents-{$link_shakebox_index}">
				{if $show_content neq 'FALSE'}
					{if $pagename eq "story"}
						{* The nl2br modifier will convert line breaks to <br> tags. http://www.smarty.net/docsv2/en/language.modifier.nl2br.tpl*}
						{$story_content|nl2br}
					{else}
						{* The truncate modifier will cut off content after X characters. http://www.smarty.net/docsv2/en/language.modifier.truncate *}
						{$story_content|nl2br}
					{/if}
				{/if}
				{* 
				{if $Enable_Extra_Field_1 eq 1}{if $link_field1 neq ""}<br/><b>{$Field_1_Title}:</b> {$link_field1}{/if}{/if}
				{if $Enable_Extra_Field_2 eq 1}{if $link_field2 neq ""}<br/><b>{$Field_2_Title}:</b> {$link_field2}{/if}{/if}
				{if $Enable_Extra_Field_3 eq 1}{if $link_field3 neq ""}<br/><b>{$Field_3_Title}:</b> {$link_field3}{/if}{/if}
				{if $Enable_Extra_Field_4 eq 1}{if $link_field4 neq ""}<br/><b>{$Field_4_Title}:</b> {$link_field4}{/if}{/if}
				{if $Enable_Extra_Field_5 eq 1}{if $link_field5 neq ""}<br/><b>{$Field_5_Title}:</b> {$link_field5}{/if}{/if}
				{if $Enable_Extra_Field_6 eq 1}{if $link_field6 neq ""}<br/><b>{$Field_6_Title}:</b> {$link_field6}{/if}{/if}
				{if $Enable_Extra_Field_7 eq 1}{if $link_field7 neq ""}<br/><b>{$Field_7_Title}:</b> {$link_field7}{/if}{/if}
				{if $Enable_Extra_Field_8 eq 1}{if $link_field8 neq ""}<br/><b>{$Field_8_Title}:</b> {$link_field8}{/if}{/if}
				{if $Enable_Extra_Field_9 eq 1}{if $link_field9 neq ""}<br/><b>{$Field_9_Title}:</b> {$link_field9}{/if}{/if}
				{if $Enable_Extra_Field_10 eq 1}{if $link_field10 neq ""}<br/><b>{$Field_10_Title}:</b> {$link_field10}{/if}{/if}
				{if $Enable_Extra_Field_11 eq 1}{if $link_field11 neq ""}<br/><b>{$Field_11_Title}:</b> {$link_field11}{/if}{/if}
				{if $Enable_Extra_Field_12 eq 1}{if $link_field12 neq ""}<br/><b>{$Field_12_Title}:</b> {$link_field12}{/if}{/if}
				{if $Enable_Extra_Field_13 eq 1}{if $link_field13 neq ""}<br/><b>{$Field_13_Title}:</b> {$link_field13}{/if}{/if}
				{if $Enable_Extra_Field_14 eq 1}{if $link_field14 neq ""}<br/><b>{$Field_14_Title}:</b> {$link_field14}{/if}{/if}
				{if $Enable_Extra_Field_15 eq 1}{if $link_field15 neq ""}<br/><b>{$Field_15_Title}:</b> {$link_field15}{/if}{/if}
				*}
				{* 
				  {if $pagename neq "story" && $pagename neq "submit"} <div class="floatright"><a class="btn btn-default" href="{$story_url}">{#PLIGG_Visual_Read_More#}</a></div>{/if}
				*}
				<div class="clearboth"></div> 
			</div>
			{if $pagename eq "story"}{checkActionsTpl location="tpl_pligg_story_body_end_full"}{else}{checkActionsTpl location="tpl_pligg_story_body_end"}{/if}
		{/if}
	</div><!-- /.storycontent -->
	{checkActionsTpl location="tpl_link_summary_end"}
</div><!-- /.stories -->
{checkActionsTpl location="tpl_pligg_story_end"}
<!--/link_summary.tpl -->
