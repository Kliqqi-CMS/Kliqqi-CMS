{config_load file=anonymous_comments_lang_conf}

{literal}
<script type="text/javascript">
	function validate(form_id,email) {
		var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
		var address = document.forms[form_id].elements[email].value;
		if(reg.test(address) == false) {
			alert('Invalid Email Address');
			return false;
		}
	}
</script>
{/literal}

<fieldset><legend>{#PLIGG_Anonymous_Comment_Submit_Comment#}</legend>	
	<form action="" method="POST" id="thisform" onsubmit="javascript:return validate('thisform','a_email');">
		<span><b>&nbsp;{#PLIGG_Anonymous_Comment_Name#} :&nbsp;</b></span><br/><input  type ="text" name = "a_username" />{$a_username}<br clear="all" />
{*		<span><b>&nbsp;{#PLIGG_Anonymous_Comment_Website#} :&nbsp;</b></span><br/><input  type ="text" name = "a_website" />{$a_website}<br clear="all" />
		<span><b>&nbsp;{#PLIGG_Anonymous_Comment_Email#} :&nbsp;</b></span><br/><input  type ="text" name = "a_email" />{$a_email}<br clear="all" />
*}
		<label>{#PLIGG_Anonymous_Comment_NoHTML#}</label><br clear="all" />
		<textarea name="comment_content" id="comment" rows="6" cols="60"/>{if isset($TheComment)}{$TheComment}{/if}</textarea><br />
		<br/>
		{if isset($register_step_1_extra)}
			<br />
			{$register_step_1_extra}
		{/if}
		<input type="submit" name="submit" value="{#PLIGG_Anonymous_Comment_Submit#}" class="btn btn-default" />
		<input type="hidden" name="process" value="newcomment" />
		<input type="hidden" name="randkey" value="{$randkey}" />
		<input type="hidden" name="link_id" value="{$link_id}" />
		<input type="hidden" name="user_id" value="{$anonymous_user_id}" />
		<input type="hidden" name="anon" value="1" />
	</form>
</fieldset>

{config_load file=anonymous_comments_pligg_lang_conf}
