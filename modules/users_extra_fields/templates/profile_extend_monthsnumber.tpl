<td>
	<select  name="{$users_extra_fields_field[fields].name}" id="{$users_extra_fields_field[fields].name}">
		<option value='' {if $users_extra_fields_field[fields].value eq ""} selected="selected"{/if}>Select a month</option>
		<option value='01' {if $users_extra_fields_field[fields].value eq "01"} selected="selected"{/if}>01</option>
		<option value='02' {if $users_extra_fields_field[fields].value eq "02"} selected="selected"{/if}>02</option>
		<option value='03' {if $users_extra_fields_field[fields].value eq "03"} selected="selected"{/if}>03</option>
		<option value='04' {if $users_extra_fields_field[fields].value eq "04"} selected="selected"{/if}>04</option>
		<option value='05' {if $users_extra_fields_field[fields].value eq "05"} selected="selected"{/if}>05</option>
		<option value='06' {if $users_extra_fields_field[fields].value eq "06"} selected="selected"{/if}>06</option>
		<option value='07' {if $users_extra_fields_field[fields].value eq "07"} selected="selected"{/if}>07</option>
		<option value='08' {if $users_extra_fields_field[fields].value eq "08"} selected="selected"{/if}>08</option>
		<option value='09' {if $users_extra_fields_field[fields].value eq "09"} selected="selected"{/if}>09</option>
		<option value='10' {if $users_extra_fields_field[fields].value eq "10"} selected="selected"{/if}>10</option>
		<option value='11' {if $users_extra_fields_field[fields].value eq "11"} selected="selected"{/if}>11</option>
		<option value='12' {if $users_extra_fields_field[fields].value eq "12"} selected="selected"{/if}>12</option>
	</select>
</td>