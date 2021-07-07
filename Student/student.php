<?php include_once('../Database/database.php');
	include('navside.php'); 
	include('functions.php'); ?>

<!DOCTYPE html>

<html>
<head>
	<title>Student Portal</title>
	<script type="text/javascript">
		//Changing active nav link color
		$(document).ready(function(){
			$('#dashboard').css({
			color: '#EEEEEE'
			});
		})

	</script>

	<?php
	if(isset($_POST['add_std_complaint'])){
		$message = apply_filters($_POST['message']);

		if (student_complaint($message)){
			$com_std_added = '<div class="alert alert-success alert-dismissible fade in updated">
    						<a href="#" class="close" data-dismiss="alert" aria-label="close" style="padding-top:15px;">&times;</a>
    						<strong>Success!</strong> New Complaint added.
  						</div>';
		}
	} ?>
</head>
<body>

	<div style="margin-left: 20%; margin-top: 5%;">
	<!--------------------- STUDENT COMPLAINTS TABLE ------------------------------>
		<div class="row">

			<div class="col-xs-8 col-md-12">
				<?php 
					if (isset($com_std_added)){
						echo $com_std_added;
					}

					?>
				<div class = 'complaints col-xs-12'>
					
					<div class="complaints_txt2"><h1><span class="icon_tchr">&#xf024;</span>My Complaints</h1>
						<div id='add_btn'>
						<button class ='btn btn-warning add' data-toggle="modal" data-target= "#stdComplaintModal">Add New &nbsp;&#xf067;</button>
					</div>
					</div>
					<div class='complaints_table'>
						<?php
							$s_complaints = get_student_complaints();
							//Error if function return false
							if (!$s_complaints){
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
        							<th>Message</th>
        							<th>Admin Reply</th>
      							</tr>
    							</thead>
    							<tbody>
								";
								//Count number of entries
								$n = count($s_complaints);
								for($i=0;$i<$n;$i++) { //Echo data in table
      								echo '<tr>';
      								$id = $s_complaints[$i][0];
      								$value = (string)$id;
      								echo '<td>'. $s_complaints[$i][0]. '</td>';
      								echo '<td>'. $s_complaints[$i][1]. '</td>';
      								echo '<td>'. $s_complaints[$i][2]. '</td>';
      								echo '<td>'. $s_complaints[$i][3]. '</td></tr>';
      							}
      							echo "</tbody></table>";

							}
						
						?>
									
					</div>

				</div>

				<!-- ADD COMPLAINT MODAL ---------------->
				<div class="modal fade" id="stdComplaintModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
  					<div class=modal-dialog role="document">
    					<div class="modal-content">
      						<div class="modal-header">
        					<h4 class="modal-title" id="ModalLabel">Add New Complaint</h4>
        					<strong><small style="color: #84469F;">*All Fields are Required</small></strong>
        					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          					<span aria-hidden="true">&times;</span>
        					</button>
      					</div>
      					<div class="modal-body">

        				<form method="post" action= <?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>>
  							<div class="form-group">
    							<label for="message">Message</label>
								<textarea class="form-control" id="message" rows="5" name='message' required placeholder="Enter Feedback/Complaint"></textarea></div>
							</div>
      						<div class="modal-footer">
        						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        						<button type="submit" class="btn btn-primary" name='add_std_complaint'>Add</button>
      						</div>
      					</form>
    					</div>
  					</div>
				</div>


		</div> <!-- ROW -->


	</div> <!-- MAIN -->

</div> <!-- Div closed for navside.php container -->

</body>
</html>