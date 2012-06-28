<?php
/**************************************************************
* Smarty Youtube Plugin for Pligg
*
* Name: youtube
* Type: function
* Purpose: translate <youtube> tags to YouTube code
* Author: Ryan 'Dravis' Knowles http://www.PlugIM.com
* Parameters:
*	params: parameters array
*	smarty: smarty instance
* Returns: nothing, assigns new value to a smarty variable
**************************************************************/
function tpl_function_embedvideos($params, &$tpl)
{
	$displayed_story = "";
	$displayed_story = $tpl->get_template_vars("story_content");
	$story_url = $tpl->get_template_vars("story_url");
	$view_type = $tpl->get_template_vars("viewtype");
	$post_video_html = "<br />";
	
	
	// code to replace <youtube> tags with
			$YouTubeCode = '<object width="425" height="350"><param name="movie" value="http://www.youtube.com/v/$1&ap=%2526fmt%3D18""></param><param name="wmode" value="transparent"></param><embed src="http://www.youtube.com/v/$1&ap=%2526fmt%3D18"" type="application/x-shockwave-flash" wmode="transparent" width="425" height="350"></embed></object>' . $post_video_html;
	// replace <youtube> tags with the youtube code		
			$displayed_story = preg_replace("/\<youtube\>(.+?)\<\/youtube\>/is", $YouTubeCode, $displayed_story);

	// code to replace <googlevideo> tags with
			$GoogleVideo = '<embed style="width:400px; height:326px;" id="VideoPlayback" type="application/x-shockwave-flash" src="http://video.google.com/googleplayer.swf?docId=$1&hl=en" flashvars=""> </embed>' . $post_video_html;
	// replace <googlevideo> tags with the googlevideo code
			$displayed_story = preg_replace("/\<googlevideo\>(.+?)\<\/googlevideo\>/is", $GoogleVideo, $displayed_story);

	
	// code to replace <xoinks> tags with
			$XoinksVideo = '<embed src="http://xoinks.com/mov/player/mevidplayer.swf" FlashVars="config=http://xoinks.com/mov/flvplayer.php?viewkey=$1&vimg=http://xoinks.com/mov/images/xoinksmark.jpg" quality="high" bgcolor="#cccccc" wmode="transparent" width="350" height="250" loop="false" align="middle" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" scale="exactfit" > </embed>' . $post_video_html;
	// replace <xoinks> tags with the xoinks code
			$displayed_story = preg_replace("/\<xoinks\>(.+?)\<\/xoinks\>/is", $XoinksVideo, $displayed_story);
			
	
	// code to replace <revver> tags with
			$Revver = '<embed type="application/x-shockwave-flash" src="http://flash.revver.com/player/1.0/player.swf" pluginspage="http://www.macromedia.com/go/getflashplayer" scale="noScale" salign="TL" bgcolor="#ffffff"  wmode="transparent" height="392" width="480" flashvars="mediaId=$1&affiliateId=0"> </embed>' . $post_video_html;
	// replace <revver> tags with the revver code
			$displayed_story = preg_replace("/\<revver\>(.+?)\<\/revver\>/is", $Revver, $displayed_story);
		
		
	// code to replace <myspace> tags with
			$MySpace = '<embed src="http://lads.myspace.com/videos/vplayer.swf" flashvars="m=$1&type=video" type="application/x-shockwave-flash" width="430" height="346"></embed>' . $post_video_html;
	// replace <myspace> tags with the myspace code
			$displayed_story = preg_replace("/\<myspace\>(.+?)\<\/myspace\>/is", $MySpace, $displayed_story);
			
			
	// code to replace <vimeo> tags with
			$Vimeo = '<embed src="http://www.vimeo.com/moogaloop.swf?clip_id=$1" quality="best" scale="exactfit" width="400" height="300" type="application/x-shockwave-flash"></embed>' . $post_video_html;
	// replace <vimeo> tags with the vimeo code
			$displayed_story = preg_replace("/\<vimeo\>(.+?)\<\/vimeo\>/is", $Vimeo, $displayed_story);
			
			
	// code to replace <break> tags with
			$Break = '<object width="425" height="350"><param name="movie" value="http://embed.break.com/$1"></param><embed src="http://embed.break.com/$1" type="application/x-shockwave-flash" width="425" height="350"></embed></object>' . $post_video_html;
	// replace <break> tags with the break code
			$displayed_story = preg_replace("/\<break\>(.+?)\<\/break\>/is", $Break, $displayed_story);
			
			
	// code to replace <veoh> tags with
			$Veoh = '<embed src="http://www.veoh.com/multiplayer.swf?type=v&permalinkId=$1" width="425" height="340" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer"></embed>' . $post_video_html;
	// replace <veoh> tags with the veoh code
			$displayed_story = preg_replace("/\<veoh\>(.+?)\<\/veoh\>/is", $Veoh, $displayed_story);
			

	// code to replace <wmv> tags with
			$WMV = '<embed type="application/x-mplayer2" pluginspage="http://www.microsoft.com/Windows/MediaPlayer/" name="mediaplayer1" autostart="true" width="400" height="370" transparentstart="1" SHOWSTATUSBAR="1" loop="0" controller="true" src="$1" stretchToFit="true" ></embed>' . $post_video_html;
	// replace <wmv> tags with the wmv code
			$displayed_story = preg_replace("/\<wmv\>(.+?)\<\/wmv\>/is", $WMV, $displayed_story);
			
			
	// code to replace <dailymotion> tags with
			$DailyMotion = '<object width="400" height="316"><param name="movie" value="http://www.dailymotion.com/swf/$1"></param><param name="allowfullscreen" value="true"></param><embed src="http://www.dailymotion.com/swf/$1" type="application/x-shockwave-flash" width="400" height="316" allowfullscreen="true"></embed></object>' . $post_video_html;
	// replace <dailymotion> tags with the dailymotion code
			$displayed_story = preg_replace("/\<dailymotion\>(.+?)\<\/dailymotion\>/is", $DailyMotion, $displayed_story);
			
												
	// code to replace <metacafe> tags with
    		$MetaCafe = '<embed src="http://www.metacafe.com/fplayer/$1/$1.swf" width="400" height="345" wmode="transparent" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash"></embed><br />';
	// replace <metacafe> tags with the metacafe code
    		$displayed_story = preg_replace("/\<metacafe\>(.+?)\<\/metacafe\>/is", $MetaCafe, $displayed_story);


    // code to replace <ifilm> tags with
    		$IFILM = '<embed width="400" height="345" src="http://www.ifilm.com/efp" quality="high" bgcolor="000000" name="efp" align="middle" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" flashvars="flvbaseclip=$1&"></embed><br />';
	// replace <ifilm> tags with the ifilm code
    		$displayed_story = preg_replace("/\<ifilm\>(.+?)\<\/ifilm\>/is", $IFILM, $displayed_story);


    // code to replace <guba> tags with
    		$GUBA = '<embed src="http://www.guba.com/a/704270/a/f/root.swf?aid=704270&video_url=http://free.guba.com/uploaditem/$1/flash.flv&isEmbeddedPlayer=true" quality="high" bgcolor="#FFFFFF" menu="false" width="400px" height="326px" name="root" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer"></embed><br />';
	// replace <guba> tags with the guba code
    		$displayed_story = preg_replace("/\<guba\>(.+?)\<\/guba\>/is", $GUBA, $displayed_story);


    //code to replace <tubeley> tags with
    		$Tubeley='<object type="application/x-shockwave-flash" width="320" height="240" wmode="transparent" data="http://tubeley.com/flvideo/flvplayer.swf?file=http://tubeley.com/flvideo/$1.flv&autoStart=false"><param name="movie" value="http://tubeley.com/flvideo/flvplayer.swf?file=http://tubeley.com/flvideo/$1.flv&autoStart=false" /><param name="wmode" value="transparent" /></object>';
	 // replace <tubeley> tags with the tubeley code
    		$displayed_story = preg_replace("/\<tubeley\>(.+?)\<\/tubeley\>/is", $Tubeley, $displayed_story);    

     
    // assign the contents with the embedded video code
	$tpl->assign("show_content", "FALSE");
	$tpl->assign("displayed_story", $displayed_story);
}