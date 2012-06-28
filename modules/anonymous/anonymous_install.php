<?php	
	$module_info['name'] = 'Anonymous Mode';
	$module_info['desc'] = 'Required to activate Anonymous comments or story';
	$module_info['version'] = 0.1;
	
	$module_info['db_sql'][] = "INSERT INTO ".table_users." (user_login,user_level,user_modification,user_date,user_pass,user_email,user_lastlogin) VALUES ('anonymous','normal',NOW(),NOW(),'1e41c3f5a260b83dd316809b221f581cdbba8c1489e6d5896', 'anonymous@pligg.com',NOW())";
?>