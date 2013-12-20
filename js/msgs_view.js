$(document).ready(function(){

//---------------------------------------
//	load more posts
var tot_msgs = $('#tot_msgs').attr('value');
console.log("tot_msgs start: " + tot_msgs);

var tot_length = 0;

var options = {
	type: 	'POST',
	url: 	'/msgs/view_more/',
	dataType: 'json',
	success: function(data) {
		if (data.length === tot_length) {
			$('#results').append("There are no more messages to retrieve.");
		}
		tot_length = data.length;
		
		document.getElementById('msg-output').innerHTML = "";
		for (var i=0;i<data.length;++i)
		{
			var poster  = data[i].first_name;
			var content = data[i].content;

			$('#msg-output').append("<span><b>" + poster + ":</b> " + content + "</span><br/>");
		}
		
		tot_msgs = parseInt(tot_msgs) + 20;
		$('#tot_msgs').val(tot_msgs);
	},
	error: function() {
		$('#results').append("An error occurred while trying to get more messages...");
	}
};
$('form').ajaxForm(options);
		
});