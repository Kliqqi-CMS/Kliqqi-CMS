{************************************
***** Advanced Search Template ******
*************************************}
<!-- search_advanced_center.tpl -->
{checkActionsTpl location="tpl_pligg_search_advanced_start"}
<script>
	{literal}
	function SEO2submit(form)
	{
		var datastr = '';
		var fields  = form.getElementsByTagName('INPUT');
		for (var i=0; i<fields.length; i++)
			if (fields[i].type=="text")
			if (fields[i].name=="search")
				datastr += (fields[i].value ? encodeURIComponent(fields[i].value) : '-') + '/';
			else if (fields[i].value!='')
				datastr += fields[i].name + '/' + encodeURIComponent(fields[i].value) + '/';
			else if (fields[i].type=="radio" && fields[i].checked)
			datastr += fields[i].name + '/' + encodeURIComponent(fields[i].value) + '/';
		fields  = form.getElementsByTagName('SELECT');
		for (var i=0; i<fields.length; i++)
				for (var j=0; j<fields[i].length; j++)
			if (fields[i][j].selected)
					datastr += fields[i].name + '/' + encodeURIComponent(fields[i][j].value) + '/';

		document.location.href=form.action+datastr+'adv/1';
	}
	{/literal}
</script>

<div class="span7">
	<form method="get" class="form-horizontal" action="{$URL_search}" {php}	global $URLMethod; if ($URLMethod==2) print "onsubmit='SEO2submit(this); return false;'";{/php}>
		<fieldset>
			<div class="control-group">
				<label for="search" class="control-label">{#PLIGG_Visual_Search_Keywords#}</label>
				<div class="controls">
					<input autofocus="autofocus" name="search" type="text" class="input-xlarge" />
					<p class="help-block">{#PLIGG_Visual_Search_Keywords_Instructions#}</p>
				</div>
			</div>
			<div class="control-group">
				<label for="slink" class="control-label">{#PLIGG_Visual_Search_Story#}</label>
				<div class="controls">
					<select name="slink">
						<option value="3" selected="selected">{#PLIGG_Visual_Search_Story_Title_and_Description#}</option>
						<option value="1">{#PLIGG_Visual_Search_Story_Title#}</option>
						<option value="2">{#PLIGG_Visual_Search_Story_Description#}</option>												
					</select>
				</div>
			</div>
			<div class="control-group">
				<label for="scategory" class="control-label">{#PLIGG_Visual_Search_Category#}</label>
				<div class="controls">
					<select name="scategory" >
						{$category_option}
					</select>
				</div>
			</div>
			<div class="control-group">
				<label for="scomments" class="control-label">{#PLIGG_Visual_Search_Comments#}</label>
				<div class="controls">
					<input type="radio" name="scomments" value="1" checked="checked" /> {#PLIGG_Visual_Search_Advanced_Yes#} &nbsp;&nbsp;
					<input type="radio" name="scomments" value="0" /> {#PLIGG_Visual_Search_Advanced_No#}
				</div>
			</div>
			<div class="control-group">
				<label for="stags" class="control-label">{#PLIGG_Visual_Search_Tags#}</label>
				<div class="controls">
					<input type="radio" name="stags" value="1" checked="checked" /> {#PLIGG_Visual_Search_Advanced_Yes#} &nbsp;&nbsp;
					<input type="radio" name="stags" value="0" /> {#PLIGG_Visual_Search_Advanced_No#}
				</div>
			</div>
			<div class="control-group">
				<label for="suser" class="control-label">{#PLIGG_Visual_Search_User#}</label>
				<div class="controls">
					<input type="radio" name="suser" value="1" /> {#PLIGG_Visual_Search_Advanced_Yes#} &nbsp;&nbsp;
					<input type="radio" name="suser" value="0" checked="checked" /> {#PLIGG_Visual_Search_Advanced_No#}
				</div>
			</div>
			<div class="control-group">
				<label for="date" class="control-label">{#PLIGG_Visual_Advanced_Search_Date#}</label>
				<div class="controls">
					{include file=$the_template."/date_picker.tpl"}
					<input name="date" type="text" class="input-small">
					<input type="button" value="{#PLIGG_Visual_Advanced_Search_Select#}" class="btn" onclick="displayDatePicker('date', false, 'ymd', '-');">
				</div>
			</div>
			{php} if (enable_group=='true') { {/php}
				<div class="control-group">
					<label for="sgroup" class="control-label">{#PLIGG_Visual_Search_Group#}</label>
					<div class="controls">
						<select name="sgroup">
							<option value="3" selected="selected">{#PLIGG_Visual_Search_Group_Named_and_Description#}</option>
							<option value="1">{#PLIGG_Visual_Search_Group_Name#}</option>
							<option value="2">{#PLIGG_Visual_Search_Group_Description#}</option>												
						</select>
					</div>
				</div>
			{php} }	{/php}
			<div class="control-group">
				<label for="status" class="control-label">{#PLIGG_Visual_Search_Status#}</label>
				<div class="controls">
					<select name="status">
						<option value="all" selected="selected">{#PLIGG_Visual_Search_Status_All#}</option>
						<option value="published">{#PLIGG_Visual_Search_Status_Published#}</option>
						<option value="new">{#PLIGG_Visual_Search_Status_New#}</option>												
					</select>
				</div>
			</div>
			<div class="form-actions">
				<input name="adv" type="hidden" value="1" />		
				<input name="advancesearch" value="Search " type="submit" class="btn btn-primary" />
			</div>
		</fieldset>
	</form>
</div>
{checkActionsTpl location="tpl_pligg_search_advanced_end"}
<!--/search_advanced_center.tpl -->