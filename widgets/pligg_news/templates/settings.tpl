<form method="get">
	<input type="hidden" name="widget" value="pligg_news">
	<p>
		{#PLIGG_News_Widget_Select_Show#}		
		<select name="stories" value="pligg_news">
			<option value="1" {if $news_count eq "1"}selected="selected"{/if}>1</option>
			<option value="2" {if $news_count eq "2"}selected="selected"{/if}>2</option>
			<option value="3" {if $news_count eq "3"}selected="selected"{/if}>3</option>
			<option value="4" {if $news_count eq "4"}selected="selected"{/if}>4</option>
			<option value="5" {if $news_count eq "5"}selected="selected"{/if}>5</option>
		</select>
		{#PLIGG_News_Widget_Select_Items#}
		
		{* <input type="text" name="stories" value="{$news_count}"> *}
		
	</p>
	<br />
	<p>
		<input type = "submit" value="{#PLIGG_News_Widget_Save#}">
	</p>
</form>