{************************************
***** Tag Cloud Page Template *******
*************************************}
<!-- tag_cloud_center.tpl -->
<legend>{#PLIGG_Visual_Tags#}</legend>
<div id="tagcloud" style="line-height:{$tags_max_pts}px;">
	{section name=customer loop=$tag_number}
		<span style="font-size: {$tag_size[customer]|number_format:"0":"":""}px" class="cloud_size_{$tag_size[customer]|number_format}"><a href="{$tag_url[customer]}">{$tag_name[customer]}</a></span>&nbsp;
	{/section}
</div>
<!--/tag_cloud_center.tpl -->