$(document).ready(function(){

//---------------------------------------
//	Delete a post
{
	var options = {
		type: 	'POST',
		url: 	'/posts/p_delete_one',
		beforeSubmit: function() {
			$('#results').html("Deleting your post...");
		},
		success: function(response) {
			var ret = $.parseJSON(response);
			// Post the results
			$('#results').html(ret['msg']);
			
			// remove the deleted post
			$('.article_one').hide();
			$('form').hide();
		},
		error: function() {
			$('#err_msg').html("An error occurred while trying to delete your post...");
		}
	};
	$('form').ajaxForm(options);
}

});