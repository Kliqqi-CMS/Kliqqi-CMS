{if $pagename eq "admin_index"}
	<ol id="HelloWorld" style="display:none;">
		<li data-target="#AdminAccordion" data-title="Admin Sidebar">Navigate between the different Admin Panel pages using these links. Each section can be collapsed or expanded, making it easier to access the links that you use most frequently between sessions.</li>
		<li data-target="#CollapseManage" data-title="Management Sidebar Area">This is the management sidebar area, where you will find links to manage content on your Pligg website. If you see a number on the right side of any of these sidebar labels, that represents items that need to be reviewed. </li>
		<li data-target="#CollapseSettings" data-title="Settings Sidebar Area">This is where you can configure your site to your liking. Change things like: whether un-registered users can vote, how many stories appear on each page, backup your files and MySQL database.</li>
		<li data-target="#CollapseTemplate" data-title="Template Sidebar Area">Here you can manage your template through a settings area and a web-based template file editor.</li>
		<li data-target="#CollapseModules" data-title="Modules Sidebar Area">Modules are add-ons that provide additional functionality to Pligg. Modules that have settings pages will insert a link to that page under this section. The numbers that appear to the right of some modules represent something that they want to call your attention to, like content waiting for your approval. The number that appears in the collapsable bar at the top is the total number of alerts in the module section, similar to how the manage section alerts work.</li>
		<li data-target="#CollapseWidgets" data-title="Widgets Sidebar Area">Widgets are the boxes of information that appear on the Admin Panel Homepage.</li>
		<li data-target="#left_column" data-title="Widgets">Here are some examples of Widgets in action. They can be quickly customized through the settings link in the corner of some of their title bars, minimized temporarily, or completely uninstalled with a single click on the X icon.</li>
	</ol>

	<script src="{$my_base_url}{$my_pligg_base}/modules/hello_world/templates/bootstrap-tour.js" type="text/javascript"></script>

	{literal}
	<script type="text/javascript">
	  $(window).load(function() {
		$(this).featureTour({
		  /* Options will go here */
		});
	  });

	$(this).featureTour({
	  'cookieMonster': true,         	// true/false for whether cookies are used
	  'cookieName': 'HelloWorldHome',  // choose your own cookie name
	  'cookieDomain': false,           	// set to false or yoursite.com
	  'tipContent': '#HelloWorld',    	// The ID of the <ol> used for content
	  'postRideCallback': $.noop,      	// A method to call once the tour closes
	  'postStepCallback': $.noop,      	// A method to call after each step
	  'nextOnClose': false,            	// If cookies are enabled, increment the current step on close
	  'debug': false
	});
	</script>
	{/literal}
{/if}

{if $pagename eq "admin_links" || $pagename eq "admin_comments" || $pagename eq "admin_users" || $pagename eq "admin_group" || $pagename eq "admin_page" || $pagename eq "admin_categories"}
	<ol id="HelloWorld" style="display:none;">
		<li data-target="#manage_submissions" data-title="Submissions">The Submissions page contains all of the articles submitted to your website. When you see a number to the right of the submissions link, that means that you have articles currently awaiting moderation.</li>
		<li data-target="#manage_comments" data-title="Comments">Quickly view the latest comments and moderate them from the comment management page. If a number appears on the right side of this label, that represents the number of comments awaiting moderation.</li>
		<li data-target="#manage_users" data-title="Users">View user details like their ID, avatar, email address, and join date from the user management page. You can also "Killspam" a member or manually validate their email address from this page.</li>
		<li data-target="#manage_groups" data-title="Groups">Members can form their own groups, but it is important for admins to moderate new groups so that they keep on topic with the site.</li>
		<li data-target="#manage_pages" data-title="Pages">Manage the pages used by your Pligg site. Pligg doesn't automatically link to new pages, so you will need to manually insert a link to the created pages into your template.</li>
		<li data-target="#manage_categories" data-title="Categories">Manage what categories are available for articles being submitted to the site. You can also organize the categories and apply advanced settings to each category.</li>
	</ol>

	<script src="{$my_base_url}{$my_pligg_base}/modules/hello_world/templates/bootstrap-tour.js" type="text/javascript"></script>

	{literal}
	<script type="text/javascript">
	  $(window).load(function() {
		$(this).featureTour({
		  /* Options will go here */
		});
	  });

	$(this).featureTour({
	  'cookieMonster': true,         	// true/false for whether cookies are used
	  'cookieName': 'HelloWorldManage',  // choose your own cookie name
	  'cookieDomain': false,           	// set to false or yoursite.com
	  'tipContent': '#HelloWorld',    	// The ID of the <ol> used for content
	  'postRideCallback': $.noop,      	// A method to call once the tour closes
	  'postStepCallback': $.noop,      	// A method to call after each step
	  'nextOnClose': false,            	// If cookies are enabled, increment the current step on close
	  'debug': false
	});
	</script>
	{/literal}
{/if}

{if $pagename eq "admin_config" && $templatelite.get.page neq "Template"}
	<ol id="HelloWorld" style="display:none;">
		<li data-target="#CollapseSettings" data-title="Settings Sidebar Area">This is where you can configure your site to your liking. Change things like: whether un-registered users can vote, how many stories appear on each page, backup your files and MySQL database.</li>
		<li data-target="#settings_anonymous" data-title="Anonymous">Enable anonymous voting from this page.</li>
		<li data-target="#settings_antispam" data-title="Antispam">Here you can change what local blacklist files Pligg uses to prevent spam.</li>
	</ol>

	<script src="{$my_base_url}{$my_pligg_base}/modules/hello_world/templates/bootstrap-tour.js" type="text/javascript"></script>

	{literal}
	<script type="text/javascript">
	  $(window).load(function() {
		$(this).featureTour({
		  /* Options will go here */
		});
	  });

	$(this).featureTour({
	  'cookieMonster': true,         	// true/false for whether cookies are used
	  'cookieName': 'HelloWorldSettings',  // choose your own cookie name
	  'cookieDomain': false,           	// set to false or yoursite.com
	  'tipContent': '#HelloWorld',    	// The ID of the <ol> used for content
	  'postRideCallback': $.noop,      	// A method to call once the tour closes
	  'postStepCallback': $.noop,      	// A method to call after each step
	  'nextOnClose': false,            	// If cookies are enabled, increment the current step on close
	  'debug': false
	});
	</script>
	{/literal}
{/if}

{if $pagename eq "admin_editor" || $pagename eq "admin_config" && $templatelite.get.page eq "Template"}
	<ol id="HelloWorld" style="display:none;">
		<li data-target="#template_settings" data-title="Template Settings">Change the default template that is used on your site.</li>
		<li data-target="#template_editor" data-title="Template Editor">A web-based template file editor that allows you to make changes to your template files without having to use an external program.</li>
		<li data-target="#open_template" data-title="Open Template File">After choosing a template file that you want to edit from the dropdown list, click on the open button to bring up the editor.</li>	
	</ol>

	<script src="{$my_base_url}{$my_pligg_base}/modules/hello_world/templates/bootstrap-tour.js" type="text/javascript"></script>

	{literal}
	<script type="text/javascript">
	  $(window).load(function() {
		$(this).featureTour({
		  /* Options will go here */
		});
	  });

	$(this).featureTour({
	  'cookieMonster': true,         	// true/false for whether cookies are used
	  'cookieName': 'HelloWorldTemplate',  // choose your own cookie name
	  'cookieDomain': false,           	// set to false or yoursite.com
	  'tipContent': '#HelloWorld',    	// The ID of the <ol> used for content
	  'postRideCallback': $.noop,      	// A method to call once the tour closes
	  'postStepCallback': $.noop,      	// A method to call after each step
	  'nextOnClose': false,            	// If cookies are enabled, increment the current step on close
	  'debug': false
	});
	</script>
	{/literal}
{/if}

{if $pagename eq "admin_modules"}
	<ol id="HelloWorld" style="display:none;">
		<li data-target="#modules_installed" data-title="Installed Modules">This page lists all of the currently installed modules on your website. The list provides a link to each module's readme page, settings page (when available), requirements to run, update notifications, and uninstall links. Any numbers that appear to the right of this line represent the number of installed modules that have an update available.</li>
		<li data-target="#modules_uninstalled" data-title="Uninstalled Modules">This page allows you to install a module with a single click. It also contains similar information to the installed module page. Any numbers that appear to the right of this line represent the number of uninstalled modules that have an update available.</li>
		<li data-target="#module_uninstalled" data-title="Change Pages">Quickly change between installed and uninstalled pages using these tabs.</li>
		{php} if ($_GET["status"] != "uninstalled"){ echo '<li data-target="#apply_changes" data-title="Apply Changes">To disable a module, but leave it installed, uncheck the box in the "Enabled" column below and click on the Apply Changes button.</li>'; } {/php}
	</ol>

	<script src="{$my_base_url}{$my_pligg_base}/modules/hello_world/templates/bootstrap-tour.js" type="text/javascript"></script>

	{literal}
	<script type="text/javascript">
	  $(window).load(function() {
		$(this).featureTour({
		  /* Options will go here */
		});
	  });

	$(this).featureTour({
	  'cookieMonster': true,         	// true/false for whether cookies are used
	  'cookieName': 'HelloWorldModules',  // choose your own cookie name
	  'cookieDomain': false,           	// set to false or yoursite.com
	  'tipContent': '#HelloWorld',    	// The ID of the <ol> used for content
	  'postRideCallback': $.noop,      	// A method to call once the tour closes
	  'postStepCallback': $.noop,      	// A method to call after each step
	  'nextOnClose': false,            	// If cookies are enabled, increment the current step on close
	  'debug': false
	});
	</script>
	{/literal}
{/if}

{if $pagename eq "admin_widgets"}
	<ol id="HelloWorld" style="display:none;">
		<li data-target="#widgets_installed" data-title="Installed Widgets">This page displays the installed widgets. Any numbers that appear to the right of this line represent the number of installed widgets that have an update available.</li>
		<li data-target="#widgets_uninstalled" data-title="Uninstalled Widgets">This page is where you will go when you want to install a new widget. Any numbers that appear to the right of this line represent the number of uninstalled widgets that have an update available.</li>
		<li data-target="#uninstalled" data-title="Change Pages">Quickly change between installed and uninstalled pages using these tabs.</li>
		{php} if ($_GET["status"] != "uninstalled"){ echo '<li data-target="#apply_changes" data-title="Apply Changes">To disable a widget, but leave it installed, uncheck the box in the "Enabled" column below and click on the Apply Changes button.</li>'; } {/php}
	</ol>

	<script src="{$my_base_url}{$my_pligg_base}/modules/hello_world/templates/bootstrap-tour.js" type="text/javascript"></script>

	{literal}
	<script type="text/javascript">
	  $(window).load(function() {
		$(this).featureTour({
		  /* Options will go here */
		});
	  });

	$(this).featureTour({
	  'cookieMonster': true,         	// true/false for whether cookies are used
	  'cookieName': 'HelloWorldWidgets',  // choose your own cookie name
	  'cookieDomain': false,           	// set to false or yoursite.com
	  'tipContent': '#HelloWorld',    	// The ID of the <ol> used for content
	  'postRideCallback': $.noop,      	// A method to call once the tour closes
	  'postStepCallback': $.noop,      	// A method to call after each step
	  'nextOnClose': false,            	// If cookies are enabled, increment the current step on close
	  'debug': false
	});
	</script>
	{/literal}
{/if}