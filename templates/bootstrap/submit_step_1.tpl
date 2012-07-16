{************************************
****** Submit Step 1 Template *******
*************************************}

<legend>{#PLIGG_Visual_Submit1_Header#}</legend>

<div class="submit">
	<h3>{#PLIGG_Visual_Submit1_Instruct#}:</h3>
	{checkActionsTpl location="tpl_pligg_submit_step1_start"}
	
	<div class="submit_instructions">
		<ul class="instructions">
			{if #PLIGG_Visual_Submit1_Instruct_1A# ne ''}<li><strong>{#PLIGG_Visual_Submit1_Instruct_1A#}:</strong> {#PLIGG_Visual_Submit1_Instruct_1B#}</li>{/if}
			{if #PLIGG_Visual_Submit1_Instruct_2A# ne ''}<li><strong>{#PLIGG_Visual_Submit1_Instruct_2A#}:</strong> {#PLIGG_Visual_Submit1_Instruct_2B#}</li>{/if}
			{if #PLIGG_Visual_Submit1_Instruct_3A# ne ''}<li><strong>{#PLIGG_Visual_Submit1_Instruct_3A#}:</strong> {#PLIGG_Visual_Submit1_Instruct_3B#}</li>{/if}
			{if #PLIGG_Visual_Submit1_Instruct_4A# ne ''}<li><strong>{#PLIGG_Visual_Submit1_Instruct_4A#}:</strong> {#PLIGG_Visual_Submit1_Instruct_4B#}</li>{/if}
			{if #PLIGG_Visual_Submit1_Instruct_5A# ne ''}<li><strong>{#PLIGG_Visual_Submit1_Instruct_5A#}:</strong> {#PLIGG_Visual_Submit1_Instruct_5B#}</li>{/if}
			{if #PLIGG_Visual_Submit1_Instruct_6A# ne ''}<li><strong>{#PLIGG_Visual_Submit1_Instruct_6A#}:</strong> {#PLIGG_Visual_Submit1_Instruct_6B#}</li>{/if}
			{if #PLIGG_Visual_Submit1_Instruct_7A# ne ''}<li><strong>{#PLIGG_Visual_Submit1_Instruct_7A#}:</strong> {#PLIGG_Visual_Submit1_Instruct_7B#}</li>{/if}
		</ul>
	</div>
		
	{checkActionsTpl location="tpl_pligg_submit_step1_middle"}
	
	<form action="{$URL_submit}" method="post" id="thisform">
	
		<div class="submit_form">
			<h3>{#PLIGG_Visual_Submit1_NewsSource#}</h3>
			
			<label for="url">{#PLIGG_Visual_Submit1_NewsURL#}:</label>
			<input type="text" name="url" class="span6" id="url" placeholder="http://" />
			
			{checkActionsTpl location="tpl_pligg_submit_step1_end"}
			
			<input type="hidden" name="phase" value="1">
			<input type="hidden" name="randkey" value="{$submit_rand}">
			<input type="hidden" name="id" value="c_1">
			<br />
			<input type="submit" value="{#PLIGG_Visual_Submit1_Continue#}" class="btn btn-primary" />
			<br /><br />
		</div>	
		
		<div class="bookmarklet">
			<h3>{#PLIGG_Visual_User_Profile_Bookmarklet_Title#}</h3>
			<p>{#PLIGG_Visual_User_Profile_Bookmarklet_Title_1#} {#PLIGG_Visual_Name#}.{#PLIGG_Visual_User_Profile_Bookmarklet_Title_2#}<br />
			<br /><strong>{#PLIGG_Visual_User_Profile_IE#}:</strong> {#PLIGG_Visual_User_Profile_IE_1#}
			<br /><strong>{#PLIGG_Visual_User_Profile_Firefox#}:</strong> {#PLIGG_Visual_User_Profile_Firefox_1#}
			<br /><strong>{#PLIGG_Visual_User_Profile_Opera#}:</strong> {#PLIGG_Visual_User_Profile_Opera_1#}
			<br /><br /><strong>{#PLIGG_Visual_User_Profile_The_Bookmarklet#}: { include file=$the_template"/bookmarklet.tpl" }</strong>
			</p>
		</div>
	
	</form>
</div>