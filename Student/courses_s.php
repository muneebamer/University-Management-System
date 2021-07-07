<?php include_once('../Database/database.php');
	include('navside.php'); 
	include('functions.php'); ?>

<!DOCTYPE html>

 <?php
	
	//Check if Register course form submitted
	if(isset($_POST['crs_register'])){
		
		
		if(register_course($_COOKIE['section_id'])){

			//Bootstrap close Alert
			$crs_registered = '<div class="alert alert-success alert-dismissible fade in updated">
    						<a href="#" class="close" data-dismiss="alert" aria-label="close" style="padding-top:15px;">&times;</a>
    						<strong>Success!</strong> New has been registered successfully.
  						</div>';
		}

	} ?>

	<?php
	
	//Check if Register course form submitted
	if(isset($_POST['withdraw'])){
		$rsn = apply_filters($_POST['reason']);
		
		if(withdraw($_COOKIE['section_id'], $rsn)){

			//Bootstrap close Alert
			$withdrawed = '<div class="alert alert-success alert-dismissible fade in updated">
    						<a href="#" class="close" data-dismiss="alert" aria-label="close" style="padding-top:15px;">&times;</a>
    						<strong>Success!</strong> Your Course Withdrawal request has been submitted and is waiting for Approval.
  						</div>';
		}

	} ?>
<html>
<head>
	<title>Student Portal</title>
	<script type="text/javascript">
		//Changing active nav link color
		$(document).ready(function(){
			$('#courses').css({
			color: '#EEEEEE'
			});
		})

	</script>
<?php //SELECT course_sec.C_ID, course_registered.Sec_ID,course_sec.T_ID,course.Name, teacher.Name, course_registered.Semester,course_registered.Grade FROM course_sec, course_registered, teacher, course Where course_registered.S_ID = 'S-102'  AND course_sec.T_ID =teacher.T_ID AND course.C_ID = course_sec.C_ID AND course_registered.Sec_ID = course_sec.Sec_ID ?>
</head>
<body>

	<div style="margin-left: 20%; margin-top: 5%;">
	<!--------------------- STUDENT COURSES (ungraded) TABLE ------------------------------>
		<div class="row">
			<?php 
				//Message if updated
				if (isset($withdrawed)){
					echo $withdrawed;
				}
				if(isset($_POST['withdraw'])){
					if(!isset($withdrawed)){

						echo '<div class="alert alert-warning alert-dismissible fade in updated">
    						<a href="#" class="close" data-dismiss="alert" aria-label="close" style="padding-top:15px;">&times;</a>
    						<strong>Error!</strong> You have already requested withdrawal from this course.
  						</div>';
					}
				}


				 ?>

			<div class="col-xs-8 col-md-12">

				<div class = 'complaints col-xs-12'>
					
					<div class="complaints_txt2" style="background-color: #141414;"><h1><span class="icon_reg">&#xf046;</span>Registered Courses (UNGRADED)</h1>
					</div>
					<div class='complaints_table'>
						<?php
						$sid = $_SESSION['S_ID'];
						$query = "SELECT course_sec.C_ID, course_registered.Sec_ID,course.Name,teacher.Name, course_registered.Semester,course_registered.Grade FROM course_sec, course_registered, teacher, course Where course_registered.S_ID = '$sid'  AND course_sec.T_ID =teacher.T_ID AND course.C_ID = course_sec.C_ID AND course_registered.Sec_ID = course_sec.Sec_ID AND course_registered.Grade = 'PENDING'";
							$result = mysqli_query($GLOBALS['conn'],$query);  
							
							if(mysqli_num_rows($result) > 0){

							echo "<table class='table table-hover table-bordered table-striped'>";
							echo "<thead>";
							echo "
							<tr>
        						<th>Course ID</th>
        						<th>Section ID</th>
        						<th>Course Name</th>
        						<th>Teacher Name</th>
        						<th>Semester</th>
        						<th>Grade</th>
        						<th>Withdraw Course</th>
      						</tr>
    						</thead>
    						<tbody><tr>";
    						while ($row = mysqli_fetch_row($result)) {
    							$sec_id = $row[1];
								echo '<td>'.$row[0].'</td>';
								echo '<td>'.$row[1].'</td>';
								echo '<td>'.$row[2].'</td>';
								echo '<td>'.$row[3].'</td>';
								echo '<td>'.$row[4].'</td>';
								echo '<td>'.$row[5].'</td>';
								echo '<td>'.'<button class = "btn btn-sm btn-danger w_btn" data-toggle="modal" data-target= "#withdrawModal" value ='.$sec_id.'><i class="fa fa-times" aria-hidden="true"></i></button></td></tr>';
							}	
						echo "</tbody></table>";
					}
					else{
						echo "<div class='alert alert-danger complaint_err' role='alert'>
							No Registered Courses! <span class='smile'>&#xf119;</span>
							</div>";
					}
						?>
									
					</div>
				</div>
				<script>
				//When a withdraw button clicked
				$(".w_btn").click(function() {
					document.cookie = "section_id=;expires=Thu, 01 Jan 1970 00:00:00 UTC;"; //delete previous id cookie
    				var fired_button = $(this).val(); //get value of clicked button
    				document.cookie = "section_id="+fired_button; //create a cookie (section_id)
    				$('#w_id').html(fired_button);
    				$('#wd_id').html(fired_button);
					});					
						
			</script>
			</div>

			<!-- Modal for Student Complaints -->
			<div class="modal fade" id="withdrawModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  				<div class=modal-dialog role="document">
    			<div class="modal-content">
      				<div class="modal-header">
        				<h4 class="modal-title" id="exampleModalLabel">Confirm Registration (CID: <span id = 'w_id'></span>)</h4>
        				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          				<span aria-hidden="true">&times;</span>
        				</button>
      				</div>
      			<div class="modal-body">
        			<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        			<div class="form-group">
    						<label for="reason">Reason</label>
    						<textarea class="form-control" id="reason" name="reason" rows= '5' placeholder="Enter Reason for course withdrawal" type="text" required></textarea>
  						</div>

      			</div>
      			
      			<div class="modal-footer">
        			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        			<button type="submit" class="btn btn-primary" name='withdraw'>Withdraw</button>
      			</div>
      			</form>
    			</div>
  				</div>
			</div> 


		</div> <!-- ROW -->
		<div class="row"> <!-- Row -->
		<?php 
				//Message if updated
				if (isset($req_updated)){
					echo $req_updated;
				}

				//Message if updated
				if (isset($crs_registered)){
					echo $crs_registered;
				}
				if(isset($_POST['crs_register'])){
					if (!isset($crs_registered)){
						echo '<div class="alert alert-warning alert-dismissible fade in updated">
    						<a href="#" class="close" data-dismiss="alert" aria-label="close" style="padding-top:15px;">&times;</a>
    						<strong>Error!</strong> Course Registration Unsuccessful.
  						</div>';
					}
				}

				 ?>
			
			<div class = 'accnt addCourses col-xs-12' style="margin-left: 30px;">
			<div class="complaints_txt" style="background-color: #141414;"><h1><i class='fa fa-bookmark icons' aria-hidden="true"></i>Add Courses</h1></div>
			<div class='complaints_table'> <!-- table -->

			<?php
				$query = "SELECT course_sec.C_ID, course_sec.Sec_ID, course.Name, teacher.Name, course.Cred_hrs, course_sec.SeatsOffered,course_sec.SeatsAvail, course_sec.Room, course_sec.Days, course_sec.Timings FROM course_sec, course, teacher WHERE course_sec.C_ID = course.C_ID AND course_sec.T_ID = teacher.T_ID";
				$result = mysqli_query($GLOBALS['conn'],$query); 
				if(mysqli_num_rows($result) > 0){

					echo "<table class='table table-hover table-bordered table-striped custom-scrollbar table-wrapper-scroll-y'>";
					echo "<thead>";
					echo "
					<tr>
        				<th>Course ID</th>
        				<th>Section ID</th>
        				<th>Course Name</th>
        				<th>Teacher Name</th>
        				<th>Cred hrs</th>
        				<th>Seats Offered</th>
        				<th>Seats Avail</th>
        				<th>Room</th>
        				<th>Days</th>
        				<th>Timings</th>
        				<th>Add Course</th>
      				</tr>
    				</thead>
    				<tbody><tr>";
    				while ($row = mysqli_fetch_row($result)) {
    					$sec_id = $row[1];
						echo '<td>'.$row[0].'</td>';
						echo '<td>'.$row[1].'</td>';
						echo '<td>'.$row[2].'</td>';
						echo '<td>'.$row[3].'</td>';
						echo '<td>'.$row[4].'</td>';
						echo '<td>'.$row[5].'</td>';
						echo '<td>'.$row[6].'</td>';
						echo '<td>'.$row[7].'</td>';
						echo '<td>'.$row[8].'</td>';
						echo '<td>'.$row[9].'</td>';
						echo '<td>'.'<button class = "btn btn-small btn-primary add_btn" data-toggle="modal" data-target= "#checkModal" value ='.$sec_id.'><i class="fa fa-plus-circle" aria-hidden="true"></i></button></td></tr>';
							}	
						echo "</tbody></table>";
					}
					else{

						echo "<div class='alert alert-danger complaint_err' role='alert'>
							No Courses Found! <span class='smile'>&#xf119;</span>
							</div>";
						}
					?>
				</div>
			</div>
			<script>
				//When a stdnt edit reply button clicked
				$(".add_btn").click(function() {
					document.cookie = "section_id=;expires=Thu, 01 Jan 1970 00:00:00 UTC;"; //delete previous id cookie
    				var fired_button = $(this).val(); //get value of clicked button
    				document.cookie = "section_id="+fired_button; //create a cookie (section_id)
    				$('#crs_id').html(fired_button);
    				$('#cr_id').html(fired_button);
					});					
						
			</script>

			<!-- Modal for Student Complaints -->
			<div class="modal fade" id="checkModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  				<div class=modal-dialog role="document">
    			<div class="modal-content">
      				<div class="modal-header">
        				<h4 class="modal-title" id="exampleModalLabel">Confirm Registration (CID: <span id = 'crs_id'></span>)</h4>
        				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          				<span aria-hidden="true">&times;</span>
        				</button>
      				</div>
      			<div class="modal-body">
        			
        			<h5> Are you sure you want to register <span id='cr_id' style="color: #46B141;"></span></h5>

      			</div>
      			<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
      			<div class="modal-footer">
        			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        			<button type="submit" class="btn btn-primary" name='crs_register'>Yes</button>
      			</div>
      			</form>
    			</div>
  				</div>
			</div> 
		</div> <!-- ROW -->

		<div class="row">

			<div class="col-xs-8 col-md-12">

				<div class = 'complaints col-xs-12'>
					
					<div class="complaints_txt2" style="background-color: #45AEA3;"><h1><span class="icon_reg">&#xf29a;</span>Your Course Withdrawal Requests</h1>
					</div>
					<div class='complaints_table'>
						<?php
						$sid = $_SESSION['S_ID'];
						$query = "SELECT W_ID, Sec_ID, Reason, Status FROM withdraw_course WHERE S_ID = '$sid'";
							$result = mysqli_query($GLOBALS['conn'],$query);  
							
							if(mysqli_num_rows($result) > 0){

							echo "<table class='table table-hover table-bordered table-striped'>";
							echo "<thead>";
							echo "
							<tr>
        						<th>Withdrawal ID</th>
        						<th>Section ID</th>
        						<th>Reason</th>
        						<th>Status</th>
      						</tr>
    						</thead>
    						<tbody><tr>";
    						while ($row = mysqli_fetch_row($result)) {
    							$sec_id = $row[1];
								echo '<td>'.$row[0].'</td>';
								echo '<td>'.$row[1].'</td>';
								echo '<td>'.$row[2].'</td>';
								echo '<td>'.$row[3].'</td></tr>';
								
							}	
						echo "</tbody></table>";
					}
					else{
						echo "<div class='alert alert-danger complaint_err' role='alert'>
							No Course Withdrawal Requests! <span class='smile'>&#xf119;</span>
							</div>";
					}
						?>
									
					</div>
				</div>
			</div>
		</div>

	</div> <!-- MAIN -->

</div> <!-- Div closed for navside.php container -->

</body>
</html>