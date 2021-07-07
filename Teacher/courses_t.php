<?php 
	include_once('../Database/database.php');
	include_once('functions.php');
	include_once('navside.php');
?>

<!DOCTYPE html>

<html>
<head>
	<title>Courses - Teacher</title>

	<script type="text/javascript">
		//Changing active nav link color
		$(document).ready(function(){
			$('#courses').css({
			color: '#EEEEEE'
			});
		})
	</script>

	<?php
	if(isset($_POST['req_course'])){
		$course = apply_filters($_POST['course']);

		if (request_course($course)){
			$req_added = '<div class="alert alert-success alert-dismissible fade in updated">
    						<a href="#" class="close" data-dismiss="alert" aria-label="close" style="padding-top:15px;">&times;</a>
    						<strong>Success!</strong> Course Offer Requested.
  						</div>';
		}
	}
	?>

</head>
<body>
	<div class = 'row' style="margin-top: 50px;">
		<div class="col-xs-8 col-md-12">
			<div class = 'complaints col-xs-12'>
					
				<div class="complaints_txt2" style="background-color: #17B8B8;"><h1><span class="icon_tchr" style="margin-right: 10px;">&#Xf02d;</span>Teacher Courses</h1>
				</div>

					<div class='complaints_table'>
						<?php
							$t_courses = get_teacher_courses();
							//Error if function return false
							if (!$t_courses){
								echo "<div class='alert alert-info complaint_err' role='alert'>
								No Courses at the moment! <span class='smile'>&#xf118;</span>
								</div>";
							}
							//Create Table
							else{
								echo "<table class='table table-hover table-bordered table-striped'>";
								echo "<thead>";
								echo "
								<tr>
        							<th>Course ID</th>
        							<th>Section ID</th>
        							<th>Teacher ID</th>
        							<th>Seats Offered</th>
        							<th>Seats Available</th>
        							<th>Room</th>
        							<th>Days</th>
        							<th>Timing</th>
      							</tr>
    							</thead>
    							<tbody>
								";
								//Count number of entries
								$n = count($t_courses);
								for($i=0;$i<$n;$i++) { //Echo data in table
      								echo '<tr>';
      								$id = $t_courses[$i][0];
      								$value = (string)$id;
      								echo '<td>'. $t_courses[$i][0]. '</td>';
      								echo '<td>'. $t_courses[$i][1]. '</td>';
      								echo '<td>'. $t_courses[$i][2]. '</td>';
      								echo '<td>'. $t_courses[$i][3]. '</td>';
      								echo '<td>'. $t_courses[$i][4]."</td>";
      								echo '<td>'. $t_courses[$i][5]."</td>";
      								echo '<td>'. $t_courses[$i][6]."</td>";
      								echo '<td>'. $t_courses[$i][7]."</td>";
      								echo '</tr>';
      							}
      							echo "</tbody></table>";

							}
						?>
									
					</div>
				</div>
			</div>
		</div>

	<div class="row">
		<div class="col-xs-8 col-md-12">

		<div class = 'complaints col-xs-12'>
					
				<div class="complaints_txt2" style="background-color: #34B048;"><h1><span style="margin-right: 10px;">&#xf0f3;</span>Available Courses</h1></div>

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
								echo '<td>'.$row[5].'</td></tr>';
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
			</div>
		</div>



	</div>



<div class = 'row'>
					<div class="col-xs-8 col-md-12">
				<?php 
					if (isset($req_added)){
					 echo $req_added;
					}

					if(isset($_POST['req_course'])){
					if (!isset($req_added)){
						echo '<div class="alert alert-warning alert-dismissible fade in updated">
    						<a href="#" class="close" data-dismiss="alert" aria-label="close" style="padding-top:15px;">&times;</a>
    						<strong>Error!</strong> Course is already requested or The course ID is not valid.
  						</div>';
					}
				}

					?>
				<div class = 'complaints col-xs-12' style="width: 60%; margin-left:370px;">
					
					<div class="complaints_txt2" style="background-color: #AD5CFE;"><h1><span class="icon_tchr" style="margin-right: 10px;">&#Xf2b6;</span>Course Offer Request</h1>
						<div id='add_btn'>
						<button class ='btn btn-warning add' data-toggle="modal" data-target= "#courseOfferModal">Add New &nbsp;&#xf067;</button>
						</div>
					</div>
					<div class="modal fade" id="courseOfferModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
  				<div class=modal-dialog role="document">
    			<div class="modal-content">
      				<div class="modal-header">
        				<h4 class="modal-title" id="ModalLabel">Course Offer Request</h4>
        				<strong><small style="color: #84469F;">*All Fields are Required</small></strong>
        				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          				<span aria-hidden="true">&times;</span>
        				</button>
      				</div>
      			<div class="modal-body">

        			<form method="post" action= <?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>>
        				<div class="form-group">
    						<label for="course">Course</label>
    						<input class="form-control" id="course" name="course" placeholder="Enter Course ID e.g COMP300" type="text" required></input>
  						</div>
      			</div>
      			<div class="modal-footer">
        			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        			<button type="submit" class="btn btn-primary" name='req_course'>Request</button>
      			</div>
      			</form>
    			</div>
  				</div>
			</div>

					<div class='complaints_table'>
						<?php
							$t_requests = get_teacher_requests();
							//Error if function return false
							if (!$t_requests){
								echo "<div class='alert alert-info complaint_err' role='alert'>
								No course requests at the moment! <span class='smile'>&#xf118;</span>
								</div>";
							}
							//Create Table
							else{
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
    							<tbody>
								";
								//Count number of entries
								$n = count($t_requests);
								for($i=0;$i<$n;$i++) { //Echo data in table
      								echo '<tr>';
      								$id = $t_requests[$i][0];
      								$value = (string)$id;
      								echo '<td>'. $t_requests[$i][0]. '</td>';
      								echo '<td>'. $t_requests[$i][1]. '</td>';
      								echo '<td>'. $t_requests[$i][2]. '</td>';
      								echo '<td>'. $t_requests[$i][3]. '</td>';
      								echo '</tr>';
      							}
      							echo "</tbody></table>";

							}
						?>
									
					</div>
				</div>
			</div>
</body>
</html>