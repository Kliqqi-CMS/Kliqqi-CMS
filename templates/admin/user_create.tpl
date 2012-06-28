<div style="padding-left:10px;">
<h2>{#PLIGG_Visual_AdminPanel_New_User#}</h2>
<form action="" method="post" onsubmit="validate();" onsubmit="self.close ();">
  <div style="padding-left:20px;font-weight:bold;">
	<form action="" method="post" onsubmit="validate();" class="form">
	{$hidden_token_admin_users_create}

	  <label for="username">{#PLIGG_Visual_Register_Username#}:</label>
	    <div class="div_texbox">
	    <input name="username" type="text" class="textbox" id="username" value="" />
		</div>
		{if isset($username_error)}{ foreach value=error from=$username_error }<br /><div class="error">{$error}</div><br />{ /foreach }<br />{/if}	
		<div style="clear:both;"></div>
		<label for="email">{#PLIGG_Visual_Register_Email#}:</label>
		<div class="div_texbox">
	    <input name="email" type="text" class="textbox" id="city" value="" />
		</div>
		{if isset($email_error)}{ foreach value=error from=$email_error }<br /><div class="error">{$error}</div><br />{ /foreach }<br />{/if}	
		<div style="clear:both;"></div>
		<label>{#PLIGG_Visual_View_User_Level#}:</label>
		<div class="div_texbox">
		<select name="level">
		<option value="normal">Normal</option>
		<option value="admin">Admin</option>
		<option value="god">God</option>	
		</select>
		</div>
		<div style="clear:both;"></div>
		<label for="password">{#PLIGG_Visual_Register_Password#}:</label>
	    <div class="div_texbox">
	    <input name="password" type="text" class="textbox" id="password" value="" />
		</div>
		{if isset($password_error)}{ foreach value=error from=$password_error }<br /><div class="error">{$error}</div><br />{ /foreach }<br />{/if}	
		<div style="clear:both;"></div>
		<div class="buton_div">
		<input type="hidden" name="mode" value="newuser">
		<input type="submit" value="Create User" class="log2 buttons buttonright" />
		</div>
		
	</form>
	</div>
</form>
</div>