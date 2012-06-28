<?php

	function captcha_create($registration_details){
		global $main_smarty, $the_template;

		if(!isset($_SESSION)){session_start();}
		unset($_SESSION['security_code']);

		$register_step_1_extra = $main_smarty->get_template_vars('register_step_1_extra');
		$register_step_1_extra .= $main_smarty->fetch(captcha_captchas_path . '/WhiteHat/captcha.tpl');
		$main_smarty->assign('register_step_1_extra', $register_step_1_extra);

	}

	function captcha_check($registration_details){
		global $main_smarty, $the_template;

		if(!isset($_SESSION)){session_start();}

		$username = $registration_details['username'];
		$email = $registration_details['email'];
		$password = $registration_details['password'];
		$user_code = (isset($_POST['security_code'])) ? $_POST['security_code'] : '';
		$sess_code = (isset($_SESSION['security_code'])) ? $_SESSION['security_code'] : '';

		if( $sess_code == $user_code && $user_code != '') {
			unset($_SESSION['security_code']);
			return true;
		} else {

			$main_smarty->assign('register_captcha_error', "The CAPTCHA answer provided is not correct. Please try again.");
			return false;

		}

	}

	function captcha_configure(){
		// there is nothing to configure for this captcha
	}

	function captcha_can_we_use(){
		// nothing special is needed for this captcha
		return true;
	}
?>
