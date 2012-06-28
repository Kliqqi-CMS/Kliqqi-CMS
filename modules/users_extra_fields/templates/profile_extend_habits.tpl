<td>
	<select  name="{$users_extra_fields_field[fields].name}" id="{$users_extra_fields_field[fields].name}">
		<option value='' {if $users_extra_fields_field[fields].value eq ""} selected="selected"{/if}>Select one</option>
		<option value='Smoking' {if $users_extra_fields_field[fields].value eq "Smoking"} selected="selected"{/if}>Smoking</option>
		<option value='Non-smoking' {if $users_extra_fields_field[fields].value eq "Non-smoking"} selected="selected"{/if}>Non-smoking</option>
	</select>
</td>