var XMLHttpRequestObject = false; 
if (window.XMLHttpRequest)
	XMLHttpRequestObject = new XMLHttpRequest();
else if (window.ActiveXObject)
	XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");

function show_likes(id)
{
    if(XMLHttpRequestObject && document.getElementById('likes'+id).style.display!='block')
    {
    	XMLHttpRequestObject.open("GET", my_pligg_base+"/modules/status/status.php?lid="+id+"&action=likes", false);
    	XMLHttpRequestObject.send(null);

    	if (XMLHttpRequestObject.responseText)
    	{
    		document.getElementById('likes'+id).innerHTML=XMLHttpRequestObject.responseText;
    		document.getElementById('likes'+id).style.display='block';
    	}
    }
    else
	document.getElementById('likes'+id).style.display='none';
}

function like(id)
{
    if(XMLHttpRequestObject)
    {
	document.getElementById('likes'+id).style.display='none';

    	XMLHttpRequestObject.open("GET", my_pligg_base+"/modules/status/status.php?lid="+id, false);
    	XMLHttpRequestObject.send(null);

    	if (XMLHttpRequestObject.responseText)
	{
	    if (document.getElementById('unlike'+id).style.display=='none')
	    {
    		document.getElementById('like'+id).style.display='none';
    		document.getElementById('unlike'+id).style.display='inline';
	    }
	    else
	    {
    		document.getElementById('like'+id).style.display='inline';
    		document.getElementById('unlike'+id).style.display='none';
	    }

	    if (XMLHttpRequestObject.responseText > 0)
	    {
    	    	document.getElementById('count'+id).innerHTML=XMLHttpRequestObject.responseText+' '+likes;
    		document.getElementById('count'+id).disabled = false;
	    }
	    else
	    {
    		document.getElementById('count'+id).innerHTML = nolikes;
    		document.getElementById('count'+id).disabled = true;
	    }
	}
    }
}
