$(document).ready(function() {
	if (authenticated !== '') {
		$('.js-connect-tab').hide();
		$('.js-train-tab').addClass('is-active');
	}
});