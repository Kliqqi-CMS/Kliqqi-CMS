<div class="instructions">
<h3>
	<?php echo $lang['WelcomeToInstaller']; ?>
</h3>
<p>
	<?php echo $lang['WelcomeToThe']; ?> 
</p>
<p>
	<?php echo $lang['Bugs']; ?>
</p>
<br />
<h3>
	<?php echo $lang['Installation']; ?>
</h3>
<p>
	<?php echo $lang['OnceFamiliar']; ?>
</p>
<form id="form2" name="form2" method="post" action="install.php">
	<input type="hidden" name="step" value="2">
	<input type="hidden" name="language" value="<?php echo addslashes(strip_tags($_REQUEST['language'])); ?>">
	<input type="submit" name="Submit" class="submitbutton" value="<?php echo $lang['Next']; ?>" />
</form>
</div>