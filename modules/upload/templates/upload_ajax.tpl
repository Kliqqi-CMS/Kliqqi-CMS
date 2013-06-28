{* Display thumbnails of uploaded image on submit page 2 using AJAX *}

{*config_load file=upload_lang_conf}
{config_load file='../lang.conf'*}
{*#PLIGG_Upload_Success#*}

<fieldset style="border:1px solid #eee;padding:10px;margin-bottom:10px;" class="upload_ajax">

<table class="upload_ajax_table">
	{foreach from=$images item=image}
		{php}
			if ($this->_vars['display'][$this->_vars['image']['file_size']]>0)
			{
		{/php}
			<tr class="upload_ajax_label">
				<td>{$file}</td>
			</tr>
			<tr class="upload_ajax_image">
				<td>
					{php}
						// Get the image URL
						$image =  $this->_vars['my_base_url'].$this->_vars['my_pligg_base'].$this->_vars['upload_directory'].'/'.$this->_vars['image']['file_name'];
						// echo $image;
						
						// Assign $height and $width variables
						list($width, $height) = getimagesize($image);
						
						// Check that the height and width is within the 1-100px range
						if ((1 <= $width) && ($width <= 100)){
							// Use exact width between 1-100px
						} elseif ( $width > 100 ){
							$width = '100';
						} else {
							$width = '';
						}
						
						if ((1 <= $height) && ($height <= 100)){
							// Use exact height between 1-100px
						} elseif ( $height > 100 ){
							$height = '100';
						} else {
							$height = '';
						}
						
						global $main_smarty;
						$main_smarty->assign('image_width', $width);
						$main_smarty->assign('image_height', $height);

					{/php}
					{if strpos($image.file_name,'http')===0}
						<a href="{$image.file_name}"><img src='{$image.file_name}' height="{$image_height}" width="{$image_width}" class="upload_ajax_image_preview"/></a>
					{elseif $image.file_size=='orig'}
						<a href="{$my_pligg_base}{$upload_directory}/{$image.file_name}" target="_blank"><img  src='{$my_pligg_base}{$upload_directory}/{$image.file_name}' height="{$image_height}" width="{$image_width}" class="upload_ajax_image_preview" /></a>
					{else}
						<img src='{$my_pligg_base}{$upload_thdirectory}/{$image.file_name}' height="{$image_height}" width="{$image_width}" class="upload_ajax_image_preview"/>
					{/if}
				</td>
			</tr>
			{*
			<tr class="upload_ajax_details">
				<td class="upload_ajax_size">
					{$image.file_size}
				</td>
				<td class="upload_ajax_instructions">
					<span style="font-weight:normal;">{#PLIGG_Upload_Code_Instructions#}</span><br />
					<input type="text" style="margin:4px 0;padding:3px 5px 3px 5px;" value="{literal}{image{/literal}{$number}{if $image.file_size!='orig'}_{$image.file_size}{/if}{literal}}{/literal}" />
					<br />
				</td>
			</tr>
			*}
		{php}
			}
		{/php}
	{/foreach}
	
	<tr class="upload_ajax_remove">
		<td>
			<input type='button' class="btn btn-danger upload_ajax_remove_button" value='Remove Attachment' onclick='deleteImage({$submit_id},{$number});'>
		</td>
	</tr>

	{if $upload_allow_hide}
		<tr class="upload_ajax_hide">
			<td>
				{if $ispicture}
					<input type='checkbox' onclick='switchImage({$submit_id},{$number},"thumb");' {if $hide_thumb}checked{/if}> {#PLIGG_Upload_Off_Thumb#}<br>
				{/if}
				<input type='checkbox' onclick='switchImage({$submit_id},{$number},"file");'  {if $hide_file}checked{/if}> {#PLIGG_Upload_Off_File#}
			</td>
		</tr>
	{/if}

</table>

</fieldset>
