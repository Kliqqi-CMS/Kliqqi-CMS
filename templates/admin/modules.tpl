<!-- modules.tpl -->
{checkActionsTpl location="tpl_admin_modules_top"}
{php}
global $db, $main_smarty;	
if(isset($_REQUEST['action'])){
	$action = sanitize($_REQUEST['action'],3);
} else {
	$action = 'main';
}
if($action == 'main' || $action == 'disable' || $action == 'enable'){
	echo '<legend>'.$main_smarty->get_config_vars('PLIGG_Visual_AdminPanel_Module_Management').' </legend>';
	echo '<p>'.$main_smarty->get_config_vars('PLIGG_Visual_AdminPanel_Module_Description').'</p>';
	echo '	<ul id="moduletabs" class="nav nav-tabs">';
		if ($_GET["status"] != 'uninstalled'){
			echo '<li class="active" id="module_installed"><a href="#installed" data-toggle="tab">Installed</a></li>';
			echo '<li id="module_uninstalled"><a href="#uninstalled" data-toggle="tab">Uninstalled</a></li>';
		} else {
			echo '<li id="module_installed"><a href="#installed" data-toggle="tab">Installed</a></li>';
			echo '<li class="active" id="module_uninstalled"><a href="#uninstalled" data-toggle="tab">Uninstalled</a></li>';
		}
	echo '	</ul>';
	// Tab Wrapper
	echo '	<div class="tab-content" id="tabbed">';
	// Install tab status
	if ($_GET["status"] != 'uninstalled'){
		echo '<div id="installed" class="active tab-pane fade in">';
	} else {
		echo '<div id="installed" class="tab-pane fade in">';
	}
	echo '<form name="bulk_moderate" method="post">';
	echo '<div class="module_apply"><input type="submit" class="btn btn-primary" name="submit" value="'.$main_smarty->get_config_vars('PLIGG_Visual_AdminPanel_Apply_Changes').'" id="apply_changes" /></div>';
	echo '<br />';
	echo '<table class="table table-bordered table-striped">';
	echo '<thead><tr><th style="text-align:center;">Enabled</th><th>Details</th><th>Requires</th><th>Version</th><th>Homepage</th><th>Settings</th><th>Uninstall</th></tr></thead><tbody>';	
	$modules = $db->get_results('SELECT * from ' . table_modules . ' order by name asc;');
	if($modules){
		foreach($modules as $module) {
			if (file_exists(mnmmodules . $module->folder))
			{	
				echo '<tr>';
				echo '<td style="text-align:center;vertical-align:middle;">';
				echo "<input type=\"hidden\" name=\"enabled[{$module->id}]\" id=\"enabled_{$module->id}\" value=\"{$module->enabled}\">";
				echo "<input type='checkbox' onclick='document.getElementById(\"enabled_{$module->id}\").value=this.checked ? 1 : 0;' ";
				if($module->enabled)
					echo "checked";
				echo ">";
				echo '</td>';
				echo '<td><a href="?action=readme&module=' . $module->folder . '">' . $module->name . '</a>';
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
					$description =  $module_info['desc'];
					if($description != ''){
						echo '<br />' . $description;
					}
					echo '</td>';
					if(isset($module_info['requires'])){
						$requires = $module_info['requires'];
						if(is_array($requires)){
							echo '<td><ul class="unstyled">';
							foreach($requires as $requirement){
								echo '<li style="line-height:22px;">';
								if(check_for_enabled_module($requirement[0], $requirement[1])){
									echo '<span class="label label-success" style="padding:3px 5px;"><i class="icon-white icon-ok"></i> ';
								} else {
									echo '<span class="label label-important" style="padding:3px 5px;"><i class="icon-white icon-remove"></i> ';
								}
								if ($requirement[3]){ echo '<a href="' . $requirement[3] . '" style="color:#fff;">'; }
								if ($requirement[2]){ echo $requirement[2];	} else { echo $requirement[0]; }
								if ($requirement[3]){ echo '</a>'; }
								echo ' ' . $requirement[1] .'</span></li>';
							}
							echo '</ul></td>';
						} else {
							echo '<td></td>';
						}
					} else {
						echo '<td></td>';
					}
					echo '<td style="text-align:center;vertical-align:middle;">';
					if ($versionupdate > 0 && $versionupdate!=$module->version){
						if(isset($module_info['homepage_url'])){
							$homepage_url = $module_info['homepage_url'];
							echo " <a class='label label-important' href='" . $homepage_url . "' target='_blank' title='Upgrade to $versionupdate'>".$module->version."</a>";
						}
					} else {
						echo '<span class="label">'.$module->version.'</span></td>';
					}
					echo '</td>';
					if(isset($module_info['homepage_url'])){
					$homepage_url = $module_info['homepage_url'];
						echo '<td style="text-align:center;vertical-align:middle;"><a class="btn btn-mini" href="' . $homepage_url . '">Homepage</a></td>';
					} else {
						echo '<td></td>';
					}
					if(isset($module_info['settings_url'])){
					$settings_url = $module_info['settings_url'];
						echo '<td style="text-align:center;vertical-align:middle;"><a class="btn btn-mini" href="' . $settings_url . '">Settings</a></td>';
					} else {
						echo '<td></td>';
					}
				} else {
					echo '<td></td>';
				}
				echo '<td style="text-align:center;vertical-align:middle;">';
				echo '<a class="btn btn-danger btn-mini" href="?action=remove&module=' . $module->name . '">'.$main_smarty->get_config_vars('PLIGG_Visual_AdminPanel_Module_Remove').'</a>';
				echo '</td></tr>';
			}
		}
	} else {
		echo '<h3>There are no modules installed!</h3>';
	}
	echo '</tbody></table>';
	echo '<div class="apply_modules"><input type="submit" class="btn btn-primary" name="submit" value="'.$main_smarty->get_config_vars('PLIGG_Visual_AdminPanel_Apply_Changes').'" /></div>';
	echo '</form>';
	// End installed wrapper
	echo '</div>';
	// Uninstall tab status
	if ($_GET["status"] == 'uninstalled'){
		echo '<div id="uninstalled" class="active tab-pane fade in">';
	} else {
		echo '<div id="uninstalled" class="tab-pane fade in">';
	}
	echo '<table class="table table-bordered table-striped">';
	echo '<thead><tr><th>Details</th><th>Requires</th><th style="text-align:center;">Version</th><th style="text-align:center;">Homepage</th><th style="text-align:center;">Install</th></tr></thead><tbody>';	
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
					echo '<tr><td><a href="?action=readme&module=' . $value . '">' . $name . '</a>';
				} else {
					echo '<tr><td><strong>' . $thename . '</strong>';
				}
				if(is_array($text)){
					foreach($text as $tex){echo '<br />'.$tex;}
				}
				echo '</td>';
				if(isset($module_info['requires'])){
					$requires = $module_info['requires'];
					if(is_array($requires)){
						echo '<td><ul class="unstyled">';
						foreach($requires as $requirement){
							echo '<li style="line-height:22px;">';
							if(check_for_enabled_module($requirement[0], $requirement[1])){
								echo '<span class="label label-success" style="padding:3px 5px;"><i class="icon-white icon-ok"></i> ';
							} else {
								echo '<span class="label label-important" style="padding:3px 5px;"><i class="icon-white icon-remove"></i> ';
							}
							if ($requirement[3]){ echo '<a href="' . $requirement[3] . '" style="color:#fff;">'; }
							if ($requirement[2]){ echo $requirement[2];	} else { echo $requirement[0]; }
							if ($requirement[3]){ echo '</a>'; }
							echo ' ' . $requirement[1] .'</span></li>';
						}
						echo '</ul></td>';
					} else {
						echo '<td></td>';
					}
				} else {
					echo '<td></td>';
				}
				echo '<td style="text-align:center;vertical-align:middle;"><span class="label">'.$version.'</span></td>';
				echo '<td style="text-align:center;vertical-align:middle;">';
				if(isset($module_info['homepage_url'])){
					$homepage_url = $module_info['homepage_url'];
					echo " <a class='btn btn-mini' href='" . $homepage_url . "' target='_blank'>Homepage</a>";
				}
				echo '</td>';
				echo '<td style="text-align:center;vertical-align:middle;"><a class="btn btn-success btn-mini" href="?action=install&module=' . $value . '">Install</a></td></tr>';
			}
		}
	} else {
		// this is where folders are found but don't have the install file.
		echo '<strong>No uninstalled modules found!</strong><br />';
	}
	echo '</tbody></table>';
	// End the uninstalled module wrapper
	echo '</div>';
}
// End the tab container
echo '</div>';
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
	echo '<legend>'.$main_smarty->get_config_vars('PLIGG_Visual_AdminPanel_Module_Readme').'</legend>';
	echo '<a class="btn" href="'.my_pligg_base.'/admin/admin_modules.php"><i class="icon-arrow-left"></i> '.$main_smarty->get_config_vars('PLIGG_Visual_AdminPanel_Module_Return').'</a><hr />';
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
{literal}
<script>
$(function () {
	$('#installed a[href="#installed"]').tab('show');
	$('#uninstalled a[href="#uninstalled"]').tab('show');
})
</script>
{/literal}
<!--/modules.tpl -->