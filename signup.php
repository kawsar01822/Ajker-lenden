<?php
	session_start();
	include('inc/functions.php');

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Admin Panel</title>
<link rel="stylesheet" href="css/style.css" type="text/css">
</head>

<body>
<div class="wrapper">
	<h2 class="title">Welcome to admin panel</h2>
    <div class="container">
	<?php echo read_msg(); ?>
	<div class='conent_add'>
		<h3>Your information</h3>
			<form class='add_form' method='post' action='process.php'>
				<table class='add'>
					<tr>
						<td>Name</td>
						<td>
						<input type='text' name='name' placeholder='Your name' required>
						</td>
					</tr>
					<tr>
						<td>Username</td>
						<td>
						<input type='text' name='user' placeholder='Username' required>
						</td>
					</tr>
					<tr>
						<td>Email</td>
						<td>
						<input type='email' name='email' placeholder='Email' required>
						</td>
					</tr>
					<tr>
						<td>Mobile no.</td>
						<td>
						<input type='number' name='mobile' placeholder='Mobile no.'>
						</td>
					</tr>
					<tr>
						<td>Password</td>
						<td><input type='password' name='pass' placeholder='Password'></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>
						<input type='submit' name='signup' value='Sign up'>
						</td>
					</tr>
				</table>
			</form>
		</div>
	
  </div><!--container end-->
</div><!--wrapper end-->
</body>
</html>