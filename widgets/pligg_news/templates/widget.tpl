{literal}
<style type="text/css">
.pligg_news_title {
	border-bottom:1px dotted #ddd;
	padding: 5px 0 2px 0;
	margin:0 0 2px 0;
}
.pligg_news_paragraph {
	padding-bottom:5px;
	font-size:12px;
	line-height:13px;
}
.pligg_news_paragraph strong {
	font-weight:normal;
}
</style>
{/literal}

{php}

require_once('../templates/admin/simplepie.inc');
$url = 'http://www.pligg.com/rss/blog';

function shorten($string, $length){
	// By default, an ellipsis will be appended to the end of the text.
	$suffix = '';

	// Convert 'smart' punctuation to 'dumb' punctuation, strip the HTML tags,
	// and convert all tabs and line-break characters to single spaces.
	$short_desc = trim(str_replace(array("\r","\n", "\t"), ' ', strip_tags($string)));

	// Cut the string to the requested length, and strip any extraneous spaces 
	// from the beginning and end.
	$desc = trim(substr($short_desc, 0, $length));

	// Find out what the last displayed character is in the shortened string
	$lastchar = substr($desc, -1, 1);

	// If the last character is a period, an exclamation point, or a question 
	// mark, clear out the appended text.
	if ($lastchar == '.' || $lastchar == '!' || $lastchar == '?') $suffix='';

	// Append the text.
	$desc .= $suffix;

	// Send the new description back to the page.
	return $desc;
}

$feed = new SimplePie();
$feed->set_feed_url($url);
$feed->init();

// default starting item
$start = 0;

// default number of items to display. 0 = all
$length = $this->_vars['news_count'];

// set item link to script uri
$link = $_SERVER['REQUEST_URI'];

function trim_text($input, $length) {
	$input = strip_tags($input);
	if (iconv_strlen($input,'UTF-8') <= $length) {
		return $input;
	}
	$last_space = iconv_strrpos(iconv_substr($input, 0, $length,'UTF-8'), ' ','UTF-8');
	$trimmed_text = iconv_substr($input, 0, $last_space,'UTF-8');
	$trimmed_text .= '...';
	return $trimmed_text;
}

// loop through items
foreach($feed->get_items($start,$length) as $key=>$item) {
	// set query string to item number
	$queryString = '?item=' . $key;

	$link = $item->get_link();
	$queryString = '';        

	// display item title and date    
	echo '<h4 class="pligg_news_title"><a href="' . $link . $queryString . '">' . shorten($item->get_title(), 55) . '</a></h4>';
	echo '<p class="pligg_news_paragraph">'.trim_text($item->get_description(), 350).'</p>';
}

{/php}
