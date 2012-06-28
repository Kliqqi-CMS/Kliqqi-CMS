<?php
function hc_register(&$vars){
		global $main_smarty, $the_template, $hc_registered;

		if ($hc_registered) return;
		$hc_registered = true;

		if(!isset($_SESSION)){session_start();}
		$_SESSION['hc_math_answer'] == '';
	
		$q_1_low = (get_misc_data('hc_math_q1low') == '') ? 1 : get_misc_data('hc_math_q1low');
		$q_1_high = (get_misc_data('hc_math_q1high') == '') ? 5 : get_misc_data('hc_math_q1high');
		$q_2_low = (get_misc_data('hc_math_q2low') == '') ? 1 : get_misc_data('hc_math_q2low');
		$q_2_high = (get_misc_data('hc_math_q2high') == '') ? 5 : get_misc_data('hc_math_q2high');

		$number1 = md5(mt_rand($q_1_low, $q_1_high));
		do {		
			$number2 = md5(mt_rand($q_2_low, $q_2_high));
		} while ($number2==$number1);
		$number3 = md5(mt_rand($q_2_low, $q_2_high));

		$_SESSION['titlename'] = $number1;
		$_SESSION['bodyname']  = $number2;
		$_SESSION['commentname'] = $number3;
		$main_smarty->assign('name', $_SESSION['hc_math_answer_name']);

		// smarty prefilter
		$main_smarty->register_prefilter('add_header_comment');
}

// prefilter routine
function add_header_comment($tpl_source, &$smarty)
{

	return str_replace(
		array('name="title"',
		      'name="comment_content"',
		      'name="bodytext"'),
		array('name="{$templatelite.session.titlename}"',
		      'name="{$templatelite.session.commentname}"',
		      'name="{$templatelite.session.bodyname}"'),
		$tpl_source);
}



function hc_register_check_errors(&$vars){
		global $main_smarty, $the_template, $hc_checked;
		if ($hc_checked) return;
		$hc_checked = true;

		$username = $vars['username'];
		$email = $vars['email'];
		$password = $vars['password'];

		$main_smarty->assign('username', $username);
		$main_smarty->assign('email', $email);
		$main_smarty->assign('password', $password);

		if(!isset($_SESSION)){session_start();}

		if ((!isset($_POST[$_SESSION['titlename']]) || !isset($_POST[$_SESSION['bodyname']])) && !isset($_POST[$_SESSION['commentname']]))
		{
			$main_smarty->assign('register_hc_error', "Human Check error. Please try again.");
			$vars['error'] = true;
		} else {
			$_POST['title'] = $_POST[$_SESSION['titlename']];
			$_POST['bodytext'] = $_POST[$_SESSION['bodyname']];
			$_POST['comment_content'] = $_POST[$_SESSION['commentname']];
		}
		return true;
}
?>
