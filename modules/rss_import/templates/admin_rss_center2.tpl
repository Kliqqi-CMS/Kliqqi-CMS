{config_load file=rss_import_lang_conf}
{* get a list of feeds in the database and put them into smarty varliable "FeedList" *}
{feedsListFeeds varname=FeedList}

{literal}
<script src="./modules/rss_import/js/pligg_effects.js" type="text/javascript"></script>
<script src="./modules/rss_import/js/EditInPlace.js" type="text/javascript"></script>

	<style type="text/css">
		.eip_editable { background-color: #ff9;border-left:0px;border-bottom:1px solid #828177;border-right:1px solid #828177; }
		.eip_savebutton { background-color: #36f; color: #fff; }
		.eip_cancelbutton { background-color: #000; color: #fff; }
		.eip_saving { background-color: #903; color: #fff; padding: 3px; }
		.eip_empty { color: #afafaf; }	
		.emptytext {padding:0px 4px;border-top:2px solid #828177;border-left:2px solid #828177;border-bottom:1px solid #B0B0B0;border-right:1px solid #B0B0B0;background:#F5F5F5;}
	</style>
{/literal}

<fieldset><legend><img src="{$my_pligg_base}/modules/rss_import/images/manage_rss.gif" align="absmiddle"/> {#PLIGG_RSS_Import#}</legend>

<br />
<img src="{$my_pligg_base}/modules/rss_import/images/feed_add.gif" align="absmiddle"/> 
<a href="{$my_pligg_base}/module.php?module=rss_import">Back to Feeds Lists</a>

<div id="import" style="display:none">
	<br/>
	<form>
		<textarea rows=10 cols=70 name="prebuiltfeed"></textarea>
		<input type = "hidden" name="module" value="rss_import">
		<input type = "hidden" name="action" value="importprebuiltfeed_go">
		<br /><input type = "submit" value="Import Feed" class="log2">
	</form>
</div>

<hr/>

{literal}
<script>
function verify(){
    msg = "Are you absolutely sure that you want to delete this feed?";
    //all we have to do is return the return value of the confirm() method
    return confirm(msg);
    }
</script>
{/literal}

{foreach from=$FeedList item=feed_id}
<?php global $main_smarty; $main_smarty->assign('fid', $_GET['feed_id']); ?>
{if $feed_id eq $fid} 

<h2>Edit the feed</h2>	
  <b><img src="{$my_pligg_base}/modules/rss_import/images/feed_bullet.gif" align="absmiddle"/> Feed Name: </b> <span class="emptytext">{eipItem 
item=qeip_FeedName unique=$feed_id ShowJS=TRUE}</span><br>
	<div style="margin-left:30px">
	<b>Feed URL: </b><span class="emptytext">{eipItem item=qeip_FeedURL unique=$feed_id ShowJS=TRUE}</span><br>

	<img src= "{$my_pligg_base}/modules/rss_import/images/feed_delete.gif" align="absmiddle"/> 
	<a href = "module.php?module=rss_import&action=dropfeed&feed_id={$feed_id}" onClick="return verify()">
	Delete this feed</a>

	<br />
	<img src="{$my_pligg_base}/modules/rss_import/images/feed_go.gif" align="absmiddle"/> <a href = "module.php?module=rss_import&action=exportfeed&feed_id={$feed_id}">Export this feed</a>
	<br />
	<img src="{$my_pligg_base}/modules/rss_import/images/feed_go.gif" align="absmiddle"/> <a href = "module.php?module=rss_import&action=examinefeed&feed_id={$feed_id}">Examine this feed</a>
	<br>
	<img src="{$my_pligg_base}/modules/rss_import/images/feed_go.gif" align="absmiddle"/> <a href = "module.php?module=rss_import_do_import&override={$feed_id}">Import this feed</a>
	<br><br>
	- <b>Feed Frequency (hours): </b><span class="emptytext">{eipItem item=qeip_FeedFreqHours unique=$feed_id ShowJS=TRUE}</span> -- how often to check for new items.<br>
	<br />
	- <b>Feed Order: </b><span class="emptytext">{eipItem item=qeip_FeedLastItemFirst unique=$feed_id ShowJS=TRUE}</span> -- Do we start with the last items first? 0 = no, 1 = yes<br>
	<br />	
	- <b>Feed Random Votes: </b><span class="emptytext">{eipItem item=qeip_FeedRandomVoteEnable unique=$feed_id ShowJS=TRUE}</span> -- Do we use a random number of votes? 0 = no, 1 = yes<br>
	<br />	
	- <b>Feed Votes (if not random): </b><span class="emptytext">{eipItem item=qeip_FeedVotes unique=$feed_id ShowJS=TRUE}</span> -- how many votes new items recieve (limit 200)<br>
	<br />
	- <b>Feed Votes Minimum (if random): </b><span class="emptytext">{eipItem item=qeip_FeedRandomVotesMin unique=$feed_id ShowJS=TRUE}</span> -- how many votes new items recieve (limit 200)<br>
	- <b>Feed Votes Maximum (if random): </b><span class="emptytext">{eipItem item=qeip_FeedRandomVotesMax unique=$feed_id ShowJS=TRUE}</span> -- how many votes new items recieve (limit 200)<br>
	<br />
	- <b>Feed Items Limit: </b><span class="emptytext">{eipItem item=qeip_FeedItemLimit unique=$feed_id ShowJS=TRUE}</span> -- how many new items to take from the feed when it's checked<br>
	- <b>Feed URL Dupes: </b><span class="emptytext">{eipItem item=qeip_FeedURLDupe unique=$feed_id ShowJS=TRUE}</span> -- Allow duplicate URL's 0=No, 1=Yes, Allow<br>
	- <b>Feed Title Dupes: </b><span class="emptytext">{eipItem item=qeip_FeedTitleDupe unique=$feed_id ShowJS=TRUE}</span> -- Allow duplicate Title's 0=No, 1=Yes, Allow<br>
	- <b>Feed Submitter Id (number): </b><span class="emptytext">{eipItem item=qeip_FeedSubmitter unique=$feed_id ShowJS=TRUE}</span></p> -- The ID of the person who will be listed as the submitter<br>
	- <b>Feed Category Id (number): </b><span class="emptytext">{eipItem item=qeip_FeedCategory unique=$feed_id ShowJS=TRUE}</span> -- The ID of the category to place these items into<br>
	
	<br>
	{* get a list of all field_links where `feed_id` = $feed_id and put them into the smarty variable "FeedLinks" *}
		{feedsListFeedLinks varname=FeedLinks feedid=$feed_id}
		
	{foreach from=$FeedLinks item=feed_link_id}
		{* get a list of fields in the RSS feed and put them into the smarty variable "eip_select" for the EIP selectbox to use *}
			{feedsListFeedFields feed_id=$feed_id}
	
		-- <b>feed field name</b>: <span class="emptytext">{eipItem item=qeip_FeedLink_FeedField unique=$feed_link_id ShowJS=TRUE}</span>

		{* get a list of pligg fields and put them into the smarty variable "eip_select" for the EIP selectbox to use *}
			{feedsListPliggLinkFields}
			
		--- <b>pligg field name</b>: <span class="emptytext">{eipItem item=qeip_FeedLink_PliggField unique=$feed_link_id ShowJS=TRUE}</span>

		--- <a href = "module.php?module=rss_import&action=dropfieldlink&FeedLinkId={$feed_link_id}">Remove this link</a>
 		<br>

	{/foreach}
	
	-- <a href = "module.php?module=rss_import&action=addnewfieldlink&FeedLinkId={$feed_id}">Add a new field link</a>
	</div>
	<hr>
	
{/if}
{/foreach}
<br/>
</fieldset>
{config_load file=rss_import_pligg_lang_conf}