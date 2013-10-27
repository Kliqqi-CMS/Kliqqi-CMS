<?php 
if(!defined('mnminclude')){
	header('Location: ../error_404.php');
	die();
}

// after your Pligg is installed, change this to false
$do_check = true;

if($do_check == true){
	if (strpos($_SERVER['SCRIPT_NAME'], "install.php") == 0){
		$errors = array();
		$file = dirname(__FILE__) . '/../settings.php'; 
		if (!file_exists($file)) { $errors[]="<strong>/settings.php was not found!</strong><br /> Try renaming 'settings.php.default' to 'settings.php'"; }
		elseif (filesize($file) <= 0) { $errors[]="/settings.php is 0 bytes!"; }

		$file = dirname(__FILE__) . '/../libs/dbconnect.php'; 
		if (!file_exists($file)) { $errors[]="<strong>/libs/dbconnect.php was not found!</strong><br />Try renaming '/libs/dbconnect.php.default' to '/libs/dbconnect.php'"; }

		$file= dirname(__FILE__) . '/../cache'; 
		if (!file_exists($file)) { $errors[]="<strong>/cache/ was not found!</strong> Create a directory called cache in your root directory and CHMOD it to 777."; }
		elseif (!is_writable($file)) { $errors[]="<strong>/cache/ is not writable!</strong><br />Please CHMOD this directory to 777"; }

		if (sizeof($errors)) {	
			$output = '';
			echo '<!DOCTYPE html>
				<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
				<head>
					<meta name="viewport" content="width=device-width, initial-scale=1.0" />
					<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
					<link rel="stylesheet" type="text/css" href="./templates/admin/css/bootstrap.no-icons.min.css" media="screen" />
					<link rel="stylesheet" type="text/css" href="./templates/admin/css/font-awesome.min.css">
					<link rel="stylesheet" type="text/css" href="./templates/admin/css/style.css" media="screen" />
					<style type="text/css">
					body {
						padding-top: 40px;
						position: relative;
						background-color: #fff;
						background-image: url(./templates/admin/img/grid-18px-masked.png);
						background-repeat: repeat-x;
					}
					.navbar-fixed-top, .navbar-fixed-bottom {
						position:absolute;
					}
					.navbar .nav > li > a {
						padding-top:11px;
					}
					</style>
					<title>Error!</title>
				</head>
				<body>
					<div class="container">
						<section id="maincontent">
							<div class="row">
								<div class="col-md-12">
									<legend>Error Loading Site!</legend>
									<p>Have you installed your website yet? Please fix the errors below and proceed to the <a href="./readme.html">Pligg Readme</a> or the <a href="./install/">Pligg Installation</a> which will attempt to rename the .default files for you.</p>
									';
									foreach ($errors as $error) {
										echo "<div class='alert alert-info'>";
										echo "$error \n";
										echo "</div>";
									}
									echo '<div class="alert alert-danger">Please fix the above error(s) before proceeding to the installation page.</div>';
								echo '
								</div>
							</div><!--/.row-->
						</section><!--/#maincontent-->
					</div><!--/.container-->
					<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
					<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js"></script>
					<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/themes/smoothness/jquery-ui.css" media="all" rel="stylesheet" type="text/css" />
					<!--[if lt IE 7]>
					<script type="text/javascript" src="./templates/admin/js/jquery/jquery.dropdown.js"></script>
					<![endif]-->
					<script type="text/javascript" src="./templates/admin/js/bootstrap.min.js"></script>
				</body>
				</html>';
			die;
		}
	}
}
?>