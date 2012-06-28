{config_load file=$simple_messaging_lang_conf}

{literal}
<style type="text/css">
.menuwrapper {
margin:0;padding:0;
}
ul#tabnav {
text-align: left;
margin: 10px 0 2px 0;
font-size: 11px;
border-bottom: 1px solid #ccc; 
list-style-type: none;
padding: 3px 10px 1px 10px;
}

ul#tabnav li { 
display: inline;margin:0 5px 0 0;
}

#tab1 li.tab1, #tab2 li.tab2, #tab3 li.tab3, #tab4 li.tab4, #tab5 li.tab5{ 
border-bottom: 1px solid #fff;
background-color: #fff;
}

#tab1 li.tab1 a, #tab2 li.tab2 a, #tab3 li.tab3 a, #tab4 li.tab4 a, #tab5 li.tab5 a { 
background-color: #fff; 
color: #000; 
position: relative;
top: 1px;
padding-top: 4px; 
}

ul#tabnav li a {
padding: 3px 4px;
border: 1px solid #ccc;
background-color: #EDEDED;
color: #666;
margin-right: 0px;
text-decoration: none;
}
ul#tabnav li a img{
border:0;
}
ul#tabnav a:hover { 
background: #fff; 
}
</style>
{/literal}

<div class="menuwrapper">
	<ul id="tabnav">
		<li class="tab1" >
			<a href="{$my_pligg_base}/module.php?module=simple_messaging&view=inbox" {if $modulepage eq "simple_messaging_inbox" || $modulepage eq "viewmsg"}style="background:#fff;border-bottom:1px solid #fff;"{/if}>
				<img src="{$simple_messaging_img_path}email.png" alt="" align="absmiddle"/>
				{#PLIGG_MESSAGING_Inbox#}
			</a>
		</li>

		<li class="tab2">
			<a href="{$my_pligg_base}/module.php?module=simple_messaging&view=sent" {if $modulepage eq "simple_messaging_sent" ||  $modulepage eq "viewsentmsg"}style="background:#fff;border-bottom:1px solid #fff;"{/if}>
				<img src="{$simple_messaging_img_path}reply.png" alt="" align="absmiddle"/>
				{#PLIGG_MESSAGING_Sent_Messages#}
			</a>
		</li>

		{if $Allow_Friends neq "0"}	 
			<li class="tab3">
				<a href="{$user_url_friends}">
					<img src="{$simple_messaging_img_path}friends.png" alt="" align="absmiddle"/>
					{#PLIGG_MESSAGING_Users_Im_Following#}
				</a>
			</li>

			<li class="tab4">
				<a href="{$user_url_friends2}">
					<img src="{$simple_messaging_img_path}friends2.png" alt="" align="absmiddle"/>
					{#PLIGG_MESSAGING_Users_Following_me#}
				</a>
			</li>
			
			{*
			{if $user_authenticated eq true} 
				<li class="tab5">
					<img src="{$my_pligg_base}/templates/{$the_template}/images/user_search.png" align="absmiddle"/>
					{php}global $main_smarty; echo "<a onclick=\"new Effect.toggle('search_users','appear', {queue: 'end'}); \">". $main_smarty->get_config_vars('PLIGG_MESSAGING_Search_Users')."</a>";{/php}
				</li>
			{/if}
			*}
		{/if}
	</ul>
</div>

{if $user_authenticated eq true} 
	<div id="search_users" style="display:none">
		<h2>{#PLIGG_MESSAGING_Search_Users#}</h2>
		<form action="{$my_pligg_base}/user.php" method="get">
		<input type="hidden" name="view" value="search">
		<input type="text" name="keyword">
		<input type="submit" value="{#PLIGG_MESSAGING_Search_Users#}" class="log2">
		</form>
	</div>
{/if}

{config_load file=simple_messaging_pligg_lang_conf}