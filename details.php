<?php 
	require('inc/header.php');
	
	if(isset($_GET['id'])){
		$details_id = (int)$_GET['id'];
	}else{
		lets_go('index.php');
	}
	
	$sql = "SELECT p.*,c.cat_name, u.name,u.email,u.mobile
			FROM products p
			Left JOIN categories c
			ON p.cat_id = c.id
			LEFT JOIN users u
			ON p.auth_id = u.id
			WHERE p.id = '$details_id'";
	$qr = mysqli_query($db,$sql);
	if(mysqli_num_rows($qr)){
		while($data = mysqli_fetch_assoc($qr)){
			extract($data);
			$lst = "<div class='product_title'>
						<h1>{$title}</h1>
						<span class='sub_title'>Author: <a href='#'>{$name}</a>, category: <a href='#'>{$cat_name}</a>, Date: <a href='#'>{$created_on}</a></span>
					</div>
					<div class='product_image'>
						<img src='"."admin/$images'"."height='400px' width='600px'>
					</div>
					<div class='contact_price'>
						<h1>Contact</h1>
							<p>Mobile: {$mobile}<br>Email: {$email}</p>
						<h2>Price: {$price}</h2>
					</div>
					<div class='description'>
						<p>{$detail}</p>
					</div>";	
		}
	}else{
		$lst = "<div class='product_title'>
				<h1>No data found</h1>
				</div>";
	}
	
?>
		
		<!--    Content start   -->
		<div class="content_details clearfix">
			<div class="content_div clearfix">
				<div class="product_details">
					<?php echo $lst; ?>
				</div>
			</div>			
		</div>
		<!--     Content End     -->
		
		<!--      Footer  start     -->
<?php require('inc/footer.php'); ?>