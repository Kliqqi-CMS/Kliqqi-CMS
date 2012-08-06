window.onload = function() {
var s = document.getElementsByTagName('SCRIPT');
var path = new Array();
for (var i=0; i<s.length; i++)
    if (path = s[i].src.match(/^(.+buttons\/)buttons\.js$/))
	break;

var a = document.getElementsByTagName('A');
var urls = new Array();
var url = '';
for (var i=0; i<a.length; i++)
{
    c=" "+a[i].className+" ";
    if(c.match(/( PliggButton )/) && a[i].href && !urls[a[i].href])
    {
	if (url!='') url += '|';
	url += a[i].href;
	urls[a[i].href]=1;
    }
}
var s = document.createElement('SCRIPT'), s1 = document.getElementsByTagName('SCRIPT')[0];
s.type = 'text/javascript';
s.async = true;
s.src = path[1]+'buttons.php?urls='+escape(url);
s1.parentNode.insertBefore(s, s1);
};
