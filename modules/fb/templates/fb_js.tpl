<script>
var my_pligg_base='{$my_pligg_base}';
{literal}
function fb_story(htmlid, linkid)
{
	var url = my_pligg_base + "/modules/fb/sendfb.php";
	var mycontent = "htmlid=" + htmlid + "&linkid=" + linkid;

	$('#fb-'+htmlid).html("Sending...");

    	$.post(url, mycontent, function (data) {
		if (data.match (new RegExp ("^ERROR:"))) {
			$('#fb-'+htmlid).html('<font color=red>'+data.substring(6, data.length)+'</font>');
   		} else {
			$('#fb-'+htmlid).html(data);
		}
	}, "text");
}
</script>
{/literal}
