<td>
	<select  name="{$users_extra_fields_field[fields].name}" id="{$users_extra_fields_field[fields].name}">
		<option value='' {if $users_extra_fields_field[fields].value eq ""} selected="selected"{/if}>No vehicle</option>
		<option value='sedan' {if $users_extra_fields_field[fields].value eq "sedan"} selected="selected"{/if}>sedan</option>
		<option value='sportscar' {if $users_extra_fields_field[fields].value eq "sportscar"} selected="selected"{/if}>sportscar</option>
		<option value='convertible' {if $users_extra_fields_field[fields].value eq "convertible"} selected="selected"{/if}>convertible</option>
		<option value='station wagon' {if $users_extra_fields_field[fields].value eq "station wagon"} selected="selected"{/if}>station wagon</option>
		<option value='suv' {if $users_extra_fields_field[fields].value eq "suv"} selected="selected"{/if}>suv</option>
		<option value='pickup' {if $users_extra_fields_field[fields].value eq "pickup"} selected="selected"{/if}>pickup</option>
		<option value='offroad' {if $users_extra_fields_field[fields].value eq "offroad"} selected="selected"{/if}>offroad</option>
		<option value='van' {if $users_extra_fields_field[fields].value eq "van"} selected="selected"{/if}>van</option>
		<option value='caravan' {if $users_extra_fields_field[fields].value eq "caravan"} selected="selected"{/if}>caravan</option>
		<option value='speedboat' {if $users_extra_fields_field[fields].value eq "speedboat"} selected="selected"{/if}>speedboat</option>
		<option value='motorcycle' {if $users_extra_fields_field[fields].value eq "motorcycle"} selected="selected"{/if}>motorcycle</option>
	</select>
</td>