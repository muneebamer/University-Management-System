	
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
			$('#fee').css({
			color: '#EEEEEE'
			});
		})

	</script>
</head>

<body>
	
	<div style="margin-left: 20%; margin-top: 4%;"> <!-- main div -->
		<div class="row">

			<!--------------------- APPLIED INTERNSHIPS ------------------------------>
		<div class="row">

			<div class="col-xs-8 col-md-12">

				<div class = 'complaints col-xs-12'>
					
					<div class="complaints_txt2" style="background-color: #073452;"><h1><span class="icons">&#xf0d6;</span>Fee Details</h1>
					</div>
					<div class='complaints_table'>
						<?php
						$sid = $_SESSION['S_ID'];
						$query = "SELECT * FROM fee_detail WHERE S_ID = '$sid'";
							$result = mysqli_query($GLOBALS['conn'],$query);  
							
							if(mysqli_num_rows($result) > 0){

							echo "<table class='table table-hover table-bordered table-striped'>";
							echo "<thead>";
							echo "
							<tr>
        						<th>Total Fee</th>
        						<th>Paid Fee</th>
        						<th>Remaining Fee</th>
        						<th>Semester</th>
      						</tr>
    						</thead>
    						<tbody><tr>";
    						while ($row = mysqli_fetch_row($result)) {
    							$value = $row[0];
								echo '<td>'.$row[1].'</td>';
								echo '<td>'.$row[2].'</td>';
								echo '<td>'.$row[3].'</td>';
								echo '<td>'.$row[4].'</td></tr>';
							}	
						echo "</tbody></table>";
					}
					else{
						echo "<div class='alert alert-danger complaint_err' role='alert'>
							No Fee Details! <span class='smile'>&#xf119;</span>
							</div>";
					}
						?>
									
					</div>
				</div>
			</div>


		</div> <!-- ROW -->

		</div> <!-- ROW -->



	</div> <!-- Main Div> -->
</body>




</html>