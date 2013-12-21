$(document).ready(function(){

//---------------------------------------
//	Login

	var options = {
		type: 	'POST',
		url: 	'/users/p_login',
		beforeSubmit: function() { $('#results').html("Validating your login...") },
		success: function(response) {
			var ret = $.parseJSON(response);
			
			// set the text for the login if incorrect
			$('#results').html(ret['msg']);
			if (ret['cmd'] >= 0) {
				window.setTimeout(function() { window.location.href = '/posts/'; }, 2000);
			}
			
			// redirect to the posts
			
		},
		error: function() {
			$('#err_msg').html("An error occurred while trying to log in...");
		}
	};

	$('form').ajaxForm(options);
});