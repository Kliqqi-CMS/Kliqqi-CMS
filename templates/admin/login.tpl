{literal}
<style type="text/css">
/* Override some defaults */
html, body {
background-color: #eee;
text-align:center;
}
</style>
{/literal}
<div class="login_box">
	<div class="login_content">
		{if $errorMsg ne ""}
			<div class="alert alert-warning">
				<a class="close" data-dismiss="alert" href="#">&times;</a>
				{$errorMsg}
			</div>
		{/if}
		<div class="login_form">
			<h2>{#PLIGG_Visual_Name#}</h2>
			<form action="{$my_pligg_base}/admin/admin_login.php" method="post">
				<div class="clearfix login_username">
					<input type="text" class="form-control" name="username" {if $post_username}value="{$post_username}"{else}placeholder="{#PLIGG_Visual_Register_Username#}{/if}">
				</div>
				<div class="clearfix login_password">
					<input type="password" class="form-control" name="password" placeholder="{#PLIGG_Visual_Register_Password#}">
				</div>
				<input type="hidden" name="processlogin" value="1"/>
				<input type="hidden" name="return" value="{$get.return}"/>
				<button class="btn btn-primary col-md-12 admin_login_submit" type="submit">{#PLIGG_Visual_Login_LoginButton#}</button>
			</form>
		</div>
	</div>
</div>
