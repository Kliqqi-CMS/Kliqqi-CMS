{config_load file=auto_update_lang_conf}

<fieldset><legend> {#AUTO_UPDATE_TITLE#}</legend>

<p>{#AUTO_UPDATE_STEP4_DESCRIPTION#}</p>

<script>
var failed = '{#AUTO_UPDATE_FAILED#}';
var unzipped = '{#AUTO_UPDATE_UNZIPPED_OK#}';

{literal}
var interval = new Array();
var submitted = 0;
var loaded = 0;
var XMLHttpRequestObject = false; 
if (window.XMLHttpRequest)
	XMLHttpRequestObject = new XMLHttpRequest();
else if (window.ActiveXObject)
	XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
function submitUploadForm(form)
{
    if (submitted) return true;

    document.getElementById('step5').disabled=true;

    // Hide the form 
    document.getElementById('myElementId').style.display='block';
    form.submit();
    return false;
}

function getStatus()
{
    if(XMLHttpRequestObject)
    {
	XMLHttpRequestObject.open("GET", "modules/auto_update/upload.php?status=1", true);
        XMLHttpRequestObject.onreadystatechange = function()
	{
	        if (XMLHttpRequestObject.readyState !=4) return;

	        if (XMLHttpRequestObject.responseText != "")
	   	{
		    if (XMLHttpRequestObject.responseText.indexOf('ERROR:')==0)
		    {
    	   	    	document.getElementById('step5').disabled=false;
		    	document.getElementById('myElementId').style.display='none';
	    	    	document.getElementById('status').innerHTML="<font color='#ED2B2B'>"+XMLHttpRequestObject.responseText+"</font>";
		    }
		    else if (XMLHttpRequestObject.responseText >= 100)
		    {
			document.getElementById('myElementId').style.display='none';
	    	        document.getElementById('step5').innerHTML="<font color='#FFFF55'>" + unzipped +"</font>";
    			document.getElementById('step5').style.display='block';
		        submitted = 1;
		    }
		}
		else if (++interval[1] > 120)
		{
	    	    document.getElementById('status').innerHTML="<font color='#ED2B2B'>"+failed+"</font>";
    	   	    document.getElementById('step5').disabled=false;
		    document.getElementById('myElementId').style.display='none';
		}
	};
	XMLHttpRequestObject.send(null);

    }
}
{/literal}
</script>

<br>
{#AUTO_UPDATE_DOWNLOADED#|sprintf:$latestversion}
<hr />

<span id='status'></span>
<form method=post enctype="multipart/form-data" action='{$my_pligg_base}/modules/auto_update/upload.php'  target='upload_iframe'>
<input type='hidden' name='where' value='unzip'>
</form>
<button onclick='return submitUploadForm(document.forms[0]);' style="border:1px solid #ccc;background:#0A5089;color:#fff;padding:5px 8px;float:left;display:block;">{#AUTO_UPDATE_UNZIP#}</button>

<iframe name="upload_iframe" onload="if (++loaded>1) getStatus();" id="upload_iframe" style='display:none;'></iframe> 

<a id='step5' href='?module=auto_update&step=5' style="border:1px solid #ccc;background:#0A5089;color:#fff;padding:6px 8px;float:left;color:#fff;display:none;">{#AUTO_UPDATE_CONTINUE_STEP5#}</a><br style="clear:both;" />

<span style='display: none;' !class="progressBar" id="myElementId"><img src='{$my_pligg_base}/modules/auto_update/images/loader.gif'/></span>

</fieldset>
{config_load file=auto_update_pligg_lang_conf}