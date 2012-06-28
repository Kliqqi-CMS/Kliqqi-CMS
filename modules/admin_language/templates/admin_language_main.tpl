{config_load file=admin_language_lang_conf}

{literal}
	<style type="text/css">
		td {line-height:18px;}
		.eip_editable { background-color: #ff9; padding: 3px; }
		.eip_savebutton { background-color: #36f; color: #fff; }
		.eip_cancelbutton { background-color: #000; color: #fff; }
		.eip_saving { background-color: #903; color: #fff; padding: 3px; }
		.eip_empty { color: #afafaf; }	
		.emptytext {padding:0px 6px 0px 6px;border-top:2px solid #828177;border-left:2px solid #828177;border-bottom:1px solid #B0B0B0;border-right:1px solid #B0B0B0;background:#F5F5F5;}
	</style>
{/literal}

<fieldset><legend><img src="{$my_pligg_base}/templates/admin/images/manage_lang.gif" align="absmiddle" /> {#PLIGG_Admin_Language#}</legend>
<p>{#PLIGG_Admin_Language_Instructions_1#}</p>
<p>{#PLIGG_Admin_Language_Instructions_2#}</p>

<br />
<strong>{#PLIGG_Admin_Language_Filter_Text#}</strong>: 
<input type="text" id="filterfor">
<input type="button" name="filter" value="{#PLIGG_Admin_Language_Filter_Button#}" onclick="filtertotext();" class="log2">
<input type="button" name="clearfilter" value="{#PLIGG_Admin_Language_Filter_Clear#}" onclick="showall();" class="log2">
<br /><br />
<hr />

{foreach from=$outputHtml item=html}
	{$html}
{/foreach}

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
