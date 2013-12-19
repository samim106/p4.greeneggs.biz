<?php if($user): ?>
	<div id='fp1'>
		Welcome back <?=$user->first_name;?>! We're glad you stopped by.<br>
		Click below to get to your posts --> <a href='/posts'>Goto posts</a>
	</div>
<?php else: ?>

<div id='fp1'>
	Welcome to Green Eggs Chatroom!<br>
	Please sign in to the right or create a new account if you're new to this site.
	We're glad you stopped by. Feel free to follow other people, read their insights, and just have a good time!
	<ul>
		<li>All aspects of posting has been updated to use AJAX.</li>
		<li>A global chatroom has been added and all messages are saved.</li>
</div>
<div id='fp2'>
	<form method='POST' action='/users/p_login'>
		username <input type="text" name="email" /> <br/>
		password <input type="password" name="password" /> <br/>
		<input type="submit" value="login">
	</form>

	<br><br>
	<div id='signup_button'>
		<a href='/users/signup'>CREATE AN ACCOUNT</a>
	</div>
</div>


<?php endif; ?>
