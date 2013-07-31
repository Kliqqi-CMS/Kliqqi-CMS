<?php
// header
	$lang['installer'] = "Installer";
	$lang['Welcome'] = "Benvenuto";
	$lang['Install'] = "Installa";
	$lang['Upgrade'] = "Aggiorna";
	$lang['Troubleshooter'] = "Risoluzione dei problemi";
	$lang['Step'] = "Passaggio";
	$lang['Readme'] = "Readme";
	$lang['Admin'] = "Admin";
	$lang['Home'] = "Home";
	$lang['Install_instruct']  = "Si prega di avere a portata di mano i tuoi dati MySQL. Vedi aggiornamento per aggiornare un sito esistente.";
	$lang['Upgrade_instruct'] = "L'aggiornamento apportarà modifiche al vostro database MySQL. Effettuate un backup prima di procedere.";
	$lang['Troubleshooter_instruct'] = "La risoluzione dei problemi rileverà i problemi più comuni, come i permessi sbagliati delle directory";

// intro / step 1
	$lang['WelcomeToInstaller'] = "Benvenuto nell'installer di Pligg!";
	$lang['Introduction'] = "Introduzione";
	$lang['WelcomeToThe'] = "Benvenuto nel <a href='http://www.pligg.com' target='_blank'>Sistema di gestione dei contenuti Pligg</a>. Prima di installare il CMS Pligg rassicusati di aver scaricato l'ultima versione di Pligg visitando la <a href='http://www.pligg.com/download.php' target='_blank'>pagina ufficiale di download di Pligg</a>.";
	$lang['Bugs'] = "Mentre si sta visitando il sito Pligg.com, ti preghiamo di familiarizzare la documentazione fornita dalla comunità Pligg. Noi suggeriamo inoltre di registrarsi nel <a href='http://forums.pligg.com/' target='_blank'> Forum di Pligg </a>, dove potrete trovare moduli gratuiti, modelli e altre grandi risorse per migliorare il tuo sito web. Se si scopre un bug o errori di battitura in Pligg, <a href='http://forums.pligg.com/projects/pligg-cms/index.html' target='_blank'> fate il vostro report </a> attraverso il nostro sezione bug report in modo che possiamo risolvere il problema in una versione futura.";
	$lang['Installation'] = "Installazione (Leggete attentamente)";
	$lang['OnceFamiliar'] = "<p>Se questa è la prima volta che fate un'installazione del CMS Pligg potrai continuare in questa pagina, seguendo attentamente le istruzioni riportate di seguito. Se hai bisogno di <a href='./upgrade.php'> aggiornare il sito </a> da una versione precedente, eseguire lo script di aggiornamento facendo clic sulla scheda di aggiornamento qui sopra. ATTENZIONE: l'esecuzione del processo di installazione su un database esistente Pligg sovrascrive tutte le news e le impostazioni, in modo da assicurarsi che si desidera eseguire un'installazione se si continua di seguito. </P> <br />
	<ol>
		<li>Rinomina settings.php.default a settings.php</li>
		<li>Rinomina /languages/lang_english.conf.default a lang_english.conf</li>
		<li>Rinomina /languages/lang_italian.conf.default a lang_italian.conf</li>
		<li>Rinomina /libs/dbconnect.php.default a dbconnect.php</li>
		<li>Rinominare la directory /logs.default a /logs</li>
		<li>CHMOD 0777 le seguenti cartelle, se ti danno errori provare a 777. </li>
		<ol>
			<li>/admin/backup/</li>
			<li>/avatars/groups_uploaded/</li>
			<li>/avatars/user_uploaded/</li>
			<li>/cache/</li>
			<li>/languages/ (e tutti i file contenuti in questa cartella deve essere chmod 777) </li>
		</ol>
		<li>Chmod 666 i seguenti file</li>
		<ol>
			<li>/libs/dbconnect.php </li>
			<li>settings.php </li>
		</ol>
	</ol>
	Una volta che avete familiarizzato con il concetto di base e la progettazione di Pligg, leggendo alcuni dei messaggi del forum Pligg, passare alla fase successiva e installare Pligg.";

// step 2
	$lang['EnterMySQL'] = "Inserisci le tue impostazioni del database MySQL di seguito. Se non conosci le impostazioni del database MySQL consigliamo di verificare la documentazione di hosting o contattarlo direttamente.";
	$lang['DatabaseName'] = "Nome Database";
	$lang['DatabaseUsername'] = "Username del Database";
	$lang['DatabasePassword'] = "Password del Database";
	$lang['DatabaseServer'] = "Database Server";
	$lang['TablePrefix'] = "Table Prefix";
	$lang['PrefixExample'] = "(es: 'pligg_' le tabelle geli utentei inizieranno pligg_users)";
	$lang['CheckSettings'] = "Controlla le impostazioni";
	$lang['Errors'] = "Si prega di correggere gli errori sopra riportati, installazione interrotta!";
	$lang['LangNotFound'] = 'non è stato trovato. Si prega di rimuovere l\'estensione. Predefinita da tutti i file di lingua e riprovare.';

// step 3
	$lang['ConnectionEstab'] = "Connessione Database stabilita...";
	$lang['FoundDb'] = "Database trovato..";
	$lang['dbconnect'] = "'/libs/dbconnect.php' aggiornato correttamente.";
	$lang['NoErrors'] = "Non ci sono errori, continua al prossimo passaggio...";
	$lang['Next'] = "Prossimo";
	$lang['GoBack'] = "Torna indietro";
	$lang['Error2-1'] = "Non puoi scrivere in 'libs/dbconnect.php' file.";
	$lang['Error2-2'] = "Non puoi aprire '/libs/dbconnect.php' file for writing.";
	$lang['Error2-3'] = "Connesso al database, ma il nome del database non e' corretto.";
	$lang['Error2-4'] = "Non puoi connetterti al database usanto le informazioni fornite.";

// step 4
	$lang['CreatingTables'] = "<p><strong>Sta creando le tabele nel database...</strong></p>";
	$lang['TablesGood'] = "<p><strong>Le tabelle sono state create correttamente!</strong></p><hr />";
	$lang['Error3-1'] = "<p>Ci sono alcuni problemi nel creare la tabelle nel database.</p>";
	$lang['Error3-2'] = "<p>Non puoi connetterti al databse.</p>";
	$lang['EnterAdmin'] = "<p><strong>Inserisci l'email dell'Amministratore qui sotto:</strong><br />Si prega di scrivere queste informazioni account perché sarà necessario per accedere e configurare il vostro sito. </P>";
	$lang['AdminLogin'] = "Login Admin";
	$lang['AdminPassword'] = "Admin Password";
	$lang['ConfirmPassword'] = "Conferma Password";
	$lang['AdminEmail'] = "Admin E-mail";
	$lang['SiteTitleLabel'] = 'Nome Sito web';
	$lang['CreateAdmin'] = "Crea un Account dell'Amministratore";

// Step 5
	$lang['Error5-1'] = "Compila tutti i campi dell'account dell'Amministratore.";
	$lang['Error5-2'] = "I campi della password non corrispondono. Si prega di tornare indietro e re-inserire i campi password.";
	$lang['AddingAdmin'] = "Si sta aggiungendo l'account utente Admin...";
	$lang['InstallSuccess'] = "<a href='../'>Il tuo sito Pligg</a> sempre essere installato con successo!";
	$lang['InstallSuccessMessage'] = 'Complimenti, hai creato un sito web Pligg CMS! Mentre il sito è completamente funzionale, a questo punto, si vuole fare un po \'di pulizia seguendo le istruzioni riportate di seguito per proteggere il vostro sito.';
	$lang['WhatToDo'] = "Cosa fare:";
	$lang['WhatToDoList'] = "		<li><p>chmod \'/libs/dbconnect.php\' torna a 644, non avremo bisogno di modificare questo file. </p> </li>
<li> <strong> CANCELLA </strong> la directory \'/install\' dal server se avete installato con successo Pligg. </p> </li>
<li> Login al <a href=\'../admin/admin_index.php\'> area admin </a> utilizzando le informazioni utente potrete accede dal passo precedente. Una volta che si accede si dovrebbe presentare con ulteriori informazioni sulla modalità di utilizzo di Pligg. </P> </li>
<li> href=\'../admin/admin_config.php\'> Configura il tuo sito </a> utilizzando l\'area admin. </p> </li>
<li> Visita il <a href=\'http://pligg.com/\'> Pligg.com </a>, se avete domande, o semplicemente per raccontarci il vostro nuovo sito.</p></li>";

// Upgrade
	$lang['UpgradeHome'] = "Questo aggiornamento del database per Pligg versioni Beta 9.0.0 e superiori. Sarà anche l\'aggiornamento del file delle lingue per le versioni di cui sopra Pligg 1.0.0. Avrete comunque bisogno di caricare i nuovi file e aggiornare i modelli pienamente compatibili con la versione più recente. <br /> Si consiglia di eseguire un backup del sito web e database su un computer locale prima di procedere, perché nel processo di aggiornamento verranno apportate modifiche permanenti al vostro database MySQL.";
	$lang['UpgradeAreYouSure'] = "Sei sicuro di voler aggiornare il database e i file di lingua?";
	$lang['UpgradeYes'] = "Si";
	$lang['UpgradeLanguage'] = "Ottimo, Pligg ha aggiornato i suo file di lingua. Esso comprende ora la lingua Ultime notizie.";
	$lang['UpgradingTables'] = "<strong>Aggiornamento Database...</strong>";
	$lang['LanguageUpdate'] = "<strong>Aggiornamento dei File di lingua...</strong>";
	$lang['IfNoError'] = "Se non ci sono errori visualizzati, l''aggiornamento e' stato eseguito correttamente!";
	$lang['PleaseFix'] = "Si prega di correggere l'errore sopra indicato(i), l'aggiornamento bloccato!";
	
// Errors
	$lang['NotFound'] = "non trovato!";
	$lang['CacheNotFound'] = "non è stato trovato! Creare una directory chiamata / cache nella directory principale.";
	$lang['DbconnectNotFound'] = "non è stato trovato! Provare a rinominare dbconnect.php.default a dbconnect.php";
	$lang['SettingsNotFound'] = "non è stato trovato! Provare a rinominare settings.php.default a settings.php";
	$lang['ZeroBytes'] = "is 0 bytes.";
	$lang['NotEditable'] = "non è modificabile. Mettere il CHMOD a 777";
	
?>