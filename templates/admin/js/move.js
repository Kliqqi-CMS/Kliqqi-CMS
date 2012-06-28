function moveup(id)
{
   var cat = document.getElementById('cat'+id);
   var prev = cat.previousSibling;
   var parentdoc = cat.parentNode;
   var id2 = prev.id.substr(3);

   parentdoc.removeChild(cat); 
   parentdoc.insertBefore(cat, prev); 

   var up1 = document.getElementById('up'+id);
   var up2 = document.getElementById('up'+id2);
   var down1 = document.getElementById('down'+id);
   var down2 = document.getElementById('down'+id2);
   var i = up1.style.display; up1.style.display = up2.style.display; up2.style.display = i;
   i = down1.style.display; down1.style.display = down2.style.display; down2.style.display = i;

    if(XMLHttpRequestObject)
    {
    	XMLHttpRequestObject.open("GET", "?action=move_above&id_to_move="+id+"&moveabove_id="+id2, true);
    	XMLHttpRequestObject.send(null);
    }
}
function movedown(id)
{
   var cat = document.getElementById('cat'+id);
   var next = cat.nextSibling;
   var id2 = next.id.substr(3);
   moveup(id2);
}
