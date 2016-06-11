<?php 
	include('inc/header.php');
	
	$sql = "SELECT * FROM categories";
	$qr = mysqli_query($db,$sql);
	
	$opt = "";
	while($data = mysqli_fetch_assoc($qr)){
		extract($data);
		$opt .= "<option value='$id'>{$cat_name}</option>";
	}
	
	if($_SESSION['role'] == 'superadmin'){
		$sql = "SELECT * FROM products";
	}else{
		$user_id = $_SESSION['id'];
		$sql = "SELECT * FROM products WHERE auth_id='$user_id'";
	}
	$qr = mysqli_query($db,$sql);
	
	$tbl = "<tr>
				<th width='6%' scope='col'>SN</th>
				<th width='50%' scope='col'>Title</th>
				<th width='22%' scope='col'>Price</th>
				<th width='22%' scope='col' colspan='2'>Action</th>
			</tr>";
	$i = 0;
	if(mysqli_num_rows($qr)){
	while($data = mysqli_fetch_assoc($qr)){
		extract($data);
		$tbl .= "<tr>";
		$tbl .= "<td>".++$i."</td>";
		$tbl .= "<td>{$title}</td>";
		$tbl .= "<td>{$price}</td>";
		$tbl .= "<td>
					<form action = 'edit_products.php' method='post'>
						<input type='hidden' name='edit_id' value='{$id}'>
						<input type='submit' name='edit_post' value='Edit'>
					</form>
				</td>
				<td>
					<form action = 'process.php' method='post'>
						<input type='hidden' name='delete_id' value='{$id}'>
						<input type='submit' name='delete_post' value='Delete'>
					</form>
				</td>";
		$tbl .= "</tr>";
	}
	}else{
		$tbl .= "<tr><td colspan='4'>No products found</td></tr>";
	}
?>

    <div class="container">
	
	<div class="content_view">
		<h3>Posts List</h3>
		<table class="view" width="100%" cellspacing="0">
		<?php echo $tbl; ?>
	</table>

    </div><!--content view end-->
    <div class="conent_add">
   	  <h3>Add Content</h3>
      <form class="add_form" method="post" action="process.php" enctype="multipart/form-data">
        <table class="add">
				<tr>
					<td>Category</td>
					<td>
						<select name = "category">
							<option>Select a category</option>
							<?php echo $opt; ?>
						</select>
					</td>
				</tr>
				<tr>
                    <td>Title</td>
                    <td><input type="text" name="title" placeholder="Title of your product"></td>
                </tr>
                <tr>
                    <td>Description</td>
                    <td><textarea rows="10" cols="40" name="detail" placeholder="Description of your Product"></textarea></td>
                </tr>
				<tr>
                    <td>Price</td>
					<td><input type="number" name="price" placeholder="price"></td>
                </tr>
				<tr>
					<td>Upload a photo</td>
					<td><input type="file" name="image"></td>
				</tr>
                <tr>
                	<td>&nbsp;</td>
                    <td>
                    <input type="submit" name="send_post" value="Post your add">
                    </td>
                </tr>
            </table>
      </form>
    </div><!--content add end-->
    
  </div><!--container end-->
<?php include('inc/footer.php'); ?>
