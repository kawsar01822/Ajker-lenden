<?php
	include('inc/header.php'); 
	include('inc/dbcon.php');
	$id = $_SESSION['id'];
	$sql = "SELECT * FROM users WHERE id = '$id'";
	$qr = mysqli_query($db,$sql);
	$data = mysqli_fetch_assoc($qr);
	extract($data);

?>
	<div class="conent_add">
   	  <h3>Add or Update Content</h3>
      <form class="add_form" method="post" action="process.php">
	  <input type="hidden" name="user_id" value="<?php echo $id; ?>">
        <table class="add">
                <tr>
                    <td>Fullname</td>
                    <td>
                    <input type="text" name="name" value="<?php echo $name; ?>">
                    </td>
                </tr>
				<tr>
                    <td>Username</td>
                    <td><?php echo $user; ?></td>
                </tr>
                <tr>
				<tr>
                    <td>Email</td>
                    <td>
                    <input type="text" name="email" value="<?php echo $email; ?>">
                    </td>
                </tr>
				<tr>
                    <td>Mobile</td>
                    <td>
                    <input type="text" name="mobile" value="<?php echo $mobile; ?>">
                    </td>
                </tr>
                    <td>Old Password</td>
                    <td><input type="password" name="opass" value="" required></td>
                </tr>
				<tr>
                    <td>New Password</td>
                    <td><input type="password" name="npass" value="" required></td>
                </tr>
                <tr>
                	<td>&nbsp;</td>
                    <td>
                    <input type="submit" name="update_profile" value="Update">
                    </td>
                </tr>
            </table>
      </form>
    </div><!--content add end-->
	<?php include('inc/footer.php'); ?>