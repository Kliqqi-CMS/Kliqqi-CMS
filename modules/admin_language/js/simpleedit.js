var is_number_valid=new Array();
var XMLHttpRequestObject = false; 
if (window.XMLHttpRequest)
	XMLHttpRequestObject = new XMLHttpRequest();
else if (window.ActiveXObject)
	XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
function show_edit(id)
{
    editme = document.getElementById('editme'+id);
    showme = document.getElementById('showme'+id);
    editme.style.display='none';
    showme.style.display='';
    is_number_valid[id] = true;
}
function hide_edit(id)
{
    editme = document.getElementById('editme'+id);
    showme = document.getElementById('showme'+id);
    editme.style.display='';
    showme.style.display='none';
    is_number_valid[id] = true;
}
function save_changes(id,form)
{
    if (!is_number_valid[id]) return false;

    var editme = document.getElementById('editme'+id);
    if (form.var_value.type=='text')
    	value = form.var_value.value;
    else
    	value = form.var_value.options[form.var_value.selectedIndex].value;
    editme.innerHTML=htmlentities(value);
    if(XMLHttpRequestObject)
    {
    	XMLHttpRequestObject.open("GET", "?module=admin_language&mode=save&edit="+id+"&newvalue="+escape(value), true);
    	XMLHttpRequestObject.send(null);
    }
    hide_edit(id);
}
function check_number(id,field,min_value)
{
    if (isNaN(field.value))
    {
	alert("Should be a number.");
	field.focus();
	is_number_valid[id]=false;
	return;
    }

    if (min_value && field.value<min_value)
    {
	alert("Should be at least "+min_value);
	field.focus();
	is_number_valid[id]=false;
	return;
    }
    is_number_valid[id]=true;
}
function htmlentities(s){    // Convert all applicable characters to HTML entities
    var div = document.createElement('div');
    var text = document.createTextNode(s);
    div.appendChild(text);
    return div.innerHTML;
}
