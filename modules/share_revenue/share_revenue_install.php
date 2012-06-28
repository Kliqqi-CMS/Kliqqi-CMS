<?php

	$module_info['name'] = 'Google Adsense Revenue Sharing';

	$module_info['desc'] = 'Allows you to share your adsense revenue with contributors';

	$module_info['version'] = 0.3;

	$module_info['requires'][] = array('users_extra_fields', 0.1);

	$module_info['db_add_field'][]=array('users', 'google_adsense_id', 'VARCHAR',  64, '', 0, '');

	$module_info['db_add_field'][]=array('users', 'google_adsense_channel', 'VARCHAR',  64, '', 0, '');

	$module_info['db_add_field'][]=array('users', 'google_adsense_percent', 'TINYINT',  3, "UNSIGNED", 0, '50');

?>

