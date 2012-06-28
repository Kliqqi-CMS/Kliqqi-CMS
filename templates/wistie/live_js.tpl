{*
The live.php Javascript is in a seperate file because it needs to come after xmlhttp is loaded and
xmlhttp is loaded at the end of pligg.tpl. This file gets shown after all of pligg.tpl is.
*}

<script type="text/javascript">
//<![CDATA[
var timestamp=0;
var busy = false;
var animating = false;

dochref = document.location.href.substr(document.location.href.search('/')+2, 1000);
if(dochref.search('/') == -1){ldelim}
	$thisurl = document.location.href.substr(0,document.location.href.search('/')+2) + dochref;
{rdelim} else {ldelim}
	$thisurl = document.location.href.substr(0,document.location.href.search('/')+2) + dochref.substr(0, dochref.search('/'));
{rdelim}

var base_url = $thisurl+'<?php echo my_pligg_base;?>/live2.php';
var items = Array();
var new_items = 0;
var animation_colors = Array("#F2F2F2", "#F4F4F4", "#F6F6F6", "#F8F8F8", "#F9F9F9", "#FBFBFB", "#FCFCFC", "#FDFDFD", "#FEFEFE", "#ffffff");
var colors_max = animation_colors.length - 1;
var current_colors = Array();
var animation_timer;
var max_items = <?php echo items_to_show; ?>;
var min_update = <?php echo (how_often_refresh * 1000); ?>;
var next_update = 5000;
var xmlhttp = new myXMLHttpRequest ();
var requests = 0;
var max_requests = 3000;
// Reload the mnm banner each 5 minutes
var mnm_banner_reload = 180000;

function start() {ldelim}
	for (i=0; i<max_items; i++) {ldelim}
		items[i] = document.getElementById('live2-'+i);
	{rdelim}
	get_data();
{rdelim}

function get_data() {ldelim}
	if (busy) return;
	busy = true;
	url=base_url+'?time='+timestamp;
	xmlhttp.open("GET",url,true);
	xmlhttp.onreadystatechange=received_data;
	xmlhttp.send(null);
	requests++;
	return false;
{rdelim}

function set_initial_color(i) {ldelim}
	var j;
	if (i >= colors_max)
		j = colors_max - 1;
	else j = i;
	current_colors[i] = j;
	items[i].style.backgroundColor = animation_colors[j];
{rdelim}

function animate_background() {ldelim}
	if (animating) {ldelim}
		return;
	{rdelim}
	if (current_colors[0] == colors_max) {ldelim}
		clearInterval(animation_timer);
		return;
	{rdelim}
	animating = true;
	for (i=new_items-1; i>=0; i--) {ldelim}
		if (current_colors[i] < colors_max) {ldelim}
			current_colors[i]++;
			items[i].style.backgroundColor = animation_colors[current_colors[i]];
		{rdelim} else 
			new_items--;
	{rdelim}
	animating = false;
{rdelim}

function received_data() {ldelim}
	if (xmlhttp.readyState != 4) return;
	busy = false;
	if (xmlhttp.status == 200 && xmlhttp.responseText.length > 10) {ldelim}
		// We get new_data array
		var new_data = Array();
		eval (xmlhttp.responseText);
		new_items= new_data.length;
		if(new_items > 0) {ldelim}
			clearInterval(animation_timer);
			next_update = Math.round(0.5*next_update + 0.5*min_update/(new_items*2));
			shift_items(new_items);
			for (i=0; i<new_items && i<max_items; i++) {ldelim}
				items[i].innerHTML = to_html(new_data[i]);
				set_initial_color(i);
			{rdelim}
			animation_timer = setInterval('animate_background()', 100)
		{rdelim} else next_update = Math.round(next_update*1.25);
	{rdelim}
	if (next_update < 5000) next_update = 5000;
	if (next_update > min_update) next_update = min_update;
	if (requests > max_requests) {ldelim}
		if ( !confirm('<?php echo _('Timeout: Would you like to try to reconnect?');?>') ) {ldelim}
			mnm_banner_reload = 0;
			return;
		{rdelim}
		requests = 0;
		next_update = 100;
	{rdelim}
	timer = setTimeout('get_data()', next_update)
{rdelim}

function shift_items(n) {ldelim}
	//for (i=n;i<max_items;i++) {ldelim}
	for (i=max_items-1;i>=n;i--) {ldelim}
		items[i].innerHTML = items[i-n].innerHTML;
		//items.shift();
	{rdelim}
{rdelim}

function to_html(data) {ldelim}
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
	if(diff > 1440){ldelim}timeStr = '> 25 <?php global $main_smarty; echo $main_smarty->get_config_vars('PLIGG_Visual_Story_Times_Hours'); ?>';{rdelim} // 1440 = 60 mins/hr * 24 hrs/day

	html = '<div class="live2-ts">'+timeStr+'</div>';

	if (data.type == 'problem')
		html += '<div class="live2-type"><span class="live2-problem">'+data.type+'</span></div>';
	else if (data.type == 'new')
		html += '<div class="live2-type"><strong><a href="<?php echo my_pligg_base; ?>/live_unpublished.php">'+data.type+'</a></strong></div>';
	else if (data.type == 'published')
		html += '<div class="live2-type"><strong><a href="<?php echo my_pligg_base; ?>/live_published.php">'+data.type+'</a></strong></div>';	
	else if (data.type == 'comment')
		html += '<div class="live2-type"><strong><a href="<?php echo my_pligg_base; ?>/live_comments.php">'+data.type+'</a></strong></div>';	
	else
		html += '<div class="live2-type">'+data.type+'</div>';

	html += '<div class="live2-votes">'+data.votes+'</div>';
	html += '<div class="live2-story"><a href="<?php echo my_base_url.my_pligg_base; ?>/story.php?id='+data.link+'">'+data.title+'</a></div>';
	if (data.type == 'problem')
		html += '<div class="live2-who"><span class="live2-problem">'+data.who+'</span></div>';
	else if (data.uid > 0) 
		html += '<div class="live2-who"><a href="<?php echo my_base_url.my_pligg_base; ?>/user.php?login='+data.who+'">'+data.who+'</a></div>';
	else 
		html += '<div class="live2-who">'+data.who+'</div>';
	html += '<div class="live2-status">'+data.status+'</div>';
	return html;
{rdelim}

//]]>
</script>
