<div id="fb-root"></div>
<script>
var logout_url = "{$URL_logout}";
var appid = "{$fb_key}";

{php}
//if ($this->_vars['URL_logout'] && $this->_vars['user_fb_id'])
//    $this->_vars['URL_logout'] = "#\" onclick=\"FB.logout(FBredirect)";
{/php}

{literal}
  window.fbAsyncInit = function() {
    FB.init({appId: appid, status: true, cookie: true, xfbml: true});
  };

  (function() {
    var e = document.createElement('script'); e.async = true;
    e.src = document.location.protocol +
      '//connect.facebook.net/en_US/all.js';
    document.getElementById('fb-root').appendChild(e);
  }());

	function FBredirect(response) {
    	    window.location = logout_url;
    	    return;
    	}

{/literal}
</script>
