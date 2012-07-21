<!-- user_create.tpl --><html>
<head>
	<link rel="stylesheet" type="text/css" href="{$my_base_url}{$my_pligg_base}/templates/admin/css/bootstrap.css" media="screen">
</head>
<body>
	<div class="modal-header">
		<a class="close" data-dismiss="modal">×</a>
		<h3>{#PLIGG_Visual_AdminPanel_New_User#}</h3>
	</div>
	<div class="modal-body">
		<form action="" method="post" onsubmit="validate();" onsubmit="self.close ();">	<form action="" method="post" onsubmit="validate();" class="form">
			{$hidden_token_admin_users_create}
			<label for="username">{#PLIGG_Visual_Register_Username#}:</label>
			<div class="div_texbox">
				<input name="username" type="text" class="textbox" id="username" value="" />
			</div>
			{if isset($username_error)}
				<div class="alert">
					<button class="close" data-dismiss="alert">×</button>
					{ foreach value=error from=$username_error }
						<p class="error">{$error}</p>
					{ /foreach }
				</div>
			{/if}	
			<div style="clear:both;"></div>
			<label for="email">{#PLIGG_Visual_Register_Email#}:</label>
			<div class="div_texbox">
				<input name="email" type="text" class="textbox" id="city" value="" />
			</div>
			{if isset($email_error)}
				<div class="alert">
					<button class="close" data-dismiss="alert">×</button>
					{ foreach value=error from=$email_error }
						<p class="error">{$error}</p>
					{ /foreach }
				</div>
			{/if}	
			<div style="clear:both;"></div>
			<label>{#PLIGG_Visual_View_User_Level#}:</label>
			<div class="div_texbox">
				<select name="level">
					<option value="normal">Normal</option>
					<option value="moderator">Moderator</option>
					<option value="admin">Admin</option>
				</select>
			</div>
			<div style="clear:both;"></div>
			<label for="password">{#PLIGG_Visual_Register_Password#}:</label>
			<div class="div_texbox">
				<input name="password" type="text" class="textbox" id="password" value="" />
			</div>
			{if isset($password_error)}
				<div class="alert">
					<button class="close" data-dismiss="alert">×</button>
					{ foreach value=error from=$password_error }
						<p class="error">{$error}</p>
					{ /foreach }
				</div>
			{/if}	
			<div style="clear:both;"></div>
			<div class="buton_div">
				<input type="hidden" name="mode" value="newuser">
				<input type="submit" class="btn btn-primary" value="Create User"/>
			</div>
		</form>
	</div>
	<div class="modal-footer">
		<a class="btn" data-dismiss="modal">Close</a>
	</div>
</body>
</html><!--/user_create.tpl -->