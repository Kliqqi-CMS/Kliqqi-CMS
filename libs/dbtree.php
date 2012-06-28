<?php

if(!defined('mnminclude')){header('Location: ../404error.php');die();}

// taken from http://www.sitepoint.com/article/hierarchical-data-database and modified
function rebuild_tree($parent, $left, $table, $key_name, $parent_name) {
	global $db;
	if (!is_numeric($parent)) die();

	// the right value of this node is the left value + 1
	$right = $left+1;

	// get all children of this node
	$sql = 'SELECT * FROM `'.$table.'` WHERE `'.$parent_name.'`='.$parent.' and category_enabled = 1 ORDER BY category_order;';
	$result = $db->get_results($sql);

	if($result){
		foreach ($result as $row){
			// recursive execution of this function for each
			// child of this node
			// $right is the current right value, which is
			// incremented by the rebuild_tree function
			$right = rebuild_tree($row->$key_name, $right, $table, $key_name, $parent_name);
		}
	}

	// we've got the left value, and now that we've processed
	// the children of this node we also know the right value
	$db->query('UPDATE `'.$table.'` SET lft='.$left.', rgt='.$right.' WHERE `'.$key_name.'`='.$parent.';');

	// return the right value of this node + 1
	return $right+1;
}

function children_id_to_array(&$child_array, $table, $parent) {
	global $db;
	if (!is_numeric($parent)) die();

	// retrieve all children of $parent
	$sql = 'SELECT category__auto_id FROM '.$table.' WHERE category_parent="'.$parent.'" and category__auto_id <> 0;';
	$result = $db->get_results($sql);

	if($result){
		foreach ($result as $row){
			$child_array[] = $row->category__auto_id;

			// call this function again to display this child's children
			children_id_to_array($child_array, $table, $row->category__auto_id);
		}
	}
}

function GetCatName($catid){
	global $db, $dblang, $the_cats;

	foreach($the_cats as $cat){
		if($cat->category_id == $catid && $cat->category_lang == $dblang)
		{
			$x = $cat->category_name;
		}
	}
	return $x;
}

function rebuild_the_tree(){
	rebuild_tree(0, 0, table_categories, "category__auto_id", "category_parent");
}

function GetLastCategoryOrder($catParentId){
	global $db;
	if (!is_numeric($catParentId)) die();
	
	$sql = "SELECT MAX(category_order) FROM ".table_categories." where category_parent = ".$catParentId.";";
	//echo $sql;
	$MaxOrder = $db->get_var($sql);
	//echo $MaxOrder;
	return $MaxOrder;
}

function get_cached_category_data($field, $value){
	global $cached_categories;

	foreach($cached_categories as $cat){
		if($cat->$field == $value)
		{ 
			return $cat;
		}
	}
}

function get_cached_between($lft, $rgt){
	global $cached_categories;
	$results = array();

	foreach($cached_categories as $cat){
		if($cat->lft >= $lft && $cat->rgt <= $rgt)
		{ 
			$results[] = $cat;
		}
	}
	return $results;
}


function tree_to_array($root, $table, $showRoot = TRUE) {
	// showRoot -- Do we want to include the "root" category named "all" in our results -- all subcats WILL appear regardless
	
	global $db, $cached_categories;
	$row = get_cached_category_data('category__auto_id', $root);
	if(!$row){
		$sqlfix = "UPDATE " . table_categories . " SET `category__auto_id` = '0' WHERE `category_name` = 'all' LIMIT 1;";
		$db->query($sqlfix);

		$cached_categories = loadCategoriesForCache();
		$row = get_cached_category_data('category__auto_id', $root);
		if(!$row){
			die('There is a problem with the categories table. Error CA:001.');
		}
	}
	$right = array();
	$left  = array();
	$result = get_cached_between($row->lft, $row->rgt);
	$i = 0;
	$lastspacer = 0;
	// added @ thanks to `parterburn` - http://www.pligg.com/forum/showthread.php?t=4888
	foreach($result as $row){
		if (count($right)>0) {
			// check if we should remove a node from the stack
			while ($right[count($right)-1]<$row->rgt) {
				array_pop($left);
				if (array_pop($right) == NULL) {
					break;  // We've reached the top of the category chain
				}
			}
		}

		$array[$i]['first'] = $row->lft-1 == $left[sizeof($left)-1];
		$array[$i]['last']  = $row->rgt+1 == $right[sizeof($right)-1];
		$array[$i]['principlecat'] = $row->rgt - $row->lft -1;
		$array[$i]['spacercount'] = count($right);
		$array[$i]['lastspacercount'] = $lastspacer;
		$array[$i]['spacerdiff'] = abs($lastspacer - count($right));
		$array[$i]['id'] = $row->category_id;
		$array[$i]['auto_id'] = $row->category__auto_id;
		$array[$i]['name'] = $row->category_name;
		$array[$i]['safename'] = $row->category_safe_name;
		$array[$i]['order'] = $row->category_order;
		$array[$i]['left'] = $row->lft;
		$array[$i]['right'] = $row->rgt;
		$array[$i]['leftrightdiff'] = $row->rgt - $row->lft;
		$array[$i]['authorlevel'] = $row->category_author_level;
		$array[$i]['authorgroup'] = $row->category_author_group;
		$array[$i]['votes'] = $row->category_votes;
		$array[$i]['karma'] = $row->category_karma;
		$array[$i]['description'] = $row->category_desc;
		$array[$i]['keywords'] = $row->category_keywords;
		if(isset($row->category_color)){$array[$i]['color'] = $row->category_color;}
		if(isset($row->category_parent)){
			$array[$i]['parent'] = $row->category_parent;
			$array[$i]['parent_name'] = GetCatName($row->category_parent);
			$array[$i]['parent_subcat_count'] = GetSubCatCount($row->category_parent);
		}
		$array[$i]['subcat_count'] = GetSubCatCount($row->category__auto_id);
		$lastspacer = count($right);
		$right[] = $row->rgt;
		$left[] = $row->lft;
		if($array[$i]['leftrightdiff'] != 1)
		{
			for($j=0;$j<=$array[$i]['leftrightdiff'];$j++) 
			{
				$array[$i]['subcatalign'] = 1;
			}
		}
		$i++;
	}
	if($showRoot == FALSE){array_splice($array, 0, 1);}
	return $array;
}

function GetSubCatCount($catid){
	global $db, $the_cats;

	$count = 0;

	foreach($the_cats as $cat){
		if(isset($cat->category_parent)){
			if($cat->category_parent == $catid && $cat->category__auto_id <> 0 && $cat->category_lang == $dblang)
			{ 
				$count = $count + 1;
			}
		}
	}

	return $count;
}

function OrderNew(){
	global $db;
	$cateogories = $db->get_results("SELECT * FROM ".table_categories.";");
	if ($cateogories) {
		foreach($cateogories as $category) {
			$sub_cateogories = $db->get_results("SELECT * FROM ".table_categories." where category_parent = ".$category->category__auto_id." and category_order = 0 AND category__auto_id<>0;");
			if ($sub_cateogories) {
				if(count($sub_cateogories) > 1){
					$OrderNum = GetLastCategoryOrder($category->category__auto_id);
					foreach($sub_cateogories as $sub_category) {
						$OrderNum = $OrderNum + 1;
						//echo $sub_category->category_name.'-'.$sub_category->category_order."<BR>";
						$sql = "Update ".table_categories." set category_order = " . $OrderNum . " where category__auto_id = ".$sub_category->category__auto_id.";";
						//echo $sql . "<BR>";
						$db->query($sql);
					}
					//echo "<hr>";
				}
			}
		}
	}
}

// function Cat_Safe_Names has been moved to admin_categories.php

?>
