// Just load JS code from buttons.php for each link (AJAX proxy)
$(function() {
    $('a.PliggButton').map( function(i, val) {
    	$.getScript($('script').last().attr('src').replace(/\.js$/,'.php') + '?urls='+escape(val.href));
    });
});
