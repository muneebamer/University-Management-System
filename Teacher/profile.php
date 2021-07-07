	
<?php 
	include_once('../Database/database.php');
	include('navside.php'); 
	include('functions.php');
?>

<!DOCTYPE html>
<html>
<head>
	<title>Teacher Profile</title>
</head>

<body>
	
	<div style="margin-left: 20%; margin-top: 4%;"> <!-- main div -->
		<div class="row">

			<div class="col-xs-8 col-md-12">
				<?php 
				if(isset($_SESSION['pasw_changed'])){
					echo '<div class="alert alert-success alert-dismissible fade in updated">
    						<a href="#" class="close" data-dismiss="alert" aria-label="close" style="padding-top:15px;">&times;</a>
    						<strong>Success!</strong> Your Password has been updated.
  						</div>';
				}

				?>

				<div class='profile_box col-xs-12 col-md-12'>
					<div class ='image'><img src="../Images/mohid.jpeg" width="210px" height="250px;"></div>
					<div class='profile_txt' style="margin-top: 25px;">ID: <?php echo $_SESSION['T_ID'] ?></div>
					<hr>
					<div class='profile_txt'>Name: <?php echo $_SESSION['Name'] ?></div>
					<hr>
					<div class='profile_txt'>Number: <?php echo $_SESSION['Contact'] ?></div>
					<hr>
					<div class='profile_txt'>Email: <?php echo $_SESSION['Email'] ?></div>
					<hr>
					<div class='profile_txt'>Department: <?php echo $_SESSION['Dept'] ?></div>
					<hr>
					<div class='profile_txt'>Salary: <?php echo $_SESSION['Salary'] ?></div>
					<hr>
					<div class='profile_txt' style="margin-bottom: 25px;">Address: <?php echo $_SESSION['Address'] ?></div>

				</div>



			</div>

		</div>



	</div> <!-- Main Div> -->
</body>




</html>