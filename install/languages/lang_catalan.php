<?php
// header
	$lang['installer'] = 'instal · lador';
	$lang['Welcome'] = 'Benvinguda';
	$lang['Install'] = 'Instal · lar';
	$lang['Upgrade'] = 'Millorar';
	$lang['Troubleshooter'] = 'Solucionador de problemes';
	$lang['Step'] = 'Pas';
	$lang['Readme'] = 'Llegiu-me';
	$lang['Admin'] = 'Administració';
	$lang['Home'] = 'Pàgina d\'inici';
	$lang['Install_instruct'] = 'Tingueu seva informació de MySQL pràctic. Veure Upgrade per actualitzar un lloc existent.';
	$lang['Upgrade_instruct'] = 'Actualitzar farà modificacions a la base de dades MySQL. Assegureu-vos de fer còpies de seguretat abans de continuar.';
	$lang['Troubleshooter_instruct'] = 'El solucionador de problemes detecta problemes comuns, com ara permisos de carpeta incorrectes';

// intro / step 1
	$lang['WelcomeToInstaller'] = 'Benvingut a la CMS instal Pligg!';
	$lang['Introduction'] = 'Introducció';
	$lang['WelcomeToThe'] = 'Benvingut a Pligg Content Management System, CMS que milers de llocs web de la comunitat. Si aquesta és la primera vegada que la instal · lació de Pligg, llegiu totes les instruccions amb cura perquè no es perdi cap adreces importants. En nom dels desenvolupadors Pligg, m\'agradaria desitjar a vostè i el seu nou lloc web de la millor de les sorts.';
	$lang['Bugs'] = 'Si us plau, familiaritzar-se amb alguns de la documentació aportada per la comunitat Pligg al <a href="http://pligg.com/support/">Pligg Support</a> lloc web. També suggerim que es registri un compte perquè vostè tindrà accés a suport tècnic gratuït, mòduls, widgets, plantilles i altres grans recursos.';
	$lang['Installation'] = 'instal · lació';
	$lang['OnceFamiliar'] = '<p>Si aquesta és la primera vegada que la instal · lació de Pligg ha de continuar en aquesta pàgina després de seguir acuradament les instruccions de sota. Si necessita <a href="./upgrade.php">actualitzar el seu lloc</a> d\'una versió anterior, executeu l\'script d\'actualització, feu clic a l\'enllaç d\'actualització anterior. ADVERTÈNCIA: executar el procés d\'instal · lació d\'una base de dades del lloc Pligg existent sobreescriurà totes les històries i configuracions, així que si us plau assegureu-vos que vol dur a terme una instal · lació si decideix continuar endavant.
	<ol>
		<li>Canvieu el nom del fitxer settings.php.default a settings.php</li>
		<li>Canvieu el nom del fitxer /languages/lang_english.conf.default a lang_english.conf</li>
		<li>Canvieu el nom del fitxer /languages/lang_catalan.conf.default a lang_catalan.conf</li>
		<li>Canvieu el nom del fitxer /libs/dbconnect.php.default a dbconnect.php</li>
		<li>Canvieu el nom del directori /logs.default a /logs</li>
		<li>CHMOD 0777 les següents carpetes:</li>
		<ol>
			<li>/admin/backup/</li>
			<li>/avatars/groups_uploaded/</li>
			<li>/avatars/user_uploaded/</li>
			<li>/cache/</li>
			<li>/languages/ (CHMOD 0777 tots els arxius continguts en aquesta carpeta)</li>
		</ol>
		<li>CHMOD 0666 els següents arxius</li>
		<ol>
			<li>/libs/dbconnect.php</li>
			<li>settings.php</li>
		</ol>
	</ol>
	Ara està més enllà de la part més difícil! Continueu amb el següent pas per instal · lar Pligg a la base de dades MySQL </p>';

	// step 2
	$lang['EnterMySQL'] = 'Introduïu la configuració de bases de dades MySQL a continuació. Si vostè no ho sap la configuració de bases de dades MySQL ha de consultar la documentació del seu servei de hosting o poseu-vos en contacte amb ells directament.';
	$lang['DatabaseName'] = 'Nom de la base';
	$lang['DatabaseUsername'] = 'Base de dades Nom d\'usuari';
	$lang['DatabasePassword'] = 'Base de dades Contrasenya';
	$lang['DatabaseServer'] = 'Servidor de base de dades';
	$lang['TablePrefix'] = 'Prefix de taula de base de dades';
	$lang['PrefixExample'] = '(ie: "pligg_" fa que les taules per als usuaris pligg_users)';
	$lang['CheckSettings'] = 'Comproveu la configuració';
	$lang['Errors'] = 'Si us plau corregiu l\'error anterior(s), a continuació, actualitzeu la pàgina';
	$lang['LangNotFound'] = 'no s\'ha trobat. Si us plau, elimini l\'extensió. Defecte de tots els fitxers d\'idioma i torneu a intentar.';

// step 3
	$lang['ConnectionEstab'] = 'Connexió de base de dades establerta...';
	$lang['FoundDb'] = 'Base de dades es troben...';
	$lang['dbconnect'] = '\'/libs/dbconnect.php\' actualitzat correctament.';
	$lang['NoErrors'] = 'No hi va haver errors, continueu amb el pas ...';
	$lang['Next'] = 'Següent pas';
	$lang['GoBack'] = 'Torna i prova de nou';
	$lang['Error2-1'] = 'No s\'ha pogut escriure al /libs/dbconnect.php file.';
	$lang['Error2-2'] = 'No s\'ha pogut obrir /libs/dbconnect.php arxiu per escriptura.';
	$lang['Error2-3'] = 'Connectat a la base de dades, però el nom de base de dades és incorrecta.';
	$lang['Error2-4'] = 'No es pot connectar amb el servidor de base de dades amb la informació facilitada.';

// step 4
	$lang['CreatingTables'] = 'Creació de taules de bases de dades';
	$lang['TablesGood'] = '<strong>Taules s\'han creat correctament!</strong>';
	$lang['Error3-1'] = '<p>Hi va haver un problema en crear les taules.</p>';
	$lang['Error3-2'] = '<p>No s\'ha pogut connectar a la base de dades.</p>';
	$lang['EnterAdmin'] = '<p><strong>Introdueixi els detalls del compte d\'administrador a continuació:</strong><br />Si us plau, escriviu aquesta informació de compte, ja que serà necessària per iniciar sessió i configurar el seu lloc.</p>';
	$lang['AdminLogin'] = 'Administrador Nom d\'usuari';
	$lang['AdminPassword'] = 'Contrasenya d\'administrador';
	$lang['ConfirmPassword'] = 'Confirmar contrasenya';
	$lang['AdminEmail'] = 'Administrador de Correu';
	$lang['SiteTitleLabel'] = 'Nom del lloc web';
	$lang['CreateAdmin'] = 'Crear Compte d\'administrador';

// Step 5
	$lang['Error5-1'] = 'Ompli tots els camps per al compte d\'administrador.';
	$lang['Error5-2'] = 'Els camps de contrasenya no coincideixen. Si us plau, tornar enrere i tornar a entrar als camps de contrasenya.';
	$lang['AddingAdmin'] = 'Addició del compte d\'usuari Administrador...';
	$lang['InstallSuccess'] = 'Instal · lació completa!';
	$lang['InstallSuccessMessage'] = 'Felicitacions, vostè ha creat un lloc web Pligg CMS! Mentre que el seu lloc està en ple funcionament en aquest punt, haurà de fer una mica de neteja, seguint les instruccions següents per protegir el seu lloc.';
	$lang['WhatToDo'] = 'Què fer a continuació:';
	$lang['WhatToDoList'] = '		<li><p>chmod "/libs/dbconnect.php" de nou a 644, que no es necessita canviar el fitxer de nou.</p></li>
		<li><p><strong>Elimineu</strong> el "/ install" directori del servidor si teniu instal · lat Pligg.</p></li>
		<li><p>Entra en <a href="../admin/admin_index.php"> àrea d\'administració </a> utilitzant la informació d\'usuari que va introduir en el pas anterior. Una vegada que entreu s\'us amb més informació sobre com utilitzar Pligg.</p></li>
		<li><p><a href="../admin/admin_config.php">Configureu el vostre lloc web </a> amb l\'àrea d\'administració.</p></li>
		<li><p>Visiteu el <a href="http://pligg.com/"> Pligg Support </a> lloc web si té alguna pregunta.</p></li>';
	$lang['ContinueToSite'] = 'Continueu el seu nou lloc web';
// Upgrade
	$lang['UpgradeHome'] = 'En fer clic al botó de sota, Pligg actualitzarà la seva base de dades a l\'última versió. També afegirà noves frases afegint les darreres incorporacions a la part inferior del seu arxiu d\'idioma. Vostè encara haurà de carregar els nous arxius i actualitzar manualment les plantilles per ser totalment compatible amb l\'última versió.</p> Li recomanem que faci una còpia del seu lloc web i la base de dades en l\'equip local abans de continuar, perquè el procés d\'actualització farà canvis permanents a la base de dades MySQL.';
	$lang['UpgradeAreYouSure'] = 'Esteu segur que voleu actualitzar la seva base de dades i arxiu d\'idioma?';
	$lang['UpgradeYes'] = 'Procedir amb l\'actualització';
	$lang['UpgradeLanguage'] = 'Èxit, Pligg actualitza el seu arxiu d\'idioma. Ara inclou els últims elements del llenguatge.';
	$lang['UpgradingTables'] = '<strong>Actualització de base de dades...</strong>';
	$lang['LanguageUpdate'] = '<strong>Actualització de l\'arxiu Idioma...</strong>';
	$lang['IfNoError'] = 'Si no hi ha errors que es mostren, l\'actualització s\'ha completat!';
	$lang['PleaseFix'] = 'Si us plau corregiu l\'error anterior (s), actualitzar detingut!';
	
// Errors
	$lang['NotFound'] = 'no s\'ha trobat!';
	$lang['CacheNotFound'] = 'no s\'ha trobat! Creeu un directori anomenat /cache al directori arrel i posar-lo a CHMOD 777.';
	$lang['DbconnectNotFound'] = 'no s\'ha trobat! Intenta canviar el nom a dbconnect.php.default dbconnect.php';
	$lang['SettingsNotFound'] = 'no s\'ha trobat! Intenta canviar el nom a settings.php.default settings.php';
	$lang['ZeroBytes'] = 'és 0 bytes.';
	$lang['NotEditable'] = 'no es pot escriure. Si us plau, CHMOD a 777';
	
?>