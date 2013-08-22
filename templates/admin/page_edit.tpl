<!-- page_edit.tpl -->
<legend>{#PLIGG_Visual_AdminPanel_Page_Edit#}</legend>
<a class="btn btn-default" href="{$my_base_url}{$my_pligg_base}/page.php?page={$page_url}" target="_blank">Visit {$page_title} Page</a>
<br /><br />
<form action="" class="form-horizontal" method="POST" id="thisform">
	<div class="control-group">
		<label class="control-label">{#PLIGG_Visual_AdminPanel_Page_Submit_Title#}</label>
		<div class="controls">
			<input type="text" name="page_title" id="page_title" class="form-control col-md-7" value="{$page_title}"/>
			<p class="help-inline">This will appear in the &lt;title&gt; tag and breadcrumb area.</p>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label">{#PLIGG_Visual_AdminPanel_Page_Submit_URL#}</label>
		<div class="controls">
			<input type="text" name="page_url" id="page_url" class="form-control col-md-7" value="{$page_url}"/>
			<p class="help-inline">Define the URL value (ex. about-us). If left blank, this will be generated for you.</p>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label">{#PLIGG_Visual_AdminPanel_Page_Submit_Keywords#}</label>
		<div class="controls">
			<input type="text" name="page_keywords" id="page_keywords" class="form-control col-md-7" value="{$page_keywords}"/>
			<p class="help-inline">This value is used for the meta keywords tag. Enter keywords separated by commas.</p>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label">{#PLIGG_Visual_AdminPanel_Page_Submit_Description#}</label>
		<div class="controls">
			<input type="text" name="page_description" id="page_description" class="form-control col-md-7" value="{$page_description}"/>
			<p class="help-inline">This value is used for the meta description tag.</p>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label">Page Content</label>
		<div class="controls">
			<textarea id="textarea-1" name="page_content" class="form-control page_content" rows="30" style="width:95%;">{$page_content|htmlspecialchars}</textarea>
			<span class="help-inline">{#PLIGG_Visual_AdminPanel_Page_HTML#}</span>
			{#PLIGG_Visual_AdminPanel_Page_Smarty#}
		</div>
	</div>
	<div class="form-actions">
		<input type="submit" class="btn btn-primary" name="submit" value="{#PLIGG_Visual_AdminPanel_Page_Submit#}" />
		<button class="btn btn-default" ONCLICK="history.go(-1)">Cancel</button>
	</div>
	<input type="hidden" name="process" value="edit_page" />
	<input type="hidden" name="randkey" value="{$randkey}" />
	<input type="hidden" name="link_id" value="{$link_id}" />
</form>
<!--/page_edit.tpl -->