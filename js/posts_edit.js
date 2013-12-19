$(document).ready(function(){

//---------------------------------------
//	Edit a post
{
	var options = {
		type: 	'POST',
		url: 	'/posts/p_edit_one',
		beforeSubmit: function() {
			$('#results').html("Editing your post...");
		},
		success: function(response) {
			var ret = $.parseJSON(response);
			// Post the results
			$('#results').html(ret['msg']);
		},
		error: function() {
			err_msg.append("An error occurred while trying to update your post...");
		}
	};
	$('form').ajaxForm(options);
}

});