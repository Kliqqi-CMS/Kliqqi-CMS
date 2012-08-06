<script>
var my_pligg_base='{$my_pligg_base}';
{literal}
function comment_subscribe(htmlid, linkid, unsubscribe)
{
	var url = my_pligg_base + "/modules/comment_subscription/subscribe.php";
	mycontent = "htmlid=" + htmlid + "&linkid=" + linkid;
	if (unsubscribe) mycontent += "&uns=1";

	$('#cs-'+htmlid).html("Loading...");

    	$.post(url, mycontent, function (data) {
		if (data.match (new RegExp ("^ERROR:"))) {
			$('#cs-'+htmlid).html('<font color=red>'+data.substring(6, data.length)+'</font>');
   		} else {
			$('#cs-'+htmlid).html(data);
		}
	}, "text");
}
</script>
{/literal}
