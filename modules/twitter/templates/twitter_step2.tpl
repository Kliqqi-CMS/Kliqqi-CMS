<div class="linetop" style="margin-bottom:15px;"></div>
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
				document.getElementById ('reg_usernamecheckitvalue').innerHTML = '<span style="color:black">' + responsestring + '</span>';
			} else {
				document.getElementById ('reg_usernamecheckitvalue').innerHTML = '<span style="color:red">' + responsestring + '</span>';
			}
		}
	}
  checkitxmlhttp.send ('name=' + encodeURIComponent(field.value));
  return false;
}
</script>
{/literal}


<div class="leftwrapper">

	<div style="margin:0;padding:6px 10px;width:96%;box-shadow:0 1px 2px rgba(0, 0, 0, 0.5);background:-moz-linear-gradient(center top , #48728c, #3c598e) repeat 0 0 transparent;">
		<img src="{$my_base_url}{$my_pligg_base}/modules/twitter/templates/images/twitter_logo.png" width="108px" height="20px" alt="Twitter" />
	</div>

	<h1 style="font-size:24px;margin:12px 0 2px 0;padding:0;">Welcome Twitter User!</h1>
	<p style="margin:0 0 12px 0;">To start using the site you will need to select a new username, or connect your Twitter account to an existing account.</p> 

	<div class="register-left" style="border-right:1px solid #eee;">
	<form method="post" id="thisform">
		<h2>Create a New Account</h2>
		<p>Don't have an account yet? Click the Create New User button below to open a new account.</p>

		<strong>New Username:</strong><br />
		<div class="twitter_username_input"><input style="margin:3px 0;" type="text" onchange="checkname(this)" name="reg_username" id="reg_username" value="{if isset($reg_username)}{$reg_username}{/if}" size="25" tabindex="10" maxlength="32"/><br /> <span id="reg_usernamecheckitvalue"></span></div>
		<div style="color:#AA0200;" class="twitter_username_error">{$error}</div>

		{include file=$twitter_tpl_path."twitter_fields.tpl"}

		<br />
		<input type="submit" name="submit" value="Create New User" class="btn" tabindex="16" />
		<input type="hidden" name="regfrom" value="full"/>
	</form>
	</div>

	<div class="register-right">
		<h2>Existing Account?</h2>
		<p>Enter your existing login credentials and we will connect your account with your Twitter account. This will make the login process easier and add other features to your profile.</p>
		<form action="{$URL_login}" method="post">	
			<strong>Username:</strong><br />
				<input type="text" name="username" class="login" value="{if isset($login_username)}{$login_username}{/if}" tabindex="10" /><br />
				<br /><strong>Password:</strong><br />
				<input type="password" name="password" class="login" tabindex="11" /><br />
			<input type="hidden" name="processlogin" value="1"/>
			<input type="hidden" name="return" value="{$templatelite.get.return|sanitize:3}"/>
			<input type="checkbox" name="persistent" tabindex="12" /> Keep me logged in
			<br />

			{include file=$twitter_tpl_path."twitter_fields.tpl"}

			<br />
			<input type="submit" value="Connect Existing Account" class="submit-s" tabindex="13" />
		</form>
	</div>

</div>
