<!-- pages.tpl -->
<legend>{#PLIGG_Visual_AdminPanel_Manage_Pages#}</legend>
<br />
<table class="table table-bordered table-striped">
	<thead>
		<tr>
			<th>{#PLIGG_Visual_AdminPanel_Page_Submit_Title#}</th>
			<th style="width:80px;text-align:center;">{#PLIGG_Visual_AdminPanel_Page_Edit#}</th>
			<th style="width:80px;text-align:center;">{#PLIGG_Visual_AdminPanel_Page_Delete#}</th>
		</tr>
	</thead>
	<tbody>
		{$page_title}
	</tbody>
</table>
{$page_text}
<a class="btn btn-success" href="{$my_base_url}{$my_pligg_base}/admin/submit_page.php" title="{#PLIGG_Visual_AdminPanel_Page_Submit_New#}">{#PLIGG_Visual_AdminPanel_Page_Submit_New#}</a>
<!--/pages.tpl -->