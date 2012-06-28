<?php

	function users_extra_fields_story_top(){
		global $main_smarty, $current_user, $users_extra_fields_field, $link;
		include_once(mnminclude.'user.php');

		$user=new User();
		$user->username = $link->username();
		if(!$user->read()) {
			echo "error 2";
			die;
		}

		if ($users_extra_fields_field) {
			foreach($users_extra_fields_field as $z => $thefield) {
				foreach($thefield as $x => $y) {
					$users_extra_fields_field[$z]['value'] = $user->extra_field[$thefield['name']];
					$main_smarty->assign($thefield['name'], $user->extra_field[$thefield['name']]);
				}
			}
		}
		$main_smarty->assign('users_extra_fields_field', $users_extra_fields_field);
		$main_smarty->assign('users_extra_fields_submitter', $link->username);
	}
		
	
	
	function users_extra_fields_admin_users_save(){
		global $userdata, $users_extra_fields_field;

		if ($users_extra_fields_field) {
			foreach($users_extra_fields_field as $thefield) {
				foreach($thefield as $x => $y) {
					$userdata->extra[$thefield['name']]=$_REQUEST[$thefield['name']];	
				}
			}
		}
	}

	function users_extra_fields_admin_users_view(){
		global $main_smarty, $user, $users_extra_fields_field;
		if ($users_extra_fields_field) {
			foreach($users_extra_fields_field as $z => $thefield) {
				foreach($thefield as $x => $y) {
					$users_extra_fields_field[$z]['value'] = $user->extra_field[$thefield['name']];
					$main_smarty->assign($thefield['name'], $user->extra_field[$thefield['name']]);
				}
			}
		}
		$main_smarty->assign('users_extra_fields_field', $users_extra_fields_field);
	}

	function users_extra_fields_admin_users_edit(){
		global $main_smarty, $user, $users_extra_fields_field;
		if ($users_extra_fields_field) {
			foreach($users_extra_fields_field as $z => $thefield) {
				foreach($thefield as $x => $y) {
					$users_extra_fields_field[$z]['value'] = $user->extra_field[$thefield['name']];
					$main_smarty->assign($thefield['name'], $user->extra_field[$thefield['name']]);
				}
			}
		}
		$main_smarty->assign('users_extra_fields_field', $users_extra_fields_field);
	}
	
	
	function users_extra_fields_profile_save(){
		global $user, $users_extra_fields_field;

		if ($users_extra_fields_field) {
			foreach($users_extra_fields_field as $thefield) {
				foreach($thefield as $x => $y) {
					if($thefield['show_to_user'] == true){
						$user->extra[$thefield['name']]=sanitize($_POST[$thefield['name']]);	
					}
				}
			}
		}
	}

	function users_extra_fields_profile_show(){
		global $main_smarty, $user, $users_extra_fields_field;
		if ($users_extra_fields_field) {
			foreach($users_extra_fields_field as $z => $thefield) {
				foreach($thefield as $x => $y) {
					$users_extra_fields_field[$z]['value'] = $user->extra_field[$thefield['name']];
					$main_smarty->assign($thefield['name'], $user->extra_field[$thefield['name']]);
				}
			}
		}
		$main_smarty->assign('users_extra_fields_field', $users_extra_fields_field);
	}
?>