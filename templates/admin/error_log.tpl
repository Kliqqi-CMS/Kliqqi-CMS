<!-- error_log.tpl -->
<legend>Error Log</legend>
<p>The following is the contents of the /{php} echo LOG_FILE; {/php} file, where Pligg CMS stores error messages. Not all of these error messages are significant, but you should carefully review each one to detect problems with your website. Once you have reviewed the errors below, dismiss them by clicking on the "Clear Log" button.</p>
<a class="btn" ONCLICK="history.go(-1)">Back</a> <a class="btn btn-primary" href="admin_log.php?clear=1">Clear Log</a>
<br /><br />
<pre>{php} @readfile('../'.LOG_FILE); {/php}</pre>
<!--/error_log.tpl -->