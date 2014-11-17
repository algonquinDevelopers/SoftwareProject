<?php

// Connect to the MySQL database
include("connect.php");


//$sql = "SELECT courseName, courseCode, courseLevel FROM course WHERE courseLevel = 2";//for fat table
//$sql = "select course_name, course_no, course_level from course where course_level = 02";//for new database

if (!empty($_GET['name']) || $_GET['name'] == ""){
	$program = $_GET['name'];
	$sql = "select c.course_name, c.course_no, c.course_level
			from course c, program p, program_course a
			where c.course_no = a.course_no
			and p.program_no = a.program_no
			and p.program_name = '$program'
			order by c.course_level";
}

$result = mysqli_query($db,$sql);

$rows = array();
while($r = mysqli_fetch_array($result)) {
	    array_push($rows, $r);
    }

// CLOSE CONNECTION
	header('Content-type: application/json');
	echo json_encode($rows); 
?>
