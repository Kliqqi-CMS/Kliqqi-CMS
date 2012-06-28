<td>
	<select  name="{$users_extra_fields_field[fields].name}" id="{$users_extra_fields_field[fields].name}">
		<option value='' {if $users_extra_fields_field[fields].value eq ""} selected="selected"{/if}>Select a weekday</option>
		<option value='Monday' {if $users_extra_fields_field[fields].value eq "Monday"} selected="selected"{/if}>Monday</option>
		<option value='Tuesday' {if $users_extra_fields_field[fields].value eq "Tuesday"} selected="selected"{/if}>Tuesday</option>
		<option value='Wednesday' {if $users_extra_fields_field[fields].value eq "Wednesday"} selected="selected"{/if}>Wednesday</option>
		<option value='Thursday' {if $users_extra_fields_field[fields].value eq "Thursday"} selected="selected"{/if}>Thursday</option>
		<option value='Friday' {if $users_extra_fields_field[fields].value eq "Friday"} selected="selected"{/if}>Friday</option>
		<option value='Saturday' {if $users_extra_fields_field[fields].value eq "Saturday"} selected="selected"{/if}>Saturday</option>
		<option value='Sunday' {if $users_extra_fields_field[fields].value eq "Sunday"} selected="selected"{/if}>Sunday</option>
	</select>
</td>