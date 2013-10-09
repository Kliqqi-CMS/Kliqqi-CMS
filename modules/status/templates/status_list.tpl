{config_load file=status_lang_conf}
<div class="clearfix"></div>
<link rel="stylesheet" type="text/css" href="{$my_pligg_base}/modules/status/templates/status_update.css" media="screen">
<div class="masonry status_update" id="status_update_module">
	<script>
		var my_pligg_base = '{$my_pligg_base}';
		var likes = "{#PLIGG_Status_Likes#}";
		var nolikes = "{#PLIGG_Status_No_Likes#}";
	</script>
	<script src='{$my_pligg_base}/modules/status/status.js'></script>

	{checkActionsTpl location="status_update_top"}
	{php}
		global $db, $current_user, $URLMethod;
		include_once(mnminclude.'search.php');

		$this->_vars['isadmin'] = checklevel('admin');
		$this->_vars['isadmin'] = checklevel('moderator');

		$settings = get_status_settings();
		$user = new User;
		$user->username = $this->_vars['user_login'] ? $this->_vars['user_login'] : $current_user->user_login;
		if($settings['switch'] && $user->read() && status_is_allowed($user) && $user->extra_field['status_switch'])
		{

		$this->_vars['current_user'] = get_object_vars($current_user);
		$this->_vars['current_username'] = '@'.$current_user->user_login;
		$this->_vars['settings'] = $settings;

		if ($_POST['page']) $page=$_POST['page'];	
		else $page=1;
		$page_size = $settings['results'];

		if ($_POST['ssearch'])
		{
			$search=new Search();
			$search->searchTerm = $db->escape(sanitize($_REQUEST['ssearch']), 3);

			$words = str_replace(array('-','+','/','\\','?','=','$','%','^','&','*','(',')','\'','!','@','|'),'',$search->searchTerm);
			$SearchMethod = SearchMethod; 
			if($SearchMethod == 3){
				$SearchMethod = $search->determine_search_method($words);
			}
			if($SearchMethod == 1){
				$words = str_replace('+','',stripslashes($words));
				if (preg_match_all('/("[^"]+"|[^\s]+)/',$words,$m))
					$words = '+'.join(" +",$m[1]);
				$search_sql = " AND MATCH (update_text) AGAINST ('$words' IN BOOLEAN MODE) ";
			}
			else 
				$search_sql = ' AND '.$search->explode_search('update_text', $words);
		}

		if ($user->extra_field['status_friends'])
		{
			$friends_sql = "(b.friend_from='{$user->id}' ";
			if (!$user->extra_field['status_all_friends'])
				if ($user->extra_field['status_friend_list'])
				$friends_sql .= " AND c.user_login IN ('".str_replace(',',"','",$user->extra_field['status_friend_list'])."')";
			else
				$friends_sql .= " AND 0";
			$friends_sql .= ") OR";
		}
			if (enable_group && $user->extra_field['status_group'])
				$group_sql = " OR !ISNULL(d.member_id) ";
		$sql = "SELECT SQL_CALC_FOUND_ROWS * FROM ".table_prefix."updates a
				LEFT JOIN ".table_prefix."likes ON like_user_id='{$current_user->user_id}' AND like_update_id=update_id
				LEFT JOIN ".table_friends." b ON a.update_user_id=b.friend_to
				LEFT JOIN ".table_users." c ON a.update_user_id=c.user_id
				LEFT JOIN ".table_group_member." d ON d.member_group_id=a.update_group_id AND member_user_id='{$user->id}'
				WHERE (($friends_sql a.update_user_id='{$user->id}') 
				OR update_level='$user->level'
				$group_sql ".
				($user->extra_field['status_excludes'] ? " AND update_id NOT IN (".$user->extra_field['status_excludes'].")" : "").
				" OR update_level='all') $search_sql
				GROUP BY update_id
				ORDER BY update_time DESC      	
				LIMIT ".($page-1)*$page_size.",$page_size";
		$updates = $db->get_results($sql,ARRAY_A);
		$count   = $db->get_var("SELECT FOUND_ROWS()");
		$this->_vars['updates'] = $updates;
	{/php}

	{literal}
	<script>
	function status_next_page(page)
	{
		var form = document.getElementById('status_search');
		form.page.value = page;
		form.submit();
		return false;
	}
	</script>
	{/literal}

	{$settings.pre_format}

	
<div class="tabbable">
	<ul class="nav nav-tabs">
		<li class="active"><a href="#submit" data-toggle="tab">Submit Update</a></li>
		<li><a href="#search" data-toggle="tab">Search Updates</a></li>
	</ul>
	<div class="tab-content">
		<div id="submit" class="tab-pane active">
			{* Submit form *}
			{if $user_login == $current_user.user_login || ($settings.inputonother=='1' && strstr($settings.profile_level,$current_user.user_level))}
				{$settings.pre_submit}
				{$templatelite.session.status_error}
				<div class="status_submit">
				{checkActionsTpl location="status_submit_1"}
					<h4 class="status_submit_title">{#PLIGG_Status_Submit_Updates#}</h4>
					<form method='post' action='{$my_pligg_base}/modules/status/status.php'>
						<div class="col-lg-12">
							{checkActionsTpl location="status_submit_2"}
							<div class="col-lg-10">
								<textarea rows="2" class="form-control status_submit_input" name="status">{php}if ($_SESSION['status_text']) print $_SESSION['status_text']; elseif ($user->id != $current_user->user_id) print '@'.$user->username.' ';{/php}</textarea> 
								{checkActionsTpl location="status_submit_3"}
							</div>
							<div class="col-lg-2">
								<input class="btn btn-primary status_submit_submission" value="{#PLIGG_Status_Submit#}" type="submit">
							</div>
						</div>
					</form>			
					<div class="clearfix"></div>
				{checkActionsTpl location="status_submit_4"}
				</div>
				{$settings.post_submit}
			{/if}
			{* end of Submit form *}
		</div>
		<div id="search" class="tab-pane">
			{* Search form *}
			<form method='post' id='status_search' !action='{php}print getmyurl('user2', $user->username, 'profile');{/php}'>
				<input name="page" type="hidden" value="">
				{if $settings.allowsearch}
					{$settings.pre_search}
					{checkActionsTpl location="status_search_1"}
					<div class="status_search">
						<h4 class="status_search_title">{#PLIGG_Status_Search_Updates#}</h4>	
						<div class="col-lg-4 status_search_form">
							<div class="input-group">
								{checkActionsTpl location="status_search_2"}
								<input placeholder="Enter search terms here..." class="form-control status_search_input" name="ssearch" type="text" value="{$templatelite.post.ssearch|sanitize:2}">
								{checkActionsTpl location="status_search_3"}
								<span class="input-group-btn">
									<input class="btn btn-primary status_search_submission" value="{#PLIGG_Status_Search#}" type="submit">
								</span>
							</div>
						</div>
						<div class="clearfix"></div>
					</div>
					{checkActionsTpl location="status_search_4"}
					{$settings.post_search}
				{/if}
			</form>
			{* end of Search form *}
		</div>
	</div><!-- /.tab-content -->
</div><!-- /.tabbable -->
	
	{checkActionsTpl location="status_update_middle"}

	<div class="status_friend_updates">
		<div class="status_friend_updates_title">
			<h4>{if $templatelite.post.ssearch}{#PLIGG_Status_Search_Results#}{else}{#PLIGG_Status_Friend_Updates#}{/if}</h4>
		</div>

		{foreach from=$updates item=update}
			<div class="status_message_wrapper">
				<a id='{$update.update_id}'></a>
				{if $update.update_type=='c'}
				{$settings.pre_comment}
				{elseif $update.update_type=='s'}
				{$settings.pre_story}
				{elseif strstr($update.update_text,$current_username)}
				{$settings.pre_username}
				{/if}
				<div class="status_message_content_wrapper">
					<div class="status_message_tools">
						{checkActionsTpl location="status_tools_1"}

						{if $current_user.user_id>0 && $update.update_user_id!=$current_user.user_id}
							<a href="{$my_pligg_base}/modules/status/status.php?lid={$update.update_id}" onclick='like({$update.update_id}); return false'><span id='like{$update.update_id}' {if $update.like_user_id}style='display:none;'{/if}>{#PLIGG_Status_Like#}</span><span id='unlike{$update.update_id}' {if !$update.like_user_id}style='display:none;'{/if}>{#PLIGG_Status_Unlike#}</span></a>
							| 
						{/if}

						<a href='#' id='count{$update.update_id}' onclick='show_likes({$update.update_id}); return false;' {if $update.update_likes<=0}disabled{/if}>{if $update.update_likes>0}{$update.update_likes} {#PLIGG_Status_Likes#}{else}{#PLIGG_Status_No_Likes#}{/if}</a>
						<div id='likes{$update.update_id}' style='display: none'></div> | 

						<a href="{$my_pligg_base}{php}
						global $URLMethod, $my_base_url, $my_pligg_base;
						if ($URLMethod==2) print "/status/"; 
						else print "/modules/status/status.php?id=";{/php}{$update.update_id}">{#PLIGG_Status_Permalink#}{if $settings.show_permalinks} {$update.update_id}{/if}</a>
						{checkActionsTpl location="status_tools_2"}
						{if $current_user.user_id && ($update.update_user_id==$current_user.user_id || $isadmin || $isadmin)}
							| <a href="{$my_pligg_base}/modules/status/status.php?did={$update.update_id}">{#PLIGG_Status_Delete#}</a>
							{assign var='slash' value='1'}
						{/if}
						{if $current_user.user_id && $update.update_user_id!=$current_user.user_id}
							{if $slash} | {/if}
							<a href="#" onclick="document.getElementById('reply{$update.update_id}').style.display='block'; return false;">{#PLIGG_Status_Reply#}</a> |
							<a href="{$my_pligg_base}/modules/status/status.php?hid={$update.update_id}">{#PLIGG_Status_Hide#}</a>
						{/if}
						{checkActionsTpl location="status_tools_3"}
					</div>
					<div class="status_message_stats">
						<div class="status_message_username">
							{checkActionsTpl location="status_user_1"}
							<a href="{php}print getmyurl('user2', $this->_vars['update']['user_login'], 'profile');{/php}">
							<img alt="" class="status_message_avatar" src="{php}print get_avatar($settings['avatar'], "", "", "", $this->_vars['update']['user_id']);{/php}" style="width:22px;height:22px;" />
							{checkActionsTpl location="status_user_2"}
							{$update.user_login}
							{checkActionsTpl location="status_user_3"}
						</div>
						<div class="status_message_time">
							</a> 
							{if $settings.clock=='12'}
								{php}print date("F j, Y h:i:sa",$this->_vars['update']['update_time']);{/php}
							{else}
								{php}print date("F j, Y H:i:s",$this->_vars['update']['update_time']);{/php}
							{/if}
						</div>
						<div class="clearfix"></div>
					</div>
					<div class="status_message_content">
						{checkActionsTpl location="status_message_1"}
						{if $update.update_type=='m'}
							{php}
							if ($this->_vars['update']['update_group_id'])
							{
								$group = $db->get_row("SELECT * FROM ".table_groups." WHERE group_id={$this->_vars['update']['update_group_id']}");
								$this->_vars['update']['update_text'] = str_replace( '!'.$group->group_name, "<a href='".getmyurl("group_story_title", $group->group_safename)."'>!{$group->group_name}</a>", $this->_vars['update']['update_text'] );
							}
							if (in_array($this->_vars['update']['update_level'],array('admin','moderator')))
								$this->_vars['update']['update_text'] = str_replace( '*'.$this->_vars['update']['update_level'], "<span style='color:red;'>*{$this->_vars['update']['update_level']}</span>", $this->_vars['update']['update_text'] );
							elseif ($this->_vars['update']['update_level'])
								$this->_vars['update']['update_text'] = str_replace( '*'.$this->_vars['update']['update_level'], "", $this->_vars['update']['update_text'] );
							print preg_replace(
								array("/@([^\s]+)/e",
									  "/#(\d+)/e"),
								array("'@<a href=\"'.getmyurl('user2', '\\1', 'profile').'\">\\1</a>'",
									  $settings['permalinks'] ? "'<a href=\"'.my_pligg_base.'/modules/status/status.php?id=\\1\">#\\1</a>'" : ""),
								$this->_vars['update']['update_text']);
							{/php}
						{else}
							{$update.update_text}
						{/if}
						{checkActionsTpl location="status_message_2"}
					</div>

					{* Reply form *}
					<div id="reply{$update.update_id}" style="display: none;">
						<div class="status_reply">
							<h4>{#PLIGG_Status_Post_Reply#}</h4>
							<div class="status_reply_form">
								<form method='post' action='{$my_pligg_base}/modules/status/status.php'>
									<input value="{$update.update_id}" type="hidden" name="id">
									<textarea rows="1" class="col-md-6 status_reply_textarea" name="status">@{$update.user_login} {if $settings.permalinks}#{$update.update_id} {/if}</textarea>
									<input value="{#PLIGG_Status_Submit_Reply#}" class="col-md-2 btn status_reply_submit" type="submit">
								</form>
							</div>
						</div>
					</div>
					{* end of Reply form *}
				</div>

				{if $update.update_type=='c'}
					{$settings.post_comment}
				{elseif $update.update_type=='s'}
					{$settings.post_story}
				{elseif strstr($update.update_text,$current_username)}
					{$settings.post_username}
				{/if}
			</div>
		{foreachelse}
			{if $templatelite.post.ssearch}
				{#PLIGG_Status_No_Results#|sprintf:$templatelite.post.ssearch|strip_tags}
			{/if}
		{/foreach}
	</div>

	{php}
		$output = do_pages($count, $page_size, $page, true);
		$output = preg_replace('/"[^"]+\/(\d+)">([^<]+)</','"#" onclick="return status_next_page(\\1)">\\2<',$output);
		$output = preg_replace('/"?page=(\d+)"[^>]*>([^<]+)</','"#" onclick="return status_next_page(\\1)">\\2<',$output);
		print $output;
	{/php}

	{$settings.post_format}

	{php}
		}
		unset($_SESSION['status_error']);
		unset($_SESSION['status_text']);
	{/php}
</div> <!-- End status_update class -->

{config_load file=status_pligg_lang_conf}

