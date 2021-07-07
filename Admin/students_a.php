
<?php 
	include_once('../Database/database.php');
	include('navside.php');
	include('functions.php');
	 
?>
<!DOCTYPE html>

<html>
<head>
		
	<title>Admin Portal</title>
	<!-- Changing active nav link color-->
	<script type="text/javascript">
		$(document).ready(function(){
			$('#students').css({
			color: '#EEEEEE'
			});
		})

	</script>

	<!------------------------------------------------------ FORM SUBMISSIONS ------------------------------------------------------------>

	<?php
	//Check if Add Student form submitted
	if(isset($_POST['add_student'])){
		$id = apply_filters($_POST['s_id']); //Store reply
		$name = apply_filters($_POST['name']); //Store reply
		$pasw = apply_filters($_POST['pasw']); //Store reply
		$contact = apply_filters($_POST['contact']); //Store reply
		$email = apply_filters($_POST['email']); //Store reply
		$address = apply_filters($_POST['address']); //Store reply
		$major = apply_filters($_POST['major']); //Store reply
		$gender = apply_filters($_POST['gender']); //Store reply
		$semester = apply_filters($_POST['semester']); //Store reply
		$year = apply_filters($_POST['year']); //Store reply
		
		if(add_student($id,$name,$contact,$email,$address,$major,$gender,$semester,$year,$pasw)){

			//Bootstrap close Alert
			$student_added = '<div class="alert alert-success alert-dismissible fade in updated">
    						<a href="#" class="close" data-dismiss="alert" aria-label="close" style="padding-top:15px;">&times;</a>
    						<strong>Success!</strong> New Student added.
  						</div>';
		}	
	} ?>

	<?php
	//Check if Student form submitted
	if(isset($_POST['edit_student'])){
		$col2set = array();
		$data = array();

		$name = apply_filters($_POST['name']); //Store reply
		if (strlen($name) > 0){
			array_push($col2set, 'Name');
			array_push($data, $name);
		}
		$contact = apply_filters($_POST['contact']); //Store reply
		if (strlen($contact) > 0){
			array_push($col2set, 'Contact');
			array_push($data, $contact);
		}
		$email = apply_filters($_POST['email']); //Store reply
		if (strlen($email) > 0){
			array_push($col2set, 'Email');
			array_push($data, $email);
		}
		$address = apply_filters($_POST['address']); //Store reply
		if (strlen($address) > 0){
			array_push($col2set, 'Address');
			array_push($data, $address);
		}
		$major = apply_filters($_POST['major']); //Store reply
		if (strlen($major) > 0){
			array_push($col2set, 'Major');
			array_push($data, $major);
		}
		$gender = apply_filters($_POST['gender']); //Store reply
		if (strlen($gender) > 0){
			array_push($col2set, 'Gender');
			array_push($data, $gender);
		}
		$year = apply_filters($_POST['year']); //Store reply
		if (strlen($year) > 0){
			array_push($col2set, 'Grad_year');
			array_push($data, $year);
		}
		
		if(update('student',$col2set,$data,'S_ID',$_COOKIE['s_id'])){

			//Bootstrap close Alert
			$updated_student = '<div class="alert alert-success alert-dismissible fade in updated">
    						<a href="#" class="close" data-dismiss="alert" aria-label="close" style="padding-top:15px;">&times;</a>
    						<strong>Success!</strong> Student Information has been updated.
  						</div>';
		}	
	}
	//Check if Student Account form submitted
	if(isset($_POST['update_account'])){
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
		if(update('login',$col2set,$data,'UserID',$_COOKIE['user_accnt_id'])){

			//Bootstrap close Alert
			$updated_stu_account = '<div class="alert alert-success alert-dismissible fade in updated">
    						<a href="#" class="close" data-dismiss="alert" aria-label="close" style="padding-top:15px;">&times;</a>
    						<strong>Success!</strong> Student Account Information has been updated.
  						</div>';
		}	
	}

	//Check if Feeform submitted

	if(isset($_POST['update_fee'])){
		$col2set = array();
		$data = array();

		$fee_total = apply_filters($_POST['fee_total']); //Store reply
		if (strlen($fee_total) > 0){
			array_push($col2set, 'TotalFee');
			array_push($data, $fee_total);
		}
		$reamaining_fee = apply_filters($_POST['remaining_fee']); //Store reply
		if (strlen($reamaining_fee) > 0){
			array_push($col2set, 'RemainingFee');
			array_push($data, $reamaining_fee);
		}
		$paid_fee = apply_filters($_POST['paid_fee']); //Store reply
		if (strlen($reamaining_fee) > 0){
			array_push($col2set, 'PaidFee');
			array_push($data, $paid_fee);
		}
		if(update('fee_detail',$col2set,$data,'S_ID',$_COOKIE['fee_accnt'])){

			//Bootstrap close Alert
			$updated_fee_details = '<div class="alert alert-success alert-dismissible fade in updated">
    						<a href="#" class="close" data-dismiss="alert" aria-label="close" style="padding-top:15px;">&times;</a>
    						<strong>Success!</strong> Student Fee Details have been updated.
  						</div>';
		}	
	}

	?>

	<!-------------------------------------------------------- FORM SUBMISSION END -------------------------------------------------------->
</head>
<body>

	<div style="margin-left: 20%; margin-top: 4%;"> <!-- main div -->

		<div class="row"> <!-- Row -->

			<div class="col-xs-8 col-md-12">
				<!-- Search form -->
				<div class="search_bar">
					<form  class='form-inline' method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
  					<input class="form-control" type="text" placeholder="Search Students by ID or Name...." required name='std_search'>
  						<button id='btn' class="btn btn-primary" name="search">&#xf002;</button>
  					</form>
				</div>
			</div>

			<!----------------------------- SEARCH RESULTS SECTION (Hidden) ----------------------------------->
		</div> <!-- Row -->

		<div class="row"> <!-- Row -->

			<div class = 'complaints col-xs-12 search_col' style="margin-left: 68px;">
					
				<div class="search_txt"><h1><span class="s_icon">&#xf002;</span>Search Results</h1></div>
				<div class='complaints_table'>

					<?php 
    				if (isset($_POST['search'])){
						$search = apply_filters($_POST['std_search']); //get value of search input
						for ($i=0; $i<strlen($search);$i++){// loop through char of search
							if ($search[$i]=='-'){ // if - found set flag
								$id = true;
							}
						}
						if(isset($id)){ // if id given in search
							$query = "SELECT * FROM Student WHERE S_ID = '$search'";
						}
						else{ // if name given in search
							$query = "SELECT * FROM Student WHERE Name = '$search'";
						}

						$result = mysqli_query($GLOBALS['conn'],$query);
						if(mysqli_num_rows($result) > 0){

							echo "<table class='table table-hover table-bordered table-striped'>";
							echo "<thead>";
							echo "
							<tr>
        						<th>Student ID</th>
        						<th>Name</th>
        						<th>Contact</th>
        						<th>Email</th>
        						<th>Address</th>
        						<th>Major</th>
        						<th>Gender</th>
        						<th>Semester</th>
        						<th>Grad Year</th>
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
								echo '<td>'.$row[7].'</td>';
								echo '<td>'.$row[8].'</td></tr>';
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
		

		<!----------------------------- STUDENTS SECTION ----------------------------------->

		<div class="row"> <!-- Row -->
			<?php 
			//Message if updated
				if (isset($updated_student)){
					echo $updated_student;
				}
				if (isset($student_added)){
					echo $student_added;
				}
				if(isset($_POST['add_student'])){
					if (!isset($student_added)){
						echo '<div class="alert alert-warning alert-dismissible fade in updated">
    						<a href="#" class="close" data-dismiss="alert" aria-label="close" style="padding-top:15px;">&times;</a>
    						<strong>Error!</strong> A Student with this ID already exists.
  						</div>';
					}
				}

				?>
			

			<div class = 'complaints col-xs-12' style="margin-left: 62px;">
					
				<div class="complaints_txt"><h1><span class="icons">&#Xf0c0;</span>All Students</h1>
					<div id='add_btn'>
						<button class ='btn btn-warning add' data-toggle="modal" data-target= "#addStudentModal">Add New &nbsp;&#xf067;</button>
					</div>
				</div>
				<!-- Modal for Teacher Complaints -->
			<div class="modal fade" id="addStudentModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
  				<div class=modal-dialog role="document">
    			<div class="modal-content">
      				<div class="modal-header">
        				<h4 class="modal-title" id="ModalLabel">Add New Student</h4>
        				<strong><small style="color: #84469F;">*All Fields are Required</small></strong>
        				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          				<span aria-hidden="true">&times;</span>
        				</button>
      				</div>
      			<div class="modal-body">

        			<form method="post" action= "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        				<div class="form-group">
    						<label for="s_id">Student ID</label>
    						<input class="form-control" id="s_id" name="s_id" placeholder="Enter Student ID (eg. S-000)" type="text" pattern="[S](-\d{3})" required></input>
  						</div>
  						<div class="form-group">
    						<label for="pasw">Student Password</label>
    						<input class="form-control" id="pasw" name="pasw" placeholder="Enter Student Password" type="text" required></input>
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
    						<label for="major">Major</label>
    						<input class="form-control" id="major" name="major" placeholder="Enter Major" type="text" required></input>
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
    						<label for="semester">Semester</label>
    						<input class="form-control" id="semester" name="semester" placeholder="Enter Student Semester" type="number" required></input>
  						</div>

  						<div class="form-group">
    						<label for="year">Graduation Year</label>
    						<input class="form-control" id="year" name="year" placeholder="Enter Graduation Year" type="text" required></input>
  						</div>


      			</div>
      			<div class="modal-footer">
        			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        			<button type="submit" class="btn btn-primary" name='add_student'>Add</button>
      			</div>
      			</form>
    			</div>
  				</div>
			</div> 
				<div class='complaints_table'>

					<?php
					$query = "SELECT * FROM Student";
					$result = mysqli_query($GLOBALS['conn'],$query); 
					if(mysqli_num_rows($result) > 0){

							echo "<table class='table table-hover table-bordered table-striped custom-scrollbar table-wrapper-scroll-y'>";
							echo "<thead>";
							echo "
							<tr>
        						<th>Student ID</th>
        						<th>Name</th>
        						<th>Contact</th>
        						<th>Email</th>
        						<th>Address</th>
        						<th>Major</th>
        						<th>Gender</th>
        						<th>Semester</th>
        						<th>Grad Year</th>
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
								echo '<td>'.$row[8].'</td>';
								echo '<td>'.'<button class = "btn btn-small btn-success stdnt" data-toggle="modal" data-target= "#studentModal" value ='.$value.'><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></td></tr>';
							}	
						echo "</tbody></table>";
					}
					else{

						echo "<div class='alert alert-danger complaint_err' role='alert'>
							No Students found! <span class='smile'>&#xf119;</span>
							</div>";
						}

					?>
				</div>
				<script>
					//When a stdnt edit reply button clicked
					$(".stdnt").click(function() {
						document.cookie = "s_id=;expires=Thu, 01 Jan 1970 00:00:00 UTC;"; //delete previous id cookie
    					var fired_button = $(this).val(); //get value of clicked button
    					document.cookie = "s_id="+fired_button; //create a cookie (s_id)
    					$('#std_id1').html(fired_button);
						});					
						
					</script>


			<!-- Modal for Student Complaints -->
			<div class="modal fade" id="studentModal" tabindex="-1" role="dialog" aria-labelledby="stdLabel1" aria-hidden="true">
  				<div class=modal-dialog role="document">
    			<div class="modal-content">
      				<div class="modal-header">
        				<h4 class="modal-title" id="stdLabel1">Edit Student Information (<span id = 'std_id1'></span>)</h4>
        				<strong><small style="color: #84469F;">*Enter fields you want to update</small></strong>
        				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          				<span aria-hidden="true">&times;</span>
        				</button>
      				</div>
      			<div class="modal-body">

        			<form method="post" action= "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

  						<div class="form-group">
    						<label for="name">Name</label>
    						<input class="form-control" id="name" name="name" placeholder="Enter Name" type="text"></input>
  						</div>
  						<div class="form-group">
    						<label for="contact">Contact</label>
    						<input class="form-control" id="contact" name="contact" placeholder="Enter Contact" type="tel"></input>
  						</div>
  						<div class="form-group">
    						<label for="email">Email</label>
    						<input class="form-control" id="email" name="email" placeholder="Enter Email" type="email"></input>
  						</div>
  						<div class="form-group">
    						<label for="address">Address</label>
    						<input class="form-control" id="address" name="address" placeholder="Enter Address" type="text"></input>
  						</div>
  						<div class="form-group">
    						<label for="major">Major</label>
    						<input class="form-control" id="major" name="major" placeholder="Enter Major" type="text"></input>
  						</div>
  						<div class="form-group">
    						<label for="gender">Gender</label>
    						<!-- <input class="form-control" id="gender" name="gender"></input> -->
    						<select class="form-control" id="gender" name="gender">
    							<option value="">Select</option>
   	 							<option value="Male">Male</option>
    							<option value="Female">Female</option>
    						</select>
  						</div>
  						<div class="form-group">
    						<label for="year">Graduation Year</label>
    						<input class="form-control" id="year" name="year" placeholder="Enter Graduation Year" type="text"></input>
  						</div>


      			</div>
      			<div class="modal-footer">
        			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        			<button type="submit" class="btn btn-primary" name='edit_student'>Update</button>
      			</div>
      			</form>
    			</div>
  				</div>
  			</div>
			</div> 
		</div><!-- Row -->

		<!----------------------------- STUDENTS Accounts SECTION ----------------------------------->
			
		<div class="row"> <!-- Row --> 
			<?php 
				//Message if updated
				if (isset($updated_stu_account)){
					echo $updated_stu_account;
				} ?>
			
			<div class = 'accnt complaints col-xs-12' style="margin-left: 68px;">
			<div class="complaints_txt" style="background-color: #17B8B8;"><h1><i class="fa fa-user-circle-o accnt_icon" aria-hidden="true"></i>Student Accounts</h1></div>
			<div class='complaints_table'> <!-- table -->

			<?php
				$query = "SELECT UserID, Pasw, Is_Block FROM login WHERE account_type = 2";
				$result = mysqli_query($GLOBALS['conn'],$query); 
				if(mysqli_num_rows($result) > 0){

					echo "<table class='table table-hover table-bordered table-striped'>";
					echo "<thead>";
					echo "
					<tr>
        				<th>Student ID</th>
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
						echo '<td>'.'<button class = "btn btn-small btn-success stu_accnt_btn" data-toggle="modal" data-target= "#AccountsModal" value ='.$value.'><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></td></tr>';
							}	
						echo "</tbody></table>";
					}
					else{

						echo "<div class='alert alert-danger complaint_err' role='alert'>
							No Student Accounts found! <span class='smile'>&#xf119;</span>
							</div>";
						}

					?>
				</div>
				<script>
					//When a stdnt edit reply button clicked
					$(".stu_accnt_btn").click(function() {
						document.cookie = "user_accnt_id=;expires=Thu, 01 Jan 1970 00:00:00 UTC;"; //delete previous id cookie
    					var fired_button = $(this).val(); //get value of clicked button
    					document.cookie = "user_accnt_id="+fired_button; //cr_Accnteate a cookie (user_id)
    					$('#std_id_txt').html(fired_button);
						});					
						
					</script>
			</div> <!-- table -->

			<!-- Modal for Student Accounts -->
			<div class="modal fade" id="AccountsModal" tabindex="-1" role="dialog" aria-labelledby="accntLabel" aria-hidden="true">
  				<div class=modal-dialog role="document">
    			<div class="modal-content">
      				<div class="modal-header">
        				<h4 class="modal-title" id="accntLabel">Edit Student Account Information (<span id = 'std_id_txt'></span>)</h4>
        				<strong><small style="color: #84469F;">*Enter fields you want to update</small></strong>
        				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          				<span aria-hidden="true">&times;</span>
        				</button>
      				</div>
      			<div class="modal-body">

        			<form method="post" action= "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

  						<div class="form-group">
    						<label for="pasw">Student Password</label>
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
        			<button type="submit" class="btn btn-primary" name='update_account'>Update</button>
      			</div>
      			</form>
    			</div>
  				</div>
  			</div>
		</div><!-- ROW -->


		<!----------------------------- STUDENTS FEE DETAILS SECTION ----------------------------------->
			
		<div class="row"> <!-- Row -->
		<?php 
				//Message if updated
				if (isset($updated_fee_details)){
					echo $updated_fee_details;
				} ?>
			
			<div class = 'accnt complaints col-xs-12' style="margin-left: 68px;">
			<div class="complaints_txt" style="background-color: #141414;"><h1><i class="fa fa-money icons" aria-hidden="true"></i>Student Fee Details</h1></div>
			<div class='complaints_table'> <!-- table -->

			<?php
				$query = "SELECT * FROM fee_detail";
				$result = mysqli_query($GLOBALS['conn'],$query); 
				if(mysqli_num_rows($result) > 0){

					echo "<table class='table table-hover table-bordered table-striped'>";
					echo "<thead>";
					echo "
					<tr>
        				<th>Student ID</th>
        				<th>Total Fee</th>
        				<th>Remaining Fee</th>
        				<th>Paid Fee</th>
        				<th>Semester</th>
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
						echo '<td>'.'<button class = "btn btn-small btn-success accnt_btn" data-toggle="modal" data-target= "#feeModal" value ='.$value.'><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></td></tr>';
							}	
						echo "</tbody></table>";
					}
					else{

						echo "<div class='alert alert-danger complaint_err' role='alert'>
							No Student Accounts found! <span class='smile'>&#xf119;</span>
							</div>";
						}

					?>
				</div>
				<script>
					//When a stdnt edit reply button clicked
					$(".accnt_btn").click(function() {
						document.cookie = "fee_accnt=;expires=Thu, 01 Jan 1970 00:00:00 UTC;"; //delete previous id cookie
    					var fired_button = $(this).val(); //get value of clicked button
    					document.cookie = "fee_accnt="+fired_button; //cr_Accnteate a cookie (user_id)
    					$('#fee_std_id').html(fired_button);
						});					
						
					</script>
			</div> <!-- table -->

			<!-- Modal for Student Accounts -->
			<div class="modal fade" id="feeModal" tabindex="-1" role="dialog" aria-labelledby="accntLabel2" aria-hidden="true">
  				<div class=modal-dialog role="document">
    			<div class="modal-content">
      				<div class="modal-header">
        				<h4 class="modal-title" id="accntLabel2">Edit Student Fee Details (<span id = 'fee_std_id'></span>)</h4>
        				<strong><small style="color: #84469F;">*Enter fields you want to update</small></strong>
        				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          				<span aria-hidden="true">&times;</span>
        				</button>
      				</div>
      			<div class="modal-body">

        			<form method="post" action= "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

  						<div class="form-group">
    						<label for="fee_total">Total Fee</label>
    						<input class="form-control" id="fee_total" name="fee_total" placeholder="Enter total fee" type="number"></input>
  						</div>
  						<div class="form-group">
    						<label for="remaining_fee">Remaining Fee</label>
    						<input class="form-control" id="remaining_fee" name="remaining_fee" placeholder="Enter Remaining fee" type="number"></input>
  						</div>
  						<div class="form-group">
    						<label for="paid_fee">Paid Fee</label>
    						<input class="form-control" id="paid_fee" name="paid_fee" placeholder="Enter fee Paid by Student" type="number"></input>
  						</div>
  						
      			</div>
      			<div class="modal-footer">
        			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        			<button type="submit" class="btn btn-primary" name='update_fee'>Update</button>
      			</div>
      			</form>
    			</div>
  				</div>
  			</div> 


		</div> <!-- ROW -->

		
	</div> <!-- main div -->

</body>
</html>