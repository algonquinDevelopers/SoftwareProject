<?php

// Connect to the MySQL database
include("connect.php");

$level = $_GET['courseLevel'];

$sql = "SELECT course_name, course_no, course_level FROM course WHERE course_level = 6";

$result = mysqli_query($db,$sql);

$rows = array();
while($r = mysqli_fetch_array($result)) {
	    array_push($rows, $r);
    }

// CLOSE CONNECTION
	header('Content-type: application/json');
	echo json_encode($rows); 
?>
