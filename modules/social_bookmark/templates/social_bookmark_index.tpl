{checkActionsTpl location="tpl_pligg_module_social_bookmark_start"}
{config_load file=social_bookmark_lang_conf}
<span id="linksummaryAddLink">
	| <a href="javascript://" onclick="var replydisplay=document.getElementById('addto-{$link_shakebox_index}').style.display ? '' : 'none';document.getElementById('addto-{$link_shakebox_index}').style.display = replydisplay;"> {#Social_Bookmark_AddTo#}</a>&nbsp;
</span>
<span id="addto-{$link_shakebox_index}" style="display:none">
<div style="position:absolute;display:block;background:#fff;padding:10px;margin:10px 0 0 100px;font-size:12px;border:2px solid #000;z-index:999;">
	&nbsp;&nbsp;<a title="submit '{$title_short}' to Twitter" href="http://twitter.com/home?status" onclick="window.open('http://twitter.com/home?status={$enc_title_short}%20{$enc_url}', '{#PLIGG_Visual_LS_Delicious#}','toolbar=no,width=700,height=400'); return false;"><img src="{$my_base_url}{$my_pligg_base}/modules/social_bookmark/images/twitter.png" border="0" alt="submit '{$title_short}' to Twitter" /></a>
	&nbsp;&nbsp;<a title="submit '{$title_short}' to del.icio.us" href="http://del.icio.us/post" onclick="window.open('http://del.icio.us/post?v=4&amp;noui&amp;jump=close&amp;url={$enc_url}&amp;title={$enc_title_short}', '{#PLIGG_Visual_LS_Delicious#}','toolbar=no,width=700,height=400'); return false;"><img src="{$my_base_url}{$my_pligg_base}/modules/social_bookmark/images/delicious.png" border="0" alt="submit '{$title_short}' to del.icio.us" /></a>
	&nbsp;&nbsp;<a title="submit '{$title_short}' to digg" href="http://digg.com/submit?phase=2&amp;url={$enc_url}&amp;title={$title_short}&amp;bodytext={$story_content}"><img src="{$my_base_url}{$my_pligg_base}/modules/social_bookmark/images/digg.png" border="0" alt="submit '{$title_short}' to digg" /></a>
	&nbsp;&nbsp;<a title="submit '{$title_short}' to reddit" href="http://reddit.com/submit?url={$enc_url}&amp;title={$title_short}"><img src="{$my_base_url}{$my_pligg_base}/modules/social_bookmark/images/reddit.gif" border="0" alt="submit '{$title_short}' to reddit" /></a>
	&nbsp;&nbsp;<a title="submit '{$title_short}' to facebook" href="http://www.facebook.com/sharer.php?u={$enc_url}&t={$title_short}"><img src="{$my_base_url}{$my_pligg_base}/modules/social_bookmark/images/facebook.gif" border="0" alt="submit '{$title_short}' to facebook" /></a>
	&nbsp;&nbsp;<a title="submit '{$title_short}' to technorati" href="http://www.technorati.com/faves?add={$enc_url}"><img src="{$my_base_url}{$my_pligg_base}/modules/social_bookmark/images/technorati.gif" border="0" alt="submit '{$title_short}' to technorati" /></a>
	&nbsp;&nbsp;<a title="submit '{$title_short}' to slashdot" href="http://slashdot.org/bookmark.pl?url={$enc_url}&title={$title_short}"><img src="{$my_base_url}{$my_pligg_base}/modules/social_bookmark/images/slashdot.gif" border="0" alt="submit '{$title_short}' to slashdot" /></a>
	&nbsp;&nbsp;<a title="submit '{$title_short}' to Stumbleupon" href="http://www.stumbleupon.com/submit?url={$enc_url}&amp;title={$title_short}"><img src="{$my_base_url}{$my_pligg_base}/modules/social_bookmark/images/icon-stumbleupon.gif" border="0" alt="submit '{$title_short}' to Stumbleupon" /></a>
	&nbsp;&nbsp;<a title="submit '{$title_short}' to Windows Live" href="https://favorites.live.com/quickadd.aspx?url={$enc_url}&title={$title_short}"><img src="{$my_base_url}{$my_pligg_base}/modules/social_bookmark/images/windowslive.gif" border="0" alt="submit '{$title_short}' to Windows Live" /></a>
	&nbsp;&nbsp;<a title="submit '{$title_short}' to squidoo" href="http://www.squidoo.com/lensmaster/bookmark?{$enc_url}"><img src="{$my_base_url}{$my_pligg_base}/modules/social_bookmark/images/squidoo.gif" border="0" alt="submit '{$title_short}' to squidoo" /></a>
	&nbsp;&nbsp;<a title="submit '{$title_short}' to yahoo" href="http://myweb2.search.yahoo.com/myresults/bookmarklet?u={$enc_url}&amp;title={$title_short}"><img src="{$my_base_url}{$my_pligg_base}/modules/social_bookmark/images/yahoomyweb.png" border="0" alt="submit '{$title_short}' to yahoo" /></a>
	&nbsp;&nbsp;<a title="submit '{$title_short}' to google" href="http://www.google.com/bookmarks/mark?op=edit&bkmk={$enc_url}&title={$title_short}"><img src="{$my_base_url}{$my_pligg_base}/modules/social_bookmark/images/googlebookmarks.gif" border="0" alt="submit '{$title_short}' to google" /></a>
	&nbsp;&nbsp;<a title="submit '{$title_short}' to ask" href=" http://myjeeves.ask.com/mysearch/BookmarkIt?v=1.2&t=webpages&url={$enc_url}&title={$title_short}"><img src="{$my_base_url}{$my_pligg_base}/modules/social_bookmark/images/ask.gif" border="0" alt="submit '{$title_short}' to ask" /></a>
	<hr style="margin:10px 0;" />
	<p style="font-weight:bold;margin:0px;">Story URL</p>
	{literal}
	<script type="text/javascript">
		function select_all()
		{
			var text_val=eval("document.storyurl.thisurl");
			text_val.focus();
			text_val.select();
		}
	</script>
	{/literal}
	<form name="storyurl" style="margin-bottom:5px"><input type="text" name="thisurl" class="col-md-4" style="margin-bottom:0;" onClick="select_all();" value="{$my_base_url}{$story_url}"></form>
</div>
</span>

{checkActionsTpl location="tpl_pligg_module_social_bookmark_end"}
{config_load file=social_bookmark_pligg_lang_conf}
