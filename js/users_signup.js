$(document).ready(function(){

//---------------------------------------
//	Sign up
{
	var options = {
		type: 	'POST',
		url: 	'/users/p_signup',
		success: function(response) {
			var ret = $.parseJSON(response);
			console.log("ret: " + ret['msg']);
			var msg = ret['msg'];
			// set the text for the login if incorrect
			$('#results').text(ret['msg']);
			
			window.setTimeout(function() { window.location.href = '/posts/'; }, 2000);
		},
		error: function() {
			$('#err_msg').append("An error occurred while trying to log in...");
		}
	};
	$('form').ajaxForm(options);
}

});