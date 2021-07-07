<?php
//******* DB INFO **********

$host="localhost";
$username="root";
$passwrd="";
$db = "university_db";

//**************************

//Creating Connection (Procedural)
$conn= mysqli_connect($host,$username,$passwrd,"");

//Check Connection
if(!$conn){

	die("Connection Failed: ". mysqli_connect_error() ); //Connection Error
}

?>