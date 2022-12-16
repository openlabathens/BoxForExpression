jQuery(document).ready(function( $ ) {
	//Open Why
	$('.why-cta').click(function(){
		$('.why-text').show();
	});
	//Open Who
	$('.who-cta').click(function(){
		$('.who-text').show();
	});
	//Close
	$('.close').click(function(){
		var what = $(this).data("about");
		$('.'+what+'-text').hide();
	});
});