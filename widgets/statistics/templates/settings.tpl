<form method="get">
	<input type="hidden" name="widget" value="statistics">
	<p>{#PLIGG_Statistics_Widget_Description#}</p>
	<p style="margin:5px 7px 0 7px;">
		<input type="hidden" name="version" value="0">
		<input type="checkbox" name="version" value="1" {if $sw_version eq "1"}checked{/if}> {#PLIGG_Statistics_Widget_Version#}<br />
		<input type="hidden" name="members" value="0">
		<input type="checkbox" name="members" value="1" {if $sw_members eq "1"}checked{/if}> {#PLIGG_Statistics_Widget_Members#}<br />
		<input type="hidden" name="groups" value="0">
		<input type="checkbox" name="groups" value="1" {if $sw_groups eq "1"}checked{/if}> {#PLIGG_Statistics_Widget_Groups#}<br />
		<input type="hidden" name="links" value="0">
		<input type="checkbox" name="links" value="1" {if $sw_links eq "1"}checked{/if}> {#PLIGG_Statistics_Widget_Links#}<br />
		<input type="hidden" name="published" value="0">
		<input type="checkbox" name="published" value="1" {if $sw_published eq "1"}checked{/if}> {#PLIGG_Statistics_Widget_Published#}<br />
		<input type="hidden" name="new" value="0">
		<input type="checkbox" name="new" value="1" {if $sw_new eq "1"}checked{/if}> {#PLIGG_Statistics_Widget_New#}<br />
		<input type="hidden" name="votes" value="0">
		<input type="checkbox" name="votes" value="1" {if $sw_votes eq "1"}checked{/if}> {#PLIGG_Statistics_Widget_Votes#}<br />
		<input type="hidden" name="comments" value="0">
		<input type="checkbox" name="comments" value="1" {if $sw_comments eq "1"}checked{/if}> {#PLIGG_Statistics_Widget_Comments#}<br />
		<input type="hidden" name="latestuser" value="0">
		<input type="checkbox" name="latestuser" value="1" {if $sw_newuser eq "1"}checked{/if}> {#PLIGG_Statistics_Widget_Latest_User#}<br />
		<input type="hidden" name="phpver" value="0">
		<input type="checkbox" name="phpver" value="1" {if $phpver eq "1"}checked{/if}> {#PLIGG_Statistics_Widget_PHP_Version#}<br />
		<input type="hidden" name="mysqlver" value="0">
		<input type="checkbox" name="mysqlver" value="1" {if $mysqlver eq "1"}checked{/if}> {#PLIGG_Statistics_Widget_MySQL_Version#}<br />
		<input type="hidden" name="dbsize" value="0">
		<input type="checkbox" name="dbsize" value="1" {if $sw_dbsize eq "1"}checked{/if}> {#PLIGG_Statistics_Widget_DB_Size#}<br />
	</p>
	<br />
	<p style="margin:0 0 5px 8px;">
		<input type="submit" class="btn btn-primary" value="{#PLIGG_Statistics_Widget_Save#}">
	</p>
</form>