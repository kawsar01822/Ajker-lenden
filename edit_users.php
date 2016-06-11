<?php 
	include('inc/header.php');
	
	is_post('index.php');
	
	$user_id = (int)$_POST['edit_id'];
	$sql = "SELECT * FROM users where id = '$user_id'";
	$qr = mysqli_query($db,$sql);
	
	while($data = mysqli_fetch_assoc($qr)){
		extract($data);
	}
	
?>
	<div class="container">
	<div class="conent_add">
   	  <h3>Add or Update Content</h3>
      <form class="add_form" name="form1" method="post" action="process.php">
		<input type = "hidden" name="edit_id" value="<?php echo $user_id; ?>">
        <table class="add">
				<tr>
                    <td>Name</td>
                    <td>
                    <?php echo $name; ?>
                    </td>
                </tr>
				<tr>
                    <td>Role</td>
                    <td>
						<label><input type="radio" <?php echo $role == 'admin' ? 'checked' : ''; ?> name="role" value='admin'> Admin</label>
						<label><input type="radio" <?php echo $role == 'user' ? 'checked' : ''; ?> name="role" value='user'> User</label>
					</td>
                </tr>
                <tr>
                	<td>&nbsp;</td>
                    <td>
                    <input type="submit" name="update_user" value="Update">
                    </td>
                </tr>
            </table>
      </form>
    </div><!--content add end-->
    
  </div><!--container end-->
<?php include('inc/footer.php'); ?>