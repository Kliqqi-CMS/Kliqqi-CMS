{config_load file=admin_language_lang_conf}

<legend>{#PLIGG_Admin_Language#}</legend>
<p>{#PLIGG_Admin_Language_Instructions_1#}</p>
<p>{#PLIGG_Admin_Language_Instructions_2#}</p>

<div style="">
	<strong>{#PLIGG_Admin_Language_Filter_Text#}</strong>:
</div>
<div style="">
	<div style="float:left;display:inline;margin:0 4px 0 0;">
		<input type="text" id="filterfor" class="span input-xlarge">
	</div>
	<div style="float:left;display:inline;">
		<input type="button" name="filter" value="{#PLIGG_Admin_Language_Filter_Button#}" onclick="filtertotext();" class="btn btn-primary">
		<input type="button" name="clearfilter" value="{#PLIGG_Admin_Language_Filter_Clear#}" onclick="showall();" class="btn">
	</div>
	<div style="clear:both;"></div>
</div>

{literal}<style type="text/css">
.edit_input {
  margin:0;padding:0;
}
</style>{/literal}

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
