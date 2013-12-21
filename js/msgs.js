$(document).ready(function(){

// initialize
{
	var gSenderID		= '';
	var gBkgnd			= new Array();
	var channel			= 'greeneggs_msgs';
	var err_msg			= $('#err_msg');
	var output			= $('#msg-output');
	var output_priv		= $('#msg-output-priv');
	
	var pubnub = PUBNUB.init({
		publish_key: 	'pub-c-133f21e4-3995-458c-9936-c1544e69c04e',
		subscribe_key:	'sub-c-22828d84-654f-11e3-bd1e-02ee2ddab7fe',
	});
	
	// put the focus on the text box
	$('#msg').focus();
}

//---------------------------------------
//	Subscribe to the channel
//	This is triggered after every turn, since the turn sends a message
//---------------------------------------
pubnub.subscribe({
	channel: channel,
	message: function(message){
		// Turn the string of JSON into an array
		var results   = $.parseJSON(message);

		// Pull the information
		var sender_id		= results['sender_id'];
		var sender_fname	= results['sender_fname'];
		var receiver_id		= results['receiver_id'];
		var msg				= results['message'];

		// listen for messages
		listen(sender_id,sender_fname,receiver_id,msg);
	},	
});

$('#showmenu').click(function() {
	$('.menu').slideToggle("fast");
});

//---------------------------------------
//	Message limit to 144 chars
$('#msg').keyup( function() {
	$('#chars-remaining').html((144 - $('#msg').val().length) + ' characters remaining');
	
	// clear the results box
	$('#results').html("");
});

//---------------------------------------
//	Send message button
$('#send-msg').click(function() {
	if ($('#msg').val() == '') {
		$('#results').html("Please input text before submitting");
		return false;
	} else {
		// send the message
		send_msg(0);
		
		// hide the previous chats
		//$('#msg_prev_container').slideUp(); 		// !@#!@# this needs to be integrated into the chat windows stupid
		
		// put the focus back into the text box
		$('#msg').focus();
	}
});


//---------------------------------------
//	Send private message button
$('#send-msg-priv').click(function() {
	// get the receiver id
	var r_id	= $(this).attr('r_id');
	//console.log("r_id: " + r_id);
	
	// send the message
	send_msg(r_id);
	
	//console.log('here!!!!');
});


//---------------------------------------
//	Send the message
function send_msg(r_id) {
 	// Get the message you want to send
	var szMsg = $('#msg').val();
	if (r_id != 0) {
		szMsg = $('#msg-priv-'+r_id).val();
	}
	//console.log("szMsg: " + szMsg);		// !@#!@#

	// set up the options for ajax
	var options = {
		type: 'POST',
		url: '/msgs/p_add/'+r_id,
		success: function(response) {
			var ret = $.parseJSON(response);
			var sender_fname	= ret['sender_fname'];
			gSenderID 			= ret['sender_id'];
			//console.log('gSenderID1: ' + gSenderID);

			// Data of player_id and roll
			data = { 
				'sender_id'		: gSenderID,
				'sender_fname'	: sender_fname,
				'receiver_id'	: r_id,
				'message'		: szMsg 
			}

			// Convert the data to JSON string
			var message = JSON.stringify(data);
			
			// Publish 
			pubnub.publish({
				channel: channel,
				message: message,
			});
	
			// reset the counter
			$('#chars-remaining').html('144 characters remaining');
		},
		error: function() {
			err_msg.html("An error occurred while trying to send your message...");
		},
		clearForm: true
	};
	$('form').ajaxForm(options);
	
}

//---------------------------------------
//	Listen for messages
function listen(sender_id, sender_fname, receiver_id, msg) {
	//console.log("gSenderID: " + gSenderID);
	//console.log("sender_id: " + sender_id);
	//console.log("sender_fn: " + sender_fname);
	//console.log("receiver_id: " + receiver_id);

	// format the msg
	{
		// add color to the text depending if you're the sender or not
		if (sender_id == gSenderID) {
			msg = "<span class='msg-sent'><b>" + sender_fname + ":</b> " + msg + "</span>";
		} else {
			msg = "<span class='msg-recd'><b>" + sender_fname + ":</b> " + msg + "</span>";
		}
		
		// add background to every other msg 
		if (receiver_id == 0) {
			if (gBkgnd[receiver_id]) {
				msg = "<span class='msg-bkgnd'>" + msg + "</span>";
				gBkgnd[receiver_id] = false;
			} else {
				gBkgnd[receiver_id] = true;
			}
		} else {
			if (gBkgnd[sender_id]) {
				msg = "<span class='msg-bkgnd'>" + msg + "</span>";
				gBkgnd[sender_id] = false;
			} else {
				gBkgnd[sender_id] = true;
			}
		}
	}

	// receiver_id 0 = global chat room
	if (receiver_id == 0) 
	{
		// post the msg to the chat box
		output.append(msg);
		
		// scroll to see the msg
		output.scrollTop(output[0].scrollHeight);
	} 
	// message will go to a private chat window if it's meant for me
	else if (gSenderID == receiver_id) {
		// check to see if the div exists
		if ($('#msg-output-priv-'+sender_id).length == 0) {
		// create div
		$('#msg-container-priv').append(
			"<div id='msg-container-priv-"+sender_id+"' class='msg-output-priv'></div><br>"+
			"<form method='post' action='/msgs/p_add/"+sender_id+"'>"+
			"	<input type='text' name='content' id='msg-priv' maxlength='144'>"+
			"	<input type='submit' value='Send' id='send-msg-priv'>"+
			"</form>"+
			"<div id='chars-remaining-priv'>144 characters remaining</div>"
			);
		} else {
			// chatbox already exists, post message
			$('#msg-output-priv-'+sender_id).append(msg);
		}
		
		// scroll to the bottom of the chat box
		myPrivDiv.scrollTop(output[0].scrollHeight);
	}
}

//---------------------------------------
//	Listen for clicks on user list
$('#msg-user-list li').click(function() {
	var r_id	= $(this).attr('name');
	var toName	= $(this).html().toLowerCase().trim();
	
	// open the chat window for that ID
	var myStr = '#msg-output-priv-' + r_id;
	var myPrivDiv = $(myStr);
	//console.log("myprivdiv: " + myPrivDiv);
	
	// check to see if the div exists
	if ($('#msg-output-priv-'+r_id).length == 0) {
		// create div
		$('#msg-container-priv').append(
			"<div id='msg-container-priv-"+r_id+"' class='msg-output-priv'></div><br>"+
			"<form method='post' action='/msgs/p_add/"+r_id+"'>"+
			"	<input type='text' name='content' id='msg-priv-"+r_id+"' maxlength='144'>"+
			"	<input type='submit' value='Send to "+toName+"' r_id='"+r_id+"' id='send-msg-priv'>"+
			"</form>"+
			"<div id='chars-remaining-priv'>144 characters remaining</div>"
			);
	} else {
		// do nothing, we're just opening up a chat box 
	}
});





});