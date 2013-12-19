<!DOCTYPE html>
<html>
<head>
	<title><?php if(isset($title)) echo $title; ?></title>

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />	
					
	<!-- Controller Specific JS/CSS -->
	<link rel="stylesheet" type="text/css" href="/css/style.css">
	<?php if(isset($client_files_head)) echo $client_files_head; ?>
	
</head>
<body>	
    <div id='menu_container'>
		<div id='menu_logo'>
			<a href='/'><img src='/images/logo.png' alt='logo'></a>
		</div>
		<div id='menu'>

			<!-- Menu for users who are logged in -->
			<?php if($user): ?>
				Hi <?=$user->first_name; ?>!&nbsp;&nbsp;
				<a href='/msgs/'>Messages</a>&nbsp;&nbsp;|&nbsp;&nbsp;
				<a href='/posts/'>Posts</a>&nbsp;&nbsp;|&nbsp;&nbsp;
				<a href='/posts/users/'>Users</a>&nbsp;&nbsp;|&nbsp;&nbsp;
				<a href='/users/profile'>Profile</a>&nbsp;&nbsp;|&nbsp;&nbsp;
				<a href='/users/logout'>Logout</a>&nbsp;&nbsp;
			<!-- Menu options for users who are not logged in -->
			<?php else: ?>
				<a href='/'>Home</a>&nbsp;&nbsp;|&nbsp;&nbsp;
				<a href='/users/signup'>Sign up</a>&nbsp;&nbsp;|&nbsp;&nbsp;
				<a href='/users/login'>Log in</a>&nbsp;&nbsp;
			<?php endif; ?>
		</div>
    </div>
    <br>
	<div id='fp_container'>
		<div id='fp_top'>
			<h2><?php if(isset($title)) echo $title; ?></h2>
			<div id='err_msg'></div>
		</div>
		<?php if(isset($content)) echo $content; ?>
		<?php if (substr("$_SERVER[REQUEST_URI]",1,5) == 'posts') { ?>
		<div id='post_menu'>
			<ul>
				<li><b>Post Menu</b></li>
				<li><a href='/posts/add/'>Add a Post</a></li>
				<li><a href='/posts/edit/'>Edit/Delete Your Posts</a></li>
				<li><a href='/posts/'>View Followed Posts</a></li>
			</ul>
		</div>
		<?php } ?>
	</div>
	<br><br>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<?php if(isset($client_files_body)) echo $client_files_body; ?>

</body>
</html>