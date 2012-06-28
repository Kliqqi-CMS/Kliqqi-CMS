function SetState(obj_checkbox, obj_textarea) {
	if(obj_checkbox.checked){
		obj_textarea.disabled = false;
	} else {
		obj_textarea.disabled = true;
	}
}
function textCounter(field, countfield, maxlimit) {
	if (field.value.length > maxlimit) // if too long...trim it!
		field.value = field.value.substring(0, maxlimit);
		// otherwise, update 'characters left' counter
	else
		countfield.value = maxlimit - field.value.length;
}
function counter(text) {
	text.form.text_num.value = text.value.length;
}

var offsetfromedge=20      //offset from window edge when content is "docked". Change if desired.
var dockarray=new Array() //array to cache dockit instances
var dkclear=new Array()   //array to cache corresponding clearinterval pointers

function dockit(el, duration){
	this.source=document.all? document.all[el] : document.getElementById(el);
	this.source.height=this.source.offsetHeight;
	this.docheight=truebody().clientHeight;
	this.duration=duration;
	this.pagetop=0;
	this.elementoffset=this.getOffsetY();
	dockarray[dockarray.length]=this;
	var pointer=eval(dockarray.length-1);
	var dynexpress='dkclear['+pointer+']=setInterval("dockornot(dockarray['+pointer+'])",100);';
	dynexpress=(this.duration>0)? dynexpress+'setTimeout("clearInterval(dkclear['+pointer+']); dockarray['+pointer+'].source.style.top=0", duration*1000)' : dynexpress;
	eval(dynexpress);
}

dockit.prototype.getOffsetY=function(){
	var totaloffset=parseInt(this.source.offsetTop);
	var parentEl=this.source.offsetParent;
	while (parentEl!=null){
		totaloffset+=parentEl.offsetTop;
		parentEl=parentEl.offsetParent;
	}
	return totaloffset;
}

function dockornot(obj){
	obj.pagetop=truebody().scrollTop;
	var h = obj.source.parentNode.clientHeight;
	var top = 0;
	if (obj.pagetop>obj.elementoffset) //detect upper offset
		top=obj.pagetop-obj.elementoffset+offsetfromedge;
	else if (obj.pagetop+obj.docheight<obj.elementoffset+parseInt(obj.source.height)) //lower offset
		top=obj.pagetop+obj.docheight-obj.source.height-obj.elementoffset-offsetfromedge;
	else
		top=0;

	if (top<0)
		obj.source.style.top=0;
	else if (top+obj.source.offsetHeight>h)
		obj.source.style.top=0;
	else
		obj.source.style.top=top+"px";
}

function truebody(){
	return (document.compatMode && document.compatMode!="BackCompat")? document.documentElement : document.body
}