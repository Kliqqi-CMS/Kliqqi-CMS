<script type="text/javascript">
var save_lang_text="{#PLIGG_MiscWords_Save_Links_Save#}";
var remove_lang_text="{#PLIGG_MiscWords_Save_Links_Remove#}";
var UserURLSave="{$user_url_saved}";
{literal}

 $(function() {
    $(".favorite").click(function() 
    {
	
	  var oparation = $(this).attr("id");
	  var return_value="";
	  var link_id=$(this).attr("linkid");
	  var dataString = 'action='+oparation+'&link_id='+link_id;
	  var parent = $(this);
	  //parent.removeClass("add_favorite");
	  //parent.addClass("remove_favorite");
	
	 
	  parent.fadeOut(100);
	  $.ajax({
	  type: "POST",
	  url:my_base_url+my_pligg_base+"/user_add_remove_links.php",
	  data: dataString,
	  cache: false,
	
	  success: function(html)
		{
		  
		  return_value=html;
		  if(return_value==1){
		    parent.attr('id','remove');
			parent.html(remove_lang_text);
		  }else if(return_value==2){
		    parent.attr('id','add');
		    parent.html(save_lang_text);
		  }else{
		   parent.html(html); 
		  }
		   
		  parent.fadeIn(200);
		 
		} 
		
		
	  });
     
	  var message="";
	  link_title=$(this).attr("title");
	  if(oparation=="add")
	    message='Saved '+link_title+' from <a href="'+UserURLSave+'">Favorites</a>.';
	  else if(oparation=="remove")
	    message='Removed '+link_title+' from <a href="'+UserURLSave+'">Favorites</a>.';
		
           $.pnotify({
						//pnotify_text: 'Removed {/literal}{$title_short}{literal} from <a href=\'{/literal}{$user_url_saved}{literal}\'>Favorites</a>.',
						pnotify_text: message,
						pnotify_sticker: false,
						pnotify_history: false,
						pnotify_notice_icon: 'icon-star-empty'
					});
					
      
  	return false;
  
    });
	
	
  });



{/literal}
</script>