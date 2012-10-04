{config_load file=rss_import_lang_conf}
{* get a list of feeds in the database and put them into smarty varliable "FeedList" *}
{feedsListFeeds varname=FeedList}

{literal}
<script src="./modules/rss_import/js/pligg_effects.js" type="text/javascript"></script>
<script src="./modules/rss_import/js/EditInPlace.js" type="text/javascript"></script>

	<style type="text/css">
		.eip_editable { background-color: #ff9;cursor: pointer;}
		.eip_savebutton { }
		.eip_cancelbutton { margin-left:4px;}
		.eip_saving { background-color: #903; color: #fff; padding: 3px; }
		.eip_empty { color: #afafaf;cursor: pointer; }
	</style>
{/literal}

<legend>{#PLIGG_RSS_Import#}</legend>

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

		<h3>Edit the feed</h3>	
		<strong>Feed Name:</strong> <span class="emptytext">{eipItem item=qeip_FeedName unique=$feed_id ShowJS=TRUE}</span>
		<br />
		<strong>Feed URL:</strong> <span class="emptytext">{eipItem item=qeip_FeedURL unique=$feed_id ShowJS=TRUE}</span>
		<br />
		<img src="{$my_pligg_base}/modules/rss_import/images/feed_delete.gif" align="absmiddle"/> <a href="module.php?module=rss_import&action=dropfeed&feed_id={$feed_id}" onClick="return verify()">Delete this feed</a>
		<br />
		<img src="{$my_pligg_base}/modules/rss_import/images/feed_go.gif" align="absmiddle"/> <a href = "module.php?module=rss_import&action=exportfeed&feed_id={$feed_id}">Export this feed</a>
		<br />
		<img src="{$my_pligg_base}/modules/rss_import/images/feed_go.gif" align="absmiddle"/> <a href = "module.php?module=rss_import&action=examinefeed&feed_id={$feed_id}">Examine this feed</a>
		<br />
		<img src="{$my_pligg_base}/modules/rss_import/images/feed_go.gif" align="absmiddle"/> <a href = "module.php?module=rss_import_do_import&override={$feed_id}">Import this feed</a>
		<br /><br />
		<table class="table table-bordered">
			<thead>
				<tr>
					<th>Title</th>
					<th>Value (click to edit)</th>
					<th>Description</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>Feed Frequency (hours)</td>
					<td><span class="emptytext tablevalue">{eipItem item=qeip_FeedFreqHours unique=$feed_id ShowJS=TRUE}</span></td>
					<td>How often to check for new items.</td>
				</tr>
				<tr>
					<td>Feed Order</td>
					<td><span class="emptytext tablevalue">{eipItem item=qeip_FeedLastItemFirst unique=$feed_id ShowJS=TRUE}</span></td>
					<td>Do we start with the last items first? 0 = no, 1 = yes</td>
				</tr>
				<tr>	
					<td>Feed Random Votes</td>
					<td><span class="emptytext tablevalue">{eipItem item=qeip_FeedRandomVoteEnable unique=$feed_id ShowJS=TRUE}</span></td>
					<td>Do we use a random number of votes? 0 = no, 1 = yes</td>
				</tr>
				<tr>	
					<td>Feed Votes (if not random)</td>
					<td><span class="emptytext tablevalue">{eipItem item=qeip_FeedVotes unique=$feed_id ShowJS=TRUE}</span>
					<td>How many votes new items recieve (limit 200)
				</tr>
				<tr>
					<td>Feed Votes Minimum (if random)</td>
					<td><span class="emptytext tablevalue">{eipItem item=qeip_FeedRandomVotesMin unique=$feed_id ShowJS=TRUE}</span>
					<td>How many votes new items recieve (limit 200)
				</tr>
				<tr>
					<td>Feed Votes Maximum (if random)</td>
					<td><span class="emptytext tablevalue">{eipItem item=qeip_FeedRandomVotesMax unique=$feed_id ShowJS=TRUE}</span>
					<td>How many votes new items recieve (limit 200)</td>
				</tr>
				<tr>
					<td>Feed Items Limit</td>
					<td><span class="emptytext tablevalue">{eipItem item=qeip_FeedItemLimit unique=$feed_id ShowJS=TRUE}</span></td>
					<td>how many new items to take from the feed when it's checked</td>
				</tr>
				<tr>
					<td>Feed URL Dupes</td>
					<td><span class="emptytext tablevalue">{eipItem item=qeip_FeedURLDupe unique=$feed_id ShowJS=TRUE}</span></td>
					<td>Allow duplicate URL's 0=No, 1=Yes, Allow</td>
				</tr>
				<tr>
					<td>Feed Title Dupes</td>
					<td><span class="emptytext tablevalue">{eipItem item=qeip_FeedTitleDupe unique=$feed_id ShowJS=TRUE}</span></td>
					<td>Allow duplicate Title's 0=No, 1=Yes, Allow</td>
				</tr>
				<tr>
					<td>Feed Submitter Id (number)</td>
					<td><span class="emptytext tablevalue">{eipItem item=qeip_FeedSubmitter unique=$feed_id ShowJS=TRUE}</span></td>
					<td>The ID of the person who will be listed as the submitter</td>
				</tr>
				<tr>
					<td>Feed Category Id (number)</td>
					<td><span class="emptytext tablevalue">{eipItem item=qeip_FeedCategory unique=$feed_id ShowJS=TRUE}</span></td>
					<td>The ID of the category to place these items into</td>
				</tr>
				<br>
				{* get a list of all field_links where `feed_id` = $feed_id and put them into the smarty variable "FeedLinks" *}
					{feedsListFeedLinks varname=FeedLinks feedid=$feed_id}
			</tbody>
		</table>
		<h4>Feed Content</h4>
		<p>Below is where you associate feed fields with Pligg fields, which tells the Pligg RSS Importer what data should be used where. For example you will want to connect the feed's title value to your Pligg link_title value.</p>
		
		<table class="table table-bordered">
			<thead>
				<tr>
					<th>Feed Field Name</th>
					<th>Pligg Field Name</th>
					<th>Remove Item</th>
				</tr>
			</thead>
			<tbody>
				{foreach from=$FeedLinks item=feed_link_id}					
					<tr>
						{* get a list of fields in the RSS feed and put them into the smarty variable "eip_select" for the EIP selectbox to use *}
						{feedsListFeedFields feed_id=$feed_id}
						
						<td><span class="emptytext">{eipItem item=qeip_FeedLink_FeedField unique=$feed_link_id ShowJS=TRUE}</span></td>

						{* get a list of pligg fields and put them into the smarty variable "eip_select" for the EIP selectbox to use *}
						{feedsListPliggLinkFields}
						
						<td><span class="emptytext">{eipItem item=qeip_FeedLink_PliggField unique=$feed_link_id ShowJS=TRUE}</span></td>
						<td><a href = "module.php?module=rss_import&action=dropfieldlink&FeedLinkId={$feed_link_id}">Remove this item</a></td>
					</tr>
				{/foreach}
				<tr>
					<td colspan="3">
						<a href = "module.php?module=rss_import&action=addnewfieldlink&FeedLinkId={$feed_id}">Add a new field item</a>
					</td>
				</tr>
			</tbody>
		</table>
	{/if}
{/foreach}

<br /><br />
{config_load file=rss_import_pligg_lang_conf}