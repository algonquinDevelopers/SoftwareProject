<?php

// Connect to the MySQL database
include("connectNewDb.php");

$limit = $_GET['limit'];
// $sql = "";



//$sql = mysqli_query($db, "SELECT DISTINCT studentName, studentNumber from studentStats where aLevel = 'A1' LIMIT $limit");

if (!empty($_GET['name'])){
	$programName = $_GET['name'];
	//echo $programName;
	$sql = "SELECT DISTINCT student_name, student_no from student LIMIT $limit";
	//echo $sql;
} else {
	$sql = "SELECT DISTINCT student.student_name, student.student_no from student 
			INNER JOIN `student_enrollment` on student_enrollment.student_no = student.student_no 
			LIMIT 300";
}

$result = mysqli_query($db, $sql);


$rows = array();
while($r = mysqli_fetch_array($result)) {
    array_push($rows, $r);
}

// close connection
header('Content-type: application/json');
echo json_encode($rows); 

?>


