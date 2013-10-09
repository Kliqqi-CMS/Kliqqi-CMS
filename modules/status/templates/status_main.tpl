{config_load file=status_lang_conf}

<legend>{#PLIGG_Status#}</legend>
<p>{#PLIGG_Status_Instructions#}</p>
<form action="" method="POST" id="thisform">
	<table class="table table-bordered table-striped">
		<thead>
			<tr>
				<th colspan="2">{#PLIGG_Status_General#}</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td style="text-align:right;min-width:300px;width:300px;"><label><a href="#{#PLIGG_Status_Switch#}">{#PLIGG_Status_Switch#}</a>:</label></td>
				<td>
					<select name="status_switch" class="form-control" style="width:100px;">
						<option value='1' {if $settings.switch>0}selected{/if}>On</option>
						<option value='0' {if $settings.switch==0}selected{/if}>Off</option>
						<option value='-1' {if $settings.switch<0}selected{/if}>Suspend</option>
					</select>
				</td>
			</tr>
			<tr>
				<td style="text-align:right;min-width:300px;width:300px;"><label><a href="#{#PLIGG_Status_Allow_Search#}">{#PLIGG_Status_Allow_Search#}</a>:</label></td>
				<td><input type="checkbox" name="status_allowsearch" id="status_allowsearch" value="1" {if $settings.allowsearch}checked{/if}/></td>
			</tr>
			<tr>
				<td style="text-align:right;min-width:300px;width:300px;"><label><a href="#{#PLIGG_Status_Email_Update#}">{#PLIGG_Status_Email_Update#}</a>:</label></td>
				<td><input type="checkbox" name="status_email" id="status_email" value="1" {if $settings.email}checked{/if}/></td>
			</tr>
			<tr>
				<td style="text-align:right;min-width:300px;width:300px;"><label><a href="#{#PLIGG_Status_Permalinks#}">{#PLIGG_Status_Permalinks#}</a></label></td>
				<td><input type="checkbox" name="status_permalinks" id="status_permalinks" value="1" {if $settings.permalinks}checked{/if}/></td>
			</tr>
			<tr>
				<td style="text-align:right;min-width:300px;width:300px;"><label><a href="#{#PLIGG_Status_Input_On_Other#}">{#PLIGG_Status_Input_On_Other#}</a></label></td>
				<td><input type="checkbox" name="status_inputonother" id="status_inputonother" value="1" {if $settings.inputonother}checked{/if}/></td>
			</tr>
			<tr>
				<td style="text-align:right;min-width:300px;width:300px;"><label><a href="#{#PLIGG_Status_Show_Permalinks#}">{#PLIGG_Status_Show_Permalinks#}</a></label></td>
				<td><input type="checkbox" name="status_show_permalinks" id="status_show_permalinks" value="1" {if $settings.show_permalinks}checked{/if}/></td>
			</tr>
			<tr>
				<td style="text-align:right;min-width:300px;width:300px;"><label><a href="#{#PLIGG_Status_Results#}">{#PLIGG_Status_Results#}</a>:</label></td>
				<td><input type="text" class="form-control" style="width: 100px;" name="status_results" id="status_results" size="3" value="{$settings.results}" /></td>
			</tr>
			<tr>
				<td style="text-align:right;min-width:300px;width:300px;"><label><a href="#{#PLIGG_Status_Max_Char#}">{#PLIGG_Status_Max_Char#}</a>:</label></td>
				<td><input type="text" class="form-control" style="width: 100px;" name="status_max_chars" id="status_max_chars" size="3" value="{$settings.max_chars}" /></td>
			</tr>
			<tr>
				<td style="text-align:right;min-width:300px;width:300px;"><label><a href="#{#PLIGG_Status_Avatar_Size#}">{#PLIGG_Status_Avatar_Size#}</a>:</label></td>
				<td>
					<input type="radio" name="status_avatar" value="small" {if $settings.avatar == 'small'}checked{/if}/> {#PLIGG_Status_Avatar_Small#}<br>
					<input type="radio" name="status_avatar" value="large" {if $settings.avatar == 'large'}checked{/if}/> {#PLIGG_Status_Avatar_Large#}
				</td>
			</tr>
			<tr>
				<td style="text-align:right;min-width:300px;width:300px;"><label><a href="#{#PLIGG_Status_Clock_Format#}">{#PLIGG_Status_Clock_Format#}</a>:</label></td>
				<td>
					<select name="status_clock" class="form-control" style="width: 100px;">
						<option value='24' {if $settings.clock=='24'}selected{/if}>24 hour</option>
						<option value='12' {if $settings.clock=='12'}selected{/if}>12 hour</option>
					</select>
				</td>
			</tr>
			<tr>
				<td></td>
				<td><input type="submit" name="submit" value="{#PLIGG_Status_Submit#}" class="btn btn-primary" /></td>
			</tr>
		</tbody>
	</table>
	<table class="table table-bordered table-striped">
		<thead>
			<tr>
				<th colspan="2">{#PLIGG_Status_Style#}</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td style="text-align:right;min-width:300px;width:300px;"><label><a href="#{#PLIGG_Status_Place#}">{#PLIGG_Status_Place#}</a>:</label></td><td>
					<select name="status_place" class="form-control">
						<option>{#PLIGG_Status_Nowhere#}</option>
					{foreach from=$status_places item=place}
						<option {if $settings.place==$place}selected{/if}>{$place}</option>
					{/foreach}
					</select>
				</td>
			</tr>
			<tr>
				<td style="text-align:right;min-width:300px;width:300px;"><label><a href="#{#PLIGG_Status_Pre_Format#}">{#PLIGG_Status_Pre_Format#}</a>:</label></td>
				<td><input type="text" name="status_pre_format" id="status_pre_format" size="66" value="{$settings.pre_format}" style="width: 420px;"/></td>
			</tr>
			<tr>
				<td style="text-align:right;min-width:300px;width:300px;"><label><a href="#{#PLIGG_Status_Post_Format#}">{#PLIGG_Status_Post_Format#}</a>:</label></td>
				<td><input type="text" class="form-control" name="status_post_format" id="status_post_format" size="66" value="{$settings.post_format}" style="width: 420px;"/></td>
			</tr>
			<tr>
				<td style="text-align:right;min-width:300px;width:300px;"><label><a href="#{#PLIGG_Status_Pre_Comment#}">{#PLIGG_Status_Pre_Comment#}</a>:</label></td>
				<td><input type="text" class="form-control" name="status_pre_comment" id="status_pre_comment" size="66" value="{$settings.pre_comment}" style="width: 420px;"/></td>
			</tr>
			<tr>
				<td style="text-align:right;min-width:300px;width:300px;"><label><a href="#{#PLIGG_Status_Post_Comment#}">{#PLIGG_Status_Post_Comment#}</a>:</label></td>
				<td><input type="text" class="form-control" name="status_post_comment" id="status_post_comment" size="66" value="{$settings.post_comment}" style="width: 420px;"/></td>
			</tr>
			<tr>
				<td style="text-align:right;min-width:300px;width:300px;"><label><a href="#{#PLIGG_Status_Pre_Story#}">{#PLIGG_Status_Pre_Story#}</a>:</label></td>
				<td><input type="text" class="form-control" name="status_pre_story" id="status_pre_story" size="66" value="{$settings.pre_story}" style="width: 420px;"/></td>
			</tr>
			<tr>
				<td style="text-align:right;min-width:300px;width:300px;"><label><a href="#{#PLIGG_Status_Post_Story#}">{#PLIGG_Status_Post_Story#}</a>:</label></td>
				<td><input type="text" class="form-control" name="status_post_story" id="status_post_story" size="66" value="{$settings.post_story}" style="width: 420px;"/></td>
			</tr>
			<tr>
				<td style="text-align:right;min-width:300px;width:300px;"><label><a href="#{#PLIGG_Status_Pre_Username#}">{#PLIGG_Status_Pre_Username#}</a>:</label></td>
				<td><input type="text" class="form-control" name="status_pre_username" id="status_pre_username" size="66" value="{$settings.pre_username}" style="width: 420px;"/></td>
			</tr>
			<tr>
				<td style="text-align:right;min-width:300px;width:300px;"><label><a href="#{#PLIGG_Status_Post_Username#}">{#PLIGG_Status_Post_Username#}</a>:</label></td>
				<td><input type="text" class="form-control" name="status_post_username" id="status_post_username" size="66" value="{$settings.post_username}" style="width: 420px;"/></td>
			</tr>
			<tr>
				<td style="text-align:right;min-width:300px;width:300px;"><label><a href="#{#PLIGG_Status_Pre_Search#}">{#PLIGG_Status_Pre_Search#}</a>:</label></td>
				<td><input type="text" class="form-control" name="status_pre_search" id="status_pre_search" size="66" value="{$settings.pre_search}" style="width: 420px;"/></td>
			</tr>
			<tr>
				<td style="text-align:right;min-width:300px;width:300px;"><label><a href="#{#PLIGG_Status_Post_Search#}">{#PLIGG_Status_Post_Search#}</a>:</label></td>
				<td><input type="text" class="form-control" name="status_post_search" id="status_post_search" size="66" value="{$settings.post_search}" style="width: 420px;"/></td>
			</tr>
			<tr>
				<td style="text-align:right;min-width:300px;width:300px;"><label><a href="#{#PLIGG_Status_Pre_Submit#}">{#PLIGG_Status_Pre_Submit#}</a>:</label></td>
				<td><input type="text" class="form-control" name="status_pre_submit" id="status_pre_submit" size="66" value="{$settings.pre_submit}" style="width: 420px;"/></td>
			</tr>
			<tr>
				<td style="text-align:right;min-width:300px;width:300px;"><label><a href="#{#PLIGG_Status_Post_Submit#}">{#PLIGG_Status_Post_Submit#}</a>:</label></td>
				<td><input type="text" class="form-control" name="status_post_submit" id="status_post_submit" size="66" value="{$settings.post_submit}" style="width: 420px;"/></td>
			</tr>
			<tr>
				<td></td>
				<td><input type="submit" name="submit" value="{#PLIGG_Status_Submit#}" class="btn btn-primary" /></td>	
			</tr>
		</tbody>
	</table>
	<table class="table table-bordered table-striped">
		<thead>
			<tr>
				<th colspan="2">{#PLIGG_Status_Access#}</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td style="text-align:right;min-width:300px;width:300px;"><label><a href="#{#PLIGG_Status_Levels#}">{#PLIGG_Status_Levels#}</a>:</label></td>
				<td>
					<input type="checkbox" name="status_level[]" id="status_level1" value="admin" {if strstr($settings.level,'admin')}checked{/if}/> Admin<br>
					<input type="checkbox" name="status_level[]" id="status_level2" value="moderator" {if strstr($settings.level,'moderator')}checked{/if}/> Moderator<br>
					<input type="checkbox" name="status_level[]" id="status_level3" value="normal" {if strstr($settings.level,'normal')}checked{/if}/> Normal<br>
				</td>
			</tr>
			<tr>
				<td style="text-align:right;min-width:300px;width:300px;"><label><a href="#{#PLIGG_Status_Profile_Levels#}">{#PLIGG_Status_Profile_Levels#}</a>:</label></td>
				<td>
					<input type="checkbox" name="status_profile_level[]" id="status_level1" value="admin" {if strstr($settings.profile_level,'admin')}checked{/if}/> Admin<br>
					<input type="checkbox" name="status_profile_level[]" id="status_level2" value="moderator" {if strstr($settings.profile_level,'admin')}checked{/if}/> Moderator<br>
					<input type="checkbox" name="status_profile_level[]" id="status_level3" value="normal" {if strstr($settings.profile_level,'normal')}checked{/if}/> Normal<br>
				</td>
			</tr>
			<tr>
				<td style="text-align:right;min-width:300px;width:300px;"><label><a href="#{#PLIGG_Status_Groups#}">{#PLIGG_Status_Groups#}</a>:<br /><span class="help-block">{#PLIGG_Status_Groups_Note#}</span></label></td>
				<td><input type="text" class="form-control" name="status_groups" id="status_groups" size="66" value="{$settings.groups}" style="width: 420px;"/></td>
			</tr>
			<tr>
				<td style="text-align:right;min-width:300px;width:300px;"><label><a href="#{#PLIGG_Status_Users#}">{#PLIGG_Status_Users#}</a>:<br /><span class="help-block">{#PLIGG_Status_Users_Note#}</span></label></td>
				<td><input type="text" class="form-control" name="status_users" id="status_users" size="66" value="{$settings.users}" style="width: 420px;"/></td>
			</tr>
			<tr>
				<td></td>
				<td><input type="submit" name="submit" value="{#PLIGG_Status_Submit#}" class="btn btn-primary" /></td>
			</tr>
		</tbody>
	</table>
	<table class="table table-bordered table-striped">
		<thead>
			<tr>
				<th colspan="2">{#PLIGG_Status_Default#}</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td style="text-align:right;min-width:300px;width:300px;"><label><a href="#{#PLIGG_Status_User_Switch#}">{#PLIGG_Status_User_Switch#}</a>:</label></td>
				<td><input type="checkbox" name="status_user_switch" id="status_user_switch" value="1" {if $settings.user_switch}checked{/if}/></td>
			</tr>
			<tr>
				<td style="text-align:right;min-width:300px;width:300px;"><label><a href="#{#PLIGG_Status_User_Friends#}">{#PLIGG_Status_User_Friends#}</a>:</label></td>
				<td><input type="checkbox" name="status_user_friends" id="status_user_friends" value="1" {if $settings.user_friends}checked{/if}/></td>
			</tr>
			<tr>
				<td style="text-align:right;min-width:300px;width:300px;"><label><a href="#{#PLIGG_Status_User_Story#}">{#PLIGG_Status_User_Story#}</a>:</label></td>
				<td><input type="checkbox" name="status_user_story" id="status_user_story" value="1" {if $settings.user_story}checked{/if}/></td>
			</tr>
			<tr>
				<td style="text-align:right;min-width:300px;width:300px;"><label><a href="#{#PLIGG_Status_User_Comment#}">{#PLIGG_Status_User_Comment#}</a>:</label></td>
				<td><input type="checkbox" name="status_user_comment" id="status_user_comment" value="1" {if $settings.user_comment}checked{/if}/></td>
			</tr>
			<tr>
				<td style="text-align:right;min-width:300px;width:300px;"><label><a href="#{#PLIGG_Status_User_Group#}">{#PLIGG_Status_User_Group#}</a>:</label></td>
				<td><input type="checkbox" name="status_user_group" id="status_user_group" value="1" {if $settings.user_group}checked{/if}/></td>
			</tr>
			<tr>
				<td style="text-align:right;min-width:300px;width:300px;"><label><a href="#{#PLIGG_Status_User_Email#}">{#PLIGG_Status_User_Email#}</a>:</label></td>
				<td><input type="checkbox" name="status_user_email" id="status_user_email" value="1" {if $settings.user_email}checked{/if}/></td>
			</tr>
			<tr>
				<td></td>
				<td><input type="submit" name="submit" value="{#PLIGG_Status_Submit#}" class="btn btn-primary" /></td>
			</tr>
		</tbody>
	</table>
</form>
{literal}
<style>
p {margin:10px 0;}
p a {color:#094F89;cursor:pointer;}
</style>
{/literal}
<hr />
<h2>{#Pligg_Status_Use#}</h2>
<p>{#Pligg_Status_Use_Overview#}</p>
<h3>{#Pligg_Status_Use_User#}</h3>
<p>{#Pligg_Status_Use_User_Definition#}</p>
<h3>{#Pligg_Status_Use_Admin#}</h3>
<p>{#Pligg_Status_Use_Admin_Definition#}</p>
<h3>{#Pligg_Status_Use_Groups#}</h3>
<p>{#Pligg_Status_Use_Groups_Definition#}</p>

<hr />
<h2>{#PLIGG_Status_Field_Definitions#}</h2>
<p>{#PLIGG_Status_Field_Definitions_Desc#}</p>
<p><strong><a name="{#PLIGG_Status_Switch#}" href="#{#PLIGG_Status_Switch#}">{#PLIGG_Status_Switch#}</a></strong>: {#PLIGG_Status_Switch_Definition#}</p>
<hr />
<p><strong><a name="{#PLIGG_Status_Email_Update#}" href="#{#PLIGG_Status_Email_Update#}">{#PLIGG_Status_Email_Update#}</a></strong>: {#PLIGG_Status_Email_Update_Definition#}</p>
<hr />
<p><strong><a name="{#PLIGG_Status_Place#}" href="#{#PLIGG_Status_Place#}">{#PLIGG_Status_Place#}</a></strong>: {#PLIGG_Status_Place_Definition#}</p>
<hr />
<p><strong><a name="{#PLIGG_Status_Permalinks#}" href="#{#PLIGG_Status_Permalinks#}">{#PLIGG_Status_Permalinks#}</a></strong>: {#PLIGG_Status_Permalinks_Definition#}</p>
<hr />
<p><strong><a name="{#PLIGG_Status_Input_On_Other#}" href="#{#PLIGG_Status_Input_On_Other#}">{#PLIGG_Status_Input_On_Other#}</a></strong>: {#PLIGG_Status_Input_On_Other_Definition#}</p>
<hr />
<p><strong><a name="{#PLIGG_Status_Show_Permalinks#}" href="#{#PLIGG_Status_Show_Permalinks#}">{#PLIGG_Status_Show_Permalinks#}</a></strong>: {#PLIGG_Status_Show_Permalinks_Definition#}</p>
<hr />
<p><strong><a name="{#PLIGG_Status_Results#}" href="#{#PLIGG_Status_Results#}">{#PLIGG_Status_Results#}</a></strong>: {#PLIGG_Status_Results_Definition#}</p>
<hr />
<p><strong><a name="{#PLIGG_Status_Avatar_Size#}" href="#{#PLIGG_Status_Avatar_Size#}">{#PLIGG_Status_Avatar_Size#}</a></strong>: {#PLIGG_Status_Avatar_Size_Definition#}</p>
<hr />
<p><strong><a name="{#PLIGG_Status_Clock_Format#}" href="#{#PLIGG_Status_Clock_Format#}">{#PLIGG_Status_Clock_Format#}</a></strong>: {#PLIGG_Status_Clock_Format_Definition#}</p>
<hr />
<p><strong><a name="{#PLIGG_Status_Place#}" href="#{#PLIGG_Status_Place#}">{#PLIGG_Status_Place#}</a></strong>: {#PLIGG_Status_Place_Definition#}</p>
<hr />
<p><strong><a name="{#PLIGG_Status_Pre_Format#}" href="#{#PLIGG_Status_Pre_Format#}">{#PLIGG_Status_Pre_Format#}</a></strong>: {#PLIGG_Status_Pre_Format_Definition#}</p>
<hr />
<p><strong><a name="{#PLIGG_Status_Post_Format#}" href="#{#PLIGG_Status_Post_Format#}">{#PLIGG_Status_Post_Format#}</a></strong>: {#PLIGG_Status_Post_Format_Definition#}</p>
<hr />
<p><strong><a name="{#PLIGG_Status_Pre_Comment#}" href="#{#PLIGG_Status_Pre_Comment#}">{#PLIGG_Status_Pre_Comment#}</a></strong>: {#PLIGG_Status_Pre_Comment_Definition#}</p>
<hr />
<p><strong><a name="{#PLIGG_Status_Post_Comment#}" href="#{#PLIGG_Status_Post_Comment#}">{#PLIGG_Status_Post_Comment#}</a></strong>: {#PLIGG_Status_Post_Comment_Definition#}</p>
<hr />
<p><strong><a name="{#PLIGG_Status_Pre_Story#}" href="#{#PLIGG_Status_Pre_Story#}">{#PLIGG_Status_Pre_Story#}</a></strong>: {#PLIGG_Status_Pre_Story_Definition#}</p>
<hr />
<p><strong><a name="{#PLIGG_Status_Post_Story#}" href="#{#PLIGG_Status_Post_Story#}">{#PLIGG_Status_Post_Story#}</a></strong>: {#PLIGG_Status_Post_Story_Definition#}</p>
<hr />
<p><strong><a name="{#PLIGG_Status_Pre_Username#}" href="#{#PLIGG_Status_Pre_Username#}">{#PLIGG_Status_Pre_Username#}</a></strong>: {#PLIGG_Status_Pre_Username_Definition#}</p>
<hr />
<p><strong><a name="{#PLIGG_Status_Post_Username#}" href="#{#PLIGG_Status_Post_Username#}">{#PLIGG_Status_Post_Username#}</a></strong>: {#PLIGG_Status_Post_Username_Definition#}</p>
<hr />
<p><strong><a name="{#PLIGG_Status_Levels#}" href="#{#PLIGG_Status_Levels#}">{#PLIGG_Status_Levels#}</a></strong>: {#PLIGG_Status_Levels_Definition#}</p>
<hr />
<p><strong><a name="{#PLIGG_Status_Profile_Levels#}" href="#{#PLIGG_Status_Profile_Levels#}">{#PLIGG_Status_Profile_Levels#}</a></strong>: {#PLIGG_Status_Profile_Levels_Definition#}</p>
<hr />
<p><strong><a name="{#PLIGG_Status_Groups#}" href="#{#PLIGG_Status_Groups#}">{#PLIGG_Status_Groups#}</a></strong>: {#PLIGG_Status_Groups_Definition#}</p>
<hr />
<p><strong><a name="{#PLIGG_Status_Users#}" href="#{#PLIGG_Status_Users#}">{#PLIGG_Status_Users#}</a></strong>: {#PLIGG_Status_Users_Definition#}</p>
<hr />
<p><strong><a name="{#PLIGG_Status_User_Switch#}" href="#{#PLIGG_Status_User_Switch#}">{#PLIGG_Status_User_Switch#}</a></strong>: {#PLIGG_Status_User_Switch_Definition#}</p>
<hr />
<p><strong><a name="{#PLIGG_Status_User_Friends#}" href="#{#PLIGG_Status_User_Friends#}">{#PLIGG_Status_User_Friends#}</a></strong>: {#PLIGG_Status_User_Friends_Definition#}</p>
<hr />
<p><strong><a name="{#PLIGG_Status_User_Story#}" href="#{#PLIGG_Status_User_Story#}">{#PLIGG_Status_User_Story#}</a></strong>: {#PLIGG_Status_User_Story_Definition#}</p>
<hr />
<p><strong><a name="{#PLIGG_Status_User_Comment#}" href="#{#PLIGG_Status_User_Comment#}">{#PLIGG_Status_User_Comment#}</a></strong>: {#PLIGG_Status_User_Comment_Definition#}</p>
<hr />
<p><strong><a name="{#PLIGG_Status_User_Email#}" href="#{#PLIGG_Status_User_Email#}">{#PLIGG_Status_User_Email#}</a></strong>: {#PLIGG_Status_User_Email_Definition#}</p>
<hr />

{config_load file=status_pligg_lang_conf}