<!-- backup_main_center.tpl -->
{if $isAdmin eq 1}
	{php}
	$canIhaveAccess = 0;
	$canIhaveAccess = $canIhaveAccess + checklevel('admin');
	if($canIhaveAccess == 1) {
		if($_REQUEST['dobackup'] == "files"){
			include ('../libs/backup/file_backup/backup.php');
			$FileBackup = new FileBackup;
			$FileBackup->MakeBackup();
			//echo "<HR>";
			header("Location: admin_backup.php");
			die();
		}
		if($_REQUEST['dobackup'] == "avatars"){
			include ('../libs/backup/file_backup/backup.php');
			$FileBackup = new FileBackup;
			$FileBackup->MakeAvatarBackup();
			//echo "<HR>";
			header("Location: admin_backup.php");
			die();
		}
		if($_REQUEST['dobackup'] == "database"){
			require("../libs/backup/mysql_backup/backup.php");
		}
		if($_REQUEST['dobackup'] == "clearall"){
			// http://www.phpbbstyles.com/viewtopic.php?t=2278
			$files = array();  
			$dir = opendir('./backup'); 
			while(($file = readdir($dir)) !== false) {
				if($file !== '.' && $file !== '..' && !is_dir($file) && $file !== 'index.htm') {
					$files[] = $file;
				}
			}
			closedir($dir);
			sort($files);
			for($i=0; $i<count($files); $i++) {
				unlink('./backup/'.$files[$i]);
			}
			header("Location: admin_backup.php");
			die();
		}
		// Output the data
		echo "<legend>";{/php}{#PLIGG_Visual_AdminPanel_Backup#}{php}echo "</legend>";
		// Check to see if you have permission to write backup files to the /admin/backup directory.
		$backup_permissions = substr(sprintf('%o', fileperms('./backup')), -4);
		if ($backup_permissions !== '0777'){
			echo "<div class='alert'>Your /admin/backup/ directory does not have the correct CHMOD permissions to write backup files.<br />Please change the CHMOD status from ".$backup_permissions." to 0777.</div>";
		} else {
			echo '<h3>';{/php}{#PLIGG_Visual_View_Backup#}{php}echo':</h3><img src="'.my_pligg_base.'/templates/admin/images/backup_files.gif" align="absmiddle" /> <a href = "?dobackup=files">';{/php}{#PLIGG_Visual_View_Backup_Files#}{php} echo'</a><br>';
			echo '<img src="'.my_pligg_base.'/templates/admin/images/backup_avatars.gif" align="absmiddle" /> <a href = "?dobackup=avatars">';{/php}{#PLIGG_Visual_View_Backup_Avatars#}{php}echo'</a><br>';
			echo '<img src="'.my_pligg_base.'/templates/admin/images/backup_db.gif" align="absmiddle" /> <a href = "?dobackup=database">';{/php}{#PLIGG_Visual_View_Backup_Database#}{php}echo'</a><br><br>';
			echo "<h3>";{/php}{#PLIGG_Visual_View_Backup_Previous#}{php}echo"</h3>";
			// http://www.phpbbstyles.com/viewtopic.php?t=2278
			$files = array();
			$dir = opendir('./backup');
			while(($file = readdir($dir)) !== false) {
				if($file !== '.' && $file !== '..' && !is_dir($file) && $file !== 'index.htm') {
					$files[] = $file;  
				}
			}
			closedir($dir);  
			sort($files);  
			if (count($files) != '0'){
				echo '<img src="'.my_pligg_base.'/templates/admin/images/backup_remove.gif" align="absmiddle" /> <a href = "?dobackup=clearall">';{/php}{#PLIGG_Visual_View_Backup_Remove#}{php}echo'</a><br>';
				echo '<br /><ul style="margin-left:18px;">';
				for($i=0; $i<count($files); $i++) {
					echo '<li><a href = "./backup/' . $files[$i] . '">' . $files[$i] . '</a></li>';  
				}
				echo '</ul>';
			}
		}
	} else {
		echo "Access denied";
	}
	{/php}
{else}
	{#PLIGG_Visual_Header_AdminPanel_NoAccess#}
{/if}
<!--/backup_main_center.tpl -->