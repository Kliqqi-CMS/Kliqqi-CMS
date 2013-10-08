{config_load file=admin_language_lang_conf}

<legend>{#PLIGG_Admin_Language#}</legend>
<p>{#PLIGG_Admin_Language_Instructions_1#}</p>
<p>{#PLIGG_Admin_Language_Instructions_2#}</p>
<p>{#PLIGG_Admin_Language_Instructions_3#}</p>

<div style="">
	<strong>{#PLIGG_Admin_Language_Filter_Text#}</strong>:
</div>
<div style="">
	<div style="float:left;display:inline;margin:0 4px 0 0;">
		<input type="text" id="filterfor" class="form-control">
	</div>
	<div style="float:left;display:inline;">
		<input type="button" name="filter" value="{#PLIGG_Admin_Language_Filter_Button#}" onclick="filtertotext();" class="btn btn-primary">
		<input type="button" name="clearfilter" value="{#PLIGG_Admin_Language_Filter_Clear#}" onclick="showall();" class="btn btn-default">
	</div>
	<div style="clear:both;"></div>
</div>

{literal}<style type="text/css">
.edit_input {
  margin:0;padding:0 5px;
}
</style>{/literal}

			
<table class="table table-bordered table-striped" style="font-size:1.0em;">
{foreach from=$lines item=line}
	{if $line.title}
		Reading from the <strong>{$line.title}</strong> language file.<br /><br />
	{elseif $line.error}
		<tr><td colspan=2><font color=red>{$line.error}</font></td></tr>
	{elseif $line.section && $line.section!=$lastsection}
		{assign var=lastsection value=$line.section}
		</tbody>
		<thead>
			<tr class="section_head">
				<th colspan="2"><a href="#{$lastsection|lower|replace:' ':''}" id="{$lastsection|lower|replace:' ':''}">{$lastsection}</a></th>
			</tr>
		</thead>
		<tbody>
	{else}
		<tr id = "row_{$line.value}">
		    <td style='width:240px;'>
			<div style='width:240px;word-wrap:break-word;'>{$line.id}</div>
		    </td>
		    <td>
            <form style='margin:0;' onsubmit="return false" name="myform">
			    <input type="text" name="var_value" class="form-control edit_input" style="margin:0;" id="editme{$line.id}" onclick="show_edit('{$line.id}')" value="{$line.value}">
			    <span id="showme{$line.id}" style="display:none;">
			        <input type="submit" style="margin-top:5px;" class="btn btn-primary" value="Save" onclick="save_changes('{$line.id}','{$line.file|replace:'\\':'\\\\'}',this.form)">
			        <input type="reset" style="margin-top:5px;" class="btn btn-default" value="Cancel" onclick="hide_edit('{$line.id}')">
			    </span>
			</form>
		    </td>
		</tr>
	{/if}
{/foreach}
</tbody></table>

{literal}
	<script type="text/javascript">
	function filtertotext(){
			var rows = document.getElementsByTagName("tr"); 
			var filterfor = document.getElementById('filterfor').value;
			
			for (var i = 0; i < rows.length; i++) { 
				var x = rows[i].id;
				
				if(x.substr(0, 4) == 'row_'){
					var y = x.substr(4, 1000).toUpperCase();
					if(y.indexOf(filterfor.toUpperCase())==-1){
						rows[i].style.display='none';
					} else {
						rows[i].style.display='';
					}
				}
			}
	}

	function showall(){
			var rows = document.getElementsByTagName("tr"); 
			for (var i = 0; i < rows.length; i++) { 
				rows[i].style.display='';
			}

	}
	</script>
{/literal}


{config_load file=admin_language_pligg_lang_conf}
