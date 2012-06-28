{*Step 2 Errors*}

<fieldset>

{if $submit_error eq 'invalidurl'}
	<p class="error">{#PLIGG_Visual_Submit2Errors_InvalidURL#}{if $submit_url eq "http://"}. {#PLIGG_Visual_Submit2Errors_InvalidURL_Specify#}{else}: {$submit_url}{/if}</p>
	<br/>
	<form id="thisform">
		<input type="button" onclick="javascript:gPageIsOkToExit=true;window.history.go(-1);" value="{#PLIGG_Visual_Submit2Errors_Back#}" class="submit">
	</form>
{/if}

{if $submit_error eq 'dupeurl'}
	<p class="error">{#PLIGG_Visual_Submit2Errors_DupeArticleURL#}: {$submit_url}</p>
	<p>{#PLIGG_Visual_Submit2Errors_DupeArticleURL_Instruct#}</p>
	<p><a href="{$submit_search}"><strong>{#PLIGG_Visual_Submit2Errors_DupeArticleURL_Instruct2#}</strong></a></p>
	<br style="clear: both;" /><br style="clear: both;" />
	<form id="thisform">
		<input type=button onclick="javascript:gPageIsOkToExit=true;window.history.go(-1);" value="{#PLIGG_Visual_Submit2Errors_Back#}" class="submit" />
	</form>
{/if}

{checkActionsTpl location="tpl_pligg_submit_error_2"}

{*Step 3 Errors*}

{if $submit_error eq 'badkey'}
	<p class="error">{#PLIGG_Visual_Submit3Errors_BadKey#}</p>
	<br/>
	<form id="thisform">
		<input type="button" onclick="gPageIsOkToExit=true; document.location.href='{$my_base_url}{$my_pligg_base}/{$pagename}.php?id={$link_id}';" value="{#PLIGG_Visual_Submit3Errors_Back#}" class="submit" />
	</form>
{/if}

{if $submit_error eq 'hashistory'}
	<p class="error">{#PLIGG_Visual_Submit3Errors_HasHistory#}: {$submit_error_history}</p>
	<br/>
	<form id="thisform">
		<input type="button" onclick="gPageIsOkToExit=true; document.location.href='{$my_base_url}{$my_pligg_base}/{$pagename}.php?id={$link_id}';" value="{#PLIGG_Visual_Submit3Errors_Back#}" class="submit" />
	</form>
{/if}

{if $submit_error eq 'urlintitle'}
	<p class="error">{#PLIGG_Visual_Submit3Errors_URLInTitle#}</p>
	<br/>
	<form id="thisform">
		<input type="button" onclick="gPageIsOkToExit=true; document.location.href='{$my_base_url}{$my_pligg_base}/{$pagename}.php?id={$link_id}';" value="{#PLIGG_Visual_Submit3Errors_Back#}" class="submit" />
	</form>
{/if}

{if $submit_error eq 'incomplete'}
	<p class="error">{#PLIGG_Visual_Submit3Errors_Incomplete#}</p>
	<br/>
	<form id="thisform">
		<input type="button" onclick="gPageIsOkToExit=true; document.location.href='{$my_base_url}{$my_pligg_base}/{$pagename}.php?id={$link_id}';" value="{#PLIGG_Visual_Submit3Errors_Back#}" class="submit" />
	</form>
{/if}

{if $submit_error eq 'long_title'}
	<p class="error">{#PLIGG_Visual_Submit3Errors_Long_Title#}</p>
	<br/>
	<form id="thisform">
		<input type="button" onclick="gPageIsOkToExit=true; document.location.href='{$my_base_url}{$my_pligg_base}/{$pagename}.php?id={$link_id}';" value="{#PLIGG_Visual_Submit3Errors_Back#}" class="submit" />
	</form>
{/if}

{if $submit_error eq 'long_content'}
	<p class="error">{#PLIGG_Visual_Submit3Errors_Long_Content#}</p>
	<br/>
	<form id="thisform">
		<input type="button" onclick="gPageIsOkToExit=true; document.location.href='{$my_base_url}{$my_pligg_base}/{$pagename}.php?id={$link_id}';" value="{#PLIGG_Visual_Submit3Errors_Back#}" class="submit" />
	</form>
{/if}

{if $submit_error eq 'long_tags'}
	<p class="error">{#PLIGG_Visual_Submit3Errors_Long_Tags#}</p>
	<br/>
	<form id="thisform">
		<input type="button" onclick="gPageIsOkToExit=true; document.location.href='{$my_base_url}{$my_pligg_base}/{$pagename}.php?id={$link_id}';" value="{#PLIGG_Visual_Submit3Errors_Back#}" class="submit" />
	</form>
{/if}

{if $submit_error eq 'long_summary'}
	<p class="error">{#PLIGG_Visual_Submit3Errors_Long_Summary#}</p>
	<br/>
	<form id="thisform">
		<input type="button" onclick="gPageIsOkToExit=true; document.location.href='{$my_base_url}{$my_pligg_base}/{$pagename}.php?id={$link_id}';" value="{#PLIGG_Visual_Submit3Errors_Back#}" class="submit" />
	</form>
{/if}

{if $submit_error eq 'nocategory'}
	<p class="error">{#PLIGG_Visual_Submit3Errors_NoCategory#}</p>
	<br/>
	<form id="thisform">
		<input type="button" onclick="gPageIsOkToExit=true; document.location.href='{$my_base_url}{$my_pligg_base}/{$pagename}.php?id={$link_id}';" value="{#PLIGG_Visual_Submit3Errors_Back#}" class="submit" />
	</form>
{/if}

{checkActionsTpl location="tpl_pligg_submit_error_3"}

</fieldset>
