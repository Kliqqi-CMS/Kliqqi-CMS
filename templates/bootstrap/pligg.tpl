{if $maintenance_mode eq "true" && $user_level neq 'admin'}{include file=$the_template"/maintenance.tpl"}{else}<!DOCTYPE html>
<html dir="{#PLIGG_Visual_Language_Direction#}" xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	{checkActionsTpl location="tpl_pligg_head_start"}
	{include file=$the_template"/meta.tpl"}
	
	<link rel="stylesheet" type="text/css" href="{$my_pligg_base}/templates/{$the_template}/css/bootstrap.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="{$my_pligg_base}/templates/{$the_template}/css/jquery.pnotify.css" media="screen" />
	{if $pagename eq "submit"}<link rel="stylesheet" type="text/css" href="{$my_pligg_base}/templates/{$the_template}/css/bootstrap-wysihtml5.css"></link>{/if}
	
	<link rel="stylesheet" type="text/css" href="{$my_pligg_base}/templates/{$the_template}/css/style.css" media="screen" />
	
	{if $Voting_Method eq 2}
	<link rel="stylesheet" type="text/css" href="{$my_pligg_base}/templates/{$the_template}/css/star_rating/star.css" media="screen" />
	{/if}
	
	{checkForCss}
	{checkForJs}
	
	{include file=$the_template"/title.tpl"}
	
	{if $pagename eq "submit"}
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.0/jquery.min.js"></script>
		{literal}
		<script type="text/javascript">
		$(function() 
		{
			$(".title").keyup(function() 
			{
				var title=$(this).val();
				$(".story_title").html(title);
				return false;
			});
			$(".story_category").keyup(function() 
			{
				var category=$(this).val();
				$(".category").html(category);
				return false;
			});
			$(".story_group").keyup(function() 
			{
				var story_group=$(this).val();
				$(".story_group").html(story_group);
				return false;
			});
			$(".tags").keyup(function() 
			{
				var tags=$(this).val();
				$(".tags").html(tags);
				return false;
			});
			$(".bodytext").keyup(function() 
			{
				var bodytext=$(this).val();
				$(".bodytext").html(bodytext);
				return false;
			});
			
		});
		</script>
		{/literal}
	{/if}
	
	<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="{$my_base_url}{$my_pligg_base}/rss.php"/>
	<link rel="icon" href="{$my_pligg_base}/favicon.ico" type="image/x-icon"/>
	{if $pagename eq 'published'}<link rel="canonical" href="{$my_base_url}{$my_pligg_base}/{$navbar_where.text2}/" />{/if}
	{if $pagename eq 'index'}<link rel="canonical" href="{$my_base_url}{$my_pligg_base}/" />{/if}
	{if $pagename eq 'story'}<link rel="canonical" href="{$my_base_url}{$my_pligg_base}{$navbar_where.link2}" />{/if}
	{checkActionsTpl location="tpl_pligg_head_end"}
</head>
<body dir="{#PLIGG_Visual_Language_Direction#}" {$body_args}>
	{if $maintenance_mode eq "true" && $user_level eq 'admin'}
		<div class="alert alert-error" style="margin-bottom:0;"><button class="close" data-dismiss="alert">×</button>{#PLIGG_Maintenance_Admin_Warning#}</div>
	{/if}
	{checkActionsTpl location="tpl_pligg_body_start"}
	{include file=$tpl_header.".tpl"}
	<!-- START CATEGORIES -->
	{assign var=sidebar_module value="categories"}{include file=$the_template_sidebar_modules."/wrapper.tpl"}
	<!-- END CATEGORIES -->
	<div class="container">
		<section id="maincontent">
			<div class="row">
				{checkActionsTpl location="tpl_pligg_banner_top"}
				<!-- START LEFT COLUMN -->
			  {if $pagename eq "submit"}
				<div class="span12">
			  {else}
				<div class="span9">
			  {/if}
					{include file=$the_template"/breadcrumb.tpl"}
					{literal}
						<script type="text/javascript" language="JavaScript">
						function checkForm() {
						answer = true;
						if (siw && siw.selectingSomething)
							answer = false;
						return answer;
						}//
						</script>
					{/literal}
					{checkActionsTpl location="tpl_pligg_content_start"}
					{checkActionsTpl location="tpl_pligg_above_center"}
					{include file=$tpl_center.".tpl"}
					{checkActionsTpl location="tpl_pligg_below_center"}
					{checkActionsTpl location="tpl_pligg_content_end"}
				</div><!--/span-->
				<!-- END LEFT COLUMN -->
		  
				{checkActionsTpl location="tpl_pligg_columns_start"}	

				{if $pagename neq "submit"}
					<!-- START RIGHT COLUMN -->
					<div class="span3">
						<div class="well sidebar-nav">
							<div id="rightcol">
								{include file=$tpl_right_sidebar.".tpl"}
								{include file=$tpl_second_sidebar.".tpl"}
							</div>
						</div><!--/.well -->
					</div><!--/span-->
					<!-- END RIGHT COLUMN -->
				{/if}
			{checkActionsTpl location="tpl_pligg_banner_bottom"}
			</div><!--/.row-->
		</section><!--/#maincontent-->
		
		<hr>
		<footer class="footer">
			{include file=$tpl_footer.".tpl"}
		</footer>
		
	</div><!--/.container-->
	
	{if $Voting_Method == 2}
		{include file=$the_template"/functions/vote_star.tpl"}
	{else}
		{include file=$the_template"/functions/vote_normal.tpl"}
	{/if}
	{if $pagename eq "story"}
		{include file=$the_template"/functions/vote_comments.tpl"}
	{/if}
	
	
     {if $anonymous_vote eq "false" and $user_logged_in eq ""}
		{include file=$the_template"/modal_login_form.tpl"}
     {elseif $votes_per_ip>0 and $user_logged_in eq ""}  
        {include file=$the_template"/modal_login_form.tpl"}  
	 {/if}
	
	
	{checkActionsTpl location="tpl_pligg_body_end"}
	{if $pagename neq "submit"}<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>{/if}
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js"></script>
	<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/themes/smoothness/jquery-ui.css" media="all" rel="stylesheet" type="text/css" />
	
	<!--[if lt IE 7]>
	<script type="text/javascript" src="{$my_pligg_base}/templates/{$the_template}/js/jquery/jquery.dropdown.js"></script>
	<![endif]-->
	
	<!--for registration validation-->
	<script type="text/javascript" src="{$my_pligg_base}/templates/{$the_template}/js/registration_verify.js"></script>
	<script type="text/javascript" src="{$my_pligg_base}/templates/{$the_template}/js/bootstrap.js"></script>
	<script type="text/javascript" src="{$my_pligg_base}/templates/{$the_template}/js/bootstrap-fileupload.js"></script>
	<script type="text/javascript" src="{$my_pligg_base}/templates/{$the_template}/js/jquery/jquery.pnotify.js"></script>
	<script type="text/javascript" src="{$my_pligg_base}/templates/{$the_template}/js/jquery/jquery.masonry.min.js"></script>
	{include file=$the_template"/functions/update_story_link.tpl"}
    {if $pagename eq "topusers"}
     <script type="text/javascript" src="{$my_pligg_base}/templates/{$the_template}/js/jquery.tablesorter.js"></script>
    {literal}
    <script type="text/javascript">
        $(function() {		
            $("#tablesorter-demo").tablesorter({sortList:[[0,0]], widgets: ['zebra']});
            $("#options").tablesorter({sortList: [[0,0]], headers: { 3:{sorter: false}, 1:{sorter: false}}});
        });	
    </script>
    {/literal}
    {/if}
    
	{* JavaScript for tooltips on avatar hover *}
   
	{if $Auto_scroll eq true}
    {$Auto_scroll}
    <script type="text/javascript">
	var my_pligg_url="{$my_base_url}{$my_pligg_base}";
	var catID="{$catID}";
	var part="{$part}";
	{literal}
	$(document).ready(function()
	{
		var count=10;
		function last_msg_funtion() 
		{ 
			alert(count);
			var dataString = "action=load_data&start_up="+count+"&catID="+catID+"&part="+part;
			//alert(count);
			$.ajax({
			type: "POST",
			url:my_pligg_url+"/load_data.php",
			data: dataString,
			beforeSend: function() {
				//$(".stories:last").addClass("loader");
			},
			cache: false,
			success: function(html)	{
				if (html != "") {
				$(".stories:last").after(html); 
				$(".stories").removeClass("loader");
				count=count+3;
				}
				
				//parent.removeClass("loader");
			} 
		});
			
			//var ID=$(".stories:last").attr("id");
			
			//$('div#last_msg_loader').html('<img src="'+my_pligg_url+'/templates/bootstrap/css/images/ajax-loader.gif">');
			//$(".stories:last").addClass("loader");
			/*$.post(my_pligg_url+"/load_data.php?action=load_data&start_up="+count+"&catID="+catID+"&part="+part,

			function(data){
				if (data != "") {
				$(".stories:last").after(data); 
				$(".stories").removeClass("loader");
				count=count+3;
				}
				//$('div#last_msg_loader').empty();
				
			});*/
		}; 

		$(window).scroll(function(){
			if ($(window).scrollTop() == $(document).height() - $(window).height()){
				last_msg_funtion();
			}
		}); 
});

{/literal}
</script>
{/if}
	{literal}

<script> 
		$('.avatar-tooltip').tooltip()
		</script>
	{/literal}
	
	{if $pagename eq "submit"}
		<script src="{$my_pligg_base}/templates/{$the_template}/js/wysihtml5-0.3.0_rc3.js"></script>
		<script src="{$my_pligg_base}/templates/{$the_template}/js/bootstrap-wysihtml5.js"></script>
		{literal}<script>
			$('#bodytext').wysihtml5();
		</script>{/literal}
	{/if}
	{if $pagename eq "profile"}
		{literal}
		<script>
		  $(function(){
			var $container = $('#profile_container');
			$container.imagesLoaded( function(){
			  $container.masonry({
				itemSelector : '.table'
			  });
			});
		  });
		</script>
		{/literal}
	{/if}
</body>
</html>
{/if}{*END Maintenance Mode *}