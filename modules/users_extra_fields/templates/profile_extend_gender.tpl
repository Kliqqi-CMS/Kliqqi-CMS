<td>
	<select  name="{$users_extra_fields_field[fields].name}" id="{$users_extra_fields_field[fields].name}">
		<option value='' {if $users_extra_fields_field[fields].value eq ""} selected="selected"{/if}>Select a gender</option>
		<option value='Male' {if $users_extra_fields_field[fields].value eq "Male"} selected="selected"{/if}>Male</option>
		<option value='Female' {if $users_extra_fields_field[fields].value eq "Female"} selected="selected"{/if}>Female</option>
	</select>
</td>