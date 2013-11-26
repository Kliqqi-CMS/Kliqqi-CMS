<!-- users.tpl -->
{literal}

<script type="text/javascript">
	$(function () {
		$("[rel='tooltip']").tooltip();
	});
</script>

<script type="text/javascript" language="javascript">
function submit_list_form(){
	
	if($(".enabled_disable:checked").length==0) {
		alert("Please select users");
		return false;
	}
	
	val_action=$("#admin_action").val();
	
	if(val_action==3){
		var usernames ="";
		$('.enabled_disable:checked').each(function(i){
			usernames += $(this).attr("usernameval")+", ";
		});
		if(confirm("Are you sure that you want to killspam these users: "+usernames)){
        
		} else {
			return false;
		}
	}
	
	document.getElementById("user_list_form").submit();
	
	//for(x in document.getElementById("user_list_form"))
	//alert(x);
	//alert(document.getElementById("user_list_form"));
}

$(function(){
	// add multiple select / deselect functionality
	$("#selectall_user_ed").click(function () {
		  $('.enabled_disable').attr('checked', this.checked);
	});
	// if all checkbox are selected, check the selectall checkbox
	// and viceversa
	$(".enabled_disable").click(function(){
		if($(".enabled_disable").length == $(".enabled_disable:checked").length) {
			$("#selectall_user_ed").attr("checked", "checked");
		} else {
			$("#selectall_user_ed").removeAttr("checked");
		}
	});
});

function set_admin_action(acc){
	if(acc==1){
		$("#selected_action").addClass("fa fa-check-square-o");
		$("#selected_action").removeClass("fa fa-ban");
		$("#selected_action").removeClass("fa fa-fa-square-o");
		$("#admin_action").val(1);
	}
	if(acc==2){
		$("#selected_action").addClass("fa fa-fa-square-o");
		$("#selected_action").removeClass("fa fa-check-square-o");
		$("#selected_action").removeClass("fa fa-ban");
		$("#admin_action").val(2);
	}
	if(acc==3){
		$("#selected_action").addClass("fa fa-ban");
		$("#selected_action").removeClass("fa fa-fa-square-o");
		$("#selected_action").removeClass("fa fa-check-square-o");
		$("#admin_action").val(3);
	}
	submit_list_form(); 
}

function validate_all_user_action(){
	if($("#admin_action").val()==""){
		alert("select user list");
		return false;
	}
}
</script>
{/literal}
<legend>{#PLIGG_Visual_AdminPanel_User_Manage#}</legend>
{if $moderated_users_count neq "0"}
	<div class="alert alert-warning">
		There {if $moderated_users_count eq "1"}is{else}are{/if} <strong>{$moderated_users_count} {if $moderated_users_count eq "1"}user{else}users{/if}</strong> awaiting moderation.<br />
		<a href="admin_users.php?filter=disabled">Click here to review the {if $moderated_users_count eq "1"}acccount{else}accounts{/if}.</a>
	</div>
{/if}

<form action="{$my_base_url}{$my_pligg_base}/admin/admin_users.php" method="get" >
	<div class="row management-tools">
		<div class="col-md-3">
			<div class="btn-group pull">
				<a class="btn btn-default dropdown-toggle" href="#" data-toggle="dropdown">
					<i id="selected_action"></i>
					{#PLIGG_Visual_AdminPanel_Apply_Changes#}
					<span class="caret"></span>
				</a>
				<ul class="dropdown-menu">
					<li>
						<a onclick="set_admin_action('1')" href="#">
							<i class="fa fa-check-square-o"></i>
							{#PLIGG_Visual_User_Profile_Enabled#}
						</a>
					</li>
					<li>
						<a onclick="set_admin_action('2')" href="#">
							<i class="fa fa-square-o"></i>
							{#PLIGG_Visual_User_Profile_Disabled#}
						</a>
					</li>
					<li>
						<a onclick="set_admin_action('3')" href="#">
							<i class="fa fa-ban"></i>
							{#PLIGG_Visual_KillSpam#}
						</a>
					</li>
				</ul>
			</div>
		</div>
		<div class="col-md-3">
			<div class="input-append">
				<input type="hidden" name="mode" value="search">
				{if isset($templatelite.get.keyword) && $templatelite.get.keyword neq ""}
					{assign var=searchboxtext value=$templatelite.get.keyword|sanitize:2}
				{else}
					{assign var=searchboxtext value=#PLIGG_Visual_Search_SearchDefaultText#}			
				{/if}
				<input type="text" class="form-control search-query" name="keyword" placeholder="{$searchboxtext}">
				<button type="submit" class="btn btn-primary">{#PLIGG_Visual_Search_Go#}</button>
			</div>
		</div>			
		<div class="col-md-3">
			<select name="filter" class="form-control" id="user_filter" onchange="this.form.submit()">
				<option value=""> -- User Level -- </option>
				<option value="admin" {if $templatelite.get.filter == "admin"} selected="selected" {/if}>Admin</option>
				<option value="moderator" {if $templatelite.get.filter == "moderator"} selected="selected" {/if}>Moderator</option>
				<option value="normal" {if $templatelite.get.filter == "normal"} selected="selected" {/if}>Normal</option>
				<option value="spammer" {if $templatelite.get.filter == "spammer"} selected="selected" {/if}>Spammer</option>
			</select>
		</div>
		<div class="col-md-3">
			<select name="pagesize" class="form-control" id="user_sort" onchange="this.form.submit()">
				<option value="15" {if isset($pagesize) && $pagesize == 15}selected{/if}>Show 15</option>
				<option value="30" {if isset($pagesize) && $pagesize == 30}selected{/if}>Show 30</option>
				<option value="50" {if isset($pagesize) && $pagesize == 50}selected{/if}>Show 50</option>
				<option value="100" {if isset($pagesize) && $pagesize == 100}selected{/if}>Show 100</option>
				<option value="200" {if isset($pagesize) && $pagesize == 200}selected{/if}>Show 200</option>
			</select>
		</div>
	</div>
</form>

{if isset($usererror)}
	<span class="error">{$usererror}</span><br/>
{/if}
<form name="user_list_form" id="user_list_form" action="{$my_base_url}{$my_pligg_base}/admin/admin_users.php" method="post" onsubmit="return validate_all_user_action()">
	<input type="hidden" name="frmsubmit" value="userlist" />	
	<input type="hidden" name="admin_acction"  value="" id="admin_action"/>
	{$hidden_token_admin_users_list}
	<table class="table table-bordered table-bordered table-condensed tablesorter" id="tablesorter-userTable">
		<thead>
			<tr>
				<th style="text-align:center;vertical-align:middle;"><input type='checkbox' id="selectall_user_ed" name="all1"></th>
				{checkActionsTpl location="tpl_pligg_admin_users_th_start"}
				<th style="min-width:50px;text-align:center;">ID</th>
				<th style="min-width:95px;">{#PLIGG_Visual_Login_Username#}</th>
				<th style="min-width:75px;text-align:center;">{#PLIGG_Visual_View_User_Level#}</th>
				<th>{#PLIGG_Visual_View_User_Email#}</th>
				<th style="min-width:85px">{#PLIGG_Visual_User_Profile_Joined#}</th>
				<th style="min-width:50px;text-align:center;">Status</th>
				{checkActionsTpl location="tpl_pligg_admin_users_th_end"}
			</tr>
		</thead>
		<tbody>
			{section name=nr loop=$userlist}
				
				<tr class="{if $userlist[nr].user_enabled eq '0'}tr_moderated {/if}">
					<td style="text-align:center;vertical-align:middle;">
						{if $userlist[nr].user_level neq 'admin'}      
							<input type="checkbox" name="enabled[{$userlist[nr].user_id}]" class="enabled_disable"  value="1" usernameval="{$userlist[nr].user_login}"/>
						{/if} 
					</td>
					{checkActionsTpl location="tpl_pligg_admin_users_td_start"}
					<td style="text-align:center;vertical-align:middle;">{$userlist[nr].user_id}</td>
					<td style="vertical-align:middle;"><img src="{$userlist[nr].Avatar}" style="height:18px;width:18px;" /> <a href = "?mode=view&user={$userlist[nr].user_id}">{$userlist[nr].user_login}</a></td>	
					<td style="text-align:center;vertical-align:middle;">{$userlist[nr].user_level}</td>
					<td style="vertical-align:middle;">
						{if $userlist[nr].user_lastlogin neq "0000-00-00 00:00:00"}
							<i class="fa fa-check confirmed-email" title="{#PLIGG_Visual_AdminPanel_Confirmed_Email#}" alt="{#PLIGG_Visual_AdminPanel_Confirmed_Email#}"></i>
						{else}
							<a data-toggle="modal" href="{$my_base_url}{$my_pligg_base}/admin/admin_user_validate.php?id={$userlist[nr].user_id}" title="{#PLIGG_Visual_AdminPanel_Unconfirmed_Email#}"><i class="fa fa-warning unconfirmed-email" rel="tooltip" data-placement="left" data-toggle="tooltip" data-original-title="{#PLIGG_Visual_AdminPanel_Unconfirmed_Email#}"></i></a>
						{/if}
						<a href="mailto:{$userlist[nr].user_email}" target="_blank">{$userlist[nr].user_email|truncate:25:"...":true}</a>
					</td>
					<td>{$userlist[nr].user_date}</td>
					<td style="text-align:center;vertical-align:middle;">
						{if $userlist[nr].user_level eq 'Spammer'}
							<i class="fa fa-ban" title="{#PLIGG_Visual_AdminPanel_Spam#}"></i> {#PLIGG_Visual_AdminPanel_Spam#}
						{elseif $userlist[nr].user_enabled eq 1}
							<i class="fa fa-check-square-o" title="{#PLIGG_Visual_User_Profile_Enabled#}"></i> {#PLIGG_Visual_User_Profile_Enabled#}
						{else}
							<i class="fa fa-square-o" title="{#PLIGG_Visual_User_Profile_Disabled#}"></i> {#PLIGG_Visual_User_Profile_Disabled#}
						{/if}
					</td>
					{checkActionsTpl location="tpl_pligg_admin_users_td_end"}
				</tr>
			{/section}
		</tbody>
	</table>
</form>
{include file="/admin/user_create.tpl"}
<div style="float:right;margin:8px 2px 0 0;">
	<a class="btn btn-success"  href="#createUserForm-modal" data-toggle="modal" title="{#PLIGG_Visual_AdminPanel_New_User#}">{#PLIGG_Visual_AdminPanel_New_User#}</a>
</div>
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