$(document).ready(function() {
	$('.js-started').hide();

	$('.js-train').submit(function(e) {
		e.preventDefault();

		$.ajax({
			url: '/train',
			type: 'POST',
			data: {
				fileName: $('#fileName').val()
			}
		})
			.done(function(response) {
				console.log(response);

				$('.js-not-started').hide();
				$('.js-started').show();
			})
			.fail(function() {
				$('.js-not-started').show();
				$('.js-started').hide();
			});
	});

	$('.js-train-status').click(function(e) {
		e.preventDefault();

		$.ajax({
			url: '/train-status',
			type: 'GET'
		})
			.done(function(response) {
				console.log(response);
			})
			.fail(function(response) {
				console.log(response);
			});
	});
});
