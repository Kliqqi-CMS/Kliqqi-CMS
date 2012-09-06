<?php
//
// Connect to vbulletin database
// Tested 07/31/09
//
function vbulletin_connect()
{
	global $settings, $db, $vbulletin_db;

	if ($settings['user'])
	{
		$dbname = strpos($settings['db'],'.') > 0 ? substr($settings['db'],0,strpos($settings['db'],'.')) : $settings['db'];
	 	$db1 = new ezSQL_mysql($settings['user'], $settings['pass'], $dbname, $settings['host']);
		$db1->show_errors = false;
		return $db1;
	} 
 	elseif (@mysql_query("select * from {$settings['db']}user LIMIT 0,1"))
		return $db;
	else
		return null;
}

function vbulletin_disconnect($db)
{
	mysql_close($db->dbh);
	mysql_connect(EZSQL_DB_HOST,EZSQL_DB_USER,EZSQL_DB_PASSWORD);
	mysql_select_db(EZSQL_DB_NAME);
}

//
// Check for VB login 
// Tested 07/31/09
//
function vbulletin_all_pages_top()
{
	global $settings, $db, $vbulletin_db, $current_user, $main_smarty;

	$settings = get_vb_settings();

	// Read VB cookies
	$member_id = $password = '';
	foreach ($_COOKIE as $k => $v)
	    if ($k == $settings['prefix'].'userid')
		$member_id = sanitize($v,3);
	    elseif ($k == $settings['prefix'].'password')
		$password = sanitize($v,3);

	// If logged in to VB but not to Pligg
	if ($member_id && !$current_user->authenticated)
	{
		if (!($vbulletin_db = vbulletin_connect())) return;

		// Found VB user by userid/password hash
		if (($member = $vbulletin_db->get_row($sql="SELECT * FROM {$settings['db']}user WHERE userid='$member_id' AND MD5(CONCAT(password,'".mysql_real_escape_string($settings['hash'])."'))='$password'")) && 
		     vbulletin_login_to_pligg($member_id,$member->username,$member->email,$member->password))
		{
			$main_smarty->assign('user_logged_in', $current_user->user_login);
			$main_smarty->assign('user_authenticated', $current_user->authenticated);
			if($current_user->user_login){$main_smarty->assign('Current_User_Avatar_ImgSrc', get_avatar('small', "", "", "", $current_user->user_id));}
		}
		vbulletin_disconnect($vbulletin_db);
	}
	// If Pligg login form is being processed
	elseif( isset($_POST["processlogin"]) && $_POST["processlogin"]==1 )
	{
		$username = sanitize(trim($_POST['username']), 3);
		$password = sanitize(trim($_POST['password']), 3);

		$settings = get_vb_settings();
		if (!($vbulletin_db = vbulletin_connect())) return;

		// Found VB user by username/password
		if ($member = $vbulletin_db->get_row($sql = "SELECT * FROM {$settings['db']}user WHERE username='$username' AND MD5(CONCAT(MD5('$password'),salt))=password"))	
			vbulletin_login_to_pligg($member->userid,$member->username,$member->email,$password);
		vbulletin_disconnect($vbulletin_db);
	}
}

//
// Logout from both VB at same time
// Verified 07/31/09
//
function vbulletin_logout()
{
	global $db, $current_user;
	$domain = preg_replace('/^www/','',$_SERVER['HTTP_HOST']);
	if ($domain == 'localhost' || strpos($domain,'localhost:')===0) $domain='';
	foreach ($_COOKIE as $k => $v)
	    if (preg_match('/^bb/',$k))
	    {
		setcookie ($k, "", time()-3600, "/", ''); 
		setcookie ($k, "", time()-3600, "/", $domain); 

	    }
}

//
// Make a login to Pligg using VB credentials
// Tested 07/31/09
//
function vbulletin_login_to_pligg($user_id,$login,$email,$password='')
{
	global $settings, $db, $vbulletin_db, $current_user;

	if (!class_exists('User'))
	    require_once(mnminclude.'user.php');

	$u = $db->get_var($sql = "SELECT user_login FROM ".table_users." WHERE user_vbulletin=$user_id");	
	$user = new User();
	// If no user created yet for given VB login
	if (!$u)
	{
		if (!$password) $password = rand();

		// Create new pligg user here
		$user->username = $login;
		$user->pass = $password;
		$user->email = $email;
		if(!user_exists($login) && $user->Create())
		{
			$user->read('short');
			$db->query($sql="UPDATE ".table_users." SET user_vbulletin=$user_id, user_lastlogin=NOW() WHERE user_id={$user->id}");	
		
			$registration_details = array(
				'username' => $login,
				'password' => $password,
				'email' => $email,
				'id' => $user->id
			);
	
			check_actions('register_success_pre_redirect', $registration_details);
			return $current_user->Authenticate($login, $password, false);
		} 
		else
			return false;
	// use Pligg credentials to login
	} else {
		$user->username = $u;
		$user->read();
		
		if ($current_user->Authenticate($user->username, '', false, $user->pass))
		{
		    if ($password) {
			$user->pass = $password;
			$user->store();
		    }
		    return true;
		} else
			return false;
	}
}

// 
// Read module settings
//
function get_vb_settings()
{
    return array(
		'db' => get_misc_data('vbulletin_db'),
		'user' => get_misc_data('vbulletin_user'),
		'pass' => get_misc_data('vbulletin_pass'),
		'host' => get_misc_data('vbulletin_host'),
		'prefix' => get_misc_data('vbulletin_prefix'),
		'hash' => get_misc_data('vbulletin_hash'),
		);
}

//
// Settings page
//
function vbulletin_showpage(){
	global $db, $main_smarty, $the_template;
		
	include_once('config.php');
	include_once(mnminclude.'html1.php');
	include_once(mnminclude.'link.php');
	include_once(mnminclude.'tags.php');
	include_once(mnminclude.'smartyvariables.php');
	
	$main_smarty = do_sidebar($main_smarty);

	force_authentication();
	$canIhaveAccess = 0;
	$canIhaveAccess = $canIhaveAccess + checklevel('admin');
	
	if($canIhaveAccess == 1)
	{	
		if ($_POST['submit'])
		{
			misc_data_update('vbulletin_db', sanitize($_REQUEST['vbulletin_db'], 3));
			misc_data_update('vbulletin_user', sanitize($_REQUEST['vbulletin_user'], 3));
			misc_data_update('vbulletin_pass', sanitize($_REQUEST['vbulletin_pass'], 3));
			misc_data_update('vbulletin_host', sanitize($_REQUEST['vbulletin_host'], 3));
			misc_data_update('vbulletin_prefix', sanitize($_REQUEST['vbulletin_prefix'], 3));
			misc_data_update('vbulletin_hash', sanitize($_REQUEST['vbulletin_hash'], 3));
			header("Location: ".my_pligg_base."/module.php?module=vbulletin");
			die();
		}
		// breadcrumbs
		$main_smarty->assign('navbar_where', $navwhere);
		$main_smarty->assign('posttitle', " / " . $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel'));
		// breadcrumbs
		define('modulename', 'vbulletin'); 
		$main_smarty->assign('modulename', modulename);
		
		define('pagename', 'admin_modifyvbulletin'); 
		$main_smarty->assign('pagename', pagename);

		$main_smarty->assign('settings', get_vb_settings());
		$main_smarty->assign('tpl_center', vbulletin_tpl_path . 'vbulletin_main');
		$main_smarty->display($template_dir . '/admin/admin.tpl');
	}
	else
	{
		header("Location: " . getmyurl('login', $_SERVER['REQUEST_URI']));
	}
}	

?>
