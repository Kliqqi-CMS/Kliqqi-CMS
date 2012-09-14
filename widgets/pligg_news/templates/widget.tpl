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
	$timeout = 3;
	$userAgent = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:7.0.1) Gecko/20100101 Firefox/7.0.1';
	curl_setopt($ch, CURLOPT_URL, $feed);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout); 
	curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
	$rss = curl_exec($ch);
	$blog_curl_errno = curl_errno($ch);
	$blog_curl_error = curl_error($ch);
	curl_close($ch);
	
	if ($blog_curl_errno > 0) {		
		if ($blog_curl_errno = 28){
			echo 'Unable to connect to the Pligg Blog feed. Please try again later.';
		}else{
			echo "cURL Error ($blog_curl_errno): $blog_curl_error\n";
		}
	} else {
	
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
}

// Number of items to display
$items = $this->_vars['news_count'];

feedMe("http://feeds.feedburner.com/PliggBlog",$items);

{/php}