{checkActionsTpl location="tpl_pligg_module_ticket_start"}
{config_load file=ticket_lang_conf}

{php}

$canIhaveAccess = 0;
$canIhaveAccess = $canIhaveAccess + checklevel('admin');
$canIhaveAccess = $canIhaveAccess + checklevel('moderator');

$link_id = $this->_vars['link_id'];
	
global $db;
$ticket_sql = $db->get_col("SELECT ticket_status FROM " . table_links . " WHERE link_id='$link_id';");
$ticket = ($ticket_sql[0]);

if($canIhaveAccess != 0){	
	if ($ticket == ''){
		{/php}
		<div class="btn-group" style="float:right;margin:0 0 0 5px;display:inline;">
			<a class="btn btn-mini dropdown-toggle" data-toggle="dropdown" href="#"> Ticket <span class="caret"></span></a>
			<ul class="dropdown-menu">
				<li><a href="{$my_base_url}{$my_pligg_base}/modules/ticket/ticket.php?do=accepted&id={php} echo $link_id; {/php}">Accepted</a></li>
				<li><a href="{$my_base_url}{$my_pligg_base}/modules/ticket/ticket.php?do=completed&id={php} echo $link_id; {/php}">Completed</a></li>
				<li><a href="{$my_base_url}{$my_pligg_base}/modules/ticket/ticket.php?do=rejected&id={php} echo $link_id; {/php}">Rejected</a></li>
				<li><a href="{$my_base_url}{$my_pligg_base}/modules/ticket/ticket.php?do=reproduce&id={php} echo $link_id; {/php}">Cannot Reproduce</a></li>
			</ul>
		</div>
		{php}
	} elseif ($ticket == 'accepted'){
		{/php}
		<div class="btn-group" style="float:right;margin:0 0 0 5px;display:inline;">
			<a class="btn btn-mini btn-info dropdown-toggle" data-toggle="dropdown" href="#"> Accepted <span class="caret"></span></a>
			<ul class="dropdown-menu">
				<li><a href="{$my_base_url}{$my_pligg_base}/modules/ticket/ticket.php?do=completed&id={php} echo $link_id; {/php}">Completed</a></li>
				<li><a href="{$my_base_url}{$my_pligg_base}/modules/ticket/ticket.php?do=rejected&id={php} echo $link_id; {/php}">Rejected</a></li>
				<li><a href="{$my_base_url}{$my_pligg_base}/modules/ticket/ticket.php?do=reproduce&id={php} echo $link_id; {/php}">Cannot Reproduce</a></li>
				<li><a href="{$my_base_url}{$my_pligg_base}/modules/ticket/ticket.php?do=unset&id={php} echo $link_id; {/php}">Remove Ticket</a></li>
			</ul>
		</div>
		{php}
	} elseif ($ticket == 'completed'){
		{/php}
		<div class="btn-group" style="float:right;margin:0 0 0 5px;display:inline;">
			<a class="btn btn-mini btn-success dropdown-toggle" data-toggle="dropdown" href="#"> Completed <span class="caret"></span></a>
			<ul class="dropdown-menu">
				<li><a href="{$my_base_url}{$my_pligg_base}/modules/ticket/ticket.php?do=accepted&id={php} echo $link_id; {/php}">Accepted</a></li>
				<li><a href="{$my_base_url}{$my_pligg_base}/modules/ticket/ticket.php?do=rejected&id={php} echo $link_id; {/php}">Rejected</a></li>
				<li><a href="{$my_base_url}{$my_pligg_base}/modules/ticket/ticket.php?do=reproduce&id={php} echo $link_id; {/php}">Cannot Reproduce</a></li>
				<li><a href="{$my_base_url}{$my_pligg_base}/modules/ticket/ticket.php?do=unset&id={php} echo $link_id; {/php}">Remove Ticket</a></li>
			</ul>
		</div>
		{php}
	} elseif ($ticket == 'rejected'){
		{/php}
		<div class="btn-group" style="float:right;margin:0 0 0 5px;display:inline;">
			<a class="btn btn-mini btn-danger dropdown-toggle" data-toggle="dropdown" href="#"> Rejected <span class="caret"></span></a>
			<ul class="dropdown-menu">
				<li><a href="{$my_base_url}{$my_pligg_base}/modules/ticket/ticket.php?do=accepted&id={php} echo $link_id; {/php}">Accepted</a></li>
				<li><a href="{$my_base_url}{$my_pligg_base}/modules/ticket/ticket.php?do=completed&id={php} echo $link_id; {/php}">Completed</a></li>
				<li><a href="{$my_base_url}{$my_pligg_base}/modules/ticket/ticket.php?do=reproduce&id={php} echo $link_id; {/php}">Cannot Reproduce</a></li>
				<li><a href="{$my_base_url}{$my_pligg_base}/modules/ticket/ticket.php?do=unset&id={php} echo $link_id; {/php}">Remove Ticket</a></li>
			</ul>
		</div>
		{php}
	} elseif ($ticket == 'cannot reproduce'){
		{/php}
		<div class="btn-group" style="float:right;margin:0 0 0 5px;display:inline;">
			<a class="btn btn-mini btn-warning dropdown-toggle" data-toggle="dropdown" href="#"> Cannot Reproduce <span class="caret"></span></a>
			<ul class="dropdown-menu">
				<li><a href="{$my_base_url}{$my_pligg_base}/modules/ticket/ticket.php?do=accepted&id={php} echo $link_id; {/php}">Accepted</a></li>
				<li><a href="{$my_base_url}{$my_pligg_base}/modules/ticket/ticket.php?do=completed&id={php} echo $link_id; {/php}">Completed</a></li>
				<li><a href="{$my_base_url}{$my_pligg_base}/modules/ticket/ticket.php?do=rejected&id={php} echo $link_id; {/php}">Rejected</a></li>
				<li><a href="{$my_base_url}{$my_pligg_base}/modules/ticket/ticket.php?do=unset&id={php} echo $link_id; {/php}">Remove Ticket</a></li>
			</ul>
		</div>
		{php}
	}
	
} else {

	// Non-Admins will see these markers

	if ($ticket == 'accepted'){
		{/php}
			| <a href="{$my_base_url}{$my_pligg_base}/search.php?search=accepted&tag=true" class="btn btn-mini btn-info ticket_accepted">{#Ticket_Task#} {#Ticket_Status_Accepted#}</a>
		{php}
	}
	if ($ticket == 'completed'){
		{/php}
			| <a href="{$my_base_url}{$my_pligg_base}/search.php?search=completed&tag=true" class="btn btn-mini btn-success ticket_completed">{#Ticket_Task#} {#Ticket_Status_Completed#}</a>
		{php}
	}
	if ($ticket == 'rejected'){
		{/php}
			| <a href="{$my_base_url}{$my_pligg_base}/search.php?search=rejected&tag=true" class="btn btn-mini btn-danger ticket_rejected">{#Ticket_Task#} {#Ticket_Status_Rejected#}</a>
		{php}
	}
	if ($ticket == 'cannot reproduce'){
		{/php}
			| <a href="{$my_base_url}{$my_pligg_base}/search.php?search=cannot+reproduce&tag=true" class="btn btn-mini btn-warning ticket_rejected">{#Ticket_Status_Reproduce#}</a>
		{php}
	}
	
}

{/php}

{config_load file=ticket_pligg_lang_conf}
{checkActionsTpl location="tpl_pligg_module_ticket_end"}