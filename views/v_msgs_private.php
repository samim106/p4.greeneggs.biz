<div id='article_container'>
	
	<!-- Private Chatroom -->
	<h2>Private chats</h2>
	<div id='msg-container-priv'>
	</div>
	
	<div id='msg-user-list-container'>
		<h2>User List</h2>
		<ul id='msg-user-list'>
		<?php 
			foreach($users as $user):
				print('<li name='.$user['user_id'].'>'.$user['first_name'].' '.$user['last_name'].'</li>');
			endforeach;
		?>
		</ul>
	</div>
</div>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="http://cdn.pubnub.com/pubnub.js"></script>
<script type="text/javascript" src="/js/msgs_private.js"></script>
