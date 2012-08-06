{config_load file=fb_lang_conf}

{*

{if $user_authenticated && $user_fb_id}
	{literal}
		<style type="text/css">
		.facebook_grant_permission {display:inline;}
		.facebook_grant_permission img, .facebook_grant_permission img a {border:0px;}
		</style>
	{/literal}
	
	<div class="facebook_grant_permission">
		<h2>{#PLIGG_FB_Submit_Title#}</h2>
		<p>{#PLIGG_FB_Submit_Description#}</p>
		{if !$has_permission}
			<a href='{$my_pligg_base}/modules/fb/fb.php?mode=perm' onclick='window.open("{$my_pligg_base}/modules/fb/fb.php?mode=perm","new","width=300, height=300, toolbar=no, location=yes, directories=no, menubar=no, fullscreen=no"); return false;'>
				<img src="{$my_pligg_base}/modules/fb/images/post_to_wall.gif" alt="{#PLIGG_FB_Submit_to_Wall#}"><br />
			</a>
		{/if}
	</div>
{/if}

*}

{config_load file=fb_pligg_lang_conf}
