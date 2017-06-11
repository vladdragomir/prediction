$(document).ready(function() {
	$('.js-started').hide();
	$('.js-done').hide();
	$('.js-train-status').hide();

	$('.js-train').submit(function(e) {
		e.preventDefault();

		$.ajax({
			url: '/train',
			type: 'POST',
			data: {
				fileName: $('#fileName').val()
			}
		})
			.done(function() {
				$('.js-not-started').hide();
				$('.js-started').show();
				$('.js-train-status').show();
			})
			.fail(function() {
				$('.js-not-started').show();
				$('.js-started').hide();
				$('.js-train-status').hide();
			});
	});

	$('.js-train-status').click(function(e) {
		e.preventDefault();

		$.ajax({
			url: '/train-status',
			type: 'GET',
			dataType: 'json'
		})
			.done(function(response) {
				if (response.trainingStatus === 'DONE') {
					$('.js-train-status').hide();
					$('.js-started').hide();
					$('.js-done').show();
				}
			});
	});
});
