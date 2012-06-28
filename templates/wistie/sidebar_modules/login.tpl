{if $pagename neq "login"}
<div class="headline">
	<div class="sectiontitle"><a href="{$URL_login}">{#PLIGG_Visual_Login_Title#}</a></div>
</div>
<div class="boxcontent">
{checkActionsTpl location="tpl_widget_login_start"}
	<form action="{$URL_login}" method="post"> 
		{#PLIGG_Visual_Login_Username#}:<br /><input type="text" name="username" class="login" value="{if isset($login_username)}{$login_username}{/if}" tabindex="40" /><br />
		{#PLIGG_Visual_Login_Password#}:<br /><input type="password" name="password" class="login" tabindex="41" /><br />
		<input type="hidden" name="processlogin" value="1"/>
		<input type="hidden" name="return" value="{$templatelite.get.return|sanitize:3}"/>
		{#PLIGG_Visual_Login_Remember#}: <input type="checkbox" name="persistent" tabindex="42" />
		<input type="submit" value="{#PLIGG_Visual_Login_LoginButton#}" class="submit-s" tabindex="43" />
	</form>
	{checkActionsTpl location="tpl_widget_login_end"}
</div>
{/if}