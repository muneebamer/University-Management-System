	
<?php 
	include_once('../Database/database.php');
	include('navside.php'); 
	include('functions.php');
?>

<!DOCTYPE html>

<html>
<head>
	
	<title>Admin Portal</title>
	<!------------------ FORM SUBMISSIONS ------------------------------------->

	<?php 

	//Check if Student form submitted
	if(isset($_POST['send_student'])){

		$reply = apply_filters($_POST['reply']); //Store reply
		if(handle_student_complaints($_COOKIE['id'],$reply)){

			//Bootstrap close Alert
			$success_student = '<div class="alert alert-success alert-dismissible fade in std_cmplnt">
    						<a href="#" class="close" data-dismiss="alert" aria-label="close" style="padding-top:15px;">&times;</a>
    						<strong>Success!</strong> Your Message has been sent.
  						</div>';
		}		
	}

	//Check if Teacher form submitted
	if(isset($_POST['send_tchr'])){

		$reply = apply_filters($_POST['reply']); //Store reply
		if(handle_teacher_complaints($_COOKIE['id'],$reply)){

			//Bootstrap close Alert
			$success_teacher = '<div class="alert alert-success alert-dismissible fade in std_cmplnt">
    						<a href="#" class="close" data-dismiss="alert" aria-label="close" style="padding-top:15px;">&times;</a>
    						<strong>Success!</strong> Your Message has been sent.
  						</div>';
		}		
	}

	?>


	<script type="text/javascript">
		//Changing active nav link color
		$(document).ready(function(){
			$('#dashboard').css({
			color: '#EEEEEE'
			});
		})

	</script>
</head>
<body>
	
	<div style="margin-left: 20%; margin-top: 5%;">
		<!---------------------------- Header Card Boxes ------------------------------------>
		<div class="row">
			<div class="col-xs-8 col-md-12">
				<div class='header_box col-xs-12 col-md-2'>
					<div class ='header_txt' style="background-color: #AD5CFE;"><h1><?php echo count_students() ?></h1></div>
					<div class='header_txt2'>Total Students</div>
				</div>
				<div class="header_box col-xs-12 col-md-2">
					<div class ='header_txt' style="background-color: #FFC132;"><h1><?php echo count_teachers() ?></h1></div>
					<div class='header_txt2'>Total Teachers</div>
				</div>
				<div class="header_box col-xs-12 col-md-2" >
					<div class ='header_txt' style="background-color: #4CAF50;"><h1><?php echo count_courses() ?></h1></div>
					<div class='header_txt2'>Total Courses</div>
				</div>

			</div>
		</div>

		<!------------------------------------ Students Complaint Table ------------------------------------------->
		<div class = 'row'>
			<div class="col-xs-8 col-md-12">
				<?php 
					if (isset($success_student)){
						echo $success_student;
					}

					?>
				<div class = 'complaints col-xs-12'>
					
					<div class="complaints_txt"><h1><span class="icons">&#Xf0c0;</span>Student Complaints</h1></div>
					<div class='complaints_table'>
						<?php
							$s_complaint = get_student_complaints();
							//Error if function return false
							if (!$s_complaint){
								echo "<div class='alert alert-info complaint_err' role='alert'>
								No Complaints at the moment! <span class='smile'>&#xf118;</span>
								</div>";
							}
							//Create Table
							else{
								echo "<table class='table table-hover table-bordered table-striped'>";
								echo "<thead>";
								echo "
								<tr>
        							<th>Complaint ID</th>
        							<th>Student ID</th>
        							<th>Student Name</th>
        							<th>Message</th>
        							<th>Admin Reply</th>
      							</tr>
    							</thead>
    							<tbody>
								";
								//Count number of entries
								$n = count($s_complaint);
								for($i=0;$i<$n;$i++) { //Echo data in table
      								echo '<tr>';
      								$id = $s_complaint[$i][0];
      								$value = (string)$id;
      								echo '<td>'. $s_complaint[$i][0]. '</td>';
      								echo '<td>'. $s_complaint[$i][1]. '</td>';
      								echo '<td>'. $s_complaint[$i][2]. '</td>';
      								echo '<td>'. $s_complaint[$i][3]. '</td>';
      								echo '<td>'. $s_complaint[$i][4]."<button class='btn btn-small btn-warning std' data-toggle='modal' data-target='#studentModal' value = ".$value.">Reply</button></td>"; //Button trigger modal and set its value to current Complaint ID
      								echo '</tr>';
      							}
      							echo "</tbody></table>";

							}
						?>
									
					</div>
					<script>
						//When a std complaint reply button clicked
						$(".std").click(function() {
								document.cookie = "id=;expires=Thu, 01 Jan 1970 00:00:00 UTC;"; //delete previous id cookie
    							var fired_button = $(this).val(); //get value of clicked button
    							document.cookie = "id="+fired_button; //create a cookie (id)
    							$('#std_cmplnt').html(fired_button);
							});					
						
					</script>

				</div>

			<!-- Modal for Student Complaints -->
			<div class="modal fade" id="studentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  				<div class=modal-dialog role="document">
    			<div class="modal-content">
      				<div class="modal-header">
        				<h4 class="modal-title" id="exampleModalLabel">Student Complaint (CID: <span id = 'std_cmplnt'></span>)</h4>
        				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          				<span aria-hidden="true">&times;</span>
        				</button>
      				</div>
      			<div class="modal-body">

        			<form method="post" action= "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

						<div class="form-group">
    						<label for="std_reply">Enter Your Reply</label>
    						<textarea class="form-control" id="std_reply" rows="5" name='reply' required></textarea>
  						</div>

        			

      			</div>
      			<div class="modal-footer">
        			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        			<button type="submit" class="btn btn-primary" name='send_student'>Send</button>
      			</div>
      			</form>
    			</div>
  				</div>
			</div> 
			

			</div>
		</div>

		<!------------------------------------ Teacher Complaint Table ------------------------------------------->

			<div class = 'row'>
			<div class="col-xs-8 col-md-12">
				<?php 
					if (isset($success_teacher)){
						echo $success_teacher;
					}

					?>
				<div class = 'complaints col-xs-12'>
					
					<div class="complaints_txt2"><h1><span class="icon_tchr">&#Xf007;</span>Teacher Complaints</h1></div>
					<div class='complaints_table'>
						<?php
							$t_complaints = get_teacher_complaints();
							//Error if function return false
							if (!$t_complaints){
								echo "<div class='alert alert-info complaint_err' role='alert'>
								No Complaints at the moment! <span class='smile'>&#xf118;</span>
								</div>";
							}
							//Create Table
							else{
								echo "<table class='table table-hover table-bordered table-striped'>";
								echo "<thead>";
								echo "
								<tr>
        							<th>Complaint ID</th>
        							<th>Teacher ID</th>
        							<th>Teacher Name</th>
        							<th>Message</th>
        							<th>Admin Reply</th>
      							</tr>
    							</thead>
    							<tbody>
								";
								//Count number of entries
								$n = count($t_complaints);
								for($i=0;$i<$n;$i++) { //Echo data in table
      								echo '<tr>';
      								$id = $t_complaints[$i][0];
      								$value = (string)$id;
      								echo '<td>'. $t_complaints[$i][0]. '</td>';
      								echo '<td>'. $t_complaints[$i][1]. '</td>';
      								echo '<td>'. $t_complaints[$i][2]. '</td>';
      								echo '<td>'. $t_complaints[$i][3]. '</td>';
      								echo '<td>'. $t_complaints[$i][4]."<button class='btn btn-small btn-warning tchr' data-toggle='modal' data-target='#teacherModal' value = ".$value.">Reply</button></td>"; //Button trigger modal and set its value to current Complaint ID
      								echo '</tr>';
      							}
      							echo "</tbody></table>";

							}
						?>
									
					</div>
					<script>
						//When a tchr complaint reply button clicked
						$(".tchr").click(function() {
								document.cookie = "id=;expires=Thu, 01 Jan 1970 00:00:00 UTC;"; //delete previous id cookie
    							var fired_button = $(this).val(); //get value of clicked button
    							document.cookie = "id="+fired_button; //create a cookie (id)
    							$('#tchr_cmplnt').html(fired_button);
							});					
						
					</script>

				</div>

			<!-- Modal for Teacher Complaints -->
			<div class="modal fade" id="teacherModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
  				<div class=modal-dialog role="document">
    			<div class="modal-content">
      				<div class="modal-header">
        				<h4 class="modal-title" id="ModalLabel">Teacher Complaint (CID: <span id = 'tchr_cmplnt'></span>)</h4>
        				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          				<span aria-hidden="true">&times;</span>
        				</button>
      				</div>
      			<div class="modal-body">

        			<form method="post" action= "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

						<div class="form-group">
    						<label for="tchr_reply">Enter Your Reply</label>
    						<textarea class="form-control" id="tchr_reply" rows="5" name='reply' required></textarea>
  						</div>    			

      			</div>
      			<div class="modal-footer">
        			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        			<button type="submit" class="btn btn-primary" name='send_tchr'>Send</button>
      			</div>
      			</form>
    			</div>
  				</div>
			</div> 
			

			</div>

		</div>

	
	</div> <!-- MAIN -->

	</div> <!-- Div closed for navside.php container -->



</body>
</html>
