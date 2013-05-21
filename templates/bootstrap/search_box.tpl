{************************************
************ Search Box *************
*************************************}
<!-- search_box.tpl -->
{checkActionsTpl location="tpl_pligg_search_start"}
<script type="text/javascript">
	{if !isset($searchboxtext)}
		{assign var=searchboxtext value=#PLIGG_Visual_Search_SearchDefaultText#}			
	{/if}
	var some_search='{$searchboxtext}';
</script>
<div class="search">
	<form action="{$my_pligg_base}/search.php" method="get" name="thisform-search" id="thisform-search" {if $urlmethod==2}onsubmit='document.location.href="{$my_base_url}{$my_pligg_base}/search/"+this.search.value.replace(/\//g,"|").replace(/\?/g,"%3F"); return false;'{/if}>
		<input type="text" size="20" class="searchfield" tabindex="20" name="search" id="searchsite" value="{$searchboxtext}" onfocus="if(this.value == some_search) {ldelim}this.value = '';{rdelim}" onblur="if (this.value == '') {ldelim}this.value = some_search;{rdelim}"/>
		<input type="submit" tabindex="21" value="{#PLIGG_Visual_Search_Go#}" class="btn btn-primary" style="height:29px;vertical-align:top;padding-top:5px;width:22%;"/>
	</form>
</div>
<div class="clear"></div>
{checkActionsTpl location="tpl_pligg_search_end"}
<!--/search_box.tpl -->
