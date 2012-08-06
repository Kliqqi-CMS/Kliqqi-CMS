{if $error}

<font color=red>{$error}</font>

{else}

{$message}:<br>
<a href='{$story_url}'>{$link.title}</a><br>

{/if}
