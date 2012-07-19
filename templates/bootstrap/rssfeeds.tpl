{************************************
********* RSS Feeds Template ********
*************************************}
<!-- rssfeeds.tpl -->
<table class="table table-bordered table-striped">
	<thead>
		<tr>
			<th>Category</th>
			<th>RSS URL</th>
		</tr>
	</thead>
	<tbody>
		{section name=thecat loop=$cat_array}
			{if $lastspacer eq ""}
				{assign var=lastspacer value=$cat_array[thecat].spacercount}
			{/if}
			<tr>
				<td><a href="{$URL_rsscategory, $cat_array[thecat].auto_id}" target="_blank" style="border:none;"><img src="{$my_pligg_base}/templates/{$the_template}/images/rss.gif" border="0" alt="RSS" /></a> <a href="{$URL_rsscategory, $cat_array[thecat].auto_id}" target="_blank" style="border:none;">{$cat_array[thecat].name}</a></td>
				<td><input type="text" class="span4" style="margin-bottom:0;" value="{$my_base_url}{$URL_rsscategory, $cat_array[thecat].auto_id}"></td>
			</tr>
			{assign var=lastspacer value=$cat_array[thecat].spacercount}
		{/section}
	</tbody>
</table>
<!--/rssfeeds.tpl -->