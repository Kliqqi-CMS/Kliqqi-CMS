{literal}
<script type="text/javascript">
function SetState(obj_checkbox, obj_textarea) {
	if(obj_checkbox.checked)
		{ obj_textarea.disabled = false;
	}
	else {
		obj_textarea.disabled = true;
	}
}
function textCounter(field, countfield, maxlimit) {
	if (field.value.length > maxlimit) // if too long...trim it!
			field.value = field.value.substring(0, maxlimit);
			// otherwise, update 'characters left' counter
	else
			countfield.value = maxlimit - field.value.length;
}
function counter(text) {
	text.form.text_num.value = text.value.length;
}
</script>
{/literal}

{checkActionsTpl location="tpl_pligg_submit_step2_start"}
<form action="" method="post" id="thisform" enctype="multipart/form-data" >
	<input type="hidden" name="id" value="{$submit_id}" />
	{$hidden_token_edit_link}

	<legend>{#PLIGG_Visual_EditStory_Header#}: {$submit_title}</legend>
	
	<strong>{#PLIGG_Visual_Submit2_NewsURL#}: </strong>
	&nbsp;<a href="{$submit_url}">{$submit_url}</a>
	{if $isAdmin eq 1}
		<br />
		<input type="text" name="url" id="url" class="span6" value ="{$submit_url}">
	{/if}
	
	<br />
	
	{* 
		<strong for="url_title" accesskey="2">{#PLIGG_Visual_Submit2_URLTitle#}: </strong>{$submit_url_title} 
		<hr />
	*}

	<strong>{#PLIGG_Visual_Submit2_Title#}: </strong> 
	<span class="field-description">{#PLIGG_Visual_Submit2_TitleInstruct#}</span>
	<br />
	<input type="text" id="title" class="span6" name="title" value="{$submit_title}" maxlength="{$maxTitleLength}" />
	<br />
	
	{if $enable_tags}
		<strong>{#PLIGG_Visual_Submit2_Tags#}: </strong> 
		<span class="field-description">{#PLIGG_Visual_Submit2_Tags_Inst1#} {#PLIGG_Visual_Submit2_Tags_Example#} {#PLIGG_Visual_Submit2_Tags_Inst2#}</span>
		<input type="text" id="tags" class="span6" name="tags" value="{$tags_words}" maxlength="{$maxTagsLength}" />
		<br />
	{/if}
		
	<strong>{#PLIGG_Visual_Submit2_Description#}: </strong>
	<span class="field-description">{#PLIGG_Visual_Submit2_DescInstruct#}</span>
	<br />
	<textarea name="bodytext" rows="10" id="bodytext" class="span9" WRAP="SOFT" onKeyPress="counter(this)" onKeyDown="counter(this)" {if $SubmitSummary_Allow_Edit eq 1}onkeyup="counter(this); if(!this.form.summarycheckbox || !this.form.summarytext) return; if(this.form.summarycheckbox.checked == false) {ldelim}this.form.summarytext.value = this.form.bodytext.value.substring(0, {$StorySummary_ContentTruncate});{rdelim}textCounter(this.form.summarytext,this.form.remLen, {$StorySummary_ContentTruncate});"{else}onkeyup="counter(this);"{/if}>{$submit_content}</textarea>
	{if $Story_Content_Tags_To_Allow neq "" && $enable_tags}
		<span class="help-inline">
			{#PLIGG_Visual_Submit2_HTMLTagsAllowed#}: {$Story_Content_Tags_To_Allow}
		</span>
	{/if}
	<br />
	{if $Spell_Checker eq 1}
		<input type="button" name="spelling" value="{#PLIGG_Visual_Check_Spelling#}" class="btn" onClick="openSpellChecker('bodytext');"/>
	{/if}
	<input class="span1" value='{$storylen}' name=text_num disabled> {#PLIGG_Visual_Total_Chars#} 
	<br />
	
	{if $SubmitSummary_Allow_Edit eq 1}
		<strong>{#PLIGG_Visual_Submit2_Summary#}: </strong>
		<span class="field-description">{#PLIGG_Visual_Submit2_SummaryInstruct#}{#PLIGG_Visual_Submit2_SummaryLimit#}{$StorySummary_ContentTruncate}{#PLIGG_Visual_Submit2_SummaryLimitCharacters#}</span>
		<br />
		<input type="checkbox" name="summarycheckbox" id="summarycheckbox" class="span6" onclick="SetState(this, this.form.summarytext)" checked> {#PLIGG_Visual_Submit2_SummaryCheckBox#}
		<br />
		<textarea name="summarytext" rows="5" id="summarytext" class="span9" WRAP="SOFT" onKeyDown="textCounter(this.form.summarytext,this.form.remLen, {$StorySummary_ContentTruncate});">{$submit_summary}</textarea>
		<input readonly type=text name=remLen size="3" class="span1" value="{$StorySummary_ContentTruncate}"> {#PLIGG_Visual_Submit2_SummaryCharactersLeft#}
		{if $Spell_Checker eq 1}
			<input class="btn" type="button" name="spelling" value="{#PLIGG_Visual_Check_Spelling#}" onClick="openSpellChecker('summarytext');"/>
		{/if}
		<br />
	{/if}
	
	<strong>{#PLIGG_Visual_Submit2_Category#}: </strong>
	<span class="field-description">{#PLIGG_Visual_Submit2_CatInstruct#}</span>
	<br />
	<select {if $Multiple_Categories}name="category[]" multiple size=10{else}name="category"{/if}>
		{section name=thecat loop=$cat_array}
			<option value = "{$cat_array[thecat].auto_id}"{if $cat_array[thecat].auto_id eq $submit_category || in_array($cat_array[thecat].auto_id,$submit_additional_cats)} selected="selected"{/if}>
			{if $cat_array[thecat].spacercount lt $lastspacer}{$cat_array[thecat].spacerdiff|repeat_count:''}{/if}
			{if $cat_array[thecat].spacercount gt $lastspacer}{/if}
			{$cat_array[thecat].spacercount|repeat_count:'&nbsp;&nbsp;&nbsp;'}
			{$cat_array[thecat].name} 
			&nbsp;&nbsp;&nbsp;       
			{assign var=lastspacer value=$cat_array[thecat].spacercount}					
			</option>
		{/section}
	</select>

	<br />
	
	{if $canIhaveAccess eq 1}
		<strong>{#PLIGG_Visual_EditStory_Notify#}: </strong>
		<br />
		&nbsp; <input type="checkbox" name="notify" value="yes"> {#PLIGG_Visual_EditStory_NotifyText#}
		<ul style="list-style-type:none;">
			<li><input type="radio" name="reason" value="typo" onclick="notify.checked = 'true';">{#PLIGG_Visual_EditStory_Reason_typo#}</li>
			<li><input type="radio" name="reason" value="category" onclick="notify.checked = 'true';">{#PLIGG_Visual_EditStory_Reason_category#}</li>
			<li><input type="radio" name="reason" value="tags" onclick="notify.checked = 'true';">{#PLIGG_Visual_EditStory_Reason_tags#}</li>
			<li><input type="radio" name="reason" value="foul" onclick="notify.checked = 'true';">{#PLIGG_Visual_EditStory_Reason_foul#}</li>
			<li><input type="radio" name="reason" value="other" onclick="notify.checked = 'true';">{#PLIGG_Visual_EditStory_Reason_other#} <input type="text" name="otherreason" size="50"></li>
		</ul>
	{/if}
	
	{checkActionsTpl location="submit_step_2_pre_extrafields"}

	{include file=$tpl_extra_fields.".tpl"}
	
	<br />
	
	<input type="submit" value="{#PLIGG_Visual_Submit2_Continue#}" class="btn btn-primary" />
	
</form>
