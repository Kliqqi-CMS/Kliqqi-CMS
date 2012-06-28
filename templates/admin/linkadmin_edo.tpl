<h1>{#PLIGG_Visual_Change_Link_Status#}</h1>
<strong>{#PLIGG_Visual_Change_Link_Reason#}</strong><br /><br />
<form method="post">
	<input type="hidden" name = "id" value="{$link_id}">
	<input type="hidden" name = "action" value="edodiscard">
	<input type="radio" name="reason" value="spam">{#PLIGG_Visual_Change_Link_Reason_Spam#}<br />
	<input type="radio" name="reason" value="other">{#PLIGG_Visual_EditStory_Reason_other#}: <input type="text" name="otherreason" size="75">
	<br /><br /><input type = "submit" name = "submit" value = "submit" class="log2">
</form>