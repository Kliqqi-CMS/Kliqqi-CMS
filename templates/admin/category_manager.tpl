<h1><img src="{$my_pligg_base}/templates/admin/images/manage_cat.gif" align="absmiddle" /> {#PLIGG_Visual_AdminPanel_Category_Manage#}</h1>
<br />

{literal}
<script> 
function catOnLoad()
{
	new Accordian('basic-accordian',5,'header_highlight'); 
}
window.onload = catOnLoad;
function showdel(id)
{
    document.getElementById('del'+id).style.display='block'; 
    var content = document.getElementById('test'+id+'-content');
    var height = content.style.height;
    content.style.height = (parseInt(height.substr(0,height.indexOf('p')))+180)+'px';
}
</script>
{/literal} 
 
<div id="basic-accordian" ><!--Parent of the Accordion--> 
 
<div style="width:125px; float:left"> 
  {section name=thecat loop=$cat_array start=1}
  {if $cat_array[thecat].auto_id neq 0}
  	<div id="test{$cat_array[thecat].auto_id}-header" class="accordion_headings {if $templatelite.section.thecat.index==1}header_highlight{/if}" >{$cat_array[thecat].name}</div> 
  {/if}
  {/section}
  <br />
  <div id="test0-header" class="accordion_headings" style="background:#129c1f">{#PLIGG_Visual_AdminPanel_Category_Add#}</div> 
</div> 
 
<div style="float:right; width:650px;"> 
  {section name=thecat loop=$cat_array start=1}
  {if $cat_array[thecat].auto_id neq 0}
  <div id="test{$cat_array[thecat].auto_id}-content"> 
	<div class="accordion_child"> 
	<form method='post'>
	{$hidden_token_category_manager}
	<input type='hidden' name='auto_id' value='{$cat_array[thecat].auto_id}'>
	<input type='hidden' name='action' value='save'>
    	<table style="width:600px" border="0"> 
	<tbody> 
		<tr> 
			<td style="font-weight:bold" width="200" height="26">{#PLIGG_Visual_AdminPanel_Category_Name#}</td> 
			<td><input size="55" style="padding:3px" name="name" value="{$cat_array[thecat].name}" type="text"></td> 
		</tr> 

		<tr> 
			<td style="font-weight:bold" width="200" height="26">{#PLIGG_Visual_AdminPanel_Category_URL#}</td> 
			<td><input size="55" style="padding:3px" name="safename" value="{$cat_array[thecat].safename}" type="text"></td> 
		</tr> 

		<tr> 
			<td style="font-weight:bold" width="200" height="26">{#PLIGG_Visual_AdminPanel_Category_ID#}</td> 
			<td>{$cat_array[thecat].id}</td> 
		</tr> 

		<tr> 
			<td style="font-weight:bold" width="200" height="26">{#PLIGG_Visual_AdminPanel_Category_Meta_Desc#}</td> 
			<td><input size="55" style="padding:3px" name="description" value="{$cat_array[thecat].description}" type="text"></td> 
		</tr> 

		<tr> 
			<td style="font-weight:bold" width="200" height="26">{#PLIGG_Visual_AdminPanel_Category_Meta_Keywords#}</td> 
			<td><input size="55" style="padding:3px" name="keywords" value="{$cat_array[thecat].keywords}" type="text"></td> 
		</tr> 

		<tr> 
			<td style="font-weight:bold" width="200" height="26">{#PLIGG_Visual_AdminPanel_Category_Author_Level#}</td> 
			<td> 
			<select name="level" style="padding:3px;width:100px"> 
				<option value="normal" {if $cat_array[thecat].authorlevel=='normal'}selected{/if}>Normal</option> 
				<option value="admin" {if $cat_array[thecat].authorlevel=='admin'}selected{/if}>Admin</option> 
				<option value="god" {if $cat_array[thecat].authorlevel=='god'}selected{/if}>God</option> 
			</select> 
			</td> 
		</tr> 

		<tr> 
			<td style="font-weight:bold" width="200" height="26">{#PLIGG_Visual_AdminPanel_Category_Author_Group#}</td> 
			<td><input size="55" style="padding:3px" name="group" value="{$cat_array[thecat].authorgroup}" type="text"></td> 
		</tr> 
		
		<tr> 
			<td style="font-weight:bold" width="200" height="26">{#PLIGG_Visual_AdminPanel_Category_Votes#}</td> 
			<td><input size="3" style="padding:3px" name="votes" value="{$cat_array[thecat].votes}" type="text"></td> 
		</tr> 
		
		<tr> 
			<td style="font-weight:bold" width="200" height="26">{#PLIGG_Visual_AdminPanel_Category_Karma#}</td> 
			<td><input size="3" style="padding:3px" name="karma" value="{$cat_array[thecat].karma}" type="text"></td> 
		</tr> 
		
		<tr> 
			<td style="font-weight:bold" width="200" height="26">{#PLIGG_Visual_AdminPanel_Category_Parent#}</td> 
			<td> 
			<select name="parent" style="padding:3px"> 
			  <option value="0">--</option> 
			  {foreach from=$cat_array item=cat}
			      {if $cat.auto_id!=0 && $cat.auto_id!=$cat_array[thecat].auto_id && $cat_array[thecat].auto_id!=$cat.parent}
				<option value="{$cat.auto_id}" {if $cat_array[thecat].parent==$cat.auto_id}selected{/if}>{$cat.name}</option> 
			      {/if}
			  {/foreach}
			</select> 
			</td> 
		</tr> 

		<tr> 
			<td style="font-weight:bold" width="200" height="26"><input onclick="showdel({$cat_array[thecat].auto_id})" value="{#PLIGG_Visual_AdminPanel_Category_Delete#}" {if sizeof($cat_array)<=2}disabled{/if} type="button">
			</td> 
			<td valign='top'><input value="{#PLIGG_Visual_AdminPanel_Category_Update#}" type="submit"></td> 
		</tr> 

	</tbody> 
	</table> 
	
	<div id="del{$cat_array[thecat].auto_id}" class="deletecategory" style="display:none;">
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

		<input onclick="if (confirm('{#PLIGG_Visual_View_User_Reset_Pass_Confirm#}')) document.location.href='admin_categories.php?action=remove&id={$cat_array[thecat].auto_id}&sub='+(this.form.sub[0].checked ? 'move' : 'delete')+'&move='+this.form.move.options[this.form.move.selectedIndex].value+'&sub1='+(this.form.sub1[0].checked ? 'move' : 'delete')+'&token='+this.form.token.value;" value="{#PLIGG_Visual_AdminPanel_Category_Delete#}" disabled name='delete1' type="button">
		<input onclick="document.getElementById('del{$cat_array[thecat].auto_id}').style.display='none';" value="{#PLIGG_Visual_AdminPanel_Category_Cancel#}" type="button">
	</div>
	
	</form> 
    </div> 
  </div> 
  {/if}
  {/section}

  <div id="test0-content"> 
	<div class="accordion_child"> 
	<form method='post'>
	{$hidden_token_category_manager}
	<input type='hidden' name='action' value='save'>
    	<table style="width:600px" border="0"> 
	<tbody> 
		<tr> 
			<td style="font-weight:bold" width="200" height="26">{#PLIGG_Visual_AdminPanel_Category_Name#}</td> 
			<td><input size="55" style="padding:3px" name="name" value="new category" type="text"></td> 
		</tr> 

		<tr> 
			<td style="font-weight:bold" width="200" height="26">{#PLIGG_Visual_AdminPanel_Category_URL#}</td> 
			<td><input size="55" style="padding:3px" name="safename" value="" type="text"></td> 
		</tr> 

		<tr> 
			<td style="font-weight:bold" width="200" height="26">{#PLIGG_Visual_AdminPanel_Category_Meta_Desc#}</td> 
			<td><input size="55" style="padding:3px" name="description" value="" type="text"></td> 
		</tr> 

		<tr> 
			<td style="font-weight:bold" width="200" height="26">{#PLIGG_Visual_AdminPanel_Category_Meta_Keywords#}</td> 
			<td><input size="55" style="padding:3px" name="keywords" value="" type="text"></td> 
		</tr> 

		<tr> 
			<td style="font-weight:bold" width="200" height="26">{#PLIGG_Visual_AdminPanel_Category_Author_Level#}</td> 
			<td> 
			<select name="level" style="padding:3px;width:100px"> 
				<option value="normal">Normal</option> 
				<option value="admin">Admin</option> 
				<option value="god">God</option> 
			</select> 
			</td> 
		</tr> 

		<tr> 
			<td style="font-weight:bold" width="200" height="26">{#PLIGG_Visual_AdminPanel_Category_Author_Group#}</td> 
			<td><input size="55" style="padding:3px" name="group" value="" type="text"></td> 
		</tr> 
		
		<tr> 
			<td style="font-weight:bold" width="200" height="26">{#PLIGG_Visual_AdminPanel_Category_Votes#}</td> 
			<td><input size="3" style="padding:3px" name="votes" value="" type="text"></td> 
		</tr> 
		
		<tr> 
			<td style="font-weight:bold" width="200" height="26">{#PLIGG_Visual_AdminPanel_Category_Karma#}</td> 
			<td><input size="3" style="padding:3px" name="karma" value="" type="text"></td> 
		</tr> 
		
		<tr> 
			<td style="font-weight:bold" width="200" height="26">{#PLIGG_Visual_AdminPanel_Category_Parent#}</td> 
			<td> 
			<select name="parent" style="padding:3px"> 
			  <option value="0">--</option> 
			  {foreach from=$cat_array item=cat}
			      {if $cat.auto_id!=0}
				<option value="{$cat.auto_id}">{$cat.name}</option> 
			      {/if}
			  {/foreach}
			</select> 
			</td> 
		</tr> 

		<tr> 
			<td><input value="{#PLIGG_Visual_AdminPanel_Category_Add#}" type="submit"></td> 
		</tr> 

	</tbody> 
	</table> 
	</form> 
    </div> 
  </div> 
</div> 

</div><!--End of accordion parent--> 

<div style="clear:both;margin-top:50px;"> 
	<hr />
	<h2>{#PLIGG_Visual_AdminPanel_Category_Order#}:</h2>
	<p>{#PLIGG_Visual_AdminPanel_Category_Order_Description#}</p>
	<ul> 
	{section name=thecat loop=$cat_array}
	  {if $cat_array[thecat].auto_id neq 0}
	  {if $cat_array[thecat].spacercount < $submit_lastspacer}
	   	{$cat_array[thecat].spacerdiff|repeat_count:'</ul>'}
	  {/if}
	  {if $cat_array[thecat].spacercount > $submit_lastspacer}<ul></li>{/if}

	  <li id='cat{$cat_array[thecat].auto_id}'>{$cat_array[thecat].name} 
		<input value="Up" type="image" src="{$my_pligg_base}/templates/admin/images/cat_up.gif" id='up{$cat_array[thecat].auto_id}' onclick="moveup({$cat_array[thecat].auto_id})" {if $cat_array[thecat].first}style='display:none;'{/if}>
		<input value="Down" type="image" src="{$my_pligg_base}/templates/admin/images/cat_down.gif" id='down{$cat_array[thecat].auto_id}' onclick="movedown({$cat_array[thecat].auto_id})" {if $cat_array[thecat].last}style='display:none;'{/if}>

	  {assign var=submit_lastspacer value=$cat_array[thecat].spacercount}
	  {/if}
	{/section}
	</ul> 
</div> 

<hr />
<h2>URL Method 2</h2>
<a href="admin_categories.php?action=htaccess" rel="width:250,height:250" class="mb" target="_blank">{#PLIGG_Visual_AdminPanel_URL_Method_2_Click#}</a> {#PLIGG_Visual_AdminPanel_URL_Method_2_Rename#}
<br />

{*
{#PLIGG_Visual_AdminPanel_Rewrite_Desc_1#} <a href="{$my_pligg_base}/admin/admin_config.php?page=UrlMethod">{#PLIGG_Visual_AdminPanel_URL_Method_2#}</a>{#PLIGG_Visual_AdminPanel_Rewrite_Desc_2#}</b><br /><br/>
RewriteRule ^({section name=thecat loop=$cat_array}{$cat_array[thecat].safename}{if $templatelite.section.thecat.iteration neq $cat_count}|{/if}{/section})/([^/]+)/?$ story.php?title=$2 [L]<br />
RewriteRule ^({section name=thecat loop=$cat_array}{$cat_array[thecat].safename}{if $templatelite.section.thecat.iteration neq $cat_count}|{/if}{/section})/?$ ?category=$1 [L]
<br/><br />
*}

<hr />
<div class="admin_bottom_button"><a href="admin_categories.php?action=reset">{#PLIGG_Visual_Categories_Reset#}</a></div>
<div style="clear:both;"> </div>

<br /><br />