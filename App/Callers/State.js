$(document).ready(function() {
	if (authenticated !== '') {
		$('.js-connect-tab').hide();
		$('.js-train-tab').addClass('is-active');
	} else {
		$('.js-train-tab').hide();
		$('.js-predict-tab').hide();
	}
});