<div class="navbar navbar-fixed-top">
	<div class="navbar-inner">
		<div class="container">
			<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</a>
			<a class="brand" href="http://pligg.com/"><img src="../templates/admin/img/pligg.png" height="20px;" alt="Pligg CMS" title="Pligg CMS"/></a>
			<div class="nav-collapse">
				<ul class="nav">
					<li><a href="../" title="<?php echo $lang['Home'] ?>"><?php echo $lang['Home'] ?></a></li>
					<li><a href="../readme.html" title="<?php echo $lang['Readme'] ?>"><?php echo $lang['Readme'] ?></a></li>
					<li <?php if ($page == 'install'):?>class="active current" <?php endif ?>><a href="./install.php" <?php if ($page == 'install'):?>class="navcur"<?php endif; ?> title="<?php echo $lang['Install'] ?>"><?php echo $lang['Install'] ?></a></li>
					<li <?php if ($page == 'upgrade'):?>class="active current" <?php endif ?>><a href="./upgrade.php" <?php if ($page == 'upgrade'):?>class="navcur"<?php endif; ?> title="<?php echo $lang['Upgrade'] ?>"><?php echo $lang['Upgrade'] ?></a></li>
					<li <?php if ($page == 'troubleshooter'):?>class="active current" <?php endif ?>><a href="./troubleshooter.php" <?php if ($page == 'troubleshooter'):?>class="navcur"<?php endif; ?> title="<?php echo $lang['Troubleshooter'] ?>"><?php echo $lang['Troubleshooter'] ?></a></li>
					<li><a href="../admin/" title="<?php echo $lang['Admin'] ?>"><?php echo $lang['Admin'] ?></a></li>
				</ul><!--/.nav -->
			</div><!--/.nav-collapse -->
		</div><!--/.container -->
	</div><!--/.navbar-inner -->
</div><!--/.navbar -->
