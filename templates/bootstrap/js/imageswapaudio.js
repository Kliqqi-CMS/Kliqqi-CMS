/*
* Image Swap and HTML5 audio effect
* Created: Dec 4th, 2011 by DynamicDrive.com. This notice must stay intact for usage 
* Author: Dynamic Drive at http://www.dynamicdrive.com/
* Visit http://www.dynamicdrive.com/ for full source code
*/

function evteffect(selectorstr, fxoptions){
	var $=jQuery
	var $targets=$(selectorstr)
	//define list of audio file extensions and their associated audio types. Add to it if your specified audio file isn't on this list:

	var html5_audiotypes={"mp3": "audio/mpeg", "mp4": "audio/mp4", "ogg": "audio/ogg", "wav": "audio/wav"}

	function setupeffect($anchor, wrapper, filetype, evttype, files){
		
		if (filetype=="image"){
			wrapper=new Image()
			wrapper.src=files
			$anchor.data('originalimage', $anchor.attr('src')) //remember original image src
			$anchor.bind(evttype, function(){
				$anchor.attr('src', files)
			})
			$anchor.bind((evttype=="mouseover")? "mouseout" : "mouseup", function(){
				$anchor.attr('src', $anchor.data('originalimage'))
			})
			
		}
		else if (filetype=="audio"){
      			var wrapper=document.createElement('audio')
  			if (wrapper.canPlayType){
  				for (var x=0; x<files.length; x++){
  					var sourcetag=document.createElement('source')
  					sourcetag.setAttribute('src', files[x].trim())
  					if (files[x].match(/\.(\w+)$/i))
  						sourcetag.setAttribute('type', html5_audiotypes[RegExp.$1])
  					wrapper.appendChild(sourcetag)
  				}
				$anchor.bind(evttype, function(){
      					try{
      						wrapper.pause()
      						wrapper.currentTime=0
      						wrapper.play()
      					}catch(e){
      					}
				})			
  			}	

		}
	}

	$targets.each(function(){
		var $this=$(this), mediawrapper=null;
		if (typeof fxoptions != "undefined" ){
			$.each(fxoptions, function(key, value){
				$this.data(key, value)
			})
		}
		if ($this.data('srcover') && ($this.get(0).tagName=="IMG" || $this.get(0).type=="image")){
			setupeffect($this, mediawrapper, "image", "mouseover", $this.data('srcover'))
		}
		if ($this.data('srcdown') && ($this.get(0).tagName=="IMG" || $this.get(0).type=="image")){
			setupeffect($this, mediawrapper, "image", "mousedown", $this.data('srcdown'))
		}
		if ($this.data('soundover')){
			setupeffect($this, mediawrapper, "audio", "mouseover", $this.data('soundover').split(','))
		}
		if ($this.data('sounddown')){
			setupeffect($this, mediawrapper, "audio", "mousedown", $this.data('sounddown').split(','))
		}

	})

}

jQuery(function($){ //on DOM load
	evteffect("*[data-srcover], *[data-srcdown], *[data-soundover], *[data-sounddown]") //by default, scan all elements with these data attributes
	//evteffect('a', {srcdown:'down.gif', soundover:'whistle.mp3, whistle.ogg'})
})