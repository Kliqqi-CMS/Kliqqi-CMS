<div id="categories">
<ul class="dropdown dropdown-horizontal">
{checkActionsTpl location="tpl_widget_categories_start"}

{section name=thecat loop=$cat_array}
     {*if $submit_lastspacer eq ""}{assign var=submit_lastspacer value=$cat_array[thecat].spacercount}{/if*}
     {if $cat_array[thecat].auto_id neq 0}

	  {if $cat_array[thecat].spacercount < $submit_lastspacer}
	   	{$cat_array[thecat].spacerdiff|repeat_count:'</ul></li>'}
	  {/if}

	  {if $cat_array[thecat].spacercount > $submit_lastspacer}<ul>{/if}

	<li{if $cat_array[thecat].principlecat neq 0} class="dir"{/if}>

	<a href="{if $pagename eq "upcoming" || $groupview eq "upcoming"}{$URL_queuedcategory, $cat_array[thecat].safename}{else}{$URL_maincategory, $cat_array[thecat].safename}{/if}{if $urlmethod==2}/{/if}">{$cat_array[thecat].name}</a>

	{if $cat_array[thecat].principlecat eq 0}
		</li>
	{/if}

	{assign var=submit_lastspacer value=$cat_array[thecat].spacercount}{/if}

{/section}

{checkActionsTpl location="tpl_widget_categories_end"}
{if $cat_array[thecat].spacercount < $submit_lastspacer}{$lastspacer|repeat_count:'</ul></li>'}{/if}
</ul>
</div>