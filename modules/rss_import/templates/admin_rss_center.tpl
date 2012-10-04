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

<img src="{$my_pligg_base}/modules/rss_import/images/feed_go.gif" align="absmiddle"/> <a href="module.php?module=rss_import_do_import"><strong>Import all feeds</strong></a>
<hr>
<img src="{$my_pligg_base}/modules/rss_import/images/feed_add.gif" align="absmiddle"/> <a href="module.php?module=rss_import&action=addnewfeed"><strong>Add a new feed</strong></a>
<br />
<img src="{$my_pligg_base}/modules/rss_import/images/feed_add.gif" align="absmiddle"/> 
{php} echo "<a href=\"#\" onclick=\"new Effect.toggle('import','appear', {queue: 'end'});\"><strong>Import pre-built feed</strong></a>";{/php}

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
    msg = "Are you sure that you want to delete this feed?";
    //all we have to do is return the return value of the confirm() method
    return confirm(msg);
    }
</script>
{/literal}

{foreach from=$FeedList item=feed_id}
	
	<strong>Feed Name: </strong><span class="emptytext">{eipItem item=qeip_FeedName unique=$feed_id ShowJS=TRUE}</span><br>
	<strong>Feed URL: </strong><span class="emptytext">{eipItem item=qeip_FeedURL unique=$feed_id ShowJS=TRUE}</span><br>

	<img src="{$my_pligg_base}/modules/rss_import/images/feed_go.gif" align="absmiddle"/> <a href="module.php?module=rss_import&action=editfeed&feed_id={$feed_id}">Edit</a> &nbsp;
	<img src="{$my_pligg_base}/modules/rss_import/images/feed_delete.gif" align="absmiddle"/> <a href="module.php?module=rss_import&action=dropfeed&feed_id={$feed_id}" onClick="return verify()">Delete</a> &nbsp;
	<img src="{$my_pligg_base}/modules/rss_import/images/feed_go.gif" align="absmiddle"/> <a href="module.php?module=rss_import&action=exportfeed&feed_id={$feed_id}">Export</a> &nbsp;
	<img src="{$my_pligg_base}/modules/rss_import/images/feed_go.gif" align="absmiddle"/> <a href="module.php?module=rss_import&action=examinefeed&feed_id={$feed_id}">Examine</a> &nbsp;
	<img src="{$my_pligg_base}/modules/rss_import/images/feed_go.gif" align="absmiddle"/> <a href="module.php?module=rss_import_do_import&override={$feed_id}">Import</a> &nbsp;

	<br>
	<hr>
	
{/foreach}
<br/>

{config_load file=rss_import_pligg_lang_conf}