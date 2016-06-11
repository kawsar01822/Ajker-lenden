<?php 
	include('inc/header.php'); 
	
	if($_SESSION['role'] != 'superadmin' && $_SESSION['role'] != 'admin' ){
		lets_go('index.php');
	}
	
	$sql = "SELECT * FROM categories";
	$qr = mysqli_query($db,$sql);
	
	$tbl = "<tr>
				<th width='6%' scope='col'>SN</th>
				<th width='72%' scope='col'>Title</th>
				<th width='22%' scope='col' colspan='2'>Action</th>
			</tr>";
	$i = 0;
	if(mysqli_num_rows($qr)){
	while($data = mysqli_fetch_assoc($qr)){
		extract($data);
		$tbl .= "<tr>";
		$tbl .= "<td>".++$i."</td>";
		$tbl .= "<td>{$cat_name}</td>";
		$tbl .= "<td>
					<form action = 'category.php' method='post'>
						<input type='hidden' name='edit_id' value='{$id}'>
						<input type='submit' name='edit_item' value='Edit'>
					</form>
				</td>
				<td>
					<form action = 'process.php' method='post'>
						<input type='hidden' name='delete_id' value='{$id}'>
						<input type='submit' name='delete_item' value='Delete'>
					</form>
				</td>";
		$tbl .= "</tr>";
	}
	}else{
		$tbl .= "<tr><td colspan='4'>No category found</td></tr>";
	}

	if(isset($_POST['edit_item'])){
		$id = $_POST['edit_id'];
		$sql = "SELECT * FROM categories WHERE id='$id'";
		$qr = mysqli_query($db,$sql);
		
		while($data = mysqli_fetch_assoc($qr)){
			extract($data);
		}
	}
?>

    <div class="container">
    
    <div class="content_view">
    <h3>Category List</h3>
    <table class="view" width="100%" cellspacing="0">
	<?php echo $tbl; ?>
</table>

    </div><!--content view end-->
    <div class="conent_add">
		<?php 
			if(isset($_POST['edit_item'])){
				echo "<h3>Update Category</h3>";
			}else{
				echo "<h3>Add Category</h3>";
			}
		?>
      <form class="add_form" method="post" action="process.php">
		<input type="hidden" name="edit_id" value="<?php echo $id; ?>">
        <table class="add">
                <tr>
                    <td>Category</td>
                    <td>
						<input type="text" name="cat_name" value= "<?php if(isset($_POST['edit_item'])){ echo $cat_name; } ?>" placeholder = "Category name">
                    </td>
                </tr>
                <tr>
                	<td>&nbsp;</td>
                    <td>
					<?php 
						if(empty($_POST['edit_id'])){
							echo "<input type='submit' name='add_category' value='Add Category'>";
						}else{
							echo "<input type='submit' name='update_category' value='Update'>";
						}
					?>
                    </td>
                </tr>
            </table>
      </form>
    </div><!--content add end-->
    
  </div><!--container end-->
<?php include('inc/footer.php'); ?>
