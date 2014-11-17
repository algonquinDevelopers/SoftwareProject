<?php

// Connect to the MySQL database
include("connect.php");

$level = $_GET['courseLevel'];

if (empty($_GET['course_Level'])){
	$level = 6;
}

$sql = "SELECT course_name, course_no, course_level FROM course WHERE course_level = $level AND course_level IS NOT NULL";

$result = mysqli_query($db,$sql);

$rows = array();
while($r = mysqli_fetch_array($result)) {
	    array_push($rows, $r);
    }

// CLOSE CONNECTION
	header('Content-type: application/json');
	echo json_encode($rows); 
?>
