{config_load file=buttons_lang_conf}

{if $error}
	<div class="alert fade in">
		<a data-dismiss="alert" class="close">×</a>
		{$error}
	</div>
{elseif $templatelite.post.submit}
	<div class="alert alert-success fade in">
		<a data-dismiss="alert" class="close">×</a>
		{#PLIGG_Buttons_Saved#}
	</div>
{/if}

	<legend>{#PLIGG_Buttons#}</legend>

	<p>{#PLIGG_Buttons_Instructions#}</p>

	<div style="width:250px;margin:0 auto;padding:0 auto;">
		<div style="float:left;width:100px;margin:0 auto 20px auto;padding:0 auto;text-align:center;">
			<script src="{$my_base_url}{$my_pligg_base}/modules/buttons/buttons.js" type="text/javascript"></script>
			<!-- Large Button -->
			<a class="PliggButton PliggLarge" href="http://www.pligg.com/" title="Pligg Content Management System" rev="News" rel="CMS, Pligg"><span style="display:none">Pligg is an open source CMS (Content Management System) that you can download and use for free. Pligg CMS provides social publishing  software that encourages visitors to register on your website so that they can submit content and connect with other users. Pligg's software creates websites where stories are created and voted on by members, not website editors. Use Pligg content management system to start your own social publishing community in minutes.</span></a>
		</div>
		<div style="float:left;width:120px;margin:20px auto 0 auto;padding:0 auto;text-align:center;">
			<!-- Compact Button -->
			<a class="PliggButton PliggSmall" href="http://www.pligg.com/" title="Pligg Content Management System" rev="News" rel="CMS, Pligg"><span style="display:none">Pligg is an open source CMS (Content Management System) that you can download and use for free. Pligg CMS provides social publishing  software that encourages visitors to register on your website so that they can submit content and connect with other users. Pligg's software creates websites where stories are created and voted on by members, not website editors. Use Pligg content management system to start your own social publishing community in minutes.</span></a>
		</div>
	</div>
	<div style="clear:both;"> </div>

	<form action="" method="POST" id="thisform">
		<legend>{#PLIGG_Buttons_CSS#}: </legend>
		<textarea name="buttons_css" rows="20" class="span12">{$settings.css}</textarea>
		<br />
		<input type="submit" name="submit" value="{#PLIGG_Buttons_Submit#}" class="btn btn-primary" />
	</form>
	
	<hr />
	
	<legend>Customizing the Button</legend>
	<p>This module is designed to support 2 different External Vote Buttons. By default we provide you with a large button that is 50 pixels wide and 61 pixels tall, and a compact button which is 76 pixels wide and only 17 pixels tall. You do not need to stick to these dimensions, we only tried to model our buttons after the two most common Digg.com buttons.</p>
	<p>The default buttons are designed to use 2 images: a background image and a vote button image. The background image is static, but the vote button animates when a user clicks on the button and holds down the mouse. This design uses a single image which changes position when being clicked on. You don't have to follow this design when creating your own version of the button, but we would like you to be aware of this design choice so that you could copy it should you choose to follow our design pattern.</p>
	<p>If you wish to change the size or styling of the EVBs, you can do so by uploading your own background and button images and even by altering the button's CSS file. The button comes with pre-made CSS, which is saved to a temporary file in your /cache directory. Whenever you make an edit to the CSS through the module settings area's Button CSS field you are updating that cached CSS file. Other websites will call on that file when they try to load the button, which is why we cache it as a file. The cache feature also <strong>copies the initial images into a /cache/images directory</strong>, which means that images used by this module's CSS should be stored in that directory rather than the module's own folder. </p>
	
	<hr />
	
	{literal}
	<script type="text/javascript">
	function SelectAll(id)
	{
		document.getElementById(id).focus();
		document.getElementById(id).select();
	}
	</script>
	{/literal}

	<legend>Button Usage</legend>
	<p>To use the button on a third party website, copy and paste one of the following code examples into the website's blog articles or template files. It is important that the buttons only appear on pages with a unique URL, otherwise the External Vote Button will not know how to identify which stories it is supposed to be associated with.</p>
	<p>You will want to make edits to the code examples below to customize how new articles automatically fill in submission fields. To do this, edit the last line in each of these examples, changing the title to match your article's title, link, the rev attribute to match the Pligg site's category most appropriate for that story, any tags you wish to automatically enter when submitting a story that displays as 0 votes, and the text between the &lt;a> tags should represent the description for the story. If you are uncertain about any of these advanced features it is fine to leave them as blank, that will not disrupt the module it will only make it a little less automated for the person submitting the related story for the first time.</p>
	<p>If you embed the EVB on pages with dedicated URLs you do not need to give the button a href attribute. The button will fall back on the current page URL when not href value is specified.</p>
	<h3>Large Button</h3>
	<p>Use the code below to insert a large button.</p>
	<textarea rows="3" class="span12" name="largebutton" id="largebutton" onClick="SelectAll('largebutton');">&lt;script src="{$my_base_url}{$my_pligg_base}/modules/buttons/buttons.js" type="text/javascript">&lt;/script>
&lt;a class="PliggButton PliggLarge" href="http://SAMPLE-LINK.com" title="Example Title" rev="Category 1, Fallback Category 2" rel="Tag1, Tag2, Tag3">&lt;span style="display:none">Article Content Here!&lt;/span>&lt;/a></textarea>

	
	<br /><br />
	<h3>Compact Button</h3>
	<p>The code below will insert a smaller button.</p>
	<textarea rows="3" class="span12" name="smallbutton" id="smallbutton" onClick="SelectAll('smallbutton');">&lt;script src="{$my_base_url}{$my_pligg_base}/modules/buttons/buttons.js" type="text/javascript">&lt;/script>
&lt;a class="PliggButton PliggSmall" href="http://SAMPLE-LINK.com" title="Example Title" rev="Category 1, Fallback Category 2" rel="Tag1, Tag2, Tag3">&lt;span style="display:none">Article Content Here!&lt;/span>&lt;/a></textarea>

	<br /><br />
	<h3>For Wordpress CMS Users</h3>
	<p>Below is an example of the code that I used to insert the EVB into the single page template for Wordpress. Open up your single post template file (single.php) and the main index template (index.php) and insert the following code to add the button to your Wordpress blog! You will need to change the last line value "PliggLarge" to "PliggSmall" if you wish to use the compact button. You may also want to customize the &lt;div> surrounding the button to better position the button.</p>
	<textarea rows="6" class="span12" name="wordpress" id="wordpress" onClick="SelectAll('wordpress');">&lt;div style="float:left;margin:1px 10px 0px 1px;">
&lt;script src="{$my_base_url}{$my_pligg_base}/modules/buttons/buttons.js" type="text/javascript">&lt;/script>
&lt;a class="PliggButton PliggLarge" href="&lt;?php the_permalink(); ?>" title="&lt;?php the_title(); ?>" rev="&lt;?php the_category(', '); ?>" rel="&lt;?php $posttags = wp_get_post_terms( get_the_ID() , 'post_tag' , 'fields=names' );if( $posttags ) echo implode( ', ' , $posttags ); ?>">&lt;span style="display:none">&lt;?php $excerpt = strip_tags(get_the_excerpt());echo $excerpt; ?>&lt;/span>&lt;/a>
&lt;/div></textarea>

	<br /><br />
	<h3>For Blogspot/Blogger Users</h3>
	<p>Begin by navigating to <a href="http://www.blogger.com/home" target="_blank">the blogger homepage</a>. Then click on the "Design" link for the blog that you want to add the button to. Next click on the "Edit HTML" link near the top of the page. Next click on the checkbox next to "Expand Widget Tempaltes" to display the full template code in the textbox. Now search for "&lt;data:post.body/>" and paste the code directly above that line to insert the EVB button. Additional CSS styling may be required to overwrite some of your sites settings.</p> 
	<p>This example code does not define a category or tags to be used, so you may want to manually add those values in yourself using examples from above code snippets.</p>
	<textarea rows="5" class="span12" name="blogspot" id="blogspot" onClick="SelectAll('blogspot');">&lt;div style="float:left;margin:1px 10px 0px 1px;">
  &lt;script src="http://www.pligg.com/demo/modules/buttons/buttons.js" type="text/javascript">&lt;/script>
  &lt;a class="PliggButton PliggLarge" expr:href='data:post.url' expr:title='data:post.title'>
  &lt;span style="display:none">&lt;data:post.body/>&lt;/span>&lt;/a>
&lt;/div></textarea>

{config_load file=buttons_pligg_lang_conf}