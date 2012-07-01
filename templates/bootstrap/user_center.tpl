{checkActionsTpl location="tpl_pligg_profile_start"}
{checkActionsTpl location="tpl_user_center_just_below_header"}

<ul class="nav nav-tabs" id="profiletabs">
	{checkActionsTpl location="tpl_pligg_profile_sort_start"}
	<li {if $user_view eq 'profile'}class="active"{/if}><a {if $user_view eq 'profile'}data-toggle="tab" href="#personal_info"{else}href="{$user_url_personal_data}"{/if} class="navbut{$nav_pd}">{#PLIGG_Visual_User_PersonalData#}</a></li>
	{if $user_login eq $user_logged_in}
		<li {if $user_view eq 'setting'}class="active"{/if}><a href="{$user_url_setting}" class="navbut{$nav_set}">{#PLIGG_Visual_User_Setting#}</a></li>
	{/if}
	<li {if $user_view eq 'history'}class="active"{/if}><a href="{$user_url_news_sent}" class="navbut{$nav_ns}">{#PLIGG_Visual_User_NewsSent#}</a></li>
	<li {if $user_view eq 'published'}class="active"{/if}><a href="{$user_url_news_published}" class="navbut{$nav_np}">{#PLIGG_Visual_User_NewsPublished#}</a></li>
	<li {if $user_view eq 'shaken'}class="active"{/if}><a href="{$user_url_news_unpublished}" class="navbut{$nav_nu}">{#PLIGG_Visual_User_NewsUnPublished#}</a></li>
	<li {if $user_view eq 'commented'}class="active"{/if}><a href="{$user_url_commented}" class="navbut{$nav_c}">{#PLIGG_Visual_User_NewsCommented#}</a></li>
	<li {if $user_view eq 'voted'}class="active"{/if}><a href="{$user_url_news_voted}" class="navbut{$nav_nv}">{#PLIGG_Visual_User_NewsVoted#}</a></li>
	<li {if $user_view eq 'saved'}class="active"{/if}><a href="{$user_url_saved}" class="navbut{$nav_s}">{#PLIGG_Visual_User_NewsSaved#}</a></li>
	{checkActionsTpl location="tpl_pligg_profile_sort_end"}
	<li><a data-toggle="tab" href="#status_update_module">Status</a></li>
</ul>

{literal}
<script>
$(function () {
	$('#profiletabs a[href="#personal_info"]').tab('show');
	$('#profiletabs a[href="#status_update_module"]').tab('show');
})
</script>
{/literal}

{***********************************************************************************}

{if $user_view eq 'profile'}
	<div id="tabbed" class="tab-content">
		<div class="tab-pane fade active in" id="personal_info">
			{checkActionsTpl location="tpl_pligg_profile_info_start"}
			
			<div class="span4">
				<table class="table table-bordered table-striped">
					<thead class="table_title">
						<tr>
							<th colspan="2">{#PLIGG_Visual_User_PersonalData#}</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td style="background:none"><strong>{#PLIGG_Visual_Login_Username#}:</strong></td>
							<td style="background:none">{if $UseAvatars neq "0"}<span id="ls_avatar"><img src="{$Avatar_ImgSrc}" alt="Avatar" align="absmiddle" /></span>{/if} <span style="text-transform:capitalize;">{$user_username}</span></td>
						</tr>			
						{if $user_names ne ""}
						<tr>
							<td><strong>{#PLIGG_Visual_User_Profile_User#}:</strong></td>
							<td>{$user_names}</td>
						</tr>
						{/if}

						{if $user_url ne ""}
						<tr>
							<td><strong>{#PLIGG_Visual_User_Profile_Homepage#}:</strong></td>
							<td style="text-align:center;"><a href="{$user_url}" target="_blank" rel="nofollow">{$user_url}</a></td>
						</tr>
						{/if}

						{if $user_publicemail ne ""}
						<tr>
							<td><strong>{#PLIGG_Visual_User_Profile_PublicEmail#}:</strong></td>
							<td>{$user_publicemail}</td>
						</tr>
						{/if}

						{if $user_location ne ""}
						<tr>
							<td><strong>{#PLIGG_Visual_Profile_Location#}:</strong></td>
							<td>{$user_location}</td>
						</tr>
						{/if}

						{if $user_occupation ne ""}
						<tr>
							<td><strong>{#PLIGG_Visual_Profile_Occupation#}:</strong></td>
							<td>{$user_occupation}</td>
						</tr>
						{/if}

						{if $user_aim ne ""}
						<tr>
							<td><strong>{#PLIGG_Visual_User_Profile_AIM#}:</strong></td>
							<td>{$user_aim}</td>
						</tr>
						{/if}

						{if $user_msn ne ""}
						<tr>
							<td><strong>{#PLIGG_Visual_User_Profile_MSN#}:</strong></td>
							<td>{$user_msn}</td>
						</tr>
						{/if}

						{if $user_yahoo ne ""}
						<tr>
							<td><strong>{#PLIGG_Visual_User_Profile_Yahoo#}:</strong></td>
							<td>{$user_yahoo}</td>
						</tr>
						{/if}

						{if $user_gtalk ne ""}
						<tr>
							<td><strong>{#PLIGG_Visual_User_Profile_GTalk#}:</strong></td>
							<td>{$user_gtalk}</td>
						</tr>
						{/if}

						{if $user_skype ne ""}
						<tr>
							<td><strong>{#PLIGG_Visual_User_Profile_Skype#}:</strong></td>
							<td>{$user_skype}</td>
						</tr>
						{/if}

						{if $user_irc ne ""}
						<tr>
							<td><strong>{#PLIGG_Visual_User_Profile_IRC#}:</strong></td>
							<td><a href="{$user_irc}" target="_blank">{$user_irc}</a></td>
						</tr>
						{/if}

						{if $user_login eq $user_logged_in}
						<tr>
							<td></td>
							<td><input type="button" class="btn btn-primary" value="{#PLIGG_Visual_User_Profile_Modify#}" onclick="location='{$URL_Profile}'"></td>
						</tr>
						{/if}
					</tbody>
				</table>
				{checkActionsTpl location="tpl_show_extra_profile"}
			</div>
			
			{checkActionsTpl location="tpl_pligg_profile_info_middle"}
			
			<div id="stats" class="span4">
				<table class="table table-bordered table-striped">
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
								<td>{$user_karma}</td>
							</tr>
						{/if}
						<tr>
							<td><strong>{#PLIGG_Visual_User_Profile_Joined#}:</strong></td>
							<td>{$user_joined}</td>
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
				<div id="groups" class="span4">
					<legend>{#PLIGG_Visual_User_Profile_User_Groups#}</legend>
					<table class="table table-bordered table-striped">
						<thead class="table_title">
							<tr>
								<th>Group Name</th>
								<th style="width:60px;text-align:center;">Members</th>
							</tr>
						<tbody>
							{$group_display}
						</tbody>
					</table>
				</div>
			{/if}
			
			{if $Allow_Friends neq "0"}
				<div id="friends" class="span4">
					<legend>{#PLIGG_Visual_LS_My_Friends#}</legend>
					{if $friends}			
						<table class="table table-bordered table-striped">
							<thead class="table_title">
								<tr>
									<th scope="col" style="width:25px;"></th>
									<th scope="col">{#PLIGG_Visual_Login_Username#}</th>
									{checkActionsTpl location="tpl_pligg_profile_friend_th"}
									{if $user_login eq $user_logged_in}<th scope="col">{#PLIGG_Visual_User_Profile_Remove_Friend#}</th>{/if}
								</tr>
							</thead>
							<tbody>
								{foreach from=$friends item=myfriend}
									{php}
										$this->_vars['friend_avatar'] = get_avatar('small', $this->_vars['myfriend']['user_avatar_source'], $this->_vars['myfriend']['user_login'], $this->_vars['myfriend']['user_email']);
										$this->_vars['profileURL'] = getmyurl('user2', $this->_vars['myfriend']['user_login'], 'profile');
										$this->_vars['removeURL'] = getmyurl('user_add_remove', $this->_vars['myfriend']['user_login'], 'removefriend');
									{/php}
									<tr>
									<td><a href="{$profileURL}"><img src="{$friend_avatar}" style="text-decoration:none;border:0;"/></a></td>
									<td><a href="{$profileURL}">{$myfriend.user_login}</a></td>
									{checkActionsTpl location="tpl_pligg_profile_friend_td"}
									{if $user_login eq $user_logged_in}
										<td><a href="{$removeURL}"><img src="{$my_pligg_base}/templates/{$the_template}/images/delete.gif" style="border:0;text-decoration:none;"/></a> <a href="{$removeURL}"> {$myfriend.user_login}</a></td>
									{/if}
									</tr>
								{/foreach}
							</tbody>
						</table>
					{else}
						<br /><span style="text-transform:capitalize;">{$user_username}</span> {#PLIGG_Visual_User_Profile_No_Friends#}
					{/if}
				</div>
			{/if}
			
			<div id="user_search" class="span4">
				<legend>{#PLIGG_Visual_AdminPanel_Users#}</legend>
				<table class="table table-bordered table-striped">
					{if $Allow_Friends neq "0"}	
						{if $user_authenticated eq true} 
							<tr>
								<td colspan="2">
									<form action="{$my_pligg_base}/user.php" method="get"
										{php}
										global $URLMethod, $my_base_url, $my_pligg_base;
										if ($URLMethod==2) print "onsubmit='document.location.href=\"{$my_base_url}{$my_pligg_base}/user/search/\"+encodeURIComponent(this.keyword.value); return false;'";
										{/php}>
										<input type="hidden" name="view" value="search">
										<input type="text" name="keyword" style="width:220px;margin:6px 0 0 6px">
										<input type="submit" value="{#PLIGG_Visual_User_Search_Users#}" class="btn" style="margin-top:4px;">
									</form>
								</td>
							</tr>
						{/if}
						{if $user_login neq $user_logged_in}
							<tr>
							{if check_for_enabled_module('simple_messaging',0.6) && $is_friend}
								{if $friends}
									<td><img src="{$my_pligg_base}/modules/simple_messaging/images/reply.png" border="0" align="absmiddle" /> <a href="{$my_pligg_base}/module.php?module=simple_messaging&view=compose&return={$templatelite.server.REQUEST_URI|urlencode}&to={$user_login}">{#PLIGG_Visual_User_Profile_Message#} {$user_login}</a></td>
								{/if}
							{/if}
							{if $is_friend gt 0}
								<td><img src="{$my_pligg_base}/templates/{$the_template}/images/user_delete.gif" align="absmiddle" /> <a href="{$user_url_remove}">{#PLIGG_Visual_User_Profile_Remove_Friend#} {$user_login} {#PLIGG_Visual_User_Profile_Remove_Friend_2#}</a></td>
								{if $user_authenticated eq true}
									{checkActionsTpl location="tpl_user_center"}
								{/if}
							{else}
								{if $user_authenticated eq true} 					
									<td><img src="{$my_pligg_base}/templates/{$the_template}/images/user_add.gif" align="absmiddle" /> <a href="{$user_url_add}">{#PLIGG_Visual_User_Profile_Add_Friend#} {$user_login} {#PLIGG_Visual_User_Profile_Add_Friend_2#}</a></td>
								{/if}   
							{/if}
							</tr>
						{else}
							<tr>
								<td><img src="{$my_pligg_base}/templates/{$the_template}/images/friends.png" align="absmiddle" /> <a href="{$user_url_friends}">{#PLIGG_Visual_User_Profile_View_Friends#}</a></td>
								<td><img src="{$my_pligg_base}/templates/{$the_template}/images/friends2.png" align="absmiddle" /> <a href="{$user_url_friends2}">{#PLIGG_Visual_User_Profile_View_Friends_2#}</a></td>
							</tr>
						{/if} 
					{/if}
				</table>
			</div>	
			{checkActionsTpl location="tpl_pligg_profile_info_end"}
			<div style="clear:both;"> </div>
		</div>
		{checkActionsTpl location="tpl_pligg_profile_tab_insert"}
	</div>
{/if}

{***********************************************************************************}

{if $user_view eq 'search'}

	{if $Allow_Friends neq "0"}	
		<div id="search_users">
			<form action="{$my_pligg_base}/user.php" method="get"
	{php}
	global $URLMethod, $my_base_url, $my_pligg_base;
	if ($URLMethod==2) print "onsubmit='document.location.href=\"{$my_base_url}{$my_pligg_base}/user/search/\"+encodeURIComponent(this.keyword.value); return false;'";
	{/php}
>
			<input type="hidden" name="view" value="search">
				{if $get.keyword neq ""}
					{assign var=searchboxtext value=$get.keyword}
				{else}
					{assign var=searchboxtext value=#PLIGG_Visual_Search_SearchDefaultText#}			
				{/if}
			<input type="text" name="keyword" class="field" value="{$searchboxtext}" onfocus="if(this.value == '{$searchboxtext}') {ldelim}this.value = '';{rdelim}" onblur="if (this.value == '') {ldelim}this.value = '{$searchboxtext}';{rdelim}">
			<input type="submit" value="{#PLIGG_Visual_User_Search_Users#}" class="button">
			</form>
		</div>
		{if $user_login neq $user_logged_in}
			{if $is_friend gt 0}
				<img src="{$my_pligg_base}/templates/{$the_template}/images/user_delete.gif" align="absmiddle" />
				<a href="{$user_url_remove}">{#PLIGG_Visual_User_Profile_Remove_Friend#} {$user_login} {#PLIGG_Visual_User_Profile_Remove_Friend_2#}</a>
				{if $user_authenticated eq true}
					{checkActionsTpl location="tpl_user_center"}
				{/if} 			
			{else}
				{if $user_authenticated eq true}
					<img src="{$my_pligg_base}/templates/{$the_template}/images/user_add.gif" align="absmiddle" />
					<a href="{$user_url_add}">	{#PLIGG_Visual_User_Profile_Add_Friend#} {$user_login} {#PLIGG_Visual_User_Profile_Add_Friend_2#}</a>
				{/if}   
			{/if}      		
		{else}
			<img src="{$my_pligg_base}/templates/{$the_template}/images/friends.png" align="absmiddle" />
			<a href="{$user_url_friends}">{#PLIGG_Visual_User_Profile_View_Friends#}</a> 
			&nbsp;|&nbsp;
			<img src="{$my_pligg_base}/templates/{$the_template}/images/friends2.png" align="absmiddle" />
			<a href="{$user_url_friends2}">{#PLIGG_Visual_User_Profile_View_Friends_2#}</a> 

			
		{/if} 
	{/if}

	{if $userlist}
		<h2>{#PLIGG_Visual_Search_SearchResults#} &quot;{$search}&quot;</h2>

		<table class="table table-bordered table-striped">
			<thead class="table_title">
				<tr>
					<th>{#PLIGG_Visual_Login_Username#}</th>
					<th>{#PLIGG_Visual_User_Profile_Joined#}</th>
					<th>{#PLIGG_Visual_User_Profile_Homepage#}</th>
					<th>Add/Remove</th>
				</tr>
			</thead>
			<tbody>
				{section name=nr loop=$userlist}
					<tr>
						<td width="240px"><img src="{$userlist[nr].Avatar}" align="absmiddle" /> <a href="{$URL_user, $userlist[nr].user_login}">{$userlist[nr].user_login}</a></td>
						<td width="120px">{$userlist[nr].user_date}</td>
						<td width="300px" style="text-align:center;">{$userlist[nr].user_url}</td>
						<td width="80px" style="text-align:center;">{if $userlist[nr].status eq 0}	
								<a href="{$userlist[nr].add_friend}"><img src="{$my_pligg_base}/templates/{$the_template}/images/user_add.gif" align="absmiddle" border="0" /></a>
							{else}
								<a href="{$userlist[nr].remove_friend}"><img src="{$my_pligg_base}/templates/{$the_template}/images/user_delete.gif" align="absmiddle" border="0"/></a>
							{/if}
						</td>	
					</tr>
				{/section}
			</tbody>
		</table>
	{else}
		<h2>{#PLIGG_Visual_Search_NoResults#} '{$search}'</h2>
	{/if}
	
{/if}

{***********************************************************************************}

{if $user_view eq 'viewfriends'}
	<div id="navbar">
		{if $Allow_Friends neq "0"}
			{if $user_authenticated eq true} 
				<div id="search_users">
					<form action="{$my_pligg_base}/user.php" method="get"
		{php}
		global $URLMethod, $my_base_url, $my_pligg_base;
		if ($URLMethod==2) print "onsubmit='document.location.href=\"{$my_base_url}{$my_pligg_base}/user/search/\"+encodeURIComponent(this.keyword.value); return false;'";
		{/php}
>
					<input type="hidden" name="view" value="search">
					<input type="text" name="keyword" class="field">
					<input type="submit" value="{#PLIGG_Visual_User_Search_Users#}" class="button">
					</form>
				</div>
			{/if}
			
			<img src="{$my_pligg_base}/templates/{$the_template}/images/friends2.png" align="absmiddle" /> 
			<a href="{$user_url_friends2}">{#PLIGG_Visual_User_Profile_View_Friends_2#}</a> 

		{/if}
	</div>

	<h2>{#PLIGG_Visual_User_Profile_Your_Friends#}</h2>

	{if $friends}
	  	<table>
		<th style="width:250px;text-align:left;">{#PLIGG_Visual_User_Profile_Username#}</th>
		{if check_for_enabled_module('simple_messaging',0.6) && $is_friend}<th style="width:90px;text-align:left;">{#PLIGG_Visual_User_Profile_Message#}</th>{/if}
		<th style="width:60px;text-align:center;">{#PLIGG_Visual_User_Profile_Remove_Friend#}</th>
		{foreach from=$friends item=myfriend}
			{php}
				$this->_vars['friend_avatar'] = get_avatar('small', $this->_vars['myfriend']['user_avatar_source'], $this->_vars['myfriend']['user_login'], $this->_vars['myfriend']['user_email']);
				$this->_vars['profileURL'] = getmyurl('user2', $this->_vars['myfriend']['user_login'], 'profile');
				$this->_vars['removeURL'] = getmyurl('user_add_remove', $this->_vars['myfriend']['user_login'], 'removefriend');
			{/php}
			<tr>
			<td><img src="{$friend_avatar}" align="absmiddle" /> <a href="{$profileURL}">{$myfriend.user_login}</a></td>
			{if check_for_enabled_module('simple_messaging',0.6) && $is_friend}<td align="center"><a href="{$my_pligg_base}/module.php?module=simple_messaging&view=compose&return={$templatelite.server.REQUEST_URI|urlencode}&to={$myfriend.user_login}"><img src="{$my_pligg_base}/modules/simple_messaging/images/reply.png" border="0" /></a></td>{/if}
			<td align="center"><a href = "{$removeURL}"><img src="{$my_pligg_base}/templates/{$the_template}/images/user_delete.gif" border=0></a></td>
			</tr>
		{/foreach}
		</table>
	{else}
		<br /><br />
		<h2 style="text-align:center;"><span style="text-transform:capitalize;">{$user_username}</span> {#PLIGG_Visual_User_Profile_No_Friends#}</h2>
	{/if}
{/if}

{***********************************************************************************}

{if $user_view eq 'setting'}
	{checkActionsTpl location="tpl_pligg_profile_settings_start"}
	<form action="{$my_pligg_base}/user_settings.php?login={$user_username}" method="post">
		{$hidden_token_user_settings}
		
		<h2>{#PLIGG_Visual_User_Setting#}</h2>
		
		{if $Allow_User_Change_Templates}
			<div class="user_settings_template">
				<strong>{#PLIGG_Visual_User_Setting_Template#}</strong>
				<select name='template'>
				{foreach from=$templates item=template}
				<option {if $template==$current_template}selected{/if}>{$template}</option>
				{/foreach}
				</select>
			</div>
		{/if}
		
		<strong>{#PLIGG_Visual_User_Setting_Categories#}</strong>
		{foreach from=$category item=cat name="cate"}
			<!--{if $smarty.foreach.cate.iteration % 5 == 0}<br style="clear:both;">{/if}-->
			<div class="usercategory_outer">
				<div class="usercategory_checkbox">
					<input type="checkbox" name="chack[]" value="{$cat.category__auto_id}" {if !in_array($cat.category__auto_id,$user_category)} checked="checked"{/if}>
				</div>
				<div class="usercategory_name">
					{$cat.category_name}
				</div>
			</div>
		{/foreach}

		<input type="submit" class="btn" name="submit" value="{#PLIGG_Visual_Profile_Save#}">
		
	</form>
	{checkActionsTpl location="tpl_pligg_profile_settings_end"}
{/if}

{***********************************************************************************}

{if $user_view eq 'viewfriends2'}

	{if $Allow_Friends neq "0"}	 
		{if $user_authenticated eq true} 
			<form action="{$my_pligg_base}/user.php" method="get" {php}
				global $URLMethod, $my_base_url, $my_pligg_base;
				if ($URLMethod==2) print "onsubmit='document.location.href=\"{$my_base_url}{$my_pligg_base}/user/search/\"+encodeURIComponent(this.keyword.value); return false;'";
			{/php}>
			<input type="hidden" name="view" value="search">
			<input type="text" name="keyword" class="field">
			<input type="submit" value="{#PLIGG_Visual_User_Search_Users#}" class="button">
			</form>
		{/if}		
		<img src="{$my_pligg_base}/templates/{$the_template}/images/friends.png" align="absmiddle" />
		<a href="{$user_url_friends}">{#PLIGG_Visual_User_Profile_View_Friends#}</a>
	{/if}

	<h2>{#PLIGG_Visual_User_Profile_Viewing_Friends_2a#}</h2>
	{if $friends}
	  	<table>
			{if check_for_enabled_module('simple_messaging',0.6) && $is_friend}
				<th>{#PLIGG_Visual_User_Profile_Username#}</th>
				<th>{#PLIGG_Visual_User_Profile_Message#}</th>
			{/if}
			{foreach from=$friends item=myfriend}
				{php}
					$this->_vars['friend_avatar'] = get_avatar('small', $this->_vars['myfriend']['user_avatar_source'], $this->_vars['myfriend']['user_login'], $this->_vars['myfriend']['user_email']);
					$this->_vars['profileURL'] = getmyurl('user2', $this->_vars['myfriend']['user_login'], 'profile');
					$this->_vars['removeURL'] = getmyurl('user_add_remove', $this->_vars['myfriend']['user_login'], 'removefriend');
				{/php}

				<tr>
					<td><img src="{$friend_avatar}" align="absmiddle" /> <a href="{$profileURL}">{$myfriend.user_login}</a></td>
					{if check_for_enabled_module('simple_messaging',0.6) && $is_friend}<td><a href="{$my_pligg_base}/module.php?module=simple_messaging&view=compose&to={$myfriend.user_login}&return={$templatelite.server.REQUEST_URI|urlencode}"><img src="{$my_pligg_base}/modules/simple_messaging/images/reply.png" border="0" /></a></td>{/if}
				</tr>
			{/foreach}
		</table>
	{else}
		<h2>{$user_username} {#PLIGG_Visual_User_Profile_No_Friends_2#}</h2>
	{/if}
	
{/if}

{***********************************************************************************}

{if $user_view eq 'removefriend'}
	<div id="navbar">
		{if $Allow_Friends neq "0"}		
			{if $user_authenticated eq true} 
				<form action="{$my_pligg_base}/user.php" method="get" {php}
					global $URLMethod, $my_base_url, $my_pligg_base;
					if ($URLMethod==2) print "onsubmit='document.location.href=\"{$my_base_url}{$my_pligg_base}/user/search/\"+encodeURIComponent(this.keyword.value); return false;'";
					{/php}>
					<input type="hidden" name="view" value="search">
					<input type="text" name="keyword" class="field">
					<input type="submit" value="{#PLIGG_Visual_User_Search_Users#}" class="button">
				</form>
			{/if}
			{if $user_login neq $user_logged_in}	  
				<img src="{$my_pligg_base}/templates/{$the_template}/images/friends.png" align="absmiddle" />
				<a href="{$user_url_friends}">{#PLIGG_Visual_User_Profile_View_Friends#}</a>
				&nbsp;|&nbsp;
				<img src="{$my_pligg_base}/templates/{$the_template}/images/friends2.png" align="absmiddle" />
				<a href="{$user_url_friends2}">{#PLIGG_Visual_User_Profile_View_Friends_2#}</a>	  
			{/if}

		{/if}
	</div>

	<h2>{#PLIGG_Visual_User_Profile_Friend_Removed#}</h2>
	
{/if}

{***********************************************************************************}

{if $user_view eq 'addfriend'}
	{if $Allow_Friends neq "0"}	 
		{if $user_authenticated eq true} 
			<form action="{$my_pligg_base}/user.php" method="get" {php}
				global $URLMethod, $my_base_url, $my_pligg_base;
				if ($URLMethod==2) print "onsubmit='document.location.href=\"{$my_base_url}{$my_pligg_base}/user/search/\"+encodeURIComponent(this.keyword.value); return false;'";
			{/php}>
				<input type="hidden" name="view" value="search">
				<input type="text" name="keyword" class="field">
				<input type="submit" value="{#PLIGG_Visual_User_Search_Users#}" class="button">
			</form>
		{/if}
		
		<img src="{$my_pligg_base}/templates/{$the_template}/images/friends.png" align="absmiddle" />
		<a href="{$user_url_friends}">{#PLIGG_Visual_User_Profile_View_Friends#}</a>
		&nbsp;|&nbsp;
		<img src="{$my_pligg_base}/templates/{$the_template}/images/friends2.png" align="absmiddle" />
		<a href="{$user_url_friends2}">{#PLIGG_Visual_User_Profile_View_Friends_2#}</a>

	{/if}

	<h2 style="text-align:center;">{#PLIGG_Visual_User_Profile_Friend_Added#}</h2>
	
{/if}

{***********************************************************************************}

{if isset($user_page)}{$user_page}{/if}
{if isset($user_pagination)}{checkActionsTpl location="tpl_pligg_pagination_start"}{$user_pagination}{checkActionsTpl location="tpl_pligg_pagination_end"}{/if}
{checkActionsTpl location="tpl_pligg_profile_end"}