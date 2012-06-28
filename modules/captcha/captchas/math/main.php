<?php

	function captcha_create($registration_details){
		global $main_smarty, $the_template;
		if(!isset($_SESSION)){session_start();}
		$_SESSION['captcha_math_answer'] == '';
	
		$q_1_low = (get_misc_data('captcha_math_q1low') == '') ? 1 : get_misc_data('captcha_math_q1low');
		$q_1_high = (get_misc_data('captcha_math_q1high') == '') ? 5 : get_misc_data('captcha_math_q1high');
		$q_2_low = (get_misc_data('captcha_math_q2low') == '') ? 1 : get_misc_data('captcha_math_q2low');
		$q_2_high = (get_misc_data('captcha_math_q2high') == '') ? 5 : get_misc_data('captcha_math_q2high');

		$number1 = mt_rand($q_1_low, $q_1_high);
		$number2 = mt_rand($q_2_low, $q_2_high);
		$answer = $number1 + $number2;

		$main_smarty->assign('number1', $number1);
		$main_smarty->assign('number2', $number2);
		$_SESSION['captcha_math_answer'] = $answer;

		$register_step_1_extra = $main_smarty->get_template_vars('register_step_1_extra');
		$register_step_1_extra .= $main_smarty->fetch(captcha_captchas_path . '/math/captcha.tpl');
		$main_smarty->assign('register_step_1_extra', $register_step_1_extra);
	}

	function captcha_check($registration_details){
		global $main_smarty, $the_template;

		if(!isset($_SESSION)){session_start();}

		$answer = (isset($_POST['answer'])) ? $_POST['answer'] : '';
		if ($answer != $_SESSION['captcha_math_answer']){

			$main_smarty->assign('register_captcha_error', "The CAPTCHA answer provided is not correct. Please try again.");

			return false;

		} else {

			return true;
		}
	
	}

	function captcha_configure(){
		global $main_smarty, $the_template;

		$q_1_low = (isset($_REQUEST['q_1_low'])) ? $_REQUEST['q_1_low'] : '';
		$q_1_high = (isset($_REQUEST['q_1_high'])) ? $_REQUEST['q_1_high'] : '';
		$q_2_low = (isset($_REQUEST['q_2_low'])) ? $_REQUEST['q_2_low'] : '';
		$q_2_high = (isset($_REQUEST['q_2_high'])) ? $_REQUEST['q_2_high'] : '';

		if($q_1_low != ''){misc_data_update('captcha_math_q1low', $q_1_low);} else {$q_1_low = (get_misc_data('captcha_math_q1low') == '') ? 1 : get_misc_data('captcha_math_q1low');}
		if($q_1_high != ''){misc_data_update('captcha_math_q1high', $q_1_high);} else {$q_1_high = (get_misc_data('captcha_math_q1high') == '') ? 5 : get_misc_data('captcha_math_q1high');}
		if($q_2_low != ''){misc_data_update('captcha_math_q2low', $q_2_low);} else {$q_2_low = (get_misc_data('captcha_math_q2low') == '') ? 1 : get_misc_data('captcha_math_q2low');}
		if($q_2_high != ''){misc_data_update('captcha_math_q2high', $q_2_high);} else {$q_2_high = (get_misc_data('captcha_math_q2high') == '') ? 5 : get_misc_data('captcha_math_q2high');}

		$main_smarty->assign('q_1_low', sanitize($q_1_low, 2));
		$main_smarty->assign('q_1_high', sanitize($q_1_high, 2));
		$main_smarty->assign('q_2_low', sanitize($q_2_low, 2));
		$main_smarty->assign('q_2_high', sanitize($q_2_high, 2));
	}

	function captcha_can_we_use(){
		// nothing special is needed for this captcha
		return true;
	}
?>
