{config_load file=dropbox_backup_lang_conf}

{if $error}
	<div class="alert alert-error">
		<a data-dismiss="alert" class="close">&times;</a>
		{$error}
    </div>
{elseif $templatelite.post.submit}
	<div class="alert alert-success">
		<a data-dismiss="alert" class="close">&times;</a>
		{#PLIGG_Dropbox_Backup_Saved#}
    </div>
{/if}

<legend>{#PLIGG_Dropbox_Backup#}</legend>
<p>{#PLIGG_Dropbox_Backup_Instructions#}</p>
<br />
<div class="span8">
	<form action="" method="POST" id="thisform">
		<table class="table table-bordered table-striped">
			<thead>
				<tr>
					<th>{#PLIGG_Dropbox_Backup_Setting#}</th>
					<th>{#PLIGG_Dropbox_Backup_Value#}</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td><label>{#PLIGG_Dropbox_Backup_Email#}: </label></td>
					<td><input type="text" name="dropbox_backup_email" class="span12" value="{$settings.dropbox_backup_email}" /></td>
				</tr>
				<tr>
					<td><label>{#PLIGG_Dropbox_Backup_Password#}:</label></td>
					<td>
						<input type="password" name="dropbox_backup_pass" class="span12" value="{$settings.dropbox_backup_pass}" />
						{* <input type="checkbox" value="Yes" name="dropbox_backup_save" {if $settings.dropbox_backup_save eq "Yes"}checked="checked"{/if} /> <span class="help-inline">Save your unencrypted password for next time?</span> *}
					</td>
				</tr>
				<tr>
					<td><label>{#PLIGG_Dropbox_Backup_Directory#}: </label></td>
					<td>
						<input type="text" name="dropbox_backup_dir" class="span12" value="{$settings.dropbox_backup_dir}" />
						<span class="help-inline">(Optional) Ex. /pligg will put the files in a folder named "pligg".</span>
					</td>
				</tr>
				<tr>
					<td></td>
					<td>
						<input type="submit" name="submit" value="{#PLIGG_Dropbox_Backup_Submit#}" class="btn btn-primary" />
						<input type="button" {if $settings.dropbox_backup_email eq "" || $settings.dropbox_backup_pass eq ""}disabled="disabled"{/if} value="{#PLIGG_Dropbox_Backup_Perform#}" class="btn btn-success" onClick="parent.location='{$my_pligg_base}/module.php?module=dropbox_backup&action=backup'" />
					</td>
				</tr>
			</tbody>
		</table>
	</form>
</div>

{if $message}
	<div class="span8">
		<div class="alert alert-{$status}">
			<a data-dismiss="alert" class="close">&times;</a>
			{$message}
		</div>
	</div>
{/if}

{config_load file=dropbox_backup_pligg_lang_conf}