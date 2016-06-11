<?php 
	require('inc/header.php'); 
	require('inc/slider.php');
	
	$cat_name = "";
	
	if(isset($_GET['id'])){
		$cat_detail_id = (int)$_GET['id'];
	}else{
		lets_go('index.php');
	}
	
	$sql = "SELECT p.*,c.cat_name
			FROM products AS p
			LEFT JOIN categories AS c
			ON p.cat_id = c.id
			WHERE p.cat_id='$cat_detail_id'
			ORDER BY p.created_on DESC";
	$qr = mysqli_query($db,$sql);
	$lst ="";
	if(mysqli_num_rows($qr)){
		while($data = mysqli_fetch_assoc($qr)){
			extract($data);
			$lst .= 	"<div class='content'>
						<div class='put_content'><img src='"."admin/$images'"."height='300px' width='302px'></div>
						<div class='put_content' style='overflow:scroll';><a href='details.php?id={$id}'><h2>{$title}</h2></a><p>{$detail}</p></div>
						<p id='price'>Price: {$price} tk</p>
						<a href='details.php?id={$id}'><button class='detail'>Details</button></a>
					</div>";
		}
	}else{
		$lst .= "<div class='content'><h2 style='color:red'>No data found</h2></div>";
	}
?>

	<div class="cat_title">
		<h1>Post on : <?php echo is_empty($cat_name, 'Unknown') ?></h1>
	</div>	
	</div>
	<!--    Header End    -->
	<!--    Content start   -->
	<div class="content_area clearfix">
		<div class="content_div clearfix">
			<?php echo $lst; ?>
		</div>			
	</div>
	<!--     Content End     -->
	<!--      Footer  start     -->
<?php require('inc/footer.php'); ?>

