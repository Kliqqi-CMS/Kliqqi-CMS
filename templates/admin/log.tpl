<!-- log.tpl -->
<a class="btn" ONCLICK="history.go(-1)">Return</a> <a class="btn btn-primary" href="admin_log.php?clear=1">Clear Log</a>
<br><br>
<pre>{php} @readfile('../'.LOG_FILE); {/php}</pre>
<!--/log.tpl -->