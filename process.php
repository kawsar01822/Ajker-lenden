<?php
	require_once('inc/dbcon.php');
	require_once('inc/functions.php');
	
	is_post();
	
	//USER SIGN UP
	
	if(isset($_POST['signup'])){
		$name = save_me($_POST['name']);
		$user = save_me($_POST['user']);
		$email = save_me($_POST['email']);
		$mobile = (int)save_me($_POST['mobile']);
		$pass = sha1(save_me($_POST['pass']));
		$role = 'user';
		
		$sql = "INSERT INTO users(name, user, email, mobile, pass) VALUES('$name', '$user', '$email', '$mobile', '$pass')";
		if(!empty($name) && !empty($user) && !empty($email) && !empty($mobile) && !empty($pass)){
			if(!is_duplicate('users','user',$user) && !is_duplicate('users','email',$email)){
				mysqli_query($db,$sql);
			}else{
				add_error_msg("Duplicate user or email");
				lets_go('signup.php');
			}
		}else{
			add_error_msg("You can't leave empty any field");
			lets_go('signup.php');
		}
		add_success_msg('Successfully account created ! you can log in with your username and password');
		lets_go('index.php');
	}
	
	//INSERT CATEGORY
	
	if(isset($_POST['add_category'])){
		$cat = ucfirst(strtolower(save_me($_POST['cat_name'])));
		$sql = "INSERT INTO categories(cat_name) VALUES('$cat')";
		if(!is_duplicate('categories','cat_name',$cat) && !empty($cat)){
			mysqli_query($db,$sql);
			add_success_msg("Successfully insert a Category");
		}else{
			add_error_msg("Duplicate or empty category field");
		}
		lets_go('category.php');
	}
	
	//INSERT PRODUCT
	
	if(isset($_POST['send_post'])){
		$title_field = strlen(save_me($_POST['title']));
		if($title_field <= 30){
			$title = $_POST['title'];
		}else{
			add_error_msg('Title should be in 30 character');
			lets_go('products.php');
		}
		$detail = save_me($_POST['detail']);
		$price = (int)save_me($_POST['price']);
		$auth_id = $_SESSION['id'];;
		$cat_id = $_POST['category'];
		$field = $_FILES['image'];
		$image	= upload_me($field, 500, array('jpg','jpeg','png'));
		$created_on = date('Y-m-d H:i');
		
		$sql = "INSERT INTO products(title, detail, price, cat_id, auth_id, images, created_on) VALUES('$title','$detail','$price','$cat_id','$auth_id','$image','$created_on')";
		if(!empty($title) && !empty($detail) && !empty($price) && !empty($image) && $cat_id != 'Select a category'){
			mysqli_query($db,$sql);
			add_success_msg("Successfully Added");
		}else{
			add_error_msg("Every field should be filled");
		}
		lets_go('products.php');
	}
	
	//DELETE_PRODUCT
	
	if(isset($_POST['delete_post'])){
		$id = (int)$_POST['delete_id'];
		$del_item = get_single_data('products','images','id',$id);
		if(file_exists($del_item)){
			unlink($del_item);
		}
		$sql = "DELETE FROM products WHERE id = '$id'";
		if(mysqli_query($db,$sql)){
			add_success_msg("Successfully delete your add");
		}else{
			add_error_msg("Unable to delete this add");
		}
		lets_go('products.php');
	}
	
	//DELETE USER
	
	if(isset($_POST['delete_user'])){
		$id = (int)$_POST['delete_id'];
		$sql = "DELETE FROM users WHERE id = '$id'";
		if(mysqli_query($db,$sql)){
			add_success_msg("Successfully delete a user");
		}else{
			add_error_msg("Unable to delete this user");
		}
		lets_go('users.php');
	}
	
	//UPDATE CATEGORY
	
	if(isset($_POST['update_category'])){
		$id = (int)$_POST['edit_id'];
		$cat = ucfirst(strtolower(save_me($_POST['cat_name'])));
		$sql = "UPDATE categories SET
				cat_name	=	'$cat'
				WHERE id='$id'";
		if(!is_duplicate('categories','cat_name',$cat) && !empty($cat)){
			mysqli_query($db,$sql);
			add_success_msg("Successfully update a Category");
		}else{
		add_error_msg("Duplicate or empty category field");
		}
		lets_go('category.php');
	}
	
	//UPDATE PRODUCT
	
	if(isset($_POST['update_post'])){
		$title_field = strlen(save_me($_POST['title']));
		if($title_field <= 30){
			$title = $_POST['title'];
		}else{
			add_error_msg('Title should be in 30 character');
			lets_go('products.php');
		}
		$id = $_POST['edit_id'];
		$detail = save_me($_POST['detail']);
		$price = (int)save_me($_POST['price']);
		$auth_id = $_SESSION['id'];;
		$cat_id = $_POST['category'];
		$old_image = $_POST['old_image'];
		$field = $_FILES['image'];
		if(!empty($field['name'])){	
			$new_image	= upload_me($field, 500, array('jpg','jpeg','png'));
		}else{
			$new_image = '';
		}
		
		if($new_image){
			if(file_exists($old_image)){
				unlink($old_image);
			}
			$image = $new_image;
			add_success_msg("successfully Changed your image");
		}else{
			$image = $old_image;
		}
		$created_on = date('Y-m-d H:i');
		
		$sql = "UPDATE products SET
				title		=	'$title', 
				detail		=	'$detail', 
				price		=	'$price', 
				cat_id		=	'$cat_id', 
				auth_id		=	'$auth_id', 
				images		=	'$image', 
				created_on	=	'$created_on'
				WHERE id='$id'";
		if(!empty($title) && !empty($detail) && !empty($price) && !empty($image) && $cat_id != 'Select a category'){
			mysqli_query($db,$sql);
			add_success_msg("Successfully updated (<a href='../details.php?id={$id}'>Go to your add</a>)");
		}else{
			add_error_msg("Every field should be filled");
		}
		lets_go('products.php');
	}
	
	//UPDATE USERS
	
	if(isset($_POST['update_user'])){
		$id = (int)$_POST['edit_id'];
		$role = save_me($_POST['role']);
		$sql = "UPDATE users SET
				role	=	'$role'
				WHERE id = '$id'";
		if(!empty($role)){
			mysqli_query($db,$sql);
			add_success_msg("Successfully updated");
		}else{
			add_error_msg("Role can not be empty");
		}
		lets_go('users.php');
	}
	
	//UPDATE PROFILE
	
	if(isset($_POST['update_profile'])){
		$id = (int)$_POST['user_id'];
		$opass = sha1(save_me($_POST['opass']));
		$npass = sha1(save_me($_POST['npass']));
		if($opass != 'da39a3ee5e6b4b0d3255bfef95601890afd80709'){
			$sql = "SELECT * FROM users WHERE id='$id'";
			$qr = mysqli_query($db,$sql);
			$data = mysqli_fetch_assoc($qr);
			extract($data);
			$old_pass = $pass;
			if($old_pass != $opass){
				$pass =  $opass;
				add_error_msg("Wrong password given");
				lets_go('profile.php');
				die();
			}else{
				$pass = $npass;
			}
		}else{
			add_error_msg("Please Give your present password");
			lets_go('profile.php');
			die();
		}
		$name = save_me($_POST['name']);
		$email = save_me($_POST['email']);
		$mobile = (int)save_me($_POST['mobile']);
		$sql = "UPDATE users SET
				name	=	'$name',
				email	=	'$email',
				mobile	=	'$mobile',
				pass	=	'$pass'
				WHERE id = '$id'";
		if(!empty($name) && !empty($email) && !empty($mobile) && $pass != 'da39a3ee5e6b4b0d3255bfef95601890afd80709'){
			mysqli_query($db,$sql);
			add_success_msg("Successfully update Your Profile");
		}else{
			add_error_msg("Every field should be filled!");
		}
		lets_go('profile.php');
	}

?>