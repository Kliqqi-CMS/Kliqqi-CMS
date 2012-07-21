<?php

function captcha_showpage(){

	force_authentication();
	$canIhaveAccess = 0;
	$canIhaveAccess = $canIhaveAccess + checklevel('admin');

	if($canIhaveAccess == 1)
	{

		global $main_smarty, $the_template;

		$navwhere['text1'] = 'Captcha';
		$navwhere['link1'] = URL_captcha;

		define('pagename', 'captcha'); 
		$main_smarty->assign('pagename', pagename);
		
		// New method for identifying modules rather than pagename
		define('modulename', 'captcha'); 
		$main_smarty->assign('modulename', modulename);

		$main_smarty = do_sidebar($main_smarty, $navwhere);

		if(isset($_REQUEST['action'])){$action = $_REQUEST['action'];}else{$action = '';}

		if($action == 'enable'){
			if(isset($_REQUEST['captcha'])){$captcha = $_REQUEST['captcha'];}else{$captcha = '';}
			enable_captcha($captcha);
		}

		if($action == 'configure')
		{
			if(isset($_REQUEST['captcha']) && !strstr($_REQUEST['captcha'], '/')) 
			{
				$captcha = $_REQUEST['captcha'];
				include_once(captcha_captchas_path . '/' . $captcha . '/main.php');
				captcha_configure();
				$main_smarty->assign('tpl_center', captcha_tpl_path . '../captchas/' . $captcha . '/captcha_configure');
				$main_smarty->display($template_dir . '/admin/admin.tpl');
			}
			die();
		}


		if($action == 'EnableReg'){

			$value = (isset($_REQUEST['value'])) ? $_REQUEST['value'] : '';

			if($value != ''){
				misc_data_update('captcha_reg_en', $value);
			}

			header('Location: ' . URL_captcha);

		}

		if($action == 'EnableStory'){
			$value = (isset($_REQUEST['value'])) ? $_REQUEST['value'] : '';
			if($value != ''){
				misc_data_update('captcha_story_en', $value);
			}
			header('Location: ' . URL_captcha);
		}

		if($action == 'EnableComment'){
			$value = (isset($_REQUEST['value'])) ? $_REQUEST['value'] : '';
			if($value != ''){
				misc_data_update('captcha_comment_en', $value);
			}
			header('Location: ' . URL_captcha);
		}

		$captcha = get_misc_data('captcha_method');
		if($captcha == ''){$captcha = 'recaptcha';}
		$main_smarty->assign('captcha_method', $captcha);

		$main_smarty->assign('tpl_center', captcha_tpl_path . '/captcha_home');
		$main_smarty->display($template_dir . '/admin/admin.tpl');
	}
	else
		header("Location: " . getmyurl('login', $_SERVER['REQUEST_URI']));
}

function enable_captcha($captcha){

	include_once(captcha_captchas_path . '/' . $captcha . '/main.php');

	if(captcha_can_we_use()){
		misc_data_update('captcha_method', $captcha);
		//captcha_admin();
	}	

}

function captcha_register(&$vars){
		global $main_smarty, $the_template, $captcha_registered;
		if ($captcha_registered) return;
		$captcha_registered = true;

		$captcha = get_misc_data('captcha_method');
		if($captcha == ''){$captcha = 'recaptcha';}
		include_once(captcha_captchas_path . '/' . $captcha . '/main.php');
		captcha_create('', 0);
}

function captcha_register_check_errors(&$vars){
		global $main_smarty, $the_template, $captcha_checked;
		if ($captcha_checked) return;
		$captcha_checked = true;

		$captcha = get_misc_data('captcha_method');
		if($captcha == ''){$captcha = 'recaptcha';}

		$username = $vars['username'];
		$email = $vars['email'];
		$password = $vars['password'];

		$main_smarty->assign('username', $username);
		$main_smarty->assign('email', $email);
		$main_smarty->assign('password', $password);

		include_once(captcha_captchas_path . '/' . $captcha . '/main.php');
		if(captcha_check($vars, 2)){
		} else {
			$vars['error'] = true;
		}
}
?>
