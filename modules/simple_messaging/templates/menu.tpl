{config_load file=$simple_messaging_lang_conf}
<div class="tabbable simple_message_menu">
	<ul class="nav nav-tabs">
		<li{if $modulepage eq "simple_messaging_inbox"} class="active"{/if}><a href="{$my_pligg_base}/module.php?module=simple_messaging&view=inbox"><i class="fa fa-inbox"></i> {#PLIGG_MESSAGING_Inbox#}</a></li>
		<li{if $modulepage eq "simple_messaging_sent"} class="active"{/if}><a href="{$my_pligg_base}/module.php?module=simple_messaging&view=sent"><i class="fa fa-envelope"></i> {#PLIGG_MESSAGING_Sent_Messages#}</a></li>
		{if $modulepage eq "reply" || $modulepage eq "simple_messaging_compose"}<li class="active"><a href="#"><i class="fa fa-edit"></i> {#PLIGG_MESSAGING_Compose#}</a></li>{/if}
		{if $modulepage eq "viewsentmsg"}<li class="active"><a href="#"><i class="fa fa-envelope-o"></i> {#PLIGG_MESSAGING_Read#}</a></li>{/if}
		{if $modulepage eq "viewmsg"}<li class="active"><a href="#"><i class="fa fa-envelope-o"></i> {#PLIGG_MESSAGING_Read#}</a></li>{/if}
	</ul>
</div><!-- /.tabbable -->
{config_load file=simple_messaging_pligg_lang_conf}