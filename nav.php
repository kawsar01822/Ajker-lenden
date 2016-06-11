<div class="wrapper">
	<h2 class="title">Welcome to admin panel</h2>
    <div class="nav">
    <ul>
    <li><a href="index.php">Home</a></li>
	<?php
		if(is_admin() || is_superadmin()){
			echo "<li><a href='category.php'>Category</a></li>";
		}
	?>
    <li><a href="products.php">Products</a></li>
    <?php
		if(is_superadmin()){
			echo "<li><a href='users.php'>Users</a></li>";
		}
	?>
	<li><a href="logout.php">Logout</a></li>
	<li style="float:right"><a href="profile.php"><strong><?php echo $_SESSION['name']; ?></strong></a></li>
	<li></li>
    </ul>
    </div><!--/*nav end*/-->