<!-- pages.tpl -->
<legend>{#PLIGG_Visual_AdminPanel_Manage_Pages#}</legend>
<br />
<table class="table table-condensed table-bordered table-striped">
	<thead>
		<tr>
			{checkActionsTpl location="tpl_pligg_admin_pages_th_start"}
			<th>{#PLIGG_Visual_AdminPanel_Page_Submit_Title#}</th>
			<th style="text-align:center;">{#PLIGG_Visual_AdminPanel_Page_Edit#}</th>
			<th style="text-align:center;">{#PLIGG_Visual_AdminPanel_Page_Delete#}</th>
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