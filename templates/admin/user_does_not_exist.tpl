<!-- user_does_not_exist.tpl -->
<div class="alert">
    <strong>Error:</strong> User ID {if $get.user}{$get.user}{/if}{if $get.user_id}{$get.user_id}{/if} was not found.
	<br /><br />
	<a class="btn" href="{$my_base_url}{$my_pligg_base}/admin/admin_users.php">Return to User Management</a>
</div>
<!--/user_does_not_exist.tpl -->