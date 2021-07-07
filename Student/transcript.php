	
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
			$('#transcript').css({
			color: '#EEEEEE'
			});
		})

	</script>
</head>

<body>
	
	<div style="margin-left: 20%; margin-top: 4%;"> <!-- main div -->
		<div class="row">

			<div class="col-xs-8 col-md-12">

				<div class = 'complaints col-xs-12'>
					
					<div class="complaints_txt2" style="background-color: #281A42;"><h1><span class="icon_reg">&#xf201;</span>Transcript</h1>
					</div>
					<div class='complaints_table'>
						<?php
						$sid = $_SESSION['S_ID'];
						$query = "SELECT course_sec.C_ID, course_registered.Sec_ID,course.Name,teacher.Name, course_registered.Semester,course_registered.Grade FROM course_sec, course_registered, teacher, course Where course_registered.S_ID = '$sid'  AND course_sec.T_ID =teacher.T_ID AND course.C_ID = course_sec.C_ID AND course_registered.Sec_ID = course_sec.Sec_ID";
							$result = mysqli_query($GLOBALS['conn'],$query);  
							
							if(mysqli_num_rows($result) > 0){

							echo "<table class='table table-hover table-bordered table-striped'>";
							echo "<thead>";
							echo "
							<tr>
        						<th>Course ID</th>
        						<th>Section ID</th>
        						<th>Course Name</th>
        						<th>Teacher Name</th>
        						<th>Semester</th>
        						<th>Grade</th>
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
							No Registered Courses! <span class='smile'>&#xf119;</span>
							</div>";
					}
						?>
									
					</div>
				</div>
			</div>

		</div>



	</div> <!-- Main Div> -->
</body>




</html>