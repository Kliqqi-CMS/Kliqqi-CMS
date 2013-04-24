{config_load file=sidebar_stats_lang_conf}
{*
<div class="headline">
	<div class="sectiontitle" style="border:0;">{#Sidebar_Stats_Statistics#}</div>
</div>
*}
<div class="boxcontent" id="sidebar-comments">
	<table class="table table-condensed table-bordered table-striped" id="sidebar_stats">
		<tbody>
			<tr>
				<td><strong>{#Sidebar_Stats_Newest_Member#}</strong></td>
				<td>{* <a href="{$my_base_url}{$my_pligg_base}/user.php?login={$sidebar_stats_last_user}"> *}{$sidebar_stats_last_user}{* </a> *}</td>
			</tr>
			<tr>
				<td><strong>{#Sidebar_Stats_Members#}</strong></td>
				<td>{$sidebar_stats_members}</td>
			</tr>
			<tr>
				<td><strong>{#Sidebar_Stats_Stories#}</strong></td>
				<td>{$sidebar_stats_stories}</td>
			</tr>
			<tr>
				<td><strong>{#Sidebar_Stats_Published#}</strong></td>
				<td>{$sidebar_stats_published}</td>
			</tr>
			<tr>
				<td><strong>{#Sidebar_Stats_New#}</strong></td>
				<td>{$sidebar_stats_new}</td>
			</tr>
			<tr>
				<td><strong>{#Sidebar_Stats_Votes#}</strong></td>
				<td>{$sidebar_stats_votes}</td>
			</tr>
			<tr>
				<td><strong>{#Sidebar_Stats_Comments#}</strong></td>
				<td>{$sidebar_stats_comments}</td>
			</tr>
			<tr>
				<td><strong>{#Sidebar_Stats_Comment_Votes#}</strong></td>
				<td>{$sidebar_stats_comment_votes}</td>
			</tr>
			{if $enable_group eq "true"}
				<tr>
					<td><strong>{#Sidebar_Stats_Groups#}</strong></td>
					<td>{$sidebar_stats_groups}</td>
				</tr>
			{/if}
			{*
			<tr>
				<td><strong>{#Sidebar_Stats_Bookmarked#}</strong></td>
				<td>{$sidebar_stats_saved}</td>
			</tr>
			<tr>
				<td><strong>{#Sidebar_Stats_Files#}</strong></td>
				<td>{$sidebar_stats_files}</td>
			</tr>
			<tr>
				<td><strong>{#Sidebar_Stats_Messages#}</strong></td>
				<td>{$sidebar_stats_messages}</td>
			</tr>
			<tr>
				<td><strong>{#Sidebar_Stats_Categories#}</strong></td>
				<td>{$sidebar_stats_categories}</td>
			</tr>
			*}
		</tbody>
	</table>	
</div>
{config_load file=sidebar_stats_pligg_lang_conf}