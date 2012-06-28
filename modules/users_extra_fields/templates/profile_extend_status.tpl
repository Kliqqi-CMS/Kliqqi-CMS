<td>
	<select  name="{$users_extra_fields_field[fields].name}" id="{$users_extra_fields_field[fields].name}">
		<option value='' {if $users_extra_fields_field[fields].value eq ""} selected="selected"{/if}></option>
		<option value='Never married' {if $users_extra_fields_field[fields].value eq "Never married"} selected="selected"{/if}>Never married</option>
		<option value='Widowed' {if $users_extra_fields_field[fields].value eq "Widowed"} selected="selected"{/if}>Widowed</option>
		<option value='Divorced' {if $users_extra_fields_field[fields].value eq "Divorced"} selected="selected"{/if}>Divorced</option>
		<option value='Separated' {if $users_extra_fields_field[fields].value eq "Separated"} selected="selected"{/if}>Separated</option>
		<option value='Married' {if $users_extra_fields_field[fields].value eq "Married"} selected="selected"{/if}>Married</option>
	</select>
</td>