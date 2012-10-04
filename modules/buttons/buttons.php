<?php
header ("Expires: ".gmdate("D, d M Y H:i:s", time())." GMT"); 
header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
header ("Cache-Control: no-cache, must-revalidate"); 
header ("Pragma: no-cache");
header ("Content-type: application/javascript");

chdir('../');
include_once('../internal/Smarty.class.php');
$main_smarty = new Smarty;

$do_not_include_in_pages_core[] = 'buttons';
include('../config.php');

include(mnminclude.'html1.php');
include(mnminclude.'link.php');
include_once(mnminclude.'utils.php');
include(mnminclude.'user.php');
include(mnminclude.'smartyvariables.php');

$domain = preg_replace('/^www/','',$_SERVER['HTTP_HOST']);
if (!strstr($domain,'.') || strpos($domain,'localhost:')===0) $domain='';
setcookie ("referrer", "1", 0, '/', $domain); 

#ini_set('display_errors', 1);
#error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);

// Current link URL (or page URL if no href specified)
$url = $_GET['urls'];
if (parse_url($url)===FALSE) $url = '';
?>
// Load style.css
$('head').append('<link rel="stylesheet" media="screen" href="<?=my_base_url . my_pligg_base . '/modules/buttons/evb.php'?>" type="text/css" />');

$(function() {
    // All appropriate links on the page replace with Vote div code
    $('a.PliggButton').map( function(i, val) {
	if (val.href=='<?php echo $url ?>') {
    <?php
    if (!$url) $url = $_SERVER['HTTP_REFERER'];
    if (!$url) die('} }); });');

    $link = $db->get_row($sql="SELECT * FROM ".table_links." WHERE link_url='".$db->escape($url)."' AND link_status!='discard'");
    if (!$link)
    {
	// Search without www if not found
	if (preg_match('/\/\/www\./i',$url))
	    $url1 = preg_replace('/\/\/www\./i','//',$url);
	else
	    $url1 = preg_replace('/\/\//i','//www.',$url);
        $link = $db->get_row("SELECT * FROM ".table_links." WHERE link_url='".$db->escape($url1)."' AND link_status!='discard'");
    }

    // Page not added to Pligg yet
    if (!$link)
    {
	$rand = rand();

    // Create submit form 
    ?>
	form = $("<form id='form<?php echo $rand?>' method='post' action='<?=my_base_url . my_pligg_base . '/submit.php?url='.urlencode($url); ?>'></form>");
	if (val.rev)
	    form.append("<textarea style='display:none;' name='category'>"+val.rev+"</textarea>");
	if (val.rel)
	    form.append("<textarea style='display:none;' name='tags'>"+val.rel+"</textarea>");
	if (val.title)
	    form.append("<textarea style='display:none;' name='title'>"+val.title+"</textarea>");
	if (val.childNodes.length>0 && val.childNodes[0].innerHTML)
	    form.append("<textarea style='display:none;' name='description'>"+val.childNodes[0].innerHTML+"</textarea>");
	$('body').append(form);

    <?php
  	$onclick = "$('#form$rand').submit(); return false;";
	$url = "href='#' onclick=\"$onclick\"";
    	$main_smarty->assign('link_shakebox_votes', 0);
    	$main_smarty->assign('link_shakebox_index', $rand);
    	$main_smarty->assign('link_shakebox_javascript_vote', $onclick);
    	$main_smarty->assign('link_shakebox_javascript_report', $onclick);
    }
    // User logged in
    elseif ($current_user->user_id || (anonymous_vote && anonymous_vote!=='false'))
    {
		$url = "href='". my_base_url . my_pligg_base . "/story.php?title={$link->link_title_url}'";
    }
    // User not logged in
    else
    {
		$main_smarty->assign('login_url', my_base_url . my_pligg_base . "/login.php?return=".my_pligg_base."/story.php?title={$link->link_title_url}\"");
		$url = "href='". my_base_url . my_pligg_base . "/story.php?title={$link->link_title_url}'";
    }

    // Fill smarty vars with found link
    if ($link)
    {
    	$linkres = new Link;
    	$linkres->id=$link->link_id;
    	if ($linkres->read())
      		$main_smarty = $linkres->fill_smarty($main_smarty);
    }
    $main_smarty->assign('url', $url);
    ?>
	div=$("<div></div>");

//        if(val.className.match(/( PliggSmall)/))
//	else
	    div.html("<?php echo str_replace(array("\n",'"',"\r"), array("\\\n",'\"',''), $main_smarty->fetch('buttons/templates/buttons_large.tpl'));?>");
	$(val).append(div);
    }
    });
});

function vote(user, id, htmlid, md5, value)
{
    $.getJSON('<?=my_base_url . my_pligg_base . '/modules/buttons/vote.php?'?>' + "id=" + id + "&user=" + user + "&md5=" + md5 + "&value=" + value + '&callback=?', 
	function(data) { 
		if (data.message.match (new RegExp ("^ERROR:"))) {
			alert(data.message);
   		} else {
			var anchor = $('#xvote-'+data.htmlid+' > .'+(data.value>0 ? 'btn-danger' : 'btn-success'));
			if (anchor.length)
				anchor.removeClass(data.value>0 ? 'btn-danger' : 'btn-success')
					.attr('href', anchor.attr('href').replace(/unvote/,'vote'))
					.children('i').removeClass('icon-white');

			var anchor = $('#xvote-'+data.htmlid+' > a:'+(data.value>0 ? 'first' : 'last'));
			anchor.addClass(data.value>0 ? 'btn-success' : 'btn-danger')
				.attr('href', anchor.attr('href').replace(/vote/,'unvote'))
				.children('i').addClass('icon-white');
				
			$('#xnews-'+data.htmlid+' .votenumber').html(data.message.split('~')[0]);
		}
  	});
}

function unvote(user, id, htmlid, md5, value)
{
    $.getJSON('<?=my_base_url . my_pligg_base . '/modules/buttons/vote.php?'?>' + "id=" + id + "&user=" + user + "&md5=" + md5 + "&value=" + value + '&unvote=true&callback=?', 
	function(data) { 
		if (data.message.match (new RegExp ("^ERROR:"))) {
			alert(data.message);
   		} else {
			var anchor = $('#xvote-'+data.htmlid+' > a:'+(data.value>0 ? 'first' : 'last'));
			anchor.removeClass(data.value>0 ? 'btn-success' : 'btn-danger')
				.attr('href', anchor.attr('href').replace(/unvote/,'vote'))
				.children('i').removeClass('icon-white');
				
			$('#xnews-'+data.htmlid+' .votenumber').html(data.message.split('~')[0]);
		}
  	});
}
