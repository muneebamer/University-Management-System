<?php 
	include_once('../Database/database.php');
	include('navside.php'); 
	include('functions.php');
?>

<!DOCTYPE html>
<html>
<head>
	<title>Student Profile</title>
</head>
<?php
if(isset($_POST['pasw_btn'])) {
	$new_pasw = $_POST['change_pasw'];
	if(change_pasw($new_pasw)){
		$_SESSION['pasw_changed'] = true;
		header("Location: profile.php");
	}

}


?>

<body>
	
	<div style="margin-left: 34%; margin-top: 4%;"> <!-- main div -->
		<div class="row">

			<div class="col-xs-8 col-md-12">

			
					<!-- Search form -->
				<div class="change_pasw_bar">
					<form  class='form-inline' method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
  						<input class="form-control" type="text" placeholder="Enter Your New Password" required name='change_pasw'>
  						<button id='btn' class="btn btn-primary" name="pasw_btn">Change Password</button>
  					</form>
				</div>



			</div>

		</div>



	</div> <!-- Main Div> -->
</body>




</html>