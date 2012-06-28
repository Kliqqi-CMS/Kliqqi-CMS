<?php	
function welcome_email_send(&$registration_details)
{
	global $main_smarty, $current_user;
	
	include_once(mnminclude.'user.php');

	// Check User ID != 0
	if ($registration_details['id'] > 0)
	{		

		$username = $registration_details['username']; 
		$password = $registration_details['password']; 
		$email = $registration_details['email']; 
		$id = $registration_details['id'];

		$user = new User();
		$user->id = $id;
				
		// Check User Data
		if ($user->read())
		{
			include_once(mnmmodules . 'welcome_email/includes/htmlMimeMail.php');

			// Current Date/Time of Server
			$thisDate = date("M d, Y");
			$thisTime = date("H:i:s");
			
			// User Information
			$thisUserName = $username;
			$thisUserEmail = $email;
			
			// Pligg Information
			$siteName = $main_smarty->get_config_vars('PLIGG_Visual_Name'); 
			$siteEmail = $main_smarty->get_config_vars('PLIGG_PassEmail_From');
			
			$installedURL = my_base_url;
			$installedBase = my_pligg_base;
			
			// Email Subject
			$messageSubject = "Welcome to ".$siteName."!";
			
			// Email Message
			$messageText  = "Hello, ".$thisUserName.".\n\n";
			$messageText .= "Your account at ".$siteName." has been successfully set up.\n\n";
			$messageText .= "Please keep the below information for future reference:\n";
			$messageText .= "-----------------------------------------\n\n";		
			$messageText .= "  Login URL: ".$installedURL.$installedBase."/login.php\n\n";
			$messageText .= "  Username.: ".$thisUserName."\n";
			$messageText .= "  Password.: (password choosen when registered)\n\n";
			$messageText .= "-----------------------------------------\n";		
			$messageText .= "Email has been automatically generated on ".$thisDate." at ".$thisTime.".\n";
			
			// Setup Mail Class
			$mail = new htmlMimeMail();
			
			// Set Mail Body Text
			$mail->setText($messageText);
			
			// Set Mail From
			$mail->setFrom($siteName." <".$siteEmail.">");
			
			// Set Mail Subject
			$mail->setSubject($messageSubject);	
			
			// Send Mail
			$mail->send(array($thisUserEmail));
			
		} else {
			
			// Unable to find user data
			echo "Module Error #2";
			die;
			
			// To disable this error message and continue with registration,
			// remove the above ELSE statement this comment is within.
		}
	} else {
	
		// Unable to find User ID
		echo "Module Error #1";
		die;
	}
}
	
?>