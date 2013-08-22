<?php
// header
	$lang['installer'] = 'Installer';
	$lang['Welcome'] = 'Welcome';
	$lang['Install'] = 'Install';
	$lang['Upgrade'] = 'Upgrade';
	$lang['Troubleshooter'] = 'Troubleshooter';
	$lang['Step'] = 'Step';
	$lang['Readme'] = 'Readme';
	$lang['Admin'] = 'Admin';
	$lang['Home'] = 'Home';
	$lang['Install_instruct'] = 'Please have your MySQL information handy. See Upgrade to upgrade an existing site.';
	$lang['Upgrade_instruct'] = 'Upgrading will make modifications to your MySQL database. Be sure to backup before proceeding.';
	$lang['Troubleshooter_instruct'] = 'The Troubleshooter will detect common problems such as incorrect folder permissions';

// intro / step 1
	$lang['WelcomeToInstaller'] = 'Welcome to the Pligg CMS Installer!';
	$lang['Introduction'] = 'Introduction';
	$lang['WelcomeToThe'] = 'Welcome to <a href="http://pligg.com" target="_blank">Pligg</a>, the CMS that powers thousands of community websites. If this is your first time installing Pligg CMS, please read all of the provided instructions carefully so that you don\'t miss any important directions.';
	$lang['Bugs'] = 'Please familiarize yourself with some of the documentation provided by the Pligg community at the <a href="http://pligg.com/support/">Pligg Support</a> website. We also suggest that you register an account so that you will have access to free support, modules, widgets, templates and other great resources.';
	$lang['Installation'] = 'Installation (Please Read Carefully)';
	$lang['OnceFamiliar'] = '<p>If this is your first time installing Pligg you should continue on this page after carefully following the directions below. If you need to <a href="./upgrade.php">upgrade your site</a> from a previous version, please run the upgrade script by clicking on the Upgrade link above. WARNING: running the installation process on an existing Pligg site database will overwrite all stories and settings, so please make sure that you want to perform an installation if you choose to continue below.
	<ol>
		<li>Rename settings.php.default to settings.php</li>
		<li>Rename /languages/lang_english.conf.default to lang_english.conf</li>
		<li>Rename /libs/dbconnect.php.default to dbconnect.php</li>
		<li>Rename the directory /logs.default to /logs</li>
		<li>CHMOD 0777 the following folders:</li>
		<ol>
			<li>/admin/backup/</li>
			<li>/avatars/groups_uploaded/</li>
			<li>/avatars/user_uploaded/</li>
			<li>/cache/</li>
			<li>/languages/ (CHMOD 0777 all of the files contained within this folder)</li>
		</ol>
		<li>CHMOD 0666 the following files</li>
		<ol>
			<li>/libs/dbconnect.php</li>
			<li>settings.php</li>
		</ol>
	</ol>
	You\'re now past the hardest part! Proceed to the next step to install Pligg onto your MySQL database.</p>';

// step 2
	$lang['EnterMySQL'] = 'Enter your MySQL database settings below. If you don\'t know your MySQL database settings you should check your webhost documentation or contact them directly.';
	$lang['DatabaseName'] = 'Database Name';
	$lang['DatabaseUsername'] = 'Database Username';
	$lang['DatabasePassword'] = 'Database Password';
	$lang['DatabaseServer'] = 'Database Server';
	$lang['TablePrefix'] = 'Table Prefix';
	$lang['PrefixExample'] = '(ie: "pligg_" makes the tables for users become pligg_users)';
	$lang['CheckSettings'] = 'Check Settings';
	$lang['Errors'] = 'Please fix the above error(s), then <a class="btn btn-default btn-xs" onClick="document.location.reload(true)">Refresh the Page</a>';
	$lang['LangNotFound'] = 'was not found. Please remove the .default extension from all language files and try again.';

// step 3
	$lang['ConnectionEstab'] = 'Database connection established...';
	$lang['FoundDb'] = 'Found database...';
	$lang['dbconnect'] = '\'/libs/dbconnect.php\' was updated successfully.';
	$lang['NoErrors'] = 'There were no errors, continue onto the next step...';
	$lang['Next'] = 'Next Step';
	$lang['GoBack'] = 'Go Back and Try Again';
	$lang['Error2-1'] = 'Could not write to \'libs/dbconnect.php\' file.';
	$lang['Error2-2'] = 'Could not open \'/libs/dbconnect.php\' file for writing.';
	$lang['Error2-3'] = 'Connected to the database, but the database name is incorrect.';
	$lang['Error2-4'] = 'Cannot connect to the database server using the information provided.';

// step 4
	$lang['CreatingTables'] = 'Creating database tables';
	$lang['TablesGood'] = '<strong>Tables were created successfully!</strong>';
	$lang['Error3-1'] = '<p>There was a problem creating the tables.</p>';
	$lang['Error3-2'] = '<p>Could not connect to database.</p>';
	$lang['EnterAdmin'] = '<p><strong>Enter your admin account details below:</strong><br />Please write down this account information because it will be needed to log in and configure your site.</p>';
	$lang['AdminLogin'] = 'Admin Login';
	$lang['AdminPassword'] = 'Admin Password';
	$lang['ConfirmPassword'] = 'Confirm Password';
	$lang['AdminEmail'] = 'Admin E-mail';
	$lang['SiteTitleLabel'] = 'Website Name';
	$lang['CreateAdmin'] = 'Create Admin Account';

// Step 5
	$lang['Error5-1'] = 'Please fill all fields for admin account.';
	$lang['Error5-2'] = 'Password fields do not match. Please go back and re-enter the password fields.';
	$lang['AddingAdmin'] = 'Adding the Admin user account...';
	$lang['InstallSuccess'] = 'Installation Complete!';
	$lang['InstallSuccessMessage'] = 'Congratulations, you have set up a Pligg CMS website! While your site is fully functional at this point, you will want to do a little cleaning up by following the directions below to secure your site.';
	$lang['WhatToDo'] = 'What to do next:';
	$lang['WhatToDoList'] = '		<li>chmod "/libs/dbconnect.php" back to 644, we will not need to change this file again.</li>
		<li><strong>DELETE</strong> the "/install" directory from your server if you have successfully installed Pligg.</li>
		<li>Login to the <a href="../admin/admin_index.php">admin area</a> using the user information you entered from the previous step. Once you log in you should be presented with more information about how to use Pligg.</li>
		<li><a href="../admin/admin_config.php">Configure your site</a> using the admin area.</li>
		<li>Visit the <a href="http://pligg.com/support/">Pligg Support</a> website if you have any questions.</li>';
	$lang['ContinueToSite'] = 'Continue to Your New Website';
	
// Upgrade
	$lang['UpgradeHome'] = '<p>By clicking on the button below, Pligg will upgrade your database to the latest version. It will also add new phrases by appending the latest additions to the bottom of your language file. You will still need to upload the new files and manually update your templates to be fully compatable with the latest version.</p> <p>We recommend that you back up your website and database to your local computer before proceeding because the upgrade process will make permanent changes to your MySQL database.';
	$lang['UpgradeAreYouSure'] = 'Are you sure that you want to upgrade your database and language file?';
	$lang['UpgradeYes'] = 'Proceed with Upgrade';
	$lang['UpgradeLanguage'] = 'Success, Pligg updated your language file. It now includes the latest language items.';
	$lang['UpgradingTables'] = '<strong>Upgrading Database...</strong>';
	$lang['LanguageUpdate'] = '<strong>Upgrading Language File...</strong>';
	$lang['IfNoError'] = 'If there were no errors displayed, upgrade is complete!';
	$lang['PleaseFix'] = 'Please fix the above error(s), upgrade halted!';
	
// Errors
	$lang['NotFound'] = 'was not found!';
	$lang['CacheNotFound'] = 'was not found! Create a directory called /cache in your root directory and set it to CHMOD 777.';
	$lang['DbconnectNotFound'] = 'was not found! Try renaming dbconnect.php.default to dbconnect.php';
	$lang['SettingsNotFound'] = 'was not found! Try renaming settings.php.default to settings.php';
	$lang['ZeroBytes'] = 'is 0 bytes.';
	$lang['NotEditable'] = 'is not writable. Please CHMOD it to 777';
	
?>