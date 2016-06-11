<?php 
	include('inc/header.php');
		
	if($_SESSION['role'] != 'superadmin'){
		lets_go('index.php');
	}
	
	$sql = "SELECT * FROM users";
	$qr = mysqli_query($db,$sql);
	
	$tbl = "<tr>
				<th width='6%' scope='col'>SN</th>
				<th width='34%' scope='col'>Name</th>
				<th width='20%' scope='col'>Username</th>
				<th width='20%' scope='col'>Role</th>
				<th width='20%' scope='col' colspan='2'>Action</th>
			</tr>";
	$i = 0;
	if(mysqli_num_rows($qr)){
		while($data = mysqli_fetch_assoc($qr)){
			extract($data);
			if($role != 'superadmin'){	
				$tbl .= "<tr>";
				$tbl .= "<td>".++$i."</td>";
				$tbl .= "<td>{$name}</td>";
				$tbl .= "<td>{$user}</td>";
				$tbl .= "<td>{$role}</td>";
				$tbl .= "<td>
							<form action = 'edit_users.php' method='post'>
								<input type='hidden' name='edit_id' value='{$id}'>
								<input type='submit' name='edit_user' value='Edit'>
							</form>
						</td>
						<td>
							<form action = 'process.php' method='post'>
								<input type='hidden' name='delete_id' value='{$id}'>
								<input type='submit' name='delete_user' value='Delete'>
							</form>
						</td>";
				$tbl .= "</tr>";
			}
		}
	}else{
		$tbl .= "<tr><td colspan='5'>No user found</td></tr>";
	}

?>

    <div class="container">
	<div class="content_view">
		<h3>Users List</h3>
		<table class="view" width="100%" cellspacing="0">
		<?php echo $tbl; ?>
	</table>
    </div><!--content view end-->
    
  </div><!--container end-->
<?php include('inc/footer.php'); ?>
