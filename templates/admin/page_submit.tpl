<!-- page_submit.tpl -->
<legend>{#PLIGG_Visual_AdminPanel_Page_Submit_New#}</legend>
<form action="" method="POST" id="thisform">
	<label>{#PLIGG_Visual_AdminPanel_Page_Submit_Title#} : </label><input type="text" class="form-control" name="page_title" id="page_title" size="66"/>
	<br />
	<label>{#PLIGG_Visual_AdminPanel_Page_Submit_URL#} : </label><input type="text" class="form-control" name="page_url" id="page_url" size="66"/>
	<br />
	<label>{#PLIGG_Visual_AdminPanel_Page_Submit_Keywords#} : </label><input type="text" class="form-control" name="page_keywords" id="page_keywords" size="66"/>
	<br />
	<label>{#PLIGG_Visual_AdminPanel_Page_Submit_Description#} : </label><input type="text" class="form-control" name="page_description" id="page_description" size="66"/>
	<br />
	<textarea id="textarea-1" name="page_content" class="form-control page_content" rows="15">{$page_content}</textarea>	
	<br style="clear:both" /><br />
	<input type="submit" class="btn btn-primary" name="submit" value="{#PLIGG_Visual_AdminPanel_Page_Submit#}" />
	<input type="hidden" name="process" value="new_page" />
	<input type="hidden" name="randkey" value="{$randkey}" />
</form>
<hr />
<p>{#PLIGG_Visual_AdminPanel_Page_HTML#}</p>
<p>{#PLIGG_Visual_AdminPanel_Page_Smarty#}</p>
<!--/page_submit.tpl -->