<?
header ("Expires: ".gmdate("D, d M Y H:i:s", time())." GMT"); 
header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
header ("Cache-Control: no-cache, must-revalidate"); 
header ("Pragma: no-cache");
header ("Content-type: application/javascript");

chdir('../');
include_once('../Smarty.class.php');
$main_smarty = new Smarty;

include('../config.php');
include(mnminclude.'html1.php');
include(mnminclude.'link.php');
include_once(mnminclude.'utils.php');
include(mnminclude.'user.php');
include(mnminclude.'smartyvariables.php');

$domain = preg_replace('/^www/','',$_SERVER['HTTP_HOST']);
if (!strstr($domain,'.') || strpos($domain,'localhost:')===0) $domain='';
setcookie ("referrer", "1", 0, '/', $domain); 

$urls = explode('|',$_GET['urls']);
if (!in_array($_SERVER['HTTP_REFERER'],$urls))
    $urls[] = $_SERVER['HTTP_REFERER'];
?>
var a = document.getElementsByTagName('A');

(function ()
{
    var s = document.createElement('LINK');
    s1 = document.getElementsByTagName('SCRIPT')[0];
    s.type = 'text/css';
    s.rel = "stylesheet";
    s.media = "screen";
    s.async = true;
//    s.href = '<?=my_base_url . my_pligg_base . (file_exists(mnmpath.'/cache/evb.css') ? '/cache/evb.css' : '/modules/buttons/evb.css') ?>';
    s.href = '<?=my_base_url . my_pligg_base . '/modules/buttons/evb.php'?>';
    s1.parentNode.insertBefore(s, s1);

for (var i=0; i<a.length; i++)
{
    c=" "+a[i].className+" ";
    if(c.match(/( PliggButton )/))
    {
<?
#print "vote".anonymous_vote;
#exit;
foreach ($urls as $url)
{
    $link = $db->get_row("SELECT * FROM ".table_links." WHERE link_url='".$db->escape($url)."' AND link_status!='discard'");
    if (!$link)
    {
	if (preg_match('/\/\/www\./i',$url))
	    $url1 = preg_replace('/\/\/www\./i','//',$url);
	else
	    $url1 = preg_replace('/\/\//i','//www.',$url);
        $link = $db->get_row("SELECT * FROM ".table_links." WHERE link_url='".$db->escape($url1)."' AND link_status!='discard'");
    }
    if($url==$_SERVER['HTTP_REFERER'])
	print "if (a[i].href=='' || a[i].href=='{$_SERVER['HTTP_REFERER']}') {";
    else
	print "if (a[i].href=='$url') {";

    // Page not added to Pligg
    if (!$link)
    {
?>
	form=document.createElement("form");
	if (a[i].href)
	    form.action = '<?=my_base_url . my_pligg_base . '/submit.php?url='?>' + escape(a[i].href);
	else
	    form.action = '<?=my_base_url . my_pligg_base . '/submit.php?url='.urlencode($url);?>';
	form.method = 'post';
	form.id='form'+i;
	a[i].parentNode.appendChild(form);

	if (a[i].rev)
	{
            text = document.createElement("textarea");
	    text.name = "category";
	    text.value= a[i].rev;
	    text.style.display='none';
	    form.appendChild(text);
	}
	if (a[i].rel)
	{
            text = document.createElement("textarea");
	    text.name = "tags";
	    text.value= a[i].rel;
	    text.style.display='none';
	    form.appendChild(text);
	}
	if (a[i].title)
	{
            text = document.createElement("textarea");
	    text.name = "title";
	    text.value= a[i].title;
	    text.style.display='none';
	    form.appendChild(text);
	}
	if (a[i].childNodes.length>0 && a[i].childNodes[0].innerHTML)
	{
            text = document.createElement("textarea");
	    text.name = "description";
	    text.value= a[i].childNodes[0].innerHTML;
	    text.style.display='none';
	    form.appendChild(text);
	}
	a[i].style.display = 'none';

<?
  	$onclick = "document.getElementById(\\\"form\"+i+\"\\\").submit();return false;";
	$url = "href='#' onclick='$onclick'";
	$link->link_votes = 0;
    }
    // User logged in
    elseif ($current_user->user_id || (anonymous_vote && anonymous_vote!=='false'))
    {
	$onclick = "crossvote({$current_user->user_id},{$link->link_id},\"+i+\",\\\"".md5($current_user->user_id.$link->link_randkey)."\\\",10)";
	$url = "href='". my_base_url . my_pligg_base . "/story.php?title={$link->link_title_url}'";
    }
    // User not logged in
    else
    {
	$onclick =  "document.location.href=\\\"" . my_base_url . my_pligg_base . "/login.php?return=".my_pligg_base."/story.php?title={$link->link_title_url}\\\"";
	$url = "href='". my_base_url . my_pligg_base . "/story.php?title={$link->link_title_url}'";
    }
?>
	div=document.createElement("div");
	a[i].parentNode.appendChild(div);
        if(c.match(/( PliggSmall)/))
	    div.innerHTML = "<div class='evb_small_wrapper'>\
				<div class='evb_small_vote_count'><a id='xvotes-<?=$link->link_id?>' <?=$url?>><?=$link->link_votes?></a></div>\
				<div id='evb_small_vote_button' onclick='<?=$onclick?>' onMouseDown='changeSmBgImage()' onMouseUp='unchangeBgImage();'>\
					<div class='evb_small_vote_text'>Vote</div>\
				</div>\
				<div style='clear:both;'> </div>\
			</div>";
	else
	    div.innerHTML = "<div class='evb_large_wrapper'>\
				<div class='evb_large_vote_count'><a id='xvotes-<?=$link->link_id?>' <?=$url?>><?=$link->link_votes?></a></div>\
				<div class='evb_large_vote_text'>Votes</div>\
				<div id='evb_large_button' onclick='<?=$onclick?>' onMouseDown='changeLgBgImage()' onMouseUp='unchangeBgImage();'></div>\
			</div>";
	}
<?
}
?>
    }
}
})()

function changeLgBgImage (image , id) {
  // The position change value should be half of the image height. In this case the height of the button image source is 42px, so the value is set to -21px.
  document.getElementById('evb_large_button').style.backgroundPosition = '0px -21px';
}
function changeSmBgImage (image , id) {
  // The position change value should be half of the image height. In this case the height of the button image source is 34px, so the value is set to -17px
  document.getElementById('evb_small_vote_button').style.backgroundPosition = '0px -17px';
}
function unchangeBgImage (image , id) {
  document.getElementById('evb_large_button').style.backgroundPosition = '0px 0px';
  document.getElementById('evb_small_vote_button').style.backgroundPosition = '0px 0px';
}

function crossvote(user, id, htmlid, md5, value)
{
	var s = document.createElement('SCRIPT'), s1 = document.getElementsByTagName('SCRIPT')[0];
	s.type = 'text/javascript';
	s.async = true;
	s.src = '<?=my_base_url . my_pligg_base . '/modules/buttons/vote.php?'?>' + "id=" + id + "&user=" + user + "&md5=" + md5 + "&value=" + value;
	s1.parentNode.insertBefore(s, s1);
}
