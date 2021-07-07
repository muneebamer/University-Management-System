<?php include_once('database.php');?>

<?php
insert("",array('S-103','Usama Akhtar','+92 31252652','usama@mmm.com','Bahria Town, Lahore','History','Male',2,2023),'student');
insert("",array('S-103','usama123',2,'NO'),'login');
insert("",array('S-104','Jazlan Shakeel','+92 31242252','jazzy@hothot.com','DHA Phase 1, Lahore','Media Studies','Male',4,2022),'student');
insert("",array('S-104','jazzyhothot',2,'NO'),'login');
insert("",array('S-105','Ahsan Asghar','+92 32115132','ahsan@mmm.com','Shahdara, Lahore','Computer Science','Male',8,2020),'student');
insert("",array('S-105','tomandjerry',2,'NO'),'login');
insert("",array('T-104','Shaaf Imran','+92 33363623','shaaf@mmm.com','DHA Phase 6, Lahore','History','Male',90000),'teacher');
insert("",array('T-104','shaaflin',3,'NO'),'login');
insert("",array('T-105','Saba Toor','+92 347552323','saba@mmm.com','Phulon Wala Dera, Chichawatni','History','Female',100000),'teacher');
insert("",array('T-105','chichawatni',3,'NO'),'login');
insert(array('S_ID','Message'),array('S-101','The fan in room M-32 is broken.'),'student_complaints');
insert(array('S_ID','Message'),array('S-103','The wifi of history department is not working.'),'student_complaints');
insert("",array('CSCS100','Introduction to Computer Science',3,'Computer Science','None','You will learn the basics of computer science'),'course');
insert("",array('COMP102','Programming 1',3,'Computer Science','CSCS100','Learn basic programming skills i.e: loops,conditional statements, strings, etc. in python'),'course');
insert("",array('HIST100','Introduction to History',3,'History','None','This is an introduction level history course in which you will learn about british history.'),'course');
insert("",array('PSYC100','Introduction to Psychology',3,'Psychology','None','You will learn the basics of Psychology how our brain thinks and what decisions can we control.'),'course');
insert("",array('CSCS342','Web Development',3,'Computer Science','COMP102','You will learn the basics of web development. We will be working on html,css,bootstrap,javascript,jquery,php this is all in one course you will be able to develop your own app at the end of the course.'),'course');
insert("",array('I-01','AWS Cloud Engineer','CNS Engineering, Lahore','3 Months','YES'),'internship');
insert("",array('I-02','3D Designer','WebAxis 3D, Lahore','1 Month','NO'),'internship');
insert("",array('I-03','Web Developer','Obridge, Islamabad','2 Months','YES'),'internship');
insert("",array('I-04','Sales Representative','NESTLE, Peshawar','1 Month','YES'),'internship');
insert("",array('S-101',160000,40000,120000,'4'),'fee_detail');
insert("",array('S-102',155000,0,155000,'4'),'fee_detail');
insert("",array('S-103',80000,45000,35000,'2'),'fee_detail');
insert("",array('S-104',95000,90000,5000,'4'),'fee_detail');
insert("",array('S-105',100000,40000,60000,'8'),'fee_detail');
echo "DATA ENTERED SUCCESSFULLY.<br> Go back to main page";

?>
