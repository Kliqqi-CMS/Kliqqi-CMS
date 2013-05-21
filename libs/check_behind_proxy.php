<?php

if(!defined('mnminclude')){header('Location: ../error_404.php');die();}

function isIPIn($ip,$net,$mask) {
	$lnet=ip2long($net);
	$lip=ip2long($ip);
	$binnet=str_pad( decbin($lnet),32,"0",STR_PAD_LEFT );
	$firstpart=substr($binnet,0,$mask);
	$binip=str_pad( decbin($lip),32,"0",STR_PAD_LEFT );
	$firstip=substr($binip,0,$mask);
	return(strcmp($firstpart,$firstip)==0);
}


function isPrivateIP($ip) {
	$privates = array ("127.0.0.0/24", "10.0.0.0/8", "172.16.0.0/12", "192.168.0.0/16");
	foreach ( $privates as $k ) {
			list($net,$mask)=preg_split("/",$k);
			if (isIPIn($ip,$net,$mask)) {
					return true;
			}
	}
	return false;
}

function check_ip_behind_proxy() {

	if (!empty($_SERVER["HTTP_X_FORWARDED_FOR"])) {
		$user_ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
	} else if (!empty($_SERVER["HTTP_CLIENT_IP"])) {
		$user_ip = $_SERVER["HTTP_CLIENT_IP"];
	} else {
		return $_SERVER["REMOTE_ADDR"];
	}

	$ips = preg_split('/[, ]/', $user_ip);
	foreach ($ips as $ip) {
		if (preg_match('/^(\d{1,3}\.){3}\d{1,3}$/s', $ip)
			&& !isPrivateIP($ip) ) {
			return $ip;
		}
	}

	return $_SERVER["REMOTE_ADDR"];
}
?>