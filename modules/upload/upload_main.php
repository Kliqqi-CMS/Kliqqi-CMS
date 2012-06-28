<?php
//
// Settings page
//
function upload_showpage(){
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
		// Save settings
		if ($_POST['submit'])
		{
			misc_data_update('upload_thumb', sanitize($_REQUEST['upload_thumb'], 3));

			$sizes = unserialize(get_misc_data('upload_sizes'));
			for ($i=0; $i<sizeof($sizes); $i++)
			{
			    if (@in_array($sizes[$i],$_POST['delsize']))
			    {
				if ($_REQUEST['upload_defsize'] == $sizes[$i]) $_REQUEST['upload_defsize'] = 'orig';
				array_splice($sizes,$i--,1);
			    }
			}
			if (is_numeric($_POST['upload_width']) && $_POST['upload_width'] > 0 &&
			    is_numeric($_POST['upload_height']) && $_POST['upload_height'] > 0)
			{
			    $size = sanitize($_POST['upload_width'].'x'.$_POST['upload_height'], 3);
			    if (!@in_array($size,$sizes))
			    {
			    	$sizes[] = $size;

				$files = $db->get_results($sql = "SELECT a.* FROM " . table_prefix . "files a
								    LEFT JOIN " . table_prefix . "files b ON a.file_id=b.file_orig_id AND b.file_size='$size'
								    WHERE a.file_size='orig' AND ISNULL(b.file_id)");
				if ($files)
				{
				    misc_data_update('upload_sizes', serialize($sizes));
				    misc_data_update('upload_thumb_format', $_REQUEST['upload_thumb_format']);
				    misc_data_update('upload_quality', $_REQUEST['upload_quality']<=100 && $_REQUEST['upload_quality']>=1 ? $_REQUEST['upload_quality'] : 80 );
				    $settings = get_upload_settings();

				    foreach ($files as $file)
					generate_thumbs(
						strpos($file->file_name,'http')===0 ? $file->file_name : mnmpath.sanitize($_REQUEST['upload_directory'], 3).'/'.$file->file_name,
						$file->file_link_id,
						$settings,
						$file->file_id,
						$size);
				}
			    }
			}

			$fields = unserialize(base64_decode(get_misc_data('upload_fields')));
			for ($i=0; $i<sizeof($fields); $i++)
			{
			    if (in_array($fields[$i],$_POST['delfield']))
				array_splice($fields,$i--,1);
			}
			if ($_POST['upload_new_field'])
			    $fields[] = sanitize($_POST['upload_new_field'], 3);

			if ($_POST['alternate'])
			    foreach ($_POST['alternate'] as $k => $v)
			    	$alternates[$k] = sanitize($v, 3);

			$mandatory = array();
			if ($_POST['mandatory'])
			    foreach ($_POST['mandatory'] as $k => $v)
			    	$mandatory[$k] = sanitize($v, 3);

			$display = array();
			if ($_POST['display'])
			    foreach ($_POST['display'] as $k => $v)
			    	$display[$k] = sanitize($v, 3);

			misc_data_update('upload_sizes', serialize($sizes));
			misc_data_update('upload_fields', base64_encode(serialize($fields)));
			misc_data_update('upload_alternates', base64_encode(serialize($alternates)));
			misc_data_update('upload_mandatory', serialize($mandatory));
			misc_data_update('upload_display', serialize($display));
			misc_data_update('upload_place', sanitize($_REQUEST['upload_place'], 3));
			misc_data_update('upload_defsize', sanitize($_REQUEST['upload_defsize'], 3));
			misc_data_update('upload_external', sanitize($_REQUEST['upload_external'], 3));
			misc_data_update('upload_format', $_REQUEST['upload_format']);
			misc_data_update('upload_pre_format', $_REQUEST['upload_pre_format']);
			misc_data_update('upload_post_format', $_REQUEST['upload_post_format']);
			misc_data_update('upload_thumb_format', $_REQUEST['upload_thumb_format']);
			misc_data_update('upload_t_pre_format', $_REQUEST['upload_thumb_pre_format']);
			misc_data_update('upload_t_post_format', $_REQUEST['upload_thumb_post_format']);
			misc_data_update('upload_allow_hide', sanitize($_REQUEST['upload_allow_hide'],3));
			misc_data_update('upload_quality', $_REQUEST['upload_quality']<=100 && $_REQUEST['upload_quality']>=1 ? $_REQUEST['upload_quality'] : 80 );
			misc_data_update('upload_link', sanitize($_REQUEST['upload_link'], 3));
			misc_data_update('upload_directory', sanitize($_REQUEST['upload_directory'], 3));
			misc_data_update('upload_thdirectory', sanitize($_REQUEST['upload_thdirectory'], 3));
			misc_data_update('upload_filesize', sanitize($_REQUEST['upload_filesize'], 3));
			misc_data_update('upload_maxnumber', sanitize($_REQUEST['upload_maxnumber'], 3));
			misc_data_update('upload_extensions', sanitize($_REQUEST['upload_extensions'], 3));
			misc_data_update('upload_fileplace', sanitize($_REQUEST['upload_fileplace'], 3));

			header("Location: ".my_pligg_base."/module.php?module=upload");
			die();
		}
		// breadcrumbs
			$navwhere['text1'] = $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel');
			$navwhere['link1'] = getmyurl('admin', '');
			$navwhere['text2'] = "Modify Upload";
			$navwhere['link2'] = my_pligg_base . "/module.php?module=upload";
			$main_smarty->assign('navbar_where', $navwhere);
			$main_smarty->assign('posttitle', " / " . $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel'));
		// breadcrumbs
		define('modulename', 'upload'); 
		$main_smarty->assign('modulename', modulename);
		
		define('pagename', 'admin_modifyupload'); 
		$main_smarty->assign('pagename', pagename);
		$main_smarty->assign('settings', str_replace('"','&#034;',get_upload_settings()));
		$main_smarty->assign('places',$upload_places);
		$main_smarty->assign('tpl_center', upload_tpl_path . 'upload_main');
		$main_smarty->display($template_dir . '/admin/admin.tpl');
	}
	else
	{
		header("Location: " . getmyurl('login', $_SERVER['REQUEST_URI']));
	}
}	

function upload_edit_link()
{
	global $db, $current_user;

	$upload_dir = mnmpath . get_misc_data('upload_directory');
    	$thumb_dir  = mnmpath . get_misc_data('upload_thdirectory');

	// Remove selected files
	if ($_POST['upload_delete'])
	    foreach ($_POST['upload_delete'] as $id)
	    {
	    	if ($files = $db->get_results($sql = "SELECT * FROM ".table_prefix."files WHERE (file_id='$id' OR file_orig_id='$id') AND file_user_id='{$current_user->user_id}'"))
		    foreach ($files as $row)
		    {
		    	if ($row->file_size=='orig')
			    @unlink("$upload_dir/{$row->file_name}");
		    	else
			    @unlink("$thumb_dir/{$row->file_name}");
		    }
	    	$db->query("DELETE FROM ".table_prefix."files WHERE (file_id='$id' OR file_orig_id='$id') AND file_user_id='{$current_user->user_id}'"); 
 	    }
	upload_save_files();
}

function upload_do_submit2()
{
	global $db, $current_user;
	upload_delete(array("link_id" => $_POST['id']));
        upload_save_files();
}

function upload_save_files()
{
	global $db, $main_smarty, $dblang, $the_template, $linkres, $current_user;

	$settings = get_upload_settings();
	$upload_dir = mnmpath . $settings['directory'];
	$last_id = $count = 0;
	$extensions = split('[ ,.]+',$settings['extensions']);

	// Save additional fields
	$fields = array();
	foreach ($_POST as $k => $v)
	    if (strpos($k,"field")===0)
		$fields[$k] = sanitize($v,3);


    if (strstr($settings['external'],'file') && $_FILES["upload_files"]["error"])
    {
	if (is_dir($upload_dir))
	{
	    foreach ($_FILES["upload_files"]["error"] as $key => $err) 
	    {
		if ($_FILES["upload_files"]["size"][$key]/1024 > $settings['filesize'])
		    $error = "Maximum file size ({$settings['filesize']} Kb) exceeded";
	    	elseif ($err == UPLOAD_ERR_OK) 
	  	{
	            $tmp_name = $_FILES["upload_files"]["tmp_name"][$key];
	            $name = $_FILES["upload_files"]["name"][$key];
		    if ($ext = strrchr($name,'.'))
		    {
			$name = str_replace($ext,'',$name);
	            	$ext  = substr($ext,1);
		    }
		    if ($ext && in_array(strtolower($ext),$extensions))
		    {
			    while (file_exists("$upload_dir/$name$i.$ext")) $i++;
			    $name .= $i;
	
		            if (@move_uploaded_file($tmp_name, "$upload_dir/$name.$ext"))
			    {
				$db->query("INSERT INTO ".table_prefix."files 
						SET file_size='orig',
						    file_user_id={$current_user->user_id},
						    file_link_id={$linkres->id},
						    file_real_size='{$_FILES["upload_files"]["size"][$key]}',	
						    file_fields='".base64_encode(serialize($fields))."',
						    file_name='".$db->escape("$name.$ext")."'");
				$count++;
				$last_id = $db->insert_id;
				$error = generate_thumbs("$upload_dir/$name.$ext",$linkres->id,$settings,$db->insert_id);
			    }
			    else
				$error = "Error copying file to $upload_dir/$name";
		    }
		    else
			$error = "Extension .$ext is not allowed";
	        }
	    }
	} 
	else
	    $error = "Directory $upload_dir does not exists";
    }

	// Add external links here
	if (strstr($settings['external'],'url') && $_POST["upload_urls"])
	{
		foreach ($_POST["upload_urls"] as $url) 
		{
		    if ($count > $settings['maxnumber']) break;
		    $url = trim($url);
		    if (strlen($url)>10 && strpos($url,'http')===0) 
		    {
			$db->query("INSERT INTO ".table_prefix."files 
					SET file_size='orig',
					    file_user_id={$current_user->user_id},
					    file_link_id={$linkres->id},
					    file_fields='".base64_encode(serialize($fields))."',
					    file_name='".$db->escape($url)."'");
			$count++;
			$last_id = $db->insert_id;
			$error = generate_thumbs($url,$linkres->id,$settings,$last_id);
		    }
		}
	}

	if ($error)
	{
		print $error;
		return $error;
	}
	else
		return $last_id;
}

function generate_thumbs($fname,$link_id,$settings,$orig_id,$only_size='')
{
    global $db, $current_user;

    if (!($str = @file_get_contents($fname)))   return "Can't read file $fname"; 
    if (!($img = @imagecreatefromstring($str))) 
	return; 
    else	
	$db->query("UPDATE ".table_prefix."files SET file_ispicture=1 WHERE file_id='$orig_id'");

    if (!$settings['thumb']) return;
    if (!$settings['sizes']) return;
    $thumb_dir = mnmpath . $settings['thdirectory'];

    // load image and get image size
    $width  = imagesx( $img );
    $height = imagesy( $img );
    $error  = '';
    foreach ($settings['sizes'] as $size)
    {
	if (!strstr($size,'x') || ($only_size && $only_size!=$size)) continue;
	list($maxw,$maxh) = split('[x]',$size);
	if ($maxw <= 0 || $maxh <= 0) continue;

	// Thumbnail file name
	if (preg_match('/([^\/]+)\.[^\/]+$/',$fname,$m) || preg_match('/([^\/]+)$/',$fname,$m))
	    $name = $m[1];
	else
	    $name = $fname;
	$name = "$name$size";

	// calculate thumbnail size
	$c = max($width/$maxw,$height/$maxh);
	if ($c > 1)
	{
	      	$new_width  = floor($width/$c);
	      	$new_height = floor($height/$c);
	}
	else
	{
	      	$new_width  = $width;
	      	$new_height = $height;
	}

	// create a new temporary image
      	$tmp_img = imagecreatetruecolor( $new_width, $new_height );
	
      	// copy and resize old image into new image 
        while (file_exists("$thumb_dir/$name$i.jpg")) $i++;
	$name = "$name$i.jpg";

      	imagecopyresized( $tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height );
	
      	if (!imagejpeg( $tmp_img, "$thumb_dir/$name",$settings['quality'] ))
	    $error .= "Can't create thumbnail $thumb_dir/$name";
	else
	    $db->query("INSERT INTO ".table_prefix."files 
				SET file_size='$size',
				    file_orig_id='$orig_id',
				    file_user_id={$current_user->user_id},
				    file_link_id=$link_id,
				    file_ispicture=1,
				    file_real_size='".filesize("$thumb_dir/$name")."',
				    file_name='".$db->escape($name)."'");
    }
    return $error;
}

// 
// Read module settings
//
function get_upload_settings()
{
    return array(
		'thumb' => get_misc_data('upload_thumb'), 
		'sizes' => unserialize(get_misc_data('upload_sizes')), 
		'place' => get_misc_data('upload_place'), 
		'defsize' => get_misc_data('upload_defsize'), 
		'external' => get_misc_data('upload_external'), 
		'quality' => get_misc_data('upload_quality'), 
		'allow_hide' => get_misc_data('upload_allow_hide'), 
		'fields' => unserialize(base64_decode(get_misc_data('upload_fields'))), 
		'alternates' => unserialize(base64_decode(get_misc_data('upload_alternates'))), 
		'mandatory' => unserialize(get_misc_data('upload_mandatory')), 
		'display' => unserialize(get_misc_data('upload_display')), 
		'format' => get_misc_data('upload_format'), 
		'pre_format' => get_misc_data('upload_pre_format'), 
		'post_format' => get_misc_data('upload_post_format'), 
		'thumb_format' => get_misc_data('upload_thumb_format'), 
		'thumb_pre_format' => get_misc_data('upload_t_pre_format'), 
		'thumb_post_format' => get_misc_data('upload_t_post_format'), 
		'link' => get_misc_data('upload_link'), 
		'directory' => get_misc_data('upload_directory'), 
		'thdirectory' => get_misc_data('upload_thdirectory'), 
		'filesize' => get_misc_data('upload_filesize'), 
		'maxnumber' => get_misc_data('upload_maxnumber'), 
		'extensions' => get_misc_data('upload_extensions'), 
		'fileplace' => get_misc_data('upload_fileplace')
		);
}

// 
// 
//
function upload_get_file_count($link_id)
{
    global $db;

    $sql = "SELECT COUNT(*) FROM " . table_prefix . "files where file_link_id='$link_id' AND file_size='orig'";
    $row = $db->get_row($sql,ARRAY_N);
    return $row[0];
}

// 
// 
//
function upload_get_file_size($link_id)
{
    global $db;

    $sql = "SELECT SUM(file_real_size) FROM " . table_prefix . "files where file_link_id='$link_id'";
    $row = $db->get_row($sql,ARRAY_N);
    return 0+$row[0];
}

function upload_track($vars)
{
    global $db, $smarty, $dblang, $the_template, $linkres, $current_user;

    $upload_dir = get_misc_data('upload_directory');
    $thumb_dir  = get_misc_data('upload_thdirectory');

    $content = $vars['smarty']->_vars['story_content'];
    $link_id = $vars['smarty']->_vars['link_id'];
    if (preg_match_all('/\{image(\d+)(\_(\d+x\d+))?\}/s',$content,$m))
    for ($i=0; $i<sizeof($m[1]); $i++)
    {
	$number = $m[1][$i];
	$size = $m[3][$i];
	if (!$size) $size='orig';

	if ($file = $db->get_row($sql = "SELECT * FROM " . table_prefix . "files where file_link_id='$link_id' AND file_size='$size' AND file_number=$number"))
	{
	    if (strpos($file->file_name,'http')===0)
		$image = "<img src='{$file->file_name}'/>";
	    elseif ($file->file_size=='orig')
		$image = "<img src='".my_pligg_base."{$upload_dir}/{$file->file_name}'/>";
	    else
		$image = "<img src='".my_pligg_base."{$thumb_dir}/{$file->file_name}'/>";
	}
	else
	    $image = '';	
	$content = str_replace($m[0][$i],$image,$content);
    }

    $images = $db->get_results($sql = "SELECT * FROM " . table_prefix . "files where file_link_id='$link_id'");
    if ($images)
	foreach ($images as $file)
	{
	    if (strpos($file->file_name,'http')===0)
		$image = "<img src='{$file->file_name}'/>";
	    elseif ($file->file_size=='orig')
		$image = "<img src='".my_pligg_base."{$upload_dir}/{$file->file_name}'/>";
	    else
		$image = "<img src='".my_pligg_base."{$thumb_dir}/{$file->file_name}'/>";

	    if ($file->file_size=='orig')
    	    	$vars['smarty']->_vars["image{$file->file_number}"] = $file->file_ispicture ? $image : '';
	    else
    	    	$vars['smarty']->_vars["image{$file->file_number}_{$file->file_size}"] = $image;
	}
    $vars['smarty']->_vars['story_content'] = $content;
}

function upload_delete($vars)
{
    global $db, $smarty, $dblang, $the_template, $linkres, $current_user;

    $upload_dir = mnmpath . get_misc_data('upload_directory');
    $thumb_dir  = mnmpath . get_misc_data('upload_thdirectory');

    // Remove files 
    if (is_numeric($vars['link_id']))
    {
	    if ($files = $db->get_results($sql = "SELECT * FROM ".table_prefix."files WHERE file_link_id='{$vars['link_id']}'"))
	    	foreach ($files as $row)
		{
	    	    if ($row->file_size=='orig')
			    @unlink("$upload_dir/{$row->file_name}");
		    else
			    @unlink("$thumb_dir/{$row->file_name}");
		}
	    $db->query("DELETE FROM ".table_prefix."files WHERE file_link_id='{$vars['link_id']}'"); 
    }
}
?>