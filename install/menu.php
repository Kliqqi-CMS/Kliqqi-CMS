<div id="header">
	<div class="logo"><img src="../templates/admin/images/logo.gif" alt="Pligg CMS" title="Pligg CMS"/></div>
	<div id="head-nav">
		<ul class="nav-menu">
			<li><a href="../readme.html"class="nav" title="<?php echo $lang['Readme'] ?>"><?php echo $lang['Readme'] ?></a></li>
			<li><a href="./install.php" <?php if ($page == 'install'):?>class="navcur"<?php endif; ?> class="nav" title="<?php echo $lang['Install'] ?>"><?php echo $lang['Install'] ?></a></li>
			<li><a href="./upgrade.php" <?php if ($page == 'upgrade'):?>class="navcur"<?php endif; ?> class="nav" title="<?php echo $lang['Upgrade'] ?>"><?php echo $lang['Upgrade'] ?></a></li>
			<li><a href="./troubleshooter.php" <?php if ($page == 'troubleshooter'):?>class="navcur"<?php endif; ?> class="nav" title="<?php echo $lang['Troubleshooter'] ?>"><?php echo $lang['Troubleshooter'] ?></a></li>
			<li><a href="../admin/" class="nav" title="<?php echo $lang['Admin'] ?>"><?php echo $lang['Admin'] ?></a></li>
			<li><a href="../" class="nav" title="<?php echo $lang['Home'] ?>"><?php echo $lang['Home'] ?></a></li>
		</ul>
		<div id="navbar">
			<?php if ($page == 'install'): echo $lang['Install_instruct']; endif; ?>
			<?php if ($page == 'upgrade'): echo $lang['Upgrade_instruct']; endif; ?>
			<?php if ($page == 'troubleshooter'): echo $lang['Troubleshooter_instruct']; endif; ?>
		</div>
	</div>
	</div>
<div style="clear:both;"></div>
