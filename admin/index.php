<?php 

$install = '../install/install.php';

if (file_exists($install)) {
    echo "<html><head><style type='text/css'>body {background-color:#FFFDDD;}</style></head><body><div style='margin:0 auto;position:relative;text-align:center;font-size:16px;padding:10px 10px 40px 10px;margin-top:60px;width:28em;background:#fff;border:1px solid #000;border-top-color:#bbb;border-left-color:#bbb;'><h2>Warning!</h2><p>The file install.php currently exists in the /install/ directory of your website.<br />Please <strong>remove the /install/ directory</strong> if you have completed an installation or upgrade to your site.</p><p>To temporarily ignore this error and continue to the admin panel<br /><a href='./admin_index.php'>Click Here</a></p></div></body>";
} else {
    header('Location: admin_index.php');
}

?>
