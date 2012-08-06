<!-- users.tpl -->
{* 
<script language="JavaScript" type="text/javascript" src="{$my_base_url}{$my_pligg_base}/templates/admin/js/jquery/jquery.form.js"></script>
<script language="JavaScript" type="text/javascript" src="{$my_base_url}{$my_pligg_base}/templates/admin/js/jquery/jquery.validate.js"></script>

<!-- JDR: Themeroller files and my generic base
<link type="text/css" href="http://localhost/svnpligg/trunk/templates/admin/inc/css/ui-lightness/jquery-ui-1.7.2.custom.css" rel="stylesheet" />  -->

<!--<script language="JavaScript" type="text/javascript">
{literal}
jQuery(function() {
    jQuery().ajaxError(function(a, b, e) {
        throw e;
    });
	
	// JDR: our form submit and valiation
	var aform = $("#createUserForm").validate({
	    
		// JDR: make sure we show/hide both blocks
		errorContainer: "#errorblock-div1, #errorblock-div2",
	    
		// JDR: put all error messages in a UL
		errorLabelContainer: "#errorblock-div2 ul",
	    
		// JDR: wrap all error messages in an LI tag
		wrapper: "li",
	    
		// JDR: rules/messages are for the validation
		rules: {
	        username: "required",
	        email: {
	            required: true,
	            email: true
	                }
	    },
	    messages: {
	        username: "Please enter a user name.",
	        email: {
	            required: "Please enter an email address.",
	            email: "Please enter a valid email address."
	                }
	    }
		
		
		// JDR: our form submit
	  /* submitHandler: function(form) {
	        jQuery(form).ajaxSubmit({
				// JDR: the return target block
	            target: '#client-script-return-data',
				
				// JDR: what to do on form submit success
	            success: function() { $('#createUserForm-modal').dialog('close'); successEvents('#client-script-return-msg'); }
	         });
	     }*/
	}); 
	
	// JDR: our modal dialog setup
	var amodal = $("#my-modal-form").dialog({
	   bgiframe: true,
	   autoOpen: false,
	   height: 350,
	   width: 300,
	   modal: true,
	   buttons: {
	      'Update Data': function() 
		  { 
		  	// JDR: submit the form
		  	$("#modal-form-test").submit(); 
		  },
	      Cancel: function() 
		  { 
		  	// JDR: close the dialog, reset the form
		    $(this).dialog('close'); aform.resetForm(); 
		  }
	   }
	});
	
	
	// JDR: onclick action for our button
	var abutton = $('#load-my-modal').click(function() {
	    $('#createUserForm-modal').dialog('open');
	});
	
	// JDR: this sets up a hover effect for all buttons
   
	
}); // JDR: end main jQuery function start

function successEvents(msg) {

    // JDR: microseconds to show return message block
    var defaultmessagedisplay = 10000;
    
    // JDR: fade in our return message block
    $(msg).fadeIn('slow');

    // JDR: remove return message block
    setTimeout(function() { $(msg).fadeOut('slow'); }, defaultmessagedisplay);
};
{/literal}	
</script> *}
<legend>{#PLIGG_Visual_AdminPanel_User_Manage#}</legend>
{include file="/admin/user_create.tpl"}
<table>
	<tr>
		<form action="{$my_base_url}{$my_pligg_base}/admin/admin_users.php" method="get">
			<td>
				<div class="input-append">
					<input type="hidden" name="mode" value="search">
					{if isset($templatelite.get.keyword) && $templatelite.get.keyword neq ""}
							{assign var=searchboxtext value=$templatelite.get.keyword|sanitize:2}
					{else}
							{assign var=searchboxtext value=#PLIGG_Visual_Search_SearchDefaultText#}			
					{/if}
					<input type="text" size="30" class="span7" name="keyword" value="{$searchboxtext}" onfocus="if(this.value == '{$searchboxtext}') {ldelim}this.value = '';{rdelim}" onblur="if (this.value == '') {ldelim}this.value = '{$searchboxtext}';{rdelim}"><button type="submit" class="btn">{#PLIGG_Visual_Search_Go#}</button>
				</div>
			</td>
			<td>
				<select name="filter" style="margin-right:10px;"onchange="this.form.submit()">
					<option value="">-- User Level --</option>
					<option value="admin" {if $templatelite.get.filter == "admin"} selected="selected" {/if}>Admin</option>
					<option value="moderator" {if $templatelite.get.filter == "moderator"} selected="selected" {/if}>Moderator</option>
					<option value="normal" {if $templatelite.get.filter == "normal"} selected="selected" {/if}>Normal</option>
					<option value="spammer" {if $templatelite.get.filter == "spammer"} selected="selected" {/if}>Spammer</option>
				</select>
			</td>
			<td>
				<select name="pagesize" onchange="this.form.submit()">
					<option value="15" {if isset($pagesize) && $pagesize == 15}selected{/if}>Show 15</option>
					<option value="30" {if isset($pagesize) && $pagesize == 30}selected{/if}>Show 30</option>
					<option value="50" {if isset($pagesize) && $pagesize == 50}selected{/if}>Show 50</option>
					<option value="100" {if isset($pagesize) && $pagesize == 100}selected{/if}>Show 100</option>
					<option value="200" {if isset($pagesize) && $pagesize == 200}selected{/if}>Show 200</option>
				</select>
			</td>
		</form>
        
		<form name='bulk' action="{$my_base_url}{$my_pligg_base}/admin/admin_users.php" method="post">
			<td style="float:right;"><input type="submit" class="btn btn-primary" name="submit" value="{#PLIGG_Visual_AdminPanel_Apply_Changes#}" /></td>
	</tr>
</table>
{if isset($usererror)}
	<span class="error">{$usererror}</span><br/>
{/if}
{$hidden_token_admin_users_list}
<table class="table table-bordered table-striped table-condensed">
	<thead>
		<tr>
			<th style="width:40px;text-align:center;">ID</th>
			<th>{#PLIGG_Visual_Login_Username#}</th>
			<th style="text-align:center;">{#PLIGG_Visual_View_User_Level#}</th>
			<th>{#PLIGG_Visual_View_User_Email#}</th>
			<th style="width:140px">{#PLIGG_Visual_User_Profile_Joined#}</th>
			<th style="text-align:center;">{#PLIGG_Visual_User_Profile_Enabled#}</th>
			<th style="text-align:center;"><input type='checkbox' onclick='check_all(this);' style="margin:0px 4px 3px 0;">{#PLIGG_Visual_KillSpam#}</th>
		</tr>
	</thead>
	<tbody>
		{section name=nr loop=$userlist}
			<tr {if $userlist[nr].user_enabled eq '0'}class="tr_moderated"{/if}>
				<td style="width:40px;text-align:center;vertical-align:middle;">{$userlist[nr].user_id}</td>
				<td style="vertical-align:middle;"><img src="{$userlist[nr].Avatar}" style="height:18px;width:18px;" /> <a href = "?mode=view&user={$userlist[nr].user_login}">{$userlist[nr].user_login}</a></td>	
				<td style="text-align:center;vertical-align:middle;">{$userlist[nr].user_level}</td>
				<td style="vertical-align:middle;">
					{if $userlist[nr].user_lastlogin neq "0000-00-00 00:00:00"}
						<i class="icon icon-ok" title="{#PLIGG_Visual_AdminPanel_Confirmed_Email#}" alt="{#PLIGG_Visual_AdminPanel_Confirmed_Email#}"></i>
					{else}
						<a data-toggle="modal" href="{$my_base_url}{$my_pligg_base}/admin/admin_user_validate.php?id={$userlist[nr].user_id}" title="{#PLIGG_Visual_AdminPanel_Confirmed_Email#}"><i class="icon icon-warning-sign" title="{#PLIGG_Visual_AdminPanel_Unconfirmed_Email#}"></i></a>
					{/if}
					<a href="mailto:{$userlist[nr].user_email}" target="_blank">{$userlist[nr].user_email|truncate:25:"...":true}</a>
				</td>
				<td>{$userlist[nr].user_date}</td>
				<td style="text-align:center;vertical-align:middle;">
					<input type="checkbox" onclick="document.getElementById('enabled_{$userlist[nr].user_id}').value=this.checked ? 1 : 0;" {if $userlist[nr].user_enabled}checked{/if}>
					<input type="hidden" name="enabled[{$userlist[nr].user_id}]" id="enabled_{$userlist[nr].user_id}" value="{$userlist[nr].user_enabled}">
				</td>
				<td style="text-align:center;vertical-align:middle;"><div style="text-align:center"><input type='checkbox' id='killspam' name='delete[]' value='{$userlist[nr].user_id}'></div></td>	
			</tr>
		{/section}
	</tbody>
</table>
<div style="float:right;margin:8px 2px 0 0;">
<a class="btn btn-success"  href="#createUserForm-modal" data-toggle="modal" title="{#PLIGG_Visual_AdminPanel_New_User#}">{#PLIGG_Visual_AdminPanel_New_User#}</a>
	<input type="submit" class="btn btn-primary" name="submit" value="{#PLIGG_Visual_AdminPanel_Apply_Changes#}" />
</div>
</form>

<div style="clear:both;"></div>

<SCRIPT>
{literal}
function check_all(elem) {
	for (var i=0; i< document.bulk.length; i++) 
		if (document.bulk[i].id == "killspam")
			document.bulk[i].checked = elem.checked;
}
{/literal}
</SCRIPT>
<!--/users.tpl -->