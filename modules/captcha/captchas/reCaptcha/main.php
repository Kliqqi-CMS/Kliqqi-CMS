<?php
	function captcha_create($registration_details){
		global $main_smarty;

		$register_step_1_extra = $main_smarty->get_template_vars('register_step_1_extra');
		$register_step_1_extra .= $main_smarty->fetch(captcha_captchas_path . '/reCaptcha/captcha.tpl');
		$main_smarty->assign('register_step_1_extra', $register_step_1_extra);
	}

	function captcha_check($registration_details){
		global $main_smarty, $the_template;

		if (isset($_POST['g-recaptcha-response'])){
			$privatekey = get_misc_data('reCaptcha_prikey');
			$recaptcha = new \ReCaptcha\ReCaptcha($privatekey);
			$resp = $recaptcha->verify($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);
			if ($resp->isSuccess()){
				return true;
			}
			else{
				$main_smarty->assign('register_captcha_error', "The CAPTCHA answer provided is not correct. Please try again.");
				return false;
			}
		}else{
			$main_smarty->assign('register_captcha_error', "There is an error with the CAPTCHA setup, please contact your system administrator");
				return false;
		}
	}

	function captcha_configure(){
		global $main_smarty;

		if(isset($_REQUEST['pubkey'])){$pubkey = $_REQUEST['pubkey'];}else{$pubkey = '';}
		if(isset($_REQUEST['prikey'])){$prikey = $_REQUEST['prikey'];}else{$prikey = '';}

		if($pubkey != '' && $pubkey != get_misc_data('reCaptcha_pubkey')){
			misc_data_update('reCaptcha_pubkey', $pubkey);
			$main_smarty->assign('msg', 'Update Complete');
		}
		if($prikey != '' && $prikey != get_misc_data('reCaptcha_prikey')){
			misc_data_update('reCaptcha_prikey', $prikey);
			$main_smarty->assign('msg', 'Update Complete');
		}

		$main_smarty->assign('captcha_pubkey', get_misc_data('reCaptcha_pubkey'));
		$main_smarty->assign('captcha_prikey', get_misc_data('reCaptcha_prikey'));

	}

	function captcha_can_we_use(){
		global $main_smarty;

		$pubkey = get_misc_data('reCaptcha_pubkey');
		$prikey = get_misc_data('reCaptcha_prikey');

		if($pubkey == '' || $prikey == ''){
			$main_smarty->assign('msg', 'reCaptcha needs to be configured before it can be used.');
			return false;
		} else {
			return true;
		}
	}
?>