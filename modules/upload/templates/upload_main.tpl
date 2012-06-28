{config_load file=upload_lang_conf}

<fieldset><legend> {#PLIGG_Upload#}</legend>
<p>{#PLIGG_Upload_Instructions#}</p>
<br />


	<form action="" method="POST" id="thisform">
		<table border="0" cellspacing="8">
		<tr>
		<td width="250" colspan="2"><h2>{#PLIGG_Upload_Image#}: </h2></td>
		</tr>
		<tr>
		<td width="250" style="text-align:right"><label><a href="#{#PLIGG_Upload_Generate_Thumbnails#}">{#PLIGG_Upload_Generate_Thumbnails#}</a>:</label></td><td>
			<select name="upload_thumb">
			<option value='1' {if $settings.thumb}selected{/if}>On</option>
			<option value='0' {if !$settings.thumb}selected{/if}>Off</option>
			</select>
		</td>
		</tr>
		<tr>
		<td width="250" style="text-align:right"><label><a href="#{#PLIGG_Upload_Thumbnail_Sizes#}">{#PLIGG_Upload_Thumbnail_Sizes#}</a>:</label></td><td>
			<table border=1 style='width: 200px;'>
			<tr><th>{#PLIGG_Upload_Max_Size#}</th><th>{#PLIGG_Upload_Display_On_Upload#}</th><th>{#PLIGG_Upload_Delete#}</th></tr>
			<tr><td>{#PLIGG_Upload_Original#}</td><td><input type='checkbox' name='display[orig]' value='1' {if $settings.display.orig}checked{/if}></td><td>&nbsp;</td></tr>
			{foreach from=$settings.sizes item=size}
			<tr>	
			<td>{$size}</td>
			<td><input type='checkbox' name='display[{$size}]' value='1' {php}if ($this->_vars['settings']['display'][$this->_vars['size']]) echo 'checked';{/php}></td>
			<td><input type='checkbox' name='delsize[]' value='{$size}'></td>
			</tr>
			{/foreach}
			</table>
		</td>
		</tr>
		<tr>
		<td width="250" style="text-align:right"><label><a href="#{#PLIGG_Upload_Add_Size#}">{#PLIGG_Upload_Add_Size#}</a>:<br /><i>{#PLIGG_Upload_Add_Size_Note#}</i></label></td><td>
			{#PLIGG_Upload_Width#} : <input type='text' name='upload_width' size=3>&nbsp;&nbsp;&nbsp;
			{#PLIGG_Upload_Height#}: <input type='text' name='upload_height' size=3><br>
		</td>
		</tr>
		<tr>
		<td width="250" style="text-align:right"><label><a href="#{#PLIGG_Upload_Quality#}">{#PLIGG_Upload_Quality#} (1-100)</a>:</label></td><td>
			<input type='text' name='upload_quality' value="{$settings.quality}" size=3>
		</td>
		</tr>
		<tr>
		<td width="250" style="text-align:right"><label><a href="#{#PLIGG_Upload_Thumbnail_Place#}">{#PLIGG_Upload_Thumbnail_Place#}</a>:</label></td><td>
			<select name="upload_place">
				<option>{#PLIGG_Upload_Nowhere#}</option>
			{foreach from=$upload_places item=place}
				<option {if $settings.place==$place}selected{/if}>{$place}</option>
			{/foreach}
			</select>
		</td>
		</tr>
		<tr>
		<td width="250" style="text-align:right"><label><a href="#{#PLIGG_Upload_Thumbnail_Defsize#}">{#PLIGG_Upload_Thumbnail_Defsize#}</a>:</label></td><td>
			<select name="upload_defsize">
				<option value='orig' {if $settings.defsize=='orig'}selected{/if}>{#PLIGG_Upload_Original_Image#}</option>
			{foreach from=$settings.sizes item=size}
				<option {if $settings.defsize==$size}selected{/if}>{$size}</option>
			{/foreach}
			</select>
		</td>
		</tr>
		<tr>
		<td width="250" style="text-align:right"><label><a href="#{#PLIGG_Upload_Allow_External#}">{#PLIGG_Upload_Allow_External#}</a>:</label></td><td>
			<select name="upload_external">
			<option value='file,url' {if $settings.external=='file,url'}selected{/if}>{#PLIGG_Upload_Both#}</option>
			<option value='file' {if $settings.external=='file'}selected{/if}>{#PLIGG_Upload_File_Only#}</option>
			<option value='url' {if $settings.external=='url'}selected{/if}>{#PLIGG_Upload_URL_Only#}</option>
			</select>
		</td>
		</tr>
		<tr>
		<td width="250" style="text-align:right"><label><a href="#{#PLIGG_Upload_Thumbnail_Link#}">{#PLIGG_Upload_Thumbnail_Link#}</a>:</label></td><td>
			<select name="upload_link">
			<option value='story' {if $settings.link=='story'}selected{/if}>{#PLIGG_Upload_Story_Page#}</option>
			<option value='orig' {if $settings.link=='orig'}selected{/if}>{#PLIGG_Upload_Original_Image#}</option>
			{foreach from=$settings.sizes item=size}
				<option value='{$size}' {if $settings.link==$size}selected{/if}>{#PLIGG_Upload_Another_Thumbnail#} ({$size})</option>
			{/foreach}
			</select>
		</td>
		</tr>
		<tr>
		<td width="250" style="text-align:right"><label><a href="#{#PLIGG_Upload_Thumbnail_Fields#}">{#PLIGG_Upload_Thumbnail_Fields#}</a>:</label></td><td>
			<table border=1 style='width: 200px;'>
			<tr><th>{#PLIGG_Upload_Tag_Name#}</th><th>{#PLIGG_Upload_Field_Name#}</th><th>{#PLIGG_Upload_Alternate#}</th><th>{#PLIGG_Upload_Mandatory#}</th><th>{#PLIGG_Upload_Delete#}</th></tr>
			{foreach from=$settings.fields item=field key=i}
			<tr>
			<td>{literal}{{/literal}field{php}echo $this->_vars['i']+1;{/php}{literal}}{/literal}</td>
			<td>{$field}</td>
			<td><input type='text' name='alternate[{php}echo $this->_vars['i']+1;{/php}]' value='{php}echo $this->_vars['settings']['alternates'][$this->_vars['i']+1];{/php}' size='20'></td>
			<td><input type='checkbox' name='mandatory[{php}echo $this->_vars['i']+1;{/php}]' value='1' {php}if ($this->_vars['settings']['mandatory'][$this->_vars['i']+1]) echo 'checked';{/php}></td>
			<td><input type='checkbox' name='delfield[]' value='{$field}'></td></tr>
			{/foreach}
			</table>
		</td>
		</tr>
		<tr>
		<td width="250" style="text-align:right"><label><a href="#{#PLIGG_Upload_Add_Field#}">{#PLIGG_Upload_Add_Field#}</a>:<br /><i>{#PLIGG_Upload_Add_Field_Note#}</i></label></td><td>
			<input type='text' name='upload_new_field' size=20>
		</td>
		</tr>
		<tr>
			<td width="250" style="text-align:right"><label><a href="#{#PLIGG_Upload_Pre_Format#}">{#PLIGG_Upload_Pre_Format#}</a>:</label></td>
			<td><input type="text" name="upload_pre_format" id="upload_pre_format" size="66" value="{$settings.pre_format}" style="width: 420px;"/></td>
		</tr>
		<tr>
			<td width="250" style="text-align:right"><label><a href="#{#PLIGG_Upload_Format#}">{#PLIGG_Upload_Format#}</a>:</label><br><i>{#PLIGG_Upload_Can_Use#}: {literal}{path}, {fieldX}{/literal}</i></td>
			<td><input type="text" name="upload_format" id="upload_format" size="66" value="{$settings.format}" style="width: 420px;"/></td>
		</tr>
		<tr>
			<td width="250" style="text-align:right"><label><a href="#{#PLIGG_Upload_Post_Format#}">{#PLIGG_Upload_Post_Format#}</a>:</label></td>
			<td><input type="text" name="upload_post_format" id="upload_post_format" size="66" value="{$settings.post_format}" style="width: 420px;"/></td>
		</tr>
		<tr>
			<td width="250" style="text-align:right"><label><a href="#{#PLIGG_Upload_Pre_Thumbnail_Format#}">{#PLIGG_Upload_Pre_Thumbnail_Format#}</a>:</label></td>
			<td><input type="text" name="upload_thumb_pre_format" id="upload_thumb_pre_format" size="66" value="{$settings.thumb_pre_format}" style="width: 420px;"/></td>
		</tr>
		<tr>
			<td width="250" style="text-align:right"><label><a href="#{#PLIGG_Upload_Thumbnail_Format#}">{#PLIGG_Upload_Thumbnail_Format#}</a>:</label><br><i>{#PLIGG_Upload_Can_Use#}: {literal}{target}, {path}, {fieldX}{/literal}</i></td>
			<td><input type="text" name="upload_thumb_format" id="upload_thumb_format" size="66" value="{$settings.thumb_format}" style="width: 420px;"/></td>
		</tr>
		<tr>
			<td width="250" style="text-align:right"><label><a href="#{#PLIGG_Upload_Post_Thumbnail_Format#}">{#PLIGG_Upload_Post_Thumbnail_Format#}</a>:</label></td>
			<td><input type="text" name="upload_thumb_post_format" id="upload_thumb_post_format" size="66" value="{$settings.thumb_post_format}" style="width: 420px;"/></td>
		</tr>
		<tr>
			<td width="250" style="text-align:right"><label><a href="#{#PLIGG_Upload_Allow_Hiding#}">{#PLIGG_Upload_Allow_Hiding#}</a>:</label></td>
			<td><input type="checkbox" name="upload_allow_hide" id="upload_allow_hide" value="1" {if $settings.allow_hide}checked{/if}/></td>
		</tr>


		<tr>
		<td width="250" colspan="2"><br /><br /><h2>{#PLIGG_Upload_General#}: </h2></td>
		</tr>
		<tr>
			<td width="250" style="text-align:right"><label><a href="#{#PLIGG_Upload_Storage_Directory#}">{#PLIGG_Upload_Storage_Directory#}</a>:</label></td>
			<td><input type="text" name="upload_directory" id="upload_directory" size="66" value="{$settings.directory}" style="width: 420px;"/></td>
		</tr>
		<tr>
			<td width="250" style="text-align:right"><label><a href="#{#PLIGG_Upload_Thumbnail_Directory#}">{#PLIGG_Upload_Thumbnail_Directory#}</a>:</label></td>
			<td><input type="text" name="upload_thdirectory" id="upload_thdirectory" size="66" value="{$settings.thdirectory}" style="width: 420px;"/></td>
		</tr>
		<tr>
			<td width="250" style="text-align:right"><label><a href="#{#PLIGG_Upload_File_Size#}">{#PLIGG_Upload_File_Size#}</a>:</label></td>
			<td><input type="text" name="upload_filesize" id="upload_filesize" size="66" value="{$settings.filesize}" style="width: 50px;"/> KB</td>
		</tr>
		<tr>
			<td width="250" style="text-align:right"><label><a href="#{#PLIGG_Upload_Max_Number#}">{#PLIGG_Upload_Max_Number#}</a>:</label></td>
			<td><input type="text" name="upload_maxnumber" id="upload_maxnumber" size="66" value="{$settings.maxnumber}" style="width: 50px;"/></td>
		</tr>
		<tr>
			<td width="250" style="text-align:right"><label><a href="#{#PLIGG_Upload_File_Extensions#}">{#PLIGG_Upload_File_Extensions#}</a>:<br /><i>{#PLIGG_Upload_File_Extensions_Note#}</i></label></td>
			<td><input type="text" name="upload_extensions" id="upload_extensions" size="66" value="{$settings.extensions}" style="width: 420px;"/></td>
		</tr>
		<tr>
		<td width="250" style="text-align:right"><label><a href="#{#PLIGG_Upload_Files_Place#}">{#PLIGG_Upload_Files_Place#}</a>:</label></td><td>
			<select name="upload_fileplace">
				<option>{#PLIGG_Upload_Nowhere#}</option>
			{foreach from=$upload_places item=place}
				<option {if $settings.fileplace==$place}selected{/if}>{$place}</option>
			{/foreach}
			</select>
		</td>
		</tr>

		<tr><td width="250"></td><td><Br /><input type="submit" name="submit" value="{#PLIGG_Upload_Submit#}" class="log2" style="font-weight:bold;padding:2px 15px 2px 15px"/><br /><br /></td></tr>

		</table>
	</form>

<hr />
<h2>{#PLIGG_Upload_Field_Definitions#}</h2>
<p>{#PLIGG_Upload_Field_Definitions_Desc#}</p>
{literal}
<style>
p {margin:10px 0;}
strong {font-size:14px;}
</style>
{/literal}
<p><strong><a name="{#PLIGG_Upload_Generate_Thumbnails#}">{#PLIGG_Upload_Generate_Thumbnails#}</a></strong>: {#PLIGG_Upload_Generate_Thumbnails_Definition#}</p>
<p><strong><a name="{#PLIGG_Upload_Thumbnail_Sizes#}">{#PLIGG_Upload_Thumbnail_Sizes#}</a></strong>: {#PLIGG_Upload_Thumbnail_Sizes_Definition#}</p>
<p><strong><a name="{#PLIGG_Upload_Add_Size#}">{#PLIGG_Upload_Add_Size#}</a></strong>: {#PLIGG_Upload_Add_Size_Definition#}</p>
<p><strong><a name="{#PLIGG_Upload_Quality#}">{#PLIGG_Upload_Quality#}</a></strong>: {#PLIGG_Upload_Quality_Definition#}</p>
<p><strong><a name="{#PLIGG_Upload_Thumbnail_Place#}">{#PLIGG_Upload_Thumbnail_Place#}</a></strong>: {#PLIGG_Upload_Thumbnail_Place_Definition#}</p>
<p><strong><a name="{#PLIGG_Upload_Thumbnail_Defsize#}">{#PLIGG_Upload_Thumbnail_Defsize#}</a></strong>: {#PLIGG_Upload_Thumbnail_Defsize_Definition#}</p>
<p><strong><a name="{#PLIGG_Upload_Allow_External#}">{#PLIGG_Upload_Allow_External#}</a></strong>: {#PLIGG_Upload_Allow_External_Definition#}</p>
<p><strong><a name="{#PLIGG_Upload_Thumbnail_Link#}">{#PLIGG_Upload_Thumbnail_Link#}</a></strong>: {#PLIGG_Upload_Thumbnail_Link_Definition#}</p>
<p><strong><a name="{#PLIGG_Upload_Thumbnail_Fields#}">{#PLIGG_Upload_Thumbnail_Fields#}</a></strong>: {#PLIGG_Upload_Thumbnail_Fields_Definition#}</p>
<p><strong><a name="{#PLIGG_Upload_Add_Field#}">{#PLIGG_Upload_Add_Field#}</a></strong>: {#PLIGG_Upload_Add_Field_Definition#}</p>
<p><strong><a name="{#PLIGG_Upload_Pre_Format#}">{#PLIGG_Upload_Pre_Format#}</a></strong>: {#PLIGG_Upload_Pre_Format_Definition#}</p>
<p><strong><a name="{#PLIGG_Upload_Format#}">{#PLIGG_Upload_Format#}</a></strong>: {#PLIGG_Upload_Format_Definition#}</p>
<p><strong><a name="{#PLIGG_Upload_Post_Format#}">{#PLIGG_Upload_Post_Format#}</a></strong>: {#PLIGG_Upload_Post_Format_Definition#}</p>
<p><strong><a name="{#PLIGG_Upload_Pre_Thumbnail_Format#}">{#PLIGG_Upload_Pre_Thumbnail_Format#}</a></strong>: {#PLIGG_Upload_Pre_Thumbnail_Format_Definition#}</p>
<p><strong><a name="{#PLIGG_Upload_Thumbnail_Format#}">{#PLIGG_Upload_Thumbnail_Format#}</a></strong>: {#PLIGG_Upload_Thumbnail_Format_Definition#}</p>
<p><strong><a name="{#PLIGG_Upload_Post_Thumbnail_Format#}">{#PLIGG_Upload_Post_Thumbnail_Format#}</a></strong>: {#PLIGG_Upload_Post_Thumbnail_Format_Definition#}</p>
<p><strong><a name="{#PLIGG_Upload_Allow_Hiding#}">{#PLIGG_Upload_Allow_Hiding#}</a></strong>: {#PLIGG_Upload_Allow_Hiding_Definition#}</p>
<p><strong><a name="{#PLIGG_Upload_Storage_Directory#}">{#PLIGG_Upload_Storage_Directory#}</a></strong>: {#PLIGG_Upload_Storage_Directory_Definition#}</p>
<p><strong><a name="{#PLIGG_Upload_Thumbnail_Directory#}">{#PLIGG_Upload_Thumbnail_Directory#}</a></strong>: {#PLIGG_Upload_Thumbnail_Directory_Definition#}</p>
<p><strong><a name="{#PLIGG_Upload_File_Size#}">{#PLIGG_Upload_File_Size#}</a></strong>: {#PLIGG_Upload_File_Size_Definition#}</p>
<p><strong><a name="{#PLIGG_Upload_Max_Number#}">{#PLIGG_Upload_Max_Number#}</a></strong>: {#PLIGG_Upload_Max_Number_Definition#}</p>
<p><strong><a name="{#PLIGG_Upload_File_Extensions#}">{#PLIGG_Upload_File_Extensions#}</a></strong>: {#PLIGG_Upload_File_Extensions_Definition#}</p>
<p><strong><a name="{#PLIGG_Upload_Files_Place#}">{#PLIGG_Upload_Files_Place#}</a></strong>: {#PLIGG_Upload_Files_Place_Definition#}</p>

</fieldset>


{config_load file=upload_pligg_lang_conf}
