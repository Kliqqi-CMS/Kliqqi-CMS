{checkActionsTpl location="tpl_admin_modules_top"}

{php}

global $db, $main_smarty;	

if(isset($_REQUEST['action'])){
	$action = sanitize($_REQUEST['action'],3);
}else{
	$action = 'main';
}
	
if($action == 'main' || $action == 'disable' || $action == 'enable'){


	echo '<h1><img src="'.my_pligg_base.'/templates/admin/images/manage_mods.gif" align="absmiddle"/> '.$main_smarty->get_config_vars('PLIGG_Visual_AdminPanel_Module_Management').' </h1>';
	echo '<p> '.$main_smarty->get_config_vars('PLIGG_Visual_AdminPanel_Module_Description').'</p>';
	
	if ($_GET["status"] == ""){
		echo '<form name="bulk_moderate" method="post">';
		echo '<div style="float:right;margin:5px 2px 8px 0;"><input type="submit" name="submit" value="'.$main_smarty->get_config_vars('PLIGG_Visual_AdminPanel_Apply_Changes').'" class="log2" /></div><br style="clear:both;" />';

		// pagename
		define('pagename', 'admin_modules_installed'); 
		$main_smarty->assign('pagename', pagename);
		echo '<table class="stripes" cellpadding="0" cellspacing="0" border="0">';
		echo '<tr><th>Details</th><th width="75px">Settings</th><th width="75px" style="text-align:center;">Enabled</th><th width="75px" style="text-align:center;">Uninstall</th></tr>';	
		$modules = $db->get_results('SELECT * from ' . table_modules . ' order by name asc;');
		if($modules){
			foreach($modules as $module) {
			    if (file_exists(mnmmodules . $module->folder))
			    {	
				echo '<tr>';
				echo '<td><a href = "?action=readme&module=' . $module->folder . '">' . $module->name . '</a>';
				echo ' ( Version</strong> ' . $module->version . ' )';
				
				if($module_info = include_module_settings($module->folder)){
				
					$versionupdate = '';
					if(isset($module_info['update_url'])){
						$updateurl  = $module_info['update_url'];					   
						$versionupdate = safe_file_get_contents($updateurl);
					}
					
					if (preg_match('/(\d+[\d\.]+)/',$versionupdate,$m) && $m[1] != $module->latest_version){
						$versionupdate = $m[1];
						$db->query($sql="UPDATE `". table_modules . "` SET `latest_version`='$versionupdate' WHERE `id`='{$module->id}'");
					}else{
						$versionupdate = $module->latest_version;
					}
				
					if ($versionupdate > 0 && $versionupdate!=$module->version){
						if(isset($module_info['homepage_url'])){
							$homepage_url = $module_info['homepage_url'];
							echo " (<a href='" . $homepage_url . "' target='_blank'>Upgrade $versionupdate</a>)";
						}
					}
				
					$description =  $module_info['desc'];
					if($description != ''){
						echo '<br />' . $description;
					}

					if(isset($module_info['requires'])){
						$requires = $module_info['requires'];
						if(is_array($requires)){
							echo '<br /><strong>Requires:</strong> ';
							foreach($requires as $requirement){
								if(check_for_enabled_module($requirement[0], $requirement[1])){
									echo '<img style="position:relative;top:1px;" src="'.my_pligg_base.'/templates/admin/images/icon_share_true.gif" alt="Pass" /> ';
								} else {
									echo '<img style="position:relative;top:1px;" src="'.my_pligg_base.'/templates/admin/images/icon_share_false.gif" alt="Fail" /> ';
								}
								echo '' . $requirement[0] . ' Version ' . $requirement[1] .' &nbsp;&nbsp; ';
							}
						}
					}
					
					echo '</td>';
					
					if(isset($module_info['settings_url'])){
					$settings_url = $module_info['settings_url'];
						echo '<td><a href="' . $settings_url . '"><img src="../templates/admin/images/module_settings.gif" alt="Settings" /></a></td>';
					} else {
						echo '<td></td>';
					}
				} else {
						echo '<td></td>';
				}
				
				echo '<td style="text-align:center;">';
				echo "<input type=\"hidden\" name=\"enabled[{$module->id}]\" id=\"enabled_{$module->id}\" value=\"{$module->enabled}\">";
				echo "<input type='checkbox' onclick='document.getElementById(\"enabled_{$module->id}\").value=this.checked ? 1 : 0;' ";
				if($module->enabled)
					echo "checked";
				echo ">";
				echo '</td><td>';
				echo '<a href = "?action=remove&module=' . $module->name . '"><img src="../templates/admin/images/module_uninstall.gif" alt="'.$main_smarty->get_config_vars('PLIGG_Visual_AdminPanel_Module_Remove').'" /></a>';
				echo '</td></tr>';
			    }
			}
		} else {
			echo '<h3>There are no modules installed!</h3>';
		}
		echo '</table>';
		echo '<div style="float:right;margin:8px 2px 15px 0;"><input type="submit" name="submit" value="'.$main_smarty->get_config_vars('PLIGG_Visual_AdminPanel_Apply_Changes').'" class="log2" /></div>';
		echo '</form>';



	}elseif ($_GET["status"] == 'uninstalled'){

		echo '<br /><table class="stripes" cellpadding="0" cellspacing="0" border="0">';
		echo '<tr><th>Details</th><th width="75px" style="text-align:center;">Install</th></tr>';	
		
		// find all the folders in the modules folder
		$dir = '../modules/';
		if (is_dir($dir)) {
		   if ($dh = opendir($dir)) {
			   while (($file = readdir($dh)) !== false) {
					if(is_dir($dir . $file)){
						if($file != '.' && $file != '..'){
							$foundfolders[] = $file;
						}
					}
			   }
			   closedir($dh);
		   }
		}
		

		// for each of the folders found, make sure they're not already in the database
		$modules = $db->get_results('SELECT * from ' . table_modules . ' order by name asc;');
		if($modules){
			foreach($modules as $module) {
				if(isset($foundfolders) && is_array($foundfolders)){
					foreach($foundfolders as $key => $value){
						if ($module->folder == $value){
							unset($foundfolders[$key]);
						}
					}
				}
			}		
		}		

		if(isset($foundfolders) && is_array($foundfolders)){
			asort($foundfolders);
			foreach($foundfolders as $key => $value){
				
				$text = '';
				if($module_info = include_module_settings($value)){
					$text[] = $module_info['desc'];
					$version = $module_info['version'];
					$name = $module_info['name'];
					
					if(file_exists('../modules/' . $value . '/' . $value . '_readme.htm')){
						echo '<tr><td><a href = "?action=readme&module=' . $value . '">' . $name . '</a> ( Version '.$version.' )';
					} else {
						echo '<tr><td><strong>' . $thename . '</strong> ( Version '.$version.' )';
					}

					if(is_array($text)){
						foreach($text as $tex){echo '<br />'.$tex;}
					}
					
					if(isset($module_info['requires'])){
						$requires = $module_info['requires'];
						if(is_array($requires)){
							echo '<br /><strong>Requires:</strong> ';
							foreach($requires as $requirement){
								if(check_for_enabled_module($requirement[0], $requirement[1])){
									echo '<img style="position:relative;top:1px;" src="'.my_pligg_base.'/templates/admin/images/icon_share_true.gif" alt="Pass" /> ';
								} else {
									echo '<img style="position:relative;top:1px;" src="'.my_pligg_base.'/templates/admin/images/icon_share_false.gif" alt="Fail" /> ';
								}
								echo '' . $requirement[0] . ' Version ' . $requirement[1] .' &nbsp;&nbsp; ';
							}
						}
					}
					echo '</td><td><a href = "?action=install&module=' . $value . '"><img src="'.my_pligg_base.'/templates/admin/images/module_install.gif" alt="Install" /></a></td></tr>';

				}
			}
		} else {
			// this is where folders are found but don't have the install file.
			echo '<strong>No uninstalled modules found!</strong><br />';
		}
	}
}

if($action == 'install'){
	$module = $db->escape(sanitize($_REQUEST['module'],3));

	if($module_info = include_module_settings($module))
	{
		$version = $module_info['version'];
		$name = $module_info['name'];
		$requires = $module_info['requires'];
		check_module_requirements($requires);
		
		process_db_requirements($module_info);
		
	} else {
		die('no install file exists');
	}
		
	$db->query("INSERT IGNORE INTO " . table_modules . " (`name`, `version`, `folder`, `enabled`) values ('".$name."', '" . $version . "', '".$module."', 1);");

	clear_module_cache();

	header('Location: admin_modules.php?status=uninstalled');
}	
	

if($action == 'remove'){
	$module = $db->escape(sanitize($_REQUEST['module'],3));
	$sql = "SELECT * FROM " . table_modules . " WHERE `name` = '" . $module . "';";
	$row = $db->get_row($sql);
	if(($module_info = include_module_settings($row->folder)) && $module_info['uninstall'])
		@eval($module_info['uninstall'].'();');

	$sql = "Delete from " . table_modules . " where `name` = '" . $module . "';";
	//echo $sql;
	$db->query($sql);

	clear_module_cache();

	header('Location: admin_modules.php');
}	


if($action == 'readme'){
	$module = sanitize($_REQUEST['module'],3);
	echo '<h1><img src="'.my_pligg_base.'/templates/admin/images/manage_mods.gif" align="absmiddle"/> '.$main_smarty->get_config_vars('PLIGG_Visual_AdminPanel_Module_Readme').'</h1>';
	echo '<a href="'.my_pligg_base.'/admin/admin_modules.php">'.$main_smarty->get_config_vars('PLIGG_Visual_AdminPanel_Module_Return').'</a><br /><hr />';

	if(file_exists('../modules/' . $module . '/' . $module . '_readme.htm')){
		include_once('../modules/' . $module . '/' . $module . '_readme.htm');	
	} else {
		echo $main_smarty->get_config_vars('PLIGG_Visual_AdminPanel_Module_Readme_Not_Found');
	}
	
}	

function safe_file_get_contents($url,$redirect=0)
{
	$parts = parse_url($url);
	$site  = $parts['host'];
	$port  = $parts['port'] ? $parts['port'] : 80;
	$path  = $parts['path'] . ($parts['query'] ? "?".$parts['query'] : "") . ($parts['fragment'] ? "#".$parts['fragment'] : "");
	$timeout = 5;
	$sock = @fsockopen( $site, $port, $errnum, $errstr, $timeout);
	if (!$sock) {
	return "Cannot connect to $site:$port: $errstr($errno)";
	} else {
	@socket_set_timeout($sock, $timeout);

	$dump = "GET ".$path." HTTP/1.0\r\n";
	$dump .= "User-Agent: Mozilla/4.0 (compatible; MSIE 5.01; Windows NT)\r\n";
	$dump .= "Host: ".$site."\r\n";
	$dump .= "Connection: close\r\n\r\n";

	$res = "";
	// Send HTTP query
		fputs( $sock, $dump );

	// Read all
	$header = true;
	while( $str = fgets( $sock, 1024 ) ) 
	{
		if ($header)
		{
		if (preg_match("/^Location: ([^\\s]+)\\s*$/",$str,$m) && ++$redirect<10)
			return safe_file_get_contents($m[1],$redirect);
		if ($str == "\r\n")
			$header = false;
		}
		else
			$res .= $str;
	}
	fclose( $sock );
	}
	return $res;
}

{/php}
</table>