
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
		//Set Active Nav link
		$(document).ready(function(){
			$('#internship').css({
			color: '#EEEEEE'
			});
		})

	</script>

	<!------------------ FORM SUBMISSIOINS --------------------->
	<?php
	//Check if Add Student form submitted
	if(isset($_POST['add_internship'])){
		$id = apply_filters($_POST['i_id']); //Store reply
		$title = apply_filters($_POST['title']); //Store reply
		$location = apply_filters($_POST['location']); //Store reply
		$duration = apply_filters($_POST['duration']); //Store reply
		$is_paid = apply_filters($_POST['i_status']); //Store reply
		
		if(add_internship(array($id,$title,$location,$duration,$is_paid))){

			//Bootstrap close Alert
			$i_added = '<div class="alert alert-success alert-dismissible fade in updated">
    						<a href="#" class="close" data-dismiss="alert" aria-label="close" style="padding-top:15px;">&times;</a>
    						<strong>Success!</strong> New Internship added.
  						</div>';
		}	
	} ?>

	<?php //Check if Internship Request form Submitted

	if (isset($_POST['update_intern'])){
		$col2set = array('Status');
		$data = array();

		$status = apply_filters($_POST['status']);
		array_push($data, $status);

		if(update('apply_internship',$col2set,$data,'Application_ID',$_COOKIE['int_req_id'])){

			//Bootstrap close Alert
			$int_req_updated = '<div class="alert alert-success alert-dismissible fade in updated">
    						<a href="#" class="close" data-dismiss="alert" aria-label="close" style="padding-top:15px;">&times;</a>
    						<strong>Success!</strong> Internship Request Status has been Updated.
  						</div>';

		}

	}

	 ?>


	<?php
	//Check if Edit Internship form submitted
	if(isset($_POST['edit_internship'])){
		$col2set = array();
		$data = array();

		$title = apply_filters($_POST['title']); //Store reply
		if (strlen($title) > 0){
			array_push($col2set, 'title');
			array_push($data, $title);
		}
		$location = apply_filters($_POST['location']); //Store reply
		if (strlen($location) > 0){
			array_push($col2set, 'location');
			array_push($data, $location);
		}
		$duration = apply_filters($_POST['duration']); //Store reply
		if (strlen($duration) > 0){
			array_push($col2set, 'duration');
			array_push($data, $duration);
		}
		$is_paid = apply_filters($_POST['i_status']); //Store reply
		if (strlen($is_paid) > 0){
			array_push($col2set, 'isPaid');
			array_push($data, $is_paid);
		}
		
		if(update('internship',$col2set,$data,'I_ID',$_COOKIE['int_id'])){

			//Bootstrap close Alert
			$i_edited = '<div class="alert alert-success alert-dismissible fade in updated">
    						<a href="#" class="close" data-dismiss="alert" aria-label="close" style="padding-top:15px;">&times;</a>
    						<strong>Success!</strong> Internship has been updated.
  						</div>';
		}	
	} ?>
</head>
<body>

	<div style="margin-left: 20%; margin-top: 4%;"> <!-- main div -->

		<div class="row"> <!-- Row -->
			<?php //Display message if Internship added

			if (isset($i_added)){
				echo $i_added;
			}
			if (isset($_POST['add_internship'])){
				if(!isset($i_added)){
					echo '<div class="alert alert-warning alert-dismissible fade in updated">
    						<a href="#" class="close" data-dismiss="alert" aria-label="close" style="padding-top:15px;">&times;</a>
    						<strong>Error!</strong> This Internship already exists.
  						</div>';

				}
			}
			if (isset($i_edited)){
				echo $i_edited;
			}


			?>

			<div class = 'complaints col-xs-12' style="margin-left: 62px;">
					
				<div class="complaints_txt" style="background-color: #1CC48F;"><h1><span style="margin-right: 15px;">&#xf0a1; </span>All Internships</h1>
					<div id='add_btn'>
						<button class ='btn btn-success add' data-toggle="modal" data-target= "#addInternshipModal">Add New &nbsp;&#xf067;</button>
					</div>
				</div>
				<!-- Modal for adding Student -->
			<div class="modal fade" id="addInternshipModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
  				<div class=modal-dialog role="document">
    			<div class="modal-content">
      				<div class="modal-header">
        				<h4 class="modal-title" id="ModalLabel">Add New Internship</h4>
        				<strong><small style="color: #84469F;">*All Fields are Required</small></strong>
        				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          				<span aria-hidden="true">&times;</span>
        				</button>
      				</div>
      			<div class="modal-body">

        			<form method="post" action= "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        				<div class="form-group">
    						<label for="i_id">Internship ID</label>
    						<input class="form-control" id="i_id" name="i_id" placeholder="Enter Internship ID (eg. I-01)" pattern="[I](-\d{2})" type="text" required></input>
  						</div>
  						<div class="form-group">
    						<label for="title">Title</label>
    						<input class="form-control" id="title" name="title" placeholder="Enter Internship Title" type="text" required></input>
  						</div>
  						<div class="form-group">
    						<label for="location">Location</label>
    						<input class="form-control" id="location" name="location" placeholder="Enter Internship Location" type="text" required></input>
  						</div>
  						<div class="form-group">
    						<label for="duration">Duration</label>
    						<input class="form-control" id="duration" name="duration" placeholder="Enter Duration of Internship" type="text" required></input>
  						</div>
  						<div class="form-group">
  							<label for="i_status">Is Paid?</label>
  							<select class="form-control" id="i_status" name="i_status" >
    							<option value="">SELECT</option>
   	 							<option value="YES">YES</option>
    							<option value="NO">NO</option>
    						</select>
    					</div>

      			</div>
      			<div class="modal-footer">
        			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        			<button type="submit" class="btn btn-primary" name='add_internship'>Add</button>
      			</div>
      			</form>
    			</div>
  				</div>
			</div> 

				<div class='complaints_table '>

					<?php
					$query = "SELECT * FROM internship";
					$result = mysqli_query($GLOBALS['conn'],$query); 
					if(mysqli_num_rows($result) > 0){

							echo "<table class='table table-hover table-bordered table-striped'>";
							echo "<thead>";
							echo "
							<tr>
        						<th>Internship ID</th>
        						<th>Title</th>
        						<th>Location</th>
        						<th>Duration</th>
        						<th>Is Paid</th>
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
								echo '<td>'.'<button class = "btn btn-small btn-success intern_btn" data-toggle="modal" data-target= "#internModal" value ='.$value.'><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></td></tr>';
							}	
						echo "</tbody></table>";
					}
					else{

						echo "<div class='alert alert-danger complaint_err' role='alert'>
							No Internships found! <span class='smile'>&#xf119;</span>
							</div>";
						}

					?>
				</div>
				<script>
					//When a stdnt edit reply button clicked
					$(".intern_btn").click(function() {
						document.cookie = "int_id=;expires=Thu, 01 Jan 1970 00:00:00 UTC;"; //delete previous id cookie
    					var fired_button = $(this).val(); //get value of clicked button
    					document.cookie = "int_id="+fired_button; //create a cookie (crs_id)
    					$('#int_id').html(fired_button);
						});					
						
					</script>

				<!-- Modal for Student Complaints -->
			<div class="modal fade" id="internModal" tabindex="-1" role="dialog" aria-labelledby="stdLabel1" aria-hidden="true">
  				<div class=modal-dialog role="document">
    			<div class="modal-content">
      				<div class="modal-header">
        				<h4 class="modal-title" id="stdLabel1">Edit Internship (<span id = 'int_id'></span>)</h4>
        				<strong><small style="color: #84469F;">*Enter fields you want to update</small></strong>
        				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          				<span aria-hidden="true">&times;</span>
        				</button>
      				</div>
      			<div class="modal-body">

        			<form method="post" action= "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        	
  						<div class="form-group">
    						<label for="title">Internship Title</label>
    						<input class="form-control" id="title" name="title" placeholder="Enter Internship Title" type="text"></input>
  						</div>
  						<div class="form-group">
    						<label for="location">Location</label>
    						<input class="form-control" id="location" name="location" placeholder="Enter Internship Location" type="text"></input>
  						</div>
  						<div class="form-group">
    						<label for="duration">Duration</label>
    						<input class="form-control" id="duration" name="duration" placeholder="Enter Duration of Internship" type="text"></input>
  						</div>
  						<div class="form-group">
  							<label for="i_status">Is Paid?</label>
  							<select class="form-control" id="i_status" name="i_status" >
    							<option value="">SELECT</option>
   	 							<option value="YES">YES</option>
    							<option value="NO">NO</option>
    						</select>
    					</div>


      			</div>
      			<div class="modal-footer">
        			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        			<button type="submit" class="btn btn-primary" name='edit_internship'>Add</button>
      			</div>
      			</form>
    			</div>
  				</div>
  			</div>
			</div> 
		</div><!-- Row -->

		<!----------------------------- Internship REQUESTS SECTION ----------------------------------->
			
		<div class="row"> <!-- Row -->
		<?php 
				//Message if updated
				if (isset($int_req_updated)){
					echo $int_req_updated;
				} ?>
			
			<div class = 'accnt complaints col-xs-12' style="margin-left: 68px;">
			<div class="complaints_txt" style="background-color: #141414;"><h1><i class='fa fa-bookmark icons' aria-hidden="true"></i>Internship Requests</h1></div>
			<div class='complaints_table'> <!-- table -->

			<?php
				$query = "SELECT * FROM apply_internship";
				$result = mysqli_query($GLOBALS['conn'],$query); 
				if(mysqli_num_rows($result) > 0){

					echo "<table class='table table-hover table-bordered table-striped'>";
					echo "<thead>";
					echo "
					<tr>
        				<th>Application ID</th>
        				<th>Student ID</th>
        				<th>Internship ID</th>
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
						echo '<td>'.'<button class = "btn btn-small btn-success intern_btn" data-toggle="modal" data-target= "#irequestModal" value ='.$value.'><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></td></tr>';
							}	
						echo "</tbody></table>";
					}
					else{

						echo "<div class='alert alert-danger complaint_err' role='alert'>
							No Internship Requests! <span class='smile'>&#xf119;</span>
							</div>";
						}
					?>
				</div>
				<script>
					//When a internship edit reply button clicked
					$(".intern_btn").click(function() {
						document.cookie = "int_req_id=;expires=Thu, 01 Jan 1970 00:00:00 UTC;"; //delete previous id cookie
    					var fired_button = $(this).val(); //get value of clicked button
    					document.cookie = "int_req_id="+fired_button; //cr_Accnteate a cookie (user_id)
    					$('#int_req_id').html(fired_button);
						});					
						
					</script>
			</div> <!-- table -->

			<!-- Modal for Internship Request Status -->
			<div class="modal fade" id="irequestModal" tabindex="-1" role="dialog" aria-labelledby="accntLabel2" aria-hidden="true">
  				<div class=modal-dialog role="document">
    			<div class="modal-content">
      				<div class="modal-header">
        				<h4 class="modal-title" id="accntLabel2">Respond to Request (<span id = 'int_req_id'></span>)</h4>
        				<strong><small style="color: #84469F;">*Select option below</small></strong>
        				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          				<span aria-hidden="true">&times;</span>
        				</button>
      				</div>
      			<div class="modal-body">

        			<form method="post" action= "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

  						<div class="form-group">
    						<label for="status">INternship Request Status</label>
    						<!-- <input class="form-control" id="gender" name="gender"></input> -->
    						<select class="form-control" id="status" name="status">
    							<option value="PENDING">PENDING</option>
   	 							<option value="ACCEPTED">APPROVED</option>
    							<option value="REJECTED">REJECTED</option>
    						</select>
  						</div>
  						
      			</div>
      			<div class="modal-footer">
        			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        			<button type="submit" class="btn btn-primary" name='update_intern'>Update</button>
      			</div>
      			</form>
    			</div>
  				</div>
  			</div> 


		</div> <!-- ROW -->

	</div> <!-- Main -->




</body>
</html>