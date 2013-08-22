<script type="text/javascript">
	var my_pligg_url="{$my_base_url}{$my_pligg_base}";
	var catID="{$catID}";
	var part="{$part}";
	var total_row="{$total_row}";
	var Pager_setting="{$Pager_setting}";
	var page_name="{$pagename}";
	var groupID="{$groupID}";
	var viewtype="{$viewtype}";
	var pageSize="{$scrollpageSize}";
	var searchorder="{$searchOrder}";
	var group_vote="{$group_vote}";
	var userid="{$userid}";
	var curuserid="{$curuserid}";
	
	{literal}
	$(document).ready(function()
	{
		var count;
		count=parseInt(pageSize);
		
		function last_msg_funtion() 
		{ 
			var data="";
			var url = "";
		
			if(page_name=="index" || page_name=="new" || page_name=="published"){
			 	data="&catID="+catID+"&part="+part+"&sorder="+searchorder;
			 	url = my_pligg_url+"/load_data.php";
			 }
			else if(page_name=="group_story"){
			 	data="&groupid="+groupID+"&view="+viewtype+"&group_vote="+group_vote+"&catID="+catID; 
			 	url = my_pligg_url+"/load_data.php";
			 }
			else if(page_name=="user"){
			 	data="&view="+viewtype+"&userid="+userid+"&curuserid="+curuserid; 
			 	url = my_pligg_url+"/load_data.php";
			 }
			
			var dataString = "pname="+page_name+"&start_up="+count+"&pagesize="+pageSize+data;
								
				$.ajax({
					type: "POST",
					url:url,
					data: dataString,
					beforeSend: function() {
						$(".stories:last").addClass("loader");
					},
					cache: false,
					success: function(html)	{
						
						if ($.trim(html) != "") {
							
							$(".stories:last").after(html); 
							$(".stories").removeClass("loader");
							count=count+parseInt(pageSize);
						} else{
						
							$(".stories").removeClass("loader");
						}
					} 
			});
		}; 
      
	   if(Pager_setting==2){
		$(window).scroll(function(){
			if ($(window).scrollTop() == $(document).height() - $(window).height()){
				if(parseInt(total_row)>=count)
				last_msg_funtion();
			}
		}); 
	   }else if(Pager_setting==3){
		   
			if(parseInt(total_row)>count)  
			$(".stories:last").after("<div class='btn btn-default contine_read_story'>{/literal}{#PLIGG_Continue_Reading#}{literal}</div>"); 
			
			$(".contine_read_story").live("click", function(){
				if(parseInt(total_row) > count){
					last_msg_funtion();
				}else{	
					$(this).hide();
					$(".stories:last").after("<div class='btn btn-default no_stories_left'>{/literal}{#PLIGG_No_More_Articles#}{literal}</div>"); 
				}
			});
	   }
	});
	{/literal}
	</script>