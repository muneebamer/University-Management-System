	
<?php 
	include_once('../Database/database.php');
	include('navside.php'); 
	include('functions.php');
?>

<!DOCTYPE html>
<html>
<head>
	<title>Student Portal</title>
	<script type="text/javascript">
		//Changing active nav link color
		$(document).ready(function(){
			$('#internship').css({
			color: '#EEEEEE'
			});
		})

	</script>
</head>
<?php
	
	//Check if Register course form submitted
	if(isset($_POST['req_internship'])){
		
		if(apply_internship($_COOKIE['intern_id'])){

			//Bootstrap close Alert
			$int_applied = '<div class="alert alert-success alert-dismissible fade in updated">
    						<a href="#" class="close" data-dismiss="alert" aria-label="close" style="padding-top:15px;">&times;</a>
    						<strong>Success!</strong> Applied for Internship successfully.
  						</div>';
		}

	} ?>

<body>
	
	<div style="margin-left: 20%; margin-top: 4%;"> <!-- main div -->
		<div class="row">
		<?php 

				//Message if updated
				if (isset($int_applied)){
					echo $int_applied;
				}
				if(isset($_POST['req_internship'])){
					if (!isset($int_applied)){
						echo '<div class="alert alert-warning alert-dismissible fade in updated">
    						<a href="#" class="close" data-dismiss="alert" aria-label="close" style="padding-top:15px;">&times;</a>
    						<strong>Error!</strong> You have already applied for this Internship.
  						</div>';
					}
				}

				 ?>
			
			<div class = 'accnt addCourses col-xs-12' style="margin-left: 30px;">
			<div class="complaints_txt" style="background-color: #141414;"><h1><i class='fa fa-bullhorn icons' aria-hidden="true"></i>All Internships</h1></div>
			<div class='complaints_table'> <!-- table -->

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
        				<th>Apply</th>
      				</tr>
    				</thead>
    				<tbody><tr>";
    				while ($row = mysqli_fetch_row($result)) {
    					$i_id = $row[0];
						echo '<td>'.$row[0].'</td>';
						echo '<td>'.$row[1].'</td>';
						echo '<td>'.$row[2].'</td>';
						echo '<td>'.$row[3].'</td>';
						echo '<td>'.$row[4].'</td>';
						echo '<td>'.'<button class = "btn btn-small btn-primary apply_btn" data-toggle="modal" data-target= "#applyModal" value ='.$i_id.'><i class="fa fa-plus-circle" aria-hidden="true"></i></button></td></tr>';
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
				$(".apply_btn").click(function() {
					document.cookie = "intern_id=;expires=Thu, 01 Jan 1970 00:00:00 UTC;"; //delete previous id cookie
    				var fired_button = $(this).val(); //get value of clicked button
    				document.cookie = "intern_id="+fired_button; //create a cookie (intern_id)
    				$('#intern_id').html(fired_button);
    				$('#internship_id').html(fired_button);
					});					
						
			</script>

			<!-- Modal for Student Complaints -->
			<div class="modal fade" id="applyModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  				<div class=modal-dialog role="document">
    			<div class="modal-content">
      				<div class="modal-header">
        				<h4 class="modal-title" id="exampleModalLabel">Confirm Internship (IID: <span id = 'intern_id'></span>)</h4>
        				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          				<span aria-hidden="true">&times;</span>
        				</button>
      				</div>
      			<div class="modal-body">
        			<form method="post" action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>>
        				
        			<h5> Are you sure you want to register <span id='internship_id' style="color: #46B141;"></span></h5>

      			</div>
      			
      			<div class="modal-footer">
        			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        			<button type="submit" class="btn btn-primary" name='req_internship'>Yes</button>
      			</div>
      			</form>
    			</div>
  				</div>
			</div> 
		</div> <!-- ROW -->



		<!--------------------- APPLIED INTERNSHIPS ------------------------------>
		<div class="row">

			<div class="col-xs-8 col-md-12">

				<div class = 'complaints col-xs-12'>
					
					<div class="complaints_txt2" style="background-color: #5F1A4D;"><h1><span class="icon_reg">&#xf046;</span>Applied Internships</h1>
					</div>
					<div class='complaints_table'>
						<?php
						$sid = $_SESSION['S_ID'];
						$query = "SELECT Application_ID, I_ID, Status FROM apply_internship WHERE S_ID = '$sid'";
							$result = mysqli_query($GLOBALS['conn'],$query);  
							
							if(mysqli_num_rows($result) > 0){

							echo "<table class='table table-hover table-bordered table-striped'>";
							echo "<thead>";
							echo "
							<tr>
        						<th>Application ID</th>
        						<th>Internship ID</th>
        						<th>Status</th>
      						</tr>
    						</thead>
    						<tbody><tr>";
    						while ($row = mysqli_fetch_row($result)) {
    							$value = $row[0];
								echo '<td>'.$row[0].'</td>';
								echo '<td>'.$row[1].'</td>';
								echo '<td>'.$row[2].'</td></tr>';
							}	
						echo "</tbody></table>";
					}
					else{
						echo "<div class='alert alert-danger complaint_err' role='alert'>
							No Applied Internships! <span class='smile'>&#xf119;</span>
							</div>";
					}
						?>
									
					</div>
				</div>
			</div>


		</div> <!-- ROW -->
				
			

	</div> <!-- Main Div> -->
</body>




</html>