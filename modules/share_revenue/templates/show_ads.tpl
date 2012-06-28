<center>
<br />

{adsense assign=users_adsense}
{if $users_adsense}

	{* this part shows the users adsense id *}

	<script type="text/javascript"><!--
		google_ad_client = "{$google_adsense_id}"; {* dont change this line *}
		google_alternate_ad_url = "http://kalator.com/psa/info468x60.html";
		google_ad_width = 468;
		google_ad_height = 60;
		google_ad_format = "468x60_as";
		google_ad_type = "text";
		google_ad_channel ="{$google_adsense_channel}"; {* dont change this line *}
		google_color_border = "ffffff";
		google_color_bg = "ffffff";
		google_color_link = "11A3AC";
		google_color_text = "707070";
		google_color_url = "A44848";
		//-->
	</script>
	<script type="text/javascript"
	  src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
	</script>
{else}

	{* this part shows your adsense id *}

	<script type="text/javascript"><!--
		google_ad_client = "pub-1628281707918473";  {*  be sure to put your adsense id here *}
		google_alternate_ad_url = "http://kalator.com/psa/info468x60.html";
		google_ad_width = 468;
		google_ad_height = 60;
		google_ad_format = "468x60_as";
		google_ad_type = "text";
		google_ad_channel ="";
		google_color_border = "ffffff";
		google_color_bg = "ffffff";
		google_color_link = "11A3AC";
		google_color_text = "707070";
		google_color_url = "A44848";
		//-->
	</script>
	<script type="text/javascript"
	  src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
	</script>
{/if}
</center>