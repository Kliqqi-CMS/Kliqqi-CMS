<!-- categories.tpl -->
<legend>{#PLIGG_Visual_AdminPanel_Category_Manage#}</legend>
<br />
{literal}
<script>
function showdel(id)
{
    document.getElementById('del'+id).style.display='block'; 
    var content = document.getElementById('test'+id+'-content');
    var height = content.style.height;
    content.style.height = (parseInt(height.substr(0,height.indexOf('p')))+180)+'px';
}
</script>
{/literal}
<div class="tabbable tabs-left"><!--Parent of the Accordion--> 
	<ul class="nav nav-tabs admin-category-tabs">
		{section name=thecat loop=$cat_array start=1}
			{if $cat_array[thecat].auto_id neq 0}
				<li class="{if $templatelite.section.thecat.index==1}active{/if}"><a data-toggle="tab" href="#cat-{$cat_array[thecat].auto_id}">{$cat_array[thecat].name}</a></li>
			{/if}
		{/section}
		<li class="add_new_category_tab"><a data-toggle="tab" href="#AddNew">{#PLIGG_Visual_AdminPanel_Category_Add#}</a></li>
	</ul>
	<br />
	<div class="tab-content">
		{section name=thecat loop=$cat_array start=1}
			{if $cat_array[thecat].auto_id neq 0}
				<div id="cat-{$cat_array[thecat].auto_id}" class="tab-pane {if $templatelite.section.thecat.index==1}active{/if} fade in">
					<form method='post'>
						{$hidden_token_category_manager}
						<input type='hidden' name='auto_id' value='{$cat_array[thecat].auto_id}'>
						<input type='hidden' name='action' value='save'>
						<table class="table table-bordered table-striped">
							<tbody>
								<tr>
									<td>{#PLIGG_Visual_AdminPanel_Category_Name#}</td>
									<td><input name="name" class="form-control" value="{$cat_array[thecat].name}" type="text"></td>
								</tr>
								<tr>
									<td>{#PLIGG_Visual_AdminPanel_Category_URL#}</td>
									<td><input name="safename" class="form-control" value="{$cat_array[thecat].safename}" type="text"></td>
								</tr>
								<tr>
									<td>{#PLIGG_Visual_AdminPanel_Category_ID#}</td>
									<td>{$cat_array[thecat].id}</td>
								</tr>
								<tr>
									<td>{#PLIGG_Visual_AdminPanel_Category_Meta_Desc#}</td>
									<td><input name="description" class="form-control" value="{$cat_array[thecat].description}" type="text"></td>
								</tr>
								<tr>
									<td>{#PLIGG_Visual_AdminPanel_Category_Meta_Keywords#}</td>
									<td><input name="keywords" class="form-control" value="{$cat_array[thecat].keywords}" type="text"></td>
								</tr>
								<tr>
									<td>{#PLIGG_Visual_AdminPanel_Category_Author_Level#}</td>
									<td>
										<select name="level" class="form-control">
											<option value="normal" {if $cat_array[thecat].authorlevel=='normal'}selected{/if}>Normal</option>
											<option value="moderator" {if $cat_array[thecat].authorlevel=='moderator'}selected{/if}>Moderator</option>
											<option value="admin" {if $cat_array[thecat].authorlevel=='admin'}selected{/if}>Admin</option>
										</select>
									</td>
								</tr>
								<tr>
									<td>{#PLIGG_Visual_AdminPanel_Category_Author_Group#}</td>
									<td><input name="group" class="form-control" value="{$cat_array[thecat].authorgroup}" type="text"></td>
								</tr>
								<tr>
									<td>{#PLIGG_Visual_AdminPanel_Category_Votes#}</td>
									<td><input name="votes" class="form-control" value="{$cat_array[thecat].votes}" type="text"></td>
								</tr>
								<tr>
									<td>{#PLIGG_Visual_AdminPanel_Category_Karma#}</td>
									<td><input name="karma" class="form-control" value="{$cat_array[thecat].karma}" type="text"></td>
								</tr>
								<tr>
									<td>{#PLIGG_Visual_AdminPanel_Category_Parent#}</td>
									<td>
									<select name="parent" class="form-control">
									  <option value="0"> --- </option>
									  {foreach from=$cat_array item=cat}
										  {if $cat.auto_id!=0 && $cat.auto_id!=$cat_array[thecat].auto_id && $cat_array[thecat].auto_id!=$cat.parent}
										<option value="{$cat.auto_id}" {if $cat_array[thecat].parent==$cat.auto_id}selected{/if}>{$cat.name}</option>
										  {/if}
									  {/foreach}
									</select>
									</td>
								</tr>
								<tr>
									<td><input onclick="showdel({$cat_array[thecat].auto_id})" value="{#PLIGG_Visual_AdminPanel_Category_Delete#}" {if sizeof($cat_array)<=2}disabled{/if} type="button" class="btn btn-danger"></td> 
									<td valign='top'><input value="{#PLIGG_Visual_AdminPanel_Category_Update#}" type="submit" class="btn btn-primary"></td>
								</tr>
							</tbody>
						</table>
						<div id="del{$cat_array[thecat].auto_id}" class="alert alert-error" style="display:none;">
							<p><strong>{#PLIGG_Visual_AdminPanel_Category_Select#}</strong></p>
							<input type="radio" name="sub" value="move" onclick="this.form.delete1.disabled=false;"> {#PLIGG_Visual_AdminPanel_Category_Move#}:
								<select name="move">
								{foreach from=$cat_array item=cat}
								  {if $cat.auto_id!=0 && $cat.auto_id!=$cat_array[thecat].auto_id}
									<option value="{$cat.auto_id}">{$cat.name}</option>
								  {/if}
								{/foreach}
								</select><br />
							<input type="radio" name="sub" value="delete" onclick="this.form.delete1.disabled=false;"> {#PLIGG_Visual_AdminPanel_Category_Delete_Stories#}<br /><br />
							<input type="radio" name="sub1" value="move" checked> {#PLIGG_Visual_AdminPanel_Subcategory_Move#}<br />
							<input type="radio" name="sub1" value="delete"> {#PLIGG_Visual_AdminPanel_Subcategory_Delete#}<br /><br />
							<input onclick="if (confirm('{#PLIGG_Visual_View_User_Reset_Pass_Confirm#}')) document.location.href='admin_categories.php?action=remove&id={$cat_array[thecat].auto_id}&sub='+(this.form.sub[0].checked ? 'move' : 'delete')+'&move='+this.form.move.options[this.form.move.selectedIndex].value+'&sub1='+(this.form.sub1[0].checked ? 'move' : 'delete')+'&token='+this.form.token.value;" value="{#PLIGG_Visual_AdminPanel_Category_Delete#}" disabled name='delete1' type="button" class="btn btn-danger">
							<input onclick="document.getElementById('del{$cat_array[thecat].auto_id}').style.display='none';" value="{#PLIGG_Visual_AdminPanel_Category_Cancel#}" type="button" class="btn btn-default">
						</div>
					</form>
				</div>
			{/if}
		{/section}
		<div id="AddNew" class="tab-pane fade in">
			<form method='post'>
				{$hidden_token_category_manager}
				<input type='hidden' name='action' value='save'>
				<table class="table table-bordered table-striped">
					<tbody>
						<tr>
							<td>{#PLIGG_Visual_AdminPanel_Category_Name#}</td>
							<td><input name="name" class="form-control" placeholder="New Category" type="text"></td>
						</tr>
						<tr>
							<td>{#PLIGG_Visual_AdminPanel_Category_URL#}</td>
							<td><input name="safename" class="form-control" value="" type="text"></td>
						</tr>
						<tr>
							<td>{#PLIGG_Visual_AdminPanel_Category_Meta_Desc#}</td>
							<td><input name="description" class="form-control" value="" type="text"></td>
						</tr>
						<tr>
							<td>{#PLIGG_Visual_AdminPanel_Category_Meta_Keywords#}</td>
							<td><input name="keywords" class="form-control" value="" type="text"></td>
						</tr>
						<tr>
							<td>{#PLIGG_Visual_AdminPanel_Category_Author_Level#}</td>
							<td>
							<select name="level" class="form-control">
								<option value="normal">Normal</option>
								<option value="moderator">Moderator</option>
								<option value="admin">Admin</option>
							</select>
							</td>
						</tr>
						<tr>
							<td>{#PLIGG_Visual_AdminPanel_Category_Author_Group#}</td>
							<td><input name="group" class="form-control" value="" type="text"></td>
						</tr>
						<tr>
							<td>{#PLIGG_Visual_AdminPanel_Category_Votes#}</td>
							<td><input name="votes" class="form-control" value="" type="text"></td>
						</tr>
						<tr>
							<td>{#PLIGG_Visual_AdminPanel_Category_Karma#}</td>
							<td><input name="karma" class="form-control" value="" type="text"></td>
						</tr>
						<tr>
							<td>{#PLIGG_Visual_AdminPanel_Category_Parent#}</td>
							<td>
								<select name="parent" class="form-control">
									<option value="0"> --- </option>
									{foreach from=$cat_array item=cat}
										{if $cat.auto_id!=0}
											<option value="{$cat.auto_id}">{$cat.name}</option>
										{/if}
									{/foreach}
								</select>
							</td>
						</tr>
						<tr>
							<td></td>
							<td><input value="{#PLIGG_Visual_AdminPanel_Category_Add#}" type="submit" class="btn btn-primary"></td>
						</tr>
					</tbody>
				</table>
			</form>
		</div><!--/#AddNew -->
	</div><!--/.tab-content -->
</div><!--/.tabbable-->
<div style="clear:both;margin-top:50px;">
	<hr />
	<legend>{#PLIGG_Visual_AdminPanel_Category_Order#}</legend>
	<p>{#PLIGG_Visual_AdminPanel_Category_Order_Description#}</p>
	{section name=thecat loop=$cat_array}
		{if $cat_array[thecat].auto_id neq 0}
			{if $cat_array[thecat].spacercount < $submit_lastspacer}
				{$cat_array[thecat].spacerdiff|repeat_count:'</ol>'}
			{/if}
			{if $cat_array[thecat].spacercount > $submit_lastspacer}<ol class="category_list"></li>{/if}
			<li id='cat{$cat_array[thecat].auto_id}'>{$cat_array[thecat].name}
				<a class="category_position" id='up{$cat_array[thecat].auto_id}' onclick="moveup({$cat_array[thecat].auto_id})" {if $cat_array[thecat].first}style='display:none;'{/if}><span class="fa fa-angle-up"></span></a>
				<a class="category_position" id='down{$cat_array[thecat].auto_id}' onclick="movedown({$cat_array[thecat].auto_id})" {if $cat_array[thecat].last}style='display:none;'{/if}><span class="fa fa-angle-down"></span></a>
			{assign var=submit_lastspacer value=$cat_array[thecat].spacercount}
		{/if}
	{/section}
</div>
<hr />
<p>Pligg allows users to select what categories they see from their profile settings page. If you add a new category after users have de-selected a category, they won't be able to see that new category. To make it so that all users category settings are reset to see all cateogires, click on the button below.</p> 
<a href="admin_categories.php?action=reset" class="btn btn-warning">{#PLIGG_Visual_Categories_Reset#}</a>
<div style="clear:both;"> </div>
<!--/categories.tpl -->