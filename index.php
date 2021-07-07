<!DOCTYPE html>
<html>
<?php include_once('Database/database.php'); 

?> 
<?php session_start();
// If user already logged in
if (isset($_SESSION['loggedInUser'])){
	if ($_SESSION['acnt_type'] == 1){

		header("Location: Admin/admin.php"); //Redirect to Admin Page
	}
	if ($_SESSION['acnt_type'] == 2){

		header("Location: Student/student.php"); //Redirect to Student Page
	}
	if ($_SESSION['acnt_type'] == 3){

		header("Location: Teacher/teacher.php"); //Redirect to Teacher Page
	}
} 

?>

<head>
	<title>INDEX</title>
	
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

	<!-- Latest compiled JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>


	<!-- Login Stylesheet -->
	<link rel="stylesheet" href="styling files/login.css">

	<?php 	

	if (isset($_POST['login'])){  // Execute code when form submitted

		//Apply php filters and store form data.
		$username = apply_filters($_POST["username"]);
		$pasw = apply_filters($_POST["pasw"]);

		$query = "SELECT * FROM login WHERE UserID = '$username' and Pasw = '$pasw'";

		$result = mysqli_query($conn , $query);
		//If any result returned
		if (mysqli_num_rows($result) > 0){
			
			while ($row = mysqli_fetch_assoc($result)){

				//Store details in Session Variables
				$loggedInUser = $row["UserID"];
				$acnt_type = $row["account_type"];
				$Is_Block = $row["Is_Block"];

			}


			$_SESSION['loggedInUser'] = $loggedInUser;
			$_SESSION['acnt_type'] =  $acnt_type;
			$_SESSION['Is_Block'] = $Is_Block;

			if($_SESSION['Is_Block'] == 'YES'){

					$block_err = "<div class = 'alert alert-danger'>This Username has been Blocked by Admin</div> "; 
				}

			else{
			
				if($_SESSION['acnt_type'] == 1){
					$query = "SELECT * FROM Admin WHERE A_ID = '$loggedInUser'";
					$result = mysqli_query($conn , $query);
					if (mysqli_num_rows($result) > 0){
			
						while ($row = mysqli_fetch_assoc($result)){
							//Store details in Session Variables
							$_SESSION['A_ID'] = $row['A_ID'];
							$_SESSION['Name'] = $row['Name'];
							$_SESSION['Contact'] =  $row['Contact'];
							$_SESSION['Email'] = $row['Email'];
							$_SESSION['Address'] = $row['Address'];
						}
						header("Location: Admin/admin.php"); //Redirect to Admin Page
					}
				}

				if($_SESSION['acnt_type'] == 2){
					$query = "SELECT * FROM Student WHERE S_ID = '$loggedInUser'";
					$result = mysqli_query($conn , $query);
					if (mysqli_num_rows($result) > 0){
			
						while ($row = mysqli_fetch_assoc($result)){
							//Store details in Session Variables
							$_SESSION['Name'] = $row['Name'];
							$_SESSION['S_ID'] = $row['S_ID'];
							$_SESSION['Contact'] =  $row['Contact'];
							$_SESSION['Email'] = $row['Email'];
							$_SESSION['Address'] = $row['Address'];
							$_SESSION['Major'] = $row['Major'];
							$_SESSION['Gender'] = $row['Gender'];
							$_SESSION['Semester'] = $row['Semester'];
							$_SESSION['Grad_year'] = $row['Grad_year'];
						}
					header("Location: Student/student.php"); //Redirect to Student Page
					}
				}

				if($_SESSION['acnt_type'] == 3){
					$query = "SELECT * FROM Teacher WHERE T_ID = '$loggedInUser'";
					$result = mysqli_query($conn , $query);
					if (mysqli_num_rows($result) > 0){
			
						while ($row = mysqli_fetch_assoc($result)){
							//Store details in Session Variables
							$_SESSION['T_ID'] = $row['T_ID'];
							$_SESSION['Name'] = $row['Name'];
							$_SESSION['Contact'] =  $row['Contact'];
							$_SESSION['Email'] = $row['Email'];
							$_SESSION['Address'] = $row['Address'];
							$_SESSION['Dept'] = $row['Dept'];
							$_SESSION['Gender'] = $row['Gender'];
							$_SESSION['Salary'] = $row['Salary'];
						}
					header("Location: Teacher/teacher.php"); //Redirect to Teacher Page
					}
				}			
		
			}

		}
		else{ //Error
				$login_err = "<div class = 'alert alert-danger'>Wrong Username / Password Combination. Try Again.</div> ";
			}
	}


	//PHP FILTERS
	function apply_filters($inp){

		$inp = trim($inp); // Strip unnecessary charcaters
		$inp = stripslashes($inp); // Remove Backslashes
		$inp = htmlspecialchars($inp); // Convert Special characters to html entities
		return $inp; 

		}
	?>

</head>
<body>
	
	<div class="container-fluid bg">

		<div class="row">
			<div id='main' class="col-12 col-sm-6 col-md-3">
				<div id='img_holder'>
					<img src="Images/account.png" width="150px" height="150px">
				</div>
				<h3 class='main-txt'>MMM UNIVERSITY</h3>
				<form method="post" action= <?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ; ?>>
				<div id='sec_2'>
				<br><br><input type="text" class="form-control" id="username" placeholder="User ID" name="username" required><br>
				<input type="password" class="form-control" id="pasw" placeholder="Password" name="pasw" required><br>
				<button type="submit" class="btn btn-primary btn-block" name="login">LOGIN</button>
				<span id='error'><?php 

					if(isset($login_err)) { echo $login_err ;} 
					if(isset($block_err)) {echo $block_err ;}
					if (isset($_SESSION['login_err'])) {echo "<div class = 'alert alert-danger'>You need to Login First.</div> ";}
					if (isset($_SESSION['session_err'])) {echo "<div class = 'alert alert-danger'>Please logout of other accounts first.</div> ";}


				?></span></div>

				</form>

			</div>
		</div>
		
	</div>









	<!--  DATABASE TESTING -->
	<?php

	//INSERTING DATA IN ADMIN
  	/*insert(array('A-400','pasw123','Muneeb','9982739128','admin@neeb.com','B-26 Bahria Town'),'Admin');
	insert(array('A-101','pasw321','Maham','2181625334','admin@maham.com','A-42 Iqbal Town'),'Admin');
	insert(array('A-202','pasw412','Mohid','1881525334','admin@mohid.com','C-4 Askari'),'Admin');*/

	//READING ALL DATA FROM ADMIN 
	/*
	$toPrint = read(array('*'),'Admin','','');
		while ($row = mysqli_fetch_row($toPrint)){
			echo "<br>";
			foreach ($row as $value){
				echo "$value ";
			}
		}
	*/

	//READING DATA OF RECORD IN ADMIN WHERE A_ID = 'A-400'
	/*
	$toPrint = read(array('*'),'Admin','A_ID','A-400');
	while ($row = mysqli_fetch_row($toPrint)){
			echo "<br>";
			foreach ($row as $value){
				echo "$value ";
			}
		}
	*/
	
	//DELETING DATA FROM ADMIN
	//delete('Admin','A_ID','A-400');


	//UPDATE DATA IN ADMIN
 	//update('Admin','Name','Mohid','Name','Taha');
 
	
	?>



</body>
</html>