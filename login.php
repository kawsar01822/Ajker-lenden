<?php
	session_start();
	include('inc/dbcon.php');
	include('inc/functions.php');
	
	if(isset($_SESSION['login'])){
		lets_go('index.php');
	}
	
	if(isset($_POST['login'])){
		$user = save_me($_POST['username']);
		$pass = sha1(save_me($_POST['password']));
		if(!empty($user) && !empty($pass)){
			$sql = "SELECT * FROM users WHERE user='$user' AND pass='$pass'";
			$qr = mysqli_query($db,$sql);
			if(mysqli_num_rows($qr) == 1){
				$data = mysqli_fetch_assoc($qr);
				extract($data);
				session_regenerate_id();
					$_SESSION['login'] = 'done';
					$_SESSION['name'] = $name;
					$_SESSION['id'] = $id;
					$_SESSION['role'] = $role;
				add_success_msg("Welcome ".$_SESSION['name']);
				lets_go('index.php');
			}else{
				add_error_msg("Wrong username or password");
			}
		}else{
			add_error_msg("Please provide your username & password");
		}
	}
	
	
$tbl = "";
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
		 <h3>Login information </h3>
		  <form class='add_form' method='post' action=''>
			<table class='add'>
				<tr>
					<td>Username</td>
					<td>
					<input type='text' name='username' placeholder='Username'>
					</td>
				</tr>
				<tr>
					<td>Password</td>
					<td><input type='password' name='password' placeholder='Password'></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>
					<input type='submit' name='login' value='Login'>
					</td>
				</tr>
			</table>
		 </form>
	</div>
	<div class='conent_add'>
		<table class='add'>
			<tr>
				<td><p style="color:red">New here ? <a href="signup.php"><button>Click for Register</button></a></p></td>
			</tr>
		</table>
	</div>
  </div><!--container end-->
 
</div><!--wrapper end-->
</body>
</html>
