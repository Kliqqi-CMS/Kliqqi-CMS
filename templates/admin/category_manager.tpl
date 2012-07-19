<!-- category_manager.tpl -->
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
	<ul class="nav nav-tabs">
		{section name=thecat loop=$cat_array start=1}
			{if $cat_array[thecat].auto_id neq 0}
				<li class="{if $templatelite.section.thecat.index==1}active{/if}"><a data-toggle="tab" href="#cat-{$cat_array[thecat].auto_id}">{$cat_array[thecat].name}</a></li>
			{/if}
		{/section}
		<li class=""><a data-toggle="tab" href="#AddNew">{#PLIGG_Visual_AdminPanel_Category_Add#}</a></li>
	</ul>
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
									<td><input size="55" name="name" value="{$cat_array[thecat].name}" type="text"></td>
								</tr>
								<tr>
									<td>{#PLIGG_Visual_AdminPanel_Category_URL#}</td>
									<td><input size="55" name="safename" value="{$cat_array[thecat].safename}" type="text"></td>
								</tr>
								<tr>
									<td>{#PLIGG_Visual_AdminPanel_Category_ID#}</td>
									<td>{$cat_array[thecat].id}</td>
								</tr>
								<tr>
									<td>{#PLIGG_Visual_AdminPanel_Category_Meta_Desc#}</td>
									<td><input size="55" name="description" value="{$cat_array[thecat].description}" type="text"></td>
								</tr>
								<tr>
									<td>{#PLIGG_Visual_AdminPanel_Category_Meta_Keywords#}</td>
									<td><input size="55" name="keywords" value="{$cat_array[thecat].keywords}" type="text"></td>
								</tr>
								<tr>
									<td>{#PLIGG_Visual_AdminPanel_Category_Author_Level#}</td>
									<td>
										<select name="level" style="padding:3px;width:100px">
											<option value="normal" {if $cat_array[thecat].authorlevel=='normal'}selected{/if}>Normal</option>
											<option value="admin" {if $cat_array[thecat].authorlevel=='admin'}selected{/if}>Admin</option>
											<option value="god" {if $cat_array[thecat].authorlevel=='god'}selected{/if}>God</option>
										</select>
									</td>
								</tr>
								<tr>
									<td>{#PLIGG_Visual_AdminPanel_Category_Author_Group#}</td>
									<td><input size="55" name="group" value="{$cat_array[thecat].authorgroup}" type="text"></td>
								</tr>
								<tr>
									<td>{#PLIGG_Visual_AdminPanel_Category_Votes#}</td>
									<td><input name="votes" value="{$cat_array[thecat].votes}" type="text"></td>
								</tr>
								<tr>
									<td>{#PLIGG_Visual_AdminPanel_Category_Karma#}</td>
									<td><input name="karma" value="{$cat_array[thecat].karma}" type="text"></td>
								</tr>
								<tr>
									<td>{#PLIGG_Visual_AdminPanel_Category_Parent#}</td>
									<td>
									<select name="parent">
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
							<input onclick="document.getElementById('del{$cat_array[thecat].auto_id}').style.display='none';" value="{#PLIGG_Visual_AdminPanel_Category_Cancel#}" type="button" class="btn">
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
							<td><input size="55" name="name" placeholder="New Category" type="text"></td>
						</tr>
						<tr>
							<td>{#PLIGG_Visual_AdminPanel_Category_URL#}</td>
							<td><input size="55" name="safename" value="" type="text"></td>
						</tr>
						<tr>
							<td>{#PLIGG_Visual_AdminPanel_Category_Meta_Desc#}</td>
							<td><input size="55" name="description" value="" type="text"></td>
						</tr>
						<tr>
							<td>{#PLIGG_Visual_AdminPanel_Category_Meta_Keywords#}</td>
							<td><input size="55" name="keywords" value="" type="text"></td>
						</tr>
						<tr>
							<td>{#PLIGG_Visual_AdminPanel_Category_Author_Level#}</td>
							<td>
							<select name="level">
								<option value="normal">Normal</option>
								<option value="admin">Admin</option>
								<option value="god">God</option>
							</select>
							</td>
						</tr>
						<tr>
							<td>{#PLIGG_Visual_AdminPanel_Category_Author_Group#}</td>
							<td><input size="55" name="group" value="" type="text"></td>
						</tr>
						<tr>
							<td>{#PLIGG_Visual_AdminPanel_Category_Votes#}</td>
							<td><input name="votes" value="" type="text"></td>
						</tr>
						<tr>
							<td>{#PLIGG_Visual_AdminPanel_Category_Karma#}</td>
							<td><input name="karma" value="" type="text"></td>
						</tr>
						<tr>
							<td>{#PLIGG_Visual_AdminPanel_Category_Parent#}</td>
							<td>
								<select name="parent">
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
	<ul>
		{section name=thecat loop=$cat_array}
			{if $cat_array[thecat].auto_id neq 0}
				{if $cat_array[thecat].spacercount < $submit_lastspacer}
					{$cat_array[thecat].spacerdiff|repeat_count:'</ul>'}
				{/if}
				{if $cat_array[thecat].spacercount > $submit_lastspacer}<ul></li>{/if}
				<li id='cat{$cat_array[thecat].auto_id}'>{$cat_array[thecat].name}
					<input value="Up" type="image" style="height:9px;width:11px;" src="{$my_base_url}{$my_pligg_base}/templates/admin/images/cat_up.gif" id='up{$cat_array[thecat].auto_id}' onclick="moveup({$cat_array[thecat].auto_id})" {if $cat_array[thecat].first}style='display:none;'{/if}>
					<input value="Down" type="image" style="height:9px;width:11px;" src="{$my_base_url}{$my_pligg_base}/templates/admin/images/cat_down.gif" id='down{$cat_array[thecat].auto_id}' onclick="movedown({$cat_array[thecat].auto_id})" {if $cat_array[thecat].last}style='display:none;'{/if}>
				{assign var=submit_lastspacer value=$cat_array[thecat].spacercount}
			{/if}
		{/section}
	</ul>
</div>
<hr />
<legend>URL Method 2</legend>
<a href="admin_categories.php?action=htaccess" rel="width:250,height:250" class="mb" target="_blank">{#PLIGG_Visual_AdminPanel_URL_Method_2_Click#}</a> {#PLIGG_Visual_AdminPanel_URL_Method_2_Rename#}
<hr />
<div class="btn"><a href="admin_categories.php?action=reset">{#PLIGG_Visual_Categories_Reset#}</a></div>
<div style="clear:both;"> </div>
<!--/category_manager.tpl -->