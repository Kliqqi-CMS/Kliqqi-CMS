{config_load file=karma_lang_conf}

{if $error}
	<div style="padding:10px;margin:10px 0;border:1px solid #d0d0ce;background:#fffeeb;font-weight:bold;">
		<font color=red>{$error}</font>
	</div>
{elseif $templatelite.post.submit}
	<div style="padding:10px;margin:10px 0;border:1px solid #d0d0ce;background:#fffeeb;font-weight:bold;">
		<font color=green>{#PLIGG_Karma_Saved#}</font>
	</div>
{/if}

<fieldset><legend>{#PLIGG_Karma#}</legend>
<p>{#PLIGG_Karma_Instructions#}</p>
<br />
	<form action="" method="POST" id="thisform">
		<table border="0" cellspacing="8">
		<tr>
		<td width="50"><label>{#PLIGG_Karma_Story_Published#}: </label></td><td><input type="text" name="karma_story_publish" size="66" value="{$settings.story_publish}" style="width: 420px;"/></td>
		</tr>
		<tr>
		<td width="50"><label>{#PLIGG_Karma_Story_Submit#}: </label></td><td><input type="text" name="karma_submit_story" size="66" value="{$settings.submit_story}" style="width: 420px;"/></td>
		</tr>
		<tr>
		<td width="50"><label>{#PLIGG_Karma_Comment_Submit#}: </label></td><td><input type="text" name="karma_submit_comment" size="66" value="{$settings.submit_comment}" style="width: 420px;"/></td>
		</tr>
		<tr>
		<td width="50"><label>{#PLIGG_Karma_Story_Discard#}: </label></td><td><input type="text" name="karma_story_discard" size="66" value="{$settings.story_discard}" style="width: 420px;"/></td>
		</tr>
		<tr>
		<td width="50"><label>{#PLIGG_Karma_Comment_Delete#}: </label></td><td><input type="text" name="karma_comment_delete" size="66" value="{$settings.comment_delete}" style="width: 420px;"/></td>
		</tr>
		<tr>
		<td width="50"><label>{#PLIGG_Karma_Story_Spam#}: </label></td><td><input type="text" name="karma_story_spam" size="66" value="{$settings.story_spam}" style="width: 420px;"/></td>
		</tr>
		<tr>
		<td width="50"><label>{#PLIGG_Karma_Story_Vote#}: </label></td><td><input type="text" name="karma_story_vote" size="66" value="{$settings.story_vote}" style="width: 420px;"/></td>
		</tr>
		<tr>
		<td width="50"><label>{#PLIGG_Karma_Story_Vote_Remove#}: </label></td><td><input type="text" name="karma_story_vote_remove" size="66" value="{$settings.story_vote_remove}" style="width: 420px;"/></td>
		</tr>
		<tr>
		<td width="50"><label>{#PLIGG_Karma_Comment_Vote#}: </label></td><td><input type="text" name="karma_comment_vote" size="66" value="{$settings.comment_vote}" style="width: 420px;"/></td>
		</tr>
		<tr>
		<td width="50"><label>{#PLIGG_Karma_Add_User#}: </label></td><td>{#PLIGG_Karma_Username#}: <input type="text" name="karma_username" size="22" style="width: 140px;"/>
		{#PLIGG_Karma_Value#}: <input type="text" name="karma_value" size="11" style="width: 45px;"/><br>
		</td>
		</tr>

		<tr><td width="250"></td><td><Br /><input type="submit" name="submit" value="{#PLIGG_Karma_Submit#}" class="log2" style="font-weight:bold;padding:2px 15px 2px 15px"/><br /><br /></td></tr>

		</table>
	</form>

{*
<hr />
<h2>{#PLIGG_Karma_Field_Definitions#}</h2>
<p>{#PLIGG_Karma_Field_Definitions_Desc#}</p>
{literal}
<style>
p {margin:10px 0;}
strong {font-size:14px;}
</style>
{/literal}
*}

</fieldset>

{config_load file=karma_pligg_lang_conf}