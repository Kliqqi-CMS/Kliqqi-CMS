<script type="text/javascript">
//<![CDATA[
var timestamp=0;
var busy = false;
var animating = false;
var my_base_url='{$my_base_url}';
var my_pligg_base='{$my_pligg_base}';
var pligg_hours = '{#PLIGG_Visual_Story_Times_Hours#}';
var items = Array();
var new_items = 0;
var animation_colors = Array("#CFCFCF", "#D1D1D1", "#D4D4D4", "#D9D9D9", "#DEDEDE", "#E6E6E6", "#E8E8E8", "#F0F0F0", "#F5F5F5", "#FFFFFF");
var colors_max = animation_colors.length - 1;
var current_colors = Array();
var animation_timer;
var max_items = {$items_to_show};
var min_update = {$how_often_refresh} * 1000;
var next_update = 5000;
var requests = 0;
var max_requests = 3000;
// Reload the mnm banner each 5 minutes
var mnm_banner_reload = 180000;

{literal}
function start() {
	for (i=0; i<max_items; i++)
	    items[i] = document.getElementById('live2-'+i);
	get_data();
}

function get_data() {
	if (busy) 
		return;
	busy = true;
	url  = window.location.href.replace(/\/live.*?$/, '/live2.php?time=' + timestamp);
		
	$.get(url, function (data) {
		busy = false;

	// We get new_data array
		var new_data = Array();
		eval (data);
		new_items = new_data.length;
		
		if(new_items > 0) {
			clearInterval(animation_timer);
			next_update = Math.round(0.5*next_update + 0.5*min_update/(new_items*2));
			shift_items(new_items);
			for (i=0; i<new_items && i<max_items; i++) {
				items[i].innerHTML = to_html(new_data[i]);
				set_initial_color(i);
			}
			animation_timer = setInterval('animate_background()', 100)
		} 
		else 
			next_update = Math.round(next_update*1.25);

		if (next_update < 5000) next_update = 5000;
		if (next_update > min_update) next_update = min_update;
		if (requests > max_requests) {
			if ( !confirm('Timeout: Would you like to try to reconnect?') ) {
				mnm_banner_reload = 0;
				return;
			}
			requests = 0;
			next_update = 100;
		}
		timer = setTimeout('get_data()', next_update)
}, "text");

	requests++;
	return false;
}

function set_initial_color(i) {
	var j;
	if (i >= colors_max)
		j = colors_max - 1;
	else j = i;
	current_colors[i] = j;
	items[i].style.backgroundColor = animation_colors[j];
}

function animate_background() {
	if (animating) {
		return;
	}
	if (current_colors[0] == colors_max) {
		clearInterval(animation_timer);
		return;
	}
	animating = true;
	for (i=new_items-1; i>=0; i--) {
		if (current_colors[i] < colors_max) {
			current_colors[i]++;
			items[i].style.backgroundColor = animation_colors[current_colors[i]];
		} else 
			new_items--;
	}
	animating = false;
}

function shift_items(n) {
	//for (i=n;i<max_items;i++) {
	for (i=max_items-1;i>=n;i--) {
		items[i].innerHTML = items[i-n].innerHTML;
		//items.shift();
	}
}

function to_html(data) {

	var ts=new Date(data.ts*1000);
	var timeStr;

	var hours = ts.getHours();
	var minutes = ts.getMinutes();
	var seconds = ts.getSeconds();

	timeStr  = ((hours < 10) ? "0" : "") + hours;
	timeStr  += ((minutes < 10) ? ":0" : ":") + minutes;
	timeStr  += ((seconds < 10) ? ":0" : ":") + seconds;
	
	var Xts = new Date();
	var diff = (Xts - ts) / 60000; // how manys minutes since
	if (diff > 1440) timeStr = '> 25 ' + pligg_hours; // 1440 = 60 mins/hr * 24 hrs/day

	html = '<td class="live2-ts">'+timeStr+'</td>';

	if (data.type == 'problem')
		html += '<td class="live2-type"><span class="live2-problem">'+data.type+'</span></td>';
	else if (data.type == 'Submission')
		html += '<td class="live2-type"><strong><a href="' + my_pligg_base + '/live_unpublished.php">'+data.type+'</a></strong></td>';
	else if (data.type == 'Published')
		html += '<td class="live2-type"><strong><a href="' + my_pligg_base + '/live_published.php">'+data.type+'</a></strong></td>';	
	else if (data.type == 'Comment')
		html += '<td class="live2-type"><strong><a href="' + my_pligg_base + '/live_comments.php">'+data.type+'</a></strong></td>';	
	else
		html += '<td class="live2-type">'+data.type+'</td>';

	html += '<td class="live2-votes">'+data.votes+'</td>';
	html += '<td class="live2-story"><a href="' + my_pligg_base + '/story.php?id='+data.link+'">'+data.title+'</a></td>';
	if (data.type == 'problem')
		html += '<td class="live2-who"><span class="live2-problem">'+data.who+'</span></td>';
	else if (data.uid > 0) 
		html += '<td class="live2-who"><a href="' + my_pligg_base + '/user.php?login='+data.who+'">'+data.who+'</a></td>';
	else 
		html += '<td class="live2-who">{/literal}{if $isAdmin eq 1}'+data.who+'{else}Anonymous{/if}{literal}</td>';
	html += '<td class="live2-status">'+data.status+'</td>';
	return html;
}
{/literal}

//]]>
</script>