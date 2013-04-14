<?php

	function captcha_create($registration_details){
		global $main_smarty;

		$register_step_1_extra = $main_smarty->get_template_vars('register_step_1_extra');
		$register_step_1_extra .= $main_smarty->fetch(captcha_captchas_path . '/solvemedia/captcha.tpl');
		$main_smarty->assign('register_step_1_extra', $register_step_1_extra);

	}

	function captcha_check($registration_details){
		global $main_smarty, $the_template;
		require_once(captcha_captchas_path . '/solvemedia/lib/solvemedialib.php');

		$privatekey = get_misc_data('adcopy_privkey');
		$hashkey = get_misc_data('adcopy_hashkey');
		$resp = solvemedia_check_answer ($privatekey,
				                $_SERVER["REMOTE_ADDR"],
				                $_POST["adcopy_challenge"],
				                $_POST["adcopy_response"],
						$hashkey);
		if (!$resp->is_valid) {

			$main_smarty->assign('register_captcha_error', "The Solve Media puzzle answer provided is not correct. Please try again.");

			return false;

		} else {
		
      return true;
      
    }


	}

	function captcha_configure(){
		global $main_smarty;

		if(isset($_REQUEST['pubkey'])){$pubkey = $_REQUEST['pubkey'];}else{$pubkey = '';}
		if(isset($_REQUEST['privkey'])){$privkey = $_REQUEST['privkey'];}else{$privkey = '';}
		if(isset($_REQUEST['hashkey'])){$hashkey = $_REQUEST['hashkey'];}else{$hashkey = '';}
		if(isset($_REQUEST['theme'])){$theme = $_REQUEST['theme'];}else{$theme = '';}
		if(isset($_REQUEST['lang'])){$lang = $_REQUEST['lang'];}else{$lang = '';}

		if($pubkey != '' && $pubkey != get_misc_data('adcopy_pubkey')){
			misc_data_update('adcopy_pubkey', $pubkey);
			$main_smarty->assign('msg', 'Settings Saved');
		}
		if($privkey != '' && $privkey != get_misc_data('adcopy_privkey')){
			misc_data_update('adcopy_privkey', $privkey);
			$main_smarty->assign('msg', 'Settings Saved');
		}
		if($hashkey != '' && $hashkey != get_misc_data('adcopy_hashkey')){
			misc_data_update('adcopy_hashkey', $hashkey);
			$main_smarty->assign('msg', 'Settings Saved');
		}
		if($theme != '' && $theme != get_misc_data('adcopy_theme')){
			misc_data_update('adcopy_theme', $theme);
			$main_smarty->assign('msg', 'Settings Saved');
		}
		if($lang != '' && $lang != get_misc_data('adcopy_lang')){
			misc_data_update('adcopy_lang', $lang);
			$main_smarty->assign('msg', 'Settings Saved');
		}

		$main_smarty->assign('captcha_pubkey', get_misc_data('adcopy_pubkey'));
		$main_smarty->assign('captcha_privkey', get_misc_data('adcopy_privkey'));
		$main_smarty->assign('captcha_hashkey', get_misc_data('adcopy_hashkey'));
		$main_smarty->assign('captcha_theme', get_misc_data('adcopy_theme'));
		$main_smarty->assign('captcha_lang', get_misc_data('adcopy_lang'));
	}

	function captcha_can_we_use(){
		global $main_smarty;

		$pubkey = get_misc_data('adcopy_pubkey');
		$privkey = get_misc_data('adcopy_privkey');
		$hashkey = get_misc_data('adcopy_hashkey');

		if($pubkey == '' || $privkey == '' || $hashkey == ''){
			$main_smarty->assign('msg', 'SolveMedia needs to be configured before it can be used.');
			return false;
		} else {
			return true;
		}
	}
?>
