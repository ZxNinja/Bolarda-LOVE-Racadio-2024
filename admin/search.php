<?php include("../inc/connect.inc.php"); ?>
<?php 
ob_start();
session_start();
if (!isset($_SESSION['admin_login'])) {
	header("location: login.php");
	$user = "";
}
else {
	$user = $_SESSION['admin_login'];
	$result = mysqli_query($con, "SELECT * FROM admin WHERE id='$user'");
	$get_user_email = mysqli_fetch_assoc($result);
	$uname_db = $get_user_email['firstName'];
	$utype_type = $get_user_email['type'];
}

if (isset($_REQUEST['keywords'])) {
	$epid = mysqli_real_escape_string($con, $_REQUEST['keywords']);
	if($epid != "" && ctype_alnum($epid)){
		// Valid keywords
	} else {
		header('location: index.php');
	}
} else {
	header('location: index.php');
}

$search_value = "";
if (isset($_GET['keywords'])) {
	$search_value = trim($_GET['keywords']);
}
?>

<!doctype html>
<html>
<head>
	<title>Welcome to Code Mart online shop</title>
	<link rel="stylesheet" type="text/css" href="../css/style.css">
</head>
<body class="home-welcome-text" style="background-image: url(../image/homebackgrndimg2.png);">
	<div class="homepageheader">
		<div class="signinButton loginButton">
			<div class="uiloginbutton signinButton loginButton" style="margin-right: 40px;">
				<?php 
				if ($user!="") {
					echo '<a style="text-decoration: none;color: #fff;" href="logout.php">LOG OUT</a>';
				}
				?>
			</div>
			<div class="uiloginbutton signinButton loginButton">
				<?php 
				if ($user!="") {
					echo '<a style="text-decoration: none;color: #fff;" href="login.php">Hi '.$uname_db.'</a>';
				} else {
					echo '<a style="text-decoration: none;color: #fff;" href="login.php">LOG IN</a>';
				}
				?>
			</div>
		</div>
		<div style="float: left; margin: 5px 0px 0px 23px;">
			<a href="index.php">
				<img style="height: 75px; width: 130px;" src="../image/cart.png">
			</a>
		</div>
		<div class="">
			<div id="srcheader">
				<form id="newsearch" method="get" action="search.php">
					<?php 
					echo '<input type="text" class="srctextinput" name="keywords" size="21" maxlength="120" placeholder="Search Here..." value="'.$search_value.'"><input type="submit" value="search" class="srcbutton" >';
					?>
				</form>
				<div class="srcclear"></div>
			</div>
		</div>
	</div>
	<div class="categolis">
		<table>
			<tr>
				<th><a href="index.php" style="text-decoration: none;color: #fff;padding: 4px 12px;background-color: #c7587e;border-radius: 12px;">Home</a></th>
				<th><a href="addproduct.php" style="text-decoration: none;color: #ddd;padding: 4px 12px;background-color: #c7587e;border-radius: 12px;">Add Product</a></th>
				<th><a href="newadmin.php" style="text-decoration: none;color: #ddd;padding: 4px 12px;background-color: #c7587e;border-radius: 12px;">New Admin</a></th>
				<th><a href="orders.php" style="text-decoration: none;color: #ddd;padding: 4px 12px;background-color: #c7587e;border-radius: 12px;">Orders</a></th>
				<th><a href="DeliveryRecords.php" style="text-decoration: none;color: #ddd;padding: 4px 12px;background-color: #c7587e;border-radius: 12px;">DeliveryRecords</a></th>
				<th><a href="report.php" style="text-decoration: none;color: #ddd;padding: 4px 12px;background-color: #c7587e;border-radius: 12px;">Reports</a></th>
			</tr>
		</table>
	</div>
	<div>
		<table class="rightsidemenu">
			<tr style="font-weight: bold;" colspan="10" bgcolor="#4DB849">
				<th>Id</th>
				<th>P Name</th>
				<th>Description</th>
				<th>Price</th>
				<th>Available</th>
				
				
				
				<th>P Code</th>
				<th>Edit</th>
			</tr>
			<?php
			$search_value = trim($_GET['keywords']);
			$query = "SELECT * FROM products WHERE pName like '%$search_value%' ORDER BY id DESC";
			$run = mysqli_query($con, $query);
			if ($total = mysqli_num_rows($run)) {
				while ($row = mysqli_fetch_assoc($run)) {
					$id = $row['id'];
					$pName = substr($row['pName'], 0, 50);
					$descri = $row['description'];
					$price = $row['price'];
					$piece = $row['piece'];
					$available = $row['available'];
					
					
					$item = $row['item'];
					$pCode = $row['pCode'];
					$picture = $row['picture'];
					?>
					<tr>
						<th><?php echo $id; ?></th>
						<th><?php echo $pName; ?></th>
						<th><?php echo $descri; ?></th>
						<th><?php echo $price; ?></th>
						<th><?php echo $available; ?></th>
					
						<th><?php echo $pCode; ?></th>
						<th>
							<div class="home-prodlist-img">
								<a href="editproduct.php?epid=<?php echo $id; ?>">
									<img src="../image/product/<?php echo $item; ?>/<?php echo $picture; ?>" class="home-prodlist-imgi" style="height: 75px; width: 75px;">
								</a>
							</div>
						</th>
					</tr>
				<?php }
			} else {
				echo "<tr><td colspan='10'>No results found</td></tr>";
			}
			?>
		</table>
	</div>
</body>
</html>
