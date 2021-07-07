<?php
include_once('server_configuration.php');


$sql = "CREATE DATABASE IF NOT EXISTS $db";
//Create and check
if (mysqli_query($conn,$sql)){
		
}
else {
	echo "<br>Error Creating Database: ". mysqli_error($conn);
}

//Select Active DB
$db_selected = mysqli_select_db($conn,$db);

//Function to execute Queries
function exec_query($query){ 

	if (mysqli_query($GLOBALS['conn'],$query)){
		 return true;
	}
	else{
		//echo "<br>Error : ". mysqli_error($GLOBALS['conn']); //ERROR
		return false;
	}
}

//  Function to Insert data in a table.
//	//query
//  "INSERT INTO tablename (col,col,col)
//	values(value,value,value)""

//$data will be an array with values as such (value,value,value).
//$table will be the name of table to insert data in.
//$cols will be an array with values such as (col_name,col_name)
//if $cols is passed as empty string then it will select all cols in table automatically.
function insert($cols,$data,$table){

	//if no cols added then select all columns
	if ($cols==""){
		// Query to fetch column names of a table
		$query = "SELECT COLUMN_NAME
		FROM INFORMATION_SCHEMA.COLUMNS
		WHERE TABLE_NAME = '$table'";

		//Execute Query
		if ($result = mysqli_query($GLOBALS['conn'],$query)){}
		else{
			echo "<br>Error : ". mysqli_error($GLOBALS['conn']);
		}
		
		$column_name=""; //Store Column Name
		while ( $row = mysqli_fetch_row($result)){ //Get Column Names in a table.
			//Adding a comma and space only between words.
			if ($column_name==""){
				$column_name.="";
			}else{
				$column_name.=", ";
			}
			//Add name to $column_name
			$column_name .= $row[0];
		}
	}

	//if specific cols added only select those
	else{
		$column_name = "";
		foreach ($cols as $value){
			//Adding a comma and space only between words.
			if ($column_name==""){
				$column_name.="";
			}else{
				$column_name.=", ";
			}
			//Add value with single inverted commas.
			$column_name.=$value;
		}
	}
	$values=""; //Store values of columns
	foreach ($data as $value){
		//Adding a comma and space only between words.
		if ($values==""){
			$values.="";
		}else{
			$values.=", ";
		}
		//Add value with single inverted commas.
		$values.="'".$value."'";

	}
	//Query to insert data in provided table
	$query = "INSERT INTO $table ($column_name) values ($values)";
	//Execute Query
	exec_query($query);
	return true;
	

}
//DELETE FROM $table WHERE $col = $value;
function delete($table,$col,$value){

	$query = "DELETE FROM $table WHERE $col = '$value'";
	//Execute Query
	exec_query($query);
	return true;
	//echo "<br>Record Deleted from $table";

}
//Function to display data in a table
//$data will be an array with values as such (value,value,value).
//$table will be the name of table to get data from.
//$col will have the column name on which condition is checked if no condition leave $col as ''
//In $value give the value of $col at which it returns true
function read($select,$table,$col,$value){
	//adding commas and spaces
	$column_name='';
	foreach ($select as $input){
		if ($column_name==''){
			$column_name.='';
		}else{
			$column_name.=', ';
		}
		$column_name.=$input;
	}
	//generating query having select and from
	$query = "SELECT $column_name
				FROM $table";

	//if any condition is given adding where in query
	if ($col!=''){
		$query .= " WHERE $col = '$value'";
	}
	$query.=";";
	//running query
	if ($result = mysqli_query($GLOBALS['conn'],$query)){
		//Echo Result
		return $result;
	}
	else{
		echo "<br>Error : ". mysqli_error($GLOBALS['conn']);
	}
	
}
//  Function to Update data in a table
//	$table will be the name of table
//	$col2set will be an array of columns to set
//	$data will be an array with respective values for columns
//  $col2set[n] = $data[n]
function update($table,$col2Set,$data,$col,$value){
	$query = "UPDATE $table SET ";
	for ($i = 0; $i < count($col2Set) ; $i++){
		if ($i == count($col2Set) -1){
			$query.= "$col2Set[$i] = '$data[$i]' ";
		}
		else{
		$query.= "$col2Set[$i] = '$data[$i]', ";
		}
	}
	$query .= "WHERE $col = '$value'";
	//echo $query;
	//Execute Query
	exec_query($query);
	return true;

}
//************************** TABLES **************************

//*********** ADMIN TABLE *******************
$query = "CREATE TABLE IF NOT EXISTS `Admin` (
	A_ID VARCHAR(10) PRIMARY KEY,
	Name VARCHAR(30) NOT NULL,
	Contact VARCHAR(30), 
	Email VARCHAR(30),
	Address VARCHAR(30))";
//Execute Query
exec_query($query);

//*******************************************

//*********** TEACHER TABLE *******************

$query = "CREATE TABLE IF NOT EXISTS `Teacher` (
	T_ID VARCHAR(10) PRIMARY KEY,
	Name VARCHAR(30) NOT NULL,
	Contact VARCHAR(30), 
	Email VARCHAR(30),
	Address VARCHAR(30),
	Dept VARCHAR(30),
	Gender VARCHAR(6),
	Salary FLOAT(5))";
//Execute Query
exec_query($query);

//*******************************************

//*********** STUDENT TABLE *******************

$query = "CREATE TABLE IF NOT EXISTS `Student` (
	S_ID VARCHAR(10) PRIMARY KEY,
	Name VARCHAR(30) NOT NULL,
	Contact VARCHAR(30), 
	Email VARCHAR(30),
	Address VARCHAR(30),
	Major VARCHAR(30),
	Gender VARCHAR(6),
	Semester INT(3),
	Grad_year INT(5))";
//Execute Query
exec_query($query);

//*******************************************


//*********** LOGIN TABLE *******************

$query = "CREATE TABLE IF NOT EXISTS `Login` (
	UserID VARCHAR(10) PRIMARY KEY,
	Pasw VARCHAR(20) NOT NULL,
	account_type INT(5) NOT NULL,
	Is_Block VARCHAR(5) DEFAULT 'NO')";

//Execute Query
exec_query($query);


//*********** COURSE TABLE *******************

$query = "CREATE TABLE IF NOT EXISTS `Course` (
	C_ID VARCHAR(10) PRIMARY KEY,
	Name VARCHAR(30) NOT NULL,
	Cred_hrs INT(2), 
	Department VARCHAR(30),
	Pre_req VARCHAR(30),
	Description VARCHAR(225))";
//Execute Query
exec_query($query);

//*******************************************

//*********** COURSE SECTION TABLE *******************

$query = "CREATE TABLE IF NOT EXISTS `course_sec` (
	Sec_ID VARCHAR(20) PRIMARY KEY,
	C_ID VARCHAR(10),
	T_ID VARCHAR(10), 
	SeatsOffered INT(30),
	SeatsAvail INT(30),
	Room VARCHAR(10),
	Days VARCHAR(10),
	Timings VARCHAR(20),
	FOREIGN KEY (C_ID) REFERENCES Course(C_ID) ON DELETE CASCADE,
	FOREIGN KEY (T_ID) REFERENCES Teacher(T_ID))";
//Execute Query
exec_query($query);

//*******************************************

//*********** REQUEST COURSE TABLE *******************

$query = "CREATE TABLE IF NOT EXISTS `request_course` (
	Request_ID INT AUTO_INCREMENT PRIMARY KEY,
	C_ID VARCHAR(10) NOT NULL,
	T_ID VARCHAR(10) NOT NULL,
	Status VARCHAR(10) DEFAULT 'PENDING',
	FOREIGN KEY (C_ID) REFERENCES Course(C_ID) ON DELETE CASCADE,
	FOREIGN KEY (T_ID) REFERENCES Teacher(T_ID))";
//Execute Query
exec_query($query);

//*******************************************

//*********** COURSE REGISTERED TABLE *******************

$query = "CREATE TABLE IF NOT EXISTS `course_registered` (
	S_ID VARCHAR(10),
	Sec_ID VARCHAR(10),
	Grade VARCHAR(10),
	Semester VARCHAR(10), 
	FOREIGN KEY (S_ID) REFERENCES Student(S_ID),
	FOREIGN KEY (Sec_ID) REFERENCES course_sec(Sec_ID) ON DELETE CASCADE )";
//Execute Query
exec_query($query);

//*******************************************

//*********** TEACHER COMPLAINTS TABLE *******************

$query = "CREATE TABLE IF NOT EXISTS `teacher_complaints` (
	Complaint_ID INT AUTO_INCREMENT PRIMARY KEY,
	T_ID VARCHAR(10) NOT NULL,
	Message VARCHAR(500) NOT NULL,
	Admin_reply VARCHAR(500) DEFAULT 'PENDING',
	FOREIGN KEY (T_ID) REFERENCES Teacher(T_ID))";
//Execute Query
exec_query($query);

//*******************************************

//*********** STUDENT COMPLAINTS TABLE *******************

$query = "CREATE TABLE IF NOT EXISTS `student_complaints` (
	Complaint_ID INT AUTO_INCREMENT PRIMARY KEY,
	S_ID VARCHAR(10),
	Message VARCHAR(500),
	Admin_reply VARCHAR(500) DEFAULT 'PENDING',
	FOREIGN KEY (S_ID) REFERENCES Student(S_ID))";
//Execute Query
exec_query($query);

//*******************************************

//*********** TEACHER LEAVE TABLE *******************

$query = "CREATE TABLE IF NOT EXISTS `Leave` (
	Leave_ID INT AUTO_INCREMENT PRIMARY KEY,
	T_ID VARCHAR(10) NOT NULL, 
	Days VARCHAR(10) NOT NULL,
	Reason VARCHAR(500),
	Status VARCHAR(10)  DEFAULT 'PENDING',
	FOREIGN KEY (T_ID) REFERENCES Teacher(T_ID))";
//Execute Query
exec_query($query);

//*******************************************

//*********** INTERNSHIP TABLE *******************

$query = "CREATE TABLE IF NOT EXISTS `Internship` (
	I_ID VARCHAR(10) PRIMARY KEY,
	Title VARCHAR(100), 
	Location VARCHAR(50),
	Duration VARCHAR(20),
	isPaid VARCHAR(5))";
//Execute Query
exec_query($query);

//*******************************************

//*********** APPLY INTERNSHIP TABLE *******************

$query = "CREATE TABLE IF NOT EXISTS `apply_internship` (
	Application_ID INT AUTO_INCREMENT PRIMARY KEY,
	S_ID VARCHAR(10) NOT NULL,
	I_ID VARCHAR(10) NOT NULL,
	Status VARCHAR(10)  DEFAULT 'PENDING',
	FOREIGN KEY (S_ID) REFERENCES Student(S_ID), 
	FOREIGN KEY (I_ID) REFERENCES Internship(I_ID))";
//Execute Query
exec_query($query);

//*******************************************

//*********** FEE DETAIL TABLE *******************

$query = "CREATE TABLE IF NOT EXISTS `fee_detail` (
	S_ID VARCHAR(10), 
	TotalFee FLOAT(5),
	RemainingFee FLOAT(5),
	PaidFee FLOAT(5),
	Semester VARCHAR(10),
	FOREIGN KEY (S_ID) REFERENCES Student(S_ID))";
//Execute Query
exec_query($query);

//*******************************************
//*************** WITHDRAW COURSE TABLE ***************

$query = "CREATE TABLE IF NOT EXISTS `withdraw_course` (
	W_ID INT AUTO_INCREMENT PRIMARY KEY,
	S_ID VARCHAR(10),
	Sec_ID VARCHAR(10),
	Reason VARCHAR(500),
	Status VARCHAR(10) DEFAULT 'PENDING',
	FOREIGN KEY (S_ID) REFERENCES Student(S_ID),
	FOREIGN KEY (Sec_ID) REFERENCES course_sec(Sec_ID))";
//Execute Query
exec_query($query);

// ******************* ADDING DEFAULT USERS *********************************


//UserID = A-101
//Pasw = admin
$query = "SELECT UserID FROM login WHERE UserID = 'A-101'";
if(exec_query($query)){


	$query = "INSERT INTO login (UserID, Pasw, account_type, Is_Block) 
			VALUES ('A-101', 'admin', 1 , 'NO')";

	//Execute Query
	exec_query($query);

	$query = "INSERT INTO Admin (A_ID, Name, Contact, Email, Address) 
			VALUES ('A-101', 'Muneeb Amer', '+92 3124220350', 'muneebamer98@gmail.com','B-24 SukhChayn Gardens, Lahore')";

	//Execute Query
	exec_query($query);
}

//UserID = S-101
//Pasw = student
$query = "SELECT UserID FROM login WHERE UserID = 'S-101'";
if(exec_query($query)){

	$query = "INSERT INTO login (UserID, Pasw, account_type, Is_Block) 
			VALUES ('S-101', 'student', 2 , 'NO')";

	//Execute Query
	exec_query($query);

	$query = "INSERT INTO Student (S_ID, Name, Contact, Email, Address, Major, Gender,Semester,Grad_year) 
			VALUES ('S-101', 'Maham Jamil', '+92 21325161', 'maham@gmail.com','Allama Iqbal Town, Lahore','Computer Science','Female',7,'2021')";

	//Execute Query
	exec_query($query);
}

//BLOCKED USER
//UserID = S-102
//Pasw = iamblocked

$query = "SELECT UserID FROM login WHERE UserID = 'S-102'";
if(exec_query($query)){

	$query = "INSERT INTO login (UserID, Pasw, account_type, Is_Block) 
			VALUES ('S-102', 'iamblocked', 2 , 'YES')";

	//Execute Query
	exec_query($query);

	$query = "INSERT INTO Student (S_ID, Name, Contact, Email, Address, Major, Gender, Semester,Grad_year) 
			VALUES ('S-102', 'Jon Doe', '+92 21325161', 'jon@doe.com','California','Computer Science','Male',4,'2021')";

	//Execute Query
	exec_query($query);
}
//UserID = T-101
//Pasw = teacher

$query = "SELECT UserID FROM login WHERE UserID = 'T-101'";
if(exec_query($query)){

	$query = "INSERT INTO login (UserID, Pasw, account_type, Is_Block) 
			VALUES ('T-101', 'teacher', 3 , 'NO')";

	//Execute Query
	exec_query($query);

	$query = "INSERT INTO Teacher (T_ID, Name, Contact, Email, Address, Dept, Gender, Salary) 
			VALUES ('T-101', 'Mohid Ali Gill', '+923328464176', 'mohid@mmm.com','Askari 11, Lahore','Computer Science','Male', 90000)";

	//Execute Query
	exec_query($query);
}
$query = "SELECT UserID FROM login WHERE UserID = 'T-102'";
if(exec_query($query)){

	$query = "INSERT INTO login (UserID, Pasw, account_type, Is_Block) 
			VALUES ('T-102', 'teacher', 3 , 'NO')";

	//Execute Query
	exec_query($query);

	$query = "INSERT INTO Teacher (T_ID, Name, Contact, Email, Address, Dept, Gender, Salary) 
			VALUES ('T-102', 'Jon Snow', '+92 2132543', 'john@gmail.com','Bahria Town, Lahore','Economice','Male', 50000)";

	//Execute Query
	exec_query($query);
}
$query = "SELECT UserID FROM login WHERE UserID = 'T-103'";
if(exec_query($query)){

	$query = "INSERT INTO login (UserID, Pasw, account_type, Is_Block) 
			VALUES ('T-103', 'teacher', 3 , 'YES')";

	//Execute Query
	exec_query($query);

	$query = "INSERT INTO Teacher (T_ID, Name, Contact, Email, Address, Dept, Gender, Salary) 
			VALUES ('T-103', 'Saad Saleem', '+92 8967569', 'saad@gmail.com','Thokar Niaz Baig','Computer Science','Male', 75000)";

	//Execute Query
	exec_query($query);
}

/*
$query = "INSERT INTO Course 
			VALUES ('C-01','Web App',3,'CS','C-00','Learn web development')";

	//Execute Query
	exec_query($query);


$query = "INSERT INTO course_sec 
			VALUES ('C-01-A','C-01','T-101',30,30,'S303','MWF','10')";

	//Execute Query
	exec_query($query);

$query = "INSERT INTO course_registered(S_ID,Sec_ID) 
			VALUES ('S-101','C-01-A')";

	//Execute Query
	exec_query($query);

$query = "INSERT INTO withdraw_course(S_ID,Sec_ID,Reason) 
			VALUES ('S-101','C-01-A','Baon Aukha Ae Janab')";

	//Execute Query
	exec_query($query);
*/
// *******************************************************************************

?>