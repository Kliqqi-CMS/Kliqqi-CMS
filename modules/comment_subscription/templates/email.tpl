<html>
{php}
/* CUSTOMIZE THIS */
$site_title = ""; // Your Website Title. If you don't provide one we will use a value from your language file.
$site_description = ""; // About your site. If you don't provide one we will use a value from your language file.
$facebook = ""; // Facebook Page URL
$twitter = ""; // Twitter Page URL
$header_text_color = "ffffff"; // Site title color
$header_bg_color = "474747"; // Hexidecimal color code
$link_color = "1B0093"; // Color used for links
$comment_color = "7F7F7F"; // Color used for the comment quote
/* END CUSTOMIZATIONS */
{/php}
{config_load file="/languages/lang_".$pligg_language.".conf"}
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>New Comment: {$link.title}</title>
	</head>
    <body leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0" style="width:100% !important;-webkit-text-size-adjust:none;margin:0; padding:0;">
    	<center>
        	<table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" style="background-color:#FAFAFA;height:100% !important; margin:0; padding:0; width:100% !important;">
            	<tr>
                	<td align="center" valign="top">
						<table width="600" cellspacing="0" cellpadding="10" border="0" style="background-color:#FAFAFA;">
							<tbody>
								<tr>
									<td valign="top" style="color:#505050;font-family:Arial;font-size:10px;line-height:100%;text-align:left;">
									</td>
								</tr>
							</tbody>
						</table>
                    	<table border="0" cellpadding="0" cellspacing="0" width="600" style="border: 1px solid #DDDDDD;background-color:#FDFDFD;">
                        	<tr>
                            	<td align="center" valign="top">
                                    <!-- // Begin Template Header \\ -->
                                	<table border="0" cellpadding="0" cellspacing="0" width="600" style="background-color:#{php} echo $header_bg_color {/php};border-bottom:0;">
                                        <tr>
                                            <td style="color:#{php} echo $header_text_color {/php};font-family:Arial;font-size:34px;font-weight:bold;line-height:100%;padding:0;text-align:center;vertical-align:middle;">
                                            	<div style="">
													<div style="float:left;width:120px;margin:0 0 0 20px;">
														<img src="{$image_header}" style="border:none; font-size:14px; font-weight:bold; height:auto; line-height:100%; outline:none; text-decoration:none;max-width:600px;" style="height:auto;max-width:600px;" />
													</div>
													<div style="float:left;margin:18px 0 0 20px;padding:0;">
														<h1 style="font-size:44px;"><a href="{$my_base_url}{$my_pligg_base}" style="text-decoration:none;color:#{php} echo $header_text_color {/php};">
															{php} if ($site_title != ''){ {/php}
																{php} echo $site_title {/php}
															{php} }else{ {/php}
																{#PLIGG_Visual_Name#}
															{php} } {/php}														
														</a></h1>
													</div>
												</div>
											</td>
                                        </tr>
                                    </table>
                                    <!-- // End Template Header \\ -->
                                </td>
                            </tr>
                        	<tr>
                            	<td align="center" valign="top">
                                    <!-- // Begin Template Body \\ -->
                                	<table border="0" cellpadding="0" cellspacing="0" width="600" id="templateBody">
                                    	<tr>
                                        	<td valign="top">
                                                <table border="0" cellpadding="0" cellspacing="0" style="width:400px;">
                                                    <tr>
                                                        <td valign="top" style="background-color:#FDFDFD;color:#505050;font-family:Arial;font-size:14px;line-height:150%;text-align:left;">
                                                            <table border="0" cellpadding="20" cellspacing="0" width="100%">
                                                                <tr>
                                                                    <td valign="top">
			                                                            <div>
																			<div style="display:inline;width:360px;">
																				<div style="float:left;width:75px;">
																					<img src='{$user_avatar}' width="75px" style="border:none;height:auto;width:75px;line-height:100%;outline:none;text-decoration:none;display:inline;" />
																				</div>
																				<div style="margin-left:0px;">
																					<strong style="margin-left:15px;color:#{php} echo $link_color {/php};font-weight:bold;"><a href="{$my_base_url}{$my_pligg_base}/user.php?login={$author.username}" style="color:#{php} echo $link_color {/php};text-decoration:underline;">{$author.username}</a></strong> published a comment:
																					<blockquote style="margin:2px 0 0 85px;color: #{php} echo $comment_color {/php};font-weight: bold;font-style: italic;border-left: 5px solid #eee;padding-left:6px;">" {$comment.content} "</blockquote>
																				</div>
																			</div>
																			<br style="clear:both;" />
																			This comment appears on the article:
																			<br /><a href='{$story_url}#comments' style="color:#{php} echo $link_color {/php};font-weight:normal;text-decoration:underline;">{$link.title}</a>
			                                                                <br />		                                                           
																	    </div>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        	<!-- // Begin Sidebar \\  -->

                                        	<td valign="top" width="200" style="background-color:#FFFFFF;border-left:0;">
                                            	<table border="0" cellpadding="0" cellspacing="0" width="200">
                                                	<tr>
                                                    	<td valign="top" style="color:#505050;font-family:Arial;font-size:12px;line-height:150%;text-align:left;">
                                                            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="padding-top:20px; padding-left:20px;">
                                                                <tr>
                                                                    <td valign="top">
                                                                        <table border="0" cellpadding="0" cellspacing="4">
																			{php} if ($facebook != ''){ {/php}
                                                                            <tr>
                                                                                <td align="left" valign="middle" width="16">
                                                                                    <img src="{$image_facebook}" style="border:none; font-size:14px; font-weight:bold; height:auto; line-height:100%; outline:none; text-decoration:none;margin:0 !important;display:inline;height:auto;" />
                                                                                </td>
                                                                                <td align="left" valign="top">
                                                                                    <div>
                                                                                        <a href="{php} echo $facebook {/php}" style="color:#{php} echo $link_color {/php};font-weight:normal;text-decoration:underline;">Like us on Facebook</a>
                                                                                    </div>

                                                                                </td>
                                                                            </tr>
																			{php} } {/php}
																			{php} if ($twitter != ''){ {/php}
                                                                            <tr>
                                                                                <td align="left" valign="middle" width="16">
                                                                                    <img src="{$image_twitter}" style="border:none; font-size:14px; font-weight:bold; height:auto; line-height:100%; outline:none; text-decoration:none;margin:0 !important;display:inline;height:auto;" />
                                                                                </td>
                                                                                <td align="left" valign="top">
                                                                                    <div>
                                                                                        <a href="{php} echo $twitter {/php}" style="color:#{php} echo $link_color {/php};font-weight:normal;text-decoration:underline;">Follow on Twitter</a>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
																			{php} } {/php}
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                            <table border="0" cellpadding="20" cellspacing="0" width="100%">
                                                                <tr>
                                                                    <td valign="top">
                                                                        <img src="{$image_sidebar}" style="border:none; font-size:14px; font-weight:bold; height:auto; line-height:100%; outline:none; text-decoration:none;max-width:160px;" />
                                                                        <div>
																			{php} if ($site_description != ''){ {/php}
																				{php} echo $site_description {/php}
																			{php} }else{ {/php}
																				{#PLIGG_Visual_What_Is_Pligg_Text#}
																			{php} } {/php}
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </table>                                                       
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                            <!-- // End Sidebar \\ -->
                                        </tr>
                                    </table>
                                    <!-- // End Template Body \\ -->
                                </td>
                            </tr>
                        	<tr>
                            	<td align="center" valign="top">
                                    <!-- // Begin Template Footer \\ -->
                                	<table border="0" cellpadding="10" cellspacing="0" width="600" style="background-color:#FDFDFD;border-top:0;">
                                    	<tr>
                                        	<td valign="top" style="color:#707070;font-family:Arial;font-size:12px;line-height:125%;text-align:left;">
                                                <table border="0" cellpadding="10" cellspacing="0" width="100%">
                                                    <tr>
                                                        <td colspan="2" valign="middle" style="background-color:#FDFDFD;border:0;text-align:center;">
                                                            <div style="font-size:11px;">
                                                                No longer wish to subscribe to this article's comments? <a href='{$unsubscribe_link}' style="color:#{php} echo $link_color {/php};font-weight:normal;text-decoration:underline;">Unsubscribe here.</a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </table>                                            
                                            </td>
                                        </tr>
                                    </table>
                                    <!-- // End Template Footer \\ -->
                                </td>
                            </tr>
                        </table>
                        <br />
                    </td>
                </tr>
            </table>
        </center>
    </body>
</html>