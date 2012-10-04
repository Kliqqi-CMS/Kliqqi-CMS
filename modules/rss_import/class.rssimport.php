<?php
// The source code packaged with this file is Free Software, Copyright (C) 2005 by 	 
// The Pligg Team <pligger at pligg dot com>. 	 
// It's licensed under the AFFERO GENERAL PUBLIC LICENSE unless stated otherwise. 	 
// You can get copies of the licenses here: 	 
//              http://www.affero.org/oagpl.html 	 
// AFFERO GENERAL PUBLIC LICENSE is also included in the file called "COPYING".


// TODO

// when adding a new feed and you edit the url first, it doesnt save
// when deleting a feed, need to first drop_all_links for that feed and also import data



class RSSImport {

	var $FeedName = "";
	var $FeedURL = "";
	var $FeedId = 0;
	
	var $FeedLinkId = 0;
	var $FeedLinkField = "";
	var $FeedLinkPligg = "";

	function read_feed(){
		global $db;
		$sql = "SELECT * FROM " . table_prefix . "feeds WHERE feed_id = $this->FeedId";
		//echo "<HR>" . $sql . "<HR>";
		$config = $db->get_row($sql);

			$this->FeedName=$config->feed_name;
			$this->FeedURL=$config->feed_url;
			$this->FeedId=$config->feed_id;

		return true;
	}

	function drop_feed(){
		global $db;
		$sql = "Delete from " . table_prefix . "feeds where feed_id = ".$this->FeedId.";";
		$db->query($sql);
		
		$sql = "Delete from " . table_prefix . "feed_link where feed_id = ".$this->FeedId.";";
		$db->query($sql);
	}

	function new_feed(){
		global $db;
		$sql = "INSERT INTO " . table_prefix . "feeds (feed_name, feed_url) VALUES('".$this->FeedName."', '".$this->FeedURL."');";
		//echo "<HR>" . $sql . "<HR>";
		$db->query($sql);
	}

	function store_feed(){
		global $db;
		$sql = "UPDATE " . table_prefix . "feeds set feed_name = '".$this->FeedName."', feed_url = '".$this->FeedURL."' where feed_id = ".$this->FeedId.";";
		echo "<HR>" . $sql . "<HR>";
		$db->query($sql);
	}

	function get_feeds_lists(){
		global $db;
		$feeds_list = $db->get_results("select * from " . table_prefix . "feeds");
		return $feeds_list;
	}

	function get_feed_field_links($feed_id=0){
		global $db;
		if(!isset($feed_id)){$feed_id = $this->FeedId;}
		$sql = "select * from " . table_prefix . "feed_link where feed_id = " . $feed_id;
		//echo "<HR>" . $sql . "<HR>";
		$feed_field_links = $db->get_results($sql);
		return $feed_field_links;
	}
		

 //---------------------------------
 // For Feed_Links
 //---------------------------------
	
	function get_pligg_fields(){
		global $db;
		$sql = "select * from " . table_prefix . "feed_import_fields;";
		$pligg_fields = $db->get_results($sql);
		return $pligg_fields;
	}
	
	function EIP_Feed_Field_Select($feed_url=""){

		$rss = fetch_rss($feed_url);

		$x = sizeof($rss->items[1]);
		$z = $rss->items[0];

		$TheTextToReturn = "	options: {";
		
		$count = 0;
		foreach ($z as $item => $key) {
			if ($count < $x){
				//echo $item . "<BR>";
				
				if (is_array($z[$item])) {
					foreach ($z[$item] as $item2 => $key) {
						if($count > 0){$TheTextToReturn .= ", ";}
						$TheTextToReturn .= $item . "_ne_st_ed_" . $item2 . ": '" . $item . " : " . $item2 . "'";				
						$count = $count + 1;
					}				
				} else {				
					if($count > 0){$TheTextToReturn .= ", ";}
					$TheTextToReturn .= $item . ": '" . $item . "'";				
					$count = $count + 1;
				}
			}
		}
		$TheTextToReturn .= "}";
		
		return $TheTextToReturn;
		
	}


	function EIP_Pligg_Field_Select(){

		$Pligg_Fields = $this->get_pligg_fields();
		$TheTextToReturn = "	options: {";
		$Count = 0;
		if($Pligg_Fields){
			foreach ($Pligg_Fields as $Field) {

				if($count > 0){$TheTextToReturn .= ", ";}
				$TheTextToReturn .= $Field->field_name . ": '" . $Field->field_name . "'";				
				$count = $count + 1;
				
			}
		}
		
		$TheTextToReturn .= "}";
		
		return $TheTextToReturn;
		
	}

	function read_feed_link(){
		global $db;
		$sql = "SELECT * FROM " . table_prefix . "feed_link WHERE feed_link_id = $this->FeedLinkId";
		//echo "<HR>" . $sql . "<HR>";
		$config = $db->get_row($sql);

			$this->FeedLinkField=$config->feed_field;
			$this->FeedLinkPligg=$config->pligg_field;
			$this->FeedLinkId=$config->feed_link_id;
			$this->FeedId=$config->feed_id;

		return true;
	}

	function store_feed_link(){
		global $db;
		$sql = "UPDATE " . table_prefix . "feed_link set feed_id = '".$this->FeedId."', feed_field = '".$this->FeedLinkField."', pligg_field = '".$this->FeedLinkPligg."' where feed_link_id = ".$this->FeedLinkId.";";
		echo "<HR>" . $sql . "<HR>";
		$db->query($sql);
	}

	function new_field_link(){
		global $db;
		$sql = "INSERT INTO " . table_prefix . "feed_link (feed_id, feed_field, pligg_field) VALUES(".$this->FeedLinkId.", '".$this->FeedLinkField."', '".$this->FeedLinkPligg."');";
		echo "<HR>" . $sql . "<HR>";
		$db->query($sql);
	}

	function drop_field_link(){
		global $db;
		$sql = "Delete from " . table_prefix . "feed_link where feed_link_id = ".$this->FeedLinkId.";";
		//echo "<HR>" . $sql . "<HR>";
		$db->query($sql);
	}

}

?>
