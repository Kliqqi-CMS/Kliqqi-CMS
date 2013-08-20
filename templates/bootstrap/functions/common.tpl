<script>{literal}
function show_hide_user_links(thediv)
{
	if(window.Effect){
		if(thediv.style.display == 'none')
		{Effect.Appear(thediv); return false;}
		else
		{Effect.Fade(thediv); return false;}
	}else{
		var replydisplay=thediv.style.display ? '' : 'none';
		thediv.style.display = replydisplay;					
	}
}
{/literal}</script>
