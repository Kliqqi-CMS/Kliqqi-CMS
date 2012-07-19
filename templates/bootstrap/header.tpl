{************************************
********* Header Template ***********
*************************************}
<!-- header.tpl -->
<div class="navbar navbar-fixed-top">
	<div class="navbar-inner">
		<div class="container">
			{* The next few lines form the button that appears in the navbar when the page width is small *}
			<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</a>
			<a class="brand" href="{$my_base_url}{$my_pligg_base}">{#PLIGG_Visual_Name#}</a>
			{if $user_authenticated eq true}
				<div class="btn-group pull-right">
					<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
						<i class="icon-user"></i> {$user_logged_in}
						<span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
						{checkActionsTpl location="tpl_pligg_profile_sort_start"}
						<li><a href="{$URL_userNoVar}" class="navbut{$nav_pd}">{#PLIGG_Visual_Profile#}</a></li>
						<li><a href="{$user_url_setting}" class="navbut{$nav_set}"><span>{#PLIGG_Visual_User_Setting#}</a></li>
						<li><a href="{$user_url_news_sent}" class="navbut{$nav_ns}">{#PLIGG_Visual_User_NewsSent#}</a></li>
						<li><a href="{$user_url_commented}" class="navbut{$nav_c}">{#PLIGG_Visual_User_NewsCommented#}</a></li>
						<li><a href="{$user_url_news_voted}" class="navbut{$nav_nv}">{#PLIGG_Visual_User_NewsVoted#}</a></li>
						<li><a href="{$user_url_saved}" class="navbut{$nav_s}">{#PLIGG_Visual_User_NewsSaved#}</a></li>
						{checkActionsTpl location="tpl_pligg_profile_sort_end"}
						<li class="divider"></li>
						<li><a href="{$URL_logout}">{#PLIGG_Visual_Logout#}</a></li>
					</ul>
				</div>
				<!--/$user_authenticated -->
			{/if}
			<div class="nav-collapse">
				<ul class="nav">
					<li {if $pagename eq "published" || $pagename eq "index"}class="active current"{/if}><a href="{$my_base_url}{$my_pligg_base}">Home</a></li>
					{checkActionsTpl location="tpl_pligg_navbar_start"}
					<li {if $pagename eq "upcoming"}class="active current"{/if}><a href="{$URL_upcoming}">{#PLIGG_Visual_Pligg_Queued#}</a></li>
					<li {if $pagename eq "submit"}class="active current"{/if}><a href="{$URL_submit}">{#PLIGG_Visual_Submit_A_New_Story#}</a></li>
					{if $enable_group eq "true"}	
						<li {if $pagename eq "groups" || $pagename eq "submit_groups" || $pagename eq "group_story"}class="active current"{/if}><a href="{$URL_groups}"><span>{#PLIGG_Visual_Groups#}</span></a></li>
					{/if}
						<li {if $pagename eq "topusers"}class="active current"{/if}><a href="{$URL_topusers}"><span>{#PLIGG_Visual_Top_Users#}</span></a></li>
					{if $Enable_Tags}
						<li {if $pagename eq "cloud"}class="active current"{/if}><a href="{$URL_tagcloud}"><span>{#PLIGG_Visual_Tags#}</span></a></li>
					{/if}
					{if $Enable_Live}
						<li {if $pagename eq "live"}class="active current"{/if}><a href="{$URL_live}"><span>{#PLIGG_Visual_Live#}</span></a></li>
					{/if}
					{if isset($isgod) && $isgod eq 1}
						<li><a href="{$URL_admin}"><span>{#PLIGG_Visual_Header_AdminPanel#}</span></a></li>
					{/if}
					{checkActionsTpl location="tpl_pligg_navbar_end"}
					{if $user_authenticated neq true}
						{if $pagename eq "register"}
							<li {if $pagename eq "register"}class="active current"{/if}><a href="{$URL_register}"><span>{#PLIGG_Visual_Register#}</span></a></li>
						{else}
							<!-- Register Modal -->
							<div id="myModal" class="modal hide fade">
								<div class="modal-header">
									<button class="close" data-dismiss="modal">&times;</button>
									<h3>{#PLIGG_Visual_Register#}</h3>
								</div>
							
								<div class="modal-body">
									<div class="control-group">
										{checkActionsTpl location="tpl_pligg_register_start"}
										<form action="{$URL_register}" method="post" id="thisform" class="form-horizontal">
										
										<label class="control-label" for="input01">{#PLIGG_Visual_Register_Username#}</label>
										<div class="controls">
											<input type="text" class="input-large reg_username" name="reg_username">
											<br/><span class="reg_usernamecheckitvalue"></span><br/>
										</div>
										<label class="control-label" for="input01">{#PLIGG_Visual_Register_Email#}</label>
										<div class="controls">
											{if isset($form_email_error)}
												{ foreach value=error from=$form_email_error }
													<div class="alert alert-block alert-error fade in"><button data-dismiss="alert" class="close">×</button>{$error}</div>
												{ /foreach }
											{/if}
											<input type="text" class="input-large reg_email" id="reg_email" placeholder="" name="reg_email">
											<br/><span class="reg_emailcheckitvalue"></span><br/>
										</div>
										<label class="control-label" for="input01">{#PLIGG_Visual_Register_Password#}</label>
										<div class="controls">
											{if isset($form_password_error)}
												{ foreach value=error from=$form_password_error }
													<div class="alert alert-block alert-error fade in"><button data-dismiss="alert" class="close">×</button>{$error}</div>
												{ /foreach }
											{/if}
											<input type="password" class="input-large" id="reg_password" name="reg_password" placeholder="{if isset($reg_password)}{$reg_password}{/if}">
											<p class="help-block">{#PLIGG_Visual_Register_FiveChar#}</p>
										</div>
										<label class="control-label" for="input01">{#PLIGG_Visual_Register_Verify_Password#}</label>
										<div class="controls">
											<input type="password" class="input-large" id="reg_verify" name="reg_password2" placeholder="{if isset($reg_password2)}{$reg_password2}{/if}">
										</div>
										
										{if isset($register_step_1_extra)}
											{if $captcha_method eq "reCaptcha"}
												{$register_step_1_extra}
											{elseif $captcha_method eq "WhiteHat"}
												<label class="control-label" for="input01">CAPTCHA</label>
												<div class="controls">{$register_step_1_extra}</div>
											{elseif $captcha_method eq "math"}
												<div class="controls">{$register_step_1_extra}</div> 
											{/if}
										{/if}
										 
									</div>
									<hr />
									<h4>{#PLIGG_Visual_Register_Description_Title#}</h4>
									<p>
										{#PLIGG_Visual_Register_Description_Paragraph#}
										<ul>
											{#PLIGG_Visual_Register_Description_Points#}
										</ul>
									</p>
									{checkActionsTpl location="tpl_pligg_register_end"}
								</div><!--/.modal-body -->
								<div class="modal-footer">
									<a href="#" class="btn" data-dismiss="modal" >Close</a>
									<input type="submit" name="submit" value="{#PLIGG_Visual_Register_Create_User#}" class="btn btn-primary" style="margin:0;"/>
									<input type="hidden" name="regfrom" value="full"/>
								</div>
								</form><!--/.form-horizontal -->
							</div><!--/.modal -->
							<li><a href="#myModal" data-toggle="modal">{#PLIGG_Visual_Register#}</a></li>
						{/if}
						<li class="dropdown">
							<a data-toggle="dropdown" class="dropdown-toggle" href="#">{#PLIGG_Visual_Login_Title#} <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li>
									<form id="signin" action="{$URL_login}" method="post">
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
										<div style="margin:0;text-align:center;margin:0 auto;width:100%;">
											<input type="hidden" name="processlogin" value="1"/>
											<input type="hidden" name="return" value="{$get.return}"/>
											<input id="signin_submit" class="btn btn-primary" style="margin:0;width:90%;" value="{#PLIGG_Visual_Login_LoginButton#}" tabindex="4" type="submit">
											<a id="forgot_password_link" class="btn" style="margin:8px 0 6px 0;width:81%;" href="{$URL_login}">{#PLIGG_Visual_Login_ForgottenPassword#}?</a>
										</div>
									</form>
								</li>
							</ul><!--/.dropdown-menu -->
						</li><!--/.dropdown -->
						<!--/$user_authenticated -->
					{/if}
				</ul><!--/.nav -->
			</div><!--/.nav-collapse -->
		</div><!--/.container -->
	</div><!--/.navbar-inner -->
</div><!--/.navbar -->
<div class="navbar navbar-fixed-top">
  <div id="categories">
	<div class="container">
		<!-- START CATEGORIES -->
		{assign var=sidebar_module value="categories"}{include file=$the_template_sidebar_modules."/wrapper.tpl"}
		<!-- END CATEGORIES -->
	</div>
  </div>
</div>
<!--/header.tpl -->