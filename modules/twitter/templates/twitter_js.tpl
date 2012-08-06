<script>
var my_pligg_base='{$my_pligg_base}';
{literal}
function tweet_story(htmlid, linkid)
{
	var url = my_pligg_base + "/modules/twitter/sendtweet.php";
	var mycontent = "htmlid=" + htmlid + "&linkid=" + linkid;

	$('#tweet-'+htmlid).html("<img src='./modules/twitter/templates/images/tweet_sending.gif' width='110' height='20' style='border:0;padding:0;marign:0;' title='Sending Tweet...' alt='Sending Tweet...' />");

    	$.post(url, mycontent, function (data) {
		if (data.match (new RegExp ("^ERROR:"))) {
			$('#tweet-'+htmlid).html('<font color=red>'+data.substring(6, data.length)+'</font>');
   		} else {
			$('#tweet-'+htmlid).html(data);
		}
	}, "text");
}
</script>
{/literal}
