<div id="LoginModal" class="modal hide fade LoginModal">
					<div class="modal-header">
					  <button class="close" data-dismiss="modal">&times;</button>
					  <h3>{#PLIGG_Visual_Login_Title#}</h3>
					</div>
					{checkActionsTpl location="tpl_pligg_register_start"}
					<form id="signin" action="{$URL_login}" method="post">	
					<div class="modal-body">
					
					<div style="margin:5px 15px 0 15px;">
							{checkActionsTpl location="tpl_pligg_login_link"}
							<label for="username">{#PLIGG_Visual_Login_Username#}/{#PLIGG_Visual_Register_Email#}</label>
							<input id="username" name="username" value="{if isset($login_username)}{$login_username}{/if}" title="username" tabindex="1" type="text">
						</div>
						<div style="margin:5px 15px 0 15px;">
							<label for="password">{#PLIGG_Visual_Login_Password#}</label>
							<input id="password" name="password" value="" title="password" tabindex="2" type="password">
						</div>
						<div style="margin:0px 0 0 15px;">
							<input id="remember" style="float:left;margin-right:5px;" name="persistent" value="1" tabindex="3" type="checkbox">
							<label for="remember" style="float:left;font-size:10px;">{#PLIGG_Visual_Login_Remember#}</label>
							<div style="clear:both;"></div>
						</div>
						<div  style="margin:0px 18px 0px 15px;">
						<input type="hidden" name="processlogin" value="1"/>
							<input type="hidden" name="return" id="red_after_login" value="{$get.return}"/>
							<input id="signin_submit" class="btn btn-primary" style="margin:0; float:right;" value="{#PLIGG_Visual_Login_LoginButton#}" tabindex="4" type="submit">
						
						</div>		
					</div>
						<div class="modal-footer">
							
									
							<p>{#PLIGG_Visual_Login_NewUsersA#}<a href="{$register_url}" class="btn btn-success dropdown-toggle" tabindex="7">{#PLIGG_Visual_Login_NewUsersB#}</a></p>
							
							
						</div>
					 </form> 
					</div>


