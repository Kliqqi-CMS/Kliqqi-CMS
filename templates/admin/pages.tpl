<!-- pages.tpl -->
<legend>{#PLIGG_Visual_AdminPanel_Manage_Pages#}</legend>
<br />
<table class="table table-condensed table-bordered table-striped">
	<thead>
		<tr>
			{checkActionsTpl location="tpl_pligg_admin_pages_th_start"}
			<th class="page_th_title">{#PLIGG_Visual_AdminPanel_Page_Submit_Title#}</th>
			<th class="page_th_edit">{#PLIGG_Visual_AdminPanel_Page_Edit#}</th>
			<th class="page_th_delete">{#PLIGG_Visual_AdminPanel_Page_Delete#}</th>
			{checkActionsTpl location="tpl_pligg_admin_pages_th_end"}
		</tr>
	</thead>
	<tbody>
		{$page_title}
	</tbody>
</table>
{$page_text}
<a class="btn btn-success" href="{$my_base_url}{$my_pligg_base}/admin/submit_page.php" title="{#PLIGG_Visual_AdminPanel_Page_Submit_New#}">{#PLIGG_Visual_AdminPanel_Page_Submit_New#}</a>
<!--/pages.tpl -->