{if $user_logged_in}
	<div class="headline">
		<div class="sectiontitle">Saved Stories</div>
	</div>
	<div class="boxcontent" >
		<ul class="sidebar-saved" id="saved_stories">
			{checkActionsTpl location="tpl_widget_saved_start"}	
			{php}
			include_once('internal/Smarty.class.php');
			$main_smarty = new Smarty;

			include_once('config.php');
			include_once(mnminclude.'html1.php');
			include_once(mnminclude.'link.php');
			include_once(mnminclude.'tags.php');
			include_once(mnminclude.'search.php');
			include_once(mnminclude.'smartyvariables.php');

			// -------------------------------------------------------------------------------------

			global $the_template, $main_smarty, $db;
			$user_id = $main_smarty->get_template_vars('user_id');
			$res = "select link_id,link_title,saved_id,saved_user_id,saved_link_id from ".table_links.",".table_saved_links." WHERE saved_user_id =$user_id and link_id = saved_link_id  ORDER BY saved_id DESC limit 5";

			$list_savedlinks = $db->get_results($res);
			if($list_savedlinks)
			{
				foreach($list_savedlinks as $row){            
					$story_url = getmyurl("story", $row->link_id);
					echo "<li><a class='switchurl' href='".$story_url."'>".$row->link_title."</a></li>";                
				}
			}
			{/php}
			{checkActionsTpl location="tpl_widget_saved_end"}
		</ul>
	</div>
{/if}