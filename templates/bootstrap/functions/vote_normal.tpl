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
function vote (user, id, htmlid, md5, value)
{
    var url = my_pligg_base + "/vote_total.php";
    var mycontent = "id=" + id + "&user=" + user + "&md5=" + md5 + "&value=" + value;
	
    if (!anonymous_vote && user==0) {
        window.location= my_base_url + my_pligg_base + "/login.php?return="+location.href;
    } else {
    	$.post(url, mycontent, function (data) {
		if (data.match (new RegExp ("^ERROR:"))) {
			var tag = $("<div></div>");
			tag.html(data).dialog({modal: true}).dialog('open');
   		} else {
			var anchor = $('#xvote-'+htmlid+' > .'+(value>0 ? 'btn-danger' : 'btn-success'));
			if (anchor.length)
				anchor.removeClass(value>0 ? 'btn-danger' : 'btn-success')
					.attr('href', anchor.attr('href').replace(/unvote/,'vote'))
					.children('i').removeClass('icon-white');

			var anchor = $('#xvote-'+htmlid+' > a:'+(value>0 ? 'first' : 'last'));
			anchor.addClass(value>0 ? 'btn-success' : 'btn-danger')
				.attr('href', anchor.attr('href').replace(/vote/,'unvote'))
				.children('i').addClass('icon-white');

			if (Voting_Method == 2){
			} else {
				$('#xnews-'+htmlid+' .votenumber').html(data.split('~')[0]);
			}
		}
	}, "text");
    }
}

function unvote (user, id, htmlid, md5, value)
{
    var url = my_pligg_base + "/vote_total.php";
    var mycontent = "unvote=true&id=" + id + "&user=" + user + "&md5=" + md5 + "&value=" + value;

    if (!anonymous_vote && user==0) {
        window.location= my_base_url + my_pligg_base + "/login.php?return="+location.href;
    } else {
    	$.post(url, mycontent, function (data) {
		if (data.match (new RegExp ("^ERROR:"))) {
			alert(data.substring (6, data.length));
   		} else {
			var anchor = $('#xvote-'+htmlid+' > a:'+(value>0 ? 'first' : 'last'));
			anchor.removeClass(value>0 ? 'btn-success' : 'btn-danger')
				.attr('href', anchor.attr('href').replace(/unvote/,'vote'))
				.children('i').removeClass('icon-white');

			if (Voting_Method == 2){
			} else {
				$('#xnews-'+htmlid+' .votenumber').html(data.split('~')[0]);
			}
		}
	}, "text");
    }
}
{/literal}
</script>

