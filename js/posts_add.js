$(document).ready(function(){

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
		err_msg.append("An error occurred while trying to update your following status...");
	},
	clearForm: true
};
$('form').ajaxForm(options);

});