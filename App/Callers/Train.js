$(document).ready(function() {
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
		});
	});
});
