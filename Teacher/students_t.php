<?php 
	include_once('../Database/database.php');
	include('functions.php');
	include('navside.php'); 
?>

<!DOCTYPE html>

<html>
<head>
	<title>Students - Teacher</title>
	<script type="text/javascript">
		$(document).ready(function(){
			$('#students').css({
			color: '#EEEEEE'
			});
		})

	</script>

	<?php
	//Check if Add Student form submitted
	if(isset($_POST['grade_course'])){
		$student_id = apply_filters($_POST['stuId']); //Store reply
		$sec_id = apply_filters($_POST['secId']); //Store reply
		$grade = apply_filters($_POST['grade']); //Store reply
		
		if(give_grade($student_id,$sec_id,$grade)){

			//Bootstrap close Alert
			$grade_added = '<div class="alert alert-success alert-dismissible fade in updated">
    						<a href="#" class="close" data-dismiss="alert" aria-label="close" style="padding-top:15px;">&times;</a>
    						<strong>Success!</strong> Grade added.
  						</div>';
		}	
	} ?>

	<?php

	if (isset($_POST['update_withdraw'])){
		$status = apply_filters($_POST['status']);

		if(respond_withdraw($_COOKIE['wtd_id'],$status)){

			//Bootstrap close Alert
			$withdraw_updated = '<div class="alert alert-success alert-dismissible fade in updated">
    						<a href="#" class="close" data-dismiss="alert" aria-label="close" style="padding-top:15px;">&times;</a>
    						<strong>Success!</strong> Course Withdraw Request Status has been Updated.
  						</div>';

		}

	}

	 ?>
</head>
<body>
	<div class = 'row' style="margin-top: 50px;">
		<div class="col-xs-8 col-md-12">

			<?php 
					if (isset($grade_added)){
					 echo $grade_added;
					}

					if(isset($_POST['grade_course'])){
					if (!isset($grade_added)){
						echo '<div class="alert alert-warning alert-dismissible fade in updated">
    						<a href="#" class="close" data-dismiss="alert" aria-label="close" style="padding-top:15px;">&times;</a>
    						<strong>Error!</strong> Student ID/Section ID is not correct or It is graded already.
  						</div>';
					}
				}

					?>

			<div class = 'complaints col-xs-12'>
					
				<div class="complaints_txt2" style="background-color: #17B8B8;"><h1><span class="icon_tchr" style="margin-right: 10px;">&#Xf0c0;</span>Enrolled Students</h1>
					<div id='add_btn'>
					<button class ='btn btn-warning add' data-toggle="modal" data-target= "#gradeStudentModal">Grade &nbsp;&#xf067;</button></div>
				</div>

				<div class="modal fade" id="gradeStudentModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
  				<div class=modal-dialog role="document">
    			<div class="modal-content">
      				<div class="modal-header">
        				<h4 class="modal-title" id="ModalLabel">Grade Student</h4>
        				<strong><small style="color: #84469F;">*All Fields are Required</small></strong>
        				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          				<span aria-hidden="true">&times;</span>
        				</button>
      				</div>
      			<div class="modal-body">

        			<form method="post" action= <?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>>
        				<div class="form-group">
    						<label for="stuId">Student ID</label>
    						<input class="form-control" id="stuId" name="stuId" placeholder="Enter Student ID e.g S-101" type="text" required></input>
  						</div>
  						<div class="form-group">
    						<label for="secId">Section ID</label>
    						<input class="form-control" id="secId" name="secId" placeholder="Enter Section ID e.g COMP300-A" type="text" required></input>
  						</div>
  						<div class="form-group">
    						<label for="grade">Grade</label>
    						<select class="form-control" id="grade" name="grade">
    							<option value="A">A</option>
   	 							<option value="A-">A-</option>
    							<option value="B+">B+</option>
    							<option value="B">B</option>
    							<option value="B-">B-</option>
    							<option value="C+">C+</option>
    							<option value="C">C</option>
    							<option value="C-">C-</option>
    							<option value="D+">D+</option>
    							<option value="D">D</option>
    							<option value="F">F</option>
    						</select>
  						</div>
      			</div>
      			<div class="modal-footer">
        			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        			<button type="submit" class="btn btn-primary" name='grade_course'>Grade</button>
      			</div>
      			</form>
    			</div>
  				</div>
			</div>

					<div class='complaints_table'>
						<?php
							$t_enrolled = enrolled_students();
							//Error if function return false
							if (!$t_enrolled){
								echo "<div class='alert alert-info complaint_err' role='alert'>
								No students enrolled at the moment! <span class='smile'>&#xf118;</span>
								</div>";
							}
							//Create Table
							else{
								echo "<table class='table table-hover table-bordered table-striped'>";
								echo "<thead>";
								echo "
								<tr>
        							<th>Student ID</th>
        							<th>Student Name</th>
        							<th>Section ID</th>
        							<th>Course ID</th>
        							<th>Course Name</th>
        							<th>Grade</th>
      							</tr>
    							</thead>
    							<tbody>
								";
								//Count number of entries
								$n = count($t_enrolled);
								for($i=0;$i<$n;$i++) { //Echo data in table
      								echo '<tr>';
      								$id = $t_enrolled[$i][0];
      								$value = (string)$id;
      								echo '<td>'. $t_enrolled[$i][0]. '</td>';
      								echo '<td>'. $t_enrolled[$i][1]. '</td>';
      								echo '<td>'. $t_enrolled[$i][2]. '</td>';
      								echo '<td>'. $t_enrolled[$i][3]. '</td>';
      								echo '<td>'. $t_enrolled[$i][4]."</td>";
      								echo '<td>'. $t_enrolled[$i][5]."</td>";
      								echo '</tr>';
      							}
      							echo "</tbody></table>";

							}
						?>
									
					</div>
				</div>
			</div>
		</div>


			<div class="row"> <!-- Row -->
		<?php 
				//Message if updated
				if (isset($withdraw_updated)){
					echo $withdraw_updated;
				} ?>
			
			<div class = 'accnt complaints col-xs-12' style="width:60%;margin-left: 385px;">
			<div class="complaints_txt2" style="background-color: #141414;"><h1><i class='fa fa-bookmark icons' aria-hidden="true" style="margin-right: 10px;"></i>Withdraw Requests</h1></div>
			<div class='complaints_table'> <!-- table -->

			<?php
				$query = "SELECT * FROM withdraw_course WHERE Status <> 'ACCEPTED'";
				$result = mysqli_query($GLOBALS['conn'],$query); 
				if(mysqli_num_rows($result) > 0){

					echo "<table class='table table-hover table-bordered table-striped'>";
					echo "<thead>";
					echo "
					<tr>
        				<th>Withdraw ID</th>
        				<th>Student ID</th>
        				<th>Section ID</th>
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
						echo '<td>'.'<button class = "btn btn-small btn-success req_wtd_btn" data-toggle="modal" data-target= "#requestWithdrawModal" value ='.$value.'><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></td></tr>';
							}	
						echo "</tbody></table>";
					}
					else{

						echo "<div class='alert alert-success complaint_err' role='alert'>
							No Withdraw Requests! <span class='smile'>&#xf118;</span>
							</div>";
						}
					?>
				</div>
				<script>
					//When a stdnt edit reply button clicked
					$(".req_wtd_btn").click(function() {
						document.cookie = "req_id=;expires=Thu, 01 Jan 1970 00:00:00 UTC;"; //delete previous id cookie
    					var fired_button = $(this).val(); //get value of clicked button
    					document.cookie = "wtd_id="+fired_button; //cr_Accnteate a cookie (user_id)
    					$('#wtd_id').html(fired_button);
						});					
						
					</script>
			</div> <!-- table -->

			<!-- Modal for Student Accounts -->
			<div class="modal fade" id="requestWithdrawModal" tabindex="-1" role="dialog" aria-labelledby="accntLabel2" aria-hidden="true">
  				<div class=modal-dialog role="document">
    			<div class="modal-content">
      				<div class="modal-header">
        				<h4 class="modal-title" id="accntLabel2">Respond to Withdraw Request (<span id = 'wtd_id'></span>)</h4>
        				<strong><small style="color: #84469F;">*Select option below</small></strong>
        				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          				<span aria-hidden="true">&times;</span>
        				</button>
      				</div>
      			<div class="modal-body">

        			<form method="post" action= <?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>>

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
        			<button type="submit" class="btn btn-primary" name='update_withdraw'>Update</button>
      			</div>
      			</form>
    			</div>
  				</div>
  			</div> 


		</div>

</body>
</html>