<?php 
// Pligg latest version check
$url = "http://pligg.com/pliggversion.php";
$external_version = @file_get_contents($url);

$language_default = '../languages/lang_english.conf.default';

if (file_exists($language_default)) {
    // Local latest version check
	$data = file_get_contents($language_default);
	$regex = '/<VERSION>(.+?)<\/VERSION>/';
	preg_match($regex,$data,$match);
	//var_dump($match);
	$local_version = $match[1];
} else {
    // The default language file does not exist. Let's just say it's the same version
	$local_version = $external_version;
}

?>

<div class="instructions">
	<div class="hero-unit" style="padding:16px 25px;">
		<h2><?php echo $lang['WelcomeToInstaller']; ?></h2>
		<p style="font-size:1.3em;">
			<?php echo $lang['WelcomeToThe']; ?>
		</p>
		<p style="text-align:right;font-size:1.1em;font-style:italic;">Eric Heikkinen | Pligg Founder</p>
	</div>
	<?php
	if (version_compare($external_version, $local_version, '<=')) {
		// You're up to date
	}else{
		echo '	<div class="alert"><button class="close" data-dismiss="alert">&times;</button>';				
		echo $lang['VersionCheckOld'];
		echo '	</div>';
	}
	?>
	<p><?php echo $lang['Bugs']; ?></p>
	<br />
	<h3><?php echo $lang['Installation']; ?></h3>
	<p><?php echo $lang['OnceFamiliar']; ?></p>
	<form id="form2" name="form2" method="post" action="install.php">
		<input type="hidden" name="step" value="2">
		<input type="hidden" name="language" value="<?php echo addslashes(strip_tags($_REQUEST['language'])); ?>">
		<input type="submit" name="Submit" class="btn btn-primary" value="<?php echo $lang['Next']; ?>" />
	</form>
</div>