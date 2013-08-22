{************************************
************* Login Box *************
*************************************}
<!-- login_box.tpl -->
{if $pagename neq "login" && $user_authenticated neq true}
	<div class="headline">
		<div class="sectiontitle"><a href="{$URL_login}">{#PLIGG_Visual_Login_Title#}</a></div>
	</div>
	<div class="boxcontent">
	{checkActionsTpl location="tpl_widget_login_start"}
		<form action="{$URL_login}" method="post"> 
			{#PLIGG_Visual_Login_Username#}:<br />
			<input autofocus="autofocus" type="text" name="username" class="form-control" value="{if isset($login_username)}{$login_username}{/if}" tabindex="40" /><br />
			{#PLIGG_Visual_Login_Password#}:<br />
			<input type="password" name="password" class="form-control" tabindex="41" /><br />			
			{#PLIGG_Visual_Login_Remember#}: <input type="checkbox" name="persistent" tabindex="42" /><br />
			<input type="hidden" name="processlogin" value="1"/>
			<input type="hidden" name="return" value="{$templatelite.get.return|sanitize:3}"/>
			<input type="submit" value="{#PLIGG_Visual_Login_LoginButton#}" class="btn btn-default" tabindex="43" />
		</form>
		{checkActionsTpl location="tpl_widget_login_end"}
	</div>
{/if}
<!--/login_box.tpl -->