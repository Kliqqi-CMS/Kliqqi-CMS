{************************************
********* Modal Login Form **********
*************************************}
<!-- modal_login_form.tpl -->
<div class="modal fade" id="LoginModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">{#PLIGG_Visual_Login_Title#}</h4>
			</div>
			<div class="modal-body">
				<div style="margin:5px 15px 0 15px;">
					{checkActionsTpl location="tpl_pligg_login_link"}
					<label for="username">{#PLIGG_Visual_Login_Username#}/{#PLIGG_Visual_Register_Email#}</label>
					<input id="username" class="form-control" name="username" value="{if isset($login_username)}{$login_username}{/if}" title="username" tabindex="1" type="text">
				</div>
				<div style="margin:5px 15px 0 15px;">
					<label for="password">{#PLIGG_Visual_Login_Password#}</label>
					<input id="password" class="form-control" name="password" value="" title="password" tabindex="2" type="password">
				</div>
				<div style="margin:0px 0 0 15px;">
					<input id="remember" style="float:left;margin-right:5px;" name="persistent" value="1" tabindex="3" type="checkbox">
					<label for="remember" style="float:left;font-size:10px;">{#PLIGG_Visual_Login_Remember#}</label>
					<div style="clear:both;"></div>
				</div>
				<div style="margin:0px 18px 0px 15px;">
					<input type="hidden" name="processlogin" value="1"/>
					<input type="hidden" name="return" id="red_after_login" value="{$get.return}"/>
					<input id="signin_submit" class="btn btn-primary" style="margin:0; float:right;" value="{#PLIGG_Visual_Login_LoginButton#}" tabindex="4" type="submit">
				</div>		  
			</div>
			<div class="modal-footer">
				<p>{#PLIGG_Visual_Login_NewUsersA#}<a href="{$URL_register}" class="btn btn-success dropdown-toggle" tabindex="7">{#PLIGG_Visual_Login_NewUsersB#}</a></p>
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!--/modal_login_form.tpl -->