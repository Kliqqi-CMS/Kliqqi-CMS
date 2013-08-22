<form method="get">
	<input type="hidden" name="widget" value="pligg_products">
	<p>
		{#PLIGG_Products_Widget_Select_Show#}		
		<select class="input-sm" name="products" value="pligg_products">
			<option value="1" {if $product_count eq "1"}selected="selected"{/if}>1</option>
			<option value="2" {if $product_count eq "2"}selected="selected"{/if}>2</option>
			<option value="3" {if $product_count eq "3"}selected="selected"{/if}>3</option>
			<option value="4" {if $product_count eq "4"}selected="selected"{/if}>4</option>
		</select>
		{#PLIGG_Products_Widget_Select_Items#}
		{* <input type="text" name="products" value="{$product_count}"> *}
	</p>
	<br />
	<p>
		<input type="submit" class="btn btn-primary" value="{#PLIGG_Products_Widget_Save#}">
	</p>
</form>
