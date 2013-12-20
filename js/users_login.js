$(document).ready(function(){

//---------------------------------------
//	Login

	var options = {
		type: 	'POST',
		url: 	'/users/p_login',
		success: function(response) {
			var ret = $.parseJSON(response);
			var msg = ret['msg'];
			
			// set the text for the login if incorrect
			$('#results').html(ret['msg']);
			
			// redirect to the posts
			window.setTimeout(function() { window.location.href = '/posts/'; }, 2000);
		},
		error: function() {
			$('#err_msg').append("An error occurred while trying to log in...");
		}
	};

	$('form').ajaxForm(options);
});