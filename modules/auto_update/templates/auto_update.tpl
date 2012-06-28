{config_load file=auto_update_lang_conf}

{php}
list($yourversion,$latestversion) = auto_update_detect_version();

// Uncomment the next line to test the alert message
//$yourversion = '0.0.1';
global $my_pligg_base;

if ($yourversion < $latestversion) {
print('<div style="background:#f0f0f0;border-top:1px solid #fff;border-bottom:1px solid #a0a0a0;float:left;height:25px;left:0;position:absolute;top:0;width:100%;">
	<div style="margin:0 auto;padding:5px 10px;color:#000;">
		<img src="'.$my_pligg_base.'/modules/auto_update/images/error.gif" width="16px" height="16px" style="float:left;position:relative;top:-1px;width:16px;height:16px;margin:0 8px 0 0;" />
		<h2 style="font-size:12px;font-weight:300;">'.$this->_confs['AUTO_UPDATE_NEW_VERSION_AVAILABLE'].' 
		 <a style="color:#1e517c;text-decoration:underline;font-size:12px;font-weight:600;" href="'.$my_pligg_base.'/module.php?module=auto_update">'.$this->_confs['AUTO_UPDATE_NEW_VERSION_UPGRADE'] .' '.$latestversion.'</a></h2>
	</div>
</div>');
}

{/php}

{config_load file=auto_update_pligg_lang_conf}