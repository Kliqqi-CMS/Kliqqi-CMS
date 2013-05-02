<?php
/**
 * Pseudo-Array of lines from all language files (main file + installed modules)
 */
class LangFiles implements Iterator {
    /**
     * @var integer Current line number in current file
     */
    protected $position = 0;
    /**
     * @var integer Current file number
     */
    protected $fileno = 0;
    /**
     * @var array (Filename => Module name) array
     */
    protected $files;

    /**
     * Initialize file list
     */ 
    public function __construct() {
	global $db;

	// Main language file
	$this->files = array(mnmpath.'/languages/lang_'.pligg_language.'.conf' => '');

   	// Fill files array from installed modules
	$modules = $db->get_results('SELECT * from ' . table_modules . ' order by weight asc;');
	foreach ($modules as $module) {
	    if (file_exists(mnmmodules.$module->folder.'/lang_'.pligg_language.'.conf'))
		$this->files[mnmmodules.$module->folder.'/lang_'.pligg_language.'.conf'] = $module->name;
	    elseif (file_exists(mnmmodules.$module->folder.'/lang.conf'))
		$this->files[mnmmodules.$module->folder.'/lang.conf'] = $module->name;
	}
    }

    /**
     * Return module name by language file path
     *
     * @param string $file Full path to language file
     * @return string Module name
     */
    function getName($file) {
	return $this->files[$file];
    }

    /**
     * Replace given line in given file
     *
     * @param string $id Pligg language constant
     * @param string $value New value to save
     * @param string $file Full path to language file
     * @return string Error or empty on success
     */
    function set($id, $value, $filename) {
	if (!isset($this->files[$filename]))
	    return "Wrong file $filename";

	$ret = "$id not found in $filename";
	$lines = file($filename);
	if ($handle = fopen($filename, 'w')) {
	    foreach ($lines as $line) {	
		if (preg_match("/^$id\s*=/", $line, $m)) {
			$line = $id . ' = "' . $value . '"' . "\n";
			$ret = '';
		}

		if (!fwrite($handle, $line)) 
			$ret = "Could not write to '$filename' file";
	    }
	    fclose($handle);
	} else 
		$ret = "Could not open '$filename' file for writing";

	return $ret;
    }

    /**
     * Iterator methods
     *
     * @see Iterator
     */ 
    function rewind() {
        $this->position = 0;
	$this->fileno   = 0;
	$keys = array_keys($this->files);
	$this->lines = file($keys[0]);
    }

    function current() {
        return $this->lines[$this->position];
    }

    function key() {
	$keys = array_keys($this->files);
        return $keys[$this->fileno].'#'.$this->position;
    }

    function next() {
        ++$this->position;
    }

    function valid() {
	$keys = array_keys($this->files);
	if (!isset($this->lines[$this->position])) {
	    $this->lines = @file($keys[++$this->fileno]);
	    $this->position = 0;
	}

        return isset($keys[$this->fileno]);
    }
}

function admin_language_showpage(){
	global $main_smarty, $the_template;
		
	include_once('config.php');
	include_once(mnminclude.'html1.php');
	include_once(mnminclude.'link.php');
	include_once(mnminclude.'tags.php');
	include_once(mnminclude.'smartyvariables.php');
	
	$main_smarty = do_sidebar($main_smarty);

	force_authentication();
	$canIhaveAccess = 0;
	$canIhaveAccess = $canIhaveAccess + checklevel('admin');
	
	if($canIhaveAccess == 1)
	{	
		// Lines from all language files
		$files = new LangFiles();

		// Update a line
		if($_GET["mode"] == "save") {
#echo "ankan";
			if ($error = $files->set($_REQUEST['edit'], js_urldecode($_REQUEST['newvalue']), $_REQUEST['file']))
				echo "<strong>$error</strong>";
		// Display the list of all lines
		} else {
		    $lines = array();
		    $oldmodule = '';
		    // All lines from all files here
		    foreach ($files as $lnum => $line) {
			$l = array();

			// Extract filename 
			list($file, $pos) = explode('#', $lnum);
			$l['file'] = $file;

			// Add SECTION line for a new module
			if ($files->getName($file) != $oldmodule) {
			    $l['section'] = $oldmodule = $files->getName($file);
			    $lines[] = $l;
			    unset($l['section']);
			}

			// Commented lines (auxiliary info)
			if(substr($line, 0, 2) == "//")	{
			    if (preg_match('/<TITLE>(.+)<\/TITLE>/', $line, $m))
				$l['title'] = $m[1];
			    elseif (preg_match('/<SECTION>(.+)<\/SECTION>/', $line, $m))
				$l['section'] = $m[1];
// DB 05/01/13 Seems not used
//			    elseif (preg_match('/<LANG>(.+)<\/LANG>/', $line, $m))
//				$l['lang'] = $m[1];
//                	    elseif (preg_match('/<VERSION>(.+)<\/VERSION>/', $line, $m))
//				$l['version'] = $m[1];
//			    elseif (preg_match('/<ADDED>(.+)<\/ADDED>/', $line, $m))
//				$l['added'] = $m[1]*1;
/////
			    else
				continue;
			} elseif (strlen(trim($line)) > 2) {
			    if (preg_match('/^([^=]+)\s*=\s*"?(.+)"?$/', trim($line), $m)) {
                		$l['id'] = trim($m[1]);
				$l['value'] = htmlspecialchars(str_replace('"', '', trim($m[2])));
				if (function_exists("iconv") && detect_encoding($l['value'])!='utf-8')
		    		    $l['value'] = iconv('','UTF-8//IGNORE', $l['value']);
			    } else
				$l['error'] = "Can't parse $line";
			}
			// Skip empty lines
			else
			    continue;

			$lines[] = $l;
                    }
		    $main_smarty->assign('lines', $lines);

		// breadcrumbs
			$navwhere['text1'] = $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel');
			$navwhere['link1'] = getmyurl('admin', '');
			$navwhere['text2'] = "Modify Language";
			$navwhere['link2'] = my_pligg_base . "/module.php?module=admin_language";
			$main_smarty->assign('navbar_where', $navwhere);
			$main_smarty->assign('posttitle', " | " . $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel'));
		// breadcrumbs

			//Method for identifying modules rather than pagename
			define('modulename', 'admin_language'); 
			$main_smarty->assign('modulename', modulename);
			
			define('pagename', 'admin_modifylanguage'); 
			$main_smarty->assign('pagename', pagename);
			
		    	$main_smarty->assign('editinplace_init', $editinplace_init);

			$main_smarty->assign('tpl_center', admin_language_tpl_path . 'admin_language_main');
			$main_smarty->display($template_dir . '/admin/admin.tpl');
		}
	}
	else
		header("Location: " . getmyurl('login', $_SERVER['REQUEST_URI']));
}	
?>