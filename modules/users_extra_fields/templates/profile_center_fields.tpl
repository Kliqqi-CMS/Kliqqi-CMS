{section name=fields loop=$users_extra_fields_field}
	{if $users_extra_fields_field[fields].show_to_user eq TRUE}
		<tr>
			{*================================*}
			{* First we put in a table cell the description of the field, which is defined in *}
			{* profiles_settings.php *}
			{*================================*}

			<td>
				{$users_extra_fields_field[fields].show_to_user_text}
			</td>

			{*================================*}
			{* Now we have to check for fields that are other than input text *}
			{* It is very important to use a standard that is not confusing *}
			{* For example if you defined in profiles_settings.php a field for Country *}
			{* than automatically you know that this field is going to be a select option *}
			{* The same applies for any drop down option that you define*}
			{* In this case we have a drop down for selecting the following: *}
			{* Age, Gender, Status, Habits, Car, Country, and State/Province *}
			{* All the above are template files, so we want to reference them to load and *}
			{* display the corresponding information *}

			{* So we check using the IF condition for the occurences *}
			{*================================*}

			{*================================*}
			{* field == 1 == *}
			{* For the Age, we load the appropriate file "profile_extend_age.tpl" *}
			{*================================*}

			{if $users_extra_fields_field[fields].show_to_user_text eq 'Age:'}
				{checkActionsTpl location="tpl_show_extra_profile_age"}

			{*================================*}
			{* field == 2 == *}
			{* For the Gender, we load the appropriate file "profile_extend_gender.tpl" *}
			{*================================*}

			{elseif $users_extra_fields_field[fields].show_to_user_text eq 'Gender:'}
				{checkActionsTpl location="tpl_show_extra_profile_gender"}

			{elseif $users_extra_fields_field[fields].show_to_user_text eq 'University/College:'}
				{checkActionsTpl location="tpl_show_extra_profile_university"}

			{*================================*}
			{* field == 3 == *}
			{* For the Status, we load the appropriate file "profile_extend_status.tpl" *}
			{*================================*}

			{elseif $users_extra_fields_field[fields].show_to_user_text eq 'Status:'}
				{checkActionsTpl location="tpl_show_extra_profile_status"}

			{*================================*}
			{* field == 4 == *}
			{* For the Habits, we load the appropriate file "profile_extend_habits.tpl" *}
			{*================================*}

			{elseif $users_extra_fields_field[fields].show_to_user_text eq 'Smoking:'}
				{checkActionsTpl location="tpl_show_extra_profile_habits"}

			{*================================*}
			{* field == 5 == *}
			{* For the Car, we load the appropriate file "profile_extend_car.tpl" *}
			{*================================*}

			{elseif $users_extra_fields_field[fields].show_to_user_text eq 'Car:'}
				{checkActionsTpl location="tpl_show_extra_profile_car"}

			{*================================*}
			{* field == 6 == *}
			{* For the Country, we load the appropriate file "profile_extend_country.tpl" *}
			{*================================*}

			{elseif $users_extra_fields_field[fields].show_to_user_text eq 'Country:'}
				{checkActionsTpl location="tpl_show_extra_profile_country"}

			{*================================*}
			{* field == 7 == *}
			{* For the State/Province, we load the appropriate file "profile_extend_state.tpl" *}
			{*================================*}

			{elseif $users_extra_fields_field[fields].show_to_user_text eq 'State/Province:'}
				{checkActionsTpl location="tpl_show_extra_profile_state"}

			{*================================*}
			{* field == 8 == *}
			{* Now we check to see if we have any fields that are textarea *}
			{* and we load the appropriate file "profile_extend_bio.tpl" *}
			{*================================*}

			{elseif $users_extra_fields_field[fields].show_to_user_text eq 'Bio:'}
				{checkActionsTpl location="tpl_show_extra_profile_bio"}


			{*================================*}
			{* field == 9 == *}
			{* Now we check to see if we have any fields that are type radio *}
			{* and we load the appropriate file "profile_extend_subscription.tpl" *}
			{*================================*}

			{elseif $users_extra_fields_field[fields].show_to_user_text eq 'Subscription:'}
				{checkActionsTpl location="tpl_show_extra_profile_subscription"}



			{*================================*}
			{* if none of the above applies, then it is an input type text *}
			{*================================*}

			{else}
			<td>
				<input type="text" name="{$users_extra_fields_field[fields].name}" id="{$users_extra_fields_field[fields].name}" value="{$users_extra_fields_field[fields].value}">
			</td>
			{/if}
		</tr>
	{/if}
{/section}
