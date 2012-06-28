<?php
function admin_snippet_fill_smarty($vars){
	global $main_smarty;
	$smarty = $vars['smarty'];
	$smarty->assign("snippet_actions_tpl",$main_smarty->_vars["snippet_actions_tpl"]);
}


function admin_snippet_showpage(){
	global $db, $main_smarty, $the_template;
		
	include_once('config.php');
	include_once(mnminclude.'html1.php');
	include_once(mnminclude.'link.php');
	include_once(mnminclude.'tags.php');
	include_once(mnminclude.'smartyvariables.php');
	
	$main_smarty = do_sidebar($main_smarty);

	force_authentication();
	$canIhaveAccess = 0;
	$canIhaveAccess = $canIhaveAccess + checklevel('god');
	
	if($canIhaveAccess == 1)
	{	
		// breadcrumbs
			$navwhere['text1'] = $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel');
			$navwhere['link1'] = getmyurl('admin', '');
			$navwhere['text2'] = "Modify Snippet";
			$navwhere['link2'] = my_pligg_base . "/module.php?module=admin_snippet";
			$main_smarty->assign('navbar_where', $navwhere);
			$main_smarty->assign('posttitle', " | " . $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel'));
		// breadcrumbs
		//Method for identifying modules rather than pagename
		define('modulename', 'admin_snippet'); 
		$main_smarty->assign('modulename', modulename);
		
		define('pagename', 'admin_modifysnippet'); 
		$main_smarty->assign('pagename', pagename);
		
		// Add new snippet
		if($_REQUEST['mode'] == 'new') {
			if($_POST['submit']) {
			    // Check some data
			    if(!$_POST['snippet_name']) {
				$main_smarty->assign('snippet_error', "Please specify Snippet Name");
			    } elseif(!$_POST['snippet_content']) {
				$main_smarty->assign('snippet_error', "Please specify Snippet Content");
			    } else {
				$snippet_name = $db->escape(sanitize($_POST['snippet_name'],4));
				$snippet_location = $db->escape(sanitize($_POST['snippet_location'],4));
				$snippet_content  = $db->escape($_POST['snippet_content']);
				$db->query("INSERT INTO ".table_prefix."snippets (snippet_name,snippet_location,snippet_updated,snippet_order,snippet_content) 
						   VALUES ('$snippet_name','$snippet_location',NOW(),'1','$snippet_content')");
				header("Location: ".my_pligg_base."/module.php?module=admin_snippet");
				die();
			    }
			}

			$main_smarty->assign('tpl_center', admin_snippet_tpl_path . 'admin_snippet_edit');
		// Edit snippet
		} elseif($_REQUEST['mode'] == 'edit') {
			if($_POST['submit']) {
			    // Check some data
			    if(!$_POST['snippet_name']) {
				$main_smarty->assign('snippet_error', "Please specify Snippet Name");
			    } elseif(!$_POST['snippet_content']) {
				$main_smarty->assign('snippet_error', "Please specify Snippet Content");
			    } elseif(!is_numeric($_POST['snippet_id'])) {
				$main_smarty->assign('snippet_error', "Wrong ID");
			    } else {
				$snippet_id = $_POST['snippet_id'];
				$snippet_name = $db->escape(sanitize($_POST['snippet_name'],4));
				$snippet_location = $db->escape(sanitize($_POST['snippet_location'],4));
				$snippet_content  = $db->escape($_POST['snippet_content']);
				$db->query("UPDATE ".table_prefix."snippets SET snippet_name='$snippet_name', snippet_location='$snippet_location', snippet_content='$snippet_content', snippet_updated=NOW() WHERE snippet_id='$snippet_id'");

				header("Location: ".my_pligg_base."/module.php?module=admin_snippet");
				die();
			    }
			}
	
			// Check ID
			if(!is_numeric($_GET['id'])) {
				header("Location: ".my_pligg_base."/module.php?module=admin_snippet");
				die();
			} else {
				$snippet = $db->get_row("SELECT * FROM ".table_prefix."snippets WHERE snippet_id={$_GET['id']}");
				if (!$snippet->snippet_id) {
					header("Location: ".my_pligg_base."/module.php?module=admin_snippet");
					die();
				}
				$main_smarty->assign("snippet",(array)$snippet);
			}
			$main_smarty->assign('tpl_center', admin_snippet_tpl_path . 'admin_snippet_edit');
		// Export selected
		} elseif(isset($_POST['export'])) { 
			if (sizeof($_POST["snippet_delete"]))
			{
				header('Content-Description: File Transfer'); 
				header('Pragma: no-cache');
			    	header('Cache-Control: no-cache, must-revalidate');
			    	header("Content-Disposition: attachment; filename=admin_snippet.xml"); 
			    	header("Content-type: text/xml; charset=utf-8");

    				echo "<?xml version=\"1.0\"?>\r\n";
				echo "<data>\r\n";

				$snippets = $db->get_results("SELECT * FROM ".table_prefix."snippets WHERE snippet_id IN(".join(",",array_keys($_POST["snippet_delete"])).")",ARRAY_A);
				foreach ($snippets as $snippet)
				{
				    echo "\t<snippet>\r\n";
				    echo "\t\t<name><![CDATA[".htmlspecialchars($snippet['snippet_name'],ENT_QUOTES,'UTF-8')."]]></name>\r\n";
				    echo "\t\t<location>{$snippet['snippet_location']}</location>\r\n";
				    echo "\t\t<content><![CDATA[".htmlspecialchars($snippet['snippet_content'],ENT_QUOTES,'UTF-8')."]]></content>\r\n";
				    echo "\t</snippet>\r\n";
				}

				echo "</data>\r\n";
				die();
			}

			header("Location: ".my_pligg_base."/module.php?module=admin_snippet");
			die();
		// Delete selected
		} elseif(isset($_POST['delete'])) { 
			if (sizeof($_POST["snippet_delete"]))
				$db->query("DELETE FROM ".table_prefix."snippets WHERE snippet_id IN(".join(",",array_keys($_POST["snippet_delete"])).")");

			header("Location: ".my_pligg_base."/module.php?module=admin_snippet");
			die();
		// Update orders
		} elseif(isset($_POST['update'])) {
			if (sizeof($_POST["snippet_order"]))
			    foreach ($_POST["snippet_order"] AS $k => $v)
				if (is_numeric($k) && is_numeric($v))
					$db->query("UPDATE ".table_prefix."snippets SET snippet_order='$v' WHERE snippet_id='$k'");

			header("Location: ".my_pligg_base."/module.php?module=admin_snippet");
			die();
		// Display the list
		} else {
		    	// Import snippets
		     	if($_REQUEST['import']) {
		    	    if ($_FILES["file"]["error"] == UPLOAD_ERR_OK) 
	  	    	    {
				$xml = file_get_contents($_FILES["file"]["tmp_name"]);
				if (preg_match_all('/<snippet>(.+?)<\/snippet>/is',$xml,$m))
				{
				    $array = $m[1];
				    if (sizeof($array))
				    {
					foreach($array as $snippet)
					{
					    if (preg_match('/<name>(<!\[CDATA\[)?(.+?)(\]\]>)?<\/name>/is',$snippet,$m))
					    	$snippet_name = $db->escape($m[2]);
					    if (preg_match('/<location>(.+?)<\/location>/is',$snippet,$m))
					    	$snippet_location = $db->escape($m[1]);
					    if (preg_match('/<content>(<!\[CDATA\[)?(.+?)(\]\]>)?<\/content>/is',$snippet,$m))
					    	$snippet_content = $db->escape($m[2]);
					    $db->query("INSERT INTO ".table_prefix."snippets (snippet_name,snippet_location,snippet_updated,snippet_order,snippet_content) 
							   VALUES ('$snippet_name','$snippet_location',NOW(),'1','$snippet_content')");
					}
					header("Location: ".my_pligg_base."/module.php?module=admin_snippet");
					die();
				    }
				    else
					$error = "No snippets found in XML file";
				}
				else
				    $error = 'Wrong XML format';
		    	    }
			    else
				$error = 'Error uploading file';
	
		   	    $main_smarty->assign('snippet_error',$error);
		    	}

	 		$filtered = $db->get_results("SELECT * FROM ".table_prefix."snippets ORDER BY snippet_location, snippet_order");
			if ($filtered)
			{
			    foreach($filtered as $dbfiltered) 
			  	$template_snippets[] = (array) $dbfiltered;
		  	    $main_smarty->assign('template_snippets', $template_snippets);
		  	}
			$main_smarty->assign('tpl_center', admin_snippet_tpl_path . 'admin_snippet_main');
		}
		$main_smarty->display($template_dir . '/admin/admin.tpl');
	}
	else
	{
		header("Location: " . getmyurl('login', $_SERVER['REQUEST_URI']));
	}
		
}	

?>
