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
		publish_key: 'pub-c-133f21e4-3995-458c-9936-c1544e69c04e',
		subscribe_key: 'sub-c-22828d84-654f-11e3-bd1e-02ee2ddab7fe',
	});
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


//---------------------------------------
//	Listen for clicks on user list
$('#msg-user-list li').click(function() {
	var r_id	= $(this).attr('name');
	var toName	= $(this).html().toLowerCase().trim();
	
	// check to see if the div exists
	if ($('#msg-container-priv-'+r_id).length == 0) {
		// create div
		$('#msg-container-priv').append(
		//	"<div class='msg-container-one'><div id='msg-container-priv-2' class='msg-output-priv'></div><br><form method='post' action='/msgs_private/p_add_one/2'><input type='text' name='content' id='msg-priv-2' maxlength='144'><input type='submit' value='Send to test' r_id='2' id='send-msg'></form><div id='chars-remaining-priv-2'>144 characters remaining</div></div>"
			"<div class='msg-container-one'>"+
			"	<div id='msg-container-priv-"+r_id+"' class='msg-output-priv'></div><br>"+
			"	<form method='post' action='/msgs_private/p_add_one/"+r_id+"'>"+
			"		<input type='text' name='content' id='msg-priv-"+r_id+"' maxlength='144'>"+
			"		<input type='submit' value='Send to "+toName+"' r_id='"+r_id+"' id='send-msg-priv'>"+
			"	</form>"+
			"	<div id='chars-remaining-priv-"+r_id+"'>144 characters remaining</div>"+
			"</div>"
			);
	} else {
		// do nothing, we're just opening up a chat box 
	}
});

//---------------------------------------
//	Message limit to 144 chars
$('#msg').keyup( function() {
	$('#chars-remaining').html((144 - $('#msg').val().length) + ' characters remaining');
});

//---------------------------------------
//	Send message button
$('#send-msg').click(function() {
	// send the message
	send_msg(0);
	
	// hide the previous chats
	$('#msg_prev_container').slideUp(); 		// !@#!@# this needs to be integrated into the chat windows stupid
	
	// put the focus back into the text box
	$('#msg').focus();
});

//---------------------------------------
//	Send private message button
$('#send-msg-priv').click(function() {
	// get the receiver id
	var r_id	= $(this).attr('r_id');
	console.log("r_id: " + r_id);
	
	// send the message
	send_msg(r_id);
	
	console.log('here!!!!');
});

//---------------------------------------
//---------------------------------------
$('#msg-container-priv').on("submit", function(e) {
	// get the receiver id
	var r_id	= $('#send-msg-priv').attr('r_id');
	//alert("r_id: " + r_id);
	e.preventDefault();
	// send the message
	send_msg(r_id);
});




//---------------------------------------
//---------------------------------------

//---------------------------------------
//	Send the message
function send_msg(r_id) {
 	// Get the message you want to send
	szMsg = $('#msg-priv-'+r_id).val();
	console.log("szMsg: " + szMsg);		// !@#!@#
	var myURL = '/msgs_private/p_add_one/'+r_id;
	
	console.log("erwerwerwerwer");
	// set up the options for ajax
	var options = {
		type: 'POST',
		url: '/msgs_private/p_add_one/'+r_id,
		beforeSubmit: console.log("beforesumbit"),
		success: function(response) {
			var ret = $.parseJSON(response);
			var sender_fname	= ret['sender_fname'];
			gSenderID 			= ret['sender_id'];
			console.log('gSenderID1: ' + gSenderID);

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
			err_msg.append("An error occurred while trying to send your message...");
		},
		clearForm: true
	};
	$('#msg-container-priv').ajaxForm(options);
	
}

//---------------------------------------
//	Listen for messages
function listen(sender_id, sender_fname, receiver_id, msg) {
	
	console.log("gSenderID: " + gSenderID);
	console.log("sender_id: " + sender_id);
	console.log("sender_fn: " + sender_fname);
	console.log("receiver_id: " + receiver_id);

	// format the msg
	{
		// add color to the text depending if you're the sender or not
		if (sender_id == gSenderID) {
			msg = "<span class='msg-sent'>" + sender_fname + ": " + msg + "</span>";
		} else {
			msg = "<span class='msg-recd'>" + sender_fname + ": " + msg + "</span>";
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

	if (gSenderID == receiver_id) {
		// check to see if the div exists
		if ($('#msg-container-priv-'+sender_id).length == 0) {
		// create div
		$('#msg-container-priv').append(
			"<div class='msg-container-one'>"+
			"	<div id='msg-container-priv-"+sender_id+"' class='msg-output-priv'></div><br>"+
			"	<form method='post' action='/msgs/p_add/"+sender_id+"'>"+
			"		<input type='text' name='content' id='msg-priv-"+sender_id+"' maxlength='144'>"+
			"		<input type='submit' value='Send to "+toName+"' r_id='"+sender_id+"' id='send-msg-priv'>"+
			"	</form>"+
			"	<div id='chars-remaining-priv'>144 characters remaining</div>"+
			"</div>"
		);
		} else {
			// chatbox already exists, post message
			$('#msg-output-priv-'+sender_id).append(msg);
		}
		
		// scroll to the bottom of the chat box
		$('#msg-output-priv-'+sender_id).scrollTop(output[0].scrollHeight);
	}
}




});