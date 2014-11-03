<?php

// Connect to the MySQL database
include("connect.php");

$limit = $_GET['limit'];

if (!empty($_GET['name'])){
	$programName = $_GET['name'];
	//echo($programName);
	$sql = "select distinct s.student_name, s.student_no from student s, program p where s.program_no = p.program_no and p.program_name = '$programName' LIMIT $limit";
	
	//for fat table
	//$sql = "select distinct studentName, studentNumber from studentstats where pgmName = '$programName' LIMIT $limit";
	
	//echo($sql);
} else {
	$sql = "SELECT DISTINCT student_name, student_no from student LIMIT $limit";
	
	//for fat table
	//$sql = "select distinct studentName, studentNumber from studentstats LIMIT $limit";
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


