{literal}
<style type="text/css">
.pligg_news_title {
	font-size:15px;
	border-bottom:1px dotted #ddd;
	padding: 5px 0 2px 0;
	margin:0 0 2px 0;
}
.pligg_news_paragraph {
	line-height:1.4em;
}
.pligg_news_paragraph strong {
	font-weight:normal;
}
</style>
{/literal}

{php}

Function feedMe($feed,$items) {
	// Use cURL to fetch RSS Feed
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $feed);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt ($ch, CURLOPT_USERAGENT, $useragent);
	$rss = curl_exec($ch);
	curl_close($ch);

	// Manipulate string into object
	$rss = simplexml_load_string($rss);

	// This gets the total number of items available. Substitute this with $items to print all RSS items.
	$cnt = count($rss->channel->item);
	
	for($i=0; $i<$items; $i++)
	{
		$url = $rss->channel->item[$i]->link;
		$title = $rss->channel->item[$i]->title;
		$desc = $rss->channel->item[$i]->description;
		echo '<h4 class="pligg_news_title"><a href="'.$url.'">'.$title.'</a></h4><p class="pligg_news_paragraph">'.$desc.'</p>';
	}
}

// Number of items to display
$items = $this->_vars['news_count'];

feedMe("http://pligg.com/blog/feed/",$items);

{/php}