<table style="width:70%;min-width:500px;float:left;">
	<tr>
		<td valign="top" width="135px">
			<strong>
			{if $sw_version eq "1"}{#PLIGG_Statistics_Widget_Version#}:<br />{/if}
			{if $sw_members eq "1"}{#PLIGG_Statistics_Widget_Front_Members#}:<br />{/if}
			{if $sw_groups eq "1"}{#PLIGG_Statistics_Widget_Front_Groups#}:<br />{/if}
			{if $sw_links eq "1"}{#PLIGG_Statistics_Widget_Front_Submissions#}:<br />{/if}
			{if $sw_published eq "1"}{#PLIGG_Statistics_Widget_Front_Published#}:<br />{/if}
			{if $sw_upcoming eq "1"}{#PLIGG_Statistics_Widget_Front_Upcoming#}:<br />{/if}
			{if $sw_votes eq "1"}{#PLIGG_Statistics_Widget_Front_Votes#}:<br />{/if}
			{if $sw_comments eq "1"}{#PLIGG_Statistics_Widget_Front_Comments#}:<br />{/if}
			{if $sw_newuser eq "1"}{#PLIGG_Statistics_Widget_Front_Member#}:<br />{/if}
			{if $phpver eq "1"}{#PLIGG_Statistics_Widget_PHP_Version#}:<br />{/if}
			{if $mysqlver eq "1"}{#PLIGG_Statistics_Widget_MySQL_Version#}:<br />{/if}
			{if $sw_dbsize eq "1"}{#PLIGG_Statistics_Widget_DB_Size#}:{/if}
			</strong>
		</td>
		<td valign="top">
			{if $sw_version eq "1"}{$version_number}<br />{/if}
			{if $sw_members eq "1"}{$members}<br />{/if}
			{if $sw_groups eq "1"}{$grouptotal}<br />{/if}
			{if $sw_links eq "1"}{$total}<br />{/if}
			{if $sw_published eq "1"}{$published}<br />{/if}
			{if $sw_upcoming eq "1"}{$queued}<br />{/if}
			{if $sw_votes eq "1"}{$votes}<br />{/if}
			{if $sw_comments eq "1"}{$comments}<br />{/if}
			{if $sw_newuser eq "1"}<a href="{$URL_user, $last_user}" title="{#PLIGG_Visual_AdminPanel_Latest_User#}" class="colorbox_iframe2">{$last_user}</a><br />{/if}
			{if $phpver eq "1"}{php}
			if( function_exists( "phpversion" ) ){
				print phpversion();
			}else{
				print 'Unknown';
			}
			{/php}<br />{/if}
			{if $mysqlver eq "1"}
				{php}
					function find_SQL_Version() {
					   $output = shell_exec('mysql -V');
					   preg_match('@[0-9]+\.[0-9]+\.[0-9]+@', $output, $version);
					   return $version[0];
					}
					echo find_SQL_Version();
				{/php}<br />
			{/if}
			{if $sw_dbsize eq "1"}{$dbsize}{/if}
		</td>	
	</tr>
</table>
