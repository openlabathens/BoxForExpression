jQuery(document).ready(function( $ ) {
	var consent = Cookies.get('consent');
	if(consent=="show"){
		$('.consent-container').show();
	}
	$('.accept').click(function () {
		$('.consent-container').hide();
		Cookies.remove('consent');
	})
});