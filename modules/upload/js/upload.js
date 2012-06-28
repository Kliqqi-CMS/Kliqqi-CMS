var intervals = new Array();
var XMLHttpRequestObject = false; 
if (window.XMLHttpRequest)
	XMLHttpRequestObject = new XMLHttpRequest();
else if (window.ActiveXObject)
	XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
// Upload a file
function submitUploadForm(form)
{
    if (!check_fields(form)) return;

    // Setup timer to check file status
    intervals[form.number.value] = new Array();
    intervals[form.number.value][0] = setInterval("getThumbs("+form.id.value+","+form.number.value+")", 1000 );
    intervals[form.number.value][1] = 0;
    // Hide the form 
    document.getElementById('form_'+form.number.value).style.display='none';
    document.getElementById('thumb_'+form.number.value).innerHTML=uploading;
    form.submit();
}
function deleteImage(id,number)
{
    if(XMLHttpRequestObject)
    {
    	XMLHttpRequestObject.open("GET", my_pligg_base+"/modules/upload/upload.php?delid="+id+"&number="+number, false);
    	XMLHttpRequestObject.send(null);
    	if (XMLHttpRequestObject.responseText == "OK")
    	{
    		file = document.getElementById('file_'+number);
		if (file) file.value='';
    		url = document.getElementById('url_'+number);
		if (url) url.value='http://';
    		document.getElementById('thumb_'+number).innerHTML='';
    		document.getElementById('form_'+number).style.display='block';
    	}
    }
}
function switchImage(id,number,mode)
{
    if(XMLHttpRequestObject)
    {
    	XMLHttpRequestObject.open("GET", my_pligg_base+"/modules/upload/upload.php?switchid="+id+"&number="+number+"&mode="+mode, false);
    	XMLHttpRequestObject.send(null);
    	if (XMLHttpRequestObject.responseText != "OK")
	    return false;
    }
}
function getThumbs(id,number)
{
    if(XMLHttpRequestObject)
    {
	XMLHttpRequestObject.open("GET", my_pligg_base+"/modules/upload/upload.php?id="+id+"&number="+number, false);
	XMLHttpRequestObject.send(null);

        if (XMLHttpRequestObject.responseText != "")
   	{
    	    clearInterval(intervals[number][0]);
	    if (XMLHttpRequestObject.responseText.indexOf('ERROR:')==0)
	    {
    	    	document.getElementById('thumb_'+number).innerHTML="<font color=red>"+XMLHttpRequestObject.responseText+"</font>";
    	    	document.getElementById('form_'+number).style.display='block';
	    }
	    else
    	    	document.getElementById('thumb_'+number).innerHTML=XMLHttpRequestObject.responseText;
	}
	else if (++intervals[number][1] > 30)
	{
    	    document.getElementById('thumb_'+number).innerHTML="<font color=red>"+failed+"</font>";
    	    clearInterval(intervals[number][0]);
    	    document.getElementById('form_'+number).style.display='block';
	}
    }
}
function add_upload_field(max_number)
{
    for (i=1; i<=max_number; i++)
    {
  	if (document.getElementById('thumb_'+i).innerHTML == '' && 
    	    document.getElementById('form_'+i).style.display == 'none')
	{
		document.getElementById('form_'+i).style.display = 'block';
		return;
	}
    }
}
function check_fields(form)
{
    var number = form.number.value;

    var file = document.getElementById('file_'+number);
    var url  = document.getElementById('url_'+number);
    if (file && file.value=='' && (!url || url.value=='' || url.value=='http://'))
    {
	alert(choose_file);
	file.focus();
	return false;
    }
    if (url && (url.value=='' || url.value=='http://') && (!file || file.value==''))
    {
	alert(choose_url);
	url.focus();
	return false;
    }

    var fields = form.getElementsByTagName('INPUT');
    for (var i=0; i<fields.length; i++)
     	if (fields[i].type=="text" && fields[i].id=='mandatory' && fields[i].value.length==0)
	{
	    alert(mandatory);
	    fields[i].focus();
	    return false;
	}

    return true;
}
