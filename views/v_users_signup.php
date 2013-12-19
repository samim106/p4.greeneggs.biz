<div id='fp1'>
	<?php 
		switch($msg) {
			case 501:
				echo "ERROR:<br>
					Sorry, that email is already in use. Please use another email address.";
				break;
			case 502:
				echo "ERROR:<br>
					Please fill out all of the fields.";
				break;
			default:
				echo "Please input your user information to the right to sign up for an account.
					We're glad you're signing up!";
				break;
			}
	?>
</div>
<div id='fp2'>
	<form method='POST' action='/users/p_signup'>
		<table>
			<tr><td>First name</td><td><input type='text' name='first_name'></td></tr>
			<tr><td>Last name</td><td><input type='text' name='last_name'></td></tr>
			<tr><td>Email</td><td><input type='text' name='email'></td></tr>
			<tr><td>Password</td><td><input type='password' name='password'></td></tr>
			<tr><td>&nbsp;</td><td><input type='submit' value='sign up'></td></tr>
		</table>
	</form>
</div>

