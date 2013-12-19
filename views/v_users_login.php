<div id='fp1'>
	<?php 
		switch($msg) {
			case 510:
				echo "ERROR:<br>Sorry, your login information was incorrect.";
				break;
			default:
				echo "Please input your user information to the right to log in.";
				break;
			}
	?>
</div>
<div id='fp2'>
	<form method='POST' action='/users/p_login'>
		<table>
			<tr><td>Email</td><td><input type='text' name='email'></td></tr>
			<tr><td>Password</td><td><input type='password' name='password'></td></tr>
			<tr><td>&nbsp;</td><td><input type='submit' value='login' /></td></tr>
		</table>
	</form>
</div>