{************************************
***** User Profile Template *******
 This template controls the main user profile page, and the user history pages
*************************************}
<!-- user_center.tpl -->

{***********************************************************************************}

{if $user_view eq 'removefriend'}
	<div class="alert">
		<button class="close" data-dismiss="alert">&times;</button>
		{#PLIGG_Visual_User_Profile_Friend_Removed#}
	</div>
{/if}

{***********************************************************************************}

{if $user_view eq 'addfriend'}
	<div class="alert">
		<button class="close" data-dismiss="alert">&times;</button>
		{#PLIGG_Visual_User_Profile_Friend_Added#}
	</div>
{/if}

{***********************************************************************************}
{checkActionsTpl location="tpl_pligg_profile_start"}
<div class="row-fluid" style="margin-bottom:10px;">
	<div class="span9">
		<h1 style="margin-bottom:0px;">
			{if $UseAvatars neq "0"}
				{if $user_login eq $user_logged_in}<a href="#profileavatar" data-toggle="modal">{/if}
					<div class="thumbnail avatar_thumb">
						<img style="float:left;margin:0 15px 0 0;" src="{$Avatar.large}" style="margin-bottom:4px;" alt="Avatar" />
						{if $user_login eq $user_logged_in}<a href="#profileavatar" data-toggle="modal" class="btn btn-small edit-avatar">Edit Avatar</a>{/if}
					</div>
				{if $user_login eq $user_logged_in}</a>{/if}
				{* Avatar upload modal *}
				<div class="modal hide fade" id="profileavatar" style="display: none;">
					<div class="modal-header">
						<button data-dismiss="modal" class="close" type="button">&times;</button>
						<h3>Profile Avatar Upload</h3>
					</div>
					<div class="modal-body">
						<form method="POST" enctype="multipart/form-data" name="image_upload_form" action="{$form_action}">
						<script type="text/javascript">
							$('.fileupload').fileupload()
						</script>
	
						<div class="fileupload fileupload-new" data-provides="fileupload">
							<div class="fileupload-new thumbnail">
								<img src="{$Avatar.large}" title="{#PLIGG_Visual_Profile_CurrentAvatar#}" />
							</div>
							<div class="fileupload-preview fileupload-exists thumbnail" style="max-width:{$Avatar_Large}px;max-height:{$Avatar_Large}px;"></div>
							<div>
								<span class="btn btn-file">
									<span class="fileupload-new"><i class="icon icon-picture"></i> Browse</span>
									<span class="fileupload-exists"><i class="icon icon-picture"></i> Browse</span>
									<input type="file" class="fileupload" name="image_file"/>
								</span>
								<a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload">Remove</a>
							</div>
						</div>
						
					</div>
					<div class="modal-footer">
						<input type="hidden" name="avatar" value="uploaded"/>
						{$hidden_token_profile_change}
						<input type="submit" name="action" class="btn btn-primary" value="{#PLIGG_Visual_Profile_AvatarUpload#}"/>
						</form>
					</div>
				</div>
			{/if}
			{$user_username|capitalize}
		</h1>
		<div>
			{checkActionsTpl location="tpl_user_profile_social_start"}
			{if $user_skype}
				<a href="callto://{$user_skype}" title="Skype {$user_username|capitalize}" rel="nofollow" target="_blank"><img src="{$my_pligg_base}/templates/{$the_template}/img/skype_round.png" /></a>
			{/if}
			{if $user_facebook}
				<a href="http://www.facebook.com/{$user_facebook}" title="{$user_username|capitalize} on Facebook" rel="nofollow" target="_blank"><img src="{$my_pligg_base}/templates/{$the_template}/img/facebook_round.png" /></a>
			{/if}
			{if $user_twitter}
				<a href="http://twitter.com/{$user_twitter}" title="{$user_username|capitalize} on Twitter" rel="nofollow" target="_blank"><img src="{$my_pligg_base}/templates/{$the_template}/img/twitter_round.png" /></a>
			{/if}
			{if $user_linkedin}
				<a href="http://www.linkedin.com/in/{$user_linkedin}" title="{$user_username|capitalize} on LinkedIn" rel="nofollow" target="_blank"><img src="{$my_pligg_base}/templates/{$the_template}/img/linkedin_round.png" /></a>
			{/if}
			{if $user_googleplus}
				<a href="https://plus.google.com/{$user_googleplus}" title="{$user_username|capitalize} on Google+" rel="nofollow" target="_blank"><img src="{$my_pligg_base}/templates/{$the_template}/img/google_round.png" /></a>
			{/if}
			{if $user_pinterest}
				<a href="http://pinterest.com/{$user_pinterest}/" title="{$user_username|capitalize} on Pinterest" rel="nofollow" target="_blank"><img src="{$my_pligg_base}/templates/{$the_template}/img/pinterest_round.png" /></a>
			{/if}
			{checkActionsTpl location="tpl_user_profile_social_end"}
		</div>
		{checkActionsTpl location="tpl_show_extra_profile"}
		<div style="font-size:0.85em;line-height:1.3em;margin-top:2px;">		
			{if $user_publicemail ne ""}
				{php}
					// Method to try to trick automated email address collection bots
					global $main_smarty;
					$full_email = $this->_vars['user_publicemail'];
					list($email_start,$_) = explode('@',$full_email); $email_domain = ''.$_;
					$main_smarty->assign('email_start', $email_start);
					$main_smarty->assign('email_domain', $email_domain);
				{/php}
				<script type="text/javascript">
				<!--
					var string1 = "{$email_start}";
					var string2 = "@";
					var string3 = "{$email_domain}";
				//  document.write(string4);
					document.write("<a href=" + "mail" + "to:" + string1 + string2 + string3 + ">Email</a> | ");
				//-->
				</script>
			{/if}
			{if $user_url != "" && $user_karma > "20" || $user_login eq $user_logged_in}
				<a href="{$user_url}" target="_blank" rel="nofollow">{$user_url}</a>
				<br />
			{/if}
			{checkActionsTpl location="tpl_user_profile_details_start"}
			{if $user_names != ""}
				{$user_names}
				{if $user_occupation != "" || $user_location != ""}	is {/if}
			{/if}
			{if $user_occupation != ""}
				{if $user_names != ""} a {/if}
				{$user_occupation}
			{/if}
			{if $user_location != ""}
				{if $user_occupation != "" || $user_names != ""}
					 from 
				{elseif $user_location != ""}
					 From 
				{/if}
				{$user_location}
			{/if}
			{checkActionsTpl location="tpl_user_profile_details_end"}
		</div>
	</div>
	<div id="user_search" class="span3">
		<div style="float:right;text-align:right;">
			<form action="{$my_pligg_base}/user.php" method="get" {php} global $URLMethod, $my_base_url, $my_pligg_base; if ($URLMethod==2) print "onsubmit='document.location.href=\"{$my_base_url}{$my_pligg_base}/user/search/\"+encodeURIComponent(this.keyword.value); return false;'";{/php}>
				<div class="input-append">
					<input type="hidden" name="view" value="search">
					<input type="text" name="keyword" class="input-medium" placeholder="{#PLIGG_Visual_User_Search_Users#}"><button type="submit" class="btn">{#PLIGG_Visual_Search_Go#}</button>
				</div>
			</form>	
			<div class="btn-group">
				<a class="btn btn-small" href="{$user_url_friends}"><i class="icon-user"></i> {$following|@count} {#PLIGG_Visual_User_Profile_View_Friends#}</a>
				<a class="btn btn-small" href="{$user_url_friends2}"><i class="icon-user"></i> {$follower|@count} {#PLIGG_Visual_User_Profile_Your_Friends#}</a>
			</div> 
			{if $user_login neq $user_logged_in}
				{if check_for_enabled_module('simple_messaging',0.6) && $is_friend}
					{if $friends}
						<img src="{$my_pligg_base}/modules/simple_messaging/img/reply.png" border="0" align="absmiddle" /> <a href="{$my_pligg_base}/module.php?module=simple_messaging&view=compose&return={$templatelite.server.REQUEST_URI|urlencode}&to={$user_login}">{#PLIGG_Visual_User_Profile_Message#} {$user_login}</a>
					{/if}
				{/if}
				{if $is_friend gt 0}
					<a href="{$user_url_remove}" class="btn btn-small btn-danger">{#PLIGG_Unfollow#}{* {$user_login|capitalize} *}</a>
					{if $user_authenticated eq true}
						{checkActionsTpl location="tpl_user_center"}
					{/if}
				{else}
					{if $user_authenticated eq true} 
						<a class="btn btn-success" href="{$user_url_add}">{#PLIGG_Visual_User_Profile_Add_Friend#} {$user_login}</a>
					{/if}   
				{/if}
			{/if}
		</div>
	</div>
	<div style="clear:both;"></div>
</div>
{checkActionsTpl location="tpl_user_center_just_below_header"}
<ul class="nav nav-tabs" id="profiletabs">
	{checkActionsTpl location="tpl_pligg_profile_sort_start"}
	<li {if $user_view eq 'profile' || $user_view eq 'removefriend' || $user_view eq 'addfriend'}class="active"{/if}><a {if $user_view eq 'profile'}data-toggle="tab" href="#personal_info"{else}href="{$user_url_personal_data}"{/if} class="navbut{$nav_pd}">{#PLIGG_Visual_User_PersonalData#}</a></li>
	{if $user_login eq $user_logged_in}
		<li {if $pagename eq 'profile'}class="active"{/if}><a href="{$URL_Profile}" class="navbut{$nav_set}">{#PLIGG_Visual_User_Setting#}</a></li>
	{/if}
	<li {if $user_view eq 'history'}class="active"{/if}><a href="{$user_url_news_sent}" class="navbut{$nav_ns}">{#PLIGG_Visual_User_NewsSent#}</a></li>
	<li {if $user_view eq 'published'}class="active"{/if}><a href="{$user_url_news_published}" class="navbut{$nav_np}">{#PLIGG_Visual_User_NewsPublished#}</a></li>
	<li {if $user_view eq 'shaken'}class="active"{/if}><a href="{$user_url_news_unpublished}" class="navbut{$nav_nu}">{#PLIGG_Visual_User_NewsUnPublished#}</a></li>
	<li {if $user_view eq 'commented'}class="active"{/if}><a href="{$user_url_commented}" class="navbut{$nav_c}">{#PLIGG_Visual_User_NewsCommented#}</a></li>
	
	<li {if $user_view eq 'upvoted'}class="active"{/if}><a href="{$user_url_news_upvoted}" class="navbut{$nav_nv}">{#PLIGG_Visual_UpVoted#}</a></li>
	<li {if $user_view eq 'downvoted'}class="active"{/if}><a href="{$user_url_news_downvoted}" class="navbut{$nav_nv}">{#PLIGG_Visual_DownVoted#}</a></li>
	
	<li {if $user_view eq 'saved'}class="active"{/if}><a href="{$user_url_saved}" class="navbut{$nav_s}">{#PLIGG_Visual_User_NewsSaved#}</a></li>
	{checkActionsTpl location="tpl_pligg_profile_sort_end"}
</ul>
{***********************************************************************************}
{if $user_view eq 'profile' || $user_view eq 'removefriend' || $user_view eq 'addfriend'}
	<div id="profile_container" style="position: relative;">
		<div class="row-fluid">
			{checkActionsTpl location="tpl_pligg_profile_info_start"}
			{checkActionsTpl location="tpl_pligg_profile_info_middle"}
			<div id="stats" class="masonry span6" style="margin-left:10px">
				<table class="table table-bordered table-striped"">
					<thead class="table_title">
						<tr>
							<th colspan="2">{#PLIGG_Visual_User_Profile_User_Stats#}</th>
						</tr>
					</thead>
					<tbody>
						{if $user_karma > "0.00"}
							<tr>
								<td><strong>{#PLIGG_Visual_Rank#}:</strong></td>
								<td>{$user_rank}</td>
							</tr>
							<tr>
								<td><strong>{#PLIGG_Visual_User_Profile_KarmaPoints#}:</strong></td>
								<td>{$user_karma|number_format:"0"}</td>
							</tr>
						{/if}
						<tr>
							<td><strong>{#PLIGG_Visual_User_Profile_Joined#}:</strong></td>
							<td width="120px">
								{*	{$user_joined}	*}
								{php}
									$pligg_date = $this->_vars['user_joined'];
									echo date("F d, Y", strtotime($pligg_date));
								{/php}
							</td>	
						</tr>
						<tr>
							<td><strong>{#PLIGG_Visual_User_Profile_Total_Links#}:</strong></td>
							<td>{$user_total_links}</td>
						</tr>
						<tr>
							<td><strong>{#PLIGG_Visual_User_Profile_Published_Links#}:</strong></td>
							<td>{$user_published_links}</td>
						</tr>
						<tr>
							<td><strong>{#PLIGG_Visual_User_Profile_Total_Comments#}:</strong></td>
							<td>{$user_total_comments}</td>
						</tr>
						<tr>
							<td><strong>{#PLIGG_Visual_User_Profile_Total_Votes#}:</strong></td>
							<td>{$user_total_votes}</td>
						</tr>
						{*
						<tr>
							<td><strong>{#PLIGG_Visual_User_Profile_Published_Votes#}:</strong></td>
							<td>{$user_published_votes}</td>
						</tr>
						*}
					</tbody>
				</table>
			</div>
			{if $enable_group eq "true"}
				<div id="groups" class="masonry span6" style="margin-left:10px">
					<table class="table table-bordered table-striped"">
						<thead class="table_title">
							<tr>
								<th>Group Name</th>
								<th style="width:60px;text-align:center;">Members</th>
							</tr>
						<tbody>
							{if $group_display eq ''}
								<tr>
									<td colspan="2">
										{#Pligg_Profile_No_Membership#}
									</td>
								</tr>
							{else}
								{$group_display}
							{/if}
						</tbody>
					</table>
				</div>
			{/if}
			{if $Allow_Friends neq "0"}
				<div id="following" class="masonry span6" style="margin-left:10px">
					<table class="table table-bordered table-striped"">
						<thead class="table_title">
							<tr>
								<th>{#PLIGG_Visual_Login_Username#}</th>
								{checkActionsTpl location="tpl_pligg_profile_friend_th"}
								{if $user_login eq $user_logged_in}<th>{#PLIGG_Visual_User_Profile_Remove_Friend#}</th>{/if}
							</tr>
						</thead>
						<tbody>
							{if $following}
								{foreach from=$following item=myfriend}
									{php}
										$this->_vars['friend_avatar'] = get_avatar('small', $this->_vars['myfriend']['user_avatar_source'], $this->_vars['myfriend']['user_login'], $this->_vars['myfriend']['user_email']);
										$this->_vars['profileURL'] = getmyurl('user2', $this->_vars['myfriend']['user_login'], 'profile');
										$this->_vars['removeURL'] = getmyurl('user_add_remove', $this->_vars['myfriend']['user_login'], 'removefriend');
									{/php}
									<tr>
										<td>
											<a href="{$profileURL}"><img src="{$friend_avatar}" style="text-decoration:none;border:0;"/></a>
											<a href="{$profileURL}">{$myfriend.user_login}</a>
										</td>
										{checkActionsTpl location="tpl_pligg_profile_friend_td"}
										{if $user_login eq $user_logged_in}
											<td>
												<a class="btn btn-danger" href="{$removeURL}">Unfollow</a>
											</td>
										{/if}
									</tr>
								{/foreach}
							{else}
								<tr>
									<td colspan="3">
										{$user_username|capitalize} {#PLIGG_Visual_User_Profile_No_Friends#}
									</td>
								</tr>
							{/if}
						</tbody>
					</table>
				</div>
			{/if}
			{checkActionsTpl location="tpl_pligg_profile_info_end"}
			<div style="clear:both;"> </div>
			{checkActionsTpl location="tpl_pligg_profile_tab_insert"}
		</div>
	</div>
{/if}
{***********************************************************************************}
{if $user_view eq 'search'}
	{if $userlist}
		<legend>{#PLIGG_Visual_Search_SearchResults#} &quot;{$search}&quot;</legend>
		<table class="table table-bordered table-striped">
			<thead class="table_title">
				<tr>
					<th>{#PLIGG_Visual_Login_Username#}</th>
					<th>{#PLIGG_Visual_User_Profile_Joined#}</th>
					<th>{#PLIGG_User_Profile_Social#}</th>
					<th>Add/Remove</th>
				</tr>
			</thead>
			<tbody>
				{section name=nr loop=$userlist}
					<tr>
						<td>
							<img src="{$userlist[nr].Avatar}" align="absmiddle" /> 
							<a href="{$URL_user, $userlist[nr].user_login}">{$userlist[nr].user_login|capitalize}</a></td>
						<td>
							{* {$userlist[nr].user_date} *}
							{php}
								$pligg_date = $this->_vars['userlist'][$this->_sections['nr']['index']]['user_date'];
								echo date("F d, Y", strtotime($pligg_date));
							{/php}
						</td>
						<td>
							{if $userlist[nr].user_skype}
								<a href="callto://{$userlist[nr].user_skype}" title="Skype {$userlist[nr].user_login|capitalize}" rel="nofollow" target="_blank"><img src="{$my_pligg_base}/templates/{$the_template}/img/skype_round.png" /></a>
							{/if}
							{if $userlist[nr].user_facebook}
								<a href="http://www.facebook.com/{$userlist[nr].user_facebook}" title="{$userlist[nr].user_login|capitalize} on Facebook" rel="nofollow" target="_blank"><img src="{$my_pligg_base}/templates/{$the_template}/img/facebook_round.png" /></a>
							{/if}
							{if $userlist[nr].user_twitter}
								<a href="http://twitter.com/{$userlist[nr].user_twitter}" title="{$userlist[nr].user_login|capitalize} on Twitter" rel="nofollow" target="_blank"><img src="{$my_pligg_base}/templates/{$the_template}/img/twitter_round.png" /></a>
							{/if}
							{if $userlist[nr].user_linkedin}
								<a href="http://www.linkedin.com/in/{$userlist[nr].user_linkedin}" title="{$userlist[nr].user_login|capitalize} on LinkedIn" rel="nofollow" target="_blank"><img src="{$my_pligg_base}/templates/{$the_template}/img/linkedin_round.png" /></a>
							{/if}
							{if $userlist[nr].user_googleplus}
								<a href="https://plus.google.com/{$userlist[nr].user_googleplus}" title="{$userlist[nr].user_login|capitalize} on Google+" rel="nofollow" target="_blank"><img src="{$my_pligg_base}/templates/{$the_template}/img/google_round.png" /></a>
							{/if}
							{if $userlist[nr].user_pinterest}
								<a href="http://pinterest.com/{$userlist[nr].user_pinterest}/" title="{$userlist[nr].user_login|capitalize} on Pinterest" rel="nofollow" target="_blank"><img src="{$my_pligg_base}/templates/{$the_template}/img/pinterest_round.png" /></a>
							{/if}
						</td>
						<td style="text-align:center;">{if $userlist[nr].status eq 0}	
								<a href="{$userlist[nr].add_friend}"><img src="{$my_pligg_base}/templates/{$the_template}/img/user_add.gif" align="absmiddle" border="0" /></a>
							{else}
								<a href="{$userlist[nr].remove_friend}"><img src="{$my_pligg_base}/templates/{$the_template}/img/user_delete.gif" align="absmiddle" border="0"/></a>
							{/if}
						</td>	
					</tr>
				{/section}
			</tbody>
		</table>
	{else}
		<h3>{#PLIGG_Visual_Search_NoResults#} '{$search}'</h3>
	{/if}
{/if}
{***********************************************************************************}
{if $user_view eq 'following'}
	<legend>{#PLIGG_Visual_User_Profile_People#} {$user_username|capitalize} {#PLIGG_Visual_User_Profile_Is_Following#}</legend>
	{if $following}
	  	<table class="table table-bordered table-condensed table-striped">
			<thead>
				<th>{#PLIGG_Visual_User_Profile_Username#}</th>
				{if check_for_enabled_module('simple_messaging',0.6) && $is_friend}<th>{#PLIGG_Visual_User_Profile_Message#}</th>{/if}
				<th>{#PLIGG_Visual_User_Profile_Remove_Friend#}</th>
			</thead>
			<tbody>
				{foreach from=$following item=myfriend}
					{php}
						$this->_vars['friend_avatar'] = get_avatar('small', $this->_vars['myfriend']['user_avatar_source'], $this->_vars['myfriend']['user_login'], $this->_vars['myfriend']['user_email']);
						$this->_vars['profileURL'] = getmyurl('user2', $this->_vars['myfriend']['user_login'], 'profile');
						$this->_vars['removeURL'] = getmyurl('user_add_remove', $this->_vars['myfriend']['user_login'], 'removefriend');
					{/php}
					<tr>
						<td><img src="{$friend_avatar}" align="absmiddle" /> <a href="{$profileURL}">{$myfriend.user_login}</a></td>
						{if check_for_enabled_module('simple_messaging',0.6) && $is_friend}<td align="center"><a href="{$my_pligg_base}/module.php?module=simple_messaging&view=compose&return={$templatelite.server.REQUEST_URI|urlencode}&to={$myfriend.user_login}"><i class="icon icon-envelope"></i></a></td>{/if}
						<td align="center"><a href="{$removeURL}" class="btn btn-danger">Unfollow</a></td>
					</tr>
				{/foreach}
			<tbody>
		</table>
	{else}
		<br /><br />
		<h3 style="text-align:center;">{$user_username|capitalize} {#PLIGG_Visual_User_Profile_No_Friends#}</h3>
	{/if}
{/if}
{***********************************************************************************}
{if $user_view eq 'followers'}
	<legend>{#PLIGG_Visual_User_Profile_Viewing_Friends_2a#} {$user_username|capitalize}</legend>
	{if $follower}
	  	<table class="table table-bordered table-condensed table-striped">
			<thead>
				<tr>
					<th>{#PLIGG_Visual_User_Profile_Username#}</th>
					{if check_for_enabled_module('simple_messaging',0.6) && $is_friend}
						<th>{#PLIGG_Visual_User_Profile_Message#}</th>
					{/if}
					<th>Add/Remove</th>
				</tr>
			</thead>
			<tbody>
				{foreach from=$follower item=myfriend}
					{php}
						$this->_vars['friend_avatar'] = get_avatar('small', $this->_vars['myfriend']['user_avatar_source'], $this->_vars['myfriend']['user_login'], $this->_vars['myfriend']['user_email']);
						$this->_vars['profileURL'] = getmyurl('user2', $this->_vars['myfriend']['user_login'], 'profile');
						$this->_vars['removeURL'] = getmyurl('user_add_remove', $this->_vars['myfriend']['user_login'], 'removefriend');
					{/php}

					<tr>
						<td><img src="{$friend_avatar}" align="absmiddle" /> <a href="{$profileURL}">{$myfriend.user_login}</a></td>
						{if check_for_enabled_module('simple_messaging',0.6) && $is_friend}<td><a href="{$my_pligg_base}/module.php?module=simple_messaging&view=compose&to={$myfriend.user_login}&return={$templatelite.server.REQUEST_URI|urlencode}"><i class="icon icon-envelope"></i></a></td>{/if}
						{if $user_authenticated eq true}
							{*
							{if $is_friend gt 0}
								<td><a class="btn btn-danger" href="{$removeURL}">Unfollow</a></td>
							{else}
							
							{/if}
							*}
								<td><a class="btn btn-success" href="{$user_url_add}">{#PLIGG_Visual_User_Profile_Add_Friend#}</a></td>
						{/if}
					</tr>
				{/foreach}
			</tbody>
		</table>
	{else}
		<h4>{#PLIGG_Visual_User_Profile_No_Friends_2#} {$user_username|capitalize}</h4>
	{/if}
{/if}
{***********************************************************************************}
{if isset($user_page)}
	{$user_page}
{/if}
{if isset($user_pagination)}{checkActionsTpl location="tpl_pligg_pagination_start"}{$user_pagination}{checkActionsTpl location="tpl_pligg_pagination_end"}{/if}
{checkActionsTpl location="tpl_pligg_profile_end"}
<!--/user_center.tpl -->