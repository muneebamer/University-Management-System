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
		//************************************* FUNCTIONS *****************************************
		//******************************* REQUEST COURSE FUNCTION *********************************

		//it will first check if the teacher has already requested the course and is in pending status.
		//if true it will return an error
		//if false it will add the entry in request_course table
		function request_course($course){
			$tid = $_SESSION['T_ID'];

			$query = "SELECT COUNT(C_ID) FROM course WHERE C_ID = '$course'";
			$result = mysqli_query($GLOBALS['conn'],$query);
			$row = mysqli_fetch_row($result);
			if ($row[0]>0){
				$query = "SELECT COUNT(Request_ID) FROM request_course WHERE (T_ID = '$tid' and Status = 'PENDING' and C_ID = '$course')";
				$result = mysqli_query($GLOBALS['conn'],$query);
				$row = mysqli_fetch_row($result);
				if ($row[0]==0){
					insert(array('C_ID','T_ID'),array($course,$tid),'request_course');
					return true;
				}
			}
		}

		//request_course('COMP213');
		//************************************************************************************
		//*************************** CHANGE PASSWORD FUNCTION *******************************

		//updates the password of teacher in login table
		function change_pasw($new_pasw){
			update('login',array('Pasw'),array($new_pasw),'UserID',$_SESSION['T_ID']);
			return true;
		}

		//change_pasw('teacher');
		//************************************************************************************
		//************************ RESPOND WITHDRAW REQUEST FUNCTION *************************

		//takes parameter the withdraw id as $w_id and the responce as $responce
		//responce should be 'ACCEPTED' or 'REJECTED'
		//if responce is accepted it will change the status of withdraw request to ACCEPTED and give the grade W to the student in the course
		//if responce is rejected it will simply change the status to rejected
		//returns true after accepting or rejecting the withdraw request
		function respond_withdraw($w_id,$responce){
			if ($responce=="ACCEPTED"){
				update('`withdraw_course`',array('Status'),array($responce),'W_ID',$w_id);
				$query = "SELECT S_ID,Sec_ID FROM withdraw_course WHERE W_ID = '$w_id'";
				$result = mysqli_query($GLOBALS['conn'],$query);
				$row = mysqli_fetch_row($result);
				give_grade($row[0],$row[1],'W');
				return true;
			}
			else if ($responce=="REJECTED"){
				update('`withdraw_course`',array('Status'),array($responce),'W_ID',$w_id);
				return true;
			}
		}

		//respond_withdraw(1,'ACCEPTED');
		//************************************************************************************
		//**************************** APPLY LEAVE FUNCTION **********************************

		//First checks if the teacher already have some pending leaves
		//if yes displays an error that leave already applied
		//if no leave is applied i.e added to the leave table
		function apply_leave($days,$reason){
			$tid = $_SESSION['T_ID'];

			$query = "SELECT COUNT(Leave_ID) FROM `leave` WHERE (T_ID ='$tid' and Status ='PENDING')";
			$result = mysqli_query($GLOBALS['conn'],$query);
			$row = mysqli_fetch_row($result);
			if ($row[0]==0){
				insert(array('T_ID','Days','Reason'),array($tid,$days,$reason),'`leave`');
				return true;
			}
			else{
				$err = "Leave Already Applied";
			}
		}

		//apply_leave('3','Sick');
		//**************************************************************************************
		//******************* TEACHER FEEDBACK/COMPLAINT FUNCTION ******************************

		//pass the message as parameter it will insert the complaint in teacher_complaints table
		function teacher_complaint($message){
			$tid = $_SESSION['T_ID'];

			insert(array('T_ID','Message'),array($tid,$message),'teacher_complaints');
			return true;
		}

		//teacher_complaint("No white board markers in room 12");
		//**************************************************************************************
		//************************ ENROLLED STUDENTS FUNCTION **********************************

		//finds students which are being taught by the teacher
		//returns a 2d array with std details
		//example return: array(array('S-101','Mohid','C-01-A','C-01','Web App'),array('S-101','Mohid','C-03-A','C-03','Differential'))
		//The details retured are in the order: Student id, Student Name, Course Section ID, Course ID, Course Name
		function enrolled_students(){
			$stds = array(); //array to store all students and which is to be returned
			$tid = $_SESSION['T_ID'];


			$query = "SELECT student.S_ID,student.Name,course_sec.Sec_ID,course.C_ID,course.Name,course_registered.grade FROM student,course_sec,course,course_registered WHERE (course_sec.T_ID='$tid' and course_sec.C_ID = course.C_ID and course_sec.Sec_ID =course_registered.Sec_ID and course_registered.S_ID = student.S_ID)";
			$result = mysqli_query($GLOBALS['conn'],$query);
			while ($row = mysqli_fetch_row($result)){
				$std = array($row[0],$row[1],$row[2],$row[3],$row[4],$row[5]); //array containing the selected students data
				array_push($stds, $std); //student added to students array
			}
			return $stds;
		}

		//$stds = enrolled_students();
		//echo $stds[0][0],$stds[0][1],$stds[0][2],$stds[0][3],$stds[0][4];
		//*************************************************************************************
		//**************************** GIVE GRADE FUNCTION ************************************

		//requires parameters student id, the course section sec_id to grade for and the grade to give.
		//checks that it is not changing withdrawed or failed course
		//returns true after updating
		function give_grade($student_id,$sec_id,$grade){
			$query = "SELECT COUNT(S_ID) FROM course_registered WHERE (S_ID = '$student_id' and Sec_ID = '$sec_id' AND Grade = 'PENDING')";
			$result = mysqli_query($GLOBALS['conn'],$query);
			$row = mysqli_fetch_row($result);
			if ($row[0] == 0){
				return false;
			}
			else{

			$query = "UPDATE course_registered SET Grade = '$grade' WHERE (S_ID = '$student_id' and Sec_ID = '$sec_id' AND Grade = 'PENDING')";
			mysqli_query($GLOBALS['conn'],$query);
			return true;
			}
		}

		//give_grade('S-101','C-01-A','F');
		//*************************************************************************************
		function get_teacher_complaints(){
			$tid = $_SESSION['T_ID'];
			$teacher = array(); //array to store all students complaints and which is to be returned
			
			$query = "SELECT COUNT(Complaint_ID) FROM teacher_complaints WHERE (T_ID = '$tid')";
			$result = mysqli_query($GLOBALS['conn'],$query);
			$row = mysqli_fetch_row($result);
			if ($row[0] == 0){
				return false;
			}
			else{

			$query = "SELECT teacher_complaints.Complaint_ID, teacher_complaints.T_ID, teacher.Name,teacher_complaints.Message,teacher_complaints.Admin_reply FROM teacher_complaints,teacher WHERE teacher_complaints.T_ID = teacher.T_ID AND teacher_complaints.T_ID = '$tid' ";
			$result = mysqli_query($GLOBALS['conn'],$query);
			while ($row = mysqli_fetch_row($result)){
				$teacher_complaints = array($row[0],$row[1],$row[2],$row[3],$row[4]); //array containing the selected students data
				array_push($teacher, $teacher_complaints); //student added to students array
			}
			return $teacher ;
			}
		}
		//****************************************************************************************
		function get_teacher_leaves(){
			$tid = $_SESSION['T_ID'];
			$leaves = array(); //array to store all students complaints and which is to be returned
			
			$query = "SELECT COUNT(Leave_ID) FROM `leave` WHERE (T_ID = '$tid')";
			$result = mysqli_query($GLOBALS['conn'],$query);
			$row = mysqli_fetch_row($result);
			if ($row[0] == 0){
				return false;
			}
			else{

			$query = "SELECT Leave_ID,teacher.T_ID,teacher.Name,Days,Reason,Status FROM `leave`,teacher WHERE leave.T_ID = teacher.T_ID AND leave.T_ID = '$tid' ";
			$result = mysqli_query($GLOBALS['conn'],$query);
			while ($row = mysqli_fetch_row($result)){
				$teacher_leaves = array($row[0],$row[1],$row[2],$row[3],$row[4],$row[5]); //array containing the selected students data
				array_push($leaves, $teacher_leaves); //student added to students array
			}
			return $leaves ;
			}
		}
		//****************************************************************************************
		function get_teacher_courses(){
			$tid = $_SESSION['T_ID'];
			$courses = array(); //array to store all students complaints and which is to be returned
			
			$query = "SELECT COUNT(Sec_ID) FROM course_sec WHERE (T_ID = '$tid')";
			$result = mysqli_query($GLOBALS['conn'],$query);
			$row = mysqli_fetch_row($result);
			if ($row[0] == 0){
				return false;
			}
			else{

			$query = "SELECT C_ID,Sec_ID,T_ID,SeatsOffered,SeatsAvail,Room,Days,Timings FROM course_sec WHERE T_ID = '$tid' ";
			$result = mysqli_query($GLOBALS['conn'],$query);
			while ($row = mysqli_fetch_row($result)){
				$teacher_course = array($row[0],$row[1],$row[2],$row[3],$row[4],$row[5],$row[6],$row[7]); //array containing the selected students data
				array_push($courses, $teacher_course); //student added to students array
			}
			return $courses ;
			}
		}
		//****************************************************************************************
		function get_teacher_requests(){
			$tid = $_SESSION['T_ID'];
			$requests = array(); //array to store all students complaints and which is to be returned
			
			$query = "SELECT COUNT(Request_ID) FROM request_course WHERE (T_ID = '$tid')";
			$result = mysqli_query($GLOBALS['conn'],$query);
			$row = mysqli_fetch_row($result);
			if ($row[0] == 0){
				return false;
			}
			else{

			$query = "SELECT Request_ID,C_ID,T_ID,Status FROM request_course WHERE T_ID = '$tid' ";
			$result = mysqli_query($GLOBALS['conn'],$query);
			while ($row = mysqli_fetch_row($result)){
				$teacher_request = array($row[0],$row[1],$row[2],$row[3]); //array containing the selected students data
				array_push($requests, $teacher_request); //student added to students array
			}
			return $requests ;
			}
		}
	?>