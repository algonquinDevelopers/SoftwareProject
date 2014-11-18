<?php

// Connect to the MySQL database
include("connect.php");


$sql = "SELECT DISTINCT student.student_name, student_enrollment.grade from student 
		INNER JOIN `student_enrollment` on student_enrollment.student_no = student.student_no 
		WHERE student_enrollment.a_level = 'A2' or student_enrollment.a_level = 'A3'
		LIMIT 300";



$result = mysqli_query($db, $sql);


$rows = array();
while($r = mysqli_fetch_array($result)) {
    array_push($rows, $r);
}

// close connection
header('Content-type: application/json');
echo json_encode($rows); 

?>


