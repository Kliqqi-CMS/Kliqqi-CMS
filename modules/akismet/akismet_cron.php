<?php
// The source code packaged with this file is Free Software, Copyright (C) 2005 by
// Ricardo Galli <gallir at uib dot es>.
// It's licensed under the AFFERO GENERAL PUBLIC LICENSE unless stated otherwise.
// You can get copies of the licenses here:
// 		http://www.affero.org/oagpl.html
// AFFERO GENERAL PUBLIC LICENSE is also included in the file called "COPYING".

include_once('Smarty.class.php');
$main_smarty = new Smarty;

include('config.php');
include(mnminclude.'html1.php');
include(mnminclude.'link.php');
include(mnminclude.'tags.php');
include(mnminclude.'search.php');
include(mnminclude.'smartyvariables.php');

$spam_links = get_misc_data('spam_links');
if($spam_links != ''){
	$spam_links = unserialize(get_misc_data('spam_links'));
} else {
	$spam_links = array();
}

//print_r($spam_links);

if(count($spam_links) > 0){
	foreach($spam_links as $link_id){

		$link = new Link;
		$link->id = $link_id;
		$link->read(FALSE);
		$link->status = 'discard';
		$link->store();
		echo 'Discarding link_id: ' . $link_id . '<br />';

	}
}


?>
