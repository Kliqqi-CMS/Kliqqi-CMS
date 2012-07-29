<!-- sidebar_modules\categories.tpl -->
<header id="categories">
	<div class="subnav">
		<div class="container">
			<ul class="nav nav-pills">
				{checkActionsTpl location="tpl_widget_categories_start"}
				{section name=thecat loop=$cat_array}
					{if $cat_array[thecat].auto_id neq 0}
						{if $cat_array[thecat].spacercount < $submit_lastspacer}
							{$cat_array[thecat].spacerdiff|repeat_count:'</ul></li>'}
						{/if}
						{if $cat_array[thecat].spacercount > $submit_lastspacer}
							<ul class="dropdown-menu {if $cat_array[thecat].principlecat eq 0}sub-menu{/if} sub-menu-show sub-menu-hide">
						{/if}
						<li{if $cat_array[thecat].principlecat neq 0} class="dropdown"{/if}>
						<a {if $cat_array[thecat].principlecat neq 0} class="dropdown-toggle active"{/if} href="{if $pagename eq "upcoming" || $groupview eq "upcoming"}{$URL_queuedcategory, $cat_array[thecat].safename}{else}{$URL_maincategory, $cat_array[thecat].safename}{/if}{if $urlmethod==2}/{/if}">{$cat_array[thecat].name} {if $cat_array[thecat].principlecat neq 0}<b class="caret"></b>{/if}</a>
						{if $cat_array[thecat].principlecat eq 0}
							</li>
						{/if}
						{assign var=submit_lastspacer value=$cat_array[thecat].spacercount}
					{/if}
				{/section}
				{if $cat_array[thecat].spacercount < $submit_lastspacer}{$lastspacer|repeat_count:'</ul></li>'}{/if}
				{checkActionsTpl location="tpl_widget_categories_end"}
			</ul>
		</div>
	</div>
</header>
<!-- \sidebar_modules\categories.tpl -->