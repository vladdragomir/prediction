$(document).ready(function() {
	$('.js-predict').submit(function(e) {
		e.preventDefault();

		$.ajax({
			url: '/predict',
			type: 'POST',
			data: {
				predictContent: $('#predictContent').val()
			}
		})
		.done(function(response) {
			console.log(response);
		});
	});
});
