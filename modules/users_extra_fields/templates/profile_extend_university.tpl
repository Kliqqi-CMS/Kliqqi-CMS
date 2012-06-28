<td>
	<select  name="{$users_extra_fields_field[fields].name}" id="{$users_extra_fields_field[fields].name}">
		<option value='' {if $users_extra_fields_field[fields].value eq ""} selected="selected"{/if}>University/College</option>
		<option value='University of Ottawa' {if $users_extra_fields_field[fields].value eq "University of Ottawa"} selected="selected"{/if}>University of Ottawa</option>
		<option value='Carleton Unversity' {if $users_extra_fields_field[fields].value eq "Carleton Unversity"} selected="selected"{/if}>Carleton Unversity</option>
		<option value='Algonquin College' {if $users_extra_fields_field[fields].value eq "Algonquin College"} selected="selected"{/if}>Algonquin College</option>
		<option value='La Cité collégiale' {if $users_extra_fields_field[fields].value eq "La Cité collégiale"} selected="selected"{/if}>La Cité collégiale</option>
		<option value='Herzing College' {if $users_extra_fields_field[fields].value eq "Herzing College"} selected="selected"{/if}>Herzing College</option>
	</select>
</td>