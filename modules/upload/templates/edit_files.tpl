{config_load file=upload_lang_conf}

<h3>{#PLIGG_Upload_Attached#}</h3>

{php}
	global $db;

	$upload_defsize = get_misc_data('upload_defsize');
	$upload_directory = get_misc_data('upload_directory');
	$upload_thdirectory = get_misc_data('upload_thdirectory');
	$images = $db->get_results($sql = "SELECT * from " . table_prefix . "files where file_link_id='{$this->_vars['submit_id']}' AND file_size='orig'");
	if($images)
	{
	    print "<b>".$this->get_config_vars('PLIGG_Upload_Delete')."</b><br>";
	    foreach($images as $image) 
	    {
	    	print "<input type='checkbox' name='upload_delete[]' value='{$image->file_id}'>";
		if (strpos($image->file_name,'http')===0)
		    print "<a href='{$image->file_name}'/>{$image->file_name}</a><br>";
		else
		    print "<a href='".my_pligg_base."$upload_directory/{$image->file_name}'>{$image->file_name}</a><br>";
	    }
	}
	$this->_vars['upload_maxnumber']-=sizeof($images);
{/php}                                                          

({$upload_extensions} {#PLIGG_Upload_Extensions_Allowed#})<br>

{section name=files start=0 loop=$upload_maxnumber step=1}
    {#PLIGG_Upload_Upload#}: <input type='file' name='upload_files[]'>
    {if $upload_external}
	OR Link: <input type='text' name='upload_urls[]' value='http://'>
    {/if}
    <br>
{/section}

{config_load file=upload_pligg_lang_conf}
