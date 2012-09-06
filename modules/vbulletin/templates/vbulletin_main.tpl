{config_load file=vbulletin_lang_conf}

	<script type="text/javascript">
		Event.observe(window, 'load', init, false);
		function init() {ldelim}{foreach from=$editinplace_init item=html}{$html}{/foreach}{rdelim}
	</script>

<fieldset><legend> {#PLIGG_vbulletin#}</legend>
<p>{#PLIGG_vbulletin_Instructions_1#}</p>
<p>{#PLIGG_vbulletin_Instructions_2#}</p>

	<form action="" method="POST" id="thisform">
		<table class="table table-bordered">
			<tbody>
				<tr>
					<td width="200px"><label>{#PLIGG_vbulletin_DB#}: </label></td>
					<td><input type="text" name="vbulletin_db" id="vbulletin_db" size="66" value="{$settings.db}"/></td>
				</tr>
				<tr>
					<td><label>{#PLIGG_vbulletin_User#}: </label></td>
					<td><input type="text" name="vbulletin_user" id="vbulletin_user" size="66" value="{$settings.user}"/></td>
				</tr>
				<tr>
					<td><label>{#PLIGG_vbulletin_Password#}: </label></td>
					<td><input type="text" name="vbulletin_pass" id="vbulletin_pass" size="66" value="{$settings.pass}"/></td>
				</tr>
				<tr>
					<td><label>{#PLIGG_vbulletin_Host#}: </label></td>
					<td><input type="text" name="vbulletin_host" id="vbulletin_host" size="66" value="{$settings.host}"/></td>
				</tr>
				<tr>
					<td><label>{#PLIGG_vbulletin_Cookie_Prefix#}: </label></td>
					<td><input type="text" name="vbulletin_prefix" id="vbulletin_prefix" size="66" value="{$settings.prefix}"/></td>
				</tr>
				<tr>
					<td><label>{#PLIGG_vbulletin_Cookie_Hash#}: </label></td>
					<td><input type="text" name="vbulletin_hash" id="vbulletin_hash" size="66" value="{$settings.hash}"/></td>
				</tr>
				<tr>
				<tr>
					<td></td>
					<td>
						<input type="submit" name="submit" value="{#PLIGG_vbulletin_Submit#}" class="btn btn-primary" />
					</td>
				</tr>
			</tbody>
		</table>
	</form>
	<div style="clear:both;"></div>
	{literal}
	<style type="text/css">
	.instructions h3 {margin:0;padding:0;font-size:17px;}
	.instructions h4 {margin:10px 0 4px 0;padding:0;font-size:14px;border-bottom:1px solid #bbb;}
	</style>
	{/literal}
	<div class="instructions">
		<h3>Removing the Register Page</h3>
		<p>Because this module is designed so that Pligg will no longer handle registerations it is highly suggested that you change all links to your register.php page so that they will point to your forum registration page instead. You should also edit the register_center.tpl template to redirect to the vBulletin register page. Below is sample code to place at the top of the register_center.tpl template that will automatically redirect users to the vBulletin registration page. Please bear in mind that you will need to change the URL value.</p>
		<pre>&#123;php} header( 'Location: http://forums.pligg.com/register.php' );&#123;/php}</pre>
		<h3>Configure Instructions and Examples</h3>
		<h4>MySQL Database and Prefix</h4>
		<p>Enter your vBulletin MySQL database name followed by a period and then your vBulletin prefix (if any).</p>
		<p><strong>Prefix Example:</strong> vbulletin_database.forum_<br />
		<strong>No Prefix Example:</strong> vbulletin_database.</p>

		<h4>MySQL Database User</h4>
		<p>This is the username used to access your vBulletin MySQL database</p>

		<h4>MySQL Database Password</h4>
		<p>This is the password associated with the user that has access your vBulletin MySQL database</p>

		<h4>MySQL Database Host</h4>
		<p>Usually this is set as localhost, but some web hosts provide specific IP addresses, domain names or subdomains to use as your database host. For example Dreamhost web hosting uses subdomains that you setup when creating a database.</p>

		<p><strong>Localhost Example:</strong> localhost<br />
		<strong>Subdomain Example:</strong> mysql.mydomain.com</p>

		<h4>vBulletin Cookie Prefix</h4>
		<p>The prefix value is stored in /includes/config.php. The default setting is "bb".</p>
		<p>Search for something similar to:<br />
		<pre>$config['Misc']['cookieprefix'] = 'bb';</pre>
		</p>

		<p><strong>Example:</strong> bb</p>

		<h4>Cookie Hash</h4>
		<p>Open the file /includes/functions.php from your vBulletin directory and find a variable that looks like:<br />
		<pre>define('COOKIE_SALT', 'A12345678Z');</pre>
		</p>
		<p>The value used for the cookie hash is the second value that appears on this line, it will be alphanumeric and 10 characters long.</p>

		<p><strong>Example:</strong> A12345678Z</p>
	 
	</div>
</fieldset>


{config_load file="/languages/lang_".$pligg_language.".conf"}
