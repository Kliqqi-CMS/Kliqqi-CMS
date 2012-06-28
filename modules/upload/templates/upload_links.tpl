   {checkActionsTpl location="tpl_pligg_module_upload_start"}
{config_load file=upload_lang_conf}

{php}
	global $db;

	$alternates = unserialize(base64_decode(get_misc_data('upload_alternates')));
	$this->_vars['upload_directory'] = $upload_directory = get_misc_data('upload_directory');
	$this->_vars['upload_format'] = get_misc_data('upload_format');
	$this->_vars['upload_pre_format'] = get_misc_data('upload_pre_format');
	$this->_vars['upload_post_format'] = get_misc_data('upload_post_format');
        $sql = "SELECT * FROM " . table_prefix . "files where file_link_id='{$this->_vars['link_id']}' AND file_size='orig' ".(get_misc_data('upload_allow_hide') ? ' AND !file_hide_file' : '');
	$images = $db->get_results($sql,ARRAY_A);
	if($images)
	{
		for ($i=0; $i<sizeof($images); $i++)
		{
		    $pathinfo = pathinfo($images[$i]['file_name']);
		    $images[$i]['file_ext'] = strtolower($pathinfo['extension']);
		    $images[$i]['fields'] = unserialize(base64_decode($images[$i]['file_fields']));
		}
		$this->_vars['images'] = $images;
	}
{/php}                                                          

{if sizeof($images)}<h3>{#PLIGG_Upload_Attached#}</h3>
{$upload_pre_format}
{foreach from=$images item=image}

    {if $image.file_ext=='txt'}<!-- Text file -->
    {elseif $image.file_ext=='zip'}<!-- ZIP file -->
    {/if}

    {if $upload_format}
	{php}
		$format = $this->_vars['upload_format'];
		$image  = $this->_vars['image'];
		if (strpos($image['file_name'],'http')===0)
		    $format = str_replace('{path}',$image['file_name'],$format);
		else
		    $format = str_replace('{path}',my_pligg_base."$upload_directory/{$image['file_name']}",$format);
	    	if (preg_match_all('/\{field(\d+)\}/s',$format,$m))
    		for ($i=0; $i<sizeof($m[1]); $i++)
    		{
			$field = $m[1][$i];
			$format = str_replace('{field'.$field.'}',$image['fields']['field'.$field] ? $image['fields']['field'.$field] : $alternates[$field],$format);
    		}
		echo $format;
	{/php}
    {else}
	{if strpos($image.file_name,'http')===0}
		<a href='{$image.file_name}'>{$image.file_name}</a>
	{else}
		<a href='{$my_pligg_base}{$upload_directory}/{$image.file_name}'>{$image.file_name}</a>
	{/if}
    {/if}
    <br>
{/foreach}
{$upload_post_format}
{/if}

{config_load file=upload_pligg_lang_conf}
{checkActionsTpl location="tpl_pligg_module_upload_end"}