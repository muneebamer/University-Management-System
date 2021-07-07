
<?php 
	include_once('../Database/database.php');
	include_once('functions.php');
	include_once('navside.php');
?>

<!DOCTYPE html>

<html>
<head>	
	<title>Teacher Portal</title>

	<script type="text/javascript">
		//Changing active nav link color
		$(document).ready(function(){
			$('#dashboard').css({
			color: '#EEEEEE'
			});
		})
	</script>

	<?php
	if(isset($_POST['add_complaint'])){
		$message = apply_filters($_POST['message']);

		if (teacher_complaint($message)){
			$com_added = '<div class="alert alert-success alert-dismissible fade in updated">
    						<a href="#" class="close" data-dismiss="alert" aria-label="close" style="padding-top:15px;">&times;</a>
    						<strong>Success!</strong> New Complaint added.
  						</div>';
		}
	}

	if(isset($_POST['add_leave'])){
		$days = apply_filters($_POST['days']);
		$reason = apply_filters($_POST['reason']);

		if (apply_leave($days,$reason)){
			$leave_added = '<div class="alert alert-success alert-dismissible fade in updated">
    						<a href="#" class="close" data-dismiss="alert" aria-label="close" style="padding-top:15px;">&times;</a>
    						<strong>Success!</strong> Leave Applied.
  						</div>';
		}
	}
	?>
</head>
<body>
	<div class = 'row' style="margin-top: 50px;">
		<div class="col-xs-8 col-md-12">
			<?php 
				if (isset($com_added)){
				echo $com_added;
				}

			?>
			<div class = 'complaints col-xs-12'>
					
				<div class="complaints_txt2"><h1><span class="icon_tchr" style="margin-right: 10px;">&#Xf007;</span>Teacher Complaints</h1>
					<div id='add_btn'>
						<button class ='btn btn-warning add' data-toggle="modal" data-target= "#addComplaintModal">Add New &nbsp;&#xf067;</button>
					</div>
				</div>
				<div class="modal fade" id="addComplaintModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
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
        						<button type="submit" class="btn btn-primary" name='add_complaint'>Add</button>
      						</div>
      					</form>
    					</div>
  					</div>
				</div>

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
      								echo '<td>'. $t_complaints[$i][4]."</td>";
      								echo '</tr>';
      							}
      							echo "</tbody></table>";

							}
						?>
									
					</div>
				</div>





				<div class = 'row'>
					<div class="col-xs-8 col-md-12">
				<?php 
					if (isset($leave_added)){
					 echo $leave_added;
					}

					if(isset($_POST['add_leave'])){
					if (!isset($leave_added)){
						echo '<div class="alert alert-warning alert-dismissible fade in updated">
    						<a href="#" class="close" data-dismiss="alert" aria-label="close" style="padding-top:15px;">&times;</a>
    						<strong>Error!</strong> A leave is already in PENDING state.
  						</div>';
					}
				}

					?>
				<div class = 'complaints col-xs-12'>
					
					<div class="complaints_txt2" style="background-color: #AD5CFE;"><h1><span class="icon_tchr" style="margin-right: 10px;">&#Xf007;</span>Teacher Leave</h1>
						<div id='add_btn'>
						<button class ='btn btn-success add' data-toggle="modal" data-target= "#addLeaveModal">Add New &nbsp;&#xf067;</button>
						</div>
					</div>
					<div class="modal fade" id="addLeaveModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
  				<div class=modal-dialog role="document">
    			<div class="modal-content">
      				<div class="modal-header">
        				<h4 class="modal-title" id="ModalLabel">Apply Leave</h4>
        				<strong><small style="color: #84469F;">*All Fields are Required</small></strong>
        				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          				<span aria-hidden="true">&times;</span>
        				</button>
      				</div>
      			<div class="modal-body">

        			<form method="post" action= <?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>>
        				<div class="form-group">
    						<label for="days">Days</label>
    						<input class="form-control" id="days" name="days" placeholder="Enter Days Of Leave" type="text" required></input>
  						</div>
  						<div class="form-group">
    						<label for="reason">Reason</label>
							<textarea class="form-control" id="reason" rows="5" name='reason' required placeholder="Enter Reason for Leave"></textarea>
						</div>

      			</div>
      			<div class="modal-footer">
        			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        			<button type="submit" class="btn btn-primary" name='add_leave'>Add</button>
      			</div>
      			</form>
    			</div>
  				</div>
			</div>

					<div class='complaints_table'>
						<?php
							$t_leaves = get_teacher_leaves();
							//Error if function return false
							if (!$t_leaves){
								echo "<div class='alert alert-info complaint_err' role='alert'>
								No Leaves at the moment! <span class='smile'>&#xf118;</span>
								</div>";
							}
							//Create Table
							else{
								echo "<table class='table table-hover table-bordered table-striped'>";
								echo "<thead>";
								echo "
								<tr>
        							<th>Leave ID</th>
        							<th>Teacher ID</th>
        							<th>Teacher Name</th>
        							<th>Days</th>
        							<th>Reason</th>
        							<th>Status</th>
      							</tr>
    							</thead>
    							<tbody>
								";
								//Count number of entries
								$n = count($t_leaves);
								for($i=0;$i<$n;$i++) { //Echo data in table
      								echo '<tr>';
      								$id = $t_leaves[$i][0];
      								$value = (string)$id;
      								echo '<td>'. $t_leaves[$i][0]. '</td>';
      								echo '<td>'. $t_leaves[$i][1]. '</td>';
      								echo '<td>'. $t_leaves[$i][2]. '</td>';
      								echo '<td>'. $t_leaves[$i][3]. '</td>';
      								echo '<td>'. $t_leaves[$i][4]."</td>";
      								echo '<td>'. $t_leaves[$i][5]."</td>";
      								echo '</tr>';
      							}
      							echo "</tbody></table>";

							}
						?>
									
					</div>
				</div>









</body>
</html>