<!-- widgets.tpl -->
{checkActionsTpl location="tpl_admin_widgets_top"}
{php}
	global $db, $main_smarty;	
	if(isset($_REQUEST['action'])){
		$action = sanitize($_REQUEST['action'],3);
	} else {
		$action = 'main';
	}
	if($action == 'main' || $action == 'disable' || $action == 'enable'){
		echo '<legend>'.$main_smarty->get_config_vars('PLIGG_Visual_AdminPanel_Widget_Management').' </legend>';
		echo '<p>'.$main_smarty->get_config_vars('PLIGG_Visual_AdminPanel_Widget_Description').'</p>';
		echo '	<ul id="widgettabs" class="nav nav-tabs">';
			if ($_GET["status"] != 'uninstalled'){
				echo '<li class="active"><a href="admin_widgets.php" id="installed">Installed</a></li>';
				echo '<li><a href="admin_widgets.php?status=uninstalled" id="uninstalled">Uninstalled</a></li>';
			} else {
				echo '<li><a href="admin_widgets.php" id="installed">Installed</a></li>';
				echo '<li class="active"><a href="admin_widgets.php?status=uninstalled">Uninstalled</a></li>';
			}
		echo '	</ul>';
		// Tab Wrapper
		if ($_GET["status"] != 'uninstalled'){
			echo '<form name="bulk_moderate" method="post">';
			/*
			echo '<div class="apply_widgets"><input type="submit" class="btn btn-primary" name="submit" value="'.$main_smarty->get_config_vars('PLIGG_Visual_AdminPanel_Apply_Changes').'" id="apply_changes" /></div>';
			echo '<br />';
			*/
			echo '<table class="table table-bordered">';
			echo '<thead>
					<tr>
						';
						/* <th style="text-align:center;">Enabled</th> */
			echo '		<th>Details</th>';
			// echo ' 		<th>Version</th>';
			// echo ' 		<th>Requires</th>';
			echo '		<th>Homepage</th>
						<th>Uninstall</th>
					</tr>
				</thead>
				<tbody>';	
			$widgets = $db->get_results('SELECT * from ' . table_widgets . ' order by name asc;');
			if($widgets){
				foreach($widgets as $widget) {
					if (file_exists(mnmpath . '/widgets/' . $widget->folder)){
						echo '<tr>';
						/*
							echo '	<td style="text-align:center;vertical-align:middle;">';
							echo "	<input type=\"hidden\" name=\"enabled[{$widget->id}]\" id=\"enabled_{$widget->id}\" value=\"{$widget->enabled}\">";
							echo "	<input type='checkbox' onclick='document.getElementById(\"enabled_{$widget->id}\").value=this.checked ? 1 : 0;' ";
							if($widget->enabled)
								echo "checked";
							echo ">";
							echo '	</td>';
						*/
						echo '	<td><a href = "?action=readme&widget=' . $widget->folder . '">' . $widget->name . '</a>';
						if($widget_info = include_widget_settings($widget->folder)){
							$description =  $widget_info['desc'];
							if($description != ''){
								echo '<br />' . $description;
							}
							echo '</td>';
						} else {
							echo '<td></td>';
						}
						/*
							echo '	<td style="text-align:center;">' . $widget->version . '</td>';
							$versionupdate = '';
							if(isset($widget_info['update_url'])){
								$updateurl  = $widget_info['update_url'];					   
								$versionupdate = safe_file_get_contents($updateurl);
							}
							if (preg_match('/(\d+[\d\.]+)/',$versionupdate,$m) && $m[1] != $widget->latest_version){
								$versionupdate = $m[1];
								$db->query($sql="UPDATE `". table_widgets . "` SET `latest_version`='$versionupdate' WHERE `id`='{$widget->id}'");
							} else {
								$versionupdate = $widget->latest_version;
							}
							if ($versionupdate > 0){
								if(isset($widget_info['homepage_url'])){
									$homepage_url = $widget_info['homepage_url'];
									echo " <a class='btn btn-default' href='" . $homepage_url . "' target='_blank'>Upgrade $versionupdate</a>";
								}
							}
						*/
						/*
							// Requirements is Currently Broken
							if(isset($widget_info['requires'])){
								$requires = $widget_info['requires'];
								if(is_array($requires)){
									echo '<td>';
									foreach($requires as $requirement){
										if(check_for_enabled_widget($requirement[0], $requirement[1])){
											echo '<i class="fa fa-check" alt="Pass"></i> ';
										} else {
											echo '<i class="fa fa-times" alt="Fail"></i> ';
										}
										echo '' . $requirement[0] . ' Version ' . $requirement[1] .' &nbsp;&nbsp; ';
									}
									echo '</td>';
								}
							} else {
								echo '<td></td>';
							}
						*/
						if(isset($widget_info['homepage_url']) && $widget_info['homepage_url'] != ''){
							$homepage_url = $widget_info['homepage_url'];
							echo '<td style="text-align:center;vertical-align:middle;"><a class="btn btn-default" href="' . $homepage_url . '">Homepage</a></td>';
						} else {
							echo '<td></td>';
						}
						echo '<td style="text-align:center;vertical-align:middle;">';
						echo '<a class="btn btn-danger btn-xs" href="?action=remove&widget=' . $widget->name . '">'.$main_smarty->get_config_vars('PLIGG_Visual_AdminPanel_Module_Remove').'</a>';
						echo '</td></tr>';
					}
				}
			} else {
				echo '<h3>There are no widgets installed!</h3>';
			}
			echo '</tbody></table>';
			/*
			echo '<div class="apply_widgets"><input type="submit" class="btn btn-primary" name="submit" value="'.$main_smarty->get_config_vars('PLIGG_Visual_AdminPanel_Apply_Changes').'" /></div>';
			*/
			echo '</form>';
		} else {
			echo '<table class="table table-bordered">';
			echo '<thead><tr><th>Details</th><th style="text-align:center;">Install</th></tr></thead><tbody>';	
			// find all the folders in the widgets folder
			$dir = '../widgets/';
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
			// For each of the folders found, make sure they're not already in the database
			$widgets = $db->get_results('SELECT * from ' . table_widgets . ' order by name asc;');
			if($widgets){
				foreach($widgets as $widget) {
					if(isset($foundfolders) && is_array($foundfolders)){
						foreach($foundfolders as $key => $value){
							if ($widget->folder == $value){
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
					if($widget_info = include_widget_settings($value)){
						$text[] = $widget_info['desc'];
						$version = $widget_info['version'];
						$name = $widget_info['name'];
						if(file_exists('../widgets/' . $widget->folder . '/' . $widget->folder . '_readme.htm')){
							echo '<tr><td><a href="?action=readme&widget=' . $value . '">' . $name . '</a> ( Version '.$version.' )';
						} else {
							echo '<tr><td><strong>' . $name . '</strong> ( Version '.$version.' )';
						}
						if(is_array($text)){
							foreach($text as $tex){echo '<br />'.$tex;}
						}
						if(isset($widget_info['requires'])){
							$requires = $widget_info['requires'];
							if(is_array($requires)){
								echo '<br /><strong>Requires:</strong> ';
								foreach($requires as $requirement){
									if(check_for_enabled_widget($requirement[0], $requirement[1])){
										echo '<i class="fa fa-check" alt="Pass"></i> ';
									} else {
										echo '<i class="fa fa-times" alt="Fail"></i> ';
									}
									echo '' . $requirement[0] . ' Version ' . $requirement[1] .' &nbsp;&nbsp; ';
								}
							}
						}
						echo '</td><td style="text-align:center;vertical-align:middle;"><a class="btn btn-success btn-xs" href="?action=install&widget=' . $value . '">Install</a></td></tr>';
					}
				}
			} else {
				// This is where folders are found but don't have the install file.
				echo '<strong>No uninstalled widgets found!</strong><br />';
			}
			echo '</tbody></table>';
		}
	}
	if($action == 'readme'){
		$widget = sanitize($_REQUEST['widget'],3);
		echo '<legend>'.$main_smarty->get_config_vars('PLIGG_Visual_AdminPanel_Widget_Readme').'</legend>';
		echo '<a href="'.my_pligg_base.'/admin/admin_widgets.php"><i class="fa fa-caret-left"></i> '.$main_smarty->get_config_vars('PLIGG_Visual_AdminPanel_Widget_Return').'</a><br /><hr />';
		if(file_exists('../widgets/' . $widget . '/' . $widget . '_readme.htm')){
			include_once('../widgets/' . $widget . '/' . $widget . '_readme.htm');	
		} else {
			echo $main_smarty->get_config_vars('PLIGG_Visual_AdminPanel_Widget_Readme_Not_Found');
		}
	}	
	function safe_file_get_contents($url,$redirect=0){
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
			while( $str = fgets( $sock, 1024 ) ){
				if ($header){
					if (preg_match("/^Location: ([^\\s]+)\\s*$/",$str,$m) && ++$redirect<10){
						return safe_file_get_contents($m[1],$redirect);
					}
					if ($str == "\r\n"){
						$header = false;
					}
				} else {
					$res .= $str;
				}
			}
			fclose( $sock );
		}
		return $res;
	}
{/php}
<!--/widgets.tpl -->