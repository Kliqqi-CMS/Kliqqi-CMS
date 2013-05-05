{php}
	global $db;
	//print_r($this->_vars);

	$upload_link = get_misc_data('upload_link');
	$upload_defsize = get_misc_data('upload_defsize');
	$alternates = unserialize(base64_decode(get_misc_data('upload_alternates')));
	$this->_vars['upload_directory'] = $upload_directory = get_misc_data('upload_directory');
	$this->_vars['upload_thdirectory'] = $upload_thdirectory = get_misc_data('upload_thdirectory');
	$this->_vars['upload_thumb_format'] = get_misc_data('upload_thumb_format');

	$sql = "SELECT a.*, b.file_fields AS `fields`, IF(LEFT(b.file_name,4)='http',b.file_name,CONCAT('$upload_directory/',b.file_name)) AS link_name 
			FROM " . table_prefix . "files a 
			LEFT JOIN " . table_prefix . "files b ON a.file_orig_id=b.file_id 
			WHERE a.file_link_id='{$this->_vars['link_id']}' AND a.file_size='$upload_defsize' 
			ORDER BY file_number";

	$images = $db->get_results($sql,ARRAY_A);
	if($images)
	{
		for ($i=0; $i<sizeof($images); $i++)
		    if ($images[$i]['file_fields'])
		    	$images[$i]['fields'] = unserialize(base64_decode($images[$i]['file_fields']));
		    else
		    	$images[$i]['fields'] = unserialize(base64_decode($images[$i]['fields']));
		$this->_vars['images'] = $images;
	}
{/php}

{if sizeof($images)}
	{foreach from=$images item=image}
		<media:content url="{$my_pligg_base}{$upload_directory}/{$image.file_name}" medium="image" />
	{/foreach}
{/if}