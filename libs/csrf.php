<?php

if(!defined('mnminclude')){header('Location: ../404error.php');die();}

class CSRF {

	// options
	var $do_log = false;  // log to file
	var $do_debug = false;  // output debug info
	var $do_debug_only_if_user = ''; // debug output is visible only to user X. blank means everyone can see. usually set to 'god'

	// define other variables
	var $datalog = ''; // an array of all the log items

	function CSRF(){
		$this->start();
	}

	function start(){
		session_start();
		$this->log('Starting CSRF');
	}

	function create($name, $assign = false, $assign_extra = false){
		// token_admin_users_resetpass -- token_time_admin_users_resetpass
		$_SESSION['token_' . $name] = md5(uniqid(rand(), TRUE));
		$_SESSION['token_time_' . $name] = time();
		$this->log('Creating tokens for: ' . $name . ' -- Creation time: ' . $_SESSION['token_time_' . $name]);

		if($assign == true){
			$this->smarty($name);
		}

		if($assign_extra == true){
			$this->create_hidden_field($name, true);
			$this->create_uri($name, true);
		}
	}

	function get_value($name){
		$value = $_SESSION['token_' . $name];
		$this->log('Getting token value of: ' . $name . ' value: ' . $value);
		return $value;
	}

	function get_time($name){
		$value = $_SESSION['token_time_' . $name];
		$this->log('Getting token time of: ' . $name . ' value: ' . $value);
		return $value;
	}

	function smarty($name){
		// assign the token to a smarty variable
		global $main_smarty;
		$main_smarty->assign('token_' . $name, $this->get_value($name));
		$this->log('Assigning token to smarty: ' . $name);
	}

	function check_valid($token, $name){
		// see if the $token matches what the token was previously set to.
		if ($token == $_SESSION['token_' . $name]){
			$this->log('token: ' . $name . ' matches'); 
			return true;
		} else {
			$this->log('token: ' . $name . ' does not match: ' . $token); 
			return false;
		}
	}

	function check_expired($name, $time = 600){
		// check to see if time (seconds) has passed since the token was created.
		$token_age = time() - $this->get_time($name);
		if ($token_age >= $time) {
			// delete the tokens in session for this person
			unset($_SESSION['token_' . $name]);
			unset($_SESSION['token_time_' . $name]);
			$this->log('token: ' . $name . ' has expired -- token created: ' . $this->get_time($name) . ' -- token age: ' . $token_age); 
			return true;
		} else {
			$this->log('token: ' . $name . ' has not expired'); 
			return false;
		}
	}

	function log($action){
		// currently logging does nothing. a 'logging' class is being written for Pligg and this log function will call it.
		if($this->do_log == true){
			$this->datalog[] = $action;
		}
		if($this->do_debug == true){
			if($this->do_debug_only_if_user != ''){
				global $current_user;
				if($current_user->user_login == $this->do_debug_only_if_user) {
					echo $action . '<br />';
				}
			} else {
				echo $action . '<br />';
			}
		}
	}

	function create_hidden_field($name, $assign = false){
		// creates the HTML for a hidden text field with the token
		// assigns to smarty if $assign == true
		$field = '<input type="hidden" name="token" value="' . $this->get_value($name) . '">';
		$this->log('created hidden field for token: ' . $name); 
		if($assign == true){
			global $main_smarty;
			$main_smarty->assign('hidden_token_' . $name, $field);
			$this->log('Assigning to smarty hidden field for token: ' . $name . ' to ' . $field); 
		}
		return $field;
	}

	function create_uri($name, $assign = false){
		// creates the URL code for a token
		// ex: &token=tokenIDhere
		// and assigns to smarty if $assign == true
		$uri = '&token=' . $this->get_value($name);
		$this->log('created uri for token: ' . $name); 
		if($assign == true){
			global $main_smarty;
			$main_smarty->assign('uri_token_' . $name, $uri);
			$this->log('Assigning to smarty uri for token: ' . $name . ' to ' . $uri); 
		}
		return $uri;
	}

	function show_invalid_error($steps_back){
		echo 'Invalid token (hack attempt) or timeout. Go <a href = "javascript: history.go(-' . $steps_back . ')">back</a>, refresh that page, and try again.';
	}
}
?>
