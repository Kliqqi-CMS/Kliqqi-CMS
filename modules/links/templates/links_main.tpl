{config_load file=links_lang_conf}

	<script type="text/javascript">
		Event.observe(window, 'load', init, false);
		function init() {ldelim}{foreach from=$editinplace_init item=html}{$html}{/foreach}{rdelim}
	</script>

<legend> {#PLIGG_links#}</legend>
<p>{#PLIGG_links_Instructions_1#}</p>
<p>{#PLIGG_links_Instructions_2#}</p>

<form action="" method="POST" id="thisform">
	<table class="table table-bordered table-striped">
		<tbody>
			<tr>
				<td width="20"><input type="checkbox" name="links_comments" value="1" {if $settings.comments}checked{/if}/></td>
				<td><label>{#PLIGG_links_Convert_Comments#}</label></td>
			</tr>
			<tr>
				<td width="20"><input type="checkbox" name="links_stories" value="1" {if $settings.stories}checked{/if}/></td>
				<td><label>{#PLIGG_links_Convert_Stories#}</label></td>
			</tr>
			<tr>
				<td width="20"><input type="checkbox" name="links_nofollow" value="1" {if $settings.nofollow}checked{/if}/></td>
				<td><label>{#PLIGG_links_Convert_Nofollow#}</label></td>
			</tr>
			<tr>
				<td></td>
				<td>
					<input type="submit" name="submit" value="{#PLIGG_links_Submit#}" class="btn btn-primary" />
				</td>
			</tr>
		</tbody>
	</table>
</form>

{config_load file=links_pligg_lang_conf}