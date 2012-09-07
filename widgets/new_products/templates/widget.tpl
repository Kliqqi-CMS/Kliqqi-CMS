{literal}
<style type="text/css">
.pro_item {
padding:5px 0 5px 2px;
}
.pro_left {
float:left;
width:70px;
}
.pro_right {
float:left;
}
.pro_thumb {
width:64px;
height:64px;
padding:2px;
border:1px solid #ddd;
}
.pro_thumb img{
padding:0px;
}
.pro_details {
float:left;
width:325px;
margin:0 0 0 10px;
}
.pro_title h3 {
line-height:0.9em;
margin:0;
padding:0;
}
.pro_title h3 a,.pro_title h3 a:visited{
font-size:13px;
}
.pro_description {
margin:2px 0 0 0;
}
.pro_description p{
	line-height:1.4em;
}
.pro_description p strong{
font-weight:normal;
}
.pro_price {
float:left;
background:#EDEDED;
border:1px solid #BABABA;
margin:5px 0 0 0;
padding:1px 2px;
width:64px;
text-align:center;
}
.pro_price p {margin:0;padding:0;}
.pro_price p a, .pro_price p a:visited{
color:#A61100;
font-size:11px;
font-weight:bold;
}
</style>
{/literal}

{php}

Function ProFeed($prourl,$proitems) {
	// Use cURL to fetch RSS Feed
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $prourl);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt ($ch, CURLOPT_USERAGENT, $useragent);
	$rss = curl_exec($ch);
	curl_close($ch);

	// Manipulate string into object
	$rss = simplexml_load_string($rss);

	// This gets the total number of items available. Substitute this with $proitems to print all RSS items.
	$cnt = count($rss->channel->item);
	
	for($i=0; $i<$proitems; $i++)
	{
		$pro_url = $rss->channel->item[$i]->link;
		$pro_title = $rss->channel->item[$i]->title;
		$pro_desc = $rss->channel->item[$i]->description;
		$pro_price = $rss->channel->item[$i]->price;
		$pro_thumb = $rss->channel->item[$i]->thumbnail;
		echo '<div class="pro_item">';
		echo '	<div class="pro_left">';
		echo '		<div class="pro_thumb"><a href="'.$pro_url.'"><div style="text-align:center;"><img src="'.$pro_thumb.'" /></div></a></div>';
		echo '		<div class="pro_price"><p><a href="'.$pro_url.'">'.$pro_price.'</a></p></div>';
		echo '	</div>';
		echo '	<div class="pro_right">';
		echo '		<div class="pro_details">';
		echo '			<div class="pro_title"><h3><a href="'.$pro_url.'">'.$pro_title.'</a></h3></div>';
		echo '			<div class="pro_description"><p>'.$pro_desc.'</p></div>';
		echo '		</div>';
		echo '	</div>';
		echo '	<div style="clear:both;"> </div>';	
		echo '</div>';
	}
}

// Number of items to display
$proitems = $this->_vars['product_count'];

ProFeed("http://feeds.feedburner.com/PliggPro",$proitems);

{/php}
