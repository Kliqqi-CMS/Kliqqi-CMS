<div id="feeds">
	<ul id="rssfeeds">
		<li>
			{section name=thecat loop=$cat_array}
				{if $lastspacer eq ""}
					{assign var=lastspacer value=$cat_array[thecat].spacercount}
				{/if}

					<li><a href="{$URL_rsscategory, $cat_array[thecat].auto_id}" target="_blank" style="border:none;"><img src="{$my_pligg_base}/templates/{$the_template}/images/rss.gif" border="0" alt="RSS" /></a><span class="feedname"><a href="{$URL_rsscategory, $cat_array[thecat].auto_id}" target="_blank" style="border:none;">{$cat_array[thecat].name}</a></span></li>
					<p><input type="text" class="rssfield" value="{$my_base_url}{$URL_rsscategory, $cat_array[thecat].auto_id}"></p>
					<div class="feed-spacer">&nbsp;</div>

				{assign var=lastspacer value=$cat_array[thecat].spacercount}
			{/section}
		</li>
	</ul>
</div>