<?php 
	include_once('../Database/database.php');
	include('functions.php');
	include('navside.php'); 
?>

<!DOCTYPE html>

<html>
<head>
		
	<title>Admin Portal</title>
	<script type="text/javascript">
		$(document).ready(function(){
			$('#courses').css({
			color: '#EEEEEE'
			});
		})

	</script>

	<!-------------------  FORM SUBMISSIONS -------------------------->

	<?php
	
		//Check if Add course form submitted
	if(isset($_POST['add_course'])){
		$id = apply_filters($_POST['c_id']); //Store reply
		$name = apply_filters($_POST['c_name']); //Store reply
		$cred_hrs = apply_filters($_POST['cred_hrs']); //Store reply
		$dept = apply_filters($_POST['dept']); //Store reply
		$pre_req = apply_filters($_POST['pre_req']); //Store reply
		$descr = apply_filters($_POST['descr']); //Store reply
		
		if(add_course(array($id,$name,$cred_hrs,$dept,$pre_req,$descr))){

			//Bootstrap close Alert
			$crs_added = '<div class="alert alert-success alert-dismissible fade in updated">
    						<a href="#" class="close" data-dismiss="alert" aria-label="close" style="padding-top:15px;">&times;</a>
    						<strong>Success!</strong> New Course added.
  						</div>';
		}	
	} ?>

	<?php

	if (isset($_POST['update_req'])){
		
		$col2set = array('Status');
		$data = array();

		$status = apply_filters($_POST['status']);
		if ($status == 'ACCEPTED'){ //If accepted remove request from table
			$query = 'SELECT C_ID, T_ID FROM request_course WHERE Request_ID ="'.$_COOKIE['req_id'].'"'; //Course and teacher ID
			$result = mysqli_query($GLOBALS['conn'],$query);
			$row = mysqli_fetch_row($result);
			$COURSE_ID = $row[0];// For course_sec MODAL
			setcookie('crs_id',$COURSE_ID); //set a cookie for C_ID
			$TEACHER_ID = $row[1];// For course_sec MODAL
			setcookie('tchr_id',$TEACHER_ID); //set a cookie for T_ID
			$flag_accepted = true; //set flag to open another modal

			delete('request_course','Request_ID',$_COOKIE['req_id']); //Remove from requests if ACCEPTED

		}
		array_push($data, $status); //add to array

		if(update('request_course',$col2set,$data,'Request_ID',$_COOKIE['req_id'])){

			//Bootstrap close Alert
			$req_updated = '<div class="alert alert-success alert-dismissible fade in updated">
    						<a href="#" class="close" data-dismiss="alert" aria-label="close" style="padding-top:15px;">&times;</a>
    						<strong>Success!</strong> Course Request Status has been Updated.
  						</div>';
		}

	}
	// Add course section MODAL
	if(isset($_POST['add_course_sec'])){
		$sec_id = apply_filters($_POST['Sec_ID']); //Store reply
		$seats_offered = apply_filters($_POST['SeatsOffered']); //Store reply
		$seats_avail = apply_filters($_POST['SeatsAvailable']); //Store reply
		$room = apply_filters($_POST['Room']); //Store reply
		$days = apply_filters($_POST['days']); //Store reply
		$timings = apply_filters($_POST['timings']); //Store reply

		if(insert('',array($sec_id,$_COOKIE['crs_id'],$_COOKIE['tchr_id'],$seats_offered,$seats_avail,$room,$days,$timings),'course_sec')){

			//Bootstrap close Alert
			$crs_sec_added = '<div class="alert alert-success alert-dismissible fade in updated">
    						<a href="#" class="close" data-dismiss="alert" aria-label="close" style="padding-top:15px;">&times;</a>
    						<strong>Success!</strong> Course has been added for Students to register.
  						</div>';
		}
	}

	 ?>

	<?php
	//Check if Student form submitted
	if(isset($_POST['edit_crs'])){
		$col2set = array();
		$data = array();

		$name = apply_filters($_POST['c_name']); //Store reply
		if (strlen($name) > 0){
			array_push($col2set, 'Name');
			array_push($data, $name);
		}
		$cred_hrs = apply_filters($_POST['cred_hrs']); //Store reply
		if (strlen($cred_hrs) > 0){
			array_push($col2set, 'cred_hrs');
			array_push($data, $cred_hrs);
		}
		$dept = apply_filters($_POST['dept']); //Store reply
		if (strlen($dept) > 0){
			array_push($col2set, 'Department');
			array_push($data, $dept);
		}
		$pre_req = apply_filters($_POST['pre_req']); //Store reply
		if (strlen($pre_req) > 0){
			array_push($col2set, 'Major');
			array_push($data, $pre_req);
		}
		$description = apply_filters($_POST['descr']); //Store reply
		if (strlen($description) > 0){
			array_push($col2set, 'Description');
			array_push($data, $description);
		}
		
		if(update('course',$col2set,$data,'C_ID',$_COOKIE['crs_id'])){

			//Bootstrap close Alert
			$updated_course = '<div class="alert alert-success alert-dismissible fade in updated">
    						<a href="#" class="close" data-dismiss="alert" aria-label="close" style="padding-top:15px;">&times;</a>
    						<strong>Success!</strong> Course has been updated.
  						</div>';
		}	
	} ?>

	<?php
	// DELETE COURSE
	if(isset($_POST['delete_crs'])){
		if(delete('course','C_ID',$_COOKIE['crs_id'])){
			//Bootstrap close Alert
			$delete_course = '<div class="alert alert-success alert-dismissible fade in updated">
    						<a href="#" class="close" data-dismiss="alert" aria-label="close" style="padding-top:15px;">&times;</a>
    						<strong>Success!</strong> Course has been deleted.
  						</div>';
		}
		
	}

	 ?>

</head>
<body>
	<div style="margin-left: 20%; margin-top: 4%;"> <!-- main div -->
		<div class="row"> <!-- Row -->
			<?php 
			if(isset($flag_accepted)){ //Show Modal if course request ACCEPTED
				// Modal for Student Accounts
				echo '<script type="text/javascript">
    				$(window).on("load",function(){
        			$("#course_secmodal").modal("show");
    				});</script>';
			}

			?>

			<div class="col-xs-8 col-md-12">
				<!-- Search form -->
				<div class="search_bar3">
					<form  class='form-inline' method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
  					<input class="form-control" type="text" placeholder="Search Courses by ID...." required name='crs_search'>
  						<button id='btn' class="btn btn-success green-btn" name="c_search" style="margin-left: 0px !important;">&#xf002;</button>
  					</form>
				</div>
			</div>
		</div> <!-- Row -->

		<!----------------------------- SEARCH RESULTS SECTION (Hidden) ----------------------------------->
		

		<div class="row"> <!-- Row -->

			<div class = 'complaints col-xs-12 search_col' style="margin-left: 68px;">
					
				<div class="search_txt"><h1><span class="s_icon">&#xf002;</span>Search Results</h1></div>
				<div class='complaints_table'>

					<?php 
    				if (isset($_POST['c_search'])){
						$search = apply_filters($_POST['crs_search']); //get value of search input
						$query = "SELECT * FROM Course WHERE C_ID = '$search'";

						$result = mysqli_query($GLOBALS['conn'],$query);
						if(mysqli_num_rows($result) > 0){

							echo "<table class='table table-hover table-bordered table-striped'>";
							echo "<thead>";
							echo "
							<tr>
        						<th>Course ID</th>
        						<th>Name</th>
        						<th>Credit Hours</th>
        						<th>Department</th>
        						<th>Pre Req</th>
        						<th>Description</th>
      						</tr>
    						</thead>
    						<tbody><tr>";

							while ($row = mysqli_fetch_row($result)) {
								echo '<td>'.$row[0].'</td>';
								echo '<td>'.$row[1].'</td>';
								echo '<td>'.$row[2].'</td>';
								echo '<td>'.$row[3].'</td>';
								echo '<td>'.$row[4].'</td>';
								echo '<td>'.$row[5].'</td></tr>';
							}	
						echo "</tbody></table>";
						}
						else{

							echo "<div class='alert alert-danger complaint_err' role='alert'>
								No Results found! <span class='smile'>&#xf119;</span>
								</div>";
							}

					  echo "<script>$('.complaints').show();</script>"; //Show Search results section							
				}
					?>
				</div>
		</div> 
	</div><!-- Row -->


	<!----------------------------- COURSES SECTION ----------------------------------->

		<div class="row"> <!-- Row -->
			<?php 
			//*************************** MESSAGES ******************************
				if (isset($updated_course)){
					echo $updated_course;
				}
				//COURSE ADDED MESSAGE
				if (isset($crs_added)){
					echo $crs_added;
				}
				//DELETE COURSE MESSAGE
				if (isset($delete_course)){
					echo $delete_course;
				}
				//COURSE ALREADY EXISTS
				if(isset($_POST['add_course'])){
					if (!isset($crs_added)){
						echo '<div class="alert alert-warning alert-dismissible fade in updated">
    						<a href="#" class="close" data-dismiss="alert" aria-label="close" style="padding-top:15px;">&times;</a>
    						<strong>Error!</strong> This Course already exists.
  						</div>';
					}
				}
				//COURSE ADDED TO COURSE_SEC
				if (isset($crs_sec_added)){
					echo $crs_sec_added;
				}

				?>

			<div class = 'complaints col-xs-12' style="margin-left: 62px;">
					
				<div class="complaints_txt" style="background-color: #34B048;"><h1><span style="margin-right: 15px;">&#xf02d;</span>All Courses</h1>
					<div id='add_btn'>
						<button class ='btn btn-success add' data-toggle="modal" data-target= "#addCoursesModal">Add New &nbsp;&#xf067;</button>
					</div>
				</div>
				<!-- Modal for adding Student -->
			<div class="modal fade" id="addCoursesModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
  				<div class=modal-dialog role="document">
    			<div class="modal-content">
      				<div class="modal-header">
        				<h4 class="modal-title" id="ModalLabel">Add New Course</h4>
        				<strong><small style="color: #84469F;">*All Fields are Required</small></strong>
        				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          				<span aria-hidden="true">&times;</span>
        				</button>
      				</div>
      			<div class="modal-body">

        			<form method="post" action= "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        				<div class="form-group">
    						<label for="c_id">Course ID</label>
    						<input class="form-control" id="c_id" name="c_id" placeholder="Enter Course ID (eg. COMP200)" type="text" required></input>
  						</div>
  						<div class="form-group">
    						<label for="c_name">Course Name</label>
    						<input class="form-control" id="c_name" name="c_name" placeholder="Enter Course Name" type="text" required></input>
  						</div>
  						<div class="form-group">
    						<label for="cred_hrs">Credit Hours</label>
    						<input class="form-control" id="cred_hrs" name="cred_hrs" placeholder="Enter Credit Hours" type="number" required></input>
  						</div>
  						<div class="form-group">
    						<label for="dept">Department</label>
    						<input class="form-control" id="dept" name="dept" placeholder="Enter Course Department" type="text" required></input>
  						</div>
  						<div class="form-group">
    						<label for="pre_req">Pre Req</label>
    						<input class="form-control" id="pre_req" name="pre_req" placeholder="Enter Course Pre Requisite" type="text" required></input>
  						</div>
  						<div class="form-group">
    						<label for="descr">Course Description</label>
							<textarea class="form-control" id="descr" rows="5" name='descr' required placeholder="Enter Course Description"></textarea> 						
						</div>

      			</div>
      			<div class="modal-footer">
        			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        			<button type="submit" class="btn btn-primary" name='add_course'>Add</button>
      			</div>
      			</form>
    			</div>
  				</div>
			</div> 

				<div class='complaints_table '>

					<?php
					$query = "SELECT * FROM course";
					$result = mysqli_query($GLOBALS['conn'],$query); 
					if(mysqli_num_rows($result) > 0){

							echo "<table class='table table-hover table-bordered table-striped'>";
							echo "<thead>";
							echo "
							<tr>
        						<th>Course ID</th>
        						<th>Course Name</th>
        						<th>Cred hrs</th>
        						<th>Department</th>
        						<th>Pre Req</th>
        						<th>Description</th>
        						<th>Edit</th>
      						</tr>
    						</thead>
    						<tbody><tr>";
    						while ($row = mysqli_fetch_row($result)) {
    							$value = $row[0];
								echo '<td>'.$row[0].'</td>';
								echo '<td>'.$row[1].'</td>';
								echo '<td>'.$row[2].'</td>';
								echo '<td>'.$row[3].'</td>';
								echo '<td>'.$row[4].'</td>';
								echo '<td>'.$row[5].'</td>';
								echo '<td>'.'<button class = "btn btn-small btn-success crs_btn" data-toggle="modal" data-target= "#courseModal" value ='.$value.'><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></td></tr>';
							}	
						echo "</tbody></table>";
					}
					else{

						echo "<div class='alert alert-danger complaint_err' role='alert'>
							No Courses found! <span class='smile'>&#xf119;</span>
							</div>";
						}

					?>
				</div>
				<script>
					//When a stdnt edit reply button clicked
					$(".crs_btn").click(function() {
						document.cookie = "crs_id=;expires=Thu, 01 Jan 1970 00:00:00 UTC;"; //delete previous id cookie
    					var fired_button = $(this).val(); //get value of clicked button
    					document.cookie = "crs_id="+fired_button; //create a cookie (crs_id)
    					$('#crs_id').html(fired_button);
						});					
						
					</script>

				<!-- Modal for edit course -->
			<div class="modal fade" id="courseModal" tabindex="-1" role="dialog" aria-labelledby="stdLabel1" aria-hidden="true">
  				<div class=modal-dialog role="document">
    			<div class="modal-content">
      				<div class="modal-header">
        				<h4 class="modal-title" id="stdLabel1">Edit Course Information (<span id = 'crs_id'></span>)</h4>
        				<strong><small style="color: #84469F;">*Enter fields you want to update</small></strong>
        				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          				<span aria-hidden="true">&times;</span>
        				</button>
      				</div>
      			<div class="modal-body">

        			<form method="post" action= "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

  						<div class="form-group">
    						<label for="c_name">Course Name</label>
    						<input class="form-control" id="c_name" name="c_name" placeholder="Enter Course Name" type="text" ></input>
  						</div>
  						<div class="form-group">
    						<label for="cred_hrs">Credit Hours</label>
    						<input class="form-control" id="cred_hrs" name="cred_hrs" placeholder="Enter Credit Hours" type="number" ></input>
  						</div>
  						<div class="form-group">
    						<label for="dept">Department</label>
    						<input class="form-control" id="dept" name="dept" placeholder="Enter Course Department" type="text" ></input>
  						</div>
  						<div class="form-group">
    						<label for="pre_req">Pre Req</label>
    						<input class="form-control" id="pre_req" name="pre_req" placeholder="Enter Course Pre Requisite" type="text" ></input>
  						</div>
  						<div class="form-group">
    						<label for="descr">Course Description</label>
							<textarea class="form-control" id="descr" rows="5" name='descr'  placeholder="Enter Course Description"></textarea> 						
						</div>
						 <div id='delete'>
							<button type="submit" class="btn btn-danger" name='delete_crs'> &#xf014; DELETE COURSE</button>

						</div> 

      			</div>
      			<div class="modal-footer">
        			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        			<button type="submit" class="btn btn-primary" name='edit_crs'>Update</button>
      			</div>
      			</form>
    			</div>
  				</div>
  			</div>
			</div> 
		</div><!-- Row -->


		<!----------------------------- Course REQUESTS SECTION ----------------------------------->
			
		<div class="row"> <!-- Row -->
		<?php 
				//Message if updated
				if (isset($req_updated)){
					echo $req_updated;
				} ?>
			
			<div class = 'accnt complaints col-xs-12' style="margin-left: 68px;">
			<div class="complaints_txt" style="background-color: #141414;"><h1><i class='fa fa-bookmark icons' aria-hidden="true"></i>Course Requests</h1></div>
			<div class='complaints_table'> <!-- table -->

			<?php
				$query = "SELECT * FROM request_course WHERE Status = 'PENDING'";
				$result = mysqli_query($GLOBALS['conn'],$query); 
				if(mysqli_num_rows($result) > 0){

					echo "<table class='table table-hover table-bordered table-striped'>";
					echo "<thead>";
					echo "
					<tr>
        				<th>Request ID</th>
        				<th>Course ID</th>
        				<th>Teacher ID</th>
        				<th>Status</th>
      				</tr>
    				</thead>
    				<tbody><tr>";
    				while ($row = mysqli_fetch_row($result)) {
    					$value = $row[0];
						echo '<td>'.$row[0].'</td>';
						echo '<td>'.$row[1].'</td>';
						echo '<td>'.$row[2].'</td>';
						echo '<td>'.$row[3].'</td>';
						echo '<td>'.'<button class = "btn btn-small btn-success req_btn" data-toggle="modal" data-target= "#requestModal" value ='.$value.'><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></td></tr>';
							}	
						echo "</tbody></table>";
					}
					else{

						echo "<div class='alert alert-danger complaint_err' role='alert'>
							No Pending Course Requests! <span class='smile'>&#xf119;</span>
							</div>";
						}
					?>
				</div>
				<script>
					//When a stdnt edit reply button clicked
					$(".req_btn").click(function() {
						document.cookie = "req_id=;expires=Thu, 01 Jan 1970 00:00:00 UTC;"; //delete previous id cookie
    					var fired_button = $(this).val(); //get value of clicked button
    					document.cookie = "req_id="+fired_button; //cr_Accnteate a cookie (user_id)
    					$('#req_id').html(fired_button);
						});					
						
					</script>
			</div> <!-- table -->

			<!-- Modal for Student Accounts -->
			<div class="modal fade" id="requestModal" tabindex="-1" role="dialog" aria-labelledby="accntLabel2" aria-hidden="true">
  				<div class=modal-dialog role="document">
    			<div class="modal-content">
      				<div class="modal-header">
        				<h4 class="modal-title" id="accntLabel2">Respond to Request (<span id = 'req_id'></span>)</h4>
        				<strong><small style="color: #84469F;">*Select option below</small></strong>
        				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          				<span aria-hidden="true">&times;</span>
        				</button>
      				</div>
      			<div class="modal-body">

        			<form method="post" action= "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

  						<div class="form-group">
    						<label for="status">Course Request Status</label>
    						<!-- <input class="form-control" id="gender" name="gender"></input> -->
    						<select class="form-control" id="status" name="status">
    							<option value="PENDING">PENDING</option>
   	 							<option value="ACCEPTED">ACCEPTED</option>
    							<option value="REJECTED">REJECTED</option>
    						</select>
  						</div>
  						
      			</div>
      			<div class="modal-footer">
        			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        			<button type="submit" class="btn btn-primary" name='update_req'>Update</button>
      			</div>
      			</form>
    			</div>
  				</div>
  			</div> 


  			<!-- Modal for adding course after Request Accepted -->
			<div class="modal fade" id="course_secmodal" tabindex="-1" role="dialog" aria-labelledby="accntLabel2" aria-hidden="true">
  				<div class=modal-dialog role="document">
    			<div class="modal-content">
      				<div class="modal-header">
        				<h4 class="modal-title" id="accntLabel2">Enter Course Details (<span><?php echo $COURSE_ID; ?></span>)</h4>
        				<strong><small style="color: #84469F;">*All fields are required</small></strong>
        				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          				<span aria-hidden="true">&times;</span>
        				</button>
      				</div>
      			<div class="modal-body">

        			<form method="post" action= "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

  						<div class="form-group">
    						<label for="Sec_ID">Select Course Section</label>
    						<!-- <input class="form-control" id="gender" name="gender"></input> -->
    						<select class="form-control" id="Sec_ID" name="Sec_ID" Required>
    							<option value="">SELECT</option>
   	 							<option value=<?php echo $COURSE_ID.'-A' ; ?> > <?php echo $COURSE_ID.'-A' ;?></option>
    							<option value=<?php echo $COURSE_ID.'-B' ; ?> ><?php echo $COURSE_ID.'-B' ;?></option>
    							<option value=<?php echo $COURSE_ID.'-C' ; ?> ><?php echo $COURSE_ID.'-C' ;?></option>
    						</select>
  						</div>

  						<div class="form-group">
    						<label for="SeatsOffered">Seats Offered</label>
    						<input class="form-control" id="SeatsOffered" name="SeatsOffered" placeholder="Enter Total Seats Offered" type="number" Required></input>
  						</div>

  						<div class="form-group">
    						<label for="SeatsAvailable">Seats Available</label>
    						<input class="form-control" id="SeatsAvailable" name="SeatsAvailable" placeholder="Enter Total Seats Available" type="number" Required></input>
  						</div>

  						<div class="form-group">
    						<label for="Room">Enter Room Number</label>
    						<input class="form-control" id="Room" name="Room" placeholder="Enter Room (eg. S-219)" type="text" pattern="[A-Z](-\d{3})"Required ></input>
  						</div>
  						<div class="form-group">
    						<label for="days">Select Days</label>
    						<!-- <input class="form-control" id="gender" name="gender"></input> -->
    						<select class="form-control" id="days" name="days" Required>
    							<option value="">Select Days</option>
   	 							<option value='MWF'> MWF </option>
    							<option value='TR'> TR </option>
    							<option value='MF'> MF </option>
    							<option value='MW'> MW </option>
    						</select>
  						</div>

  						<div class="form-group">
    						<label for="timings">Class Timings</label>
    						<input class="form-control" id="timings" name="timings" placeholder="Enter Timings (eg. 12:30 - 1:45)" type="text" Required></input>
  						</div>
  
      			</div>
      			<div class="modal-footer">
        			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        			<button type="submit" class="btn btn-primary" name='add_course_sec'>Add Course</button>
      			</div>
      			</form>
    			</div>
  				</div>
  			</div> 


		</div> <!-- ROW -->


	</div><!-- Main -->




</body>
</html>