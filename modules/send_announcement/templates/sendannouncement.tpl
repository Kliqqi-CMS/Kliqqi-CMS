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
		define('SENDER', $this->_confs['Pligg_Send_Announcemet_Email']);		// put the e-mail id that you want to see in from address
		announcement();
		{/php}
		<div class="alert fade in">
			<a class="close" data-dismiss="alert" href="#">×</a>
			<h4 class="alert-heading">{#Pligg_Send_Announcemet#}</h4>
			{#Pligg_Send_Announcement_Sent#}
		</div>
		{php}
	} else {
{/php}
	<legend><img src="{$my_pligg_base}/modules/send_announcement/templates/email.gif" align="absmiddle" /> {#Pligg_Send_Announcemet#}</legend>
	
	<p>{#Pligg_Send_Announcemet_Description#}</p>
	
	<form name="frm" action="" onSubmit="return errorCheck();" method="post">
		{#Pligg_Send_Announcement_Subject#}:<br /><input type="text" name="sub" value="" class="span9" /><br /><br />
		{#Pligg_Send_Announcement_Message#}:<br /><textarea name="msg" id="message" rows="10" class="span9"></textarea><br />
		{if $Spell_Checker eq 1}<input type="button" name="spelling" value="{#Pligg_Send_Announcement_Check_Spelling#}" class="btn" onClick="openSpellChecker('message');"/>{/if}
		<br /><input type="submit" name="submit" value="{#Pligg_Send_Announcement_Submit#}" class="btn btn-primary" />
	</form>

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

{config_load file=send_announcement_pligg_lang_conf}