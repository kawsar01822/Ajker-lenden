<?php 
	include('inc/header.php');
	
	is_post('index.php');
	
	if(isset($_POST['edit_post'])){
		$id = $_POST['edit_id'];
		$sql="SELECT * FROM products WHERE id = '$id'";
		$qr = mysqli_query($db,$sql);
		if($data = mysqli_fetch_assoc($qr)){
			extract($data);
		}
	}
	
	$sql = "SELECT * FROM categories";
	$qr = mysqli_query($db,$sql);
	$opt = "";
	while($data = mysqli_fetch_assoc($qr)){
		extract($data,EXTR_PREFIX_ALL,"category");
		$opt .= "<option ";
		$opt .= ($cat_id == $category_id) ? 'selected' : '';
		$opt .= " value = '{$category_id}'>{$category_cat_name}</option>";
	}
	
	
?>
	<div class="container">
	<div class="conent_add">
   	  <h3>Update Content</h3>
		<form class="add_form" method="post" action="process.php" enctype="multipart/form-data">
			<input type="hidden" name="edit_id" value="<?php echo $id; ?>">
			<input type="hidden" name="old_image" value="<?php echo $images; ?>">
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
                    <td><input type="text" name="title" placeholder="Title of your product" value="<?php echo $title; ?>"></td>
                </tr>
                <tr>
                    <td>Description</td>
                    <td><textarea rows="10" cols="40" name="detail" placeholder="Description of your Product"><?php echo $detail; ?></textarea></td>
                </tr>
				<tr>
                    <td>Price</td>
					<td><input type="number" name="price" placeholder="price" value="<?php echo $price; ?>"></td>
                </tr>
				<tr>
					<td>Upload a photo</td>
					<td><input type="file" name="image"></td>
				</tr>
                <tr>
                	<td>&nbsp;</td>
                    <td>
                    <input type="submit" name="update_post" value="Update your add">
                    </td>
                </tr>
            </table>
		</form>
    </div><!--content add end-->
	
	</div><!--container end-->
	
<?php require_once('inc/footer.php'); ?>