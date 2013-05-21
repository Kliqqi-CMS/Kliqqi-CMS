{************************************
************ Pligg Pages ************
*************************************}
<!-- page_center.tpl -->
{eval var=$page_content}
{if isset($isadmin) && $isadmin eq 1}
	<div class="edit">
		<a class="btn btn-primary" href="{$my_base_url}{$my_pligg_base}/admin/edit_page.php?link_id={$link_id}">{#PLIGG_Visual_AdminPanel_Page_Edit#}</a>
	</div>
{/if}
<!-- page_center.tpl -->