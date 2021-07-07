
<?php 
	include_once('../Database/database.php');
	include('functions.php');
	include('navside.php'); 
?>

<!DOCTYPE html>

<html>
<head>
		
	<title>Admin Portal</title>
	<!-- Change selected navlink color -->
	<script type="text/javascript">
		$(document).ready(function(){
			$('#teachers').css({
			color: '#EEEEEE'
			});
		})

	</script>
	<!------------------ FORM SUBMISSIONS ------------------------------------->

	<?php
	//Check if Add Teacher form submitted
	if(isset($_POST['add_teacher'])){
		$id = apply_filters($_POST['t_id']); //Store reply
		$name = apply_filters($_POST['name']); //Store reply
		$pasw = apply_filters($_POST['pasw']); //Store reply
		$contact = apply_filters($_POST['contact']); //Store reply
		$email = apply_filters($_POST['email']); //Store reply
		$address = apply_filters($_POST['address']); //Store reply
		$dept = apply_filters($_POST['dept']); //Store reply
		$gender = apply_filters($_POST['gender']); //Store reply
		$salary = apply_filters($_POST['salary']); //Store reply
		
		if(add_teacher($id,$name,$contact,$email,$address,$dept,$gender,$salary,$pasw)){

			//Bootstrap close Alert
			$teacher_added = '<div class="alert alert-success alert-dismissible fade in updated">
    						<a href="#" class="close" data-dismiss="alert" aria-label="close" style="padding-top:15px;">&times;</a>
    						<strong>Success!</strong> New Teacher added.
  						</div>';
		}	
	}
	//Check if Teacher form submitted
	if(isset($_POST['edit_teacher'])){
		$col2set = array();
		$data = array();

		$name2 = apply_filters($_POST['name2']); //Store reply
		if (strlen($name2) > 0){
			array_push($col2set, 'Name');
			array_push($data, $name2);
		}
		$contact2 = apply_filters($_POST['contact2']); //Store reply
		if (strlen($contact2) > 0){
			array_push($col2set, 'Contact');
			array_push($data, $contact2);
		}
		$email2 = apply_filters($_POST['email2']); //Store reply
		if (strlen($email2) > 0){
			array_push($col2set, 'Email');
			array_push($data, $email2);
		}
		$address2 = apply_filters($_POST['address2']); //Store reply
		if (strlen($address2) > 0){
			array_push($col2set, 'Address');
			array_push($data, $address2);
		}
		$dept = apply_filters($_POST['dept']); //Store reply
		if (strlen($dept) > 0){
			array_push($col2set, 'Dept');
			array_push($data, $dept);
		}
		$gender2 = apply_filters($_POST['gender2']); //Store reply
		if (strlen($gender2) > 0){
			array_push($col2set, 'Gender');
			array_push($data, $gender2);
		}
		$salary = apply_filters($_POST['salary']); //Store reply
		if (strlen($salary) > 0){
			array_push($col2set, 'Salary');
			array_push($data, $salary);
		}
		
		if(update('teacher',$col2set,$data,'T_ID',$_COOKIE['t_id'])){

			//Bootstrap close Alert
			$updated_student = '<div class="alert alert-success alert-dismissible fade in updated">
    						<a href="#" class="close" data-dismiss="alert" aria-label="close" style="padding-top:15px;">&times;</a>
    						<strong>Success!</strong> Teacher Information has been updated.
  						</div>';
		}	
	}

	//Check if Teacher Account form submitted
	if(isset($_POST['update_teacher_account'])){
		$col2set = array();
		$data = array();

		$pasw = apply_filters($_POST['pasw']); //Store reply
		if (strlen($pasw) > 0){
			array_push($col2set, 'Pasw');
			array_push($data, $pasw);
		}
		$block_status = apply_filters($_POST['is_block']); //Store reply
		if (strlen($block_status) > 0){
			array_push($col2set, 'Is_block');
			array_push($data, $block_status);
		}
		if(update('login',$col2set,$data,'UserID',$_COOKIE['teacher_accnt_id'])){

			//Bootstrap close Alert
			$updated_stu_account = '<div class="alert alert-success alert-dismissible fade in updated">
    						<a href="#" class="close" data-dismiss="alert" aria-label="close" style="padding-top:15px;">&times;</a>
    						<strong>Success!</strong> Student Account Information has been updated.
  						</div>';
		}	
	} 

	?>

	<?php

	if (isset($_POST['respond_leave_req'])){
		$status = apply_filters($_POST['status']);

		if(respond_leave($_COOKIE['leave_id'],$status)){

			//Bootstrap close Alert
			$leave_updated = '<div class="alert alert-success alert-dismissible fade in updated">
    						<a href="#" class="close" data-dismiss="alert" aria-label="close" style="padding-top:15px;">&times;</a>
    						<strong>Success!</strong> Teacher Leave Request Status has been Updated.
  						</div>';

		}

	}

	 ?>
</head>
<body>

	<div style="margin-left: 20%; margin-top: 4%;"> <!-- main div -->

		<div class="row"> <!-- Row -->

			<div class="col-xs-8 col-md-12">
				<!-- Search form -->
				<div class="search_bar2">
					<form  class='form-inline' method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
  					<input class="form-control" type="text" placeholder="Search Teachers by ID or Name...." required name='t_search'>
  						<button id='btn' class="btn btn-warning" name="tsearch">&#xf002;</button>
  					</form>
				</div>
			</div>

		</div> <!-- ROW -->

		<!----------------------------- SEARCH RESULTS SECTION (Hidden) ----------------------------------->

		<div class="row"> <!-- Row -->

			<div class = 'complaints col-xs-12 search_col' style="margin-left: 68px;">
					
				<div class="search_txt"><h1><span class="s_icon">&#xf002;</span>Search Results</h1></div>
				<div class='complaints_table'>

					<?php 
    				if (isset($_POST['tsearch'])){
						$search = apply_filters($_POST['t_search']); //get value of search input
						for ($i=0; $i<strlen($search);$i++){// loop through char of search
							if ($search[$i]=='-'){ // if - found set flag
								$id = true;
							}
						}
						if(isset($id)){ // if id given in search
							$query = "SELECT * FROM Teacher WHERE T_ID = '$search'";
						}
						else{ // if name given in search
							$query = "SELECT * FROM Teacher WHERE Name = '$search'";
						}

						$result = mysqli_query($GLOBALS['conn'],$query);
						if(mysqli_num_rows($result) > 0){

							echo "<table class='table table-hover table-bordered table-striped'>";
							echo "<thead>";
							echo "
							<tr>
        						<th>Teacher ID</th>
        						<th>Name</th>
        						<th>Contact</th>
        						<th>Email</th>
        						<th>Address</th>
        						<th>Department</th>
        						<th>Gender</th>
        						<th>Salary</th>
      						</tr>
    						</thead>
    						<tbody><tr>";

							while ($row = mysqli_fetch_row($result)) {
								echo '<td>'.$row[0].'</td>';
								echo '<td>'.$row[1].'</td>';
								echo '<td>'.$row[2].'</td>';
								echo '<td>'.$row[3].'</td>';
								echo '<td>'.$row[4].'</td>';
								echo '<td>'.$row[5].'</td>';
								echo '<td>'.$row[6].'</td>';
								echo '<td>'.$row[7].'</td></tr>';
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

	<!----------------------------- TEACHERS SECTION ----------------------------------->

		<div class="row"> <!-- Row -->
			<?php 
			//Message if updated
				if (isset($updated_student)){
					echo $updated_student;
				}
				if (isset($teacher_added)){
					echo $teacher_added;
				}
				if(isset($_POST['add_teacher'])){
					if (!isset($teacher_added)){
						echo '<div class="alert alert-warning alert-dismissible fade in updated">
    						<a href="#" class="close" data-dismiss="alert" aria-label="close" style="padding-top:15px;">&times;</a>
    						<strong>Error!</strong> A Teacher with this ID already exists.
  						</div>';
					}
				}

				?>
			

			<div class = 'complaints col-xs-12' style="margin-left: 68px;" style="width: auto;">
					
				<div class="complaints_txt" style="background-color: #E9AA2A;"><h1><span class="icon_tchr">&#Xf007;</span>All Teachers</h1>
					<div id='add_btn'>
						<button class ='btn btn-warning add' data-toggle="modal" data-target= "#addTeacherModal">Add New &nbsp;&#xf067;</button>
					</div>
				</div>
				<!-- Modal for adding Teachers -->
			<div class="modal fade" id="addTeacherModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
  				<div class=modal-dialog role="document">
    			<div class="modal-content">
      				<div class="modal-header">
        				<h4 class="modal-title" id="ModalLabel">Add New Teacher</h4>
        				<strong><small style="color: #84469F;">*All Fields are Required</small></strong>
        				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          				<span aria-hidden="true">&times;</span>
        				</button>
      				</div>
      			<div class="modal-body">

        			<form method="post" action= "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        				<div class="form-group">
    						<label for="t_id">Teacher ID</label>
    						<input class="form-control" id="t_id" name="t_id" placeholder="Enter Student ID (eg. T-000)" type="text" pattern="[T](-\d{3})" required></input>
  						</div>
  						<div class="form-group">
    						<label for="pasw">Teacher Password</label>
    						<input class="form-control" id="pasw" name="pasw" placeholder="Enter Teacher Password" type="text" required></input>
  						</div>
  						<div class="form-group">
    						<label for="name">Name</label>
    						<input class="form-control" id="name" name="name" placeholder="Enter Name" type="text" required></input>
  						</div>
  						<div class="form-group">
    						<label for="contact">Contact</label>
    						<input class="form-control" id="contact" name="contact" placeholder="Enter Contact" type="tel" required></input>
  						</div>
  						<div class="form-group">
    						<label for="email">Email</label>
    						<input class="form-control" id="email" name="email" placeholder="Enter Email" type="email" required></input>
  						</div>
  						<div class="form-group">
    						<label for="address">Address</label>
    						<input class="form-control" id="address" name="address" placeholder="Enter Address" type="text" required></input>
  						</div>
  						<div class="form-group">
    						<label for="dept">Department</label>
    						<input class="form-control" id="dept" name="dept" placeholder="Enter Department" type="text" required></input>
  						</div>
  						<div class="form-group">
    						<label for="gender">Gender</label>
    						<!-- <input class="form-control" id="gender" name="gender"></input> -->
    						<select class="form-control" id="gender" name="gender" required>
    							<option value="">Select</option>
   	 							<option value="Male">Male</option>
    							<option value="Female">Female</option>
    						</select>
  						</div>
  						<div class="form-group">
    						<label for="salary">Salary</label>
    						<input class="form-control" id="salary" name="salary" placeholder="Enter Teacher Salary" type="text" required></input>
  						</div>


      			</div>
      			<div class="modal-footer">
        			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        			<button type="submit" class="btn btn-primary" name='add_teacher'>Add</button>
      			</div>
      			</form>
    			</div>
  				</div>
			</div> 
				<div class='complaints_table'>
				<div class='complaints_table'>

					<?php
					$query = "SELECT * FROM Teacher";
					$result = mysqli_query($GLOBALS['conn'],$query); 
					if(mysqli_num_rows($result) > 0){

							echo "<table class='table table-hover table-bordered table-striped table-responsive custom-scrollbar table-wrapper-scroll-y '>";
							echo "<thead>";
							echo "
							<tr>
        						<th>Teacher ID</th>
        						<th>Name</th>
        						<th>Contact</th>
        						<th>Email</th>
        						<th>Address</th>
        						<th>Department</th>
        						<th>Gender</th>
        						<th>Salary</th>
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
								echo '<td>'.$row[6].'</td>';
								echo '<td>'.$row[7].'</td>';
								echo '<td>'.'<button class = "btn btn-small btn-success t_btn" data-toggle="modal" data-target= "#teacherModal" value ='.$value.'><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></td></tr>';
							}	
						echo "</tbody></table>";
					}
					else{ //No teachers

						echo "<div class='alert alert-danger complaint_err' role='alert'>
							No Teachers found! <span class='smile'>&#xf119;</span>
							</div>";
						}

					?>
				</div>
				<script>
					//When a stdnt edit reply button clicked
					$(".t_btn").click(function() {
						document.cookie = "t_id=;expires=Thu, 01 Jan 1970 00:00:00 UTC;"; //delete previous id cookie
    					var fired_button = $(this).val(); //get value of clicked button
    					document.cookie = "t_id="+fired_button; //create a cookie (t_id)
    					$('#tchr_id').html(fired_button);
						});					
						
					</script>


			<!-- Modal for Student Complaints -->
			<div class="modal fade" id="teacherModal" tabindex="-1" role="dialog" aria-labelledby="tlabel" aria-hidden="true">
  				<div class=modal-dialog role="document">
    			<div class="modal-content">
      				<div class="modal-header">
        				<h4 class="modal-title" id="tlabel">Edit Teacher Information (<span id = 'tchr_id'></span>)</h4>
        				<strong><small style="color: #84469F;">*Enter fields you want to update</small></strong>
        				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          				<span aria-hidden="true">&times;</span>
        				</button>
      				</div>
      			<div class="modal-body">

        			<form method="post" action= "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

  						<div class="form-group">
    						<label for="name2">Name</label>
    						<input class="form-control" id="name2" name="name2" placeholder="Enter Name" type="text"></input>
  						</div>
  						<div class="form-group">
    						<label for="contact2">Contact</label>
    						<input class="form-control" id="contact2" name="contact2" placeholder="Enter Contact" type="tel"></input>
  						</div>
  						<div class="form-group">
    						<label for="email2">Email</label>
    						<input class="form-control" id="email2" name="email2" placeholder="Enter Email" type="email"></input>
  						</div>
  						<div class="form-group">
    						<label for="address2">Address</label>
    						<input class="form-control" id="address2" name="address2" placeholder="Enter Address" type="text"></input>
  						</div>
  						<div class="form-group">
    						<label for="dept">Department</label>
    						<input class="form-control" id="dept" name="dept" placeholder="Enter Department" type="text"></input>
  						</div>
  						<div class="form-group">
    						<label for="gender2">Gender</label>
    						<!-- <input class="form-control" id="gender" name="gender"></input> -->
    						<select class="form-control" id="gender2" name="gender2">
    							<option value="">Select</option>
   	 							<option value="Male">Male</option>
    							<option value="Female">Female</option>
    						</select>
  						</div>
  						<div class="form-group">
    						<label for="salary">Salary</label>
    						<input class="form-control" id="salary" name="salary" placeholder="Enter Teacher Salary" type="text"></input>
  						</div>


      			</div>
      			<div class="modal-footer">
        			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        			<button type="submit" class="btn btn-primary" name='edit_teacher'>Update</button>
      			</div>
      			</form>
    			</div>
  				</div>
  			</div>
			</div> 
		</div><!-- Row -->

		<!----------------------------- Teacher Accounts SECTION ----------------------------------->
			
		<div class="row"> <!-- Row --> 
			<?php 
				//Message if updated
				if (isset($updated_stu_account)){
					echo $updated_stu_account;
				} ?>
			
			<div class = 'accnt complaints col-xs-12' style="margin-left: 68px;">
			<div class="complaints_txt" style="background-color: #17B8B8;"><h1><i class="fa fa-user-circle-o accnt_icon" aria-hidden="true"></i>Teacher Accounts</h1></div>
			<div class='complaints_table'> <!-- table -->

			<?php
				$query = "SELECT UserID, Pasw, Is_Block FROM login WHERE account_type = 3";
				$result = mysqli_query($GLOBALS['conn'],$query); 
				if(mysqli_num_rows($result) > 0){

					echo "<table class='table table-hover table-bordered table-striped'>";
					echo "<thead>";
					echo "
					<tr>
        				<th>Teacher ID</th>
        				<th>Password</th>
        				<th>Blocked</th>
        				<th>Edit</th>
      				</tr>
    				</thead>
    				<tbody><tr>";
    				while ($row = mysqli_fetch_row($result)) {
    					$value = $row[0];
						echo '<td>'.$row[0].'</td>';
						echo '<td>'.$row[1].'</td>';
						echo '<td>'.$row[2].'</td>';
						echo '<td>'.'<button class = "btn btn-small btn-success teacher_accnt_btn" data-toggle="modal" data-target= "#teacher_account_modal" value ='.$value.'><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></td></tr>';
							}	
						echo "</tbody></table>";
					}
					else{

						echo "<div class='alert alert-danger complaint_err' role='alert'>
							No Teacher Accounts found! <span class='smile'>&#xf119;</span>
							</div>";
						}

					?>
				</div>
				<script>
					//When a teacher edit reply button clicked
					$(".teacher_accnt_btn").click(function() {
						document.cookie = "teacher_accnt_id=;expires=Thu, 01 Jan 1970 00:00:00 UTC;"; //delete previous id cookie
    					var fired_button = $(this).val(); //get value of clicked button
    					document.cookie = "teacher_accnt_id="+fired_button; //create a cookie (user_id)
    					$('#teacher_id_txt').html(fired_button);
						});					
						
					</script>
			</div> <!-- table -->

			<!-- Modal for Student Accounts -->
			<div class="modal fade" id="teacher_account_modal" tabindex="-1" role="dialog" aria-labelledby="accntLabel" aria-hidden="true">
  				<div class=modal-dialog role="document">
    			<div class="modal-content">
      				<div class="modal-header">
        				<h4 class="modal-title" id="accntLabel">Edit Teacher Account Information (<span id = 'teacher_id_txt'></span>)</h4>
        				<strong><small style="color: #84469F;">*Enter fields you want to update</small></strong>
        				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          				<span aria-hidden="true">&times;</span>
        				</button>
      				</div>
      			<div class="modal-body">

        			<form method="post" action= "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

  						<div class="form-group">
    						<label for="pasw">Teacher Password</label>
    						<input class="form-control" id="pasw" name="pasw" placeholder="Enter Password" type="text"></input>
  						</div>
  						
  						<div class="form-group">
    						<label for="is_block">Block User</label>
    						<select class="form-control" id="is_block" name="is_block">
    							<option value="">Select</option>
   	 							<option value="YES">YES</option>
    							<option value="NO">NO</option>
    						</select>
  						</div>

      			</div>
      			<div class="modal-footer">
        			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        			<button type="submit" class="btn btn-primary" name='update_teacher_account'>Update</button>
      			</div>
      			</form>
    			</div>
  				</div>
  			</div>
		</div><!-- ROW -->

		<div class="row"> <!-- Row -->
		<?php 
				//Message if updated
				if (isset($leave_updated)){
					echo $leave_updated;
				} ?>
			
			<div class = 'accnt complaints col-xs-12' style="width:60%;margin-left: 385px;">
			<div class="complaints_txt2" style="background-color: #141414;"><h1><i class='fa fa-bookmark icons' aria-hidden="true" style="margin-right: 10px;"></i>Teacher Leave Requests</h1></div>
			<div class='complaints_table'> <!-- table -->

			<?php
				$query = "SELECT * FROM `leave` WHERE Status <> 'ACCEPTED'";
				$result = mysqli_query($GLOBALS['conn'],$query); 
				if(mysqli_num_rows($result) > 0){

					echo "<table class='table table-hover table-bordered table-striped'>";
					echo "<thead>";
					echo "
					<tr>
        				<th>Leave ID</th>
        				<th>Teacher ID</th>
        				<th>Days</th>
        				<th>Reason</th>
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
						echo '<td>'.$row[4].'</td>';
						echo '<td>'.'<button class = "btn btn-small btn-success res_leave_btn" data-toggle="modal" data-target= "#respondLeaveModal" value ='.$value.'><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></td></tr>';
							}	
						echo "</tbody></table>";
					}
					else{

						echo "<div class='alert alert-success complaint_err' role='alert'>
							No Leave Requests! <span class='smile'>&#xf118;</span>
							</div>";
						}
					?>
				</div>
				<script>
					//When a stdnt edit reply button clicked
					$(".res_leave_btn").click(function() {
						document.cookie = "leave_id=;expires=Thu, 01 Jan 1970 00:00:00 UTC;"; //delete previous id cookie
    					var fired_button = $(this).val(); //get value of clicked button
    					document.cookie = "leave_id="+fired_button; //cr_Accnteate a cookie (user_id)
    					$('#leave_id').html(fired_button);
						});					
						
					</script>
			</div> <!-- table -->

			<!-- Modal for Student Accounts -->
			<div class="modal fade" id="respondLeaveModal" tabindex="-1" role="dialog" aria-labelledby="accntLabel2" aria-hidden="true">
  				<div class=modal-dialog role="document">
    			<div class="modal-content">
      				<div class="modal-header">
        				<h4 class="modal-title" id="accntLabel2">Respond to Leave Request (<span id = 'leave_id'></span>)</h4>
        				<strong><small style="color: #84469F;">*Select option below</small></strong>
        				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          				<span aria-hidden="true">&times;</span>
        				</button>
      				</div>
      			<div class="modal-body">

        			<form method="post" action= "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

  						<div class="form-group">
    						<label for="status">Course Withdraw Request Status</label>
    						<select class="form-control" id="status" name="status">
    							<option value="PENDING">PENDING</option>
   	 							<option value="ACCEPTED">ACCEPTED</option>
    							<option value="REJECTED">REJECTED</option>
    						</select>
  						</div>
  						
      			</div>
      			<div class="modal-footer">
        			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        			<button type="submit" class="btn btn-primary" name='respond_leave_req'>Update</button>
      			</div>
      			</form>
    			</div>
  				</div>
  			</div> 

  			
		</div>
	

	</div>


	</div> <!-- Main -->




</body>
</html>