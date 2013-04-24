<!-- title.tpl -->
{if preg_match('/index.php$/',$templatelite.server.SCRIPT_NAME)}
	{if $get.category}
		{if $get.page>1}
			<title>{$navbar_where.text2} | {#PLIGG_Page_Title#} {$get.page} | {#PLIGG_Visual_Breadcrumb_Published_Tab#} | {#PLIGG_Visual_Name#}</title>
		{else}
			<title>{$navbar_where.text2} | {#PLIGG_Visual_Breadcrumb_Published_Tab#} | {#PLIGG_Visual_Name#}</title>
		{/if}
	{elseif $get.page>1}
		<title>{#PLIGG_Visual_Breadcrumb_Published_Tab#} | {#PLIGG_Page_Title#} {$get.page} | {#PLIGG_Visual_Name#}</title>
	{else}
		<title>{#PLIGG_Visual_Name#} - {#PLIGG_Visual_RSS_Description#}</title>
	{/if}
{elseif preg_match('/new.php$/',$templatelite.server.SCRIPT_NAME)}
	{if $get.category}
		{if $get.page>1}
			<title>{$navbar_where.text2} | {#PLIGG_Page_Title#} {$get.page} | {#PLIGG_Visual_Breadcrumb_Unpublished_Tab#} | {#PLIGG_Visual_Name#}</title>
		{else}
			<title>{$navbar_where.text2} | {#PLIGG_Visual_Breadcrumb_Unpublished_Tab#} | {#PLIGG_Visual_Name#}</title>
		{/if}
	{elseif $get.page>1}
		<title>{#PLIGG_Visual_Breadcrumb_Unpublished_Tab#} | {#PLIGG_Page_Title#} {$get.page} | {#PLIGG_Visual_Name#}</title>
	{else}
		<title>{#PLIGG_Visual_Breadcrumb_Unpublished_Tab#} | {#PLIGG_Visual_Name#}</title>
	{/if}
{elseif preg_match('/submit.php$/',$templatelite.server.SCRIPT_NAME)}
	<title>{#PLIGG_Visual_Submit#} | {#PLIGG_Visual_Name#}</title>
{elseif preg_match('/live.php$/',$templatelite.server.SCRIPT_NAME)}
	<title>{#PLIGG_Visual_Live#} | {#PLIGG_Visual_Name#}</title>
{elseif preg_match('/live_unpublished.php$/',$templatelite.server.SCRIPT_NAME)}
	<title>{#PLIGG_Visual_Live#} {#PLIGG_Visual_Breadcrumb_Unpublished#} | {#PLIGG_Visual_Name#}</title>
{elseif preg_match('/live_published.php$/',$templatelite.server.SCRIPT_NAME)}
	<title>{#PLIGG_Visual_Live#} {#PLIGG_Visual_Breadcrumb_Published#} | {#PLIGG_Visual_Name#}</title>
{elseif preg_match('/live_comments.php$/',$templatelite.server.SCRIPT_NAME)}
	<title>{#PLIGG_Visual_Live#} {#PLIGG_Visual_Comments#} | {#PLIGG_Visual_Name#}</title>
{elseif preg_match('/editlink.php$/',$templatelite.server.SCRIPT_NAME)}	
	<title>{#PLIGG_Visual_EditStory_Header#}: {$submit_title} | {#PLIGG_Visual_Name#}</title>
{elseif preg_match('/advancedsearch.php$/',$templatelite.server.SCRIPT_NAME)}
	<title>{#PLIGG_Visual_Search_Advanced#} | {#PLIGG_Visual_Name#}</title>
{elseif preg_match('/rssfeeds.php$/',$templatelite.server.SCRIPT_NAME)}
	<title>{#PLIGG_Visual_RSS_Feeds#} | {#PLIGG_Visual_Name#}</title>
{elseif preg_match('/search.php$/',$templatelite.server.SCRIPT_NAME)}
	<title>{#PLIGG_Visual_Search_SearchResults#} &quot;{if $get.search}{$get.search}{else}{$get.date}{/if}&quot; | {#PLIGG_Visual_Name#}</title>
{elseif preg_match('/groups.php$/',$templatelite.server.SCRIPT_NAME)}
	{if $get.page>1}
		<title>{#PLIGG_Visual_Groups#} | {#PLIGG_Page_Title#} {$get.page} | {#PLIGG_Visual_Name#}</title>
	{else}
		<title>{#PLIGG_Visual_Groups#} | {#PLIGG_Visual_Name#}</title>
	{/if}
{elseif preg_match('/editgroup.php$/',$templatelite.server.SCRIPT_NAME)}
	<title>{$group_name} | {#PLIGG_Visual_Name#}</title>
{elseif preg_match('/group_story.php$/',$templatelite.server.SCRIPT_NAME)}
	{if $groupview!='published'}
		{if $groupview eq "new"}
			{assign var='tview' value=#PLIGG_Visual_Group_New#}
		{elseif $groupview eq "shared"}
			{assign var='tview' value=#PLIGG_Visual_Group_Shared#}
		{elseif $groupview eq "members"}
			{assign var='tview' value=#PLIGG_Visual_Group_Member#}
		{/if}

		{if $get.page>1}
			<title>{$group_name} | {if $get.category}{$navbar_where.text2} | {/if}{$tview} | {#PLIGG_Page_Title#} {$get.page} | {#PLIGG_Visual_Name#}</title>
		{else}
			<title>{$group_name} | {if $get.category}{$navbar_where.text2} | {/if}{$tview} | {#PLIGG_Visual_Name#}</title>
		{/if}
	{elseif $get.page>1}
		<title>{$group_name} | {#PLIGG_Page_Title#} {$get.page} | {#PLIGG_Visual_Name#}</title>
	{else}
		<title>{$group_name} - {$group_description} | {#PLIGG_Visual_Name#}</title>
	{/if}
{elseif $pagename eq "register_complete"}
	<title>{#PLIGG_Validate_user_email_Title#} | {#PLIGG_Visual_Name#}</title>
{elseif $pagename eq "404"}
	<title>{#PLIGG_Visual_404_Error#} | {#PLIGG_Visual_Name#}</title>
{else}	
	<title>{$posttitle} | {$pretitle} {#PLIGG_Visual_Name#}</title>
{/if}
<!-- /title.tpl -->