{literal}
<script type="text/javascript">
$(document).ready(function(){ 
						   
	$(function() {
		$("#contentLeft ul").sortable({ opacity: 0.6, cursor: 'move', update: function() {
			var order = $(this).sortable("serialize") + '&action=updateRecordsListings'; 
			$.post("admin_update_template_widgets.php", order, function(theResponse){
				$("#contentRight").html(theResponse);
			}); 															 
		}								  
		});
	});

});	
</script>
{/literal}
Drag'n drop the items below for manageing display order.
<div id="contentLeft" class="table table-bordered" style="padding-top:10px; padding-bottom:10px; border-left: 1px solid #DDDDDD;" >
<ul style="margin-left:200px;">
{section name=nrid loop=$allBlocks}
<li id="recordsArray_{$allBlocks[nrid].bid}">{$allBlocks[nrid].name}</li>
{/section}
</ul>
</div>

