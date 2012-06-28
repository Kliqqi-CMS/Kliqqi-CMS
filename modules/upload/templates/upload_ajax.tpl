{* Display thumbnails of uploaded image on submit page 2 using AJAX *}

{*config_load file=upload_lang_conf}
{config_load file='../lang.conf'*}
{*#PLIGG_Upload_Success#*}

<fieldset style="border:1px solid #eee;padding:10px;margin-bottom:10px;font-weight:bold;width:450px;">
{$file}
<table>
{foreach from=$images item=image}
{php}
    if ($this->_vars['display'][$this->_vars['image']['file_size']]>0)
    {
{/php}
	<tr>
		<td>
		{if strpos($image.file_name,'http')===0}
			<a href="{$image.file_name}"><img src='{$image.file_name}' width='150'/></a>
		{elseif $image.file_size=='orig'}
			<a href="{$my_pligg_base}{$upload_directory}/{$image.file_name}" target="_blank"><img src='{$my_pligg_base}{$upload_directory}/{$image.file_name}' width='150'/></a>
		{else}
			<img src='{$my_pligg_base}{$upload_thdirectory}/{$image.file_name}'/>
		{/if}
		</td>
	</tr>
	<tr>
		{*
		<td>
		{$image.file_size}
		</td>
		*}
		<td>
		<span style="font-weight:normal;">{#PLIGG_Upload_Code_Instructions#}</span><br />
		<input type="text" style="margin:4px 0;padding:3px 5px 3px 5px;" value="{literal}{image{/literal}{$number}{if $image.file_size!='orig'}_{$image.file_size}{/if}{literal}}{/literal}" />
		<br />
		</td>
	</tr>
{php}
    }
{/php}
{/foreach}
</table>

<input type='button' value='Delete' onclick='deleteImage({$submit_id},{$number});'><br>
{if $upload_allow_hide}
    {if $ispicture}
	<input type='checkbox' onclick='switchImage({$submit_id},{$number},"thumb");' {if $hide_thumb}checked{/if}> {#PLIGG_Upload_Off_Thumb#}<br>
    {/if}
<input type='checkbox' onclick='switchImage({$submit_id},{$number},"file");'  {if $hide_file}checked{/if}> {#PLIGG_Upload_Off_File#}
{/if}
</fieldset>
