jQuery(document).ready(function($){
	$('<div id="welcome-panel" class="welcome-panel"><a class="welcome-panel-close" href="http://dev1.localhost/wp/wp-admin/?welcome=0">Dismiss</a><div class="wp-badge">Version 3.4.2</div><div class="welcome-panel-content"><h3>Welcome to your online course!</h3><p class="about-description">Say something really cool and encouraging here to help the new SME/Course instructor along in their journey to publishing/teaching their online course.</p></div></div>').insertAfter('body.index-php #wpbody-content .wrap h2');
});