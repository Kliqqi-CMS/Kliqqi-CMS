{config_load file=fb_lang_conf}
{literal}
<script>
function checkname (field)
{
	url = '../../checkfield.php?type=username';
	checkitxmlhttp = new myXMLHttpRequest ();
	checkitxmlhttp.open ("POST", url, true);
	checkitxmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	checkitxmlhttp.onreadystatechange = function () {
		if (checkitxmlhttp.readyState == 4) {
		responsestring = checkitxmlhttp.responseText;
			if (responsestring == 'OK') {
				document.getElementById ('reg_usernamecheckitvalue').innerHTML = '<span style="padding:2px;color:#167F0F">' + responsestring + '</span>';
			} else {
				document.getElementById ('reg_usernamecheckitvalue').innerHTML = '<span style="padding:2px;color:#AA0200">Taken</span>';
			}
		}
	}
  checkitxmlhttp.send ('name=' + encodeURIComponent(field.value));
  return false;
}
</script>
{/literal}

{literal}
<style type="text/css">
.register-left{
float:left;
border-right:1px solid #eee;
margin-left:0;
width:400px;
}
.register-right {
float:left;
width:400px;
}
</style>
{/literal}

<div class="facebook_register_wrapper">

	<div style="float:left;background:#3B5998;color:#fff;width:100%;">
		<img src="{$my_base_url}{$my_pligg_base}/modules/fb/images/facebook.png" width="103px" height="30px" alt="Facebook" style="float:left;display:inline;" />
	</div>

	<h1 style="font-size:24px;color:#3B5998;margin:12px 0 2px 0;padding:0;">{#PLIGG_FB_WELCOME_FACEBOOK_USER#}</h1>
	<p style="margin:0 0 12px 0;">{#PLIGG_FB_To_start_using_the_site#}</p> 

	<div class="register-left span4">
		<h3 style="color:#3B5998;">{#PLIGG_FB_Create_a_New_Account#}</h3>
		<p>{#PLIGG_FB_Dont_have_an_account_yet#}</p>
		<form method="post" id="thisform">
			<strong>{#PLIGG_FB_Username#}</strong><br />
			<div class="facebook_username_input">
				<input style="margin:3px 0;" type="text" onchange="checkname(this)" name="reg_username" id="reg_username" value="{if isset($reg_username)}{$reg_username}{/if}" size="25" tabindex="10" maxlength="32"/> <span id="reg_usernamecheckitvalue" style="background:#fff;margin:2px 0;font-weight:bold;"></span>
			</div>
			{if $error}
				<div class="alert facebook_username_error">{$error}</div>
			{/if}
			{include file=$fb_tpl_path."fb_fields.tpl"}
			<br />
			{config_load file=fb_lang_conf}
			<input type="submit" name="submit" value="{#PLIGG_FB_Create_New_User#}" class="btn btn-primary" tabindex="16" />
			<input type="hidden" name="regfrom" value="full"/>
		</form>
	</div>

	<div class="register-right span4">
		<h3 style="color:#3B5998;">{#PLIGG_FB_Existing_Account#}</h3>
		<p>{#PLIGG_FB_Enter_your_existing_login_credentials#}</p>
		<form action="{$URL_login}" method="post">	
			<strong>Username:</strong><br />
				<input type="text" name="username" class="input-large" value="{if isset($login_username)}{$login_username}{/if}" tabindex="10" /><br />
				<strong>Password:</strong><br />
				<input type="password" name="password" class="input-large" tabindex="11" />
				<br />
			<input type="hidden" name="processlogin" value="1"/>
			<input type="hidden" name="return" value="{$templatelite.get.return|sanitize:3}"/>
			<input type="checkbox" name="persistent" tabindex="12" /> {#PLIGG_FB_Keep_me_logged_in#}
			<br style="margin-bottom:2px" />
			{include file=$fb_tpl_path."fb_fields.tpl"}
			<br />
			{config_load file=fb_lang_conf}
			<input type="submit" value="{#PLIGG_FB_Connect_Existing_Account#}" class="btn btn-primary" tabindex="13" />
		</form>
	</div>

</div>

{config_load file=fb_pligg_lang_conf}