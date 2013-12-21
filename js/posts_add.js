$(document).ready(function(){

$('#results').html("Type your post in the textbox above and press the buttom above when done.");

var options = {
	type: 	'POST',
	url: 	'/posts/p_add',
	beforeSubmit: function() {
		$('#results').html("Adding your post...");
	},
	success: function(response) {
		var ret = $.parseJSON(response);
		
		// Post the results
		$('#results').html(ret['msg']);
	},
	error: function() {
		$('#err_msg').html("An error occurred while trying to update your following status...");
	},
	clearForm: true
};

$('form').ajaxForm(options);

});