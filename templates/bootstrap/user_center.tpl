{************************************
***** User Profile Template *******
 This template controls the main user profile page, and the user history pages
*************************************}
<!-- user_center.tpl -->
{checkActionsTpl location="tpl_pligg_profile_start"}
<div style="margin:0 0 10px 0;">
	<h1>
		{if $UseAvatars neq "0"}
			<img style="float:left;margin:0 15px 0 0;" src="{$Avatar_ImgSrc}" class="thumbnail" style="margin-bottom:4px;" alt="Avatar" />
		{/if}
		{$user_username}
	</h1>
	<div style="margin-top:2px;">
		{checkActionsTpl location="tpl_user_profile_social_start"}
		{if $user_skype}
			<a href="callto://{$user_skype}" title="Skype {$user_username}" rel="nofollow" target="_blank"><img src="{$my_pligg_base}/templates/{$the_template}/images/skype_round.png" /></a>
		{/if}
		{if $user_facebook}
			<a href="http://www.facebook.com/{$user_facebook}" title="{$user_username} on Facebook" rel="nofollow" target="_blank"><img src="{$my_pligg_base}/templates/{$the_template}/images/facebook_round.png" /></a>
		{/if}
		{if $user_twitter}
			<a href="http://twitter.com/{$user_twitter}" title="{$user_username} on Twitter" rel="nofollow" target="_blank"><img src="{$my_pligg_base}/templates/{$the_template}/images/twitter_round.png" /></a>
		{/if}
		{if $user_linkedin}
			<a href="http://www.linkedin.com/in/{$user_linkedin}" title="{$user_username} on LinkedIn" rel="nofollow" target="_blank"><img src="{$my_pligg_base}/templates/{$the_template}/images/linkedin_round.png" /></a>
		{/if}
		{if $user_googleplus}
			<a href="https://plus.google.com/{$user_googleplus}" title="{$user_username} on Google+" rel="nofollow" target="_blank"><img src="{$my_pligg_base}/templates/{$the_template}/images/google_round.png" /></a>
		{/if}
		{if $user_pinterest}
			<a href="http://pinterest.com/{$user_pinterest}/" title="{$user_username} on Pinterest" rel="nofollow" target="_blank"><img src="{$my_pligg_base}/templates/{$the_template}/images/pinterest_round.png" /></a>
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
		{if $user_url ne "" && $user_karma > "20" || $user_login eq $user_logged_in}
			<a href="{$user_url}" target="_blank" rel="nofollow">{$user_url}</a>
			<br />
		{/if}
		{checkActionsTpl location="tpl_user_profile_details_start"}
		{if $user_names ne ""}
			{$user_names} is
		{/if}
		{if $user_occupation ne ""}
			a {$user_occupation}
		{/if}
		{if $user_location ne ""}
			from {$user_location}
		{/if}
		{checkActionsTpl location="tpl_user_profile_details_end"}
	</div>
	<div style="clear:both;"></div>
</div>
{checkActionsTpl location="tpl_user_center_just_below_header"}
<ul class="nav nav-tabs" id="profiletabs">
	{checkActionsTpl location="tpl_pligg_profile_sort_start"}
	<li {if $user_view eq 'profile'}class="active"{/if}><a {if $user_view eq 'profile'}data-toggle="tab" href="#personal_info"{else}href="{$user_url_personal_data}"{/if} class="navbut{$nav_pd}">{#PLIGG_Visual_User_PersonalData#}</a></li>
	{if $user_login eq $user_logged_in}
		<li {if $pagename eq 'profile'}class="active"{/if}><a href="{$URL_Profile}" class="navbut{$nav_set}">{#PLIGG_Visual_User_Setting#}</a></li>
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
				<div id="groups" class="span4">
					<legend>{#PLIGG_Visual_User_Profile_User_Groups#}</legend>
					<table class="table table-bordered table-striped">
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
				<div id="friends" class="span4">
					<legend>{#PLIGG_Visual_LS_My_Friends#}</legend>
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
							{if $friends}
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
							{else}
								<tr>
									<td colspan="3">
										<span style="text-transform:capitalize;">{$user_username}</span> {#PLIGG_Visual_User_Profile_No_Friends#}
									</td>
								</tr>
							{/if}
						</tbody>
					</table>
				</div>
			{/if}
			{if $Allow_Friends neq "0" && $user_authenticated eq true}	
				<div id="user_search" class="span4">
					<legend>{#PLIGG_Visual_AdminPanel_Users#}</legend>
					<table class="table table-bordered table-striped">
						<tbody>
							<tr>
								<td colspan="2">
									<form action="{$my_pligg_base}/user.php" method="get" {php} global $URLMethod, $my_base_url, $my_pligg_base; if ($URLMethod==2) print "onsubmit='document.location.href=\"{$my_base_url}{$my_pligg_base}/user/search/\"+encodeURIComponent(this.keyword.value); return false;'";{/php}>
										<div class="input-append">
											<input type="hidden" name="view" value="search">
											<input type="text" name="keyword" class="input-medium" placeholder="{#PLIGG_Visual_User_Search_Users#}"><button type="submit" class="btn">{#PLIGG_Visual_Search_Go#}</button>
										</div>
									</form>		
								</td>
							</tr>
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
									<td><i class="icon icon-user"></i> <a href="{$user_url_friends}">{#PLIGG_Visual_User_Profile_View_Friends#}</a></td>
									<td><i class="icon icon-user"></i> <a href="{$user_url_friends2}">{#PLIGG_Visual_User_Profile_View_Friends_2#}</a></td>
								</tr>
							{/if}
						</tbody>
					</table>
				</div>	
			{/if}
			{checkActionsTpl location="tpl_pligg_profile_info_end"}
			<div style="clear:both;"> </div>
		</div>
		{checkActionsTpl location="tpl_pligg_profile_tab_insert"}
	</div>
{/if}
{***********************************************************************************}
{if $user_view eq 'search'}
	{if $Allow_Friends neq "0"}	
		<form action="{$my_pligg_base}/user.php" method="get" {php} global $URLMethod, $my_base_url, $my_pligg_base; if ($URLMethod==2) print "onsubmit='document.location.href=\"{$my_base_url}{$my_pligg_base}/user/search/\"+encodeURIComponent(this.keyword.value); return false;'";{/php}>
			<div class="input-append">
				<input type="hidden" name="view" value="search">
				<input type="text" name="keyword" class="input-medium" placeholder="{#PLIGG_Visual_User_Search_Users#}"><button type="submit" class="btn">{#PLIGG_Visual_Search_Go#}</button>
			</div>
		</form>		
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
			<i class="icon icon-user"></i>
			<a href="{$user_url_friends}">{#PLIGG_Visual_User_Profile_View_Friends#}</a> 
			&nbsp;|&nbsp;
			<i class="icon icon-user"></i>
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
						<td width="120px">{*	{$userlist[nr].user_date}	*}
							{php}
								$pligg_date = $this->_vars['userlist'][$this->_sections['nr']['index']]['user_date'];
								echo date("F d, Y", strtotime($pligg_date));
							{/php}
						</td>
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
				<form action="{$my_pligg_base}/user.php" method="get" {php} global $URLMethod, $my_base_url, $my_pligg_base; if ($URLMethod==2) print "onsubmit='document.location.href=\"{$my_base_url}{$my_pligg_base}/user/search/\"+encodeURIComponent(this.keyword.value); return false;'";{/php}>
					<div class="input-append">
						<input type="hidden" name="view" value="search">
						<input type="text" name="keyword" class="input-medium" placeholder="{#PLIGG_Visual_User_Search_Users#}"><button type="submit" class="btn">{#PLIGG_Visual_Search_Go#}</button>
					</div>
				</form>		
			{/if}
			<i class="icon icon-user"></i> 
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
			{if check_for_enabled_module('simple_messaging',0.6) && $is_friend}<td align="center"><a href="{$my_pligg_base}/module.php?module=simple_messaging&view=compose&return={$templatelite.server.REQUEST_URI|urlencode}&to={$myfriend.user_login}"><i class="icon icon-envelope"></i></a></td>{/if}
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
{if $user_view eq 'viewfriends2'}
	{if $Allow_Friends neq "0"}	 
		{if $user_authenticated eq true} 
			<form action="{$my_pligg_base}/user.php" method="get" {php} global $URLMethod, $my_base_url, $my_pligg_base; if ($URLMethod==2) print "onsubmit='document.location.href=\"{$my_base_url}{$my_pligg_base}/user/search/\"+encodeURIComponent(this.keyword.value); return false;'";{/php}>
				<div class="input-append">
					<input type="hidden" name="view" value="search">
					<input type="text" name="keyword" class="input-medium" placeholder="{#PLIGG_Visual_User_Search_Users#}"><button type="submit" class="btn">{#PLIGG_Visual_Search_Go#}</button>
				</div>
			</form>		
		{/if}
		<a style="color:#fff;" href="{$user_url_friends}">
			<span class="label" style="background:#7E7E7E;padding:5px 8px;">
				<i class="icon icon-white icon-user"></i>
				{#PLIGG_Visual_User_Profile_View_Friends#}
			</span>
		</a>
		&nbsp;
		<a style="color:#fff;" href="{$user_url_friends2}">
			<span class="label" style="background:#BCBCBC;padding:5px 8px;">
				<i class="icon icon-white icon-user"></i>
				{#PLIGG_Visual_User_Profile_View_Friends_2#}
			</span>
		</a>
	{/if}
	<h2>{#PLIGG_Visual_User_Profile_Viewing_Friends_2a#}</h2>
	{if $friends}
	  	<table class="table table-bordered table-striped">
			{if check_for_enabled_module('simple_messaging',0.6) && $is_friend}
				<thead>
					<tr>
						<th>{#PLIGG_Visual_User_Profile_Username#}</th>
						<th>{#PLIGG_Visual_User_Profile_Message#}</th>
					</tr>
				</thead>
			{/if}
			<tbody>
				{foreach from=$friends item=myfriend}
					{php}
						$this->_vars['friend_avatar'] = get_avatar('small', $this->_vars['myfriend']['user_avatar_source'], $this->_vars['myfriend']['user_login'], $this->_vars['myfriend']['user_email']);
						$this->_vars['profileURL'] = getmyurl('user2', $this->_vars['myfriend']['user_login'], 'profile');
						$this->_vars['removeURL'] = getmyurl('user_add_remove', $this->_vars['myfriend']['user_login'], 'removefriend');
					{/php}

					<tr>
						<td><img src="{$friend_avatar}" align="absmiddle" /> <a href="{$profileURL}">{$myfriend.user_login}</a></td>
						{if check_for_enabled_module('simple_messaging',0.6) && $is_friend}<td><a href="{$my_pligg_base}/module.php?module=simple_messaging&view=compose&to={$myfriend.user_login}&return={$templatelite.server.REQUEST_URI|urlencode}"><i class="icon icon-envelope"></i></a></td>{/if}
					</tr>
				{/foreach}
			</tbody>
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
				<form action="{$my_pligg_base}/user.php" method="get" {php} global $URLMethod, $my_base_url, $my_pligg_base; if ($URLMethod==2) print "onsubmit='document.location.href=\"{$my_base_url}{$my_pligg_base}/user/search/\"+encodeURIComponent(this.keyword.value); return false;'";{/php}>
					<div class="input-append">
						<input type="hidden" name="view" value="search">
						<input type="text" name="keyword" class="input-medium" placeholder="{#PLIGG_Visual_User_Search_Users#}"><button type="submit" class="btn">{#PLIGG_Visual_Search_Go#}</button>
					</div>
				</form>		
			{/if}
			{if $user_login neq $user_logged_in}	  
				<i class="icon icon-user"></i>
				<a href="{$user_url_friends}">{#PLIGG_Visual_User_Profile_View_Friends#}</a>
				&nbsp;|&nbsp;
				<i class="icon icon-user"></i>
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
			<form action="{$my_pligg_base}/user.php" method="get" {php} global $URLMethod, $my_base_url, $my_pligg_base; if ($URLMethod==2) print "onsubmit='document.location.href=\"{$my_base_url}{$my_pligg_base}/user/search/\"+encodeURIComponent(this.keyword.value); return false;'";{/php}>
				<div class="input-append">
					<input type="hidden" name="view" value="search">
					<input type="text" name="keyword" class="input-medium" placeholder="{#PLIGG_Visual_User_Search_Users#}"><button type="submit" class="btn">{#PLIGG_Visual_Search_Go#}</button>
				</div>
			</form>		
		{/if}
		<i class="icon icon-user"></i>
		<a href="{$user_url_friends}">{#PLIGG_Visual_User_Profile_View_Friends#}</a>
		&nbsp;|&nbsp;
		<i class="icon icon-user"></i>
		<a href="{$user_url_friends2}">{#PLIGG_Visual_User_Profile_View_Friends_2#}</a>
	{/if}
	<h2 style="text-align:center;">{#PLIGG_Visual_User_Profile_Friend_Added#}</h2>
{/if}
{***********************************************************************************}
{if isset($user_page)}
	{$user_page}
{/if}
{if isset($user_pagination)}{checkActionsTpl location="tpl_pligg_pagination_start"}{$user_pagination}{checkActionsTpl location="tpl_pligg_pagination_end"}{/if}
{checkActionsTpl location="tpl_pligg_profile_end"}
<!--/user_center.tpl -->