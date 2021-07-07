
<!-- Navbar and Sidebar -->

<!DOCTYPE html>

<html>
<head>

	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

	<!-- Latest compiled JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

	<!-- FONT AWESOME -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

	<!-- Admin Stylesheet -->
	<link rel="stylesheet" href="../styling files/admin.css"> 
	
</head>

<body>

	<?php 
	//**************************************** LOGOUT *************************************
		if (isset($_GET['logout'])){

			// Check if Browser sent a cookie for Session
			if(isset($_COOKIE[session_name()])){

				//Expire Cookie
				setcookie(session_name(),'',time() - 86400, '/');
			}

			//Clear All Session Variables
			session_unset();
			//Destroy the session
			session_destroy();
			//Back to index.php
			header("Location: ../index.php");
	
		}
	?>

	<!-------------------------- NAVBAR ------------------------------->
	<div class="row">
	<nav class="navbar navbar-inverse bg-inverse">
  		<div class="container-fluid">
    		<div class="navbar-header" style="padding-left: 30px;">
    			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        			<span class="icon-bar"></span>
        			<span class="icon-bar"></span>
        			<span class="icon-bar"></span>                        
      			</button>
      			<a class="navbar-brand" href="admin.php">MMM UNIVERSITY</a>
    		</div>
    	<div class="collapse navbar-collapse" id="myNavbar" style="padding-left: 65px;">
    	<ul class="nav navbar-nav navbar-right">
    		<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#"><span class="glyphicon glyphicon-user"></span><span class="caret"></span></a>
        		<ul class="dropdown-menu">
          			<li><a href="profile.php">View Profile</a></li>
          			<li class="divider"></li>
          			<li><a href="change_password.php" >Change Password</a></li>
        		</ul>
      		</li>
     		<li><a href="admin.php?logout"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
    	</ul>
    </div>
  		</div>
	</nav>
</div>
	<!------------------------ SIDEBAR   ---------------------------------------->
	<div class="container-fuid">
		<div class='col-xs-4' style="z-index: 5;">
		<div class="sidebar">
  			<a href="admin.php" id='dashboard'><i class="fa fa-university"></i>&nbsp; Dashboard</a>
  			<a href="students_a.php" id='students'><i class="fa fa-graduation-cap"></i>&nbsp; Students</a>
  			<a href="teachers_a.php" id='teachers'><i class="fa fa-user"></i>&nbsp; Teachers</a>
  			<a href="courses_a.php" id='courses'><i class="fa fa-book"></i>&nbsp; Courses</a>
  			<a href="internship_a.php" id='internship'><i class="fa fa-bell"></i>&nbsp; Internship</a>
		</div>
	</div>



	

</body>
</html>