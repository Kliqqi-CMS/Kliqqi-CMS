{config_load file=spam_trigger_lang_conf}

<fieldset><legend> {#PLIGG_Spam_Trigger#}</legend>
<p>{#PLIGG_Spam_Trigger_Instructions#}</p>
<br />


	<form action="" method="POST" id="thisform">
		<table border="0" cellspacing="8">

		<tr>
		<td width="250" colspan="2"><h2>{#PLIGG_Spam_Trigger_Light_List#}: </h2></td>
		</tr>
		<tr>
		<td width="250" colspan="2">{#PLIGG_Spam_Trigger_Light_Description#}<br><textarea name='spam_light' rows=20 cols=80>{$settings.spam_light}</textarea></td>
		</tr>

		<tr>
		<td width="250" colspan="2"><h2>{#PLIGG_Spam_Trigger_Medium_List#}: </h2></td>
		</tr>
		<tr>
		<td width="250" colspan="2">{#PLIGG_Spam_Trigger_Medium_Description#}<br><textarea name='spam_medium' rows=20 cols=80>{$settings.spam_medium}</textarea></td>
		</tr>

		<tr>
		<td width="250" colspan="2"><h2>{#PLIGG_Spam_Trigger_Hard_List#}: </h2></td>
		</tr>
		<tr>
		<td width="250" colspan="2">{#PLIGG_Spam_Trigger_Hard_Description#}<br><textarea name='spam_hard' rows=20 cols=80>{$settings.spam_hard}</textarea></td>
		</tr>

		<tr><td width="250"></td><td><Br /><input type="submit" name="submit" value="{#PLIGG_Spam_Trigger_Submit#}" class="log2" style="font-weight:bold;padding:2px 15px 2px 15px"/><br /><br /></td></tr>

		</table>
	</form>

<hr />

{config_load file=spam_trigger_pligg_lang_conf}
