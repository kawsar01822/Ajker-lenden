<?php
	require_once('./admin/inc/dbcon.php');
	require_once('./admin/inc/functions.php');
	
	$sql = " SELECT * FROM categories";
	$qr = mysqli_query($db,$sql);
	$cat = "";
	if(mysqli_num_rows($qr)){
		while($data = mysqli_fetch_assoc($qr)){
			extract($data);
			$cat .= "<li><a href='category_details.php?id={$id}'>{$cat_name}</a></li>";
		}
	}
	
?>
<!doctype html>
<html>
	<head>
		<title>Ajker lenden : The largest ecommerce site of Bangladesh!</title>
		<link rel="stylesheet" href="css/style.css">
	<!--  Navigation  -->
		<link rel="stylesheet" href="css/navstyles.css">
	<!--  Nivo Slider  -->
		<link rel="stylesheet" href="nivo/nivo-slider.css">
		<link rel="stylesheet" href="nivo/light/light.css">
	</head>
	<body>
		<!-- Navigation Start-->
		<div id='cssmenu'>
			<ul>
			   <li><a href='index.php'>Home</a></li>
			   <li class='active'><a href='#'>Products</a>
				  <ul>
					 <?php echo $cat; ?>
				  </ul>
			   </li>
			   <li><a href='help.php'>Help</a></li>
			</ul>
		</div>