<script>
var my_base_url='{$my_base_url}';
var my_pligg_base='{$my_pligg_base}';
var anonymous_vote = {$anonymous_vote};
var Voting_Method = '{$Voting_Method}';
var PLIGG_Visual_Vote_Cast = "{#PLIGG_Visual_Vote_Cast#}";
var PLIGG_Visual_Vote_Report = "{#PLIGG_Visual_Vote_Report#}";
var PLIGG_Visual_Vote_For_It = "{#PLIGG_Visual_Vote_For_It#}";
var PLIGG_Visual_Comment_ThankYou_Rating = "{#PLIGG_Visual_Comment_ThankYou_Rating#}";

{literal}
function cvote (user, id, htmlid, md5, value)
{
    var url = my_pligg_base + "/cvote.php";
    var mycontent = "id=" + id + "&user=" + user + "&md5=" + md5 + "&value=" + value;
	
    if (!anonymous_vote && user==0) {
        window.location= my_base_url + my_pligg_base + "/login.php?return="+location.href;
    } else {
    	$.post(url, mycontent, function (data) {
		if (data.match (new RegExp ("^ERROR:"))) {
			alert(data.substring (6, data.length));
   		} else {
			$('#cvote-'+htmlid).html(data.split('~')[0]);
		}
	}, "text");
    }
}
{/literal}
</script>

