

<?php include_once('../Database/database.php');
include('session.php'); 

?>

<?php 

//PHP FILTERS
	function apply_filters($inp){

		$inp = trim($inp); // Strip unnecessary charcaters
		$inp = stripslashes($inp); // Remove Backslashes
		$inp = htmlspecialchars($inp); // Convert Special characters to html entities
		return $inp; 

		}
?>

<?php  
//************************************************************************************
		//********************************** FUNCTIONS ***************************************
		//****************************** ADD STUDENT FUNCTION ********************************

		function add_student($S_ID,$Name,$Contact,$Email,$Address,$Major,$Gender,$semester,$Grad_year,$Pasw){
			$query = "SELECT COUNT(S_ID) FROM student WHERE (S_ID ='$S_ID')";
			$result = mysqli_query($GLOBALS['conn'],$query);
			$row = mysqli_fetch_row($result);
			if ($row[0]==0){
				insert("",array($S_ID,$Name,$Contact,$Email,$Address,$Major,$Gender,$semester,$Grad_year),'student');
				insert("",array($S_ID,$Pasw,2,'NO'),'login');
				return true;
			}
		}

		function count_students(){
			$query = "SELECT COUNT(S_ID) FROM student";
			$result = mysqli_query($GLOBALS['conn'],$query);
			$row = mysqli_fetch_row($result);
			return $row[0];
		}

		/*if(add_student('S-110','Will Smith','+92 331678543','will@ali.com','Australia','BBA','Male',2021,'student')){
			echo "STUDENT ADDED";
		}else{echo "<span>S_ID already exists</span>";}*/
		//**************************************************************************************
		//**************************** ADD TEACHER FUNCTION ************************************

		function add_teacher($T_ID,$Name,$Contact,$Email,$Address,$Dept,$Gender,$Salary,$Pasw){
			$query = "SELECT COUNT(T_ID) FROM `teacher` WHERE (T_ID ='$T_ID')";
			$result = mysqli_query($GLOBALS['conn'],$query);
			$row = mysqli_fetch_row($result);
			if ($row[0]==0){
				insert("",array($T_ID,$Name,$Contact,$Email,$Address,$Dept,$Gender,$Salary),'teacher');
				insert("",array($T_ID,$Pasw,3,'NO'),'login');
				return true;
			}
		}

		function count_teachers(){
			$query = "SELECT COUNT(T_ID) FROM teacher";
			$result = mysqli_query($GLOBALS['conn'],$query);
			$row = mysqli_fetch_row($result);
			return $row[0];
		} 
		/*
		if(add_teacher('T-105','Raza','+91 2737482','raza@khalid.com','Chichawatni','Eng','Male',60000,'teacher')){

		}else{echo "<span>T_ID already exists</span>";}*/
		//*******************************************************************************************
		//**************************** BLOCK ACCOUNT FUNCTION ************************************

		function block_account($id){
			// Check if account already blocked
			$check_block = read(array('Is_Block'),'Login','UserID',$id);
			$block_status = '';
			while ($row = mysqli_fetch_row($check_block)){
				foreach ($row as $value){
					$block_status = $value;
				}
			}

			if ($block_status == 'YES'){}
			//Return True if Successfully Updated.
			else{
				update('Login','Is_Block','YES','UserID',$id);			
				return true;
				}
		}

		/*
		update('Student',array('Name','Email','Gender'),array('Leonardo','leonardo@caprio.com','Female'),'S_ID','S-101');
		*/

		//updates the password of Admin in login table
		function change_pasw($new_pasw){
			update('login',array('Pasw'),array($new_pasw),'UserID',$_SESSION['A_ID']);
			return true;
		}

		//updates the password of Student or Teacher in login table
		function change_user_pasw($new_pasw,$id){
			update('login',array('Pasw'),array($new_pasw),'UserID',$id);
			return true;
		}

		//Respond to teacher complaints
		function handle_teacher_complaints($complaint_id,$message){
			$check = read(array('Admin_reply'),'teacher_complaints','Complaint_ID',$complaint_id);
			$check_status = '';
			while ($row = mysqli_fetch_row($check)){
				foreach ($row as $value){
					$check_status = $value;
				}
			}
			//Allow Respond if status pending
			if ($check_status == 'PENDING'){
				update('teacher_complaints',array('Admin_reply'),array($message),'Complaint_ID',$complaint_id);
				return true;
			}		

		}

		function get_teacher_complaints(){
			$teacher = array(); //array to store all students complaints and which is to be returned
			
			$query = "SELECT COUNT(Complaint_ID) FROM teacher_complaints WHERE (Admin_reply = 'PENDING')";
			$result = mysqli_query($GLOBALS['conn'],$query);
			$row = mysqli_fetch_row($result);
			if ($row[0] == 0){
				return false;
			}
			else{

			$query = "SELECT teacher_complaints.Complaint_ID, teacher_complaints.T_ID, teacher.Name,teacher_complaints.Message,teacher_complaints.Admin_reply FROM teacher_complaints,teacher WHERE teacher_complaints.T_ID = teacher.T_ID AND teacher_complaints.Admin_reply = 'PENDING' ";
			$result = mysqli_query($GLOBALS['conn'],$query);
			while ($row = mysqli_fetch_row($result)){
				$teacher_complaints = array($row[0],$row[1],$row[2],$row[3],$row[4]); //array containing the selected students data
				array_push($teacher, $teacher_complaints); //student added to students array
			}
			return $teacher ;
			}
		}
		//Respond to Student complaints
		function handle_student_complaints($complaint_id,$message){
			$check = read(array('Admin_reply'),'student_complaints','Complaint_ID',$complaint_id);
			$check_status = '';
			while ($row = mysqli_fetch_row($check)){
				foreach ($row as $value){
					$check_status = $value;
				}
			}
			//Allow Respond if status pending
			if ($check_status == 'PENDING'){
				update('student_complaints',array('Admin_reply'),array($message),'Complaint_ID',$complaint_id);
				return true;
			}		

		}

		function get_student_complaints(){
			$stds = array(); //array to store all students complaints and which is to be returned
			
			$query = "SELECT COUNT(Complaint_ID) FROM student_complaints WHERE (Admin_reply = 'PENDING')";
			$result = mysqli_query($GLOBALS['conn'],$query);
			$row = mysqli_fetch_row($result);
			if ($row[0] == 0){
				return false;
			}
			else{

			$query = "SELECT student_complaints.Complaint_ID, student_complaints.S_ID, student.Name,student_complaints.Message,student_complaints.Admin_reply FROM student_complaints,student WHERE student_complaints.S_ID = student.S_ID AND student_complaints.Admin_reply = 'PENDING' ";
			$result = mysqli_query($GLOBALS['conn'],$query);
			while ($row = mysqli_fetch_row($result)){
				$std_complaints = array($row[0],$row[1],$row[2],$row[3],$row[4]); //array containing the selected students data
				array_push($stds, $std_complaints); //student added to students array
			}
			return $stds ;
			}
		}

		//$internship will be an array with all values for Internship Table
		function add_internship($internship){
			$check = read(array('I_ID'),'Internship','I_ID',$internship[0]);
			$check_status = '';
			while ($row = mysqli_fetch_row($check)){
				foreach ($row as $value){
					$check_status = $value;
				}
			}
			//Insert if I_ID doesnot already exist
			if ($check_status != $internship[0]){

				insert('',$internship,'internship');
				return true;

			}

		}

		//add_internship(array('I-02','Pak Wheels','Karachi','5 Days','NO'),'internship');


		//$status will be APPROVED / REJECTED 
		function approve_internship($app_id,$status){
			//Get current application status
			$check = read(array('Status'),'apply_internship','Application_ID',$app_id);
			$check_status = '';
			while ($row = mysqli_fetch_row($check)){
				foreach ($row as $value){
					$check_status = $value;
				}
			}
			//Update only if status is PENDING
			if ($check_status == 'PENDING'){

				update('apply_internship',array('status'),array($status),'Application_ID',$app_id);
				return true;

			}

		}

		//approve_internship(1,'APPROVED');

		//$course will be an array with all values for Course Table
		function add_course($course){
			$check = read(array('C_ID'),'Course','C_ID',$course[0]);
			$check_status = '';
			while ($row = mysqli_fetch_row($check)){
				foreach ($row as $value){
					$check_status = $value; //C_ID
				}
			}
			//Check if course not already in db
			if ($check_status != $course[0]){
				insert('',$course,'Course');
				return true;
			}
		}
		//add_course(array('ISL101','Islamiat',3,'ISLAMIAT','ISL101','No description'));

		function count_courses(){
			$query = "SELECT COUNT(C_ID) FROM course";
			$result = mysqli_query($GLOBALS['conn'],$query);
			$row = mysqli_fetch_row($result);
			return $row[0];
		} 

		//$course_sec will be an array wil all values for the Table array($c_id,$name,$cred_hrs,$dept,$pre_req,$desc)
		function course_offer_accept($req_id,$Sec_ID,$SeatsOffered,$SeatsAvail,$room,$days,$timings){
			$request = read(array('Status','C_ID','T_ID'),'request_course','Request_ID',$req_id);
			$row = mysqli_fetch_row($request);

			if($row[0] == 'PENDING'){
				update('request_course',array('status'),array('ACCEPTED'),'Request_ID',$req_id);
				insert('',array($Sec_ID,$row[1],$row[2],$SeatsOffered,$SeatsAvail,$room,$days,$timings),'course_sec');
				return true;
				
			}
		}

		function course_offer_reject($req_id){
			$request = read(array('Status'),'request_course','Request_ID',$req_id);
			$row = mysqli_fetch_row($request);

			if($row[0] == 'PENDING'){
				
				update('request_course',array('status'),array('REJECTED'),'Request_ID',$req_id);
				return true;

			}
		}

		//course_offer_reject(1);

		//course_offer_accept(2,'COMP213-A',30,25,'S-101','TR','12:30 - 1:45');
		//***********************************************************************************
		function respond_leave($leave_id,$responce){
			if ($responce=="ACCEPTED"){
				update('`leave`',array('Status'),array($responce),'Leave_ID',$leave_id);
				return true;
			}
			else if ($responce=="REJECTED"){
				update('`leave`',array('Status'),array($responce),'Leave_ID',$leave_id);
				return true;
			}
		}

?>