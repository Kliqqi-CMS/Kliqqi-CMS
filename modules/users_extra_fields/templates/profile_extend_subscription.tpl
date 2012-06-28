<td>
	<input type="radio" name="{$users_extra_fields_field[fields].name}" value="0" {if $users_extra_fields_field[fields].value eq "0"} checked="checked"{/if}>Hourly<br/>
	<input type="radio" name="{$users_extra_fields_field[fields].name}" value="1" {if $users_extra_fields_field[fields].value eq "1"} checked="checked"{/if}>Daily<br/>
	<input type="radio" name="{$users_extra_fields_field[fields].name}" value="2" {if $users_extra_fields_field[fields].value eq "2"} checked="checked"{/if}>Weekly<br/>
	<input type="radio" name="{$users_extra_fields_field[fields].name}" value="3" {if $users_extra_fields_field[fields].value eq "2"} checked="checked"{/if}>No Notification<br/>
</td>