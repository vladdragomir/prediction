$(document).ready(function() {
	$('.js-predict').submit(function(e) {
		e.preventDefault();

		$.ajax({
			url: '/predict',
			type: 'POST',
			dataType: 'json',
			data: {
				predictContent: $('#predictContent').val()
			}
		})
		.done(function(response) {
			var resultsContainer = $('.prediction-results');

			response.forEach(function(item) {
				resultsContainer.append('<p><b>Label:</b> ' + item.label +'</p>');
				resultsContainer.append('<p><b>Score:</b> ' + item.score +'</p>');
			})
		});
	});
});
