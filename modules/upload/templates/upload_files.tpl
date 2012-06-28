{* File upload fields for submit step 2 and edit link form *}

{config_load file=upload_lang_conf}

<h2>{#PLIGG_Upload_Attach#}</h2>
({$upload_extensions} {#PLIGG_Upload_Extensions_Allowed#})<br /><br />

<script>
var uploading = '<fieldset style="border:1px solid #eee;padding:10px;margin-bottom:10px;font-weight:bold;width:450px;"><h2>{#PLIGG_Upload_Uploading#}...</h2></fieldset>';
var failed = '<fieldset style="border:1px solid #eee;padding:10px;margin-bottom:10px;font-weight:bold;width:450px;"><h2>{#PLIGG_Upload_Failed#}...</h2></fieldset>';
var my_pligg_base = '{$my_pligg_base}';
var mandatory = '{#PLIGG_Upload_Mandatory_Error#}';
var choose_file = '{#PLIGG_Upload_Choose_File#}';
var choose_url = '{#PLIGG_Upload_Choose_URL#}';
</script>
<script src='{$my_pligg_base}/modules/upload/js/upload.js'></script>

{assign var="upload_fields" value='1'}

{section name=files start=0 loop=$upload_maxnumber step=1}
    {assign var="number" value=$templatelite.section.files.iteration}
    
    <div id='form_{$number}'
    {php}
	global $db;
	$upload_dir = mnmpath . get_misc_data('upload_directory');
	$this->_vars['file'] = '';
    	$images = $db->get_results($sql = "SELECT * from " . table_prefix . "files where file_link_id='{$this->_vars['submit_id']}' AND file_number='{$this->_vars['number']}' ORDER BY file_orig_id",ARRAY_A);
    	if($images || $this->_vars['number']>1)
	    print "style='display:none;'";

    	if($images)
	{
	    $this->_vars['file'] = $images[0]['file_name'];
	    $this->_vars['hide_thumb'] = $images[0]['file_hide_thumb'];
	    $this->_vars['hide_file'] = $images[0]['file_hide_file'];
	    $this->_vars['ispicture'] = $images[0]['file_ispicture'];
    	    $_SESSION['upload_files'][$this->_vars['number']] = array('id' => $images[0]['file_id']);
	    if ($this->_vars['number']>1)
	    	$this->_vars['upload_fields']++;
	    // Check if file is an image
	    if (strpos($images[0]['file_name'],'http')===0)
	    	$filename = $images[0]['file_name'];
	    else
	    	$filename = $upload_dir."/".$images[0]['file_name'];
	    if (!($str = @file_get_contents($filename)))   print "Can't read file $filename"; 
	    elseif (!($img = @imagecreatefromstring($str))) {
		$images = array();
	    }
	}
	$this->_vars['images'] = $images;
	$this->_vars['upload_directory']  = get_misc_data('upload_directory'); 
	$this->_vars['mandatory']  = unserialize(get_misc_data('upload_mandatory')); 
	$this->_vars['display']  = unserialize(get_misc_data('upload_display')); 
	$this->_vars['upload_thdirectory']= get_misc_data('upload_thdirectory');
	$this->_vars['upload_allow_hide']= get_misc_data('upload_allow_hide');
	$this->_vars['additional_fields'] = unserialize(base64_decode(get_misc_data('upload_fields')));
	$fields = $db->get_col($sql = "SELECT file_fields from " . table_prefix . "files where file_link_id='{$this->_vars['submit_id']}' AND file_number='{$this->_vars['number']}' AND file_size='orig'",ARRAY_A);
    	$values = unserialize(base64_decode($fields[0]));

    {/php}
>
	<fieldset style="border:1px solid #eee;padding:10px;margin-bottom:10px;font-weight:bold;width:450px;">
    	<form method=post enctype="multipart/form-data" action='{$my_pligg_base}/modules/upload/upload.php'  target='upload_iframe_{$number}'>
		
		<input type='hidden' name='id' value='{$submit_id}'>
    	    <input type='hidden' name='number' value='{$number}'>
    	    {if strstr($upload_external,'file')}
    		{#PLIGG_Upload_Upload#}: <input style='margin-bottom:5px' size='10' type='file' name='upload_files[]' id='file_{$number}' !onchange='submitUploadForm(this.form)'>
    		{if strstr($upload_external,'url')}
	    	    {#PLIGG_Upload_OR#} 
    		{/if}
    	    {/if}
    	    {if strstr($upload_external,'url')}
		{#PLIGG_Upload_Link#}: <input type='text' name='upload_urls[]' id='url_{$number}' value='http://' !onchange='submitUploadForm(this.form)'>
    	    {/if}
	    {foreach from=$additional_fields item=field key=i}
	    <br />{$field}{php}if ($this->_vars['mandatory'][$this->_vars['i']+1] > 0) echo "<font color=red>*</font>";{/php}: <input type='text' size='57' name='field{php}echo $this->_vars['i']+1;{/php}' {php}if ($this->_vars['mandatory'][$this->_vars['i']+1] > 0) echo "id='mandatory'";{/php} value='{php}echo $values['field'.($this->_vars['i']+1)];{/php}'>
	    {/foreach}
		<br /><br />
	    <input type='button' value='Upload' onclick='submitUploadForm(this.form)'>
		
    	</form>
    </div>
    <div id='thumb_{$number}'>{if $images || $file}{include file=$upload_tpl_path."upload_ajax.tpl"}{/if}</div>
    <iframe name="upload_iframe_{$number}" id="upload_iframe_{$number}" style='display:none;'></iframe> 
    </fieldset>
{/section}
<script>
var upload_fields = {$upload_fields};
</script>
<button onclick='if (upload_fields < {$upload_maxnumber}) add_upload_field({$upload_maxnumber}); if (++upload_fields >= {$upload_maxnumber}) this.disabled=true;' {if $upload_fields>=$upload_maxnumber}disabled{/if}>{#PLIGG_Upload_Add_File#}</button>

{config_load file=upload_pligg_lang_conf}
