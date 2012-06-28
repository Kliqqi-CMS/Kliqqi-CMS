{if $ss_body ne ''}
<div class="headline">
	<div class="sectiontitle"><a href="{$my_base_url}{$my_pligg_base}{if $pagename eq "index"}/upcoming.php{/if}">{$ss_header}</a></div>
</div>
<div class="boxcontent">
	<ul class="sidebar-stories">
		{$ss_body}
	</ul>
</div>
{/if}
