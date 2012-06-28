<script type="text/javascript" src="{$my_pligg_base}/templates/{$the_template}/js/story_preview.js"></script>

<h1>{#PLIGG_Visual_Submit2_Header#}</h1>
<div id="submit">
	<div id="submit_step_1_content">
		{checkActionsTpl location="tpl_pligg_submit_step2_start"}
		<form action="{$URL_submit}" method="post" name="thisform" id="thisform" enctype="multipart/form-data" onsubmit="return checkForm()">
		<div class="submit_step_1_left">
				{if $Submit_Show_URL_Input eq 1}
					<h2>{#PLIGG_Visual_Submit2_Source#}</h2>
					<label>{#PLIGG_Visual_Submit2_NewsURL#}: </label>
					<a href="{$submit_url}" class="simple">{$submit_url}</a>
					{if $submit_url_title neq "1"}
						<br />
						<label>{#PLIGG_Visual_Submit2_URLTitle#}: </label>{$submit_url_title}
					{/if}
				{/if}
			<br /><br />
			<h2>{#PLIGG_Visual_Submit2_Details#}</h2>
			<label>{#PLIGG_Visual_Submit2_Title#}: </label>{#PLIGG_Visual_Submit2_TitleInstruct#}<br/>
			<input type="text" id="title" class="text" name="title" value="{if $submit_title}{$submit_title}{else}{$submit_url_title}{/if}" size="54" maxlength="{$maxTitleLength}" />

			<br /><br/>

			<label>{#PLIGG_Visual_Submit2_Category#}: </label>{#PLIGG_Visual_Submit2_CatInstruct#}<br/>
			<select id="category" {if $Multiple_Categories}name="category[]" multiple size=10{else}name="category"{/if} onchange="if ($('#category option:selected').val()>0) $('#lp-category').text($('#category option:selected').text()); else $('#lp-category').text('');">
				<option value="">{#PLIGG_Visual_Submit2_CatInstructSelect#}</option>
				{section name=thecat loop=$submit_cat_array}
				   <option value = "{$submit_cat_array[thecat].auto_id}" {if $submit_cat_array[thecat].auto_id == $submit_category  || in_array($cat_array[thecat].auto_id,$submit_additional_cats)}selected{/if}>
						  {if $submit_cat_array[thecat].spacercount lt $submit_lastspacer}{$submit_cat_array[thecat].spacerdiff|repeat_count:''}{/if}
						  {if $submit_cat_array[thecat].spacercount gt $submit_lastspacer}{/if}
						  {$submit_cat_array[thecat].spacercount|repeat_count:'&nbsp;&nbsp;&nbsp;'}
						  {$submit_cat_array[thecat].name}
						  &nbsp;&nbsp;&nbsp;
						  {assign var=submit_lastspacer value=$submit_cat_array[thecat].spacercount}
				  </option>
				{/section}
			</select>

			<br/><br/>

			{if $enable_group && $output neq ''}
				<label>{#PLIGG_Visual_Group_Submit_story#}: </label><br/>
				{$output}
				<br/><br/>
			{/if}
			
			{checkActionsTpl location="tpl_header_admin_main_comment_subscription"}
			
			{*{checkActionsTpl location="tpl_timestamp_stories"}*}
			
			{if $enable_tags}
				<label>{#PLIGG_Visual_Submit2_Tags#}: </label>
				<strong>{#PLIGG_Visual_Submit2_Tags_Inst1#}</strong><br />{#PLIGG_Visual_Submit2_Tags_Example#} <em>{#PLIGG_Visual_Submit2_Tags_Inst2#}</em><br/>
				<input type="text" id="tags" class="wickEnabled" name="tags" value="{$tags_words}" size="54" maxlength="{$maxTagsLength}" /><br /><br />
				<script type="text/javascript" language="JavaScript" src="{$my_pligg_base}/templates/{$the_template}/js/tag_data.js"></script> 
				<script type="text/javascript" language="JavaScript" src="{$my_pligg_base}/templates/{$the_template}/js/wick.js"></script> 
			{/if}

			{checkActionsTpl location="tpl_pligg_submit_step2_middle"}

			<label>{#PLIGG_Visual_Submit2_Description#}: </label>{#PLIGG_Visual_Submit2_DescInstruct#}
			{if $Story_Content_Tags_To_Allow eq ""}
				<br/><strong>{#PLIGG_Visual_Submit2_No_HTMLTagsAllowed#} </strong>{#PLIGG_Visual_Submit2_HTMLTagsAllowed#}
			{else}
				<br/>{#PLIGG_Visual_Submit2_HTMLTagsAllowed#}: {$Story_Content_Tags_To_Allow}
			{/if}
			<br/><textarea name="bodytext" class="bodytext" rows="10" cols="41" id="bodytext" maxlength="{$maxStoryLength}" WRAP="SOFT" onkeypress="counter(this)" onkeydown="counter(this)" onkeyup="counter(this); if(!this.form.summarycheckbox || !this.form.summarytext) return; if(this.form.summarycheckbox.checked == false) {ldelim}this.form.summarytext.value = this.form.bodytext.value.substring(0, {$StorySummary_ContentTruncate});{rdelim}textCounter(this.form.summarytext,this.form.remLen, {$StorySummary_ContentTruncate});">{if $submit_url_description}{$submit_url_description}{/if}{$submit_content}</textarea><br />
			{* <input size="2" value='{$storylen}' name="text_num disabled" /> {#PLIGG_Visual_Total_Chars#} *}
			{if $Spell_Checker eq 1}<input type="button" name="spelling" value="{#PLIGG_Visual_Check_Spelling#}" class="submit" onclick="openSpellChecker('bodytext');"/>{/if}

			<br />
			<br />

			<div id="sumtrack">
				{if $SubmitSummary_Allow_Edit eq 1}
				<label>{#PLIGG_Visual_Submit2_Summary#}: </label>{#PLIGG_Visual_Submit2_SummaryInstruct#}{#PLIGG_Visual_Submit2_SummaryLimit#}{$StorySummary_ContentTruncate}{#PLIGG_Visual_Submit2_SummaryLimitCharacters#}
					<input type="checkbox" name="summarycheckbox" id="summarycheckbox" onclick="SetState(this, this.form.summarytext)"> {#PLIGG_Visual_Submit2_SummaryCheckBox#}
					{if $Story_Content_Tags_To_Allow eq ""}
						<br /><strong>{#PLIGG_Visual_Submit2_No_HTMLTagsAllowed#} </strong>{#PLIGG_Visual_Submit2_HTMLTagsAllowed#}
					{else}
						<br />{#PLIGG_Visual_Submit2_HTMLTagsAllowed#}: {$Story_Content_Tags_To_Allow}
					{/if}
					<br/><textarea disabled="true" name="summarytext" class="summarytext" rows="5" cols="60" maxlength="{$maxSummaryLength}" id="summarytext" WRAP="SOFT" onkeydown="textCounter(this.form.summarytext,this.form.remLen, {$StorySummary_ContentTruncate});">{$submit_summary}</textarea><br />
					<input readonly type="text" name="remLen" size="3" maxlength="3" value="400">{#PLIGG_Visual_Submit2_SummaryCharactersLeft#}
					{if $Spell_Checker eq 1}<input type="button" name="spelling" value="{#PLIGG_Visual_Check_Spelling#}" class="submit" onclick="openSpellChecker('summarytext');"/>{/if}
					<br /><br />
				{/if}

				{if $Submit_Show_URL_Input eq 1}
					<label>{#PLIGG_Visual_Submit2_Trackback#}: </label>{#PLIGG_Visual_Submit2_TrackbackInstruct#}<br />
					<input type="text" name="trackback" id="trackback" class="text" value="{$submit_trackback}" size="54" />
					<br /><br/>
				{/if}
			</div>
		</div>

		<div class="submit_right_sidebar" id="dockcontent">
			{checkActionsTpl location="tpl_pligg_submit_preview_start"}
			<div class="preview-story">
				<h3 class="preview-title">{#PLIGG_Visual_Story_Preview#}</h3>
				<div class="headline">
				{if $Voting_Method eq 2}
					<h4 id="ls_title-{$link_shakebox_index}">
						<ul class='star-rating{$star_class}' id="xvotes-{$link_shakebox_index}">
							<li class="current-rating" style="width: 100px;" ></li>
							<span id="mnmc-{$link_shakebox_index}" style="display: none;">
									<li><a href="#" class='one-star'>1</a></li>
									<li><a href="#" class='two-stars'>2</a></li>
									<li><a href="#" class='three-stars'>3</a></li>
									<li><a href="#" class='four-stars'>4</a></li>
									<li><a href="#" class='five-stars'>5</a></li>
							</span>
							<span id="mnmd-{$link_shakebox_index}" style="display: none;">
									<li class='one-star-noh'>1</li>
									<li class='two-stars-noh'>2</li>
									<li class='three-stars-noh'>3</li>
									<li class='four-stars-noh'>4</li>
									<li class='five-stars-noh'>5</li>
							</span>
						</ul>
					</h4>
				{else}
					<div class="vote">
						<span class="submit_votenumber">
							1
						</span><br />
						<span class="subtext">
							{#PLIGG_Visual_Vote_For_It#}
						</span>
					</div>
				{/if}	
					<div class="title">
						<h2 style="min-height:16px;">
							<div id="lp-title">{if $submit_title}{$submit_title}{else}{$submit_url_title}{/if}</div>
						</h2>
						
						<span class="subtext">
							{php}
							global $main_smarty, $current_user;

							if ($current_user->user_id > 0 && $current_user->authenticated) {
								$login=$current_user->user_login;
							}

							// Read the users information from the database
							$user=new User();
							$user->username = $login;
							// Assign smarty variables to use in the template.
							$main_smarty->assign('user_username', $user->username);
							$main_smarty->assign('user_url_personal_data', getmyurl('user2', $login, 'profile'));
							{/php}

							{#PLIGG_Visual_LS_Posted_By#} <a href="{$user_url_personal_data}">{$user_username}</a> 
							
							{if $url_short neq "http://" && $url_short neq "://"}
								(<a href="{$url}" target="_blank">{$url_short}</a>)
							{else}
								({$No_URL_Name})
							{/if}
						</span>
					</div>
				</div>
				<div class="storycontent">
					<span class="news-body-text">
						{checkActionsTpl location="tpl_pligg_submit_preview_middle"}
						<span id="ls_contents-{$link_shakebox_index}">
							<div id="lp-bodytext">{if $submit_url_description}{$submit_url_description}{/if}{$submit_content}</div>
							<div style="clear:both;"></div> 
						</span>
					</span>
				</div>	
				<div class="storyfooter" style="float:right;font-size:10px;">	
					<div id="lp-category">
						{section name=thecat loop=$submit_cat_array}
						   {if $submit_cat_array[thecat].auto_id == $submit_category}{$submit_cat_array[thecat].name}{/if}
						{/section}
					</div>| 
					<div id="lp-tags">{$tags_words}</div>
				</div>
				<div style="clear:both;"></div>
			</div>

			{literal}
				<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
				<script type="text/javascript">
					$(document).ready(function() {
						$('#submit_step_1_content input, #submit_step_1_content textarea, #submit_step_1_content select').bind('blur keyup',function() {
							// Main content
							$('#lp-bodytext').text($('#bodytext').val());
							$('#lp-bodytext').html($('#lp-bodytext').html().replace(/\n/g,'<br />'));
							
							// Other
							$('#lp-link_group_id').text($('#link_group_id').val());
							$('#lp-tags').text($('#tags').val());
							$('#lp-title').text($('#title').val());
						});
					});
				</script>
			{/literal}
	
			{checkActionsTpl location="submit_step_2_pre_extrafields"}

			{include file=$tpl_extra_fields.".tpl"}
			<br />

			{if isset($register_step_1_extra)}
				{$register_step_1_extra}
			{/if}

			<input class="button_max" type="submit" value="{#PLIGG_Visual_Submit2_Continue#}" />
			
			{checkActionsTpl location="tpl_pligg_submit_step2_end"}
			
		</div>
		
		<div style="clear:both;"></div>

		<input type="hidden" name="url" id="url" value="{$submit_url}" />
		<input type="hidden" name="phase" value="2" />
		<input type="hidden" name="randkey" value="{$randkey}" />
		<input type="hidden" name="id" value="{$submit_id}" />
		</form>
	</div>
</div>

{literal}
<script type="text/javascript">
	var dock0=new dockit("dockcontent", 0);
</script>
{/literal}