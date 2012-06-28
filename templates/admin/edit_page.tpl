<h1><img src="{$my_pligg_base}/templates/admin/images/page.gif" align="absmiddle" /> {#PLIGG_Visual_AdminPanel_Page_Edit#}</h1>

<p style="width:99%;margin:0 0 10px 0;padding:5px 8px;border:1px solid #bbb;background:#eee;font-size:14px;"><a href="{$my_base_url}{$my_pligg_base}/page.php?page={$page_url}" target="_blank">Visit {$page_title} Page</a></p>

<form action="" method="POST" id="thisform">
	<label>{#PLIGG_Visual_AdminPanel_Page_Submit_Title#}: </label><input type="text" name="page_title" id="page_title" size="66" value="{$page_title}"/>
	<br />
	<label>{#PLIGG_Visual_AdminPanel_Page_Submit_URL#}: </label><input type="text" name="page_url" id="page_url" size="66" value="{$page_url}"/>
	<br />
	<label>{#PLIGG_Visual_AdminPanel_Page_Submit_Keywords#} : </label><input type="text" name="page_keywords" id="page_keywords" size="66" value="{$page_keywords}"/>
	<br />
	<label>{#PLIGG_Visual_AdminPanel_Page_Submit_Description#} : </label><input type="text" name="page_description" id="page_description" size="66" value="{$page_description}"/>
	<br />
	<label>{#PLIGG_Visual_AdminPanel_Page_HTML#}</label>
	<br />
	<textarea id="textarea-1" name="page_content" class="page_content" rows="30" style="width:100%">{$page_content|htmlspecialchars}</textarea>
	<div class="submitbuttonfloat">
	<br />
		<input type="submit" name="submit" value="{#PLIGG_Visual_AdminPanel_Page_Submit#}" class="log2" />
	</div>
	<input type="hidden" name="process" value="edit_page" />
	<input type="hidden" name="randkey" value="{$randkey}" />
	<input type="hidden" name="link_id" value="{$link_id}" />
</form>
