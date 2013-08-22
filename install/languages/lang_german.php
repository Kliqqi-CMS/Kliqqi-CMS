<?php
// header
	$lang['installer'] = 'Installer';
	$lang['Welcome'] = 'willkommen';
	$lang['Install'] = 'Installieren';
	$lang['Upgrade'] = 'aktualisieren';
	$lang['Troubleshooter'] = 'Störungssucher';
	$lang['Step'] = 'Schritt';
	$lang['Readme'] = 'Readme';
	$lang['Admin'] = 'Admin';
	$lang['Home'] = 'Zuhause';
	$lang['Install_instruct'] = 'Bitte halten Sie Ihre MySQL Informationen griffbereit. Siehe Upgrade auf eine bestehende Website zu aktualisieren.';
	$lang['Upgrade_instruct'] = 'Upgrade wird Änderungen an Ihrer MySQL-Datenbank zu machen. Achten Sie darauf, bevor Sie fortfahren sichern.';
	$lang['Troubleshooter_instruct'] = 'Der Troubleshooter wird häufig auftretende Probleme wie falsche Ordnerberechtigungen erkennen';

// intro / step 1
	$lang['WelcomeToInstaller'] = 'Willkommen in der Pligg CMS Installer!';
	$lang['Introduction'] = 'Einführung';
	$lang['WelcomeToThe'] = 'Willkommen bei <a href="http://pligg.com" target="_blank">Pligg Content Management System</a>, der CMS, die Befugnisse Tausende von Community-Websites. Wenn dies Ihr erster Zeit mit der Installation Pligg, lesen Sie bitte alle den bereitgestellten Anweisungen sorgfältig, so dass Sie don\'t miss alle wichtigen Richtungen. Im Namen der Pligg Entwickler, würde Ich mag zu wünschen Ihnen und Ihrer neuen Webseite viel Glück.';
	$lang['Bugs'] = 'Bitte machen Sie sich mit einigen der Unterlagen durch das Pligg Gemeinschaft an den vorgesehenen <a href="http://pligg.com/support/">Pligg Support</a> website. Wir schlagen auch vor, dass Sie ein Konto registrieren, so dass Sie Zugriff auf kostenlosen Support, Module, Widgets, Vorlagen und andere große Ressourcen haben wird. Wenn Sie irgendwelche Fehler, oder wenn Sie wollen einfach nur ein neues Feature vorschlagen entdecken, bitte senden Sie Ihr Feedback zu unseren ganz eigenen<a href="http://pligg.com/demo/">Pligg Demo website</a>.';
	$lang['Installation'] = 'Installation (bitte sorgfältig gelesen)';
	$lang['OnceFamiliar'] = '<p>Wenn dies Ihr erster Zeit mit der Installation Pligg sollten Sie auf dieser Seite nach sorgfältig nach den Anweisungen unten fort. Wenn Sie <a href="./upgrade.php">Rüsten Sie Ihre Website</a> von einer früheren Version, führen Sie das Upgrade-Skript, indem Sie auf den Upgrade-Link oben. ACHTUNG: läuft die Installation auf einer vorhandenen Website Pligg Datenbank werden alle Geschichten und Einstellungen zu überschreiben, so stellen Sie bitte sicher, dass Sie eine Installation durchführen, wenn Sie unten weiter wählen möchten.
	<ol>
		<li>Benennen settings.php.default to settings.php</li>
		<li>Benennen /languages/lang_english.conf.default to lang_english.conf</li>
		<li>Benennen /libs/dbconnect.php.default to dbconnect.php</li>
		<li>Benennen the directory /logs.default to /logs</li>
		<li>CHMOD 0777 die folgenden Ordner:</li>
		<ol>
			<li>/admin/backup/</li>
			<li>/avatars/groups_uploaded/</li>
			<li>/avatars/user_uploaded/</li>
			<li>/cache/</li>
			<li>/languages/ (CHMOD 0777 alle Dateien in diesem Ordner enthaltenen)</li>
		</ol>
		<li>CHMOD 0666 die folgenden Dateien</li>
		<ol>
			<li>/libs/dbconnect.php</li>
			<li>settings.php</li>
		</ol>
	</ol>
	Sie sind jetzt an der schwierigste Teil! Fahren Sie mit dem nächsten Schritt Pligg auf Ihre MySQL-Datenbank installieren.</p>';

// step 2
	$lang['EnterMySQL'] = 'Geben Sie Ihre MySQL-Datenbank-Einstellungen unten. Wenn Sie don\'t wissen, dass Ihr MySQL-Datenbank-Einstellungen sollten Sie Ihre Webhost Dokumentation oder wenden Sie sich direkt.';
	$lang['DatabaseName'] = 'Datenbank-Name';
	$lang['DatabaseUsername'] = 'Database Benutzername';
	$lang['DatabasePassword'] = 'Database Password';
	$lang['DatabaseServer'] = 'Database Server';
	$lang['TablePrefix'] = 'Table Prefix';
	$lang['PrefixExample'] = '(ie: "pligg_" makes the tables for users become pligg_users)';
	$lang['CheckSettings'] = 'Einstellungen überprüfen';
	$lang['Errors'] = 'Bitte korrigieren Sie die obige Fehlermeldung (en), then <a class="btn btn-default btn-xs" onClick="document.location.reload(true)">Aktualisieren Sie die Seite</a>';
	$lang['LangNotFound'] = 'wurde nicht gefunden. Bitte entfernen Sie die. Standardmäßig Erweiterung aus allen Sprachdateien und versuchen Sie es erneut.';

// step 3
	$lang['ConnectionEstab'] = 'Database-Verbindung aufgebaut...';
	$lang['FoundDb'] = 'gefunden Datenbank...';
	$lang['dbconnect'] = '\'/libs/dbconnect.php\' wurde erfolgreich aktualisiert.';
	$lang['NoErrors'] = 'Es gab keine Fehler, auf dem nächsten Schritt fort...';
	$lang['Next'] = 'Next Step';
	$lang['GoBack'] = 'Zurück und erneut versuchen';
	$lang['Error2-1'] = 'Konnte nicht zu schreiben \'libs/dbconnect.php\' file.';
	$lang['Error2-2'] = 'Konnte nicht geöffnet werden \'/libs/dbconnect.php\' file for writing.';
	$lang['Error2-3'] = 'Verbunden mit der Datenbank, aber die Datenbank ist falsch.';
	$lang['Error2-4'] = 'Kann keine Verbindung zur Datenbank <b> Server verbinden </ b> mit der bereitgestellten Informationen.';

// step 4
	$lang['CreatingTables'] = 'Erstellen Datenbanktabellen';
	$lang['TablesGood'] = '<strong>Tische wurden erfolgreich erstellt!</strong>';
	$lang['Error3-1'] = '<p>Es gab ein Problem beim Erstellen der Tabellen.</p>';
	$lang['Error3-2'] = '<p>Konnte keine Verbindung zu Datenbank herstellen.</p>';
	$lang['EnterAdmin'] = '<p><strong>Geben Sie Ihren Administrator-Account Details unten:</strong><br />Bitte notieren Sie diese Kontoinformationen, weil es benötigt, um sich einzuloggen und konfigurieren Sie Ihre Website sein.</p>';
	$lang['AdminLogin'] = 'Admin Login';
	$lang['AdminPassword'] = 'Admin Password';
	$lang['ConfirmPassword'] = 'Passwort bestätigen';
	$lang['AdminEmail'] = 'Admin E-mail';
	$lang['SiteTitleLabel'] = 'Website Name';
	$lang['CreateAdmin'] = 'Create Admin Account';

// Step 5
	$lang['Error5-1'] = 'Bitte füllen Sie alle Felder für die Admin-Konto.';
	$lang['Error5-2'] = 'Passwort stimmen nicht überein. Bitte gehen Sie zurück und geben Sie die Passwort-Felder.';
	$lang['AddingAdmin'] = 'Hinzufügen des Admin Benutzerkonto...';
	$lang['InstallSuccess'] = 'Installation abgeschlossen!';
	$lang['InstallSuccessMessage'] = 'Glückwunsch, Sie haben eine Website eingerichtet Pligg CMS! Während Ihrer Website ist voll funktionsfähig an diesem Punkt, werden Sie wollen, um ein wenig aufräumen, indem Sie die nachstehenden Anweisungen, um Ihre Website zu sichern tun.';
	$lang['WhatToDo'] = 'Was als nächstes zu tun:';
	$lang['WhatToDoList'] = '		<li><p>chmod "/libs/dbconnect.php" back to 644, wir nicht brauchen, um dieses Bild wieder ändern.</p></li>
		<li><p><strong>DELETE</strong> the "/install" directory from your server if you have successfully installed Pligg.</p></li>
		<li><p>Login to the <a href="../admin/admin_index.php">admin area</a> mit dem Benutzer eingegebenen Informationen aus dem vorherigen Schritt. Sobald Sie in sollten Sie mit mehr Informationen darüber, wie Sie verwenden Pligg vorgestellt anmelden.</p></li>
		<li><p><a href="../admin/admin_config.php">Configure your site</a> using the admin area.</p></li>
		<li><p>Visit the <a href="http://pligg.com/">Pligg Support</a> website if you have any questions.</p></li>';
	$lang['ContinueToSite'] = 'Continue to Your New Website';
// Upgrade
	$lang['UpgradeHome'] = '<p>Durch einen Klick auf den untenstehenden Button, wird Pligg Ihre Datenbank auf die neueste Version aktualisieren. Es wird auch neue Sätze durch Anhängen der neuesten Ergänzungen der Unterseite Ihres Sprachdatei. Sie müssen noch die neuen Dateien hochladen und manuell aktualisieren Sie Ihre Vorlagen, um vollständig kompatibel mit der neuesten Version.</p> <p>We recommend that you back up your website and database to your local computer before proceeding because the upgrade process will make permanent changes to your MySQL database.';
	$lang['UpgradeAreYouSure'] = 'Sind Sie sicher, dass Sie Sie Datenbank-und Sprach-Datei aktualisieren möchten?';
	$lang['UpgradeYes'] = 'Fahren Sie mit dem Upgrade-';
	$lang['UpgradeLanguage'] = 'Erfolg, Pligg your language Datei aktualisiert. Es enthält nun die neuesten Produkte Sprache.';
	$lang['UpgradingTables'] = '<strong>Aktualisieren Datenbank...</strong>';
	$lang['LanguageUpdate'] = '<strong>Upgrading Language File...</strong>';
	$lang['IfNoError'] = 'Wenn es keine Fehler angezeigt wird, ist Upgrade abgeschlossen!';
	$lang['PleaseFix'] = 'gefallen fix the above error(s), upgrade halted!';
	
// Errors
	$lang['NotFound'] = 'wurde nicht gefunden!';
	$lang['CacheNotFound'] = 'wurde nicht gefunden! Create a directory called /cache in your root directory and set it to CHMOD 777.';
	$lang['DbconnectNotFound'] = 'wurde nicht gefunden! Try renaming dbconnect.php.default to dbconnect.php';
	$lang['SettingsNotFound'] = 'wurde nicht gefunden! Try renaming settings.php.default to settings.php';
	$lang['ZeroBytes'] = 'is 0 bytes.';
	$lang['NotEditable'] = 'ist nicht beschreibbar. gefallen CHMOD it to 777';
	
?>