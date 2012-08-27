$(document).ready(function(){
var flag=0;

if( $.cookie('panelState') == null ) 
{
	 //$('.accordion-heading').next().show();
	 flag=1;
	
}

 var cookie = $.cookie("panelState"),
  expanded = cookie ? cookie.split("|").getUnique() : [],
  cookieExpires = 7; // cookie expires in 7 days, or set this as a date object to specify a date

 
 // show cookie content
  $.cookie("panelState", expanded.join('|'), { expires: cookieExpires } );
 //$('#display').html(expanded.join(','));

 // Remember content that was expanded
 $.each( expanded, function(){
  $('#' + this).show();
 })

 if(flag==1){
// expanded.push($('.accordion-heading').next().id);
 //expanded = tmp.getUnique();
  $('.accordion-heading').toggleClass("open");
  $('.accordion-heading').next().slideToggle('300', function(){
   updateCookie(this);
  });
 flag=0;
 }

 $('.accordion-heading').click(function(){
  $(this).toggleClass("open");
  $(this).next().slideToggle('300', function(){
   updateCookie(this);
  });
 })

 // Update the Cookie
 function updateCookie(el){
  var indx = el.id;
  var tmp = expanded.getUnique();
  if ($(el).is(':hidden')) {
   // remove element id from the list
   tmp.splice( tmp.indexOf(el.id) , 1);
  } else {
   // add index of widget to expanded list
   tmp.push(el.id);
  }
  expanded = tmp.getUnique();
  $.cookie("panelState", expanded.join('|'), { expires: cookieExpires } );

 // show cookie content
// $('#display').html(expanded.join(','));
 }
});

// Return a unique array.
Array.prototype.getUnique = function(sort){
 var u = {}, a = [], i, l = this.length;
 for(i = 0; i < l; ++i){
  if(this[i] in u) { continue; }
  a.push(this[i]);
  u[this[i]] = 1;
 }
 return (sort) ? a.sort() : a;
}
