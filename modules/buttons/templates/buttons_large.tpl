<div class="vote" id="xnews-{$link_shakebox_index}">
	<div class="votenumber" >
		<a {$url}>{$link_shakebox_votes}</a>
	</div>
	<div id="xvote-{$link_shakebox_index}" class="votebutton">
		{if $anonymous_vote eq "false" and $user_logged_in eq ""}
			<a data-toggle="modal" href="{$login_url}" class="btn btn-mini {if $link_shakebox_currentuser_votes eq 1}btn-success{/if}"><i class="{if $link_shakebox_currentuser_votes eq 1}icon-white {/if}icon-thumbs-up"></i></a>
			<a data-toggle="modal" href="{$login_url}" class="btn btn-mini {if $link_shakebox_currentuser_reports eq 1}btn-danger{/if}"><i class="{if $link_shakebox_currentuser_reports eq 1}icon-white {/if}icon-thumbs-down"></i></a>
		{else}
			{if $link_shakebox_currentuser_votes eq 0}
				<!-- Vote For It -->
				<a class="btn btn-mini linkVote_{$link_id}" {if $vote_from_this_ip neq 0 and $user_logged_in eq ""} data-toggle="modal" href="#LoginModal" {else} href="javascript:{$link_shakebox_javascript_vote}" {/if} title="{$title_short}" ><i class="icon-thumbs-up"></i></a>
			{else}
				<!-- Already Voted -->
				<a class="btn btn-mini btn-success linkVote_{$link_id}" href="javascript:{$link_shakebox_javascript_unvote}" title="{$title_short}"><i class="icon-white icon-thumbs-up"></i></a>
			{/if}
			{if $link_shakebox_currentuser_reports eq 0}
				<!-- Bury It -->
				<a class="btn btn-mini linkVote_{$link_id}" {if $report_from_this_ip neq 0 and $user_logged_in eq ""} data-toggle="modal" href="#LoginModal" {else} href="javascript:{$link_shakebox_javascript_report}" {/if} title="{$title_short}" ><i class="icon-thumbs-down"></i></a>
			{else}
				<!-- Already Buried -->
				<a class="btn btn-mini btn-danger linkVote_{$link_id}"   href="javascript:{$link_shakebox_javascript_unbury}" title="{$title_short}" }><i class="icon-white icon-thumbs-down"></i></a>
			{/if}
		{/if}
	</div>
</div>