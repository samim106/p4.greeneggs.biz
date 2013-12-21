$(document).ready(function(){

//---------------------------------------
//	Follow / Unfollow users
$('.uf_link').click(function() {
	var user_id = $(this).attr('id');
	var cmd = $(this).text();
	
	//console.log("user_id: " + user_id + "\n cmd: " + cmd);
	
	var options = {
		type: 	'POST',
		url: 	'/posts/' + cmd + '/' + user_id,
		success: function(response) {
			var ret = $.parseJSON(response);
			//console.log("ret: " + ret['cmd']);
			var new_cmd = ret['cmd'];
			// set the text for the follow / unfollow cmd
			$('a#'+user_id).text(new_cmd);
		},
		error: function() {
			$('#err_msg').html("An error occurred while trying to update your following status...");
		}
	};
	$.ajax(options);
		
	// prevent the page from going to the link
	return false;
});


});