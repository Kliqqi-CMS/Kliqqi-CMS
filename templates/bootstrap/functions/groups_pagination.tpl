<script type="text/javascript" language="javascript">
		

		var my_pligg_url = "{$my_base_url}{$my_pligg_base}";
		var Pager_setting = "{$Pager_setting}";
		var page_name = "{$pagename}";
		var total_row_for_group = "{$total_row_for_group}";
		var pageSize = "{$scrollpageSize}";
		
		
		{literal}
		$(document).ready(function(){
			
			var count;
			count=parseInt(pageSize);
			
			
			total_row_for_group = parseInt(total_row_for_group);
			
			var endLmt = $('.group_container').length;
			
			function last_msg_funtion_for_group() 
			{ 
				var	url = my_pligg_url+"/load_data_for_groups.php";
				var dataString = "start_up="+count+"&pagesize="+pageSize;
									
					$.ajax({
						type: "POST",
						url:url,
						data: dataString,
						beforeSend: function() {
							$(".group_container:last").addClass("loader");
						},
						cache: false,
						success: function(html)	{
							
							if (html != "") {
								$(".group_container:last").after(html); 
								$(".group_container").removeClass("loader");
								count=count+parseInt(pageSize);
							}
						} 
				});
			}; 
      		
		   if(Pager_setting==2){
		   
			$(window).scroll(function(){
				if ($(window).scrollTop() == $(document).height() - $(window).height()){
					if(parseInt(total_row_for_group)>=count)
					last_msg_funtion_for_group();
				}
			}); 
		   } else if(Pager_setting==3){
			   
				if(parseInt(total_row_for_group)>=count)  
				$(".group_container:last").after("<div class='btn btn-default contine_read_story'>{/literal}{#PLIGG_Continue_Reading#}{literal}</div>"); 
				
				$(".contine_read_story").live("click", function(){
					if(parseInt(total_row_for_group)>count){
						last_msg_funtion_for_group();
					}else{	
						$(this).hide();
						$(".group_container:last").after("<div class='btn btn-default no_stories_left'>{/literal}{#PLIGG_No_More_Articles#}{literal}</div>"); 
					}
				});
		   }
		})
		{/literal}			
		</script>