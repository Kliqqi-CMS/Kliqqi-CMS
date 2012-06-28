{section name=fields loop=$users_extra_fields_field}
	{if $users_extra_fields_field[fields].show_to_admin eq TRUE}
		<tr><td><b>{$users_extra_fields_field[fields].show_to_admin_text}</b></td><td>{$users_extra_fields_field[fields].value}</td></tr>
	{/if}
{/section}