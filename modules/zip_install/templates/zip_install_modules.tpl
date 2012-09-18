{config_load file=$zip_install_lang_conf}
<legend><img src="{$my_pligg_base}/modules/zip_install/images/modules.png" align="absmiddle"/> {#PLIGG_ZIP_INSTALL_MODULES#}</legend>

<a href="module.php?module=zip_install" class="btn"><i class="icon icon-arrow-left"></i> {#PLIGG_ZIP_INSTALL_BACK#}</a>

<hr style="margin-top:10px;" />

<p>{#PLIGG_ZIP_INSTALL_MODULES_UPLOAD_INSTRUCTIONS#}</p>

<form action="module.php?module=zip_install&action=filemod" method="post" enctype="multipart/form-data">
	<p>{#PLIGG_ZIP_INSTALL_MODULE_PACKAGE#}
		<input type="file" name="archzip" />
		<input type="submit" value="{#PLIGG_ZIP_INSTALL_UPINSTALL#}" class="btn btn-primary" />
	</p>
</form>

{config_load file=zip_install_pligg_lang_conf}