{eval var=$page_content}

{if isset($isgod) && $isgod eq 1}
	<div class="edit">
		<a href="{$my_base_url}{$my_pligg_base}/admin/edit_page.php?link_id={$link_id}" style="text-decoration:none;" ><div class="edit-image"><img src="{$my_base_url}{$my_pligg_base}/templates/admin/images/icon_user_edit.png" alt="Click to" /></div> &nbsp; {#PLIGG_Visual_AdminPanel_Page_Edit#}</a>
	</div>
{/if}