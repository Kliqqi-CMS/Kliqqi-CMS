<!-- sidebar_modules\categories.tpl -->
{literal}
<style type="text/css">
.submenu-show
{
    border-radius: 3px;
    display: block;
    left: 100%;
    margin-top: -25px !important;
    moz-border-radius: 3px;
    position: absolute;
    webkit-border-radius: 3px;
}
.submenu-hide
{
    display: none !important;
    float: right;
    position: relative;
    top: auto;
}
#categories .submenu-show:before
{
    border-bottom: 7px solid transparent;
    border-left: none;
    border-right: 7px solid rgba(0, 0, 0, 0.2);
    border-top: 7px solid transparent;
    left: -7px;
    top: 10px;
}
#categories .submenu-show:after
{
    border-bottom: 6px solid transparent;
    border-left: none;
    border-right: 6px solid #fff;
    border-top: 6px solid transparent;
    left: 10px;
    left: -6px;
    top: 11px;
}
.nav-pills .open .dropdown-toggle,
.nav > li.dropdown.open.active > a:hover {
background-color:#0088CC;
}
</style>
<script type='text/javascript'>//<![CDATA[ 
$(window).load(function(){
    jQuery('.submenu').hover(function () {
        jQuery(this).children('ul').removeClass('submenu-hide').addClass('submenu-show');
    }, function () {
        jQuery(this).children('ul').removeClass('.submenu-show').addClass('submenu-hide');
    }).find("a:first").append(" &raquo; ");
});//]]>  
</script>
{/literal}

<header id="categories">
	<div class="subnav">
		<div class="container">
			<ul class="nav nav-pills">
				{checkActionsTpl location="tpl_widget_categories_start"}
				{section name=thecat loop=$cat_array}
					{*if $submit_lastspacer eq ""}{assign var=submit_lastspacer value=$cat_array[thecat].spacercount}{/if*}
					{if $cat_array[thecat].auto_id neq 0}
						{if $cat_array[thecat].spacercount < $submit_lastspacer}
							{$cat_array[thecat].spacerdiff|repeat_count:'</ul></li>'}
						{/if}
						{if $cat_array[thecat].spacercount > $submit_lastspacer}<ul class="dropdown-menu">{/if}
						<li{if $cat_array[thecat].principlecat neq 0} class="dropdown submenu"{/if}>
						<a {if $cat_array[thecat].principlecat neq 0}data-toggle="dropdown" class="dropdown-toggle active" href="#"{else} href="{if $pagename eq "upcoming" || $groupview eq "upcoming"}{$URL_queuedcategory, $cat_array[thecat].safename}{else}{$URL_maincategory, $cat_array[thecat].safename}{/if}{if $urlmethod==2}/{/if}"{/if}>{$cat_array[thecat].name} {if $cat_array[thecat].principlecat neq 0}<b class="caret"></b>{/if}</a>
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