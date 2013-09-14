{************************************
******** User Search Results ********
 This template controls the user search results pages
*************************************}

<!-- user_search_center.tpl -->

<div class="row">
	<div class="col-md-12">
		<div class="input-group">
			<form action="{$my_pligg_base}/user.php" method="get" {php} global $URLMethod, $my_base_url, $my_pligg_base; if ($URLMethod==2) print "onsubmit='document.location.href=\"{$my_base_url}{$my_pligg_base}/user/search/\"+encodeURIComponent(this.keyword.value); return false;'";{/php}>
				<span class="input-group-btn">
					<input type="hidden" name="view" value="search">
					<input type="text" name="keyword" class="form-control" placeholder="{#PLIGG_Visual_User_Search_Users#}">
					<button class="btn btn-primary" type="button">Search Accounts</button>
				</span>
			</form>	
		</div><!-- /input-group -->
	</div><!-- /.col-md-6 -->
</div><!-- /.row -->

<hr />

{***********************************************************************************}
{if $user_view eq 'search'}
	{if $userlist}
		<h4>{#PLIGG_Visual_Search_SearchResults#} &quot;{$search}&quot;</h4>
		<table class="table table-bordered table-striped">
			<thead class="table_title">
				<tr>
					<th>{#PLIGG_Visual_Login_Username#}</th>
					<th>{#PLIGG_Visual_User_Profile_Joined#}</th>
					<th>{#PLIGG_User_Profile_Social#}</th>
					{if $Allow_Friends}<th>Add/Remove</th>{/if}
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
						{if $Allow_Friends}
							<td style="text-align:center;">{if $userlist[nr].status eq 0}	
									<a href="{$userlist[nr].add_friend}"><img src="{$my_pligg_base}/templates/{$the_template}/img/user_add.gif" align="absmiddle" border="0" /></a>
								{else}
									<a href="{$userlist[nr].remove_friend}"><img src="{$my_pligg_base}/templates/{$the_template}/img/user_delete.gif" align="absmiddle" border="0"/></a>
								{/if}
							</td>
						{/if}						
					</tr>
				{/section}
			</tbody>
		</table>
	{else}
		<h3>{#PLIGG_Visual_Search_NoResults#} '{$search}'</h3>
	{/if}
{/if}

{***********************************************************************************}

{if isset($user_page)}
	{$user_page}
{/if}

{if isset($user_pagination)}
	{checkActionsTpl location="tpl_pligg_pagination_start"}
	{$user_pagination}
	{checkActionsTpl location="tpl_pligg_pagination_end"}
{/if}
{checkActionsTpl location="tpl_pligg_profile_end"}

<!--/user_search_center.tpl -->