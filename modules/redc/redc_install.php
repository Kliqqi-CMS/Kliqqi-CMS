<?php
	$module_info['name'] = 'Registration Email Domain Check';
	$module_info['desc'] = 'Admins set up a whitelist or blacklist for allowed or forbidden email address domains during registration.';
	$module_info['version'] = 1.0;
//	$module_info['update_url'] = 'http://forums.pligg.com/versioncheck.php?product=redc';
//	$module_info['homepage_url'] = 'http://www.pligg.com/pro/catalog/modules/redc.html';
	$module_info['settings_url'] = '../module.php?module=redc';
	// this is where you set the modules "name" and "version" that is required
	// if more that one module is required then just make a copy of that line

	global $db;
	if (get_misc_data('redc_white_black')=='')
		{misc_data_update('redc_white_black', 'black');}
	if (get_misc_data('redc_list')=='')
	{
		misc_data_update('redc_list', '@10minutemail.com
@mailinator.com
@pjjkp.com
@mailmetrash.com
@trashymail.com
@mt2009.com
@thankyou2010.com
@mytrashmail.com
.mailexpire.com
@dodgit.com
.OnLateDOTcom3.info
.OnLateDOTcom1.info
.trillianpro.com
@reinvestmentclub.net
.freehost2005.info
.irishspringrealty.com
.lifebeginsatconception.info
@jetable.org
@spamgourmet.com
@spamex.com
@dingbone.com
@fidgerub.com
@beefmilk.com
@lookugly.com
@smellfear.com
@fatflap.com
@tempinbox.com
@spam.la
@tempomail.fr
@spamspot.com
@despam.it
.e4ward.com
@myspacee.info
@buyviagracanada.com
@tavla44.com
@pfsquad.nu
@guitarplayerworld.com
@theonlineblogspot.com
@bloglory.com
@163.com
@sify.com
@stampfreemail.com
@mailmenow.info
@asiabookings.net
@guerrillamail.com
@guerrillamailblock.com');
	}
	
?>