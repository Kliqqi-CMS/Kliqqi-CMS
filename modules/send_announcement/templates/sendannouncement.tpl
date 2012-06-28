{config_load file=send_announcement_lang_conf}

{php}	
	function announcement()
	{
		global $db;
		$email = $db->get_col('SELECT user_email FROM ' . table_users . ';');
	
		if ($email)
		{
			foreach($email as $to) 
			{
				$from = SENDER;
				$message = $_POST['msg'];
				$subject = $_POST['sub'];
				mail($to, $subject, $message, "From: $from");
			}
		}
	}
	
	if(isset($_POST['submit']))
	{
		define('SENDER', 'insert_your_email_address_here');		// put the e-mail id that you want to see in from address
		announcement();
		echo '<fieldset><legend>';{/php}{#Pligg_Send_Announcemet#}{php}echo'</legend><br/><center><font color="green">';{/php}{#Pligg_Send_Announcement_Sent#}{php}echo'</font><br/></center></fieldset>';
	}
	else {
{/php}

	<fieldset><legend><img src="{$my_pligg_base}/templates/admin/images/email.gif" align="absmiddle" /> {#Pligg_Send_Announcemet#}</legend>
		<form name="frm" action="" onSubmit="return errorCheck();" method="post"><br>
			{#Pligg_Send_Announcement_Subject#}:<br/><input type="text" name="sub" value="" size="50"><br><br>
			{#Pligg_Send_Announcement_Message#}:<br><textarea name="msg" id="message" rows="10" cols="40"></textarea><br />
			{if $Spell_Checker eq 1}<input type="button" name="spelling" value="{#Pligg_Send_Announcement_Check_Spelling#}" class="log2" onClick="openSpellChecker('message');"/>{/if}
				
			<br /><br /><input type="submit" name="submit" value="{#Pligg_Send_Announcement_Submit#}" class="submit" />
		</form>
	</fieldset>

	{literal}
	<script type="text/javascript">
	{	
		function errorCheck()
		{
			var subject=document.forms['frm'].elements['sub'].value;
			var mess=document.forms['frm'].elements['msg'].value;
			if(subject=="")
			{
				alert("Please enter the subject!");//("{#Pligg_Send_Announcement_Subject_Error#}");
				return false;
			}
			if(mess=="")
			{
				alert ("Please enter the Message!");//("{#Pligg_Send_Announcement_Message_Error#}");
				return false;
			}
			return true;
		}
	}	
	</script>
	{/literal}
{php}
}
{/php}