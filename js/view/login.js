$(function() {

	$('#login').on('click', function() {
		var requestParam = {
			username: $("#username").val(),
			password: $("#password").val()
		}

		var loginSuccess = function(response) {
			location.href = 'index.html';
		}

		ajax({
			url: 		apiList.login,
			data: 		requestParam,
			success: 	loginSuccess
		});
	});
});