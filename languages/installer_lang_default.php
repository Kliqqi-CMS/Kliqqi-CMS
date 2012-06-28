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
	$lang['WelcomeToInstaller'] = 'Welcome to the Pligg Installer!';
	$lang['Introduction'] = 'Introduction';
	$lang['WelcomeToThe'] = 'Welcome to the <a href="http://www.pligg.com" target="_blank">Pligg Content Management System</a>. Before installing Pligg CMS please make sure that you have the latest version of Pligg by visiting <a href="http://www.pligg.com/download.php" target="_blank">the official Pligg Download Page</a>.';
	$lang['Bugs'] = 'While you are visiting the Pligg.com, please familiarize yourself with some of the documentation provided by the Pligg community. We also suggest that you register with the <a href="http://forums.pligg.com/" target="_blank">Pligg Forum</a>, where you will find free modules, templates and other great resources to enhance your website. If you discover any bugs or typos in Pligg, please <a href="http://forums.pligg.com/projects/pligg-cms/index.html" target="_blank">report it</a> through our bug report section so that we can fix it in a future release.';
	$lang['Installation'] = 'Installation (Please Read Carefully)';
	$lang['OnceFamiliar'] = '<p>If this is your first time installing Pligg you will continue on through this page after carefully following the directions below. If you need to <a href="./upgrade.php">upgrade your site</a> from a previous version, please run the upgrade script by clicking on the Upgrade tab above. WARNING: running the installation process on an existing Pligg site database will overwrite all stories and settings, so please make sure that you want to perform an install if you continue below.</p><br />
	<h4>1. Rename settings.php.default to settings.php</h4>
	<h4>2. Rename /libs/dbconnect.php.default to dbconnect.php</h4><br />
	<h4>3. CHMOD 755 the following folders, if they give you errors try 777.</h4>
	<ol>
	<li>/admin/backup/</li>
	<li>/avatars/groups_uploaded/</li>
	<li>/avatars/user_uploaded/</li>
	<li>/cache/</li>
	<li>/cache/admin_c/</li>
	<li>/cache/templates_c/</li>
	<li>/languages/ (And all of the files contained in this folder should be CHMOD 777)</li>
	</ol><br />
	<h4>4. CHMOD 666 the following files</h4>
	<ol>
	<li>/libs/dbconnect.php</li>
	<li>settings.php</li>
	</ol>
	<br />
	Once you have familiarized yourself with the basic concept and design of Pligg by reading through some of the Pligg forum posts, Proceed to the next step and install Pligg.';

// step 2
	$lang['EnterMySQL'] = 'Enter your MySQL database settings below. If you don\'t know your MySQL database settings you should check your webhost documentation or contact them directly.';
	$lang['DatabaseName'] = 'Database Name';
	$lang['DatabaseUsername'] = 'Database Username';
	$lang['DatabasePassword'] = 'Database Password';
	$lang['DatabaseServer'] = 'Database Server';
	$lang['TablePrefix'] = 'Table Prefix';
	$lang['PrefixExample'] = '(ie: "pligg_" makes the tables for users become pligg_users)';
	$lang['CheckSettings'] = 'Check Settings';
	$lang['Errors'] = 'Please fix the above error(s), install halted!';

// step 3
	$lang['ConnectionEstab'] = 'Database connection established...';
	$lang['FoundDb'] = 'Found database...';
	$lang['dbconnect'] = '\'/libs/dbconnect.php\' was updated successfully.';
	$lang['NoErrors'] = 'There were no errors, continue onto the next step...';
	$lang['Next'] = 'Next';
	$lang['GoBack'] = 'Go Back';
	$lang['Error2-1'] = 'Could not write to \'libs/dbconnect.php\' file.';
	$lang['Error2-2'] = 'Could not open \'/libs/dbconnect.php\' file for writing.';
	$lang['Error2-3'] = 'Connected to the database, but the database name is incorrect.';
	$lang['Error2-4'] = 'Cannot connect to the database <b>server</b> using the information provided.';

// step 4
	$lang['CreatingTables'] = '<p><strong>Creating database tables...</strong></p>';
	$lang['TablesGood'] = '<p><strong>Tables were created successfully!</strong></p><hr />';
	$lang['Error3-1'] = '<p>There was a problem creating the tables.</p>';
	$lang['Error3-2'] = '<p>Could not connect to database.</p>';
	$lang['EnterGod'] = '<p><strong>Enter your admin account details below:</strong><br />Please write down this account information because it will be needed to log in and configure your site.</p>';
	$lang['GodLogin'] = 'Admin Login';
	$lang['GodPassword'] = 'Admin Password';
	$lang['ConfirmPassword'] = 'Confirm Password';
	$lang['GodEmail'] = 'Admin E-mail';
	$lang['CreateAdmin'] = 'Create Admin Account';

// Step 5
	$lang['Error5-1'] = 'Please fill all fields for admin account.';
	$lang['Error5-2'] = 'Password fields do not match. Please go back and re-enter the password fields.';
	$lang['AddingAdmin'] = 'Adding the Admin user account...';
	$lang['InstallSuccess'] = '<a href="../">Your Pligg Site</a> appears to have installed successfully!';
	$lang['WhatToDo'] = 'What to do next:';
	$lang['WhatToDoList'] = '		<li><p>chmod "/libs/dbconnect.php" back to 644, we will not need to change this file again.</p></li>
		<li><p><strong>DELETE</strong> the "/install" directory from your server if you have successfully installed Pligg.</p></li>
		<li><p>Login to the <a href="../admin/admin_index.php">admin area</a> using the user information you entered from the previous step. Once you log in you should be presented with more information about how to use Pligg.</p></li>
		<li><p><a href="../admin/admin_config.php">Configure your site</a> using the admin area.</p></li>
		<li><p>Visit the <a href="http://forums.pligg.com/">Pligg Forums</a> if you have any questions, or just to tell us about your new site.</p></li>';

// Upgrade
	$lang['UpgradeHome'] = '<p>By clicking on the button below, Pligg will upgrade your database to the latest version. It will also add new phrases by appending the latest additions to the bottom of your language file. You will still need to upload the new files and manually update your templates to be fully compatable with the latest version.</p> <p>We recommend that you back up your website and database to your local computer before proceeding because the upgrade process will make permanent changes to your MySQL database.';
	$lang['UpgradeAreYouSure'] = 'Are you sure that you want to upgrade you database and language file?';
	$lang['UpgradeYes'] = 'Proceed with Upgrade';
	$lang['UpgradeLanguage'] = 'Success, Pligg updated your language file. It now includes the latest language items.';
	$lang['UpgradingTables'] = '<strong>Upgrading Database...</strong>';
	$lang['LanguageUpdate'] = '<strong>Upgrading Language File...</strong>';
	$lang['IfNoError'] = 'If there were no errors displayed, upgrade is complete!';
	$lang['PleaseFix'] = 'Please fix the above error(s), upgrade halted!';
	
// Errors
	$lang['NotFound'] = 'was not found!';
	$lang['TemplatesCNotFound'] = 'was not found! Create a directory called /templates_c in your /cache directory.';
	$lang['CacheNotFound'] = 'was not found! Create a directory called /cache in your root directory.';
	$lang['DbconnectNotFound'] = 'was not found! Try renaming dbconnect.php.default to dbconnect.php';
	$lang['SettingsNotFound'] = 'was not found! Try renaming settings.php.default to settings.php';
	$lang['ZeroBytes'] = 'is 0 bytes.';
	$lang['NotEditable'] = 'is not writable. Please CHMOD it to 777';
	
?>