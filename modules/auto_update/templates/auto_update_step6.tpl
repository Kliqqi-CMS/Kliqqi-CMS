{config_load file=auto_update_lang_conf}

<fieldset><legend> {#AUTO_UPDATE_TITLE#}</legend>

<script>
var finished = "{#AUTO_UPDATE_COMPLETE#}";

{literal}
var XMLHttpRequestObject = false; 
if (window.XMLHttpRequest)
	XMLHttpRequestObject = new XMLHttpRequest();
else if (window.ActiveXObject)
	XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
function cleanup()
{
    if(XMLHttpRequestObject)
    {
	XMLHttpRequestObject.open("GET", "modules/auto_update/upload.php?cleanup=1", true);
        XMLHttpRequestObject.onreadystatechange = function()
	{
	        if (XMLHttpRequestObject.readyState !=4) return;

	        if (XMLHttpRequestObject.responseText != "")
	   	{
		    if (XMLHttpRequestObject.responseText.indexOf('ERROR:')==0)
		    {
	    	    	document.getElementById('status').innerHTML="<font color=red>"+XMLHttpRequestObject.responseText+"</font>";
		    }
		    else if (XMLHttpRequestObject.responseText >= 100)
		    {
	    	        document.getElementById('status').innerHTML="<font color=green>" + finished +"</font>";
		    }
		}
		else if (++interval[1] > 120)
		{
	    	    document.getElementById('status').innerHTML="<font color=red>"+failed+"</font>";
		}
	};
	XMLHttpRequestObject.send(null);
    }
}
{/literal}
</script>


<p>{#AUTO_UPDATE_STEP6_DESCRIPTION#}</p>
<p>{#AUTO_UPDATE_STEP6_DELETE_DESCRIPTION#}</p>
<ul>
<li>settings.php.default
<li>/libs/dbconnect.php.default
<li>/install/
<li>latest.zip
</ul>
<hr />
<a href='#' onclick='cleanup(); return false;' style="border:1px solid #ccc;background:#0A5089;color:#fff;padding:6px 8px;float:left;color:#fff;display:block;">{#AUTO_UPDATE_STEP6_DELETE#}</a><br style="clear:both;" />
<span id='status'></span>
<br />


{config_load file=auto_update_pligg_lang_conf}
