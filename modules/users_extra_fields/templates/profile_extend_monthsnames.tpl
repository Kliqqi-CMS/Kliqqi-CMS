<td>
	<select  name="{$users_extra_fields_field[fields].name}" id="{$users_extra_fields_field[fields].name}">
		<option value='' {if $users_extra_fields_field[fields].value eq ""} selected="selected"{/if}>Select a month</option>
		<option value='January' {if $users_extra_fields_field[fields].value eq "January"} selected="selected"{/if}>January</option>
		<option value='February' {if $users_extra_fields_field[fields].value eq "February"} selected="selected"{/if}>February</option>
		<option value='March' {if $users_extra_fields_field[fields].value eq "March"} selected="selected"{/if}>March</option>
		<option value='April' {if $users_extra_fields_field[fields].value eq "April"} selected="selected"{/if}>April</option>
		<option value='May' {if $users_extra_fields_field[fields].value eq "May"} selected="selected"{/if}>May</option>
		<option value='June' {if $users_extra_fields_field[fields].value eq "June"} selected="selected"{/if}>June</option>
		<option value='July' {if $users_extra_fields_field[fields].value eq "July"} selected="selected"{/if}>July</option>
		<option value='August' {if $users_extra_fields_field[fields].value eq "August"} selected="selected"{/if}>August</option>
		<option value='September' {if $users_extra_fields_field[fields].value eq "September"} selected="selected"{/if}>September</option>
		<option value='October' {if $users_extra_fields_field[fields].value eq "October"} selected="selected"{/if}>October</option>
		<option value='November' {if $users_extra_fields_field[fields].value eq "November"} selected="selected"{/if}>November</option>
		<option value='December' {if $users_extra_fields_field[fields].value eq "December"} selected="selected"{/if}>December</option>
	</select>
</td>