<div id='article_container'>
<?php 
/*
	if ($msgs==null) {
		echo "There are no messages to display.";
	} 
*/
?>
<!--	
	<div id='msg_prev_container'>
<?php 
/*
	$msgs = array_reverse( $msgs );
	foreach($msgs as $msg): 
?>
		<article class='msg-one'>
			<div class='article_content'>
				<?=$msg['content']?>
			</div>
			<div class='article_poster'>
				<?=$msg['first_name']?> - 
				<time datetime="<?=Time::display($msg['created'],'Y-m-d').'T'.Time::display($msg['created'],'H:i:s')?>">
					<?=Time::display($msg['created'])?>
				</time>
			</div>
		</article>
<?php endforeach; ?>
*/ ?>
	</div>
-->
	
	<!-- Global Chatroom -->
	<div id='msg-container'>
		<div id="msg-output"></div>
		<br>
		<form method='post' action='/msgs/p_add/'>
			<input type='text' name='content' id='msg' maxlength='144'>
			<input type='submit' value='Send' id="send-msg">
		</form>
		<div id='chars-remaining'>144 characters remaining</div>
		<br/>
		<div id='results'></div>
	</div>
	
	<!-- Private Chatroom 
	<div id='msg-container-priv'>
	</div>
	-->
</div>


<!--
<div id='msg-user-list-container'>
	<h2>User List</h2>
	<ul id='msg-user-list'>
	<?php 
	/*
		foreach($users as $user):
			print('<li name='.$user['user_id'].'>'.$user['first_name'].' '.$user['last_name'].'</li>');
		endforeach;
	*/
	?>
	</ul>
</div>
-->
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="http://cdn.pubnub.com/pubnub.js"></script>

