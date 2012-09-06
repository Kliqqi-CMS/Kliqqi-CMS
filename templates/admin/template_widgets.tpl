<legend>{#PLIGG_Admin_Template_Widget_Title#}</legend>
{literal}
<script type="text/javascript">
$(document).ready(function(){ 
	
	$(function() {
		$("#contentLeft tbody").sortable({ opacity: 0.6, cursor: 'move', update: function() {
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
<p>{#PLIGG_Admin_Template_Widget_Description#}</p>
<table id="contentLeft" class="table table-bordered">
	<tbody>
		{section name=nrid loop=$allBlocks}
			<tr id="recordsArray_{$allBlocks[nrid].bid}" style="cursor:move;"><td>{$allBlocks[nrid].name}</td></tr>
		{/section}
	</tbody>
</table>

