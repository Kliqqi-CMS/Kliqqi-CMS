<!-- domain_blacklist.tpl -->
{***************************************************************}

{if $errorText neq ""}
	<div class="alert alert-danger">
		{$errorText}
	</div>
{/if}

<div class="row">
	<div class="col-md-6">	
		
		{* Javascript used to enable submit buttons, preventing blank input. *}
		{literal}
			<script type='text/javascript'>
			$(function(){
				$('#whitelist_add').keyup(function () {
					if ($(this).val() == '') { //Check to see if there is any text entered
						//If there is no text within the input, disable the button
						$('.whitelistCheck').attr('disabled', 'disabled');
					} else {
						// Domain name regular expression
						var regex = new RegExp("^([0-9A-Za-z-\\.@:%_\+~#=]+)+((\\.[a-zA-Z]{2,3})+)(/(.)*)?(\\?(.)*)?");
						if (regex.test($(this).val())) {
							// Domain looks OK
							//alert("Successful match");
							$('.whitelistCheck').removeAttr('disabled');
						} else {
							// Domain is NOT OK
							//alert("No match");
							$('.whitelistCheck').attr('disabled', 'disabled');
						}
					}
				});
				$('#blacklist_add').keyup(function () {
					if ($(this).val() == '') { //Check to see if there is any text entered
						//If there is no text within the input, disable the button
						$('.blacklistCheck').attr('disabled', 'disabled');
					} else {
						// Domain name regular expression
						var regex = new RegExp("^([0-9A-Za-z-\\.@:%_\+~#=]+)+((\\.[a-zA-Z]{2,3})+)(/(.)*)?(\\?(.)*)?");
						if (regex.test($(this).val())) {
							// Domain looks OK
							//alert("Successful match");
							$('.blacklistCheck').removeAttr('disabled');
						} else {
							// Domain is NOT OK
							//alert("No match");
							$('.blacklistCheck').attr('disabled', 'disabled');
						}
					}
				});
			});
			</script>
		{/literal}
		
		<legend>Domain Whitelist {if $whitelist_file|@count != '0'}({$whitelist_file|@count} total){/if}</legend>	
		<p>Place high value domains on this list to ensure that they are never accidentally banned through actions like Killspamming.</p>
		<p>Add a domain to the whitelist, using the form below.</p>
		
		<form action="domain_management.php" method="get">
			<input type="text" name="whitelist_add" id="whitelist_add" placeholder="domain.com">
			<button type="submit" class="btn btn-success whitelistCheck" disabled='disabled' >Add to Whitelist</button>
		</form>

		{if $whitelist_file|@count != '0'}
			<ol>
				{section name=line loop=$whitelist_file}
					<li><a href="domain_management.php?id=0&list=whitelist&remove={$whitelist_file[line]}">Remove</a> - {$whitelist_file[line]} </li>
				{/section}
			</ol>
		{/if}
		
	</div>

	<div class="col-md-6">
		<legend>Domain Blacklist {if $blacklist_file|@count != '0'}({$blacklist_file|@count} total){/if}</legend>	
		<p>Place low value domains on this list to prevent users from submitting stories from these domains.</p>
		<p>Add a domain to the blacklist, using the form below.</p>

		<form action="domain_management.php" method="get">
			<input type="text" name="blacklist_add" id="blacklist_add" placeholder="domain.com">
			<button type="submit" class="btn btn-danger blacklistCheck" disabled='disabled'>Add to Blacklist</button>
		</form>

		{if $blacklist_file|@count != '0'}
			<ol>
				{section name=line loop=$blacklist_file}
					<li><a href="domain_management.php?id=0&list=blacklist&remove={$blacklist_file[line]}">Remove</a> - {$blacklist_file[line]} </li>
				{/section}
			</ol>
		{/if}
		
	</div>
	
</div> <!-- /row -->

<!--/domain_blacklist.tpl -->