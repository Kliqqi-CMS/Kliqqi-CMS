{************************************
********** Footer Template **********
*************************************}
<!-- footer.tpl -->
<div id="footer">
	{checkActionsTpl location="tpl_pligg_footer_start"}
	<span class="subtext"> 
		Copyright &copy; {php} echo date('Y'); {/php} {#PLIGG_Visual_Name#} 
		| Pligg <a href="http://pligg.com/" target="_blank">Content Management System</a> 
		| <a href="http://pligg.com/hosting/" target="_blank">Web Hosting</a> 
		| <a href="{$URL_advancedsearch}">{#PLIGG_Visual_Search_Advanced#}</a> 
		{if $URL_rss_page}
			| <a href="{$URL_rss_page}" target="_blank"><img src="{$my_pligg_base}/templates/{$the_template}/img/rss.gif" width="12px" height="12px" align="top" border="0" alt="RSS" /> RSS</a>
		{/if}
		| <a href="{$my_base_url}{$my_pligg_base}/rssfeeds.php">{#PLIGG_Visual_RSS_Feeds#}</a> 
	</span>
	{checkActionsTpl location="tpl_pligg_footer_end"}
</div>
<!--/footer.tpl -->