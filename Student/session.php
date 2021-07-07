<?php 

	session_start();

	//If user is not logged in and tries to access the Portal
	if( !$_SESSION['loggedInUser']){
		$_SESSION['login_err'] = true;
		header("Location: ../index.php");
	}

	//If logged in as some other than student and trying to access the Student portal
	if (isset($_SESSION['loggedInUser'])){

		if ($_SESSION['acnt_type'] != 2){

			header("Location: ../index.php"); //Redirect to Index Page
		}

	} 

 ?>