{checkActionsTpl location="tpl_pligg_admin_stats_widget_start"}
<table class="table table-condensed table-striped" style="margin-bottom:0;">
	{if $sw_version eq "1"}
		<tr>
			<td>
				<strong>
				{#PLIGG_Statistics_Widget_Version#}:
				</strong>
			</td>
			<td>
				{$version_number}
			</td>
		</tr>
	{/if}
	{if $sw_members eq "1"}
		<tr>
			<td>
				<strong>
				{#PLIGG_Statistics_Widget_Front_Members#}:
				</strong>
			</td>
			<td>
				{$members}
			</td>
		</tr>
	{/if}
	{if $sw_groups eq "1"}
		<tr>
			<td>
				<strong>
				{#PLIGG_Statistics_Widget_Front_Groups#}:
				</strong>
			</td>
			<td>
				{$grouptotal}
			</td>
		</tr>
	{/if}
	{if $sw_links eq "1"}
		<tr>
			<td>
				<strong>
				{#PLIGG_Statistics_Widget_Front_Submissions#}:
				</strong>
			</td>
			<td>
				{$total}
			</td>
		</tr>
	{/if}
	{if $sw_members eq "1"}
		<tr>
			<td>
				<strong>
				{#PLIGG_Statistics_Widget_Front_Published#}:
				</strong>
			</td>
			<td>
				{$published_submissions_count}
			</td>
		</tr>
	{/if}
	{if $sw_members eq "1"}
		<tr>
			<td>
				<strong>
				{#PLIGG_Statistics_Widget_Front_New#}:
				</strong>
			</td>
			<td>
				{$new_submissions_count}
			</td>
		</tr>
	{/if}
	{if $sw_members eq "1"}
		<tr>
			<td>
				<strong>
				{#PLIGG_Statistics_Widget_Front_Votes#}:
				</strong>
			</td>
			<td>
				{$votes}
			</td>
		</tr>
	{/if}
	{if $sw_members eq "1"}
		<tr>
			<td>
				<strong>
				{#PLIGG_Statistics_Widget_Front_Comments#}:
				</strong>
			</td>
			<td>
				{$comments}
			</td>
		</tr>
	{/if}
	{if $sw_members eq "1"}
		<tr>
			<td>
				<strong>
				{#PLIGG_Statistics_Widget_Front_Member#}:
				</strong>
			</td>
			<td>
				<a href="{$URL_user, $last_user}" title="{#PLIGG_Visual_AdminPanel_Latest_User#}">{$last_user}</a>
			</td>
		</tr>
	{/if}
	{if $sw_members eq "1"}
		<tr>
			<td>
				<strong>
				{#PLIGG_Statistics_Widget_PHP_Version#}:
				</strong>
			</td>
			<td>
				{if $phpver eq "1"}{php}
					if( function_exists( "phpversion" ) ){
						print phpversion();
					}else{
						print 'Unknown';
					}
				{/php}{/if}
			</td>
		</tr>
	{/if}
	{if $sw_members eq "1"}
		<tr>
			<td>
				<strong>
				{#PLIGG_Statistics_Widget_MySQL_Version#}:
				</strong>
			</td>
			<td>
				{php}
					$link = mysqli_connect(localhost,EZSQL_DB_USER,EZSQL_DB_PASSWORD);
					/* check connection */
					if (mysqli_connect_errno()) {
						printf("Connect failed: %s\n", mysqli_connect_error());
						exit();
					}
					$my_sql = mysqli_get_server_info($link);
					// $my_sql returns will be something like the version and -log (5.5.24-log). we have to just grab the version number
					$my_sql_version = substr($my_sql, 0, strpos($my_sql, "-"));
					echo $my_sql_version;
					mysqli_close($link);
				{/php}
			</td>
		</tr>
	{/if}
	{if $sw_members eq "1"}
		<tr>
			<td>
				<strong>
				{#PLIGG_Statistics_Widget_DB_Size#}:
				</strong>
			</td>
			<td>
				{$dbsize}
			</td>
		</tr>
	{/if}
	{checkActionsTpl location="tpl_pligg_admin_stats_widget_intable"}
</table>
{checkActionsTpl location="tpl_pligg_admin_stats_widget_end"}