{************************************
******* User Follow Template ********
 This template controls the user friend/follower pages
*************************************}
{include file=$the_template"/user_navigation.tpl"}

<!-- user_follow.tpl -->
{***********************************************************************************}
{if $user_view eq 'profile'}
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
{if isset($user_page)}
	{$user_page}
{/if}
{if isset($user_pagination)}{checkActionsTpl location="tpl_pligg_pagination_start"}{$user_pagination}{checkActionsTpl location="tpl_pligg_pagination_end"}{/if}
{checkActionsTpl location="tpl_pligg_profile_end"}
<!--/user_history.tpl -->