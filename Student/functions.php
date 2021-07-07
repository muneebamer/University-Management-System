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
	//************************************* FUNCTIONS ************************************
	//***************************** REGISTER COURSE FUNCTION *****************************

	//takes section id as $course parameter
	//checks if student already took the course only allowed to repeat if grade W or F
	//checks if seats are available
	//if both conditions true course registered and seats available decremented
	//otherwise errors returned
	function register_course($course){
		$sid = $_SESSION['S_ID'];
		$semester = $_SESSION['Semester'];


		//checking if course already registered or repeating(only allowed on W or F grade)
		$query = "SELECT COUNT(Sec_ID) FROM course_registered WHERE (S_ID = '$sid' AND  Sec_ID = '$course' AND Grade NOT IN ('W','F'))";
		$result = mysqli_query($GLOBALS['conn'],$query);
		$row = mysqli_fetch_row($result);

		if ($row[0]==0){ //if not repeating or already registered

			//getting number of seats available in the section
			$query = "SELECT SeatsAvail FROM course_sec WHERE Sec_ID = '$course'";
			$result = mysqli_query($GLOBALS['conn'],$query);
			$row = mysqli_fetch_row($result);

			if ($row[0]>0){//checking if seats are available

				//registering course i.e: adding data in course_registered table
				insert(array('S_ID', 'Sec_ID','Grade','Semester'),array($sid, $course,'PENDING',$semester),'course_registered');

				//decrementing the value of seats available
				$val = $row[0]-1;
				$query = "UPDATE course_sec SET SeatsAvail = $val WHERE Sec_ID = '$course'";
				mysqli_query($GLOBALS['conn'],$query);

				return true;
			}
			else {//if seats not available returning error
				$err = "No Seats Available";
				return false;
			}
		}
		else{//if already registered/repeating returning error
			$err = "Course Already Registered/Taken";
			return false;
		}
	}
	//updates the password of student in login table
		function change_pasw($new_pasw){
			update('login',array('Pasw'),array($new_pasw),'UserID',$_SESSION['S_ID']);
			return true;
		}

	//register_course('C-01-A');
	//*************************************************************************************
	//**************************** APPLY INTERNSHIP FUNCTION ******************************

	//takes Internship id as $I_ID parameter
	//checks if student has already applied for the internship
	//if not internship is applied i.e: added to apply_internship table and returns true
	//otherwise returns error
	function apply_internship($I_ID){
		$sid = $_SESSION['S_ID'];

		$query = "SELECT COUNT(I_ID) FROM apply_internship WHERE (S_ID = '$sid' AND  I_ID = '$I_ID')";
		$result = mysqli_query($GLOBALS['conn'],$query);
		$row = mysqli_fetch_row($result);

		if ($row[0]==0){
			insert(array('S_ID', 'I_ID'),array( $sid, $I_ID),'apply_internship');
			return true;
		}
		else{
			
			return false;
		}
	}

	//apply_internship('I-01');

	function withdraw($sec_id,$reason){
		$sid = $_SESSION['S_ID'];

		$query = "SELECT COUNT(W_ID) FROM withdraw_course WHERE (S_ID = '$sid' AND  Sec_ID = '$sec_id')";
		$result = mysqli_query($GLOBALS['conn'],$query);
		$row = mysqli_fetch_row($result);

		if ($row[0]==0){
			insert(array('S_ID','Sec_ID','Reason'),array( $sid,$sec_id,$reason),'withdraw_course');
			return true;
		}
		else{
			return false;
		}
	}
	
	//***************************************************************************************
	//************************ REGISTER COMPLAINT FUNCTION **********************************

	//pass the message as parameter it will insert the complaint in student_complaints table
	function student_complaint($message){
		$sid = $_SESSION['S_ID'];

		insert(array('S_ID', 'Message'),array($sid, $message),'student_complaints');
		return true;
	}

	//student_complaint("Busy Parking");

	function get_student_complaints(){
			$sid = $_SESSION['S_ID'];
			$student = array(); //array to store all students complaints and which is to be returned
			
			$query = "SELECT COUNT(Complaint_ID) FROM student_complaints WHERE (S_ID = '$sid')";
			$result = mysqli_query($GLOBALS['conn'],$query);
			$row = mysqli_fetch_row($result);
			if ($row[0] == 0){
				return false;
			}
			else{

			$query = "SELECT * FROM student_complaints WHERE S_ID = '$sid' ";
			$result = mysqli_query($GLOBALS['conn'],$query);
			while ($row = mysqli_fetch_row($result)){
				$students = array($row[0],$row[1],$row[2],$row[3]); //array containing the selected students data
				array_push($student, $students); //student added to students array
			}
			return $student ;
			}
		}
	//***************************************************************************************

	//apply_internship('I-01');
	?>