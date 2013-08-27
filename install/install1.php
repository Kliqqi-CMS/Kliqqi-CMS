<div class="instructions">
	<div class="jumbotron" style="padding:6px 25px 16px 25px;">
		<h2><?php echo $lang['WelcomeToInstaller']; ?></h2>
		<p style="font-size:0.8em;">
			<?php echo $lang['WelcomeToThe']; ?>
		</p>
	</div>
	<p><?php echo $lang['Bugs']; ?></p>
	<hr />
	<h3><?php echo $lang['Installation']; ?></h3>
	<p><?php echo $lang['OnceFamiliar']; ?></p>
	<form id="form2" name="form2" method="post" action="install.php">
		<input type="hidden" name="step" value="2">
		<input type="hidden" name="language" value="<?php echo addslashes(strip_tags($_REQUEST['language'])); ?>">
		<input type="submit" name="Submit" class="btn btn-primary" value="<?php echo $lang['Next']; ?>" />
	</form>
</div>