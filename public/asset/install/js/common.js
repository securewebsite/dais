$(document).ready(function() {
	// Sticky footer
	positionFooter();
	
	$(window).bind('resize', function () {
		positionFooter();
	});
	
	PluginInput.init();
	
	/*$(document).on('click', '.load-button', function(e) {
		e.preventDefault();
		$url = $(this).attr('href');
		$('#page-loader').fadeOut('slow', function(){
			$(this).load($url)
				.fadeIn('slow');
		});	
	});
	
	$(document).on('click', '#pre-install', function(e){
		e.preventDefault();
		$url = $('#pre-install-form').attr('action');
		alert($url);
		$.ajax({
				
		});
	});*/
	
	
	
});

function positionFooter () {
	$height = $('footer').outerHeight();
	$('#push').css('height', $height + 'px');
	$('.page-wrapper').css('margin-bottom', '-' + $height + 'px');
}