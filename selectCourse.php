<?php

// Connect to the MySQL database
include("connectNewDb.php");

$level = $_GET['level'];

if (!empty($_GET['level'])){
	$level = 6;
}

$sql = "SELECT course_name, course_no, course_level FROM course";

$result = mysqli_query($db,$sql);

$rows = array();
while($r = mysqli_fetch_array($result)) {
	    array_push($rows, $r);
    }

// CLOSE CONNECTION
	header('Content-type: application/json');
	echo json_encode($rows); 
?>
