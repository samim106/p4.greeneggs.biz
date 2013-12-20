<div id='msg-container'>
	<div id="msg-output">
<?php 
	$msgs = array_reverse( $msgs );
	foreach($msgs as $msg): 
		echo "<span><b>" . $msg['first_name'] . ":</b> " . $msg['content'] . "</span><br/>";
		/*
		$poster  = $msg['first_name'] ." ". Time::display($msg['created'], 'm-d H:i');
		if ($msg['sender_id'] == $myID) {
			echo "<span class='msg-sent'><b>" . $poster . ":</b> " . $msg['content'] . "</span><br/>";
		} else {
			echo "<span class='msg-recd'><b>" . $poster . ":</b> " . $msg['content'] . "</span><br/>";
		}
		*/
	endforeach; 
?>
	</div>
	<form method='post' action='/msgs/view_more/0'>
		<input type='hidden' name='tot_msgs' id='tot_msgs' value='20'>
		<input type='submit' value='Load 20 prior messages' id="view_more">
	</form>
	The last 20 messages were loaded. To load more, press the button above.
	<br/>
	<div id='results'></div>
</div>
