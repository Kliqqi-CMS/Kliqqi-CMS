<h1>{#PLIGG_Visual_Submit1_Header#}</h1>
<div id="leftcol-superwide">
	
	<div id="submit">
		<div id="submit_content">
			<h2>{#PLIGG_Visual_Submit1_Instruct#}:</h2>
			{checkActionsTpl location="tpl_pligg_submit_step1_start"}
			<ul class="instructions">
				{if #PLIGG_Visual_Submit1_Instruct_1A# ne ''}<li><strong>{#PLIGG_Visual_Submit1_Instruct_1A#}:</strong> {#PLIGG_Visual_Submit1_Instruct_1B#}</li>{/if}
				{if #PLIGG_Visual_Submit1_Instruct_2A# ne ''}<li><strong>{#PLIGG_Visual_Submit1_Instruct_2A#}:</strong> {#PLIGG_Visual_Submit1_Instruct_2B#}</li>{/if}
				{if #PLIGG_Visual_Submit1_Instruct_3A# ne ''}<li><strong>{#PLIGG_Visual_Submit1_Instruct_3A#}:</strong> {#PLIGG_Visual_Submit1_Instruct_3B#}</li>{/if}
				{if #PLIGG_Visual_Submit1_Instruct_4A# ne ''}<li><strong>{#PLIGG_Visual_Submit1_Instruct_4A#}:</strong> {#PLIGG_Visual_Submit1_Instruct_4B#}</li>{/if}
				{if #PLIGG_Visual_Submit1_Instruct_5A# ne ''}<li><strong>{#PLIGG_Visual_Submit1_Instruct_5A#}:</strong> {#PLIGG_Visual_Submit1_Instruct_5B#}</li>{/if}
				{if #PLIGG_Visual_Submit1_Instruct_6A# ne ''}<li><strong>{#PLIGG_Visual_Submit1_Instruct_6A#}:</strong> {#PLIGG_Visual_Submit1_Instruct_6B#}</li>{/if}
				{if #PLIGG_Visual_Submit1_Instruct_7A# ne ''}<li><strong>{#PLIGG_Visual_Submit1_Instruct_7A#}:</strong> {#PLIGG_Visual_Submit1_Instruct_7B#}</li>{/if}
			</ul>
			<div id="bookmarklet">
				<h2>{#PLIGG_Visual_User_Profile_Bookmarklet_Title#}</h2>
					<p>{#PLIGG_Visual_User_Profile_Bookmarklet_Title_1#} {#PLIGG_Visual_Name#}.{#PLIGG_Visual_User_Profile_Bookmarklet_Title_2#}<br />
					<br /><strong>{#PLIGG_Visual_User_Profile_IE#}:</strong> {#PLIGG_Visual_User_Profile_IE_1#}
					<br /><strong>{#PLIGG_Visual_User_Profile_Firefox#}:</strong> {#PLIGG_Visual_User_Profile_Firefox_1#}
					<br /><strong>{#PLIGG_Visual_User_Profile_Opera#}:</strong> {#PLIGG_Visual_User_Profile_Opera_1#}
					<br /><br /><strong>{#PLIGG_Visual_User_Profile_The_Bookmarklet#}: { include file="bookmarklet.tpl" }</strong>
					</p>
			</div>
			{checkActionsTpl location="tpl_pligg_submit_step1_middle"}
			<br />
			<h2>{#PLIGG_Visual_Submit1_NewsSource#}</h2>
			<form action="{$URL_submit}" method="post" id="thisform">
				<label for="url">{#PLIGG_Visual_Submit1_NewsURL#}:</label>
				<input type="text" name="url" id="url" value="http://" size="55" />
				
				{checkActionsTpl location="tpl_pligg_submit_step1_end"}
				
				<input type="hidden" name="phase" value=1>
				<input type="hidden" name="randkey" value="{$submit_rand}">
				<input type="hidden" name="id" value="c_1">
				<input type="submit" value="{#PLIGG_Visual_Submit1_Continue#}" class="submit-s" />
			</form>
			<br />
			{if $Submit_Require_A_URL neq 1}{#PLIGG_Visual_Submit_Editorial#}{/if}

		</div>
	</div>