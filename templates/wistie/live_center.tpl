<div class="pagewrap">
	<div class="live2-item">
		<div class="live2-ts"><strong>{#PLIGG_Visual_All_Hour#}</strong></div>
		<div class="live2-type"><strong>{#PLIGG_Visual_All_Action#}</strong></div>
		<div class="live2-votes"><strong><center>{#PLIGG_Visual_All_Votes#}</center></strong></div>
		<div class="live2-story"><div align="center"><strong>{#PLIGG_Visual_All_Story#}</strong></div></div>
		<div class="live2-who"><strong>{#PLIGG_Visual_All_User#}</strong></div>
		<div class="live2-status"><strong>{#PLIGG_Visual_All_State#}</strong></div>
	</div>
	{section name=foo start=0 loop=$items_to_show step=1}
		<div id="live2-{$templatelite.section.foo.index}" class="live2-item">&nbsp;</div>
	{/section}
	<br />
</div>
