<!-- home.tpl -->
{if $amIadmin eq 1}
	<div class="column" id="left_column">
		{foreach from=$widgets item=widget}	
			{if $widget.column=='left'}
				<div class="portlet ui-widget ui-widget-content ui-helper-clearfix ui-corner-all" id="{$widget.id}">
					{php}$this->_vars['index']++;{/php}
					<div class="portlet-header ui-widget-header">
						<div id="coda-nav-right-{$index}" class="coda-nav-right">
							{if $widget.widget_uninstall_icon}
								<span onclick='if (confirm("Uninstall {$widget.widget_title}?")) window.location.href="admin_widgets.php?action=remove&widget="+encodeURIComponent("{$widget.name}")' class="ui-icon ui-icon-close"></span>
							{/if}
							{if $widget.widget_shrink_icon}
								<span class="ui-icon {if $widget.display=='none'}ui-icon-plusthick{else}ui-icon-minusthick{/if}"></span>
							{/if}
							{if $widget.widget_has_settings}
								<a href="#"><span class="ui-icon ui-icon-wrench"></span></a>
							{/if}
						</div>
						{$widget.widget_title}
					</div>
					<div class="portlet-content" {if $widget.display=='none'}style='display:none;'{/if}>
						<div class="coda-slider-wrapper">
							<div class="coda-slider preload" id="coda-slider-{$index}">
								<div class="panel" id="p{$widget.id}">
									<div class="panel-wrapper">
										{if $widget.lang_conf}{config_load file=`$widget.lang_conf`}{/if}
										{include file=`$widget.main`}
										{config_load file=$pligg_lang_conf}
										<div style="clear:both;"> </div>
									</div>
								</div>
								{if $widget.widget_has_settings}
								<div class="panel">
									<div class="panel-wrapper">
										{if $widget.lang_conf}{config_load file=`$widget.lang_conf`}{/if}
										{include file=`$widget.settings`}
										{config_load file=$pligg_lang_conf}
										<div style="clear:both;"> </div>
									</div>
								</div>
								{/if}
							</div><!-- .coda-slider -->
						</div><!-- .coda-slider-wrapper -->
					</div>
				</div>
			{/if}
		{/foreach}
	</div><!-- END LEFT COLUMN -->
	<div class="column" id="right_column"><!-- START RIGHT COLUMN -->
		{foreach from=$widgets item=widget}	
			{if $widget.column=='right'}
				<div class="portlet ui-widget ui-widget-content ui-helper-clearfix ui-corner-all" id="{$widget.id}">
					{php}$this->_vars['index']++;{/php}
					<div class="portlet-header ui-widget-header">
						<div id="coda-nav-right-{$index}" class="coda-nav-right">
							{if $widget.widget_uninstall_icon}
								<span onclick='if (confirm("Uninstall {$widget.widget_title}?")) window.location.href="admin_widgets.php?action=remove&widget="+encodeURIComponent("{$widget.name}")' class="ui-icon ui-icon-close"></span>
							{/if}
							{if $widget.widget_shrink_icon}
								<span class="ui-icon {if $widget.display=='none'}ui-icon-plusthick{else}ui-icon-minusthick{/if}"></span>
							{/if}
							{if $widget.widget_has_settings}
								<a href="#" data-slide="next"><span class="ui-icon ui-icon-wrench"></span></a>
							{/if}
						</div>
						{$widget.widget_title}
					</div>
					<div class="portlet-content" {if $widget.display=='none'}style='display:none;'{/if}>
						<div class="coda-slider-wrapper">
							<div class="coda-slider preload" id="coda-slider-{$index}">
								<div class="panel" id="p{$widget.id}">
									<div class="panel-wrapper">
										{if $widget.lang_conf}{config_load file=`$widget.lang_conf`}{/if}
										{include file=`$widget.main`}
										{config_load file=$pligg_lang_conf}
										<div style="clear:both;"> </div>
									</div>
								</div>
								{if $widget.widget_has_settings}
								<div class="panel">
									<div class="panel-wrapper">
										{if $widget.lang_conf}{config_load file=`$widget.lang_conf`}{/if}
										{include file=`$widget.settings`}
										{config_load file=$pligg_lang_conf}
										<div style="clear:both;"> </div>
									</div>
								</div>
								{/if}
							</div><!-- .coda-slider -->
						</div><!-- .coda-slider-wrapper -->
					</div>
				</div>
			{/if}
		{/foreach}
	</div>
{else}
	{#PLIGG_Visual_AdminPanel_NoAccess#}
{/if}
<!--/home.tpl -->