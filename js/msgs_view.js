$(document).ready(function(){

//---------------------------------------
//	load more posts
var tot_msgs = $('#tot_msgs').attr('value');
//console.log("tot_msgs start: " + tot_msgs);

var tot_length = 0;

var options = {
	type: 	'POST',
	url: 	'/msgs/view_more/',
	dataType: 'json',
	beforeSubmit: function() { $('#results').html("Retrieving the messages...") },
	success: function(data) {
		var data_len = data.length;
		//console.log("data len: " + data.length);
		//console.log("tot len: " + tot_length);
		if (data_len <= tot_length) {
			$('#results').html("There are no more messages to retrieve.");
			return;
		}
		tot_length = data_len;

		// clear the chatroom view
		document.getElementById('msg-output').innerHTML = "";
		// populate with the messages
		for (var i=0;i<data_len;++i)
		{
			var poster  = data[i].first_name;
			var content = data[i].content;

			$('#msg-output').append("<span><b>" + poster + ":</b> " + content + "</span><br/>");
		}
		
		// update the results
		$('#results').html("");
		
		// update the msg count
		tot_msgs = parseInt(tot_msgs) + 20;
		$('#tot_msgs').val(tot_msgs);
	},
	error: function() {
		$('#results').html("An error occurred while trying to get more messages...");
	}
};
$('form').ajaxForm(options);

});