<?php 
/* This file checks if the installation file still exists. If so, you will be presented with a message telling you to remove it from your server. */

$install = '../install/install.php';

if (file_exists($install)) {
    echo '<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="Robots" content="none" />
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.no-icons.min.css" rel="stylesheet">
	<link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="../templates/admin/css/style.css" media="screen" />
	<style type="text/css">
	body {
		padding-top: 30px;
		position: relative;
		background-color: #fff;
		background-image: url(../templates/admin/img/grid-18px-masked.png);
		background-repeat: repeat-x;
		background-position: 0 0px;
	}
	.navbar-fixed-top, .navbar-fixed-bottom {
		position:absolute;
	}
	.navbar .nav > li > a {
		padding-top:11px;
	}
	</style>
	<title>Warning! Installation Files Detected</title>
</head>
	<body>
		<div class="container">
			<section id="maincontent">
				<div class="row">
					<div class="col-md-12">
						<div class="well install_warning">
							<h2>Warning!</h2>
							<p>The file ../install/install.php still exists on your server! 
								<br />For security reasons, you need to <strong>remove the /install/ directory</strong> from your server immediately after you have completed an installation or upgrade of your website.
							</p>
							<p>To temporarily ignore this error and continue to the Admin Panel <a href="./admin_index.php">Click Here</a></p>
						</div>
					</div>
				</div><!--/.row-->
			</section><!--/#maincontent-->
		</div><!--/.container-->
	</body>
</html>';
} else {
    header('Location: admin_index.php');
}

?>